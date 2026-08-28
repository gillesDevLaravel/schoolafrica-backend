<?php

namespace App\Traits;

use App\Models\Assessment;
use App\Models\AssessmentHasAssessmentType;
use App\Models\AssessmentHasTypeEvaluation;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Establishment;
use App\Models\Rating;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use Doctrine\DBAL\Schema\Sequence;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use stdClass;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController as BaseController;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

trait PvUtilitaires{
    //Fonction utilistaires
    //Note pour chaque type d'evaluation
    public function evalTypeNote($idStud, $idSeq, $idEval, $idType){

        $note = Rating::where('idTypeEvaluation', $idType)
            ->where('idAssessment', $idEval)
            ->where('idAssessmentType', $idSeq)
            ->where('idStudent', $idStud)->first();



        $EvalName = TypeEvaluation::select('name')
            ->where('id', $idType)->first()->name;

        if($EvalName == 'Savoir être'){
            //dd(Str::slug($EvalName, "_"));
        }


        $notemax = Assessment::select(Str::slug($EvalName, '_'))
            ->where("id", $idEval)->first()->{Str::slug($EvalName, '_')};


        if($note != null){
            $note->notemax = $notemax;
            $note->nom = $EvalName;
            return $note;
        }
        else{
            return null;
        }

    }

    //notes notes pour toutes les types d'évaluations
    public function seqEvalType($idStud, $idSeq, $idEval){

        $idTypeEvals = AssessmentHasTypeEvaluation::select('type_evaluation_id')
            ->where('assessment_id', $idEval)
            ->get();

        $assessment = Assessment::select("matter.id", "matter.name", "matter.code")
            ->join('matter', 'matter.id', '=', 'assessments.idMatter')
            ->where("assessments.id", $idEval)->first();

        $evalTypeNote = new stdClass();
        $evalTypeNote->matiere = $assessment->name;
        $evalTypeNote->idEval = $assessment->id;
        $evalTypeNote->code = $assessment->code;
        $evalTypeNote->noteObt = 0;
        $evalTypeNote->noteMaxEval = 0;
        $evalTypeNote->totalMaxNotes = 0;
        $evalTypeNote->noteType = [];

        foreach ($idTypeEvals as $idTypeEval) {
            $note = $this->evalTypeNote($idStud, $idSeq, $idEval, $idTypeEval->type_evaluation_id);


            //Si l'utilisateur a été évalué (note !=null)

            if($note != null){
                if($note->value >= 0){ //La condition a changé car un élève évalué peut avoir 0

                    $evalTypeNote->noteObt += $note->value;
                    $evalTypeNote->noteMaxEval += $note->notemax;
                    $evalTypeNote->totalMaxNotes += $note->notemax;
                    $evalTypeNote->noteType[] = $note;
                }
            }
        }

        //return $idTypeEvals;
        return $evalTypeNote;
    }

