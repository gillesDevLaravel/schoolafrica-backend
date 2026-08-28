<?php

namespace App\Traits;

use App\Models\Absence;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Event;
use App\Models\Homework;
use App\Models\MatterGroup;
use App\Models\Notification;
use App\Models\Rating;
use App\Models\Sanction;
use App\Models\School;
use App\Models\Task;
use App\Models\TeacherObservation;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use Dompdf\Dompdf;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Exception;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;

trait DataBulletinsTrait
{
    //affiche les notes de 1 à 4
    public function bulletinMaternelleGeneral(array $request)
    {
        try{
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $idOptionLevel = $request['$idOptionLevel'] ?? null;

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.city as city','users.photo as photo',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->orderBy("users.name", "asc")
                ->get();
            $tabNote['user'] = $entete;

            $effectifClasse = count($entete);
            $tabNote['effectifClasse'] = $effectifClasse;

            $total_moy_eleve = null;
            $moyClasse = null;
            //$total_matiere = null;
            for ($i=0; $i < $entete->count(); $i++) {
                $trimestre = Trimestre::select('trimestre.id as id','trimestre.name as name')
                    ->join('assessment_type','assessment_type.idTrimestre','=','trimestre.id')
                    ->where('trimestre.idSchool',$request['idSchool'])
                    ->where('trimestre.idSection',$request['idSection'])
                    ->where('assessment_type.id',$request['idAssessmentType'])
                    ->get();

                $tabNote['user'][$i]['trimestre'] = $trimestre;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                $totalCoef1 = null ;
                $totalCoef2 = null ;
                $totalCoef3 = null ;
                $totalCoef4 = null ;
                $totalCoef5 = null ;
                $totalCoef6 = null ;
                $totaltermAv = null ;
                $totalNoteCoef = null;

                $moyseq1 = null;
                $moyseq2 = null;
                $moyseq3 = null;
                $moyseq4 = null;
                $moyseq5 = null;
                $moyseq6 = null;


                $assessmentType = AssessmentType::select('id','name')
//                    ->where('idSchool',$request['idSchool'])
//                    ->where('idSection',$request['idSection'])
//                    ->where('idTrimestre',$trimestre[0]['id'])
                    ->where('id',$request['idAssessmentType'])
                    ->get();

                if (!$assessmentType->isEmpty()) {
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                    $totalSequence1 = null;
                    $totalSequence2 = null;
                    $totalSequence3 = null;
                    $totalSequence4 = null;
                    $totalSequence5 = null;
                    $totalSequence6 = null;
                    $total = null;
                    $totalSeq = null;
                    $totalCoefSeq = null;
                    $coefficient = null;

                    //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                    //$total_matiere = $total_matiere + 1;
                    $rating_exits = null;
                    $matterGroup = null;

                    if(!empty($request['idOptionLevel'])){
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                            ->orderBy("id", "asc")
                            ->get();
                    }else{
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                            ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->orderBy("id", "asc")
                            ->get();
                    }

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'] = $matterGroup;

                    $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                        ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                        ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                        ->join('ratings','ratings.idAssessment','=','assessments.id')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter','matter.id','=','assessments.idMatter')
                                ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                                ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                                ->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->where('assessment_type.id', $assessmentType[0]['id'])
                        ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                        ->whereNotNull('ratings.value')
                        ->get();

                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case "1":
                            $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "2":
                            $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "3":
                            $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "4":
                            $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "5":
                            $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "6":
                            $totalCoef6 = $coefficientSum[0]['coefficient_sum'];
                            break;
                    }

                    for ($x=0; $x < $matterGroup->count(); $x++) {
//
                        $totalNoteCoefMatterGroup1 = null;
                        $MatterGroupId = null;
                        $totalCoefMatterGroupAssessment = null;
                        $totalNoteCoefMatterGroup2 = null;
                        $totalCoefMatterGroup1 = null;
                        $totalCoefMatterGroup2 = null;
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->where('matter_group.id',$matterGroup[$x]['id'])
                            ->where('assessment_type.id',$assessmentType[0]['id'])
                            ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                                $query->where('matter_group.idOptionLevel', $idOptionLevel);
                            })
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'] = $assessment;
                        $total = null;

                        for ($n=0; $n < $assessment->count(); $n++) {

                            $teachername = User::select('users.name as teacherName')
                                ->join('assessments','assessments.idTeacher','=','users.id')
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->get();

                            $ratings = Rating::select(
                                'ratings.value as value',
                                'ratings.observation as observation',
                                'ratings.notemax as notemax',
                                'assessment_type.name as assessmentName',
                                'matter.name as nameMatter',
                                'coefficients.value as coefficient',
                                DB::raw('(ratings.value * coefficients.value) as noteCoef')
                            )
                                ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
                                ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                ->join('matter', 'matter.id', '=', 'ratings.idMatter')
                                ->join('coefficients','assessments.idCoeficient','=','coefficients.id')
                                ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->where('assessment_type.id',$assessmentType[0]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                ->first();


                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                            if(!empty($teachername)){
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                            }

                            if(!empty($ratings['coefficient'])){
                                $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;
                                $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                                        case "1":
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case "2":
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case "3":
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case "4":
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case "5":
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case "6":
                                            $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                    $MatterGroupId = $matterGroup[$x]['id'] ;
                                    switch ($matterGroup[$x]['id']) {
                                        case $MatterGroupId:
                                            $totalNoteCoefMatterGroup1 = $totalNoteCoefMatterGroup1 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup1 = $totalCoefMatterGroup1 + $ratings['coefficient'];
                                            break;
                                        /*
                                        case 2:
                                            $totalNoteCoefMatterGroup2 = $totalNoteCoefMatterGroup2 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup2 = $totalCoefMatterGroup2 + $ratings['coefficient'];
                                            break;
                                            */

                                        default:
                                            # code...
                                            break;
                                    }
                                }

                            }

                            $totaltermAv = $totaltermAv + $total;
                        }

                        $MatterGroupId = $matterGroup[$x]['id'];

                        switch ($matterGroup[$x]['id']) {
                            case $MatterGroupId:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                $cleanNumber = @str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                $totalSeq = $totalSeq + $total;
                                $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                break;
                            /*
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup2;
                                $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup2 / $totalCoefMatterGroup2,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                break;
                                */
                        }
                    }//MatterGroup boucle fin*******************************************************************

                    if(!empty($rating_exits) && $rating_exits != 0){
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                        //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                    }else{
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['total_trimestre'] = null;
                    }

                    //} *************************************************************** ici ***********************************************
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequence'] = $totalSeq;

                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case '1':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence1;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq1 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq1;
                            }
                            break;
                        case '2':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence2;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq2 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq2;
                            }
                            break;
                        case '3':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence3;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq3 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq3;
                            }
                            break;
                        case '4':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence4;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq4 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq4;
                            }
                            break;
                        case '5':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence5;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq5 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq5;
                            }
                            break;
                        case '6':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceNoteCoef'] = $totalSequence6;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][0]['moyenne'] = floatval($cleanNumber);
                                $moyseq6 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq6;
                            }
                            break;
                    }

                    switch (mb_substr($assessmentType[0]['name'], -1)) {
                        case '1':
                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            break;
                        case '2':
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            break;
                        case '3':
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            break;
                        case '4':
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            break;
                        case '5':
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            break;
                        case '6':
                            $totalSequence6User = $totalSequence6User + $totalSequence6;
                            break;
                    }

                    $santion = Sanction::where('idUser',$entete[$i]['id'])->count();

                    $absence = Absence::where('idStudent',$entete[$i]['id'])->count();

                    //bonne moyenne 1

                    switch (mb_substr($trimestre[0]['name'], -1)) {
                        case '1':
                            if($totalCoef1 != 0 && $totalCoef2 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef1 + $totalCoef2)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence1User / $totalCoef1)+($totalSequence2User / $totalCoef2))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '2':
                            if($totalCoef3 != 0 && $totalCoef4 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef3 + $totalCoef4)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                                if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq3 + $moyseq4)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '3':
                            if($totalCoef5 != 0 && $totalCoef6 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef5 + $totalCoef6)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence5User + $totalSequence6User)/2;
                                if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence5User / $totalCoef5)+($totalSequence6User / $totalCoef6))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq5 + $moyseq6)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;
                    }

                    $tabNote['user'][$i]['trimestre'][0]['totalAbs'] = $absence;
                    $tabNote['user'][$i]['trimestre'][0]['totalPunishment'] = $santion;
                }
            }

            if($effectifClasse != 0){
                $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format($moyClasse / $effectifClasse,2)));
            }else{
                $tabNote['moyenneClasse'] = null;
            }

            /******************************************************Debut calcul rang ********************************************/

            //calculer le rang par sequence

            // Vous pouvez utiliser collect pour créer une collection Laravel
            $collection = collect($tabNote['user']);

            // Ensuite, vous pouvez trier la collection en fonction de la moyenne pour un assessmentType spécifique
            $assessmentIndex = 0; // Indice de l'assessmentType que vous voulez trier
            $trimestreIndex = 0; // Indice du trimestre que vous voulez trier

            $sortedCollection = $collection->sortByDesc(function ($user) {
                return $user['trimestre'][0]['assessmentType'][0]['moyenne'];
            });

            // Vous pouvez également obtenir le rang en utilisant la méthode search
            $rankedCollection = $sortedCollection->values()->map(function ($user, $index) {
                $user['trimestre'][0]['assessmentType'][0]['rang'] = $index + 1;
                return $user;
            });

            // Maintenant, $rankedCollection contient le tableau avec les rangs assignés
            // Vous pouvez accéder aux informations comme suit :
            foreach ($rankedCollection as $user) {
                $moyenne = $user['trimestre'][0]['assessmentType'][0]['moyenne'];
                $rang = $user['trimestre'][0]['assessmentType'][0]['rang'];

                // Utilisation de $moyenne et $rang
                // Par exemple, echo "Moyenne: $moyenne, Rang: $rang";
            }

            /******************************************************fin calcul rang ********************************************/

            return $tabNote;
