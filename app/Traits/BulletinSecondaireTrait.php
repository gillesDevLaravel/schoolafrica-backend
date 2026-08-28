<?php

namespace App\Traits;

use App\Models\Absence;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Rating;
use App\Models\Trimestre;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

trait BulletinSecondaireTrait{

    public function getNoteEvaluation($idClasse, $idSequences){
        // Récupérer les pourcentages des types d'évaluation fournis
        $seqPourcentages = AssessmentType::whereIn('id', $idSequences)
            ->pluck('pourcentage', 'id')
            ->toArray();

        // Construction dynamique des colonnes pour chaque séquence (valeur brute)
        $sequenceColumns = [];
        foreach ($idSequences as $idSequence) {
            $sequenceColumns[] = DB::raw("SUM(CASE WHEN ratings.idAssessmentType = $idSequence THEN ratings.value ELSE NULL END) as sequence$idSequence");
        }

        // Colonne pour compter le nombre de séquences évaluées
        $sequenceCountColumn = DB::raw('COUNT(DISTINCT CASE WHEN ratings.value IS NOT NULL THEN ratings.idAssessmentType END) as nbrSeqEval');

        // Colonnes pour la somme pondérée (value * pourcentage) et la somme des pourcentages présents
        $weightedSumColumn = DB::raw('SUM(ratings.value * COALESCE(assessment_type.pourcentage, 0)) as weighted_sum');
        $sumPctColumn = DB::raw('SUM(COALESCE(assessment_type.pourcentage, 0)) as total_pourcentage_present');

        // Requête principale avec calcul du rang sur la somme pondérée
        $notesSequences = Rating::select(
            'ratings.idStudent',
            'assessments.idMatter',
            'matter.name as nomMatiere',
            'assessments.id as idEvaluation',
            $weightedSumColumn,
            $sumPctColumn,
            $sequenceCountColumn,
            DB::raw('RANK() OVER (PARTITION BY assessments.idMatter ORDER BY SUM(ratings.value * COALESCE(assessment_type.pourcentage,0)) DESC) as rang'),
            ...$sequenceColumns
        )
            ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
            ->join('matter', 'matter.id', '=', 'assessments.idMatter')
            ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
            ->whereIn('ratings.idAssessmentType', $idSequences)
            ->where('assessments.deleted', 0)
            ->where('assessments.idClasse', $idClasse)
            ->groupBy('ratings.idStudent', 'assessments.idMatter', 'assessments.id', 'matter.name')
            ->get();

        //Tableau associatif pour faciliter les recherches
        $notes = [];

        foreach($notesSequences as $note){
            // Normaliser la somme pondérée si nécessaire : si certaines séquences manquent, on remet à l'échelle
            $trimestre = null;
            $totalPct = isset($note->total_pourcentage_present) ? (float) $note->total_pourcentage_present : 0;
            $weightedSum = isset($note->weighted_sum) ? (float) $note->weighted_sum : 0;

            if ($totalPct > 0) {
                // Normaliser pour obtenir la moyenne pondérée : somme(value * poids) / somme(poids)
                // Les poids (pourcentage) sont utilisés tels quels (ex : 40, 60). La formule correcte est weightedSum / totalPct.
                $trimestre = $weightedSum / $totalPct;
            }

            // Préparer l'objet retourné (on conserve les colonnes sequenceX et nbrSeqEval)
            $note->trimestre = $trimestre;
            // garder nbrSeqEval comme auparavant
            $notes[$note->idStudent][$note->idMatter] = $note;
            unset($note['idStudent']);
        }

        return $notes;
    }

