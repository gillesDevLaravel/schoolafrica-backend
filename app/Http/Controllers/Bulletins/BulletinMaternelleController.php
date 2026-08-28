<?php

namespace App\Http\Controllers\Bulletins;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GenererBulletinMaternelleClassiqueRequest;
use App\Http\Requests\Admin\GenererBulletinMaternelleSequenceRequest;
use App\Http\Requests\Admin\GenererBulletinPrimaireTrimestreRequest;
use App\Models\Absence;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Establishment;
use App\Models\Key;
use App\Models\MatterGroup;
use App\Models\Rating;
use App\Models\Sanction;
use App\Models\School;
use App\Models\Section;
use App\Models\Trimestre;
use App\Models\TypeEvaluation;
use App\Models\User;
use App\Services\PensionUserService;
use App\Traits\DataBulletinsTrait;
use App\Traits\DeletePDFTmpFilesTrait;
use App\Traits\ManageDirectoryTrait;
use Dompdf\Dompdf;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Mockery\Exception;

/**
 * @group Bulletins Maternelle
 */
class BulletinMaternelleController extends BaseController
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait, DataBulletinsTrait;

    protected $pensionUserService;
    private $listRoleSimple = [7, 8];

    public function __construct(PensionUserService $pensionUserService)
    {
        $this->pensionUserService = $pensionUserService;
    }


    /**
     * Générer buleltin(s) séquence de la maternelle
     *
     * @param GenererBulletinMaternelleSequenceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinMaternelleSequence(GenererBulletinMaternelleSequenceRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             *
             * BD: dev
             * { "username":"dev", "password":"000011", "idClasse":19, "idAssessmentType":9, "idUser":22 }
             *
             * BD:juniors
             * { "username":"fondateur", "password":"000000", "idClasse":17, "idAssessmentType":7, "idUser":472, "lang":"en", "route":"juniors" }
             * { "username": "fondateur", "password": "000000", "idClasse": 17, "idAssessmentType": 7, "idUser": 472, "lang": "en", "route": "juniors", "forSolvables": true}
             */

            $this->createDirectory('pdfs');

            ini_set('max_execution_time', 300);

            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $assessmentType = AssessmentType::find($request->idAssessmentType);
            $num_sequence = $assessmentType->name[strlen($assessmentType->name)-1];

            $route = $request->route;

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
            unset($requestData['idUser']);