//            return $this->sendResponse($tabNote, 'Bulletins');
        }
        catch (\Throwable $th){
            throw new Exception($th->getMessage());
//            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    // affiche les notes /20 en images
    public function bulletinMaternelleJuniors(array $request){
        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.city as city','users.photo as photo',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->where('ratings.idAssessmentType', $request['idAssessmentType'])
                ->where('users.idClasse',$request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->orderBy("users.name", "asc")
                ->get();

            $tabNote['user'] = $entete;

            $effectifClasse = count($entete);

            $tabNote['effectifClasse'] = $effectifClasse;

            for ($i=0; $i < $entete->count(); $i++) {

                // le nombre total d'évaluations que l'élève a composé..
                // on s'en servira(si >=70% du total des évaluations) pour savoir si il doit être inclus pour calculer la moyenne générale de sa classe
                // ou même si il doit avoir un rang
                $totalNbreEvaluationsComposes = 0;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->where('matter_group.idOptionLevel', $idOptionLevel);
                    })
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                if($matterGroup->count() == 0){
                    throw new \Exception("Aucun groupe de matière trouvé");
                }

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
//                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
//                            $query->where('matter.idOptionLevel', $idOptionLevel);
//                        })
                        ->orderBy("id", "asc")
                        ->get();

                    //TODO: On change la valeur de notemax pour attribuer la somme sdes types_eval où l'enfant a effectivement composé
                    foreach ($assessment as $key_tmp_assessment => $assess) {
                        $tmp_te_s = $assess->typeEvaluations;
                        $final_notemax_for_assessment = 0;

                        // On va check si l'utilsiateur a une note sur ce type_eval pour cette évaluation
                        foreach ($tmp_te_s as $tmp_type){
                            $studentHasNote = Rating::join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_type_id','=','ratings.idAssessmentType')
                                ->where('ratings.idClasse',$request['idClasse'])
                                ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                                ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                ->where('ratings.idTypeEvaluation', $tmp_type->id)
                                ->where('ratings.idAssessment', $assess['id'])
                                ->count();

                            if($studentHasNote != 0) $final_notemax_for_assessment += $assess[Str::slug($tmp_type->name, "_")];
                        }

                        $assessment[$key_tmp_assessment]['notemax'] = $final_notemax_for_assessment;
                    }

                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

                    // TODO: On va plutôt avoir la somme des notemax des matières pour lesquelles l'élèves a effectivement composé
                    $total_notemax_assessment = 0;

                    // on récupère toutes les évaluations où le type ci a composé
                    $evals_compose = Rating::select('idAssessment', 'idTypeEvaluation' ,'te.name as te_name', 'a.*')
                        ->join('type_evaluation as te', 'te.id','=','idTypeEvaluation')
                        ->join('assessments as a', 'a.id','=','ratings.idAssessment')
                        ->join('matter','matter.id','=','ratings.idMatter')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->where([
                            'idStudent' => $tabNote['user'][$i]['id'],
                            'idAssessmentType' => $request['idAssessmentType']
                        ])
                        ->get();

                    // on somme les notes des types_evaluations (pas des notemax)
                    foreach ($evals_compose as $item) {
                        $tmp_te_name = $item['te_name'];
                        $total_notemax_assessment += $item[Str::slug($tmp_te_name, '_')];
                    }
//
//                    $total_notemax_assessment = Assessment::select(DB::raw('SUM(notemax) as total_notemax'))
//                        ->from(function (Builder $query) use ($request, $tabNote, $i, $idOptionLevel) {
//                            $query->select('a.notemax', 'a.id')
//                                ->from('ratings AS r')
//                                ->join('assessments AS a', 'a.id', '=', 'r.idAssessment')
//                                ->where('r.idClasse', $request['idClasse'])
//                                ->where('r.idStudent', $tabNote['user'][$i]['id'])
//                                ->where('r.idAssessmentType', $request['idAssessmentType'])
//                                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
//                                    $query
//                                        ->join('matter', 'matter.id', '=', 'r.idMatter')
//                                        ->where('matter.idOptionLevel', $idOptionLevel);
//                                })
//                                ->groupBy('a.id', 'a.notemax');
//                        })
//                        ->value('total_notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        // On veut compter le nombre d'évaluations que cet élève a composé.
                        // Donc si il existe une note (sur table ratings) pour ce $k évaluation, on compte l'évaluation comme composé
                        $hasStudentWriteAssessment = Rating::where('idAssessment', $assessment[$k]['id'])
                            ->where('idStudent', $tabNote['user'][$i]['id'])
                            ->where('idAssessmentType', $request['idAssessmentType'])
                            ->count();

                        if($hasStudentWriteAssessment != 0){
                            $totalNbreEvaluationsComposes++;
                        }
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','type_evaluation.libelle','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;
                        $totalSequence7 = null;
                        $totalSequence8 = null;

                        $total_note_assessment1 = null;
                        $total_note_assessment2 = null;
                        $total_note_assessment3 = null;
                        $total_note_assessment4 = null;
                        $total_note_assessment5 = null;
                        $total_note_assessment6 = null;
                        $total_note_assessment7 = null;
                        $total_note_assessment8 = null;
                        //$total_notemax_assessment = $total_notemax_assessment + $assessment[$k]['notemax'];

                        for ($l=0; $l < $typeEvaluation->count(); $l++) {
//                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            $typeEvaluation[$l]['value'] = $assessment[$k][Str::slug($typeEvaluation[$l]['name'], "_")];

                            //gérer l'affichage des points devant le type_evaluation
//                            if(!empty($assessment[$k]['oral'])){
//                                if($typeEvaluation[$l]['name'] == "Oral")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
//                            }
////
//                            if(!empty($assessment[$k]['orale'])){
//                                if($typeEvaluation[$l]['name'] == "Orale")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['orale'];
//                            }
//
//                            if(!empty($assessment[$k]['ecrit'])){
//                                if($typeEvaluation[$l]['name'] == "Ecrit")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['ecrit'];
//                            }
//
//                            if(!empty($assessment[$k]['written'])){
//                                if($typeEvaluation[$l]['name'] == "Written")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['written'];
//                            }
//
//                            if(!empty($assessment[$k]['attitude'])){
//                                if($typeEvaluation[$l]['name'] == "Attitude")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['attitude'];
//                            }
//
//                            if(!empty($assessment[$k]['savoir_etre'])){
//                                if($typeEvaluation[$l]['name'] == "Savoir être")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['savoir_etre'];
//                            }
//
//                            if(!empty($assessment[$k]['pratical'])){
//                                if($typeEvaluation[$l]['name'] == "Pratical")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratical'];
//                            }
//
//                            if(!empty($assessment[$k]['pratique'])){
//                                if($typeEvaluation[$l]['name'] == "Pratique")
//                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratique'];
//                            }

                            $rating_exits = null;
                            for ($m=0; $m < $trimestre->count(); $m++) {
                                $assessmentType = AssessmentType::select('id','name')
                                    ->where('idSchool',$request['idSchool'])
                                    ->where('idSection',$request['idSection'])
                                    ->where('idTrimestre',$trimestre[$m]['id'])
                                    ->get();
//
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------
//                                    // On détermine le rang de cet étudiant sur cette évaluation précise
                                    $ratings['rang'] = (isset($ratings->value))
                                        ? Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->join('users', 'users.id','=','ratings.idStudent')
                                            ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idClasse',$request['idClasse'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->where('ratings.value','>', $ratings->value)
                                            ->count() + 1
                                        : "-";
//
//                                    // On détermine le nombre de personnes ayant réussi (ils ont une note >= à note/2) pour cette évaluation précise (oral, écrit, pratique, ...)
                                    $tmp_note = Str::slug($typeEvaluation[$l]['name'], '_');
                                    $nbreSucceed = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->where('ratings.value','>=', $assessment[$k][$tmp_note]/2)
                                        ->count();

                                    // Pour calculer la moyenne sur le typeEvaluation de cette matière, on divise par le nombre d'étudiants qui ont effectivement composé
                                    // (qui peut être inférieur à l'effectif réel de la classe)
                                    $effectifAssessmentTypeEvaluation = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                            'idTypeEvaluation' => $typeEvaluation[$l]['id']
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    $ratings['success_percentage'] = ($effectifAssessmentTypeEvaluation != 0)
                                        ? round(($nbreSucceed * 100) / $effectifAssessmentTypeEvaluation, 2)
                                        : 0;
//
                                    // On détermine la moyenne générale de la classe sur cette évaluation
                                    $gen_avg = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->sum('ratings.value');

                                    $ratings['g_avg'] = ($effectifAssessmentTypeEvaluation !=0)
                                        ? number_format($gen_avg / $effectifAssessmentTypeEvaluation, 2) //round($gen_avg / $effectifClasse, 2);
                                        : 0;

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    // La note de l'élève sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $studentNoteOnAssessment = Rating::select('ratings.value as value')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->sum('ratings.value');

                                    // Les notes de tous les élèves sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $classeNotesOnAssesment = Rating::where('ratings.idClasse', $request['idClasse'])
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('idAssessmentType', $assessmentType[$n]['id'])
                                        ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                        ->groupBy('idStudent')
                                        ->selectRaw('SUM(value) as note')
                                        ->pluck('note')
                                        ->toArray();

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['note_on_assessment'] = $studentNoteOnAssessment;
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['rank_on_assessment'] = count(array_filter($classeNotesOnAssesment, function($note) use ($studentNoteOnAssessment) {
                                            return $note > $studentNoteOnAssessment;
                                        })) + 1;

                                    $notemax = $assessment[$k]['notemax'];

                                    // On détermine le nombre d'élèves ayant composé cette évaluation
                                    $effectifAssessment = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    // On compte le nombre d'élèves ayant la moyenne sur cette évaluation
                                    $nbreSuccessOnAssessment = count(array_filter($classeNotesOnAssesment, function($note) use ($notemax) {
                                        return $note >= ($notemax/2);
                                    }));

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['nbreSuccessOnAssessment'] = ($nbreSuccessOnAssessment != 0 && $effectifAssessment!=0)
                                        ? ($nbreSuccessOnAssessment*100) / ($effectifAssessment) ?? 1
                                        : 0;
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch (mb_substr($assessmentType[$n]['name'], -1)) {
//                                            switch ($assessmentType[$n]['id']) {
                                                case "1":
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case "2":
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case "3":
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case "4":
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case "5":
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case "6":
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case "7":
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case "8":
                                                    $totalSequence8 = $totalSequence8 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment8 = $total_note_assessment8 + $ratings['value'];
                                                    }
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
                                }

                                if($rating_exits == 3){
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }
                            }
                        }

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
                        $trimestre1 = null ;
                        $trimestre2 = null ;
                        $trimestre3 = null ;
                        if(empty($totalSequence1) || empty($totalSequence2) || empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,null);
                        }else if(!empty($totalSequence1) && !empty($totalSequence2) && !empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,$totalSequence1+$totalSequence2+$totalSequence3);
                        }

                        if(empty($totalSequence4) || empty($totalSequence5) || empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,null);
                        }else if(!empty($totalSequence41) && !empty($totalSequence5) && !empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,$totalSequence4+$totalSequence5+$totalSequence6);
                        }

                        if(empty($totalSequence7) || empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,null);
                        }else if(!empty($totalSequence7) && !empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,$totalSequence7+$totalSequence8);
                        }

                        $sommeTrimestre = array($trimestre1,$trimestre2,$trimestre3);
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;
                        $totalSequence7User = $totalSequence7User + $totalSequence7;
                        $totalSequence8User = $totalSequence8User + $totalSequence8;
                    }
                }