    public function getMatiereEvalueesParGroupe($idClasse){

        // Récupération des groupes de matière et des évaluations
        $evaluations = Assessment::select(
            "matter_group.id as idGroupMat",        // Identifiant du groupe de matière
            "matter_group.name as nomGroupMat",    // Nom du groupe de matière
            "matter_group.description as descGroupMat",    // Description du groupe de matière
            "matter.id as idMat",                  // Identifiant de la matière
            "matter.name as nomMat",               // Nom de la matière
            "matter.code",               // Nom de la matière
            "assessments.id as idEval",            // Identifiant de l'évaluation
            "users.name as nomEnseignant",           // Nom de l'enseignant
            "coefficients.value as coef"           // Coefficient
        )
            ->distinct("matter_group.id")              // Supprime les doublons sur les groupes de matières
            ->leftJoin("users", "users.id", "=", "assessments.idTeacher") // Utilisation de leftJoin
            ->join("matter_group_has_matter", "matter_group_has_matter.matter_id", "=", "assessments.idMatter")
            ->join("matter_group", "matter_group.id", "=", "matter_group_has_matter.matter_group_id")
            ->join("matter", "matter.id", "=", "matter_group_has_matter.matter_id")
            ->join("coefficients", "coefficients.id", "=", "assessments.idCoeficient")
            ->where("assessments.idClasse", $idClasse)
            ->get();

        // Filtrer les colonnes pour les groupes de matière
        $conserveClesEval = ["idGroupMat", "nomGroupMat", "descGroupMat", "idMat", "nomMat", "code", "nomEnseignant", "idEval", "coef"];

        //on supprime les attributs qui ne sont pas necessaire pour alleger l'objet
        $evaluations = $evaluations->map(function ($item) use ($conserveClesEval) {
            return collect($item)->only($conserveClesEval); // Conserve uniquement les clés spécifiées
        });

        return  $evaluations;
    }


    //Une fonction qui liste les élèves avec les différents evaluations
    public function getEvaluationEleve($idSequences, $idClasse, $isPv = false, $idStudent = null){
        //On récupère l'élève en BD avec toutes les informations nécessaires pour le bulletin
        $eleves = User::select(
            'users.id','users.name as nom', "classes.name as nomClasse",
            "users.gender as sexe", "users.repeater as redoublan",
            "users.matricule", "users.birthday as dateNaiss",
            "users.situation", "users.placeofbirth as lieuNaiss", 'users.photo')
            ->join('classes','classes.id','=','users.idClasse')
            ->where('users.idClasse', $idClasse)
            ->where('classes.deleted',0)
            ->where('users.deleted',0)
            ->when($idStudent, function ($query) use ($idStudent){
                $query->where('users.id', $idStudent);
            })
            ->get();

        //On recupere les différentes matiere contenant idMatiere et idGroupeMatiere
        //Ce qui nous permettra de classifier les notes de l'élève par groupe de matiere
        $groupeMatiereEvaluees = $this->getMatiereEvalueesParGroupe($idClasse);

        //On récupere toutes les notes de la classe avec id des matieres pour faciliter le regroupement par groupe
        $noteMatiereEvaluees = $this->getNoteEvaluation($idClasse, $idSequences);

        //Regroupement
        $groupeMatiereEvalueeParEleve = [];

        foreach ($eleves as $eleve) {
            // Convertir l'objet $eleve en tableau
            $eleveArray = $eleve->toArray();

            // Initialiser les données de l'élève dans le regroupement
            $groupeMatiereEvalueeParEleve[$eleveArray["id"]] = $eleveArray;

            foreach ($groupeMatiereEvaluees as $groupeMatiereEvaluee) {

                //On verifi que l'élève a été évalué sur la matiere
                if (isset($noteMatiereEvaluees[$eleveArray['id']][$groupeMatiereEvaluee['idMat']])) {
                    $groupeMatiereEvalueeParEleve[$eleveArray["id"]][$groupeMatiereEvaluee['idGroupMat']][$groupeMatiereEvaluee['idMat']] =
                        $noteMatiereEvaluees[$eleveArray['id']][$groupeMatiereEvaluee['idMat']];

                    $groupeMatiereEvalueeParEleve[$eleveArray["id"]][$groupeMatiereEvaluee['idGroupMat']][$groupeMatiereEvaluee['idMat']]['nomEnseignant'] =
                        $groupeMatiereEvaluee['nomEnseignant'];

                    $groupeMatiereEvalueeParEleve[$eleveArray["id"]][$groupeMatiereEvaluee['idGroupMat']][$groupeMatiereEvaluee['idMat']]['coef'] =
                        $groupeMatiereEvaluee['coef'];
                }
            }
        }


        //return  collect($users)->sortByDesc('moyenneTotale')->values();
        return  $groupeMatiereEvalueeParEleve;
    }