//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
            //return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

            Cache::forget("infosBulletinsMaternelleSequence".$requestData['idClasse']);
            $infosBulletins = (object) cache()->remember("infosBulletinsMaternelleSequence".$requestData['idClasse'], 12000, function() use ($requestData, $route) {
//                return ($route == "juniors")
                return (in_array($route, ['lacledusavoir', 'lesalouettes']))
                    ? $this->bulletinMaternelleGeneral($requestData) //affiche les notes de 1 à 4 en images --- uniquement les alouettes et lacledusavoir
                    : $this->bulletinMaternelleJuniors($requestData); // affiche les notes /20 en images ---- juniors et tous les autres
            });


            if($infosBulletins->effectifClasse == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins;

            $zip_file = "Bul-mat-".Str::slug($classe->name)."-sequence-".Str::slug($assessmentType->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $cle = Key::where('route', $request['route'])->first();

            $liensBulletins = array();

            if(!is_null($idUser)){
                $infosBulletins->user = collect($infosBulletins->user)->filter(function($user) use ($idUser){
                    return $user->id == $idUser;
                })->values();
            }

//            return response()->json($infosBulletins->user[0]);
//            $moyenne_generale = array_sum(array_map('floatval', $moyenneStudents)) / $json_data->effectifClasse;

            for ($case = 0; $case < count($infosBulletins->user); $case++){

                $user = $infosBulletins->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $user->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))){

                    $data = [
                        'effectifClasse' => $json_data->effectifClasse,
                        'classe' => $classe,
                        'teacher_principal' => $classe->teacher,
                        'user' => $user,
                        'section' => $section,
                        'assessmentType' => $assessmentType,
                        'school' => $school,
                        'establishment' => $establishment,
                        'code_couleurs' => $code_couleurs,
                        'num_sequence' => $num_sequence, // 1, 2, 3, ....
    //                    'first_moyenne' => $moyenneStudents[0],
    //                    'last_moyenne' => end($moyenneStudents),
    //                    'class_average' => round($moyenne_generale, 2),
    //                    'class_success_percentage' => round(($nbreReussite*100) / $json_data->effectifClasse, 2)
                    ];

//                    return $data;

                    $filename = Str::slug($json_data->user[$case]->name);

                    $dompdf = new Dompdf();

                    $folder = "bulletin.maternelle.sequence";

                    // Désormais, tout le monde a le template de juniors sauf les 2 ci
                    if(in_array($route, ['lacledusavoir', 'lesalouettes'])){
                        $vue = $folder.".default";
                    }else{
                        $vue = $folder.".juniors";
                    }
//                    (view()->exists($folder."." . $route))
//                        ? $vue = $folder."." . $route
//                        : $vue = $folder.".default";

//                    return $vue;

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

//                    $filename = Str::slug($json_data->user[$case]->name);
//
//                    $dompdf = new Dompdf();
//
//                    $folder = "bulletin.maternelle.sequence";
//
//                    (view()->exists($folder."." . $route))
//                        ? $vue = $folder."." . $route
//                        : $vue = $folder.".default";
//
//                    // Récupérer la vue
//                    $view = View::make($vue)->with($data);
//                    //$view = View::make('receipt')->with($formattedData);
//
//                    // Récupérer le contenu de la vue
//                    $html = $view->render();
//
//                    // Charger le contenu HTML dans Dompdf
//                    $dompdf->loadHtml($html);
//
//                    // (Optionnel) Définir la taille et l'orientation du papier
//                    $dompdf->setPaper('A4', 'portrait');
//
//                    // Exécuter le rendu du PDF
//                    $dompdf->render();
//
//                    file_put_contents(public_path("pdfs/$filename-bulletin-matternelle-sequence.pdf"), $dompdf->output());
//
//                    if(count($infosBulletins->user) > 1){
//
//                        $zip->addFile("pdfs/$filename-bulletin-matternelle-sequence.pdf");
//
//                        $liensBulletins[] = public_path("pdfs/$filename-bulletin-matternelle-sequence.pdf");
//                    }else{
//                        return $this->sendResponse(asset("pdfs/$filename-bulletin-matternelle-sequence.pdf"), "Bulletin matternelle sequence");
//                    }
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin maternelle");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function genererBulletinMaternelleTrimestre(GenererBulletinPrimaireTrimestreRequest $request)
    {
        try {
            $route = $request['route'];

            if(in_array($route, ['lacledusavoir', 'lesalouettes'])){
                return $this->genererBulletinMaternelleClassique($request);
            }else{
                return $this->genererBulletinMaternelleTrimestreGeneral($request);
            }
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer bulletin(s) trimestre de la maternelle général
     *
     * @param GenererBulletinPrimaireTrimestreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinMaternelleTrimestreGeneral($request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             *
             * BD: dev
             * { "username":"dev", "password":"000011", "idClasse":19, "idAssessmentType":9, "idTrimestre":7, "idUser":22, "route":"dev"}
             *
             * BD:juniors
             * { "username":"fondateur", "password":"000000", "idClasse":17, "idAssessmentType":7, "idTrimestre":4, "idUser":472, "lang":"en", "route":"juniors" }
             * { "username":"fondateur", "password":"000000", "idClasse":17, "idAssessmentType":7, "idTrimestre":4, "idUser":472, "lang":"en", "route":"juniors", "forSolvables":true }
             */

            $this->createDirectory('pdfs');

            ini_set('max_execution_time', 300);

            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $trimestre = Trimestre::find($request->idTrimestre);
            $assessmentType = $trimestre->assessmentTypes()->first();
            $num_sequence = $assessmentType->name[strlen($assessmentType->name)-1];

            $route = $request->route;

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $requestData['idTrimestre'] = $request->idTrimestre;
            $requestData['idAssessmentType'] = $trimestre->assessmentTypes()->first()->id;

            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
            unset($requestData['idUser']);

//Block de vérification des insolvables
            $insolvables = $this->listeInsolvables($request, $classe->idSchool, $classe->idSection);
//            return $insolvables;

            //Vérification directe si on veut pour un seul utilisateur
            if($idUser != null && !in_array($this->getRole()->id, $this->listRoleSimple)){
                if(!is_null($request['forSolvables']) && $request['forSolvables'] && !$this->isSolvable($insolvables, $idUser)){
                    return $this->sendError("L'élève n'a pas payé la totalité de la ${insolvables['Tranche']}");
                }
            }
            else if ($idUser != null && !$this->isSolvable($insolvables, $idUser)){
                return $this->sendError("Veuillez payer la totalité de la ${insolvables['Tranche']} pour télécharger le bulletin");
            }
//Fin de vérification des insolvables

            Cache::forget("infosBulletinsMaternelleTrimestre".$requestData['idClasse']);
            $infosBulletins = (object) cache()->remember("infosBulletinsMaternelleTrimestre".$requestData['idClasse'], 12000, function() use ($requestData, $route) {
                return (in_array($route, ['lacledusavoir', 'lesalouettes']))
                    ? $this->bulletinMaternelleTrimestrielGeneral($requestData) //affiche les notes de 1 à 4 en images --- uniquement les alouettes et lacledusavoir
                    : $this->bulletinPrimaireSequence($requestData); // affiche les notes /20 en images ---- juniors et tous les autres
//                return ($route == "juniors")
//                    ? $this->bulletinPrimaireSequence($requestData) // affiche les notes /20 en images
//                    : $this->bulletinMaternelleTrimestrielGeneral($requestData); //affiche les notes de 1 à 4 en images
            });

            if($infosBulletins->effectifClasse == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins;

            $zip_file = "Bul-mat-".Str::slug($classe->name)."-sequence-".Str::slug($assessmentType->name).".zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $cle = Key::where('route', $request['route'])->first();

            $liensBulletins = array();

            if(!is_null($idUser)){
                $infosBulletins->user = collect($infosBulletins->user)->filter(function($user) use ($idUser){
                    return $user->id == $idUser;
                })->values();
            }

//            return response()->json($infosBulletins->user[0]);
//            $moyenne_generale = array_sum(array_map('floatval', $moyenneStudents)) / $json_data->effectifClasse;

            for ($case = 0; $case < count($infosBulletins->user); $case++){

                $user = $infosBulletins->user[$case];

                //Générer les bulletins uniquement pour les solvables ou pour tout le monde si le fondateur le veut
                if($this->isSolvable($insolvables, $user->id) || (!in_array($this->getRole()->id, $this->listRoleSimple) && (is_null($request['forSolvables']) || !$request['forSolvables']))) {

                    $data = [
                        'effectifClasse' => $json_data->effectifClasse,
                        'classe' => $classe,
                        'teacher_principal' => $classe->teacher,
                        'user' => $user,
                        'trimestre' => $trimestre,
                        'section' => $section,
                        'assessmentType' => $assessmentType,
                        'school' => $school,
                        'establishment' => $establishment,
                        'code_couleurs' => $code_couleurs,
                        'num_sequence' => $num_sequence, // 1, 2, 3, ....
                        //                    'first_moyenne' => $moyenneStudents[0],
                        //                    'last_moyenne' => end($moyenneStudents),
                        //                    'class_average' => round($moyenne_generale, 2),
                        //                    'class_success_percentage' => round(($nbreReussite*100) / $json_data->effectifClasse, 2)
                    ];

//                                    return $data;

                    $filename = Str::slug($json_data->user[$case]->name);

                    $dompdf = new Dompdf();

                    $folder = "bulletin.maternelle.trimestre";

                    // Désormais, tout le monde a le template de juniors sauf les 2 ci
                    if(in_array($route, ['lacledusavoir', 'lesalouettes'])){
                        $vue = $folder.".default";
                    }else{
                        $vue = $folder.".juniors";
                    }
//                    (view()->exists($folder . "." . $route))
//                        ? $vue = $folder . "." . $route
//                        : $vue = $folder . ".default";

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

                    file_put_contents(public_path("pdfs/$filename-bul-mat-trim.pdf"), $dompdf->output());

                    if (count($infosBulletins->user) > 1) {

                        $zip->addFile("pdfs/$filename-bul-mat-trim.pdf");

                        $liensBulletins[] = public_path("pdfs/$filename-bul-mat-trim.pdf");
                    } else {
                        return $this->sendResponse(asset("pdfs/$filename-bul-mat-trim.pdf"), "Bulletin matternelle trimestre");
                    }
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin maternelle trimestre");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer bulletin(s) avec structure classique (actuellement utilisé par lesalouettes & laclédusavoir)
     *
     * @return \Illuminate\Http\Response
     */
    public function genererBulletinMaternelleClassique($request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             * BD: juniors
             * { "username":"fondateur", "password":"000000", "idClasse": 10, "idUser":7, "idOptionLevel": 1, "idAssessmentType": 1, "route": "juniors", "lang": "fr" }
             */
            if(is_null($request->idTrimestre) && is_null($request->idAssessmentType)){
                throw new Exception("Vous devez choisir une séquence ou un trimestre.");
            }

            $this->createDirectory('pdfs');
            ini_set('max_execution_time', 300);
            //TODO: Récupérer les données ici pour le primaire
            $requestData = $request->validated();

            $classe = Classes::find($requestData['idClasse']);
            $school = School::find($classe->idSchool);
            $section = Section::find($classe->idSection);
            $route = $request['route'];

            if(!is_null($request->idTrimestre)){
                $periode = "trimestre";
                $trimestre = Trimestre::find($request->idTrimestre);
                $assessmentType = $trimestre->assessmentTypes()->first();
                $requestData['idAssessmentType'] = $assessmentType->id;

                $num_trimestre = mb_substr($trimestre->name, -1);
            }else{
                $periode = "sequence";
                $assessmentType = AssessmentType::find($request->idAssessmentType);
            }

            $num_sequence = $assessmentType->name[strlen($assessmentType->name)-1];

            $establishment = Establishment::first();
            $code_couleurs = explode(";", $establishment->code_couleur);

            $requestData['idSchool'] = $classe->idSchool;
            $requestData['idSection'] = $classe->idSection;
            $idUser = $requestData['idUser'] ?? null; //NB: On va garder cette valeur parce qu'on ne veut pas l'envoyer au endpoint qui récupère les notes de tous les étudiants
            unset($requestData['idUser']);

            //TODO: TOUJOURS désactiver le Cache avant de push
            Cache::forget("infosBulletinsMaternelleClassique" . $request->idClasse);
            $infosBulletins = (object) cache()->remember("infosBulletinsMaternelleClassique".$request->idClasse, 36000, function() use ($requestData) {
                return $this->bulletinPrimaireSequence($requestData, true);
//                return $this->bulletinMaternelleGeneral($requestData); // endpoint 'normal'
            });

            if($infosBulletins->effectifClasse == 0){
                return $this->sendError("Pas d'élèves avec de notes pour ces données");
            }

            $json_data = $infosBulletins;

//            return response()->json($json_data);

            $zip_file = "Bul-mat-".Str::slug($classe->name)."-$periode.zip";

            $zip = new \ZipArchive();
            $zip->open("pdfs/" .$zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $liensBulletins = array();

            $moyenneStudents = array();

            if($periode=="trimestre"){
                // RAS pour le moment

                $sequence_name = "moyenneSequence".$num_sequence;

                $moyenne_generale = round($infosBulletins->moyennesGenerales[$num_sequence-1], 2);

                foreach ($infosBulletins->user as $userData) {
                    $tmp_moyenne = 0; $nbre_moyennes_user = 0;

                    foreach ($trimestre->assessmentTypes as $assessmentType) {
                        $sequence_name = "moyenneSequence".mb_substr($assessmentType->name, -1);

                        $tmp_moyenne += $userData->$sequence_name;

                        if($userData->$sequence_name > 0) $nbre_moyennes_user++;
                    }

                    if($nbre_moyennes_user > 0){
                        $moyenneStudents[] = round($tmp_moyenne/$nbre_moyennes_user, 2);
                    }
                }
            }else{
                $sequence_name = "moyenneSequence".$num_sequence;

                $moyenne_generale = round($infosBulletins->moyennesGenerales[$num_sequence-1], 2);

                foreach ($infosBulletins->user as $userData) {
                    $moyenneStudents[] = @$userData->$sequence_name;
                }
            }

            arsort($moyenneStudents);

            $moyenneStudents = array_values($moyenneStudents);

            if(!is_null($request->idUser)){
                $idUser = $request->idUser;

                $infosBulletins->user = collect($infosBulletins->user)->filter(function($user) use ($idUser) {
                    return $user->id == $idUser;
                })->values();
            }

            if(count((array)$infosBulletins->user) == 0){
                return $this->sendError("idStudent {$idUser} invalide");
            }

            // On trouve les moyennes en grades (je sais pas comment dire ça ... regarde juste le code et tu vas comprendre)
            $legend_of_grade = [
                'nye' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud <=1;
                })),
                'nye_color' => "db0b32",
                'ae' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >1  && $moyenneStud <= 2;
                })),
                'ae_color' => "fdaa3e",
                'me' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >2 && $moyenneStud <=3;
                })),
                'me_color' => "0080ff",
                'abe' => count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >3;
                })),
                'abe_color' => "008000",
            ];

            for ($case = 0; $case < count($infosBulletins->user); $case++){
                $user = $infosBulletins->user[$case];

                $nbreReussite = count(array_filter($moyenneStudents, function($moyenneStud) {
                    return $moyenneStud >= 10;
                })); // Nombre d'élèves ayant plus de 10/20 de moyenne

                $dompdf = new Dompdf();

                $data = [
                    'effectifClasse' => $json_data->effectifClasse,
                    'classe' => $classe,
                    'teacher_principal' => $classe->teacher,
                    'user' => $user,
//                    'rang_sequence' => $user->$sequence,
                    'section' => $section,
                    'assessmentType' => $assessmentType,
                    'choosenTrimestre' => $trimestre ?? null,
                    'school' => $school,
                    'establishment' => $establishment,
                    'code_couleurs' => $code_couleurs,
                    'num_sequence' => $num_sequence, // 1, 2, 3, ....
                    'moyennes' => $moyenneStudents,
                    'first_moyenne' => $moyenneStudents[0],
                    'last_moyenne' => end($moyenneStudents),
                    'class_average' => $moyenne_generale,
                    'class_success_percentage' => round(($nbreReussite*100) / $json_data->effectifClasse, 2),
                    'legend_of_grade' => $legend_of_grade
                ];

//                return $data;

                $filename = Str::slug($json_data->user[$case]->name);

                $folder = "bulletin.maternelle.$periode";

                (view()->exists($folder."." . $route))
                    ? $vue = $folder."." . $route
                    : $vue = $folder.".classique";

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

                file_put_contents(public_path("pdfs/$filename-bul-mat-$periode.pdf"), $dompdf->output());

                if(count($infosBulletins->user) > 1){

                    $zip->addFile("pdfs/$filename-bul-mat-$periode.pdf");

                    $liensBulletins[] = public_path("pdfs/$filename-bul-mat-$periode.pdf");
                }else{
                    return $this->sendResponse(asset("pdfs/$filename-bul-mat-$periode.pdf"), "Bulletin maternelle $periode");
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensBulletins) {
                $this->deletePDFTempFiles($liensBulletins);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Bulletin maternelle $periode");
        }
        catch (\Throwable $th) {
//            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