//                if($total_notemax_assessment != 0){
                $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment;
                $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;
                $tabNote['user'][$i]['moyenneSequence1'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence1User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence2'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence2User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence3'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence3User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence4'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence4User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence5'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence5User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence6'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence6User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence7'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence7User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                $tabNote['user'][$i]['moyenneSequence8'] = ($total_notemax_assessment!=0) ? number_format((($totalSequence8User * 20)) / $total_notemax_assessment, 2) : 0; //number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
//                }
                $tabNote['user'][$i]['totalNbreEvaluationsComposes'] = $totalNbreEvaluationsComposes;
            }

            /******************************************************Debut calcul rang ********************************************/

            //TODO: On compte le nombre d'évaluations que chaque enfant doit effectuer...
            // PS: si après il a composé -70% de toutes les évaluations,
            // (1) on ne va pas l'inclure dans le calcul de la moyenne générale de la classe
            // (2) on ne l'inclut pas dans les moyennes et donc il n'aura pas de rang comme les autres
            $nbreTotalEvaluations = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                ->join('matter','matter.id','=','assessments.idMatter')
                ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                ->where('assessments.idSchool',$request['idSchool'])
                ->where('assessments.idSection',$request['idSection'])
                ->where('assessments.idClasse',$request['idClasse'])
                ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->count();

            // Tableau des séquences
            $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

            // Tableau associatif pour stocker les rangs pour chaque séquence
            $rangsParSequence = [];

            $moyennesGenerales = []; // moyennes générales de la classe

            // Boucle sur chaque séquence
            foreach ($sequences as $sequence) {
                // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                $moyennes = [];
                foreach ($tabNote['user'] as $userId => $user) {
                    $totalNbreEvaluationsComposes = $user['totalNbreEvaluationsComposes'];

                    if(($totalNbreEvaluationsComposes*100 / $nbreTotalEvaluations) >= 70){
                        $moyennes[$userId] = $user[$sequence];
                    }
                }

                // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                arsort($moyennes);

                $moyennesGenerales[] = (count($moyennes) > 0)
                    ? array_sum($moyennes) / count($moyennes)
                    : 0; // on détermine la moyenen générale de la classe pour cette séquence

                // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                $rangs = [];
                $rank = 1;
                foreach ($moyennes as $userId => $moyenne) {
                    $rangs[$userId] = $rank;
                    $rank++;
                }

                // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                foreach ($tabNote['user'] as $userId => &$user) {
                    $user['rang_'.$sequence] = @$rangs[$userId] ?? null; // certains ne seront pas dans ce tableau de $rags
                }

                // Stocker les rangs dans le tableau global
                $rangsParSequence[$sequence] = $rangs;
            }

            // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément

            /******************************************************fin calcul rang ********************************************/

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            $tabNote['classTotalNotesMax'] = Assessment::select(DB::raw('SUM(notemax) as total_notemax'))
                ->from(function (Builder $query) use ($request, $idOptionLevel) {
                    $query->select('a.notemax')
                        ->from('ratings AS r')
                        ->join('assessments AS a', 'a.id', '=', 'r.idAssessment')
                        ->where('r.idClasse', $request['idClasse'])
                        ->where('r.idAssessmentType', $request['idAssessmentType'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter', 'matter.id', '=', 'r.idMatter')
                                ->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->where('a.deleted', false) // Ajouter manuellement la condition
                        ->groupBy('a.id', 'a.notemax');
                })
                ->setBindings([$request['idClasse'], $request['idAssessmentType']])
                ->value('total_notemax');

            $tabNote['nbreTotalEvaluations'] = $nbreTotalEvaluations;
            $tabNote['moyennesGenerales'] = $moyennesGenerales;

            return $tabNote;
//            return $this->sendResponse($tabNote, 'Bulletins');
        }
        catch (\Throwable $th) {
            throw new Exception($th->getMessage());
//            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    public function bulletinPrimaireSequence(array $request, $isMaternelle = false){
        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();
            $choosenTrimestre = null; // cette valeur sera modifiée plus tard si on veut les donénes du trimestre

            $idOptionLevel = $request['idOptionLevel'] ?? null;

            if(isset($request['idTrimestre'])){
                $choosenTrimestre = Trimestre::find($request['idTrimestre']); //idTrimestre peut exister si on récupère les données le bulletin Trimestriel

                $totalEvalsClasseParSequence = array();

                foreach ($choosenTrimestre->assessmentTypes()->orderBy('name')->get() as $keyTmpAssessmentType => $tmpAssessmentType) {
                    $totalEvalsClasseParSequence[] = Assessment::join('assessments_has_assessment_type as ahat', 'ahat.assessment_id','=','assessments.id')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->join('matter','matter.id','=','assessments.idMatter')
                                ->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->where('ahat.assessment_type_id', $tmpAssessmentType->id)
                        ->where('assessments.idClasse', $request['idClasse'])
                        ->count();
                }
            }

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.city as city','users.photo as photo',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->when(!is_null($choosenTrimestre), function($query) use ($choosenTrimestre) { // quand c'est le trimestre, on récupère les notemax de toutes les séquences de ce trimestre
                    $query->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray());
                })
                ->when(is_null($choosenTrimestre), function($query) use ($request) { // quand c'est la séquence, on spécifie idAssessmentType
                    $query->where('ratings.idAssessmentType', $request['idAssessmentType']);
                })
                ->where('users.idClasse', $request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->orderBy("users.name", "asc")
                ->get();

            $tabNote['user'] = $entete;

            $effectifClasse = count($entete);

            $tabNote['effectifClasse'] = $effectifClasse;

            if($effectifClasse == 0){
                throw new \Exception("Pas d'élèves avec de notes pour ces données");
            }

            for ($i=0; $i < $entete->count(); $i++) {

                // le nombre total d'évaluations que l'élève a composé..
                // on s'en servira(si >=70% du total des évaluations) pour savoir si il doit être inclus pour calculer la moyenne générale de sa classe
                // ou même si il doit avoir un rang
                $totalNbreEvaluationsComposes = 0;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                        $query->where('matter_group.idOptionLevel', $idOptionLevel);
                    })
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][$i]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                if($matterGroup->count() == 0){
                    throw new \Exception("Aucun groupe de matière trouvé");
                }

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->orderBy("id", "asc")
                        ->get();

                    // On va modifier la notemax de chaque évaluation pour cet enfant (dans la mesure où il n'a pas composé sur tous ces types)
                    // TODO: On reviendra dessus pour le trimestre
                    foreach ($assessment as $key_tmp_assessment => $assess) {

                        $notemaxs = Rating::select('ratings.idAssessmentType', 'ratings.idTypeEvaluation', 'type_evaluation.name as te_name', 'assessments.*')
                            ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
                            ->join('type_evaluation', 'type_evaluation.id', '=', 'ratings.idTypeEvaluation')
                            ->join('users', 'users.id','=','ratings.idStudent')
                            ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                            ->where('ratings.idMatter', $assess['idMatter'])
                            ->where('ratings.idClasse', $request['idClasse'])
                            ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                            ->when(!is_null($choosenTrimestre), function($query) use ($choosenTrimestre) { // quand c'est le trimestre, on récupère les notemax de toutes les séquences de ce trimestre
                                $query->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray());
                            })
                            ->when(is_null($choosenTrimestre), function($query) use ($request) { // quand c'est la séquence, on spécifie idAssessmentType
                                $query->where('ratings.idAssessmentType', $request['idAssessmentType']);
                            })
                            ->distinct()
                            ->get();

                        $nbre_seq_for_assessment = count(array_unique($notemaxs->pluck('idAssessmentType')->toArray()));
