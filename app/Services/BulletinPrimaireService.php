<?php

namespace App\Services;

use App\Models\Absence;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\MatterGroup;
use App\Models\Rating;
use App\Models\Sanction;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Storage;

class BulletinPrimaireService
{
    public function __construct()
    {
        ini_set('max_execution_time', 300);
    }

    public function index(array $request)
    {
        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$request['idSchool'])
                ->where('users.idSection',$request['idSection'])
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->count();

            $level_classe = Classes::select('idLevel')->where('id',$request['idClasse'])->first();

            $tabNote['effectifClasse'] = $effectifClasse;
            $entete = null;

            if(!empty($request['idUser']) && !empty($request['idTrimestre'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->where('id',$request['idTrimestre'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }

            }else if(!empty($request['idUser'])){
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.id',$request['idUser'])
                    ->where('users.deleted',0)
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;

                $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                    ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                    ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                    ->where('matter_group.idSchool',$request['idSchool'])
                    ->where('matter_group.idSection',$request['idSection'])
                    ->orderBy("id", "asc")
                    ->get();

                $tabNote['user'][0]['matterGroup'] = $matterGroup;

                $totalSequence1User = null;
                $totalSequence2User = null;
                $totalSequence3User = null;
                $totalSequence4User = null;
                $totalSequence5User = null;
                $totalSequence6User = null;
                $totalSequence7User = null;
                $totalSequence8User = null;

                for ($j=0; $j < $matterGroup->count(); $j++) {
                    $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                        ->join('matter','matter.id','=','assessments.idMatter')
                        ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                        ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                        ->where('matter_group.id',$matterGroup[$j]['id'])
                        ->where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->orderBy("id", "asc")
                        ->get();

                    $tabNote['user'][0]['matterGroup'][$j]['assessment'] = $assessment;

                    $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                        ->where('assessments.idSection',$request['idSection'])
                        ->where('assessments.idClasse',$request['idClasse'])
                        ->sum('assessments.notemax');

                    for ($k=0; $k < $assessment->count(); $k++) {
                        $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
                            ->join('assessments_has_type_evaluation','assessments_has_type_evaluation.type_evaluation_id','=','type_evaluation.id')
                            ->join('assessments','assessments.id','=','assessments_has_type_evaluation.assessment_id')
                            ->where('assessments.id',$assessment[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'] = $typeEvaluation;

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
                            //$total_matiere = $total_matiere + 1;
                            $trimestre = Trimestre::select('id','name')
                                ->where('idSchool',$request['idSchool'])
                                ->where('idSection',$request['idSection'])
                                ->get();

                            $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                            //gérer l'affichage des points devant le type_evaluation
                            if(!empty($assessment[$k]['oral'])){
                                if($typeEvaluation[$l]['name'] == "Oral")
                                    $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                            }

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

                                $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'] = $assessmentType;
                                $total = null;

                                for ($n=0; $n < $assessmentType->count(); $n++) {
                                    $ratings = Rating::select('ratings.value as value','ratings.observation as observation','ratings.notemax as notemax','assessment_type.name as assessmentName','matter.name as nameMatter')
                                        ->join('assessments','assessments.id','=','ratings.idAssessment')
                                        ->join('assessment_type','assessment_type.id','=','ratings.idAssessmentType')
                                        ->join('matter','matter.id','=','ratings.idMatter')
                                        ->where('ratings.idMatter',$assessment[$k]['idMatter'])
                                        ->where('assessment_type.id',$assessmentType[$n]['id'])
                                        ->where('ratings.idStudent',$tabNote['user'][0]['id'])
                                        ->where('ratings.idTypeEvaluation',$typeEvaluation[$l]['id'])
                                        ->first();


                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                    if(!empty($ratings['value'])){
                                        $total = $total + $ratings['value'];
                                        $rating_exits = $rating_exits + 1;

                                        if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                            switch ($assessmentType[$n]['id']) {
                                                case 1:
                                                    $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                    }
                                                    break;
                                                case 2:
                                                    $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                    }
                                                    break;
                                                case 3:
                                                    $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                    }
                                                    break;
                                                case 4:
                                                    $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                    }
                                                    break;
                                                case 5:
                                                    $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                    }
                                                    break;
                                                case 6:
                                                    $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                    }
                                                    break;
                                                case 7:
                                                    $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                    if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                        $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                    }
                                                    break;
                                                case 8:
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
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = $total;
                                }else{
                                    $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['total_trimestre'] = null;
                                }


                            }

                        }

                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment1'] = $total_note_assessment1;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment2'] = $total_note_assessment2;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment3'] = $total_note_assessment3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment4'] = $total_note_assessment4;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment5'] = $total_note_assessment5;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment6'] = $total_note_assessment6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment7'] = $total_note_assessment7;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['total_note_assessment8'] = $total_note_assessment8;
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
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre1'] = $trimestre1 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre2'] = $trimestre2 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['trimestre3'] = $trimestre3 ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['sommeTrimestre'] = $sommeTrimestre ;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2 + $totalSequence3;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre2'] = $totalSequence4 + $totalSequence5 + $totalSequence6;
                        $tabNote['user'][0]['matterGroup'][$j]['assessment'][$k]['totalTrimestre3'] = $totalSequence7 + $totalSequence8;

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

                if($total_notemax_assessment != 0){
                    $tabNote['user'][0]['totalNoteMax'] = $total_notemax_assessment;
                    $tabNote['user'][0]['totalSequence1User'] = $totalSequence1User;
                    $tabNote['user'][0]['totalSequence2User'] = $totalSequence2User;
                    $tabNote['user'][0]['totalSequence3User'] = $totalSequence3User;
                    $tabNote['user'][0]['totalSequence4User'] = $totalSequence4User;
                    $tabNote['user'][0]['totalSequence5User'] = $totalSequence5User;
                    $tabNote['user'][0]['totalSequence6User'] = $totalSequence6User;
                    $tabNote['user'][0]['totalSequence7User'] = $totalSequence7User;
                    $tabNote['user'][0]['totalSequence8User'] = $totalSequence8User;
                    $tabNote['user'][0]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                    $tabNote['user'][0]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                }


            }else if(!empty($request['idTrimestre'])){

            }else{
                $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                    'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                    'classes.name as classe','classes.idTeacher as idTeacher')
                    ->join('classes','classes.id','=','users.idClasse')
                    ->where('users.idClasse',$request['idClasse'])
                    ->where('users.deleted',0)
                    ->orderBy("users.name", "asc")
                    ->get();
                $tabNote['user'] = $entete;

                $total_moy_eleve = null;
                //$total_matiere = null;
                for ($i=0; $i < $entete->count(); $i++) {
                    $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                        ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                        ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
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

                    for ($j=0; $j < $matterGroup->count(); $j++) {
                        $assessment = Assessment::select('assessments.id as id','assessments.notemax as notemax','assessments.oral as oral','assessments.ecrit as ecrit','assessments.written as written','assessments.orale as orale','assessments.pratique as pratique','assessments.attitude as attitude','assessments.savoir_etre as savoir_etre','assessments.pratical as pratical','matter.id as idMatter','matter.code as codeMatter','matter.libelle as libelleMatter','matter.name as nameMatter')
                            ->join('matter','matter.id','=','assessments.idMatter')
                            ->join('matter_group_has_matter','matter_group_has_matter.matter_id','=','matter.id')
                            ->join('matter_group','matter_group.id','=','matter_group_has_matter.matter_group_id')
                            ->where('matter_group.id',$matterGroup[$j]['id'])
                            ->where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'] = $assessment;

                        $total_notemax_assessment = Assessment::where('assessments.idSchool',$request['idSchool'])
                            ->where('assessments.idSection',$request['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->sum('assessments.notemax');

                        for ($k=0; $k < $assessment->count(); $k++) {
                            $typeEvaluation = TypeEvaluation::select('type_evaluation.id','type_evaluation.name','assessments_has_type_evaluation.assessment_id')
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
                                //$total_matiere = $total_matiere + 1;
                                $trimestre = Trimestre::select('id','name')
                                    ->where('idSchool',$request['idSchool'])
                                    ->where('idSection',$request['idSection'])
                                    ->get();

                                $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'] = $trimestre;

                                //gérer l'affichage des points devant le type_evaluation
                                if(!empty($assessment[$k]['oral'])){
                                    if($typeEvaluation[$l]['name'] == "Oral")
                                        $typeEvaluation[$l]['value'] = $assessment[$k]['oral'];
                                }

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


                                        $tabNote['user'][$i]['matterGroup'][$j]['assessment'][$k]['typeEvaluation'][$l]['trimestre'][$m]['assessmentType'][$n]['ratings'] = $ratings;

                                        if(!empty($ratings['value'])){
                                            $total = $total + $ratings['value'];
                                            $rating_exits = $rating_exits + 1;

                                            if($assessment[$k]['nameMatter'] = $ratings['nameMatter']){
                                                switch ($assessmentType[$n]['id']) {
                                                    case 1:
                                                        $totalSequence1 = $totalSequence1 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment1 = $total_note_assessment1 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 2:
                                                        $totalSequence2 = $totalSequence2 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment2 = $total_note_assessment2 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 3:
                                                        $totalSequence3 = $totalSequence3 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment3 = $total_note_assessment3 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 4:
                                                        $totalSequence4 = $totalSequence4 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment4 = $total_note_assessment4 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 5:
                                                        $totalSequence5 = $totalSequence5 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment5 = $total_note_assessment5 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 6:
                                                        $totalSequence6 = $totalSequence6 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment6 = $total_note_assessment6 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 7:
                                                        $totalSequence7 = $totalSequence7 + $ratings['value'];
                                                        if($assessment[$k]['id'] = $typeEvaluation[$l]['assessment_id']){
                                                            $total_note_assessment7 = $total_note_assessment7 + $ratings['value'];
                                                        }
                                                        break;
                                                    case 8:
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

                    if($total_notemax_assessment != 0){
                        $tabNote['user'][$i]['totalNoteMax'] = $total_notemax_assessment;
                        $tabNote['user'][$i]['totalSequence1User'] = $totalSequence1User;
                        $tabNote['user'][$i]['totalSequence2User'] = $totalSequence2User;
                        $tabNote['user'][$i]['totalSequence3User'] = $totalSequence3User;
                        $tabNote['user'][$i]['totalSequence4User'] = $totalSequence4User;
                        $tabNote['user'][$i]['totalSequence5User'] = $totalSequence5User;
                        $tabNote['user'][$i]['totalSequence6User'] = $totalSequence6User;
                        $tabNote['user'][$i]['totalSequence7User'] = $totalSequence7User;
                        $tabNote['user'][$i]['totalSequence8User'] = $totalSequence8User;
                        $tabNote['user'][$i]['moyenneSequence1'] = number_format((($totalSequence1User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence2'] = number_format((($totalSequence2User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence3'] = number_format((($totalSequence3User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence4'] = number_format((($totalSequence4User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence5'] = number_format((($totalSequence5User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence6'] = number_format((($totalSequence6User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence7'] = number_format((($totalSequence7User * 20) / ($total_notemax_assessment-20)),2);
                        $tabNote['user'][$i]['moyenneSequence8'] = number_format((($totalSequence8User * 20) / ($total_notemax_assessment-20)),2);
                    }
                }

                /******************************************************Debut calcul rang ********************************************/

                // Tableau des séquences
                $sequences = ['moyenneSequence1', 'moyenneSequence2', 'moyenneSequence3', 'moyenneSequence4', 'moyenneSequence5', 'moyenneSequence6', 'moyenneSequence7', 'moyenneSequence8'];

                // Tableau associatif pour stocker les rangs pour chaque séquence
                $rangsParSequence = [];

                // Boucle sur chaque séquence
                foreach ($sequences as $sequence) {
                    // Étape 1 : Extraire les moyennes des élèves dans un tableau séparé
                    $moyennes = [];
                    foreach ($tabNote['user'] as $userId => $user) {
                        $moyennes[$userId] = $user[$sequence];
                    }

                    // Étape 2 : Trier le tableau des moyennes par ordre décroissant
                    arsort($moyennes);

                    // Étape 3 : Calculer le rang de chaque élève et associer le rang à l'ID de l'utilisateur
                    $rangs = [];
                    $rank = 1;
                    foreach ($moyennes as $userId => $moyenne) {
                        $rangs[$userId] = $rank;
                        $rank++;
                    }

                    // Étape 4 : Réintégrer les rangs dans le tableau d'utilisateurs
                    foreach ($tabNote['user'] as $userId => &$user) {
                        $user['rang_'.$sequence] = $rangs[$userId];
                    }

                    // Stocker les rangs dans le tableau global
                    $rangsParSequence[$sequence] = $rangs;
                }

                // Maintenant, $tabNote['user'] contient les rangs pour chaque séquence, et $rangsParSequence contient les rangs pour chaque séquence séparément




                /******************************************************fin calcul rang ********************************************/
            }

            //$tabNote['total_note_eleve'] = $total_note_eleve;
            //$tabNote['total_matiere'] = $total_matiere;
            //$tabNote['moyenne_classe_annuel'] = ($total_note_eleve / $total_matiere)/$effectifClasse;

            return $this->sendResponse($tabNote, 'Bulletins');

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }

        die;
        if(isset($request['idAssessmentType'])) return $this->bulletinSequence($request);

        else if(isset($request['idTrimestre'])) return $this->buleltinTrimestre($request);

        else return $this->bulletinAnnuel($request);
    }

    public function bulletinSequence(array $request)
    {
        try {
            return "Hello Séquence";
        } catch (\Throwable $th) {
            throw new ServiceException('Error BulletinPrimaireService::bulletinSequence --- ' . $th->getMessage());
        }
    }

    public function buleltinTrimestre(array $request)
    {
        try {
            $tabNote = array();
            $tabNoteCopy = array();
            $trimestre1 = array();
            $trimestre2 = array();
            $trimestre3 = array();

            $classe = Classes::find($request['idClasse']);

            $effectifClasse = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('roles.id',8)
                ->where('users.idSchool',$classe['idSchool'])
                ->where('users.idSection',$classe['idSection'])
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->count();

            $level_classe = $classe->idLevel;

            $tabNote['effectifClasse'] = $effectifClasse;
            $entete = null;

            $entete = User::select('users.id as id','users.name as name','users.firstname as firstname','users.gender as gender','users.birthday as birthday',
                'users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule',
                'classes.name as classe','classes.idTeacher as idTeacher')
                ->join('classes','classes.id','=','users.idClasse')
                ->where('users.idClasse',$request['idClasse'])
                ->where('users.deleted',0)
                ->orderBy("users.name", "asc")
                ->get();
            $tabNote['user'] = $entete;

            $total_moy_eleve = null;
            $moyClasse = null;
            //$total_matiere = null;
            for ($i=0; $i < $entete->count(); $i++) {


                $trimestre = Trimestre::select('id','name')
                    ->where('idSchool',$classe['idSchool'])
                    ->where('idSection',$classe['idSection'])
                    ->where('id',$request['idTrimestre'])
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
                $totalCoefTrim = null;

                $moyseq1 = null;
                $moyseq2 = null;
                $moyseq3 = null;
                $moyseq4 = null;
                $moyseq5 = null;
                $moyseq6 = null;


                $assessmentType = AssessmentType::select('id','name')
                    ->where('idSchool',$classe['idSchool'])
                    ->where('idSection',$classe['idSection'])
                    ->where('idTrimestre',$trimestre[0]['id'])
                    ->get();

                $tabNote['user'][$i]['trimestre'][0]['assessmentType'] = $assessmentType;

                for ($k=0; $k < $assessmentType->count(); $k++) {

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

                    /*
                    $teachername = User::select('users.name as teacherName','modules.name as moduleName')
                                        ->join('modules','modules.idTeacher','=','users.id')
                                        ->join('progressions','progressions.id','=','modules.idProgression')
                                        ->where('progressions.idClasse',$request['idClasse'])
                                        ->get();
                    */

                    //for ($l=0; $l < $typeEvaluation->count(); $l++) { ********************************* ici ****************************************************
                    //$total_matiere = $total_matiere + 1;
                    $rating_exits = null;
                    $matterGroup = null;

                    if(!empty($request['idOptionLevel'])){
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->where('matter_group.idSchool',$classe['idSchool'])
                            ->where('matter_group.idSection',$classe['idSection'])
                            ->where('matter_group..idOptionLevel',$request['idOptionLevel'])
                            ->orderBy("id", "asc")
                            ->get();
                    }else{
                        $matterGroup = MatterGroup::select('matter_group.id as id','matter_group.name as name','matter_group.description as description')
                            ->join('matter_group_has_level','matter_group_has_level.matter_group_id','=','matter_group.id')
                            ->where('matter_group_has_level.level_id',$level_classe['idLevel'])
                            ->where('matter_group.idSchool',$classe['idSchool'])
                            ->where('matter_group.idSection',$classe['idSection'])
                            ->orderBy("id", "asc")
                            ->get();
                    }

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'] = $matterGroup;

                    $coefficientSum = Assessment::selectRaw('SUM(coefficients.value) as coefficient_sum')
                        ->join('assessments_has_assessment_type', 'assessments_has_assessment_type.assessment_id', '=', 'assessments.id')
                        ->join('assessment_type','assessment_type.id','=','assessments_has_assessment_type.assessment_type_id')
                        ->join('coefficients', 'assessments.idCoeficient', '=', 'coefficients.id')
                        ->join('ratings','ratings.idAssessment','=','assessments.id')
                        ->where('assessment_type.id', $assessmentType[$k]['id'])
                        ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                        ->whereNotNull('ratings.value')
                        ->get();
                    /*
                    Rating::selectRaw('SUM(coefficients.value) as coefficient_sum')
                                                ->join('assessment_type', 'assessment_type.id', '=', 'ratings.idAssessmentType')
                                                ->join('coefficients', 'ratings.idCoeficient', '=', 'coefficients.id')
                                                ->where('assessment_type.id', $assessmentType[$k]['id'])
                                                ->where('ratings.idStudent', $tabNote['user'][$i]['id'])
                                                ->whereNotNull('ratings.value')
                                                ->get();
                                                */
                    switch ($assessmentType[$k]['id']) {
                        case 1:
                            $totalCoef1 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case 2:
                            $totalCoef2 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case 3:
                            $totalCoef3 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case 4:
                            $totalCoef4 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case 5:
                            $totalCoef5 = $coefficientSum[0]['coefficient_sum'];
                            break;
                        case 6:
                            $totalCoef6 = $coefficientSum[0]['coefficient_sum'];
                            break;
                    }

                    for ($x=0; $x < $matterGroup->count(); $x++) {

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
                            ->where('assessments.idSchool',$classe['idSchool'])
                            ->where('assessments.idSection',$classe['idSection'])
                            ->where('assessments.idClasse',$request['idClasse'])
                            ->where('matter_group.id',$matterGroup[$x]['id'])
                            ->where('assessment_type.id',$assessmentType[$k]['id'])
                            ->orderBy("id", "asc")
                            ->get();

                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'] = $assessment;
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
                                ->where('assessment_type.id',$assessmentType[$k]['id'])
                                ->where('ratings.idStudent',$tabNote['user'][$i]['id'])
                                ->first();




                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['ratings'] = $ratings;

                            if(!empty($teachername)){
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[0]['teacherName'];
                            }

                            /*
                            for($p=0; $p < $teachername->count(); $p++) {
                                if($teachername[$p]['moduleName'] = $assessment[$n]['nameMatter']){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['assessment'][$n]['tearcherName'] = $teachername[$p]['teacherName'];
                                }
                            }
                            */

                            if(!empty($ratings['coefficient'])){
                                $totalCoefMatterGroupAssessment =  $totalCoefMatterGroupAssessment + $ratings['coefficient'];
                            }

                            if(!empty($ratings['value'])){
                                $total = $total + $ratings['value'];
                                $rating_exits = $rating_exits + 1;
                                $totalNoteCoef = $totalNoteCoef + $ratings['noteCoef'];


                                if($assessment[$n]['nameMatter'] === $ratings['nameMatter']){
                                    switch ($assessmentType[$k]['id']) {
                                        case 1:
                                            $totalSequence1 = $totalSequence1 + $ratings['noteCoef'];
                                            break;
                                        case 2:
                                            $totalSequence2 = $totalSequence2 + $ratings['noteCoef'];
                                            break;
                                        case 3:
                                            $totalSequence3 = $totalSequence3 + $ratings['noteCoef'];
                                            break;
                                        case 4:
                                            $totalSequence4 = $totalSequence4 + $ratings['noteCoef'];
                                            break;
                                        case 5:
                                            $totalSequence5 = $totalSequence5 + $ratings['noteCoef'];
                                            break;
                                        case 6:
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
                        $MatterGroupId = $matterGroup[$x]['id'] ;
                        switch ($matterGroup[$x]['id']) {
                            case $MatterGroupId:
                                if($totalCoefMatterGroup1 != 0){
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteByMatterGroup'] = $total;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalCoefMatterGroupAssessment'] = $totalCoefMatterGroupAssessment;
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['totalNoteCoefByMatterGroup'] = $totalNoteCoefMatterGroup1;
                                    $cleanNumber = str_replace(',', '.', number_format($totalNoteCoefMatterGroup1 / $totalCoefMatterGroupAssessment,2));
                                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['matterGroup'][$x]['MoyenneMatterGroup'] = floatval($cleanNumber);
                                    $totalSeq = $totalSeq + $total;
                                    $totalCoefSeq = $totalCoefSeq + $totalCoefMatterGroupAssessment;
                                }

                                break;
                        }
                    }//MatterGroup boucle fin*******************************************************************



                    if(!empty($rating_exits) && $rating_exits != 0){
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['termAv'] = $total;
                        //$tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['total'] = ($total/$assessmentType->count())*$coefficient['coefficient'];
                        //$totaltermAv = $totaltermAv + ($total/$assessmentType->count())*$coefficient['coefficient'];
                    }else{
                        $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['total_trimestre'] = null;
                    }




                    //} *************************************************************** ici ***********************************************
                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequence'] = $totalSeq;
                    switch ($assessmentType[$k]['id']) {
                        case 1:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence1;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence1 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq1 = floatval($cleanNumber);
                            }
                            $totalSequence1User = $totalSequence1User + $totalSequence1;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq1;
                            break;
                        case 2:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence2;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence2 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq2 = floatval($cleanNumber);
                            }
                            $totalSequence2User = $totalSequence2User + $totalSequence2;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq2;
                            break;
                        case 3:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence3;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence3 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq3 = floatval($cleanNumber);
                            }
                            $totalSequence3User = $totalSequence3User + $totalSequence3;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq3;
                            break;
                        case 4:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence4;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence4 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq4 = floatval($cleanNumber);
                            }
                            $totalSequence4User = $totalSequence4User + $totalSequence4;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq4;
                            break;
                        case 5:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence5;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence5 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq5 = floatval($cleanNumber);
                            }
                            $totalSequence5User = $totalSequence5User + $totalSequence5;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq5;
                            break;
                        case 6:
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceNoteCoef'] = $totalSequence6;
                            $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['totalSequenceCoef'] = $totalCoefSeq;
                            if($totalCoefSeq != 0){
                                $cleanNumber = str_replace(',', '.', number_format($totalSequence6 / $totalCoefSeq,2));
                                $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$k]['moyenne'] = floatval($cleanNumber);
                                $moyseq6 = floatval($cleanNumber);
                            }
                            $totalSequence6User = $totalSequence6User + $totalSequence6;
                            $totalCoefTrim = $totalCoefTrim + $totalCoefSeq;
                            $moyClasse = $moyClasse + $moyseq6;
                            break;
                    }



                    //methode avec deux sequences par trimestre

                    /*
                    switch ($trimestre[$j]['id']) {
                        case '1':
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence1'] = $totalSequence1;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence2'] = $totalSequence2;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre1'] = $totalSequence1 + $totalSequence2;
                            break;
                        case '2':
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence3'] = $totalSequence3;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence4'] = $totalSequence4;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre2'] = $totalSequence3 + $totalSequence4;
                            break;
                        case '3':
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence5'] = $totalSequence5;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalSequence6'] = $totalSequence6;
                            $tabNote['user'][$i]['trimestre'][$j]['assessmentType'][$k]['totalTrimestre3'] = $totalSequence5 + $totalSequence6;
                            break;
                    }
                    */

                }

                $santion = Sanction::where('idUser',$entete[$i]['id'])
                    ->count();

                $absence = Absence::where('idStudent',$entete[$i]['id'])
                    ->count();

                //bonne moyenne 1
                switch ($trimestre[0]['id']) {
                    case 1:
                        if($totalCoef1 != 0 && $totalCoef2 != 0){
                            $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
                            $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence1User + $totalSequence2User)/2;
                            if(!empty($totalSequence1User) && $totalSequence1User != 0 && !empty($totalSequence2User) && $totalSequence2User != 0){
                                $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq1 + $moyseq2)/2,2);
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                            }
                        }

                        break;

                    case 2:
                        if($totalCoef3 != 0 && $totalCoef4 != 0){
                            $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
                            $tabNote['user'][$i]['trimestre'][0]['total'] = ($totalSequence3User + $totalSequence4User)/2;
                            if(!empty($totalSequence3User) && $totalSequence3User != 0 && !empty($totalSequence4User) && $totalSequence4User != 0){
                                $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestreOld'] = number_format((($totalSequence3User / $totalCoef3)+($totalSequence4User / $totalCoef4))/2,2);
                                $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = number_format(($moyseq3 + $moyseq4)/2,2);
                            }else{
                                $tabNote['user'][$i]['trimestre'][0]['moyenneTrimestre'] = null;
                            }
                        }

                        break;

                    case 3:
                        if($totalCoef5 != 0 && $totalCoef6 != 0){
                            $tabNote['user'][$i]['trimestre'][0]['totalCoef'] = $totalCoefTrim/2;
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

            if($effectifClasse != 0){
                $tabNote['moyenneClasse'] = floatval(str_replace(',', '.', number_format(($moyClasse /2) / $effectifClasse,2)));
            }else{
                $tabNote['moyenneClasse'] = null;
            }

            /******************************************************Debut calcul rang ********************************************/
            for ($i = 0; $i < $entete->count(); $i++) {
                // ... Autres calculs ...

                // Calcul du rang par trimestre
                $rangementsTrimestre = [];
                foreach ($tabNote['user'] as $key => $value) {
                    $rangementsTrimestre[$key] = $value['trimestre'][0]['moyenneTrimestre'];
                }

                // Triez les moyennes en ordre décroissant et conservez les clés associatives
                arsort($rangementsTrimestre);

                // Attribuez le rang à chaque moyenne
                $rang = 1;
                $previousMoyenne = null;
                foreach ($rangementsTrimestre as $key => $moyenne) {
                    if ($moyenne !== $previousMoyenne) {
                        $previousMoyenne = $moyenne;
                        $rangementsTrimestre[$key] = $rang;
                    } else {
                        $rangementsTrimestre[$key] = $rang;
                    }
                    $rang++;
                }

                // Affectez le rang à l'utilisateur actuel
                $tabNote['user'][$i]['trimestre'][0]['rangTrimestre'] = $rangementsTrimestre[$i] ?? null;

                // ... Autres calculs ...
            }

            //calculer le rang par sequence
            for ($i = 0; $i < count($tabNote['user']); $i++) {
                for ($j = 0; $j < count($tabNote['user'][$i]['trimestre'][0]['assessmentType']); $j++) {
                    $currentMoyenne = $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                    $rank = 1;

                    for ($k = 0; $k < count($tabNote['user']); $k++) {
                        if ($k != $i) {
                            $compareMoyenne = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['moyenne'];
                            if ($compareMoyenne > $currentMoyenne) {
                                $rank++;
                            } elseif ($compareMoyenne == $currentMoyenne) {
                                // En cas d'égalité, le rang est le même
                                $rank = $tabNote['user'][$k]['trimestre'][0]['assessmentType'][$j]['rang'];
                            }
                        }
                    }

                    $tabNote['user'][$i]['trimestre'][0]['assessmentType'][$j]['rang'] = $rank;
                }
            }

            return $tabNote;
        } catch (\Throwable $th) {
            throw new ServiceException('Error BulletinPrimaireService::buleltinTrimestre --- ' . $th->getMessage());
        }
    }

    public function bulletinAnnuel(array $request)
    {
        try {

        } catch (\Throwable $th) {
            throw new ServiceException('Error BulletinPrimaireService::bulletinAnnuel --- ' . $th->getMessage());
        }
    }
}