    //notes  pour toutes les evaluations d'un élève
    public function seqSecEval($idClass, $idOpt, $idSeq, $idStud){

        $idEvaluations = AssessmentHasAssessmentType::join('assessments', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
            ->join('matter', 'matter.id', '=', "assessments.idMatter")
            ->select("assessments_has_assessment_type.assessment_id")
            ->where("assessments.idClasse", $idClass)
            ->where("matter.idOptionLevel", $idOpt)
            ->where("assessments.deleted", 0)
            ->where("assessments_has_assessment_type.assessment_type_id", $idSeq)
            ->orderBy("assessments.id")
            ->get();

        $student = User::select("id", "name", "gender")
            ->where("id", $idStud)->first();

        $seqEvaluation = new stdClass();
        $seqEvaluation->student = $student->name;
        $seqEvaluation->idStud = $student->id;
        $seqEvaluation->sexe = $student->gender;
        $seqEvaluation->noteObt = 0;
        $seqEvaluation->nbrMatEval = 0;
        $seqEvaluation->nbrMatTotal = 0;
        $seqEvaluation->noteMaxEval = 0;
        $seqEvaluation->evaluations = [];

        foreach ($idEvaluations as $idEvaluation) {
            $evaluation = $this->seqEvalType($idStud, $idSeq, $idEvaluation->assessment_id);

            //Si l'utilisateur a été évalué sur au moins un type de cette évaluation alors il a composé
            if($evaluation->noteObt >= 0 && sizeof($evaluation->noteType) > 0){
                $seqEvaluation->noteObt += $evaluation->noteObt;
                $seqEvaluation->noteMaxEval += $evaluation->noteMaxEval;
                $seqEvaluation->evaluations[] = $evaluation;
                $seqEvaluation->nbrMatEval ++;
            }

            $seqEvaluation->nbrMatTotal ++;
        }

        //return $idTypeEvals;
        return $seqEvaluation;
    }


    //notes de la sequence pour tous les eleves d'une classe
    public function classSeq($idClass, $idSec, $idSeq){

        $classStudents = User::select('users.id', "classes.name")
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('classes.deleted', 0)
            ->where('classes.id', $idClass)
            ->where('users.deleted', 0)
            ->orderBy("users.name")
            ->where('roles.id', 8)->get();

        $idTrim = AssessmentType::find($idSeq)['idTrimestre'];

        $studSeqEvaluation = new stdClass();
        $studSeqEvaluation->classe = "";
        $studSeqEvaluation->idSeq = $idSeq;
        $studSeqEvaluation->idTrim = $idTrim;
        $studSeqEvaluation->noteObt = 0;
        $studSeqEvaluation->noteMaxEval = 0;
        $studSeqEvaluation->nbrStudEvaluated = 0;
        $studSeqEvaluation->IdStudEvaluated = [];
        $studSeqEvaluation->stuEvaluations = [];

        //dd($classStudents[0]->name);

        foreach ($classStudents as $classStudent) {
            //Definir le nom de la classe
            if($studSeqEvaluation->classe == ""){
                $studSeqEvaluation->classe = $classStudent->name;
            }

            $stuEval = $this->seqSecEval($idClass, $idSec, $idSeq, $classStudent->id);

            //on s'assure de compter uniquement ceux qui ont été évalués et qui ont eu une note >=0
            if($stuEval->noteObt >= 0 && sizeof($stuEval->evaluations) > 0){
                $studSeqEvaluation->noteObt += $stuEval->noteObt;
                $studSeqEvaluation->noteMaxEval += $stuEval->noteMaxEval;
                $studSeqEvaluation->IdStudEvaluated[] = $classStudent->id;
                $studSeqEvaluation->stuEvaluations[] = $stuEval;
            }
        }





        // //Nom de la sequence
        $sequence = AssessmentType::select("name")
            ->where("id", $idSeq)->first();


        $sequenceEvaluation = new stdClass();
        $sequenceEvaluation->nom = $sequence->name;
        $sequenceEvaluation->classe = $studSeqEvaluation->classe;
        $sequenceEvaluation->noteObt = $studSeqEvaluation->noteObt;
        $sequenceEvaluation->noteMaxEval = 0;
        $sequenceEvaluation->IdStudEvaluated = $studSeqEvaluation->IdStudEvaluated;



        foreach ($studSeqEvaluation->stuEvaluations as $student) {

            if(!isset($sequenceEvaluation->{$student->idStud})){
                $sequenceEvaluation->{$student->idStud} = new stdClass();
                $sequenceEvaluation->{$student->idStud}->student = $student->student;
                $sequenceEvaluation->{$student->idStud}->sexe = $student->sexe;
                $sequenceEvaluation->{$student->idStud}->noteObt = $student->noteObt;
                $sequenceEvaluation->{$student->idStud}->noteMaxEval = $student->noteMaxEval;

                $sequenceEvaluation->{$student->idStud}->nbrMatEval = $student->nbrMatEval;
                $sequenceEvaluation->{$student->idStud}->nbrMatTotal = $student->nbrMatTotal;

                if($student->nbrMatTotal > 0){
                    $sequenceEvaluation->{$student->idStud}->isEvalue = (($student->nbrMatEval / $student->nbrMatTotal) > 0.7);
                }
                else{
                    $sequenceEvaluation->{$student->idStud}->isEvalue = false;
                }

                if($student->noteObt > 0){
                    $sequenceEvaluation->{$student->idStud}->nbrSeqEval = 1;
                }
            }

            foreach ($student->evaluations as $evaluation) {
                if(!isset($sequenceEvaluation->{$student->idStud}->{$evaluation->idEval})){
                    $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval} = new stdClass();
                    $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval}->matiere = $evaluation->matiere;
                    $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval}->noteObt = $evaluation->noteObt;
                    $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval}->noteMaxEval = $evaluation->noteMaxEval;

                    if($evaluation->noteObt !== null){
                        $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval}->nbrEval = 1;
                    }
                    else{
                        $sequenceEvaluation->{$student->idStud}->{$evaluation->idEval}->nbrEval = 0;
                    }
                }
            }
        }

        return [
            "sequentielle" => $sequenceEvaluation,
            "trimestrielle" => $studSeqEvaluation
        ];
    }

    public function classTrimestre($idClass, $idOptionLevel, $idTrim = null){

        if(!$idTrim){
            $idSequences = AssessmentType::select('id', 'name')
                ->where('idSection', function ($query) use ($idClass) {
                    $query->select('idSection')
                        ->from('classes')
                        ->where('id', $idClass);
                })
                ->get();

            $trimestres = Trimestre::select('id', 'name', 'numbering')
                ->whereIn("id", AssessmentType::whereIn("id", array_column($idSequences->toArray(), "id"))
                    ->distinct()
                    ->pluck("idTrimestre"))
                ->where('takenIntoAccount', 0)
                ->distinct()
                ->get()->toArray();

            //Nom du trimestre
            $trimestre = __("bulletin_primaire.annual");
        }else{
            $idSequences = AssessmentType::select('id', "name", 'numbering')
                ->where("idTrimestre", $idTrim)->get();

            $trimestres = Trimestre::select('id', 'name', 'numbering')
                ->whereIn("id", AssessmentType::whereIn("id", array_column($idSequences->toArray(), "id"))
                    ->distinct()
                    ->pluck("idTrimestre"))
                ->where('takenIntoAccount', 0)
                ->distinct()
                ->get()->toArray();

            //Nom du trimestre
            $trimestre = Trimestre::where("id", $idTrim)->value("name");
        }

        $studTrimEvaluation = new stdClass();
        $studTrimEvaluation->classe = "";
        $studTrimEvaluation->seqEvaluations = [];

        foreach ($idSequences as $idSequence) {
            $sequence = $this->classSeq($idClass, $idOptionLevel, $idSequence->id)["trimestrielle"];

            if($sequence->noteObt > 0){
                $studTrimEvaluation->seqEvaluations[] = $sequence;
            }
        }


        $trimEvaluation = new stdClass();
        $trimEvaluation->nom = $trimestre;
        $trimEvaluation->classe = "";
        $trimEvaluation->noteObt = 0;
        $trimEvaluation->noteMaxEval = 0;
        $trimEvaluation->noteMaxEval = 0;
        $trimEvaluation->IdStudEvaluated = [];
        $trimEvaluation->nbrStudEvaluateds = [];



        foreach ($studTrimEvaluation->seqEvaluations as $seqEvaluation) {

            if($trimEvaluation->classe == "" && $seqEvaluation != ""){
                $trimEvaluation->classe = $seqEvaluation->classe;
            }

            if($seqEvaluation->noteObt > 0){
                $trimEvaluation->noteObt += $seqEvaluation->noteObt;
                $trimEvaluation->noteMaxEval += $seqEvaluation->noteMaxEval;
                $trimEvaluation->nbrStudEvaluateds[] = $seqEvaluation->nbrStudEvaluated;
                $trimEvaluation->IdStudEvaluated = array_merge($trimEvaluation->IdStudEvaluated, array_diff($seqEvaluation->IdStudEvaluated, $trimEvaluation->IdStudEvaluated));
            }
            foreach ($seqEvaluation->stuEvaluations as $student) {

                if (($student->nbrMatEval / $student->nbrMatTotal) >= 0.7) {
                    if (!isset($trimEvaluation->{$student->idStud})) {
                        $trimEvaluation->{$student->idStud} = new stdClass();
                        $trimEvaluation->{$student->idStud}->student = $student->student ?? null;
                        $trimEvaluation->{$student->idStud}->sexe = $student->sexe ?? null;
                        $trimEvaluation->{$student->idStud}->noteObt = $student->noteObt ?? null;
                        $trimEvaluation->{$student->idStud}->noteMaxEval = $student->noteMaxEval ?? null;

                        $trimEvaluation->{$student->idStud}->nbrMatEval = $student->nbrMatEval;
                        $trimEvaluation->{$student->idStud}->nbrMatTotal = $student->nbrMatTotal;
                        $trimEvaluation->{$student->idStud}->isEvalue = true;

                        foreach ($trimestres as $trimestre){
                            $key = "moyennesTrim" . $trimestre['id'];
                            $trimEvaluation->{$student->idStud}->$key = [];
                        }

                        if ($student->noteMaxEval != 0 && isset($seqEvaluation->idTrim)) {
                            $key = "moyennesTrim" . $seqEvaluation->idTrim;
                            $trimEvaluation->{$student->idStud}->$key []= ($student->noteObt / $student->noteMaxEval) * 20;
                        }

                        $trimEvaluation->{$student->idStud}->nbrSeqEval = $student->noteObt > 0 ? 1 : 0;
                    } else {
                        $trimEvaluation->{$student->idStud}->noteObt += $student->noteObt;
                        $trimEvaluation->{$student->idStud}->noteMaxEval += $student->noteMaxEval;

                        if ($student->noteObt > 0) {
                            $trimEvaluation->{$student->idStud}->nbrSeqEval++;
                        }

                        if(!$trimEvaluation->{$student->idStud}->isEvalue){
                            $trimEvaluation->{$student->idStud}->isEvalue = true;
                        }

                        if ($student->noteMaxEval != 0 && isset($seqEvaluation->idTrim)) {
                            $key = "moyennesTrim" . $seqEvaluation->idTrim;
                            $trimEvaluation->{$student->idStud}->$key[] = ($student->noteObt / $student->noteMaxEval) * 20;
                        }
                    }

                    foreach ($student->evaluations as $evaluation) {
                        if (!isset($trimEvaluation->{$student->idStud}->{$evaluation->idEval})) {
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval} = new stdClass();
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->matiere = $evaluation->matiere ?? null;
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->noteObt = $evaluation->noteObt ?? 0;
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->noteMaxEval = $evaluation->noteMaxEval ?? 0;
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->nbrEval = $evaluation->noteObt > 0 ? 1 : 0;
                        } else {
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->noteObt += $evaluation->noteObt ?? 0;
                            $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->noteMaxEval += $evaluation->noteMaxEval ?? 0;

                            if ($evaluation->noteObt !== null) {
                                $trimEvaluation->{$student->idStud}->{$evaluation->idEval}->nbrEval++;
                            }
                        }
                    }
                }
                else{
                    // Initialisation par défaut si l'étudiant n'a pas été évalué ou ne remplit pas la condition.
                    if (!isset($trimEvaluation->{$student->idStud})) {
                        $trimEvaluation->{$student->idStud} = new stdClass();
                        $trimEvaluation->{$student->idStud}->student = $student->student ?? null;
                        $trimEvaluation->{$student->idStud}->sexe = $student->sexe ?? null;
                        $trimEvaluation->{$student->idStud}->noteObt = null;
                        $trimEvaluation->{$student->idStud}->noteMaxEval = null;

                        $trimEvaluation->{$student->idStud}->nbrMatEval = 0;
                        $trimEvaluation->{$student->idStud}->nbrMatTotal = 0;
                        $trimEvaluation->{$student->idStud}->isEvalue = false;
                        $trimEvaluation->{$student->idStud}->nbrSeqEval = 0;
                    }
                }
            }

        }

        foreach ($trimEvaluation->IdStudEvaluated as $idStud) {

            $trimEvaluation->{$idStud}->moyenneTotal = [];

            foreach ($trimestres as $trimestre){
                $key = "moyennesTrim" . $trimestre['id'];
                if (!empty($trimEvaluation->{$idStud}->$key)){
                    $moyenneTrimestre = array_sum($trimEvaluation->{$idStud}->$key) / count($trimEvaluation->{$idStud}->$key);
                    $trimEvaluation->{$idStud}->moyenneTotal []= $moyenneTrimestre;
                }
            }

            if (!empty($trimEvaluation->{$idStud}->moyenneTotal)){
                $trimEvaluation->{$idStud}->moyenneTotal = array_sum($trimEvaluation->{$idStud}->moyenneTotal) / count($trimEvaluation->{$idStud}->moyenneTotal);
            }
            else{
                $trimEvaluation->{$idStud}->moyenneTotal = null;
            }
        }

        //return $tabMatiere;
        return $trimEvaluation;
    }

    public function classAnnuelle($idClass, $idOptionLevel, $idTrimestres) {
        $studAnnualEvaluation = new stdClass();
        $studAnnualEvaluation->classe = "";
        $studAnnualEvaluation->trimEvaluations = [];

        $annualEvaluation = new stdClass();
        $annualEvaluation->nom = __("bulletin_primaire.annual");
        $annualEvaluation->classe = "";
        $annualEvaluation->noteObt = 0;
        $annualEvaluation->noteMaxEval = 0;
        $annualEvaluation->IdStudEvaluated = [];
        $annualEvaluation->nbrStudEvaluateds = [];
        $annualEvaluation->trimestres = [];

        $nbrTrimsValid = 0;

        foreach ($idTrimestres as $idTrimestre) {
            $trimEvaluation = $this->classTrimestre($idClass, $idOptionLevel, $idTrimestre);

            if ($trimEvaluation->noteObt > 0) {
                $nbrTrimsValid++;
                $studAnnualEvaluation->trimEvaluations[] = $trimEvaluation;

                // Enregistrer les résultats par trimestre
                $annualEvaluation->trimestres[] = (object)[
                    'id' => $idTrimestre,
                    'nom' => $trimEvaluation->nom,
                    'noteObt' => $trimEvaluation->noteObt,
                    'noteMaxEval' => $trimEvaluation->noteMaxEval,
                ];
            }
        }

        foreach ($studAnnualEvaluation->trimEvaluations as $trimEval) {
            if ($annualEvaluation->classe == "" && $trimEval != "") {
                $annualEvaluation->classe = $trimEval->classe;
            }

            $annualEvaluation->noteObt += $trimEval->noteObt;
            $annualEvaluation->noteMaxEval += $trimEval->noteMaxEval;
            $annualEvaluation->nbrStudEvaluateds[] = $trimEval->nbrStudEvaluateds;
            $annualEvaluation->IdStudEvaluated = array_merge(
                $annualEvaluation->IdStudEvaluated,
                array_diff($trimEval->IdStudEvaluated, $annualEvaluation->IdStudEvaluated)
            );

            foreach ($trimEval as $key => $studentData) {
                if (!is_object($studentData) || !isset($studentData->student)) continue;
                $idStud = $key;

                if (!isset($annualEvaluation->{$idStud})) {
                    $annualEvaluation->{$idStud} = new stdClass();
                    $annualEvaluation->{$idStud}->student = $studentData->student ?? null;
                    $annualEvaluation->{$idStud}->sexe = $studentData->sexe ?? null;
                    $annualEvaluation->{$idStud}->noteObt = $studentData->noteObt ?? 0;
                    $annualEvaluation->{$idStud}->noteMaxEval = $studentData->noteMaxEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrSeqEval = $studentData->nbrSeqEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrMatEval = $studentData->nbrMatEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrMatTotal = $studentData->nbrMatTotal ?? 0;
                    $annualEvaluation->{$idStud}->isEvalue = $studentData->isEvalue ?? false;
                } else {
                    $annualEvaluation->{$idStud}->noteObt += $studentData->noteObt ?? 0;
                    $annualEvaluation->{$idStud}->noteMaxEval += $studentData->noteMaxEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrSeqEval += $studentData->nbrSeqEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrMatEval += $studentData->nbrMatEval ?? 0;
                    $annualEvaluation->{$idStud}->nbrMatTotal += $studentData->nbrMatTotal ?? 0;
                    if ($studentData->isEvalue) {
                        $annualEvaluation->{$idStud}->isEvalue = true;
                    }
                }

                foreach ($studentData as $keyEval => $evalData) {
                    if (!is_object($evalData) || !isset($evalData->matiere)) continue;

                    if (!isset($annualEvaluation->{$idStud}->{$keyEval})) {
                        $annualEvaluation->{$idStud}->{$keyEval} = new stdClass();
                        $annualEvaluation->{$idStud}->{$keyEval}->matiere = $evalData->matiere ?? null;
                        $annualEvaluation->{$idStud}->{$keyEval}->noteObt = $evalData->noteObt ?? 0;
                        $annualEvaluation->{$idStud}->{$keyEval}->noteMaxEval = $evalData->noteMaxEval ?? 0;
                        $annualEvaluation->{$idStud}->{$keyEval}->nbrEval = $evalData->nbrEval ?? 0;
                    } else {
                        $annualEvaluation->{$idStud}->{$keyEval}->noteObt += $evalData->noteObt ?? 0;
                        $annualEvaluation->{$idStud}->{$keyEval}->noteMaxEval += $evalData->noteMaxEval ?? 0;
                        $annualEvaluation->{$idStud}->{$keyEval}->nbrEval += $evalData->nbrEval ?? 0;
                    }
                }
            }
        }

        // Moyennes finales par trimestre
        if ($nbrTrimsValid > 0) {
            foreach ($annualEvaluation as $key => $studentData) {
                if (!is_object($studentData) || !isset($studentData->student)) continue;

                $studentData->noteObt = $studentData->noteObt / $nbrTrimsValid;
                $studentData->noteMaxEval = $studentData->noteMaxEval / $nbrTrimsValid;

                foreach ($studentData as $keyEval => $evalData) {
                    if (!is_object($evalData) || !isset($evalData->matiere)) continue;

                    $evalData->noteObt = $evalData->noteObt / $nbrTrimsValid;
                    $evalData->noteMaxEval = $evalData->noteMaxEval / $nbrTrimsValid;
                }
            }

            $annualEvaluation->noteObt = $annualEvaluation->noteObt / $nbrTrimsValid;
            $annualEvaluation->noteMaxEval = $annualEvaluation->noteMaxEval / $nbrTrimsValid;
        }

        return $annualEvaluation;
    }


    public function contraintes($request){
        //On verifi que toutes les conditions necessaire pour générer le pv sont réunies

        //contraintes sur idOptionLevel(verifier que des matieres ont été définits)
        $idEvaluations = AssessmentHasAssessmentType::join('assessments', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
            ->join('matter', 'matter.id', '=', "assessments.idMatter")
            ->select("assessments_has_assessment_type.assessment_id", "matter.idOptionLevel")
            ->where("assessments.idClasse", $request["idClasse"])
            ->orderBy("assessments.id")
            ->get();


        if(sizeof($idEvaluations) > 0){

            foreach($idEvaluations as $idEvaluation){
                if($idEvaluation->idOptionLevel == null || $idEvaluation->idOptionLevel == $request["idOptionLevel"]){
                    return true;
                }
            }

            return "Veuillez fournir l'id de l'option pour cette classe";
        }

        return true;
    }

    public function genererDocuments($data, $vue, $filename = null){
        $dompdf = new Dompdf();

        // Récupérer la vue
        $view = View::make($vue)->with($data);

        // Récupérer le contenu de la vue
        $html = $view->render();

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optionnel) Définir la taille et l'orientation du papier
        $dompdf->setPaper('A4', 'landscape');

        // Exécuter le rendu du PDF
        $dompdf->render();

        if (is_null($filename)) {
            $filename = "pv-". Str::slug($data["classe"]->name) .".pdf";
        } else {
            if (!Str::endsWith(strtolower($filename), '.pdf')) {
                $filename = $filename . ".pdf";
            }
        }

        $baseName = pathinfo($filename, PATHINFO_FILENAME);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $counter = 1;
        $finalFilename = $filename;
        while (file_exists(public_path("pdfs/" . $finalFilename))) {
            $finalFilename = $baseName . "-" . $counter . "." . $ext;
            $counter++;
        }
        $filename = $finalFilename;

        file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

        return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de {$data["classe"]->name} avec évaluations mensuelle");
    }

    public function getCodeCouleur(){
        $establishment = Establishment::first();
        $code_couleurs = explode(";", $establishment->code_couleur);

        return $code_couleurs;
    }

    public function getAppreciation($moyenneStudents, $forMaternelle = false){
        $legend_of_grade = [
            'nye' => count(array_filter($moyenneStudents, function($moyenneStud) use ($forMaternelle) {
                if ($forMaternelle){
                    return $moyenneStud < 7.5;
                }else{
                    return $moyenneStud < 10;
                }
            })),
            'nye_color' => "db0b32",
            'ae' => count(array_filter($moyenneStudents, function($moyenneStud) use ($forMaternelle) {
                if ($forMaternelle){
                    return $moyenneStud >= 7.5 && $moyenneStud < 12.5;
                }else{
                    return $moyenneStud >= 10 && $moyenneStud < 15;
                }
            })),
            'ae_color' => "fdaa3e",
            'me' => count(array_filter($moyenneStudents, function($moyenneStud) use ($forMaternelle) {
                if ($forMaternelle){
                    return $moyenneStud >= 12.5 && $moyenneStud < 17.5;
                }else{
                    return $moyenneStud >= 15 && $moyenneStud < 18;
                }
            })),
            'me_color' => "0080ff",
            'abe' => count(array_filter($moyenneStudents, function($moyenneStud) use ($forMaternelle) {
                if ($forMaternelle){
                    return $moyenneStud >= 17.5   ;
                }else{
                    return $moyenneStud >= 18;
                }
            })),
            'abe_color' => "008000",
        ];

        return $legend_of_grade;
    }


    public function ordreMoyenne($tab){
        $newId=  [];
        $newMoy =  [];

        foreach($tab as $t){
            $newId[] = $t['idStud'];
            $newMoy[] = $t['moy'];
        }

        return [
            'ids' => $newId,
            'moys' => $newMoy
        ];
    }

    public function getStatistiques($evaluation, $idEleves, $sort = null, $forMaternelle = false){
        $moyennes = [];
        $moyennesNonEval = [];


        foreach($idEleves as $idEleve) {
            if($evaluation->{$idEleve}->isEvalue){
                // Vérifiez si la note maximale d'évaluation est supérieure à 0
                if ($evaluation->{$idEleve}->noteMaxEval > 0) {
                    $moyennes[] = [
                        'moy' => $evaluation->{$idEleve}->moyenneTotal ?? ($evaluation->{$idEleve}->noteObt / $evaluation->{$idEleve}->noteMaxEval) * 20,
                        'idStud' => $idEleve,
                        'nomStud' => $evaluation->{$idEleve}->student
                    ];
                }
            }
            else{
                // Vérifiez si la note maximale d'évaluation est supérieure à 0
                if ($evaluation->{$idEleve}->noteMaxEval > 0) {
                    $moyennesNonEval[] = [
                        'moy' => $evaluation->{$idEleve}->moyenneTotal ?? ($evaluation->{$idEleve}->noteObt / $evaluation->{$idEleve}->noteMaxEval) * 20,
                        'idStud' => $idEleve,
                        'nomStud' => $evaluation->{$idEleve}->student
                    ];
                }
            }
        }

        //Nbr nouveaux
        $evaluation->nouveaux = 0;
        $evaluation->nouvelles = 0;

        //nbr redoublants
        $evaluation->redoublants = 0;
        $evaluation->redoublantes = 0;

        //nbr redoublants
        $evaluation->nbrGarcons = 0;
        $evaluation->nbrFilles = 0;





        $eleves = User::select('users.id', "classes.name", "users.gender", "users.situation", 'repeater')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->join('classes', 'classes.id', "=", "users.idClasse")
            ->where('classes.id', $evaluation->idClasse)
            ->where('classes.deleted', 0)
            ->where('users.deleted', 0)
            ->orderBy("users.name")
            ->where('roles.id', 8)->get();


        // Calculer les compteurs
        foreach ($eleves as $eleve) {
            $isFemale = strtolower(substr($eleve->gender, 0, 1)) == 'f';


            if($isFemale){
                $evaluation->nbrFilles ++;
            }
            else{
                $evaluation->nbrGarcons ++;
            }

            if ($eleve->repeater) { // Redoublants
                if ($isFemale) {
                    $evaluation->redoublantes += 1;
                } else {
                    $evaluation->redoublants += 1;
                }
            }

            if ($eleve->situation == "new"){ // Nouveaux
                if ($isFemale) {
                    $evaluation->nouvelles += 1;
                } else {
                    $evaluation->nouveaux += 1;
                }
            }
        }


        //On calcule la moyenne générale
        if(count($moyennes) > 0){
            $moyenneGenerale = array_sum(array_column($moyennes, "moy"))/count($moyennes);
        }
        else{
            $moyenneGenerale = null;
        }


        // Tri par ordre de mérite décroissant (par 'moy') car peu imporete l'ordre
        //les rangs sont pris en compte
        $moyennes = collect($moyennes)->sortByDesc('moy')->values()->all();
        $moyennesNonEval = collect($moyennesNonEval)->sortByDesc('moy')->values()->all();
        $ordre = collect(array_merge($moyennes, $moyennesNonEval));

        if (is_null($sort) || $sort != "merit") {
            //Si on ne precise pas d'ordre
            $ordre = $ordre->sortBy('nomStud')->values()->all();

        }


        $evaluation->IdStudEvaluated = $this->ordreMoyenne($ordre)['ids'];
        $moyennes = $this->ordreMoyenne(collect(array_merge($moyennes, $moyennesNonEval)))["moys"];;


        return [
            "evaluations" => $evaluation,
            "moyenneGenerale" => ($moyenneGenerale),
            "moyennes" => $moyennes,
            "legend_of_grade" => $this->getAppreciation($moyennes, $forMaternelle)
        ];
    }


    public function listeInsolvables($request, $idSchool, $idSection){
        $requestDataX = $request->validated();
        $requestDataX['idSchool'] = $idSchool;
        if(!isset($requestDataX["idAssessmentType"]) && isset($requestDataX["idTrimestre"])){
            //pour les bulletins trimestriels
            $sequences = AssessmentType::where("idTrimestre", $requestDataX["idTrimestre"])->get();
            $request["idAssessmentType"] = $sequences[(sizeof($sequences) - 1)]->id;
        }
        $sequences = AssessmentType::where("idSection", $idSection)->get();

        //trouver les tranches qu'il faut avoir payer pour générer le bulletin
        if(sizeof($sequences) >= 2){

            foreach(array_slice(($sequences)->toArray(), 0, 2) as $sequence){
                if($sequence['id'] == $request["idAssessmentType"]){
                    $requestDataX['nameTranche'] = 2;
                }
            }
        }

        $data = $this->pensionUserService->insolvablePensionUser($requestDataX)['data'];
        if(isset($requestDataX['nameTranche'])){
            $nomTranche = "tranche ". $requestDataX['nameTranche'];
        }
        else{
            $nomTranche = "pension";
        }

        return [
            "data"=> $data,
            "Tranche"=> $nomTranche
        ];
    }

    public function isSolvable($listInsolvables, $idUser){
        foreach($listInsolvables['data'] as $insolvable){

            if($insolvable['id'] == $idUser){
                return false;
            }
        }

        return true;
    }
    public function getRole(){
        $idUser = Auth::user()->id;

        $role = User::select('roles.id','roles.name')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('users.id', $idUser)->first();


        return $role;
    }
}