//                        dd($nbre_seq_for_assessment);

                        $tmp_total = array();

                        foreach ($notemaxs as $notemax) {
                            $tmp_te_total = Str::slug($notemax->te_name, "_");
                            $tmp_total[] = $notemax->$tmp_te_total;
                        }

                        $assessment[$key_tmp_assessment]['notemax'] = ($nbre_seq_for_assessment>0)
                            ? number_format(safeArraySum($tmp_total) / $nbre_seq_for_assessment, 1)
                            : null;
                    }

                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

//TODO: Le total_notemax peut changer d'une séquence à l'autre
                    if(!is_null($choosenTrimestre)){
                        // Si on veut pour le trimestre, on va parcourir les séquences et avoir le total_notemax de chaque séquence de cet enfant
                        $total_notemax_evals = array(); // un tableau où la clé sera l'id de la séquence

                        foreach ($choosenTrimestre->assessmentTypes()->orderBy('name')->get() as $keyTmpAssessmentType => $tmpAssessmentType) {
                            $total_notemax_evals[substr($tmpAssessmentType->name, -1)] = null;

                            // on récupère toutes les évaluations où le type ci a composé
                            $evals_composeForSequence = Rating::select('idAssessment', 'idTypeEvaluation' ,'te.name as te_name', 'a.*')
                                ->join('type_evaluation as te', 'te.id','=','idTypeEvaluation')
                                ->join('assessments as a', 'a.id','=','ratings.idAssessment')
                                ->join('matter','matter.id','=','ratings.idMatter')
                                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                                    $query->where('matter.idOptionLevel', $idOptionLevel);
                                })
                                ->where('idStudent', $tabNote['user'][$i]['id'])
                                ->where('idAssessmentType', $tmpAssessmentType->id)
                                ->get();

                            // on somme les notes des types_evaluations (pas des notemax)
                            foreach ($evals_composeForSequence as $item) {
                                $tmp_te_name = $item['te_name'];
                                $total_notemax_evals[substr($tmpAssessmentType->name, -1)] += $item[Str::slug($tmp_te_name, '_')];
                            }
                        }
                    }
//TODO: Le total_notemax peut changer d'une séquence à l'autre

                    // TODO: On va plutôt avoir la somme des notemax des matières pour lesquelles l'élèves a effectivement composé
                    $total_notemax_assessment = 0;

                    // on récupère toutes les évaluations où le type ci a composé
                    $evals_compose = Rating::select('idAssessment', 'idTypeEvaluation' ,'te.name as te_name', 'a.*')
                        ->join('type_evaluation as te', 'te.id','=','idTypeEvaluation')
                        ->join('assessments as a', 'a.id','=','ratings.idAssessment')
                        ->where('idStudent', $tabNote['user'][$i]['id'])
                        ->when(!is_null($choosenTrimestre), function($query) use ($choosenTrimestre) { // quand c'est le trimestre, on récupère les notemax de toutes les séquences de ce trimestre
                            $query->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray());
                        })
                        ->when(is_null($choosenTrimestre), function($query) use ($request) { // quand c'est la séquence, on spécifie idAssessmentType
                            $query->where('ratings.idAssessmentType', $request['idAssessmentType']);
                        })
                        ->join('matter','matter.id','=','ratings.idMatter')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query->where('matter.idOptionLevel', $idOptionLevel);
                        })