    //Calcule les notes totales de chaque élève
    public function calculeNotesTotales($eleves, $idClasse, $sequences, $typeBulletin = 'annuel', $trimestres = [], $allSequences = [], $semestres = [])
    {
        $groupeMatieres = $this->getMatiereEvalueesParGroupe($idClasse);
        $idGroupMats    = [];
        $matieres       = $groupeMatieres;

        foreach ($groupeMatieres as $gm) {
            $idGroupMats[$gm['idGroupMat']] = $gm;
        }

        $moyennes        = [];
        $moyennesNonEval = [];

        // Normalisation des poids des séquences
        $seqPourcentages = AssessmentType::whereIn('id', $sequences)->pluck('pourcentage', 'id')->toArray();
        $seqFractions    = [];
        $maxPct          = $seqPourcentages ? max($seqPourcentages) : 0;
        foreach ($seqPourcentages as $id => $pct) {
            $seqFractions[$id] = ($maxPct > 1) ? $pct / 100 : ($pct ?? 0);
        }

        foreach ($eleves as $eleveId => $eleve) {
            // Initialisation des champs dynamiques
            foreach ($sequences as $seq) {
                $eleves[$eleveId]["sequence$seq"]      = null;
                $eleves[$eleveId]["noteCoefSeq$seq"]   = null;
                $eleves[$eleveId]["coefSeq$seq"]       = null;
                $eleves[$eleveId]["isEvalueSeq$seq"]   = false;
                $eleves[$eleveId]["moyenneSeq$seq"]    = null;
            }

            $eleves[$eleveId]['trimestre']         = [];
            $eleves[$eleveId]['trimestreWeights']  = [];
            $eleves[$eleveId]['totalNoteCoef']     = [];
            $eleves[$eleveId]['totalCoef']         = [];
            $eleves[$eleveId]['isEvalue']          = false;

            // --- 1. Calcul par groupe de matières ---
            foreach ($idGroupMats as $groupId => $group) {
                $totalNoteCoefGroup = 0;
                $totalCoefGroup     = 0;
                $trimestreGroup     = 0;

                foreach ($eleves[$eleveId][$groupId] ?? [] as $matKey => $matiere) {
                    if (!is_object($matiere) && !is_array($matiere)) {
                        continue;
                    }

                    // Séquences
                    foreach ($sequences as $seq) {
                        if (!is_null($matiere["sequence$seq"] ?? null)) {
                            $note = $matiere["sequence$seq"];
                            $coef = $matiere['coef'] ?? 0;

                            $eleves[$eleveId]["sequence$seq"]       = ($eleves[$eleveId]["sequence$seq"] ?? 0) + $note;
                            $eleves[$eleveId]["noteCoefSeq$seq"]    = ($eleves[$eleveId]["noteCoefSeq$seq"] ?? 0) + $note * $coef;
                            $eleves[$eleveId]["coefSeq$seq"]        = ($eleves[$eleveId]["coefSeq$seq"] ?? 0) + $coef;
                        }
                    }

                    // Écoles par semestre : la moyenne annuelle de la matière est recalculée
                    // comme la moyenne de ses semestres (chaque semestre = moyenne de ses
                    // trimestres, chaque trimestre = moyenne pondérée de ses séquences).
                    // Ainsi la colonne ANN, le TOTAL et la MG restent cohérents avec les colonnes semestre.
                    if ($typeBulletin === 'annuel' && !empty($semestres)) {
                        $totSemMat = 0;
                        $nbSemMat  = 0;
                        foreach ($semestres as $sem) {
                            $totTrimMat = 0;
                            $nbTrimMat  = 0;
                            foreach ($sem['trimestreIds'] ?? [] as $tid) {
                                $sT = 0; $pT = 0; $hasT = false;
                                foreach ($allSequences as $s) {
                                    if (($s['idTrimestre'] ?? null) == $tid) {
                                        $sid = $s['id'];
                                        $val = $matiere["sequence$sid"] ?? null;
                                        if (!is_null($val)) {
                                            $w = $seqFractions[$sid] ?? 0;
                                            $sT += $val * $w;
                                            $pT += $w;
                                            $hasT = true;
                                        }
                                    }
                                }
                                if ($hasT && $pT > 0) { $totTrimMat += $sT / $pT; $nbTrimMat++; }
                            }
                            if ($nbTrimMat > 0) { $totSemMat += $totTrimMat / $nbTrimMat; $nbSemMat++; }
                        }
                        $newTrimMat = $nbSemMat > 0 ? $totSemMat / $nbSemMat : null;
                        $matiere['trimestre'] = $newTrimMat;
                        $eleves[$eleveId][$groupId][$matKey]['trimestre'] = $newTrimMat;
                    }

                    // Trimestre (déjà pondéré dans getNoteEvaluation)
                    if (!is_null($matiere['trimestre'] ?? null)) {
                        $totalNoteCoefGroup += $matiere['trimestre'] * ($matiere['coef'] ?? 0);
                        $totalCoefGroup     += $matiere['coef'] ?? 0;
                        $trimestreGroup     += $matiere['trimestre'];
                    }
                }

                if ($totalCoefGroup > 0) {
                    $eleves[$eleveId][$groupId]['totalNoteCoef'] = $totalNoteCoefGroup;
                    $eleves[$eleveId][$groupId]['totalCoef']     = $totalCoefGroup;
                    $eleves[$eleveId][$groupId]['trimestre']     = $trimestreGroup;
                    $eleves[$eleveId][$groupId]['moyenne']       = $totalNoteCoefGroup / $totalCoefGroup;
                }
            }

            // --- 2. Moyennes séquentielles ---
            foreach ($sequences as $seq) {
                if (!empty($eleves[$eleveId]["coefSeq$seq"])) {
                    $eleves[$eleveId]["moyenneSeq$seq"] = $eleves[$eleveId]["noteCoefSeq$seq"] / $eleves[$eleveId]["coefSeq$seq"];
                    $eleves[$eleveId]["isEvalueSeq$seq"] = true;
                }
            }

            // --- 3. Moyenne du trimestre (ou du semestre si on est en mode semestre) ---
            if ($typeBulletin === 'semestre' && !empty($trimestres)) {
                // For semester, calculate per trimester averages first
                $trimestreMoyennes = [];
                foreach ($trimestres as $trim) {
                    $trimId = $trim['id'];
                    $seqsForTrim = array_filter($allSequences, function($s) use ($trimId) { return $s['idTrimestre'] == $trimId; });
                    $somme = 0;
                    $totalWeight = 0;
                    foreach ($seqsForTrim as $seq) {
                        $seqId = $seq['id'];
                        if ($eleves[$eleveId]["isEvalueSeq$seqId"]) {
                            $eleves[$eleveId]['isEvalue'] = true;
                            $weight = $seqFractions[$seqId] ?? 0;
                            $somme += $eleves[$eleveId]["moyenneSeq$seqId"] * $weight;
                            $totalWeight += $weight;
                        }
                    }
                    if ($totalWeight > 0) {
                        $trimestreMoyennes[$trimId] = $somme / $totalWeight;
                        $eleves[$eleveId]["moyenne_trimestre_$trimId"] = $trimestreMoyennes[$trimId];
                    }
                }

                // Then calculate semester moyenne as weighted average of trimester moyennes
                $sommePonderee = 0;
                $totalPoids = 0;
                foreach ($trimestres as $trim) {
                    $poids = $trim['pourcentage'] ?? 50;
                    $poids = $poids > 1 ? $poids / 100 : $poids; // normalisation
                    if (isset($trimestreMoyennes[$trim['id']])) {
                        $sommePonderee += $trimestreMoyennes[$trim['id']] * $poids;
                        $totalPoids += $poids;
                    }
                }
                if ($totalPoids > 0) {
                    $eleves[$eleveId]['moyenne'] = $sommePonderee / $totalPoids;
                    $eleves[$eleveId]['semestre'] = $eleves[$eleveId]['moyenne'];
                    $eleves[$eleveId]['trimestre'] = $eleves[$eleveId]['moyenne'];
                }
            } else {
                // For other types (trimestre, annuel, sequence)
                
                // Calcul des moyennes trimestrielles pour annuel et trimestriel
                $trimestreMoyennes = [];
                if ($typeBulletin === 'annuel' && !empty($trimestres)) {
                    foreach ($trimestres as $trim) {
                        $trimId = $trim['id'];
                        $seqsForTrim = array_filter($allSequences, function($s) use ($trimId) { return $s['idTrimestre'] == $trimId; });
                        $somme = 0;
                        $totalWeight = 0;
                        foreach ($seqsForTrim as $seq) {
                            $seqId = $seq['id'];
                            if ($eleves[$eleveId]["isEvalueSeq$seqId"]) {
                                $eleves[$eleveId]['isEvalue'] = true;
                                $weight = $seqFractions[$seqId] ?? 0;
                                $somme += $eleves[$eleveId]["moyenneSeq$seqId"] * $weight;
                                $totalWeight += $weight;
                            }
                        }
                        if ($totalWeight > 0) {
                            $trimestreMoyennes[$trimId] = $somme / $totalWeight;
                            $eleves[$eleveId]["moyenne_trimestre_$trimId"] = $trimestreMoyennes[$trimId];
                        }
                    }
                }

                // Calcul de la moyenne générale (annuelle ou trimestrielle)
                if ($typeBulletin === 'annuel') {
                    if (!empty($semestres)) {
                        // Écoles par semestre : moyenne annuelle = moyenne des moyennes de
                        // semestre, chaque semestre = moyenne de ses trimestres (poids égal).
                        $sommeSemestres = 0;
                        $nbSemestres    = 0;
                        foreach ($semestres as $sem) {
                            $totTrim = 0;
                            $nbTrim  = 0;
                            foreach ($sem['trimestreIds'] ?? [] as $tid) {
                                if (isset($trimestreMoyennes[$tid])) {
                                    $totTrim += $trimestreMoyennes[$tid];
                                    $nbTrim++;
                                }
                            }
                            if ($nbTrim > 0) {
                                $moySem = $totTrim / $nbTrim;
                                $eleves[$eleveId]["moyenne_semestre_{$sem['id']}"] = $moySem;
                                $sommeSemestres += $moySem;
                                $nbSemestres++;
                            }
                        }
                        if ($nbSemestres > 0) {
                            $eleves[$eleveId]['moyenne']   = $sommeSemestres / $nbSemestres;
                            $eleves[$eleveId]['trimestre'] = $eleves[$eleveId]['moyenne'];
                        }
                    } else {
                        // Moyenne annuelle = moyenne des trimestres
                        $totalWeight = 0;
                        $sommePonderee = 0;
                        foreach ($trimestres as $trim) {
                            if (isset($trimestreMoyennes[$trim['id']])) {
                                $poids = 1 / count($trimestres);
                                $sommePonderee += $trimestreMoyennes[$trim['id']] * $poids;
                                $totalWeight += $poids;
                            }
                        }
                        if ($totalWeight > 0) {
                            $eleves[$eleveId]['moyenne'] = $sommePonderee / $totalWeight;
                            $eleves[$eleveId]['trimestre'] = $eleves[$eleveId]['moyenne'];
                        }
                    }
                } else {
                    // Pour séquence simple ou trimestriel
                    $currentTrimestreId = null;
                    if (!empty($allSequences)) {
                        $currentTrimestreId = $allSequences[0]['idTrimestre'] ?? null;
                    }

                    foreach ($sequences as $seq) {
                        if ($eleves[$eleveId]["isEvalueSeq$seq"]) {
                            $eleves[$eleveId]['isEvalue'] = true;

                            $weight = $seqFractions[$seq] ?? (count($sequences) > 0 ? 1 / count($sequences) : 0);
                            $moySeq = $eleves[$eleveId]["moyenneSeq$seq"];

                            $eleves[$eleveId]['trimestre'][]        = $moySeq * $weight;
                            $eleves[$eleveId]['trimestreWeights'][] = $weight;
                        }
                    }

                    if ($eleves[$eleveId]['isEvalue']) {
                        $totalWeight = array_sum($eleves[$eleveId]['trimestreWeights']);
                        $moyenneTrimestre = $totalWeight > 0 ? array_sum($eleves[$eleveId]['trimestre']) / $totalWeight : null;

                        // On stocke la moyenne du trimestre courant
                        if ($currentTrimestreId && $typeBulletin === 'trimestre') {
                            $eleves[$eleveId]["moyenne_trimestre_{$currentTrimestreId}"] = $moyenneTrimestre;
                        }

                        $eleves[$eleveId]['trimestre'] = $moyenneTrimestre;
                        $eleves[$eleveId]['moyenne']   = $moyenneTrimestre;
                    }
                }
            }

            if ($eleves[$eleveId]['isEvalue'] && $eleves[$eleveId]['moyenne'] !== null) {
                $moyennes[] = $eleves[$eleveId]['moyenne'];
            }
        }

        $matieres = collect($matieres)->sortBy('code')->values();

        return [
            'eleves'        => $eleves,
            'groupeMatieres'=> $idGroupMats,
            'moyennes'      => $moyennes,
            'moyennesNonEval'=> $moyennesNonEval,
            'matieres'      => $matieres->toArray(),
        ];
    }


