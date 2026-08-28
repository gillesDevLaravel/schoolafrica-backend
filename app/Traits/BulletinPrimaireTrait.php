<?php

namespace App\Traits;

use App\Models\AssessmentHasAssessmentType;
use App\Models\AssessmentHasTypeEvaluation;
use App\Models\AssessmentType;
use App\Models\MatterGroup;
use App\Models\Assessment;
use App\Models\Classes;
use App\Models\Matter;
use App\Models\Rating;
use App\Models\School;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use Dompdf\Dompdf;

use FontLib\Table\Type\name;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mockery\Exception;
use setasign\Fpdi\Fpdi;
use function PHPUnit\Framework\isEmpty;

trait BulletinPrimaireTrait
{
    public function getNoteEvaluation($idClasse, $idSequences, $idOptionNiveau=null, $idStudent=null){
        // Construction dynamique des colonnes pour chaque séquence
        $sequenceColumns = [];
        foreach ($idSequences as $idSequence) {
            $sequenceColumns[] = DB::raw("
                CASE
                    WHEN SUM(CASE WHEN ratings.idAssessmentType = $idSequence THEN ratings.value ELSE NULL END) IS NULL
                    THEN NULL
                    ELSE SUM(CASE WHEN ratings.idAssessmentType = $idSequence THEN ratings.value ELSE NULL END)
                END as sequence$idSequence
            ");
        }

        // Requête principale
        $notesSequences = Rating::select(
            'ratings.idAssessmentType',
            'ratings.idAssessment',                         // Identifiant de l'élève
            'ratings.idStudent as idEleve',                         // Identifiant de l'élève
            'matter_group.id as idGroupeMat',          // ID du groupe de matière
            'matter_group.name as nomGroupeMat',       // Nom du groupe de matière
            'assessments.idMatter as idMatiere',                      // Identifiant de la matière
            'matter.name as nomMatiere',                 // Nom de la matière
            'ratings.idTypeEvaluation as idTypeEval',     // Identifiant du type d'évaluation
            'type_evaluation.name as nomTypeEval',       // Nom du type d'évaluation
            DB::raw('SUM(ratings.value) as totalNoteObtenu'),   // Somme des notes pour ce type d'évaluation
            DB::raw('COUNT(ratings.id) as nbrSequenceEval'), // Nombre d'évaluations pour ce type d'évaluation
            DB::raw('RANK() OVER (
                PARTITION BY assessments.idMatter, ratings.idTypeEvaluation
                ORDER BY SUM(ratings.value) DESC
            ) as rang'),                               // Rang basé sur la somme des notes
            ...$sequenceColumns                        // Colonnes dynamiques pour chaque séquence
        )
            ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
            ->join('matter', 'matter.id', '=', 'assessments.idMatter')
            ->join('type_evaluation', 'type_evaluation.id', '=', 'ratings.idTypeEvaluation')
            ->join('matter_group_has_matter', 'matter_group_has_matter.matter_id', '=', 'matter.id') // Jointure avec la table pivot des groupes de matière
            ->join('matter_group', 'matter_group.id', '=', 'matter_group_has_matter.matter_group_id') // Jointure avec la table des groupes de matière
            ->join("matter_group_has_level", "matter_group_has_level.matter_group_id", "=", "matter_group.id")
            ->join("users", "users.id", "=", "ratings.idStudent")
            ->where("matter_group_has_level.level_id", Classes::where("id", $idClasse)->value('idLevel'))
            ->whereIn('ratings.idAssessmentType', $idSequences) // Filtrer par les séquences fournies
            ->where('matter.idOptionLevel', $idOptionNiveau)         // Filtrer par classe
            ->where('assessments.idClasse', $idClasse)         // Filtrer par classe
            ->where('users.idClasse', $idClasse)         // Filtrer par classe
            ->where('users.deleted', false)         // Filtrer par classe
            ->where('assessments.deleted', false)         // Filtrer par classe
            ->groupBy(
                'ratings.idAssessmentType',
                'ratings.idAssessment',
                'ratings.idStudent',                        // Regrouper par élève
                'assessments.idMatter',                     // Par matière
                'ratings.idTypeEvaluation',                 // Par type d’évaluation
                'matter.name',                              // Nom de la matière
                'type_evaluation.name',                     // Nom du type d’évaluation
                'matter_group.id',                          // ID du groupe de matière
                'matter_group.name'                         // Nom du groupe de matière
            )
            ->orderBy('assessments.idMatter')               // Trier par matière
            ->orderBy('ratings.idTypeEvaluation');            // Trier par type d’évaluation

        // Appliquer la condition sur idStudent seulement s'il n'est pas nul
        if ($idStudent !== null) {
            $notesSequences = $notesSequences->where('ratings.idStudent', $idStudent);
        }

        // Exécuter la requête
        $notesSequences = $notesSequences->get();

        $notesSequencesTemp = [];


        foreach ($notesSequences as $notesSequence){

            $hasAssessment = (AssessmentHasAssessmentType::where('assessment_id', $notesSequence["idAssessment"])
                    ->where('assessment_type_id', $notesSequence["idAssessmentType"])
                    ->count() > 0);

            $hasAssessmentType = (AssessmentHasTypeEvaluation::where("assessment_id", $notesSequence["idAssessment"])
                    ->where("type_evaluation_id", $notesSequence["idTypeEval"])
                    ->count() > 0);
            if($hasAssessment && $hasAssessmentType){
                $notesSequencesTemp [] = $notesSequence;
            }
        }

        $notesSequences = $notesSequencesTemp;


        //calcul des baremes
        // foreach($notesSequences as $index => $notesSequence){

        //     foreach($idSequences as $idSequence){

        //         if(!isset($notesSequences[$index]["noteMaxSeq$idSequence"])){
        //             $notesSequences[$index]["noteMaxSeq$idSequence"] = null;
        //         }

        //         if($notesSequences[$index]["sequence$idSequence"] !== null){
        //             $notesSequences[$index]["noteMaxSeq$idSequence"] = array_sum(Assessment::select(Str::slug($notesSequence["nomTypeEval"], "_"))
        //             ->join("assessments_has_type_evaluation", "assessments.id", "=", "assessments_has_type_evaluation.assessment_id")
        //             ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments_has_type_evaluation.assessment_id")
        //             ->where("assessments.idMatter", $notesSequence["idMatiere"])
        //             ->where("assessments.idClasse", $idClasse)
        //             ->where("assessments_has_assessment_type.assessment_type_id", $idSequence)
        //             ->where("assessments_has_type_evaluation.type_evaluation_id", $notesSequence["idTypeEval"])
        //             ->get()->pluck(Str::slug($notesSequence["nomTypeEval"], "_"))->toArray());
        //         }
        //     }
        // }



        //calcul des baremes v2
        $allAssessments = Assessment::join("assessments_has_type_evaluation", "assessments.id", "=", "assessments_has_type_evaluation.assessment_id")
            ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments_has_type_evaluation.assessment_id")
            ->where("assessments.idClasse", $idClasse)
            ->whereIn("assessments_has_assessment_type.assessment_type_id", $idSequences)
            ->get()
            ->groupBy(["idMatter", "assessment_type_id", "type_evaluation_id"]);

        foreach($notesSequences as $index => $notesSequence){
            foreach($idSequences as $idSequence){

                // Vérifier si la clé existe avant d'accéder à l'élément
                if(!isset($notesSequences[$index]["noteMaxSeq$idSequence"])){
                    $notesSequences[$index]["noteMaxSeq$idSequence"] = null;
                }

                // Vérifier si la clé "sequence$idSequence" existe et n'est pas nulle
                if(isset($notesSequences[$index]["sequence$idSequence"]) && $notesSequences[$index]["sequence$idSequence"] !== null){
                    // Vérifier si la structure nécessaire existe dans $allAssessments
                    if(isset($allAssessments[$notesSequence["idMatiere"]][$idSequence][$notesSequence["idTypeEval"]])) {
                        $notesSequences[$index]["noteMaxSeq$idSequence"] = array_sum(array_column(
                            $allAssessments[$notesSequence["idMatiere"]][$idSequence][$notesSequence["idTypeEval"]]->toArray(),
                            Str::slug($notesSequence["nomTypeEval"], "_")
                        ));
                    } else {
                        // Si la structure n'existe pas, tu peux gérer le cas ici
                        $notesSequences[$index]["noteMaxSeq$idSequence"] = 0;
                    }
                }
            }
        }



        // Retourner les résultats structurés
        return $notesSequences;
    }

    public function regroupeNoteParEleveParGroupeParMatiere($data, $idSequences, $idTrimestres = []){
        return array_reduce($data, function ($result, $item) use ($idSequences, $idTrimestres) {
            // Initialiser les données pour chaque élève
            if (!isset($result[$item['idEleve']])) {
                $result[$item['idEleve']] = [
                    'idEleve' => $item['idEleve'],
                    'totalNoteObtenus' => null, // Somme globale des totalNoteObtenu pour l'élève
                    'totalNoteMax' => null, // Somme globale des noteMax pour l'élève

                    'trimestres' => array_fill_keys(array_map(function ($id) {
                        return "trimestre$id";
                    }, $idTrimestres), null), // Somme par séquence pour l'élève

                    'noteMaxTrim' => array_fill_keys(array_map(function ($id) {
                        return "noteMaxTrim$id";
                    }, $idTrimestres), null),

                    'sequences' => array_fill_keys(array_map(function ($id) {
                        return "sequence$id";
                    }, $idSequences), null), // Somme par séquence pour l'élève

                    'noteMaxSeq' => array_fill_keys(array_map(function ($id) {
                        return "noteMaxSeq$id";
                    }, $idSequences), null),

                    'groupesMatieres' => [] // Groupes de matières
                ];
            }

            // Initialiser les données pour chaque groupe de matières
            if (!isset($result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']])) {
                $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']] = [
                    'idGroupeMat' => $item['idGroupeMat'],
                    'totalNoteObtenus' => null, // Somme globale des totalNoteObtenu pour le groupe
                    'totalNoteMax' => null, // Somme globale des noteMax pour le groupe

                    'sequences' => array_fill_keys(array_map(function ($id) {
                        return "sequence$id";
                    }, $idSequences), null), // Somme par séquence pour le groupe

                    'matieres' => [] // Matières sous ce groupe
                ];
            }

            // Initialiser les données pour chaque matière
            if (!isset($result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']])) {
                $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']] = [
                    'idMatiere' => $item['idMatiere'],
                    'totalNoteObtenus' => null, // Somme globale des totalNoteObtenu pour la matière
                    'totalNoteMax' => null, // Somme globale des noteMax pour la matière

                    'sequences' => array_fill_keys(array_map(function ($id) {
                        return "sequence$id";
                    }, $idSequences), null), // Somme par séquence pour la matière

                    'typesEvaluation' => [] // Types d'évaluations
                ];
            }

            // Initialiser les données pour chaque type d'évaluation
            if (!isset($result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']]["typesEvaluation"][$item['idTypeEval']])) {
                $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']]["typesEvaluation"][$item['idTypeEval']] = [
                    'idTypeEval' => $item['idTypeEval'],

                    'trimestres' => array_fill_keys(array_map(function ($id) {
                        return "trimestre$id";
                    }, $idTrimestres), null), // Somme par séquence pour l'élève

                    'noteMaxTrim' => array_fill_keys(array_map(function ($id) {
                        return "noteMaxTrim$id";
                    }, $idTrimestres), null),

                    'sequences' => array_fill_keys(array_map(function ($id) {
                        return "sequence$id";
                    }, $idSequences), null), // Notes par séquence pour ce type d'évaluation

                    'noteMaxSeq' => array_fill_keys(array_map(function ($id) {
                        return "noteMaxSeq$id";
                    }, $idSequences), null),

                    'totalNoteObtenu' => $item['totalNoteObtenu'] / $item['nbrSequenceEval'],
                    'nbrSequenceEval' => $item['nbrSequenceEval'],
                    'noteMax' => null,
                ];
            }

            // Ajouter les notes par séquence pour ce type d'évaluation
            foreach ($idSequences as $idSequence) {
                $sequenceKey = "sequence$idSequence";
                $noteSequence = $item[$sequenceKey] ?? null;

                // Vérifier si la note n'est pas null avant de l'ajouter aux agrégats
                if ($noteSequence !== null) {
                    // Ajouter aux séquences du type d'évaluation
                    $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']]["typesEvaluation"][$item['idTypeEval']]['sequences']["sequence$idSequence"] = $noteSequence;

                    $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']]["typesEvaluation"][$item['idTypeEval']]['noteMaxSeq']["noteMaxSeq$idSequence"] = $item["noteMaxSeq$idSequence"];

                    // Ajouter aux séquences de la matière
                    $result[$item['idEleve']]['groupesMatieres'][$item['idGroupeMat']]['matieres'][$item['idMatiere']]['sequences'][$sequenceKey] += $noteSequence;
                }
            }

            return $result;
        }, []);
    }


    public function getMatieresParSequence($idSequences, $idClasse, $idOptionNiveau){
        return Matter::select("matter.*",)
            ->join("assessments", "assessments.idMatter", "=", "matter.id")
            ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->where("assessments.deleted", 0)
            ->where("assessments.idClasse", $idClasse)
            ->where("matter.idOptionLevel", $idOptionNiveau)
            ->whereIn("assessments_has_assessment_type.assessment_type_id", $idSequences)
            ->distinct()
            ->get()
            ->toArray();
    }


    public function analyserEvaluationEleves($evaluations, $idSequences, $idClasse,$idOptionNiveau, $pourcentage = 0.7){
        $matieres  = $this->getMatieresParSequence($idSequences, $idClasse, $idOptionNiveau);
        $sequenceTrimestreMap = [];
        foreach ($idSequences as $idSequence) {
            $sequenceTrimestreMap[$idSequence] = $sequenceTrimestreMap[$idSequence]
                ?? AssessmentType::where('id', $idSequence)->value('idTrimestre');
        }

        //On parcours les evaluations de chaque eleve
        foreach ($evaluations as $key => $evaluation) {
            $nbrmatiereEvalue = 0;

            foreach($idSequences as $idSequence){
                $matieresEvaluees = [];
                $nbrmatiereEvalueSequence = 0;
                $idTrimestre = $sequenceTrimestreMap[$idSequence] ?? null;

                //Par groupe de matiere on filtre les matieres qui ont été evaluee pour la sequence courante
                foreach($evaluation["groupesMatieres"] as $groupeMatiere){
                    foreach($groupeMatiere["matieres"] as $matiere){
                        if(isset($matiere["sequences"]["sequence$idSequence"]) && $matiere["sequences"]["sequence$idSequence"] !== null){
                            $nbrmatiereEvalueSequence++;
                            $matieresEvaluees[] = $matiere['idMatiere'];
                        }
                    }
                }

                // Collecter les matières évaluées par au moins un élève (non null)
                // Note: Cette collecte doit être faite après avoir parcouru tous les élèves, mais comme c'est dans la boucle élève, on le fait ici
                // En fait, pour optimiser, on peut le faire une fois par séquence, mais puisque c'est par élève, on accumule
                // Mais pour éviter duplication, on utilise array_unique plus tard

                if (!isset($evaluations[$key]["isEvalueTrim"]["isEvalueTrim$idTrimestre"])){
                    $evaluations[$key]["isEvalueTrim"]["isEvalueTrim$idTrimestre"] = false;
                }

                // Calculer le total des matières assessables (avec au moins une note non null)
                $totalMatieresAssessables = count(array_unique($matieresEvaluees));

                //On détermine si l'eleve a effectué 70% des évaluations sur la séquence courante
                $evaluations[$key]["isEvalueSeq"]["isEvalueSeq$idSequence"] = $totalMatieresAssessables > 0 ?  ($nbrmatiereEvalueSequence / $totalMatieresAssessables) >= $pourcentage : false;

                if($evaluations[$key]["isEvalueSeq"]["isEvalueSeq$idSequence"] && $evaluations[$key]["isEvalueTrim"]["isEvalueTrim$idTrimestre"] !== true){
                    $evaluations[$key]["isEvalueTrim"]["isEvalueTrim$idTrimestre"] = $evaluations[$key]["isEvalueSeq"]["isEvalueSeq$idSequence"];
                }
            }

            //On détermine si l'eleve a effectué 70% sur au moins l'une des séquences
            $evaluations[$key]["isEvalue"] =  count(array_filter($evaluations[$key]["isEvalueSeq"], function ($value) {
                    return $value === true;
                })) > 0;

        }

        $evaluationsValides = array_filter($evaluations, function($evaluation) use($idSequences){
            return isset($evaluation['isEvalue']) && $evaluation['isEvalue'] === true;
        });

        $evaluationsInvalides = array_filter($evaluations, function($evaluation) use($idSequences){
            return isset($evaluation['isEvalue']) && $evaluation['isEvalue'] === false;
        });

        return [
            "evaluationsValides" => $evaluationsValides,
            "evaluationsInvalides" => $evaluationsInvalides
        ];
    }


    public function sommeDesNotes($evaluations, $idSequences, $idTrimestres = [])
    {
        $sequenceTrimestreMap = [];
        foreach ($idSequences as $idSequence) {
            $sequenceTrimestreMap[$idSequence] = $sequenceTrimestreMap[$idSequence]
                ?? AssessmentType::where('id', $idSequence)->value('idTrimestre');
        }

        /* ======================================================================================
           1) PREMIERE PASSE : Calculs par matière et par groupe
           ====================================================================================== */
        $newEvaluations = array_reduce($evaluations, function ($result, $item) use ($idSequences, $idTrimestres, $sequenceTrimestreMap) {

            /* ------------------------------------------------------
               Initialisation structure élève
            ------------------------------------------------------- */
            $item["totalNoteObtenus"] = null;
            $item["totalNoteMax"] = null;

            // Init moyennes de séquence
            foreach ($idSequences as $idSequence) {
                $item["moyennesSeq"]["moySeq$idSequence"] = null;
            }

            // Init moyennes trimestrielles
            foreach ($idTrimestres as $idTrimestre) {
                $item["moyennesTrim"]["moyTrim$idTrimestre"] = null;
            }

            /* ===================================================================
               TRAITEMENT DES GROUPES & MATIÈRES
            =================================================================== */
            foreach ($item["groupesMatieres"] as $gmKey => $groupeMatiere) {

                $groupeMatiere["totalNoteObtenus"] = null;
                $groupeMatiere["totalNoteMax"] = null;

                /* ----------------- MATIERES ------------------ */
                foreach ($groupeMatiere["matieres"] as $mKey => $matiere) {

                    $matiere["totalNoteObtenus"] = null;
                    $matiere["totalNoteMax"] = null;

                    // Init séquences matière
                    foreach ($idSequences as $idSequence) {
                        $matiere["sequences"]["sequence$idSequence"] = null;
                        $matiere["noteMaxSeq"]["noteMaxSeq$idSequence"] = null;
                    }

                    // Init trimestres matière
                    foreach ($idTrimestres as $idTrimestre) {
                        $matiere["trimestres"]["trimestre$idTrimestre"] = null;
                        $matiere["noteMaxTrim"]["noteMaxTrim$idTrimestre"] = null;
                    }

                    /* ---------------- TYPE EVALUATION ---------------- */
                    foreach ($matiere["typesEvaluation"] as $tKey => $typeEvaluation) {

                        $typeEvaluation["nbrSequenceEval"] = 0;
                        $typeEvaluation["totalNoteObtenu"] = null;
                        $typeEvaluation["noteMax"] = null;

                        // Init trimestres TE
                        foreach ($idTrimestres as $idTrimestre) {
                            $trimKey = "trimestre$idTrimestre";
                            $trimMaxKey = "noteMaxTrim$idTrimestre";

                            $typeEvaluation["trimestres"][$trimKey] = $typeEvaluation["trimestres"][$trimKey] ?? null;
                            $typeEvaluation["noteMaxTrim"][$trimMaxKey] = $typeEvaluation["noteMaxTrim"][$trimMaxKey] ?? null;
                        }

                        $nbrSeqByTrim = [];

                        /* -------- SOMME DES NOTES PAR SEQUENCE ------- */
                        foreach ($idSequences as $idSequence) {

                            $seqTrim = $sequenceTrimestreMap[$idSequence] ?? null;

                            $note = $typeEvaluation["sequences"]["sequence$idSequence"] ?? null;
                            $noteMax = $typeEvaluation["noteMaxSeq"]["noteMaxSeq$idSequence"] ?? null;

                            if ($note !== null && $noteMax !== null &&
                                ($item["isEvalueSeq"]["isEvalueSeq$idSequence"] ?? false)) {

                                if ($typeEvaluation["totalNoteObtenu"] === null) $typeEvaluation["totalNoteObtenu"] = 0;
                                if ($typeEvaluation["noteMax"] === null) $typeEvaluation["noteMax"] = 0;

                                $typeEvaluation["totalNoteObtenu"] += $note;
                                $typeEvaluation["noteMax"] += $noteMax;
                                $typeEvaluation["nbrSequenceEval"]++;

                                // Trimestre TE
                                $trimKey = "trimestre$seqTrim";
                                $trimMaxKey = "noteMaxTrim$seqTrim";

                                if (!isset($typeEvaluation["trimestres"][$trimKey]) || $typeEvaluation["trimestres"][$trimKey] === null) $typeEvaluation["trimestres"][$trimKey] = 0;
                                if (!isset($typeEvaluation["noteMaxTrim"][$trimMaxKey]) || $typeEvaluation["noteMaxTrim"][$trimMaxKey] === null) $typeEvaluation["noteMaxTrim"][$trimMaxKey] = 0;
                                if (!isset($nbrSeqByTrim[$trimKey])) $nbrSeqByTrim[$trimKey] = 0;

                                $typeEvaluation["trimestres"][$trimKey] += $note;
                                $typeEvaluation["noteMaxTrim"][$trimMaxKey] += $noteMax;
                                $nbrSeqByTrim[$trimKey]++;
                            }
                        }

                        /* -------- NORMALISATION (MOYENNE) -------- */
                        if ($typeEvaluation["nbrSequenceEval"] > 0) {

                            $div = $typeEvaluation["nbrSequenceEval"];

                            $typeEvaluation["totalNoteObtenu"] /= $div;
                            $typeEvaluation["noteMax"] /= $div;

                            foreach ($idTrimestres as $idTrimestre) {
                                $trimKey = "trimestre$idTrimestre";
                                $trimMaxKey = "noteMaxTrim$idTrimestre";
                                $divTrim = $nbrSeqByTrim[$trimKey] ?? 0;

                                if ($divTrim > 0) {
                                    if ($typeEvaluation["trimestres"][$trimKey] !== null)
                                        $typeEvaluation["trimestres"][$trimKey] /= $divTrim;

                                    if ($typeEvaluation["noteMaxTrim"][$trimMaxKey] !== null)
                                        $typeEvaluation["noteMaxTrim"][$trimMaxKey] /= $divTrim;
                                }
                            }
                        }

                        $matiere["typesEvaluation"][$tKey] = $typeEvaluation;
                    }

                    /* -------- CALCUL SOMME DES SÉQUENCES MATIÈRE -------- */
                    foreach ($idSequences as $idSequence) {
                        $sumN = null; $sumM = null;

                        foreach ($matiere["typesEvaluation"] as $tEval) {
                            $n = $tEval["sequences"]["sequence$idSequence"] ?? null;
                            $m = $tEval["noteMaxSeq"]["noteMaxSeq$idSequence"] ?? null;

                            if ($n !== null && $m !== null) {
                                if ($sumN === null) $sumN = 0;
                                if ($sumM === null) $sumM = 0;

                                $sumN += $n; $sumM += $m;
                            }
                        }

                        $matiere["sequences"]["sequence$idSequence"] = $sumN;
                        $matiere["noteMaxSeq"]["noteMaxSeq$idSequence"] = $sumM;
                    }

                    /* -------- MOYENNE TRIMESTRE PAR MATIÈRE -------- */
                    foreach ($idTrimestres as $idTrimestre) {

                        $sumT = 0; $sumTMax = 0; $count = 0;

                        foreach ($idSequences as $idSequence) {
                            $seqTrim = $sequenceTrimestreMap[$idSequence] ?? null;

                            if ($seqTrim == $idTrimestre) {

                                $n = $matiere["sequences"]["sequence$idSequence"] ?? null;
                                $m = $matiere["noteMaxSeq"]["noteMaxSeq$idSequence"] ?? null;

                                if ($n !== null && $m !== null &&
                                    ($item["isEvalueSeq"]["isEvalueSeq$idSequence"] ?? false)) {

                                    $sumT += $n;
                                    $sumTMax += $m;
                                    $count++;
                                }
                            }
                        }

                        $trimKey = "trimestre$idTrimestre";
                        $trimMaxKey = "noteMaxTrim$idTrimestre";

                        if ($count > 0) {
                            $matiere["trimestres"][$trimKey] = $sumT / $count;
                            $matiere["noteMaxTrim"][$trimMaxKey] = $sumTMax / $count;
                        } else {
                            $matiere["trimestres"][$trimKey] = null;
                            $matiere["noteMaxTrim"][$trimMaxKey] = null;
                        }
                    }

                    /* -------- TOTAL MATIERE -------- */
                    $sumAll = 0; $sumAllMax = 0; $countAll = 0;

                    foreach ($idSequences as $idSequence) {
                        $n = $matiere["sequences"]["sequence$idSequence"] ?? null;
                        $m = $matiere["noteMaxSeq"]["noteMaxSeq$idSequence"] ?? null;

                        if ($n !== null && $m !== null &&
                            ($item["isEvalueSeq"]["isEvalueSeq$idSequence"] ?? false)) {

                            $sumAll += $n;
                            $sumAllMax += $m;
                            $countAll++;
                        }
                    }

                    if ($countAll > 0) {
                        $matiere["totalNoteObtenus"] = $sumAll / $countAll;
                        $matiere["totalNoteMax"] = $sumAllMax / $countAll;
                    }

                    // Ajout au groupe
                    if ($matiere["totalNoteObtenus"] !== null) {

                        if ($groupeMatiere["totalNoteObtenus"] === null)
                            $groupeMatiere["totalNoteObtenus"] = 0;

                        if ($groupeMatiere["totalNoteMax"] === null)
                            $groupeMatiere["totalNoteMax"] = 0;

                        $groupeMatiere["totalNoteObtenus"] += $matiere["totalNoteObtenus"];
                        $groupeMatiere["totalNoteMax"] += $matiere["totalNoteMax"];
                    }

                    $groupeMatiere["matieres"][$mKey] = $matiere;
                }

                $item["groupesMatieres"][$gmKey] = $groupeMatiere;
            }

            $result[$item["idEleve"]] = $item;
            return $result;

        }, []);

        /* ======================================================================================
           2) DEUXIEME PASSE : Calculs globaux élève (séquences + trimestres + moyenne générale)
           ====================================================================================== */
        $final = [];

        foreach ($newEvaluations as $idEleve => $item) {

            /* -------- MOYENNES DE SÉQUENCE -------- */
            foreach ($idSequences as $idSequence) {

                $sumSeq = null; $sumSeqMax = null;

                foreach ($item["groupesMatieres"] as $groupe) {
                    foreach ($groupe["matieres"] as $matiere) {

                        $n = $matiere["sequences"]["sequence$idSequence"] ?? null;
                        $m = $matiere["noteMaxSeq"]["noteMaxSeq$idSequence"] ?? null;

                        if ($n !== null && $m !== null) {
                            if ($sumSeq === null) $sumSeq = 0;
                            if ($sumSeqMax === null) $sumSeqMax = 0;

                            $sumSeq += $n;
                            $sumSeqMax += $m;
                        }
                    }
                }

                if ($sumSeq !== null && $sumSeqMax > 0 &&
                    ($item["isEvalueSeq"]["isEvalueSeq$idSequence"] ?? false)) {

                    $item["moyennesSeq"]["moySeq$idSequence"] =
                        round(($sumSeq / $sumSeqMax) * 20, 2);

                } else {
                    $item["moyennesSeq"]["moySeq$idSequence"] = null;
                }
            }

            /* -------- TRIMESTRES + MOYENNES -------- */
            $item["totalNoteObtenus"] = null;
            $item["totalNoteMax"] = null;

            foreach ($idTrimestres as $idTrimestre) {

                $trimKey = "trimestre$idTrimestre";
                $trimMaxKey = "noteMaxTrim$idTrimestre";

                $sumT = 0; $sumTMax = 0; $count = 0;

                foreach ($item["groupesMatieres"] as $groupe) {
                    foreach ($groupe["matieres"] as $matiere) {

                        $n = $matiere["trimestres"][$trimKey] ?? null;
                        $m = $matiere["noteMaxTrim"][$trimMaxKey] ?? null;

                        if ($n !== null && $m !== null) {
                            $sumT += $n;
                            $sumTMax += $m;
                            $count++;
                        }
                    }
                }

                if ($count > 0) {
                    $item["trimestres"][$trimKey] = $sumT;
                    $item["noteMaxTrim"][$trimMaxKey] = $sumTMax;

                    if ($item["totalNoteObtenus"] === null) $item["totalNoteObtenus"] = 0;
                    if ($item["totalNoteMax"] === null) $item["totalNoteMax"] = 0;

                    $item["totalNoteObtenus"] += $sumT;
                    $item["totalNoteMax"] += $sumTMax;
                } else {
                    $item["trimestres"][$trimKey] = null;
                    $item["noteMaxTrim"][$trimMaxKey] = null;
                }

                /* -------- MOYENNE TRIMESTRIELLE (MOY SEQ VALIDES) -------- */
                $sumMoy = 0; $c = 0;

                foreach ($idSequences as $idSequence) {

                    $seqTrim = $sequenceTrimestreMap[$idSequence] ?? null;

                    if ($seqTrim == $idTrimestre) {

                        $moySeq = $item["moyennesSeq"]["moySeq$idSequence"] ?? null;

                        if ($moySeq !== null &&
                            ($item["isEvalueSeq"]["isEvalueSeq$idSequence"] ?? false)) {

                            $sumMoy += $moySeq;
                            $c++;
                        }
                    }
                }

                $moyKeyTrim = "moyTrim$idTrimestre";

                if ($c > 0 &&
                    ($item["isEvalueTrim"]["isEvalueTrim$idTrimestre"] ?? false)) {

                    $item["moyennesTrim"][$moyKeyTrim] = round($sumMoy / $c, 2);

                } else {
                    $item["moyennesTrim"][$moyKeyTrim] = null;
                }
            }

            /* ======================================================================================
               ⭐ CALCUL DE LA MOYENNE GÉNÉRALE (NOUVEAUTÉ)
               moyenne générale = moyenne des moyennes trimestrielles valides
            ====================================================================================== */
            $sumGen = 0;
            $countGen = 0;

            foreach ($idTrimestres as $idTrimestre) {

                $moyTrim = $item["moyennesTrim"]["moyTrim$idTrimestre"] ?? null;

                if ($moyTrim !== null &&
                    ($item["isEvalueTrim"]["isEvalueTrim$idTrimestre"] ?? false)) {

                    $sumGen += $moyTrim;
                    $countGen++;
                }
            }

            if ($countGen > 0) {
                $item["moyenneGenerale"] = round($sumGen / $countGen, 2);
            } else {
                $item["moyenneGenerale"] = null;
            }

            $final[$idEleve] = $item;
        }

        return $final;
    }


    public function getDonneesClasseMatieresTypeEvaluation($datas, $idClasse, $idSequences, $idOptionNiveau, $route, $idTrimestres)
    {
        // 1) récupération des types / matière / groupe (même requête qu'avant)
        $typeEvaluationParMatiereParGroupe = MatterGroup::select(
            "matter_group.id as idGroupeMat",
            "matter_group.name as nomGroupeMat",
            "matter_group.description as descGroupeMat",
            "matter.id as idMatiere",
            "matter.code as codeMatiere",
            "matter.name as nomMatiere",
            "matter.libelle as libelleMatiere",
            "type_evaluation.id as idTypeEval",
            "type_evaluation.name as nomTypeEval",
            "type_evaluation.libelle as libelleTypeEval"
        )
            ->join("matter_group_has_matter", "matter_group_has_matter.matter_group_id", "=", "matter_group.id")
            ->join("matter", "matter.id", "=", "matter_group_has_matter.matter_id")
            ->join("assessments", "assessments.idMatter", "=", "matter.id")
            ->join("assessments_has_type_evaluation", "assessments_has_type_evaluation.assessment_id", "=", "assessments.id")
            ->join("type_evaluation", "type_evaluation.id", "=", "assessments_has_type_evaluation.type_evaluation_id")
            ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->join("matter_group_has_level", "matter_group_has_level.matter_group_id", "=", "matter_group.id")
            ->where("assessments.deleted", 0)
            ->where("assessments.idClasse", $idClasse)
            ->where("matter.idOptionLevel", $idOptionNiveau)
            ->where("matter_group_has_level.level_id", Classes::where("id", $idClasse)->value('idLevel'))
            ->whereIn("assessments_has_assessment_type.assessment_type_id", $idSequences)
            ->distinct()
            ->get()
            ->toArray();

        // 2) Pré-calcul des moyennes élèves (utilise la moyenne générale arrondie déjà calculée)
        $moyennesEleves = array_values(collect($datas)->map(function ($eleve) {
            return $eleve["moyenneGenerale"] ?? null;
        })->toArray());

        // enlever les nulls et trier
        $moyennesEleves = array_values(array_filter($moyennesEleves, function ($v) {
            return $v !== null;
        }));
        rsort($moyennesEleves);

        // préparer résultat initial
        $result = [
            "donneesMatiere" => null,
            "donneesClasse" => [
                "moyennesObtenues" => $moyennesEleves,
                "moyenneGenerale" => count($moyennesEleves) > 0 ? (array_sum($moyennesEleves) / count($moyennesEleves)) : null,
                "PourcentageReussite" => count($moyennesEleves) > 0 ? (count(collect($moyennesEleves)->filter(function ($note) { return $note >= 10; })) * 100) / count($moyennesEleves) : null,
            ],
        ];

        // 3) Construction hiérarchique groupes -> matieres -> typeEvaluations
        $result["donneesMatiere"] = [];

        foreach ($typeEvaluationParMatiereParGroupe as $item) {

            $gId = $item["idGroupeMat"];
            $mId = $item["idMatiere"];
            $tId = $item["idTypeEval"];

            // crée le groupe si nécessaire
            if (!isset($result["donneesMatiere"][$gId])) {
                $result["donneesMatiere"][$gId] = [
                    "idGroupeMat" => $gId,
                    "nomGroupeMat" => $item["nomGroupeMat"],
                    "description" => $item["descGroupeMat"],
                    "matieres" => []
                ];
            }

            // crée la matière si nécessaire
            if (!isset($result["donneesMatiere"][$gId]["matieres"][$mId])) {

                // extraire pour chaque élève la totalNoteObtenus matéria et la moyenne de la matière
                $notesObtenues = collect($datas)->map(function ($eleve) use ($gId, $mId) {
                    if (isset($eleve["groupesMatieres"][$gId]["matieres"][$mId])) {
                        $mat = $eleve["groupesMatieres"][$gId]["matieres"][$mId];
                        if (isset($mat["totalNoteObtenus"]) && isset($mat["totalNoteMax"]) && $mat["totalNoteMax"] > 0 && $mat["totalNoteObtenus"] !== null) {
                            return $mat["totalNoteObtenus"];
                        }
                    }
                    return null;
                })->toArray();

                $moyennes = collect($datas)->map(function ($eleve) use ($gId, $mId) {
                    if (isset($eleve["groupesMatieres"][$gId]["matieres"][$mId])) {
                        $mat = $eleve["groupesMatieres"][$gId]["matieres"][$mId];
                        if (isset($mat["totalNoteObtenus"]) && isset($mat["totalNoteMax"]) && $mat["totalNoteMax"] > 0 && $mat["totalNoteObtenus"] !== null) {
                            // si la moyenne matière a déjà été calculée et présente (préférence), on l'utilise
                            if (isset($mat["moyenneGenerale"]) && $mat["moyenneGenerale"] !== null) {
                                return $mat["moyenneGenerale"];
                            }
                            // sinon, on peut dériver (utilise valeurs déjà calculées) — si tu veux absolument éviter, ajoute la moyenne dans sommeDesNotes
                            return ($mat["totalNoteObtenus"] / $mat["totalNoteMax"]) * 20;
                        }
                    }
                    return null;
                })->toArray();

                // nettoyage et tri
                $notesObtenues = array_values(array_filter($notesObtenues, function ($v) { return $v !== null; }));
                $moyennes = array_values(array_filter($moyennes, function ($v) { return $v !== null; }));
                rsort($notesObtenues);

                $result["donneesMatiere"][$gId]["matieres"][$mId] = [
                    "idMatiere" => $mId,
                    "codeMatiere" => $item["codeMatiere"],
                    "nomMatiere" => $item["nomMatiere"],
                    "libelleMatiere" => $item["libelleMatiere"],
                    "notesObtenues" => array_values($notesObtenues),
                    "moyenneGenerale" => count($moyennes) > 0 ? (array_sum($moyennes) / count($moyennes)) : null,
                    "pourcentageReussite" => count($moyennes) > 0 ? (count(collect($moyennes)->filter(function ($note) { return $note >= 10; })) * 100) / count($moyennes) : null,
                    "typeEvaluations" => []
                ];
            }

            // 4) Ajouter le type d'évaluation (en se basant sur les valeurs déjà présentes dans $datas)
            $notesObtenuesType = collect($datas)->map(function ($eleve) use ($gId, $mId, $tId) {
                if (isset($eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId])) {
                    $ev = $eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId];
                    if (isset($ev["totalNoteObtenu"]) && isset($ev["noteMax"]) && $ev["noteMax"] > 0 && $ev["totalNoteObtenu"] !== null) {
                        return $ev["totalNoteObtenu"];
                    }
                }
                return null;
            })->toArray();

            $notesMaxType = collect($datas)->map(function ($eleve) use ($gId, $mId, $tId) {
                if (isset($eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId])) {
                    $ev = $eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId];
                    if (isset($ev["noteMax"]) && $ev["noteMax"] !== null) {
                        return $ev["noteMax"];
                    }
                }
                return null;
            })->toArray();

            $moyennesType = collect($datas)->map(function ($eleve) use ($gId, $mId, $tId) {
                if (isset($eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId])) {
                    $ev = $eleve["groupesMatieres"][$gId]["matieres"][$mId]["typesEvaluation"][$tId];
                    if (isset($ev["totalNoteObtenu"]) && isset($ev["noteMax"]) && $ev["noteMax"] > 0 && $ev["totalNoteObtenu"] !== null) {
                        // si la moyenne du type est déjà présente, on l'utilise si disponible
                        if (isset($ev["moyenne"]) && $ev["moyenne"] !== null) {
                            return $ev["moyenne"];
                        }
                        // sinon dériver à partir des totaux (valeurs déjà issues de sommeDesNotes)
                        return ($ev["totalNoteObtenu"] / $ev["noteMax"]) * 20;
                    }
                }
                return null;
            })->toArray();

            $notesObtenuesType = array_values(array_filter($notesObtenuesType, function ($v) { return $v !== null; }));
            $notesMaxType = array_values(array_filter($notesMaxType, function ($v) { return $v !== null; }));
            $moyennesType = array_values(array_filter($moyennesType, function ($v) { return $v !== null; }));
            rsort($notesObtenuesType);

            // si juniors, comportement noteMax spécial (comme dans ton code original)
            $notesMaxForOutput = (strpos($route, 'juniors') === false) ? $notesMaxType : 20;

            $result["donneesMatiere"][$gId]["matieres"][$mId]["typeEvaluations"][$tId] = [
                "idTypeEval" => $tId,
                "nomTypeEval" => $item["nomTypeEval"],
                "libelleTypeEval" => $item["libelleTypeEval"],
                "notesObtenues" => array_values($notesObtenuesType),
                "notesmax" => $notesMaxForOutput,
                // moyenne générale du type : si on a des moyennes déjà (moyennesType) on les agrège,
                // sinon fallback sur notesObtenues (comme ton code d'origine)
                "moyenneGenerale" => (count($moyennesType) > 0) ? (array_sum($moyennesType) / count($moyennesType)) : (count($notesObtenuesType) > 0 ? (array_sum($notesObtenuesType) / count($notesObtenuesType)) : null),
                "noteMaxgenerale" => (strpos($route, 'juniors') === false) ? (count($notesMaxType) > 0 ? (array_sum($notesMaxType) / count($notesMaxType)) : null) : $notesMaxForOutput,
                "pourcentageReussite" => count($moyennesType) > 0 ? (count(collect($moyennesType)->filter(function ($note) { return $note >= 10; })) * 100) / count($moyennesType) : null,
            ];
        }

        // tri des groupes et matières et types (comme avant)
        ksort($result["donneesMatiere"]);
        foreach ($result["donneesMatiere"] as &$groupe) {
            uasort($groupe["matieres"], function ($a, $b) {
                return strcmp($a["codeMatiere"], $b["codeMatiere"]);
            });
            foreach ($groupe["matieres"] as &$matiere) {
                if (isset($matiere["typeEvaluations"])) {
                    uasort($matiere["typeEvaluations"], function ($a, $b) {
                        $nameComparison = strcmp($a["nomTypeEval"], $b["nomTypeEval"]);
                        if ($nameComparison === 0) {
                            return $a["idTypeEval"] <=> $b["idTypeEval"];
                        }
                        return $nameComparison;
                    });
                }
            }
        }
        unset($groupe, $matiere);

        return $result;
    }


    public function getInfosEcole($idClasse){
        $ecole = School::select("schools.name as nom", "schools.logo", 'idPrincipal', 'idAssistant', 'city', 'adresse', 'stamp')
            ->join("classes", "classes.idSchool", "=", "schools.id")
            ->where("classes.deleted", 0)
            ->where("classes.id", $idClasse)
            ->first();

        return $ecole;
    }


    public function genererDocument($filename, $template, $data, $zip, $disposition = null){
        $dompdf = new Dompdf();

        // Récupérer la vue
        $view = View::make($template)->with($data);

        // Récupérer le contenu de la vue
        $html = $view->render();

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4',$disposition ?? "portrait");

        // Exécuter le rendu du PDF
        $dompdf->render();

        file_put_contents(public_path("pdfs/$filename"), $dompdf->output());


        if ($zip){
            $zip->addFile("pdfs/$filename");
        }

        return public_path("pdfs/$filename");
    }
    public function calculateOptimalScaleSecondaire($template, $data)
    {
        $scale = 1.00;
        $maxScale = 1.20;
        $increment = 0.025;  // étape initiale plus grosse pour aller plus vite
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

    public function genererDocumentPrimaireAutoScale($filename, $template, $data, $zip, $scale)
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


    public function genererBulletinsNulls($idClasse, $idOptionNiveau, $idSequences)
    {
        // Récupération des élèves
        $eleves = User::select('users.id as idEleve', )
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('classes.id', $idClasse)
            ->where('classes.deleted', 0)
            ->where('users.deleted', 0)
            ->orderBy("users.name")
            ->where('roles.id', 8)
            ->groupBy('users.id')->get()
            ->keyBy('idEleve'); // Transforme la collection en tableau associatif avec 'idEleve' comme clé

        // Récupérer les données
        $typeEvaluationParMatiereParGroupe = MatterGroup::select(
            "matter_group.id as idGroupeMat",
            "matter_group.name as nomGroupeMat",
            "matter_group.description as descGroupeMat",
            "matter.id as idMatiere",
            "matter.code as codeMatiere",
            "matter.name as nomMatiere",
            "matter.libelle as libelleMatiere",
            "type_evaluation.id as idTypeEval",
            "type_evaluation.name as nomTypeEval",
            "type_evaluation.libelle as libelleTypeEval"
        )
            ->join("matter_group_has_matter", "matter_group_has_matter.matter_group_id", "=", "matter_group.id")
            ->join("matter", "matter.id", "=", "matter_group_has_matter.matter_id")
            ->join("assessments", "assessments.idMatter", "=", "matter.id")
            ->join("assessments_has_type_evaluation", "assessments_has_type_evaluation.assessment_id", "=", "assessments.id")
            ->join("type_evaluation", "type_evaluation.id", "=", "assessments_has_type_evaluation.type_evaluation_id")
            ->join("assessments_has_assessment_type", "assessments_has_assessment_type.assessment_id", "=", "assessments.id")
            ->join("matter_group_has_level", "matter_group_has_level.matter_group_id", "=", "matter_group.id")
            ->where("assessments.deleted", 0)
            ->where("assessments.idClasse", $idClasse)
            ->where("matter.idOptionLevel", null)
            ->where("matter_group_has_level.level_id", Classes::where("id", $idClasse)->value('idLevel'))
            ->whereIn("assessments_has_assessment_type.assessment_type_id", $idSequences)
            ->distinct()
            ->get()
            ->toArray();

        if(count($typeEvaluationParMatiereParGroupe) <= 0){
            return [];
        }

        $evaluationsEleve = [];
        // Construction de la structure attendue
        foreach ($eleves as $key => $eleve) {
            $eleve = [
                "idEleve" => $eleve["idEleve"],
                "totalNoteObtenus" => null,
                "totalNoteMax" => null,
                "sequences" => [],
                "noteMaxSeq" => [],
                "groupesMatieres" => [],
            ];

            // Initialisation des séquences au niveau de l'élève
            foreach ($idSequences as $idSequence) {
                $eleve["sequences"]["sequence{$idSequence}"] = null;
                $eleve["noteMaxSeq"]["noteMaxSeq{$idSequence}"] = null;
            }

            // Initialisation des groupes de matières et leurs sous-éléments
            foreach ($typeEvaluationParMatiereParGroupe as $groupe) {
                // Si le groupe de matières n'existe pas encore
                if (!isset($eleve["groupesMatieres"][$groupe["idGroupeMat"]])) {
                    $eleve["groupesMatieres"][$groupe["idGroupeMat"]] = [
                        "idGroupeMat" => $groupe["idGroupeMat"],
                        "totalNoteObtenus" => null,
                        "totalNoteMax" => null,
                        "sequences" => [],
                        "matieres" => [],
                    ];

                    // Initialisation des séquences pour le groupe
                    foreach ($idSequences as $idSequence) {
                        $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["sequences"]["sequence{$idSequence}"] = null;
                    }
                }

                // Ajout des matières dans le groupe
                if (!isset($eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]])) {
                    $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]] = [
                        "idMatiere" => $groupe["idMatiere"],
                        "totalNoteObtenus" => null,
                        "totalNoteMax" => null,
                        "sequences" => [],
                        "typesEvaluation" => [],
                    ];

                    // Initialisation des séquences pour la matière
                    foreach ($idSequences as $idSequence) {
                        $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]]["sequences"]["sequence{$idSequence}"] = null;
                    }
                }

                // Ajout des types d'évaluation dans la matière
                if (!isset($eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]]["typesEvaluation"][$groupe["idTypeEval"]])) {
                    $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]]["typesEvaluation"][$groupe["idTypeEval"]] = [
                        "idTypeEval" => $groupe["idTypeEval"],
                        "sequences" => [],
                        "noteMaxSeq" => [],
                        "totalNoteObtenu" => null,
                        "nbrSequenceEval" => 0,
                        "noteMax" => null,
                    ];

                    // Initialisation des séquences pour le type d'évaluation
                    foreach ($idSequences as $idSequence) {
                        $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]]["typesEvaluation"][$groupe["idTypeEval"]]["sequences"]["sequence{$idSequence}"] = null;
                        $eleve["groupesMatieres"][$groupe["idGroupeMat"]]["matieres"][$groupe["idMatiere"]]["typesEvaluation"][$groupe["idTypeEval"]]["noteMaxSeq"]["noteMaxSeq{$idSequence}"] = null;
                    }
                }
            }

            $evaluationsEleve[$key]= $eleve;
        }

        return $evaluationsEleve;
    }
    public function fusionnerEtRetournerBulletins($liensRepertoires, $liensBulletins, $studentName) {
        try {
            // Crée une nouvelle instance FPDI pour le fichier final
            $pdf = new Fpdi();

            // Parcourt chaque fichier PDF dans le tableau $liensBulletins
            foreach ($liensBulletins as $cheminPDF) {
                // Charge le fichier PDF source
                $pageCount = $pdf->setSourceFile($cheminPDF);

                // Parcourt chaque page du fichier PDF et les ajoute au fichier final
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $templateId = $pdf->importPage($pageNo);
                    $pdf->addPage();
                    $pdf->useTemplate($templateId);
                }
            }

            // Génère le nom du fichier final (fusionné)
            $baseNameFinal = Str::slug('bulletins_' . $studentName);
            $counter = 1;
            $nomFichierFinal = $baseNameFinal . '.pdf';
            while (file_exists(public_path('pdfs/' . $nomFichierFinal)) || file_exists(base_path('public/pdfs/' . $nomFichierFinal)) || file_exists('pdfs/' . $nomFichierFinal)) {
                $nomFichierFinal = $baseNameFinal . '-' . $counter . '.pdf';
                $counter++;
            }
            $cheminFichierFinal = 'pdfs/' . $nomFichierFinal;

            // Sauvegarde le fichier fusionné
            $pdf->Output('F', $cheminFichierFinal);

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            foreach ($liensRepertoires as $liensRepertoire) {
                $this->deleteDirectory($liensRepertoire);
            }

            // Retourne le fichier fusionné avec asset()
            return $cheminFichierFinal;
        } catch (Exception $e) {
            // Gestion des erreurs
            return $this->sendError('Une erreur est survenue lors de la fusion des bulletins: ' . $e->getMessage());
        }
    }

    public function listeDesEleves($idClasse, $sequences){
        $eleves = User::select('users.id', "users.name", "users.photo", "users.photo", "users.matricule",
            "users.gender", "users.repeater", "users.birthday", "users.nationality", "users.city")
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('classes.deleted', 0)
            ->where('classes.id', $idClasse)
            ->where('users.deleted', 0)
            ->orderBy("users.name")
            ->where('roles.id', 8)
            ->get()
            ->toArray();

        $formatSequences = collect($sequences)->mapWithKeys(function ($item) {
            return [
                $item['id'] => [
                    'name' => $item['name'],
                    'idTrimestre' => $item['idTrimestre'],
                ],
            ];
        });

//        foreach ($eleves as &$eleve) {
//            foreach ($formatSequences as $idSequence => $formatSequence){
//                $eleve[$idSequence] = $formatSequence;
//            }
//        }

        return $eleves;
    }

    public function listerLesEvaluations($idClasse, $idOptionLevel, $idSequence){
        $evaluations = AssessmentHasAssessmentType::join('assessments', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
            ->join('matter', 'matter.id', '=', "assessments.idMatter")
            ->select("assessments_has_assessment_type.assessment_id", "matter.id as matter_id", "matter.name as matter_name", "matter.libelle", "matter.code")
            ->where("assessments.idClasse", $idClasse)
            ->where("matter.idOptionLevel", $idOptionLevel)
            ->where("assessments.deleted", 0)
            ->where("assessments_has_assessment_type.assessment_type_id", $idSequence)
            ->orderBy("assessments.id")
            ->get();

        $formatEvaluations = collect($evaluations)->mapWithKeys(function ($item) {
            return [
                $item['assessment_id'] => [
                    'matter_id' => $item['matter_id'],
                    'matter_code' => $item['code'],
                    'matter_name' => $item['matter_name'],
                    'matter_libelle' => $item['libelle'],
                ],
            ];
        });

        return $formatEvaluations->toArray();
    }

    public function listerLesTypesEvaluation($idEvaluation){
        $typesEvaluation = AssessmentHasTypeEvaluation::select('type_evaluation_id')
            ->where('assessment_id', $idEvaluation)
            ->get();

        $formatTypesEvaluation = collect($typesEvaluation)->mapWithKeys(function ($item) {
            return [
                $item['type_evaluation_id'] => null
            ];
        });

        return $formatTypesEvaluation;
    }


    public function noteTYpeEvaluation($idEleve, $idSequence, $idEvaluation, $idTypeEvaluation){
        $note = Rating::select('idAssessmentType as sequence_id', 'idAssessment as evaluation_id',
            'idMatter as matter_id', 'idTypeEvaluation as type_evaluation_id', 'value as evaluation_type_note')
            ->where('idTypeEvaluation', $idTypeEvaluation)
            ->where('idAssessment', $idEvaluation)
            ->where('idAssessmentType', $idSequence)
            ->where('idStudent', $idEleve)->first();



        $evaluationTypeInfos = TypeEvaluation::select('name', 'libelle')
            ->where('id', $idTypeEvaluation)->first();

        $evaluationTypeLibelle = TypeEvaluation::select('libelle')
            ->where('id', $idTypeEvaluation)->first()->libelle;

        $evaluationTypeMax = Assessment::select(Str::slug($evaluationTypeInfos->name, '_'))
            ->where("id", $idEvaluation)->first()->{Str::slug($evaluationTypeInfos->name, '_')};


        $note = [
            'evaluation_type_name' => $evaluationTypeInfos->name,
            'evaluation_type_libelle' => $evaluationTypeInfos->libelle,
            'evaluation_type_note_max' => $note ? $evaluationTypeMax : null,
            'evaluation_type_note' => $note['evaluation_type_note'] ?? null
        ];

        return $note;
    }

    public function sommeNoteEtNoteMax($sequences, $donneeEvaluationEleve, $cle){
        foreach ($donneeEvaluationEleve[$cle] as $idMatiere => &$matiere) {

            // Vérifie que $matiere est bien un tableau
            if (!is_array($matiere)) {
                continue;
            }

            //Note max type evaluation trimestres et bilan
            foreach (array_filter(array_keys($matiere), 'is_int') as $idTypeEvaluation){
                $typeEvaluationNotes = [];
                $typeEvaluationNoteMax = [];

                foreach ($sequences as $idSequence => $sequence) {
                    $evaluationSequence = $donneeEvaluationEleve["sequence$idSequence"];
                    if (array_key_exists($idMatiere, $evaluationSequence)
                        && array_key_exists($idTypeEvaluation, $evaluationSequence[$idMatiere])
                        && $evaluationSequence[$idMatiere][$idTypeEvaluation]['noteTypeEvaluation'] !== null) {

                        $typeEvaluationNotes[] = $evaluationSequence[$idMatiere][$idTypeEvaluation]['noteTypeEvaluation'];
                        $typeEvaluationNoteMax[] = $evaluationSequence[$idMatiere][$idTypeEvaluation]['noteMaxTypeEvaluation'];
                    }
                }
                if (count($typeEvaluationNotes) > 0){
                    $matiere[$idTypeEvaluation]['noteMaxTypeEvaluation'] = array_sum($typeEvaluationNoteMax) / count($typeEvaluationNoteMax);
                    $matiere[$idTypeEvaluation]['noteTypeEvaluation'] = array_sum($typeEvaluationNotes) / count($typeEvaluationNotes);
                }
                else{
                    $matiere[$idTypeEvaluation]['noteMaxTypeEvaluation'] = null;
                    $matiere[$idTypeEvaluation]['noteTypeEvaluation'] = null;
                }
            }

            $matiereNotes = [];
            $matiereNoteMax = [];
            //Note max matière trimestres et bilan
            foreach ($sequences as $idSequence => $sequence) {
                if (isset($donneeEvaluationEleve["sequence$idSequence"][$idMatiere])) {
                    $matiereSequence = $donneeEvaluationEleve["sequence$idSequence"][$idMatiere];
                    // On récupère tous les sous-éléments qui sont des évaluations
                    $notes = array_filter($matiereSequence, function($val) {
                        return is_array($val)
                            && array_key_exists('noteTypeEvaluation', $val)
                            && $val['noteTypeEvaluation'] !== null;
                    });

                    if (count($notes) > 0){
                        $matiereNoteMax []= array_sum(array_column($notes, 'noteMaxTypeEvaluation'));
                        $matiereNotes []= array_sum(array_column($notes, 'noteTypeEvaluation'));
                    }
                }
            }

            if (count($matiereNotes) > 0){
                $matiere['noteMaxMatiere'] = array_sum($matiereNoteMax) / count($matiereNoteMax);
                $matiere['noteMatiere'] = array_sum($matiereNotes) / count($matiereNotes);
            }
            else{
                $matiere['noteMaxMatiere'] = null;
                $matiere['noteMatiere'] = null;
            }

            //Note max trimestre et bilan
            $idTrimestres = array_unique(array_column($sequences, "idTrimestre"));

            $bilanNotes = [];
            $bilanNotesMax = [];
            $bilanMoyennes = [];
            foreach ($idTrimestres as $idTrimestre) {
                $trimestreNotes = [];
                $trimestreNotesMax = [];
                $trimestreMoyennes = [];
                $filtreSequence = array_filter($sequences, function ($sequence) use ($idTrimestre) {
                    return isset($sequence['idTrimestre']) && $sequence['idTrimestre'] === $idTrimestre;
                });

                foreach ($filtreSequence as $idSequence => $sequence) {
                    if (isset($donneeEvaluationEleve["sequence$idSequence"])) {
                        if ($donneeEvaluationEleve["sequence$idSequence"]['isValid']){
                            if(!isset($donneeEvaluationEleve["trimestre$idTrimestre"]['isValid'])){
                                $donneeEvaluationEleve["trimestre$idTrimestre"]['isValid'] = true;
                            }
                            else if($donneeEvaluationEleve["trimestre$idTrimestre"]['isValid'] === false){
                                $donneeEvaluationEleve["trimestre$idTrimestre"]['isValid'] = true;
                            }

                            if(!isset($donneeEvaluationEleve["bilan"]['isValid'])){
                                $donneeEvaluationEleve["bilan"]['isValid'] = true;
                            }
                            else if($donneeEvaluationEleve["bilan"]['isValid'] === false){
                                $donneeEvaluationEleve["bilan"]['isValid'] = true;
                            }
                        }

                        if ($donneeEvaluationEleve["sequence$idSequence"]['noteSequence'] !== null){

                            $trimestreNotes []= $donneeEvaluationEleve["sequence$idSequence"]['noteSequence'];
                            $trimestreNotesMax []= $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence'];
                            $trimestreMoyennes []= $donneeEvaluationEleve["sequence$idSequence"]['moyenneSequence'];

                            $bilanNotes []= $donneeEvaluationEleve["sequence$idSequence"]['noteSequence'];
                            $bilanNotesMax []= $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence'];
                            $bilanMoyennes []= $donneeEvaluationEleve["sequence$idSequence"]['moyenneSequence'];
                        }
                    }
                }

                if (count($trimestreNotes) > 0){
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['note'] = array_sum($trimestreNotes) / count($trimestreNotes);
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['noteMax'] = array_sum($trimestreNotesMax) / count($trimestreNotesMax);
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['moyenneTrimestre'] = array_sum($trimestreMoyennes) / count($trimestreMoyennes);
                }
                else{
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['note'] = null;
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['noteMax'] = null;
                    $donneeEvaluationEleve["trimestre$idTrimestre"]['moyenneTrimestre'] = null;
                }
            }

            if (count($bilanNotes) > 0){
                $donneeEvaluationEleve["bilan"]['note'] = array_sum($bilanNotes) / count($bilanNotes);
                $donneeEvaluationEleve["bilan"]['noteMax'] = array_sum($bilanNotesMax) / count($bilanNotesMax);
                $donneeEvaluationEleve["bilan"]['moyenne'] = array_sum($bilanMoyennes) / count($bilanMoyennes);
            }
            else{
                $donneeEvaluationEleve["bilan"]['note'] = null;
                $donneeEvaluationEleve["bilan"]['noteMax'] = null;
                $donneeEvaluationEleve["bilan"]['moyenne'] = null;
            }
        }
        return $donneeEvaluationEleve;
    }
    public function calculSommeNoteEtNoteMax($donneeEvaluationEleves, $sequences, $idClasse, $idOptionLevel)
    {
        foreach ($donneeEvaluationEleves as &$donneeEvaluationEleve) {

            foreach ($sequences as $idSequence => $sequence) {
                $donneeEvaluations = $this->listerLesEvaluations($idClasse, $idOptionLevel, $idSequence);

                foreach ($donneeEvaluations as $idEvaluation => $donneeEvaluation) {
                    $donneeTypesEvaluation = $this->listerLesTypesEvaluation($idEvaluation);
                    $matiereId = $donneeEvaluation['matter_id'];
                    $idTrimestre = $sequence['idTrimestre'];

                    // Initialisation sécurisée des trimestres
                    if (!isset($donneeEvaluationEleve["trimestre$idTrimestre"])) {
                        $donneeEvaluationEleve["trimestre$idTrimestre"] = [];
                    }

                    if (!isset($donneeEvaluationEleve["trimestre$idTrimestre"][$matiereId])) {
                        $donneeEvaluationEleve["trimestre$idTrimestre"]["trimestre_id"] = $idTrimestre;
                        $donneeEvaluationEleve["trimestre$idTrimestre"][$matiereId] = $donneeEvaluation;
                    }

                    // Initialisation sécurisée du bilan
                    if (!isset($donneeEvaluationEleve['bilan'])) {
                        $donneeEvaluationEleve['bilan'] = [];
                    }
                    if (!isset($donneeEvaluationEleve['bilan'][$matiereId])) {
                        $donneeEvaluationEleve['bilan'][$matiereId] = $donneeEvaluation;
                    }

                    foreach ($donneeTypesEvaluation as $idTypeEvaluation => $typeEvaluation) {
                        // Trimestre
                        if (
                            !isset($donneeEvaluationEleve["trimestre$idTrimestre"][$matiereId][$idTypeEvaluation])
                            && isset($donneeEvaluationEleve["sequence$idSequence"][$matiereId][$idTypeEvaluation])
                        ) {
                            $donneeEvaluationEleve["trimestre$idTrimestre"][$matiereId][$idTypeEvaluation] =
                                $donneeEvaluationEleve["sequence$idSequence"][$matiereId][$idTypeEvaluation];
                        }

                        // Bilan
                        if (
                            !isset($donneeEvaluationEleve['bilan'][$matiereId][$idTypeEvaluation])
                            && isset($donneeEvaluationEleve["sequence$idSequence"][$matiereId][$idTypeEvaluation])
                        ) {
                            $donneeEvaluationEleve['bilan'][$matiereId][$idTypeEvaluation] =
                                $donneeEvaluationEleve["sequence$idSequence"][$matiereId][$idTypeEvaluation];
                        }
                    }
                }

                if (isset($donneeEvaluationEleve["sequence$idSequence"]) && is_array($donneeEvaluationEleve["sequence$idSequence"])) {
                    foreach ($donneeEvaluationEleve["sequence$idSequence"] as $idMatiere => &$matiere) {
                        if (!is_array($matiere)) continue;

                        $notes = array_filter($matiere, function ($val) {
                            return is_array($val)
                                && array_key_exists('noteTypeEvaluation', $val)
                                && $val['noteTypeEvaluation'] !== null;
                        });

                        if (count($notes) > 0) {
                            $matiere['noteMatiere'] = array_sum(array_column($notes, 'noteTypeEvaluation'));
                            $matiere['noteMaxMatiere'] = array_sum(array_column($notes, 'noteMaxTypeEvaluation'));
                        } else {
                            $matiere['noteMatiere'] = null;
                            $matiere['noteMaxMatiere'] = null;
                        }
                    }

                    $notesMatiere = array_filter($donneeEvaluationEleve["sequence$idSequence"], function ($matiere) {
                        return is_array($matiere)
                            && array_key_exists('noteMatiere', $matiere)
                            && $matiere['noteMatiere'] !== null;
                    });

                    if (count($notesMatiere) > 0) {
                        $donneeEvaluationEleve["sequence$idSequence"]['isValid'] = ((count($notesMatiere) / max(1, count($donneeEvaluations))) * 100) > 70;
                        $donneeEvaluationEleve["sequence$idSequence"]['noteSequence'] = array_sum(array_column($notesMatiere, 'noteMatiere'));
                        $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence'] = array_sum(array_column($notesMatiere, 'noteMaxMatiere'));
                        $donneeEvaluationEleve["sequence$idSequence"]['moyenneSequence'] = $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence'] > 0
                            ? ($donneeEvaluationEleve["sequence$idSequence"]['noteSequence'] / $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence']) * 20
                            : 0;
                    } else {
                        $donneeEvaluationEleve["sequence$idSequence"]['isValid'] = false;
                        $donneeEvaluationEleve["sequence$idSequence"]['noteSequence'] = null;
                        $donneeEvaluationEleve["sequence$idSequence"]['noteMaxSequence'] = null;
                        $donneeEvaluationEleve["sequence$idSequence"]['moyenneSequence'] = null;
                    }
                }
            }

            // Trimestres
            $clesTrimestres = array_filter(array_keys($donneeEvaluationEleve), function ($cle) {
                return strpos($cle, 'trimestre') !== false;
            });

            foreach ($clesTrimestres as $cleTrimestre) {
                if (isset($donneeEvaluationEleve[$cleTrimestre])) {
                    $donneeEvaluationEleve = $this->sommeNoteEtNoteMax($sequences, $donneeEvaluationEleve, $cleTrimestre);
                }
            }

            // Bilan
            if (isset($donneeEvaluationEleve['bilan'])) {
                $donneeEvaluationEleve = $this->sommeNoteEtNoteMax($sequences, $donneeEvaluationEleve, 'bilan');
            }
        }

        return $donneeEvaluationEleves;
    }


    public function calculsStatistique($donneeEvaluationEleves)
    {
        $statistiquesGenerales = [];
        $statistiquesGenerales['class_averages'] = [];

        foreach ($donneeEvaluationEleves as $donneeEvaluationEleve) {
            if (!isset($donneeEvaluationEleve['bilan']['isValid']) || !$donneeEvaluationEleve['bilan']['isValid']) {
                continue;
            }

            // Moyenne générale élève
            if (isset($donneeEvaluationEleve['bilan']['moyenne'])) {
                $statistiquesGenerales['class_averages'][] = $donneeEvaluationEleve['bilan']['moyenne'];
            }

            foreach ($donneeEvaluationEleve['bilan'] as $idMatiere => $matiere) {
                if (!is_numeric($idMatiere) || !is_array($matiere)) continue;

                if (!isset($statistiquesGenerales[$idMatiere])) {
                    $statistiquesGenerales[$idMatiere] = [
                        'matter_code' => $matiere['matter_code'] ?? '',
                        'matter_name' => $matiere['matter_name'] ?? '',
                        'matter_libelle' => $matiere['matter_libelle'] ?? '',
                        'notes' => [],
                        'averages' => []
                    ];
                }

                if (isset($matiere['noteMatiere']) && $matiere['noteMatiere'] !== null) {
                    $statistiquesGenerales[$idMatiere]['notes'][] = $matiere['noteMatiere'];
                    $statistiquesGenerales[$idMatiere]['averages'][] = ($matiere['noteMaxMatiere'] > 0)
                        ? ($matiere['noteMatiere']/$matiere['noteMaxMatiere']) * 20
                        : 0;
                }

                foreach ($matiere as $idTypeEvaluation => $evaluation) {
                    if (!is_numeric($idTypeEvaluation) || !is_array($evaluation)) continue;

                    if (!isset($statistiquesGenerales[$idMatiere][$idTypeEvaluation])) {
                        $statistiquesGenerales[$idMatiere][$idTypeEvaluation] = [
                            'nomTypeEvaluation' => $evaluation['nomTypeEvaluation'] ?? '',
                            'libelleTypeEvaluation' => $evaluation['libelleTypeEvaluation'] ?? '',
                            'notes' => [],
                            'averages' => []
                        ];
                    }

                    if (isset($evaluation['noteTypeEvaluation']) && $evaluation['noteTypeEvaluation'] !== null) {
                        $statistiquesGenerales[$idMatiere][$idTypeEvaluation]['notes'] []= $evaluation['noteTypeEvaluation'];
                        $statistiquesGenerales[$idMatiere][$idTypeEvaluation]['averages'] []= ($evaluation['noteMaxTypeEvaluation'] > 0)
                            ? ($evaluation['noteTypeEvaluation']/$evaluation['noteMaxTypeEvaluation']) * 20
                            : 0;
                    }
                }
            }
        }

        foreach ($statistiquesGenerales as $idMatiere => &$matiere) {
            if (!is_array($matiere) || !isset($matiere['notes'])) continue;

            $count = count($matiere['averages']);
            $passed = count(array_filter($matiere['averages'], function($avg) {return $avg >= 10;}));

            if ($count > 0) {
                $sum = array_sum($matiere['averages']);
                $matiere['average'] = $sum / $count;
                $matiere['success_rate'] = ($passed / $count) * 100;
            } else {
                $matiere['average'] = null;
                $matiere['success_rate'] = null;
            }
            unset($matiere['averages']);
            foreach ($matiere as $idTypeEvaluation => &$typeEvaluation) {
                if (!is_numeric($idTypeEvaluation) || !isset($typeEvaluation['notes'])) continue;

                $countEval = count($typeEvaluation['averages']);
                $passed = count(array_filter($typeEvaluation['averages'], function($avg) {return $avg >= 10;}));
                if ($countEval > 0) {
                    $sumEval = array_sum($typeEvaluation['averages']);
                    $typeEvaluation['average'] = $sumEval / $countEval;
                    $typeEvaluation['success_rate'] = ($passed / $countEval) * 100;
                } else {
                    $typeEvaluation['average'] = null;
                    $typeEvaluation['success_rate'] = null;
                }
                unset($typeEvaluation['averages']);
            }
        }
        unset($matiere, $typeEvaluation);

        // Moyenne générale globale
        $statistiquesGenerales['general_average'] = (count($statistiquesGenerales['class_averages']) > 0)
            ? array_sum($statistiquesGenerales['class_averages']) / count($statistiquesGenerales['class_averages'])
            : null;

        $passed = count(array_filter($statistiquesGenerales['class_averages'], function($avg) {return $avg >= 10;}));
        $statistiquesGenerales['general_success_rate'] = count($statistiquesGenerales['class_averages']) > 0
            ? ($passed / count($statistiquesGenerales['class_averages'])) * 100
            : null;

        // Tri des tableaux par ordre décroissant
        if (isset($statistiquesGenerales['class_averages'])) {
            rsort($statistiquesGenerales['class_averages']);
        }

        foreach ($statistiquesGenerales as $idMatiere => &$matiere) {
            if (!is_array($matiere)) continue;

            if (isset($matiere['notes'])) {
                rsort($matiere['notes']);
            }

            foreach ($matiere as $idTypeEvaluation => &$typeEvaluation) {
                if (!is_numeric($idTypeEvaluation) || !is_array($typeEvaluation)) continue;

                if (isset($typeEvaluation['notes'])) {
                    rsort($typeEvaluation['notes']);
                }
            }
        }
        unset($matiere, $typeEvaluation);

        return $statistiquesGenerales;
    }

    public function matiereParGroupe($statistiqueEvaluations, $idClasse)
    {
        $resultats = $statistiqueEvaluations;

        foreach ($statistiqueEvaluations as $idMatiere => $statistiqueEvaluation) {
            if (ctype_digit((string) $idMatiere)) {
                $groupe = Matter::find((int)$idMatiere)->getGroupForClasse($idClasse);

                if ($groupe) {
                    $groupeId = $groupe->id;

                    if (!isset($resultats[$groupeId])) {
                        $resultats[$groupeId] = [
                            'name' => $groupe->name,
                            'description' => $groupe->description,
                        ];
                    }

                    ksort($statistiqueEvaluation);

                    $resultats[$groupeId][$idMatiere] = $statistiqueEvaluation;
                    unset($resultats[$idMatiere]);
                }
            }
        }

        return $resultats;
    }

    public function formatNomTrimestre($trimestres)
    {
        // Vérifie si le tableau est non null et itère
        foreach ($trimestres ?? [] as $key => $trimestre) {
            // Modifie le nom du trimestre en ajoutant le préfixe et le dernier caractère de 'name'
            $trimestres[$key]['name'] = __('bulletin_primaire.term') . substr($trimestre['name'], -1);
        }

        if ($trimestres){
            // Trie les trimestres par 'name' en ordre décroissant
            usort($trimestres, function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
        }
        else{
            return null;
        }

        return $trimestres;
    }


    public function calculsStatistiquesAnnuels($statistiqueEvaluations, $sequences){
        $bilanAnnuel = [
            "sequences" => [],
            "trimestres" => [],
            "annuel"
        ];

        foreach ($statistiqueEvaluations as $statistiqueEvaluation){
            foreach ($sequences as $idSequence => $sequence) {
                if (!empty(array_filter($bilanAnnuel["sequences"], function($item) use ($idSequence) {
                    return isset($item['id']) && $item['id'] == $idSequence;
                }))) {
                    $bilanAnnuel["sequences"] [] = [
                        "id" => $idSequence,
                        "name" => $sequence["name"]
                    ];
                }
            }

        }

        return $bilanAnnuel;
    }

    /**
     * Calcule la moyenne annuelle pour un élève primaire (pour décision annuelle)
     * Utilise les méthodes existantes du trait primaire
     */
    public function calculateAnnualMoyennePrimaire($idClasse, $idStudent, $idOptionLevel = null)
    {
        // Récupérer toutes les séquences et trimestres
        $sequences = AssessmentType::select('id', 'name')
            ->where('idSection', function ($query) use ($idClasse) {
                $query->select('idSection')
                    ->from('classes')
                    ->where('id', $idClasse);
            })
            ->get()
            ->toArray();

        $idSequences = array_column($sequences, 'id');

        $trimestres = Trimestre::select('id', 'name')
            ->whereIn('id', AssessmentType::whereIn('id', $idSequences)
                ->distinct()
                ->pluck('idTrimestre'))
            ->where('takenIntoAccount', 0)
            ->distinct()
            ->get()
            ->toArray();

        $idTrimestres = array_column($trimestres, 'id');

        // Récupérer les évaluations de l'élève
        $notes = $this->getNoteEvaluation($idClasse, $idSequences, $idOptionLevel, $idStudent);
        $donneesEvaluation = $this->regroupeNoteParEleveParGroupeParMatiere($notes, $idSequences, $idTrimestres);

        if (empty($donneesEvaluation)) {
            return null;
        }

        // Analyser l'évaluation
        $donneesEvaluation = $this->analyserEvaluationEleves($donneesEvaluation, $idSequences, $idClasse, $idOptionLevel);
        $evaluationsValides = $this->sommeDesNotes($donneesEvaluation["evaluationsValides"] ?? [], $idSequences, $idTrimestres);

        if (empty($evaluationsValides) || !isset($evaluationsValides[$idStudent])) {
            return null;
        }

        $eleve = $evaluationsValides[$idStudent];

        // La moyenne générale est déjà calculée dans sommeDesNotes
        $moyenneGenerale = $eleve['moyenneGenerale'] ?? null;

        // Si moyenne générale non calculée, calculer à partir des trimestres
        if ($moyenneGenerale === null) {
            $totalMoyenne = 0;
            $countTrim = 0;

            foreach ($idTrimestres as $trimestreId) {
                $moyKey = "moyTrim$trimestreId";
                $evalKey = "isEvalueTrim$trimestreId";

                if (($eleve[$evalKey] ?? false) && isset($eleve['moyennesTrim'][$moyKey]) && $eleve['moyennesTrim'][$moyKey] !== null) {
                    $totalMoyenne += $eleve['moyennesTrim'][$moyKey];
                    $countTrim++;
                }
            }

            $moyenneGenerale = $countTrim > 0 ? round($totalMoyenne / $countTrim, 2) : null;
        }

        return $moyenneGenerale;
    }
}
?>