//                        ->where('idAssessmentType', $request['idAssessmentType'])
                        ->get();

                    // on somme les notes des types_evaluations (pas des notemax)
                    foreach ($evals_compose as $item) {
                        $tmp_te_name = $item['te_name'];
                        $total_notemax_assessment += $item[Str::slug($tmp_te_name, '_')];
                    }

                    if(!is_null($choosenTrimestre)){
                        $nbreSeq = Rating::select(DB::raw("DISTINCT(idAssessmentType)"))
                            ->whereIn('idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                            ->pluck('idAssessmentType')
                            ->count();
                    }else{
                        $nbreSeq = 1;
                    }

//                    dd($total_notemax_evals, $total_notemax_assessment, $nbreSeq);

                    for ($k=0; $k < $assessment->count(); $k++) {
                        // On veut compter le nombre d'évaluations que cet élève a composé.
                        // Donc si il existe une note (sur table ratings) pour ce $k évaluation, on compte l'évaluation comme composé
                        $hasStudentWriteAssessment = Rating::where('idAssessment', $assessment[$k]['id'])
                            ->where('idStudent', $tabNote['user'][$i]['id'])
                            ->where('idAssessmentType', $request['idAssessmentType'])
                            ->count();

                        if($hasStudentWriteAssessment != 0){
                            $totalNbreEvaluationsComposes++;
                        }
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','type_evaluation.libelle','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

                        $totalSequence1 = null;
                        $totalSequence2 = null;
                        $totalSequence3 = null;
                        $totalSequence4 = null;
                        $totalSequence5 = null;
                        $totalSequence6 = null;
                        $totalSequence7 = null;
                        $totalSequence8 = null;

                        $total_note_assessment1 = null;
                        $total_note_assessment2 = null;
                        $total_note_assessment3 = null;
                        $total_note_assessment4 = null;
                        $total_note_assessment5 = null;
                        $total_note_assessment6 = null;
                        $total_note_assessment7 = null;
                        $total_note_assessment8 = null;
                        //$total_notemax_assessment = $total_notemax_assessment + $assessment[$k]['notemax'];

                        for ($l=0; $l < $typeEvaluation->count(); $l++) {
                            // On ne filtre plus tous les trimestres, mais uniquement le trimestre envoyé ou au PLUS le trimestre de la séquence envoyée
                            if(!is_null($choosenTrimestre)){
                                $idTrims[] = $choosenTrimestre->id;
                            }else{
                                $idTrims[] = AssessmentType::find($request['idAssessmentType'])->idTrimestre;
                            }

//                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->whereIn('id',$idTrims)
                                ->get();

                            $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }
//
                            if(!empty($assessment[$k]['orale'])){
                                if($typeEvaluation[$l]['name'] == "Orale")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['orale'];
                            }

                            if(!empty($assessment[$k]['ecrit'])){
                                if($typeEvaluation[$l]['name'] == "Ecrit")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['ecrit'];
                            }

                            if(!empty($assessment[$k]['written'])){
                                if($typeEvaluation[$l]['name'] == "Written")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['written'];
                            }

                            if(!empty($assessment[$k]['attitude'])){
                                if($typeEvaluation[$l]['name'] == "Attitude")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['attitude'];
                            }

                            if(!empty($assessment[$k]['savoir_etre'])){
                                if($typeEvaluation[$l]['name'] == "Savoir être")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['savoir_etre'];
                            }

                            if(!empty($assessment[$k]['pratical'])){
                                if($typeEvaluation[$l]['name'] == "Pratical")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratical'];
                            }

                            if(!empty($assessment[$k]['pratique'])){
                                if($typeEvaluation[$l]['name'] == "Pratique")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['pratique'];
                            }

                            $rating_exits = null;
                            for ($m=0; $m < $trimestre->count(); $m++) {
                                $assessmentType = AssessmentType::select('id','name')
                                    ->where('idSchool',$request['idSchool'])
                                    ->where('idSection',$request['idSection'])
                                    ->where('idTrimestre',$trimestre[$m]['id'])
                                    ->get();
//
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------
//                                    // On détermine le rang de cet étudiant sur cette évaluation précise
                                    $ratings['rang'] = (isset($ratings->value))
                                        ? Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->join('users', 'users.id','=','ratings.idStudent')
                                            ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('assessment_type.id',$assessmentType[$n]['id'])
                                            ->where('ratings.idClasse',$request['idClasse'])
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->where('ratings.value','>', $ratings->value)
                                            ->count() + 1
                                        : "-";
//
//                                    // On détermine le nombre de personnes ayant réussi (ils ont une note >= à note/2) pour cette évaluation précise (oral, écrit, pratique, ...)
                                    $tmp_note = Str::slug($typeEvaluation[$l]['name'], '_');
                                    $nbreSucceed = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                        ->where('assessment_type.id', $assessmentType[$n]['id'])
                                        ->where('ratings.idClasse', $request['idClasse'])
                                        ->where('ratings.idTypeEvaluation', $typeEvaluation[$l]['id'])
                                        ->where('ratings.value','>=', $assessment[$k][$tmp_note]/2)
                                        ->count();

                                    // Pour calculer la moyenne sur le typeEvaluation de cette matière, on divise par le nombre d'étudiants qui ont effectivement composé
                                    // (qui peut être inférieur à l'effectif réel de la classe)
                                    $effectifAssessmentTypeEvaluation = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                            'idTypeEvaluation' => $typeEvaluation[$l]['id']
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    $ratings['success_percentage'] = ($effectifAssessmentTypeEvaluation != 0)
                                        ? round(($nbreSucceed * 100) / $effectifAssessmentTypeEvaluation, 2)
                                        : 0;
//
                                    // On détermine la moyenne générale de la classe sur cette évaluation
                                    $gen_avg = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->sum('ratings.value');

                                    $ratings['g_avg'] = ($effectifAssessmentTypeEvaluation !=0)
                                        ? number_format($gen_avg / $effectifAssessmentTypeEvaluation, 2) //round($gen_avg / $effectifClasse, 2);
                                        : 0;

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    // La note de l'élève sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $studentNoteOnAssessment = Rating::select('ratings.value as value')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->sum('ratings.value');

                                    // Les notes de tous les élèves sur cette matière/évaluation (tous typeEvaluation condonfus)
                                    $classeNotesOnAssesment = Rating::where('ratings.idClasse', $request['idClasse'])
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('idAssessmentType', $assessmentType[$n]['id'])
                                        ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                        ->groupBy('idStudent')
                                        ->selectRaw('SUM(value) as note')
                                        ->pluck('note')
                                        ->toArray();

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['note_on_assessment'] = $studentNoteOnAssessment;
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['rank_on_assessment'] = count(array_filter($classeNotesOnAssesment, function($note) use ($studentNoteOnAssessment) {
                                            return $note > $studentNoteOnAssessment;
                                        })) + 1;

                                    $notemax = $assessment[$k]['notemax'];

                                    // On détermine le nombre d'élèves ayant composé cette évaluation
                                    $effectifAssessment = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
                                            'idAssessmentType' => $assessmentType[$n]['id'],
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    // On compte le nombre d'élèves ayant la moyenne sur cette évaluation
                                    $nbreSuccessOnAssessment = count(array_filter($classeNotesOnAssesment, function($note) use ($notemax) {
                                        return $note >= ($notemax/2);
                                    }));

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['nbreSuccessOnAssessment'] = ($nbreSuccessOnAssessment != 0 && $effectifAssessment!=0)
                                        ? ($nbreSuccessOnAssessment*100) / ($effectifAssessment) ?? 1
                                        : 0;
//    ----------------------------------------------- on ajoute des valeurs -----------------------------------------------

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch (mb_substr($assessmentType[$n]['name'], -1)) {
//                                            switch ($assessmentType[$n]['id']) {
                                                case "1":
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case "2":
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case "3":
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case "4":
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case "5":
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case "6":
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case "7":
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case "8":
                                                    $totalSequence8 = $totalSequence8 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment8 = $total_note_assessment8 + $ratings['value'];
                                                    }
                                                    break;

                                                default:
                                                    # code...
                                                    break;
                                            }
                                        }
                                    }
                                }

                                /**
                                 * on ajoute certaines données pour le trimestre
                                 **/

                                if(isset($request['idTrimestre'])){
                                    $ratingOnTrimestreForTypeEvaluation = Rating::select(DB::raw("SUM(ratings.value) as value"))
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('type_evaluation','type_evaluation.id','=','ratings.idTypeEvaluation')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->whereIn('assessment_type.id', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                                        ->first();

                                    $studentsNotesForMatterAndTypeEvaluation = Rating::select(DB::raw('SUM(ratings.value) as noteTrim, ratings.idStudent'))
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->whereIn('assessment_type.id', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                                        ->where('ratings.idClasse',$request['idClasse'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->groupBy('ratings.idStudent')
                                        ->pluck('noteTrim')
                                        ->toArray();

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['rang_trim'] = count(array_filter($studentsNotesForMatterAndTypeEvaluation, function($rangTrim) use($ratingOnTrimestreForTypeEvaluation) {
                                            return $rangTrim > $ratingOnTrimestreForTypeEvaluation->value;
                                        })) + 1 ;

                                    // % réussite pour le trimestre
                                    $nbreSequencesAvecNotePourMatiereEtTypeEvaluation = 0; //On compte le nombre de séquences ayant des notes
                                    foreach ($choosenTrimestre->assessmentTypes as $assessmentType) {
                                        $seqNotes = Rating::join('assessments','assessments.id','=','ratings.idAssessment')
                                            ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                            ->join('matter','matter.id','=','ratings.idMatter')
                                            ->join('users', 'users.id','=','ratings.idStudent')
                                            ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                            ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                            ->where('ratings.idClasse',$request['idClasse'])
                                            ->where('assessment_type.id', $assessmentType->id)
                                            ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                            ->count();

                                        if($seqNotes > 0) $nbreSequencesAvecNotePourMatiereEtTypeEvaluation++;
                                    }

                                    $nbreSucceed = count(array_filter($studentsNotesForMatterAndTypeEvaluation, function($studNote) use ($assessment, $k, $tmp_note, $nbreSequencesAvecNotePourMatiereEtTypeEvaluation) {
                                        return $studNote >= ($assessment[$k][$tmp_note]*$nbreSequencesAvecNotePourMatiereEtTypeEvaluation)/2;
                                    }));

                                    // Pour calculer la moyenne sur le typeEvaluation de cette matière, on divise par le nombre d'étudiants qui ont effectivement composé
                                    // (qui peut être inférieur à l'effectif réel de la classe)
                                    $effectifAssessmentTypeEvaluationForTrimestre = DB::table('ratings')
                                        ->where([
                                            'idClasse' => $request['idClasse'],
                                            'idAssessment' => $assessment[$k]['id'], // la matière est liée à l'évaluation donc ...
//                                        'idAssessmentType' => $assessmentType[$n]['id'],
                                            'idTypeEvaluation' => $typeEvaluation[$l]['id']
                                        ])
                                        ->distinct('idStudent')
                                        ->count('idStudent');

                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['success_percentage_trim'] = ($effectifAssessmentTypeEvaluationForTrimestre != 0)
                                        ? round(($nbreSucceed * 100) / $effectifAssessmentTypeEvaluationForTrimestre, 2)
                                        : 0;

                                    if($effectifAssessmentTypeEvaluationForTrimestre !=0){
                                        $tmp_type_evaluation_name = Str::slug($typeEvaluation[$l]['name'], "_");
                                        $tmp_type_evaluation_notemax = $assessment[$k][$tmp_type_evaluation_name];

                                        $moyClassPourMatiereEtTypeEvaluation = ($effectifAssessmentTypeEvaluationForTrimestre!=0 && $nbreSequencesAvecNotePourMatiereEtTypeEvaluation!=0)
                                            ? array_sum($studentsNotesForMatterAndTypeEvaluation) / ($effectifAssessmentTypeEvaluationForTrimestre*$nbreSequencesAvecNotePourMatiereEtTypeEvaluation)
                                            : null;
//                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['g_avg_trim'] = number_format($moyClassPourMatiereEtTypeEvaluation, 2); // Pour la BD Juniors, cette valeur sera modifiée dans le template Blade

                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['g_avg_trim'] = ($tmp_type_evaluation_notemax > 0)
                                            ? ($moyClassPourMatiereEtTypeEvaluation*20) / $tmp_type_evaluation_notemax
                                            : null;

                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['g_avg_trim_details'] = [
                                            'tmp_type_evaluation_notemax' => $tmp_type_evaluation_notemax,
                                            'notes' => $studentsNotesForMatterAndTypeEvaluation
                                        ];
                                    }else{
                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['g_avg_trim'] = 0;
                                    }
                                }
                                /**
                                 * Fin d'ajout des informations à propos du trimestre
                                 */

                                if($rating_exits == 3){
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }

                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                            }
                        }

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
                        $trimestre1 = null ;
                        $trimestre2 = null ;
                        $trimestre3 = null ;
                        if(empty($totalSequence1) || empty($totalSequence2) || empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,null);
                        }else if(!empty($totalSequence1) && !empty($totalSequence2) && !empty($totalSequence3)){
                            $trimestre1 = array($totalSequence1,$totalSequence2,$totalSequence3,$totalSequence1+$totalSequence2+$totalSequence3);
                        }

                        if(empty($totalSequence4) || empty($totalSequence5) || empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,null);
                        }else if(!empty($totalSequence41) && !empty($totalSequence5) && !empty($totalSequence6)){
                            $trimestre2 = array($totalSequence4,$totalSequence5,$totalSequence6,$totalSequence4+$totalSequence5+$totalSequence6);
                        }

                        if(empty($totalSequence7) || empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,null);
                        }else if(!empty($totalSequence7) && !empty($totalSequence8)){
                            $trimestre3 = array($totalSequence7,$totalSequence8,$totalSequence7+$totalSequence8);
                        }

                        $sommeTrimestre = array($trimestre1,$trimestre2,$trimestre3);
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

                        if(isset($request['idTrimestre'])){
                            // Nombre de séquences qui ont des notes
                            $nbreSequencesAvecNotePourMatiere = Rating::select('ratings.idAssessmentType')
                                ->join('assessments','assessments.id','=','ratings.idAssessment')
                                ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                ->join('matter','matter.id','=','ratings.idMatter')
                                ->join('users', 'users.id','=','ratings.idStudent')
                                ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                ->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                                ->where('ratings.idClasse', $request['idClasse'])
                                ->distinct('ratings.idAssessmentType')
                                ->count();

                            if($nbreSequencesAvecNotePourMatiere > 0){
                                //Notes de toute la classe sur cette matière pour ce trim
                                $notesClassePourTimActuelSurLaMatiere = Rating::select(DB::raw("SUM(ratings.value) as studentNoteOnMatiereForTrim"), 'ratings.idStudent')
                                    ->join('assessments','assessments.id','=','ratings.idAssessment')
                                    ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                    ->join('matter','matter.id','=','ratings.idMatter')
                                    ->join('users', 'users.id','=','ratings.idStudent')
                                    ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                    ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                    ->where('ratings.idClasse', $request['idClasse'])
                                    ->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                                    ->groupBy('ratings.idStudent')
                                    ->pluck('studentNoteOnMatiereForTrim')
                                    ->toArray();

                                // Note de l'élève actuel sur cette matière pour ce trim
                                $notePourTrimActuelSurLaMatiere = array_sum(Rating::select('ratings.value as value')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->join('users', 'users.id','=','ratings.idStudent')
                                        ->where('users.deleted', '0') // on ne récupère pas les notes des personnes supprimées
                                        ->where('ratings.idMatter', $assessment[$k]['idMatter'])
                                        ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                        ->where('ratings.idClasse', $request['idClasse']) // un peu redondant vu qu'on a déjà spécifié idStudent MAIS BON ...
                                        ->whereIn('assessment_type.id', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                                        ->pluck('value')
                                        ->toArray()) / $nbreSequencesAvecNotePourMatiere; // Ma note du trim c'est la somme de mes notes sur les séquences divisé par le nombre de séquences du trimestre

                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestreActuel'] = $notePourTrimActuelSurLaMatiere;
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['rangTrimestreActuel'] = count(array_filter($notesClassePourTimActuelSurLaMatiere, function($studNoteOnMatiereTrim) use ($notePourTrimActuelSurLaMatiere, $nbreSequencesAvecNotePourMatiere) {
                                        return ($studNoteOnMatiereTrim/$nbreSequencesAvecNotePourMatiere) > $notePourTrimActuelSurLaMatiere;
                                    })) + 1;
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['successPercentageTrimestreActuel'] = (count($notesClassePourTimActuelSurLaMatiere)!=0)
                                    ? count(array_filter($notesClassePourTimActuelSurLaMatiere, function($studNoteOnMatiereTrim) use ($assessment, $nbreSequencesAvecNotePourMatiere, $k) {
                                        return ($studNoteOnMatiereTrim/$nbreSequencesAvecNotePourMatiere) >= ($assessment[$k]['notemax']/2);
                                    }))*100 / count($notesClassePourTimActuelSurLaMatiere)
                                    : null;
                            }
                            else{
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['totalTrimestreActuel'] = "-";
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['rangTrimestreActuel'] = "-";
                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['successPercentageTrimestreActuel'] = "-";
                            }
                        }

                        $totalSequence1User = $totalSequence1User + $totalSequence1;
                        $totalSequence2User = $totalSequence2User + $totalSequence2;
                        $totalSequence3User = $totalSequence3User + $totalSequence3;
                        $totalSequence4User = $totalSequence4User + $totalSequence4;
                        $totalSequence5User = $totalSequence5User + $totalSequence5;
                        $totalSequence6User = $totalSequence6User + $totalSequence6;
                        $totalSequence7User = $totalSequence7User + $totalSequence7;
                        $totalSequence8User = $totalSequence8User + $totalSequence8;
                    }
                }