    public function genererDocument($filename, $template, $data, $zip){
        $dompdf = new Dompdf();

        // Récupérer la vue
        $view = View::make($template)->with($data);

        // Récupérer le contenu de la vue
        $html = $view->render();

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'portrait');

        // Exécuter le rendu du PDF
        $dompdf->render();

        file_put_contents(public_path("pdfs/$filename.pdf"), $dompdf->output());


        $zip->addFile("pdfs/$filename.pdf");

        return public_path("pdfs/$filename.pdf");
    }

    public function genererDocumentSecondaireAutoScale($filename, $template, $data, $zip, $scale)
    {
        // Dimensions A4 en points
        $baseWidth  = 595.28;
        $baseHeight = 841.89;

        $dompdf = new Dompdf();

        // Construire le HTML
        $html = View::make($template)->with($data)->render();
        $dompdf->loadHtml($html);

        // Appliquer le scale trouvé
        $paperSize = [0, 0, $baseWidth * $scale, $baseHeight * $scale];
        $dompdf->setPaper($paperSize, 'portrait');

        // Générer PDF
        $dompdf->render();

        // Chemin final
        $finalPath = public_path("pdfs/$filename.pdf");

        // Sauvegarde
        file_put_contents($finalPath, $dompdf->output());

        // Ajouter dans ZIP
        $zip->addFile("pdfs/$filename.pdf");

        return $finalPath;
    }



    //Fonction qui permet de recuperer la liste des séquences
    //Si l'utilisateur veut un bulletin trimestriel
    public function getSequences($idClass, $idTrimestre){

        if ($idTrimestre){
            $sequences = AssessmentType::where("idTrimestre", $idTrimestre)
                ->select('id', 'name', 'pourcentage', 'idTrimestre')  // Choisir les colonnes id, name, idTrimestre
                ->get()
                ->toArray();  // Convertir le résultat en tableau
        }
        else{
            $sequences = AssessmentType::select('id', 'name', 'pourcentage', 'idTrimestre')
                ->where('idSection', function ($query) use ($idClass) {
                    $query->select('idSection')
                        ->from('classes')
                        ->where('id', $idClass);
                })
                ->get()
                ->toArray();  // Convertir le résultat en tableau

            //Nom du trimestre
        }
        return $sequences;
    }

    public function pourcentageDeReussiteParMatiere($matieres, $donneesEvaluation) {
        // On passe à travers chaque matière
        foreach ($matieres as $index => &$matiere) {
            // On récupère les notes obtenues pour chaque matière
            // getNoteEvaluation now returns a normalized 'trimestre' (pondéré et remis à l'échelle)
            $notesObt = $donneesEvaluation->map(function ($eleve) use ($matiere) {
                if (isset($eleve[$matiere["idGroupMat"]][$matiere["idMat"]])) {
                    if ($eleve["isEvalue"] && isset($eleve[$matiere["idGroupMat"]][$matiere["idMat"]]["trimestre"]) && !is_null($eleve[$matiere["idGroupMat"]][$matiere["idMat"]]["trimestre"])) {
                        // Utiliser directement la valeur 'trimestre' normalisée
                        return $eleve[$matiere["idGroupMat"]][$matiere["idMat"]]["trimestre"];
                    }
                }
                return null;  // Retourne null si les conditions ne sont pas remplies
            })->filter(function ($value) {
                return !is_null($value);  // Exclut les valeurs nulles
            })->values();

            // Calcul du pourcentage de réussite pour la matière (valeur >= 10)
            $totalEleves = $notesObt->count();  // Nombre d'élèves ayant obtenu une note
            $reussite = $notesObt->filter(function ($note) {
                return $note >= 10;  // Sélectionne les notes >= 10
            })->count();  // Nombre d'élèves ayant réussi

            // Calcul du pourcentage de réussite
            $pourcentageReussite = $totalEleves > 0 ? ($reussite / $totalEleves) * 100 : null;

            // Ajout du pourcentage de réussite à la matière
            $matieres[$index]["pourcentageReussite"] = $pourcentageReussite;

            // Calcul de la moyenne générale de la matière
            $sommeNotes = $notesObt->sum();  // Somme des notes
            $moyenneGenerale = $totalEleves > 0 ? $sommeNotes / $totalEleves : null;  // Moyenne générale

            // Ajout de la moyenne générale à la matière
            $matieres[$index]["moyenneGenerale"] = $moyenneGenerale; // Arrondi à 2 décimales
        }

        return $matieres; // Retourne toutes les matières avec le pourcentage de réussite et la moyenne générale
    }