//                if($total_notemax_assessment != 0){
                if($nbreSeq == 0){
                    throw new \Exception("Le nombre de séquences ne peut pas être null pas");
                }
                $total_notemax_assessment = $total_notemax_assessment / $nbreSeq; // on divise par le nbre de séquence. NB: si on a une seule séq, $nbreSeq==1

                $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment ;
                $tabNote['user'][$i]['totalNoteMaxes'] = @$total_notemax_evals;
//                $tabNote['user'][$i]['totalNoteMaxTrimestre'] = $total_notemax_assessment / $nbreSeq; // on divise par le nbre de séquence. NB: si on a une seule séq, $nbreSeq==1
                $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;

                if(!$isMaternelle){ // la maternelle utilise aussi cette fonction
                    $tabNote['user'][$i]['moyenneSequence1'] = (isset($total_notemax_evals['1']) && $total_notemax_evals['1']>0) ? number_format((($totalSequence1User * 20)) / $total_notemax_evals['1'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence2'] = (isset($total_notemax_evals['2']) && $total_notemax_evals['2']>0) ? number_format((($totalSequence2User * 20)) / $total_notemax_evals['2'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence3'] = (isset($total_notemax_evals['3']) && $total_notemax_evals['3']>0) ? number_format((($totalSequence3User * 20)) / $total_notemax_evals['3'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence4'] = (isset($total_notemax_evals['4']) && $total_notemax_evals['4']>0) ? number_format((($totalSequence4User * 20)) / $total_notemax_evals['4'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence5'] = (isset($total_notemax_evals['5']) && $total_notemax_evals['5']>0) ? number_format((($totalSequence5User * 20)) / $total_notemax_evals['5'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence6'] = (isset($total_notemax_evals['6']) && $total_notemax_evals['6']>0) ? number_format((($totalSequence6User * 20)) / $total_notemax_evals['6'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence7'] = (isset($total_notemax_evals['7']) && $total_notemax_evals['7']>0) ? number_format((($totalSequence7User * 20)) / $total_notemax_evals['7'], 2) : null;
                    $tabNote['user'][$i]['moyenneSequence8'] = (isset($total_notemax_evals['8']) && $total_notemax_evals['8']>0) ? number_format((($totalSequence8User * 20)) / $total_notemax_evals['8'], 2) : null;
                }else{
                    $tabNote['user'][$i]['moyenneSequence1'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence1User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence2'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence2User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence3'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence3User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence4'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence4User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence5'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence5User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence6'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence6User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence7'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence7User / $total_notemax_assessment)*4, 2) : null;
                    $tabNote['user'][$i]['moyenneSequence8'] = ($total_notemax_assessment!=0) ? round(@str_replace(',', '.', $totalSequence8User / $total_notemax_assessment)*4, 2) : null;
                }

                if(!is_null($choosenTrimestre)){
//                    $nbreEvalsComp = array();
                    foreach ($choosenTrimestre->assessmentTypes()->orderBy('name')->get() as $tmpAssessmentType) {
                        // on détermine si cette éval sera comptée pour la moy de l'enfant
                        $nbreEvalsComp = count(array_unique(Rating::select('idAssessment')
                            ->where('idAssessmentType', $tmpAssessmentType->id)
                            ->where('idStudent',  $tabNote['user'][$i]['id'])
                            ->pluck('idAssessment')
                            ->toArray()));

                        $totalEvalsClassePourSequence = (int)$totalEvalsClasseParSequence[(int)substr($tmpAssessmentType->name, -1)-1];

                        if($nbreEvalsComp / $totalEvalsClassePourSequence < 0.7){
                            unset($total_notemax_evals[substr($tmpAssessmentType->name, -1)]);
                        }
                    }

                    // on modifie ces valeurs
                    $tabNote['user'][$i]['totalNoteMax'] = safeArraySum($total_notemax_evals, true) ;
                    $tabNote['user'][$i]['totalNoteMaxes'] = $total_notemax_evals;

                    $totalDeMesNotes = 0;

                    foreach ($tabNote['user'][$i]['totalNoteMaxes'] as $kTotalSeqNoteMax => $totalNoteMaxTmp){
                        $totalDeMesNotes += $tabNote['user'][$i]["totalSequence".$kTotalSeqNoteMax."User"];
                    }

//                    $tabNote['user'][$i]['moyenneTrim'] = (!empty($tabNote['user'][$i]['totalNoteMaxes']))
                    $tabNote['user'][$i]['moyenneTrim'] = (!empty($tabNote['user'][$i]['totalNoteMaxes']) && safeArraySum($tabNote['user'][$i]['totalNoteMaxes']) != 0)
                        ? $totalDeMesNotes *20 / safeArraySum($tabNote['user'][$i]['totalNoteMaxes'])
                        : null;
                }

                $tabNote['user'][$i]['totalNbreEvaluationsComposes'] = $totalNbreEvaluationsComposes;
            }

            /******************************************************Debut calcul rang ********************************************/

            //TODO: On compte le nombre d'évaluations que chaque enfant doit effectuer...
            // PS: si après il a composé -70% de toutes les évaluations,
            // (1) on ne va pas l'inclure dans le calcul de la moyenne générale de la classe
            // (2) on ne l'inclut pas dans les moyennes et donc il n'aura pas de rang comme les autres
            $nbreTotalEvaluations = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                ->join('matter','matter.id','=','assessments.idMatter')
                ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id','=','assessments.id')
                ->where('assessments.idSchool',$request['idSchool'])
                ->where('assessments.idSection',$request['idSection'])
                ->where('assessments.idClasse',$request['idClasse'])
                ->where('assessments_has_assessment_type.assessment_type_id', $request['idAssessmentType'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->count();

            // Tableau des séquences
            $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

            // Tableau associatif pour stocker les rangs pour chaque séquence
            $rangsParSequence = [];

            $moyennesGenerales = []; // moyennes générales de la classe

            // Boucle sur chaque séquence
            foreach ($sequences as $sequence) {
                // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                $moyennes = [];
                foreach ($tabNote['user'] as $userId => $user) {
                    $totalNbreEvaluationsComposes = $user['totalNbreEvaluationsComposes'];

                    if($nbreTotalEvaluations == 0){
                        //TODO: throw exception ou continue; ?????
                        throw new \Exception("Le nombre d'évaluations ne peut pas être null pas");
                    }
                    if(($totalNbreEvaluationsComposes*100 / $nbreTotalEvaluations) >= 70){
                        $moyennes[$userId] = $user[$sequence];
                    }
                }

                // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                arsort($moyennes);

                $moyennesGenerales[] = (count($moyennes) > 0)
                    ? round(array_sum($moyennes) / count($moyennes), 2)
                    : 0; // on détermine la moyenen générale de la classe pour cette séquence

                // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                $rangs = [];
                $rank = 1;
                foreach ($moyennes as $userId => $moyenne) {
                    $rangs[$userId] = $rank;
                    $rank++;
                }

                // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                foreach ($tabNote['user'] as $userId => &$user) {
                    $user['rang_'.$sequence] = @$rangs[$userId] ?? null; // certains ne seront pas dans ce tableau de $rags
                }

                // Stocker les rangs dans le tableau global
                $rangsParSequence[$sequence] = $rangs;
            }

            // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément

            /******************************************************fin calcul rang ********************************************/

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            $tabNote['classTotalNotesMax'] = Assessment::select(DB::raw('SUM(notemax) as total_notemax'))
                ->from(function (Builder $query) use ($request, $idOptionLevel) {
                    $query->select('a.notemax')
                        ->from('ratings AS r')
                        ->join('assessments AS a', 'a.id', '=', 'r.idAssessment')
                        ->where('r.idClasse', $request['idClasse'])
                        ->where('r.idAssessmentType', $request['idAssessmentType'])
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter', 'matter.id', '=', 'r.idMatter')
                                ->where('matter.idOptionLevel', $idOptionLevel);
                        })
                        ->groupBy('a.id', 'a.notemax');
                })
                ->setBindings([$request['idClasse'], $request['idAssessmentType']])
                ->value('total_notemax');

            $tabNote['nbreTotalEvaluations'] = $nbreTotalEvaluations;
            $tabNote['moyennesGenerales'] = $moyennesGenerales;
//            return $this->sendResponse($tabNote, 'Bulletins');
            return $tabNote;
        }
        catch (\Throwable $th) {
            die("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            throw new Exception($th->getMessage());
            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Infos du bulletin trimestriel maternell pour toutes les écoles sauf Juniors
     *
     * @param array $request
     * @return \Illuminate\Http\Response
     */
    public function bulletinMaternelleTrimestrielGeneral(array $request)
    {
        try{
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $choosenTrimestre = Trimestre::find($request['idTrimestre']); //idTrimestre peut exister si on récupère les données le bulletin Trimestriel

            $idOptionLevel = $request['$idOptionLevel'] ?? null;

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.nationality as nationality','users.city as city','users.photo as photo',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->join('ratings', 'ratings.idStudent','=','users.id') //On ne va pas prendre en considération ceux qui n'ont AUCUNE NOTE
                ->whereIn('ratings.idAssessmentType', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray()) // si il n'a pas composé la séquence ? (quand nous sommes sur le trimestre)
                ->where('users.idClasse',$request['idClasse'])
                ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                    $query->join('matter','matter.id','=','ratings.idMatter')
                        ->where('matter.idOptionLevel', $idOptionLevel);
                })
                ->where('users.deleted',0)
                ->distinct('users.id')
                ->orderBy("users.name", "asc")
                ->get();
            $tabNote['user'] = $entete;

            $effectifClasse = count($entete);
            $tabNote['effectifClasse'] = $effectifClasse;

            $total_moy_eleve = null;
            $moyClasse = null;
            //$total_matiere = null;
            for ($i=0; $i < $entete->count(); $i++) {
                $trimestre = Trimestre::select('trimestre.id as id','trimestre.name as name')
                    ->join('assessment_type','assessment_type.idTrimestre','=','trimestre.id')
                    ->where('trimestre.idSchool',$request['idSchool'])
                    ->where('trimestre.idSection',$request['idSection'])
                    ->where('assessment_type.id',$request['idAssessmentType'])
                    ->get();

                $tabNote['user'][$i]['trimestre'] = $trimestre;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                $totalCoef1 = null ;
                $totalCoef2 = null ;
                $totalCoef3 = null ;
                $totalCoef4 = null ;
                $totalCoef5 = null ;
                $totalCoef6 = null ;
                $totaltermAv = null ;
                $totalNoteCoef = null;

                $moyseq1 = null;
                $moyseq2 = null;
                $moyseq3 = null;
                $moyseq4 = null;
                $moyseq5 = null;
                $moyseq6 = null;


                $assessmentType = AssessmentType::select('id','name')
                    ->whereIn('id', $choosenTrimestre->assessmentTypes()->pluck('id')->toArray())
                    ->get();

                $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                /**
                 * La boucle sur assessmentTypes commence ici
                 */

                for($at = 0; $at < count($assessmentType); $at++){

                    $totalSequence1 = null;
                    $totalSequence2 = null;
                    $totalSequence3 = null;
                    $totalSequence4 = null;
                    $totalSequence5 = null;
                    $totalSequence6 = null;
                    $total = null;
                    $totalSeq = null;
                    $totalCoefSeq = null;
                    $coefficient = null;

                    //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                    //$total_matiere = $total_matiere + 1;
                    $rating_exits = null;
                    $matterGroup = null;

                    if(!empty($request['idOptionLevel'])){
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                            ->orderBy("id", "asc")
                            ->get();
                    }else{
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                            ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                            ->where('matter_group.idSchool',$request['idSchool'])
                            ->where('matter_group.idSection',$request['idSection'])
                            ->orderBy("id", "asc")
                            ->get();
                    }

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'] = $matterGroup;

                    $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                        ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                        ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                        ->join('ratings','ratings.idAssessment','=','assessments.id')
                        ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                            $query
                                ->join('matter','matter.id','=','assessments.idMatter')
                                ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                                ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                                ->where('matter_group.idOptionLevel', $idOptionLevel);
                        })
                        ->where('assessment_type.id', $assessmentType[$at]['id'])
                        ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                        ->whereNotNull('ratings.value')
                        ->get();

                    switch (mb_substr($assessmentType[$at]['name'], -1)) {
                        case "1":
                            $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "2":
                            $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "3":
                            $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "4":
                            $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "5":
                            $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case "6":
                            $totalCoef6 = $coefficientSum[0]['coefficient_sum'];
                            break;
                    }

                    for ($x=0; $x < $matterGroup->count(); $x++) {
//
                        $totalNoteCoefMatterGroup1 = null;
                        $MatterGroupId = null;
                        $totalCoefMatterGroupAssessment = null;
                        $totalNoteCoefMatterGroup2 = null;
                        $totalCoefMatterGroup1 = null;
                        $totalCoefMatterGroup2 = null;
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->join('assessments_has_assessment_type','assessments_has_assessment_type.assessment_id','=','assessments.id')
                            ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->where('matter_group.id',$matterGroup[$x]['id'])
                            ->where('assessment_type.id',$assessmentType[$at]['id'])
                            ->when(!is_null($idOptionLevel), function($query) use ($idOptionLevel) {
                                $query->where('matter_group.idOptionLevel', $idOptionLevel);
                            })
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['assessment'] = $assessment;
                        $total = null;

                        for ($n=0; $n < $assessment->count(); $n++) {

                            $teachername = User::select('users.name as teacherName')
                                ->join('assessments','assessments.idTeacher','=','users.id')
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->get();

                            $ratings = Rating::select(
                                'ratings.value as value',
                                'ratings.observation as observation',
                                'ratings.notemax as notemax',
                                'assessment_type.name as assessmentName',
                                'matter.name as nameMatter',
                                'coefficients.value as coefficient',
                                DB::raw('(ratings.value * coefficients.value) as noteCoef')
                            )
                                ->join('assessments', 'assessments.id', '=', 'ratings.idAssessment')
                                ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                ->join('matter', 'matter.id', '=', 'ratings.idMatter')
                                ->join('coefficients','assessments.idCoeficient','=','coefficients.id')
                                ->where('ratings.idMatter',$assessment[$n]['idMatter'])
                                ->where('assessments.id',$assessment[$n]['id'])
                                ->where('assessment_type.id',$assessmentType[$at]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                ->first();


                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                            if(!empty($teachername)){
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                            }

                            if(!empty($ratings['coefficient'])){
                                $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;
                                $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];

                                if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                    switch (mb_substr($assessmentType[$at]['name'], -1)) {
                                        case "1":
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case "2":
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case "3":
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case "4":
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case "5":
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case "6":
                                            $totalSequence6 = $totalSequence6 + $ratings['noteCoef'];
                                            break;

                                        default:
                                            # code...
                                            break;
                                    }
                                    $MatterGroupId = $matterGroup[$x]['id'] ;
                                    switch ($matterGroup[$x]['id']) {
                                        case $MatterGroupId:
                                            $totalNoteCoefMatterGroup1 = $totalNoteCoefMatterGroup1 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup1 = $totalCoefMatterGroup1 + $ratings['coefficient'];
                                            break;
                                        /*
                                        case 2:
                                            $totalNoteCoefMatterGroup2 = $totalNoteCoefMatterGroup2 + $ratings['noteCoef'];
                                            $totalCoefMatterGroup2 = $totalCoefMatterGroup2 + $ratings['coefficient'];
                                            break;
                                            */

                                        default:
                                            # code...
                                            break;
                                    }
                                }

                            }

                            $totaltermAv = $totaltermAv + $total;
                        }

                        $MatterGroupId = $matterGroup[$x]['id'];

                        switch ($matterGroup[$x]['id']) {
                            case $MatterGroupId:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                $cleanNumber = ($totalCoefMatterGroup1!=0) ? @str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroup1,2)) : null;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                $totalSeq = $totalSeq + $total;
                                $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                break;
                            /*
                            case 2:
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup2;
                                $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup2 / $totalCoefMatterGroup2,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                break;
                                */
                        }
                    }//MatterGroup boucle fin*******************************************************************

                    if(!empty($rating_exits) && $rating_exits != 0){
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                        //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                    }else{
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['total_trimestre'] = null;
                    }

                    //} *************************************************************** ici ***********************************************
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequence'] = $totalSeq;

                    switch (mb_substr($assessmentType[$at]['name'], -1)) {
                        case '1':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence1;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq1 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq1;
                            }
                            break;
                        case '2':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence2;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq2 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq2;
                            }
                            break;
                        case '3':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence3;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq3 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq3;
                            }
                            break;
                        case '4':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence4;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq4 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq4;
                            }
                            break;
                        case '5':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence5;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq5 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq5;
                            }
                            break;
                        case '6':
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceNoteCoef'] = $totalSequence6;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$at]['moyenne'] = floatval($cleanNumber);
                                $moyseq6 = floatval($cleanNumber);
                                $moyClasse = $moyClasse + $moyseq6;
                            }
                            break;
                    }

                    switch (mb_substr($assessmentType[$at]['name'], -1)) {
                        case '1':
                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            break;
                        case '2':
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            break;
                        case '3':
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            break;
                        case '4':
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            break;
                        case '5':
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            break;
                        case '6':
                            $totalSequence6User = $totalSequence6User + $totalSequence6;
                            break;
                    }

                    $santion = Sanction::where('idUser',$entete[$i]['id'])->count();

                    $absence = Absence::where('idStudent',$entete[$i]['id'])->count();

                    //bonne moyenne 1

                    switch (mb_substr($trimestre[0]['name'], -1)) {
                        case '1':
                            if($totalCoef1 != 0 && $totalCoef2 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef1 + $totalCoef2)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                                if(!empty($totalSequence1User) || $totalSequence1User != 0 || !empty($totalSequence2User) || $totalSequence2User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence1User / $totalCoef1)+($totalSequence2User / $totalCoef2))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '2':
                            if($totalCoef3 != 0 && $totalCoef4 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef3 + $totalCoef4)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                                if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq3 + $moyseq4)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;

                        case '3':
                            if($totalCoef5 != 0 && $totalCoef6 != 0){
                                $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = ($totalCoef5 + $totalCoef6)/2;
                                $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence5User + $totalSequence6User)/2;
                                if(!empty($totalSequence5User) && $totalSequence5User != 0 && !empty($totalSequence6User) && $totalSequence6User != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence5User / $totalCoef5)+($totalSequence6User / $totalCoef6))/2,2);
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq5 + $moyseq6)/2,2);
                                }else{
                                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                                }
                            }

                            break;
                    }

                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreNew'] = 0;
                    $nbreSeq = 0;
                    foreach ($tabNote['user'][$i]['trimestre'][0]['assessmentType'] as $asType) {

                        $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreNew'] += $asType['moyenne'];

                        if($asType['moyenne'] > 0) $nbreSeq++;
                    }

                    $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreNew'] = ($nbreSeq>0)
                        ? $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreNew'] / $nbreSeq
                        : null;

                    $tabNote['user'][$i]['trimestre'][0]['totalAbs'] = $absence;
                    $tabNote['user'][$i]['trimestre'][0]['totalPunishment'] = $santion;
                }
                /**
                 * La boucle sur assessmentTypes finit ici
                 */
            }