//    public function getAppreciation($moyenneStudents){
//        $legend_of_grade = [
//            'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                return $moyenneStud < 10;
//            })),
//            'nye_color' => "db0b32",
//            'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                return $moyenneStud >= 10 && $moyenneStud < 15;
//            })),
//            'ae_color' => "fdaa3e",
//            'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                return $moyenneStud >= 15 && $moyenneStud < 18;
//            })),
//            'me_color' => "0080ff",
//            'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
//                return $moyenneStud >= 18;
//            })),
//            'abe_color' => "008000",
//        ];
//
//        return $legend_of_grade;
//    }


    public function getEffectifClasse($idClasse){
        $effectifClass = [];
        //Nbr nouveaux
        $effectifClass["nouveaux"] = 0;
        $effectifClass["nouvelles"] = 0;

        //nbr redoublants
        $effectifClass["redoublants"] = 0;
        $effectifClass["redoublantes"] = 0;

        //nbr redoublants
        $effectifClass["nbrGarcons"] = 0;
        $effectifClass["nbrFilles"] = 0;





        $eleves = User::select('users.id', "classes.name", "users.gender", "users.situation", 'repeater')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('classes.id', $idClasse)
            ->where('users.deleted', 0)
            ->orderBy("users.name")
            ->where('roles.id', 8)->get();


        // Calculer les compteurs
        foreach ($eleves as $eleve) {
            $isFemale = strtolower(substr($eleve->gender, 0, 1)) == 'f';


            if($isFemale){
                $effectifClass["nbrFilles"] ++;
            }
            else{
                $effectifClass["nbrGarcons"] ++;
            }

            if ($eleve->repeater) { // Redoublants
                if ($isFemale) {
                    $effectifClass["redoublantes"] += 1;
                } else {
                    $effectifClass["redoublants"] += 1;
                }
            }

            if ($eleve->situation == "new"){ // Nouveaux
                if ($isFemale) {
                    $effectifClass["nouvelles"] += 1;
                } else {
                    $effectifClass["nouveaux"] += 1;
                }
            }
        }

        return $effectifClass;
    }

    public function calculateOptimalScaleSecondaire($template, $data)
    {
        $scale = 1.00;
        $maxScale = 1.5;
        $increment = 0.03;  // étape initiale plus grosse pour aller plus vite
        $refinementStep = 0.005; // étape fine pour ajustement final

        // Dimensions A4 en points
        $baseWidth  = 595.28;
        $baseHeight = 841.89;

        // Générer le HTML une seule fois
        $html = View::make($template)->with($data)->render();

        do {
            // Dompdf avec options performantes
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', false);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isFontSubsettingEnabled', true);
            $options->set('debugKeepTemp', false);
            $options->set('fontCache', storage_path('fonts'));

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);

            // Appliquer le scale
            $paperSize = [0, 0, $baseWidth * $scale, $baseHeight * $scale];
            $dompdf->setPaper($paperSize, 'portrait');

            // Render du PDF
            $dompdf->render();

            // Nombre de pages
            $pageCount = $dompdf->getCanvas()->get_page_count();

            if ($pageCount > 1) {
                // Step plus fin si proche du max
                $scale += ($scale + $increment > $maxScale) ? $refinementStep : $increment;
            }

        } while ($pageCount > 1 && $scale <= $maxScale);

        return round($scale, 3); // scale final avec 3 décimales
    }

    public function getAbsencesForStudent($idStudent, $sequenceIds = null)
    {
        // Get the date range from the provided sequence IDs
        $dateRange = AssessmentType::selectRaw('MIN(start_date) as min_date, MAX(end_date) as max_date')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date');

        // Filter by provided sequence IDs if available
        if (!empty($sequenceIds)) {
            $dateRange = $dateRange->whereIn('id', $sequenceIds);
        }

        $dateRange = $dateRange->first();

        $minDate = $dateRange->min_date;
        $maxDate = $dateRange->max_date;

        // Get absences using Eloquent relationships
        $absences = Absence::with('course')
            ->where('idStudent', $idStudent)
            ->whereNotNull('date')
            ->whereBetween('date', [$minDate, $maxDate])
            ->get();

        // Calculate minutes using Eloquent relationships
        $justifiedMinutes = $absences->filter(function($absence) {
            return $absence->is_justified === true;
        })->sum(function($absence) {
            return $absence->course ? $absence->course->duration : 0;
        });

        $unjustifiedMinutes = $absences->filter(function($absence) {
            return $absence->is_justified === false || $absence->is_justified === null;
        })->sum(function($absence) {
            return $absence->course ? $absence->course->duration : 0;
        });

        $totalMinutes = $absences->sum(function($absence) {
            return $absence->course ? $absence->course->duration : 0;
        });

        return [
            'justified_minutes'   => (int) $justifiedMinutes,
            'unjustified_minutes' => (int) $unjustifiedMinutes,
            'total_minutes'       => (int) $totalMinutes,

            // conversion minutes -> heures (décimal)
            'justified'     => round($justifiedMinutes / 60, 2),
            'unjustified'   => round($unjustifiedMinutes / 60, 2),
            'total'         => round($totalMinutes / 60, 2),

            // optionnel: format "Xh Ym"
            'justified_hm'        => floor($justifiedMinutes / 60) . 'h ' . ($justifiedMinutes % 60) . 'm',
            'unjustified_hm'      => floor($unjustifiedMinutes / 60) . 'h ' . ($unjustifiedMinutes % 60) . 'm',
            'total_hm'            => floor($totalMinutes / 60) . 'h ' . ($totalMinutes % 60) . 'm',
        ];
    }

    /**
     * Calcule la moyenne annuelle correcte pour un élève (pour décision annuelle)
     * Réutilise la logique de genererBulletinSecondaireSmart
     */
    public function calculateAnnualMoyenneForDecision($idClasse, $idStudent, $idOptionLevel = null)
    {
        // Récupérer tous les trimestres et leurs séquences (logique similaire à genererBulletinSecondaireSmart)
        $sequences = $this->getSequences($idClasse, null);
        
        // Récupérer les trimestres associés
        $trimestres = Trimestre::select('id', 'name', 'numbering')
            ->whereIn('id', AssessmentType::whereIn('id', collect($sequences)->pluck('id')->toArray())
                ->distinct()
                ->pluck('idTrimestre'))
            ->where('takenIntoAccount', 0)
            ->distinct()
            ->get()
            ->toArray();

        $sequenceIds = collect($sequences)->pluck('id')->toArray();

        // Récupérer les évaluations de l'élève
        $evaluationEleves = $this->getEvaluationEleve($sequenceIds, $idClasse, false, $idStudent);

        // Calculer les notes totales avec le type 'annuel'
        $resultats = $this->calculeNotesTotales(
            $evaluationEleves,
            $idClasse,
            $sequenceIds,
            'annuel',
            $trimestres,
            $sequences
        );

        $eleve = $resultats['eleves'][$idStudent] ?? null;

        return $eleve['moyenne'] ?? null;
    }
}


?>