//            if($effectifClasse != 0){
//                $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format($moyClasse / $effectifClasse,2)));
//            }else{
//                $tabNote['moyenneClasse'] = null;
//            }

            /******************************************************Debut calcul rang ********************************************/

//            //calculer le rang par sequence
//
//            // Vous pouvez utiliser collect pour créer une collection Laravel
//            $collection = collect($tabNote['user']);
//
//            // Ensuite, vous pouvez trier la collection en fonction de la moyenne pour un assessmentType spécifique
//            $assessmentIndex = 0; // Indice de l'assessmentType que vous voulez trier
//            $trimestreIndex = 0; // Indice du trimestre que vous voulez trier
//
//            $sortedCollection = $collection->sortByDesc(function ($user) {
//                return $user['trimestre'][0]['assessmentType'][$at]['moyenne'];
//            });
//
//            // Vous pouvez également obtenir le rang en utilisant la méthode search
//            $rankedCollection = $sortedCollection->values()->map(function ($user, $index) {
//                $user['trimestre'][0]['assessmentType'][$at]['rang'] = $index + 1;
//                return $user;
//            });
//
//            // Maintenant, $rankedCollection contient le tableau avec les rangs assignés
//            // Vous pouvez accéder aux informations comme suit :
//            foreach ($rankedCollection as $user) {
//                $moyenne = $user['trimestre'][0]['assessmentType'][$at]['moyenne'];
//                $rang = $user['trimestre'][0]['assessmentType'][$at]['rang'];
//
//                // Utilisation de $moyenne et $rang
//                // Par exemple, echo "Moyenne: $moyenne, Rang: $rang";
//            }

            /******************************************************fin calcul rang ********************************************/

//            return $this->sendResponse($tabNote, 'Bulletins');
            return $tabNote;
        }
        catch (\Throwable $th) {
            throw new Exception($th->getMessage());
//            Log::info("Error: " . $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    public function genererZipOuPDF($zip_filename, $filename, $vue, $data, $infosBulletins)
    {
        try{
            $zip_file = "$zip_filename.zip"; //"Bulletins-maternelle-".Str::slug($classe->name)."-sequence-".Str::slug($assessmentType->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

//            $filename = Str::slug($json_data->user[$case]->name);

            $dompdf = new Dompdf();

//            $folder = "bulletin.maternelle.sequence";
//
//            (view()->exists($folder."." . $route))
//                ? $vue = $folder."." . $route
//                : $vue = $folder.".default";

            // Récupérer la vue
            $view = View::make($vue)->with($data);
            //$view = View::make('receipt')->with($formattedData);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            file_put_contents(public_path("pdfs/$filename-bulletin-matternelle-sequence.pdf"), $dompdf->output());

            if(count($infosBulletins->user) > 1){

                $zip->addFile("pdfs/$filename-bulletin-matternelle-sequence.pdf");

                $liensBulletins[] = public_path("pdfs/$filename-bulletin-matternelle-sequence.pdf");
            }else{
                return $this->sendResponse(asset("pdfs/$filename-bulletin-matternelle-sequence.pdf"), "Bulletin matternelle sequence");
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin maternelle");
        }
        catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }
}
