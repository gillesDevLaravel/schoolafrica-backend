<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Bulletins\BulletinPrimaireController;
use App\Http\Requests\Admin\CertificatScolariteRequest;
use App\Http\Requests\Document\BulletinPaieRequest;
use App\Http\Requests\Admin\InsolvableRequest;
use App\Http\Requests\Admin\InvoiceGetAllRequest;
use App\Http\Requests\Admin\ListFeesPDFRequest;
use App\Http\Requests\Admin\ListParentPDFRequest;
use App\Http\Requests\Admin\ListPensionPDFRequest;
use App\Http\Requests\Admin\ListSolvablesRequest;
use App\Http\Requests\Admin\ListStaffPDFRequest;
use App\Http\Requests\Admin\ListStudentPDFRequest;
use App\Http\Requests\Admin\ListUsersWithAssessmentsByMatterGroupPDFRequest;
use App\Http\Requests\Admin\ListUsersWithAssessmentsByMatterPDFRequest;
use App\Http\Requests\Admin\ListUsersWithAssessmentsPDFRequest;
use App\Http\Requests\Admin\PdfDesInsolvablesOuSolvablesRequest;
use App\Http\Requests\Admin\ListUsersWithMonthlyAssessmentsPDFRequest;
use App\Http\Requests\Admin\PdfDesInsolvablesRequest;
use App\Http\Requests\HonourRollRequest;
use App\Http\Requests\Staffs\CustomerRequest;
use App\Http\Requests\Staffs\PensionUserGetAllRequest;
use App\Http\Resources\Admin\UserAllResource;
use App\Http\Resources\Staffs\AssessmentResource;
use App\Http\Resources\Staffs\PensionUserResource;
use App\Http\Resources\StaffsSimp\InscriptionSimpResource;
use App\Models\AcademicYear;
use App\Models\Assessment;
use App\Models\AssessmentType;
use App\Models\Classes;
use App\Models\Customer;
use App\Models\Cycle;
use App\Models\Establishment;
use App\Models\FeeUser;
use App\Models\Invoice;
use App\Models\Level;
use App\Models\Matter;
use App\Models\MatterGroup;
use App\Models\OptionLevel;
use App\Models\PensionUser;
use App\Models\Rating;
use App\Models\School;
use App\Models\Fee;
use App\Models\Section;
use App\Models\Trimestre;
use App\Models\User;
use App\Services\FeeUserService;
use App\Services\PDFService;
use App\Services\PensionUserService;
use App\Traits\BulletinPrimaireTrait;
use App\Traits\ManageDirectoryTrait;
use App\Traits\DeletePDFTmpFilesTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * @group Documents
 */
class DocumentController extends BaseController
{
    use DeletePDFTmpFilesTrait, ManageDirectoryTrait, BulletinPrimaireTrait;

    protected $pensionUserService;
    protected $feeUserService;

    public function __construct(PensionUserService $pensionUserService, FeeUserService $feeUserService)
    {
        $this->createDirectory('pdfs'); // Beaucoup de méthodes dans ce controlleur utilisent ce dossier

        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 3600);

        $this->pensionUserService = $pensionUserService;
        $this->feeUserService = $feeUserService;

    }

    /**
     * Générer certificats de scolarité
     *
     * @param CertificatScolariteRequest $request
     * @return JsonResponse|\Illuminate\Http\Response
     */
    public function genererCertificatScolarite(CertificatScolariteRequest $request)
    {
        try {
            $idClasse = $request->idClasse ?? null;
            $idStudent = $request->idStudent ?? null;


            // Récupérer d'abord l'école à partir de la classe
            $classe = Classes::with('school')->findOrFail($idClasse);
            $school = $classe->school;
            $etab = Establishment::first();

            $users = User::select(
                'users.id',
                'users.name',
                'users.country',
                'users.gender',
                'users.birthday',
                'users.photo',
                'users.adresse',
                'users.idCycle',
                'users.idParent',
                'users.idClasse',
                'users.placeofbirth',
                'users.situation',
                'users.repeater',
                'users.matricule',
                'users.phone',
                'classes.name as classeName',
                'levels.name as levelName',
                'levels.idCycle as idCycle'
            )
                ->join('classes', 'classes.id', '=', 'users.idClasse')
                ->join('levels', 'levels.id', '=', 'users.idLevel')
                ->where('users.deleted', 0);

            if(!is_null($idClasse)){ $users = $users->where('users.idClasse', $idClasse); }
            if(!is_null($idStudent)){ $users = $users->where('users.id', $idStudent); }

            $users = $users
                ->orderBy('name')
                ->get();

            if(count($users) == 0){
                return $this->sendResponse("", "Pas d'élèves");
            }

            // Récupérer le directeur de l'école
            $director = User::whereHas('roles', function ($q) {
                $q->where('id', 3); // rôle Directeur
            })
            ->where('idSchool', $school->id)
            ->select('id', 'name')
            ->first();

//            return $school;

            $lienCertificatsScolarite = [];

            $zip_file = "certificats-de-scolarité-".date("y-m-d-h-i-s").".zip";

            if(count($users) > 1) {
                $zip = new \ZipArchive();
                $zip->open("pdfs/" . $zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            }

            $code_couleurs = explode(";", Establishment::first()->code_couleur);

            foreach ($users as $user){

//                $director = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle')
//                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
//                    ->join('roles','model_has_roles.role_id','=','roles.id')
//                    ->where('roles.id', 3)
//                    ->where('users.idSchool', $request->idSchool)
//                    ->first();

                $parent = User::select('id', 'name', 'mother')->find($user->idParent); // on récupère le parent à côté pour éviter que le join plus haut ne trouve pas aussi l'enfant (si idParent null)

                $academicYear = $request->idAcademicYear ? AcademicYear::find($request['idAcademicYear']) : AcademicYear::getCurrent();

                $data = [
                    'user' => $user,
                    'dateNaissance' => $user->birthday, //->format("d M Y"),
                    'lieuNaissance' => $user->placeofbirth,
                    'father' => @$parent->name, // peut être null
                    'mother' => @$parent->mother, // peut être null
                    'cursusEtudiant' => $user->classeName,
                    'school_logo' => $school->logo,
                    'school' => $school,
                    'cycle_name' => Cycle::find($user->idCycle)->name,
                    'academic_year' => $academicYear->label,
                    'couleurs' => [@$code_couleurs[0], @$code_couleurs[1]],
                    'director' => $director,
                    'etab' => $etab,
//                    'school' => $school
                ];

                $filename = Str::slug($user->name);

                $dompdf = new Dompdf();

                // Récupérer la vue
                $folder = "documents.certificat-scolarite";

                // Si la route contient "abiscom" (avec ou sans s)
                if (str_contains(strtolower($request->route), 'abiscom')) {
                    $route = 'abiscoms'; // On force à utiliser la vue "abiscoms"
                } else {
                    $route = $request->route; // Sinon on garde la route originale
                }

                // Maintenant, on teste avec $route, pas $request->route
                if (view()->exists("$folder.$route")) {
                    $vue = "$folder.$route";
                }
                else {
                    $vue = "$folder.default";
                }


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

                file_put_contents(public_path("pdfs/$filename-cert-scola.pdf"), $dompdf->output());

                if(count($users) > 1){
                    $zip->addFile("pdfs/$filename-cert-scola.pdf");

                    $lienCertificatsScolarite[] = public_path("pdfs/$filename-cert-scola.pdf");
                }else{
                    return $this->sendResponse(asset("pdfs/$filename-cert-scola.pdf"), "Certificat de Scolarité");
                }
            }

            $zip->close();

            $this->deletePDFTempFiles($lienCertificatsScolarite);

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Certificats de Scolarité");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer carte(s) scolaire(s)
     *
     * @param CertificatScolariteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function genererCarteScolaire(CertificatScolariteRequest $request)
    {
        try {
            $idClasse = $request->idClasse ?? null;
            $idStudent = $request->idStudent ?? null;

            // Récupérer d'abord la classe avec l'école
            $classe = Classes::with('school')->findOrFail($idClasse);
            $school = $classe->school;

            $users = User::select(
                'users.id',
                'users.idBourse',
                'users.isBourseUsed',
                'users.name',
                'users.phone',
                'users.nationality',
                'users.codeun',
                'users.codedeux',
                'users.city',
                'users.country',
                'users.email',
                'users.gender',
                'users.username',
                'users.birthday',
                'users.password',
                'users.cni',
                'users.photo',
                'users.created_at',
                'users.updated_at',
                'users.created_by',
                'users.updated_by',
                'users.adresse',
                'users.idCycle',
                'users.idParent',
                'users.idClasse',
                'users.firstname',
                'users.placeofbirth',
                'users.situation',
                'users.repeater',
                'users.matricule',
                'classes.name as classeName',
                'u2.name as parentName'
            )
                ->join('classes', 'classes.id', '=', 'users.idClasse')
                ->leftJoin('users as u2', 'u2.id', '=', 'users.idParent')
                ->where([
                    'users.deleted' => 0,
                    'users.idClasse' => $idClasse
                ]);

            if(!is_null($idStudent)){ $users = $users->where('users.id', $idStudent); }

            $users = $users
                ->orderBy('name')
                ->get();

            if(count($users) == 0){
                return $this->sendResponse("", "Pas d'élèves");
            }

            $lienCertificatsScolarite = [];

            $zip_file = "carte-scolaire-".date("y-m-d-h-i-s").".zip";

            if(count($users) > 1) {
                $zip = new \ZipArchive();
                $zip->open("pdfs/" . $zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
            }

            // Utiliser l'école déjà chargée
            $academicYear = $request->idAcademicYear ? AcademicYear::find($request['idAcademicYear']) : AcademicYear::getCurrent();


            foreach ($users as $user) {
                $code_couleurs = explode(";", Establishment::first()->code_couleur);
                $parent = User::select('phone')->find($user->idParent);

                $data = [
                    'name' => $user->name,
                    'class' => $user->classeName,
                    'image' => $user->photo,
                    'matricule' => $user->matricule,
                    'number' => $parent ? $parent->phone : '',
                    'annee_scolaire' => $academicYear->label,
                    'logo' => $school->logo,
                    'school_name' => $school->name,
                    'school' => $school,
                    'doc_title' => "Carte Scolaire " . $user->name,
                    'couleurs' => [@$code_couleurs[0], @$code_couleurs[1]]
                ];

                $filename = Str::slug($user->name);
                $dompdf = new Dompdf();

                // Récupérer la vue
                $view = View::make('documents.carte-scolaire')->with($data);
                //$view = View::make('receipt')->with($formattedData);

                // Récupérer le contenu de la vue
                $html = $view->render();

                // Charger le contenu HTML dans Dompdf
                $dompdf->loadHtml($html);

                $customPaper = array(0,0,720,1440);
                $dompdf->setPaper($customPaper, 'portrait');

                // (Optionnel) Définir la taille et l'orientation du papier
//                $dompdf->setPaper('A4', 'portrait');

                // Exécuter le rendu du PDF
                $dompdf->render();

                file_put_contents(public_path("pdfs/carte-scolaire-$filename.pdf"), $dompdf->output());

                if(count($users) > 1){
                    $zip->addFile("pdfs/carte-scolaire-$filename.pdf");

                    $lienCertificatsScolarite[] = public_path("pdfs/carte-scolaire-$filename.pdf");
                }else{
                    return $this->sendResponse(asset("pdfs/carte-scolaire-$filename.pdf"), "Carte Scolaire");
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($lienCertificatsScolarite) {
                $this->deletePDFTempFiles($lienCertificatsScolarite);
            });

            return $this->sendResponse(asset("pdfs/" . $zip_file), "Cartes Scolaires");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Générer la liste des élèves de la classe
     *
     * @param ListStudentPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listStudentsPDF(ListStudentPDFRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             * BD: whocares ?
             * { "username":"fondateur", "password":"000000", "idSchool":2 }
             */
            $idSchool = $request->idSchool;
            $idSection = $request->idSection;
            $idClasse = $request->idClasse;

            $users = User::select('users.id as id','users.name as name','users.matricule as matricule','users.gender as gender','users.birthday as birthday','users.placeofbirth as placeofbirth','users.country as country','users.repeater as repeater','users.situation as situation')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('roles.id', 8)
                ->where('users.deleted',0)
                ->where('users.idSchool', $idSchool);
            if(!is_null($idSection)) $users->where('users.idSection', $idSection);
            if(!is_null($idClasse)) $users->where('users.idClasse', $idClasse);

            $users = $users->orderBy('users.name')->get();

            if(count($users) == 0){
                return $this->sendResponse("", "Pas d'élèves");
            }

            $school = School::find($request->idSchool);

            $class_name = !is_null($request->idClasse) ? Classes::find($request->idClasse)->name : $school->name;

            $data = [
                'nouveaux_m' => $users->where('situation','new')->where('gender','Male')->count(),
                'nouveaux_f' => $users->where('situation','new')->where('gender','Female')->count(),
                'nouveaux_total' => $users->where('situation','new')->count(),

                'redoublants_m' => $users->where('repeater','1')->where('gender',"Male")->count(),
                'redoublants_f' => $users->where('repeater','1')->where('gender',"Female")->count(),
                'redoublants_total' => $users->where('repeater','1')->count(),

                'effectif_general_m' => $users->where('gender',"Male")->count(),
                'effectif_general_f' => $users->where('gender',"Female")->count(),
                'effectif_general_total' => $users->count(),

                'students' => $users,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name,
                'school' => $school,
                'academic_year' => AcademicYear::getCurrent()->label ?? '-'
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.students-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "students-list-".Str::slug($class_name).".pdf";
//            $filename = "students-list-".Str::slug($class_name)."-".date("y-m-d-h-i-s").".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de $class_name");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Générer la liste PDF de parents avec leurs enfants (pour ceux qui en ont)
     *
     * @param ListParentPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listParentsPDF(ListParentPDFRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             * BD: whocares ?
             * { "username":"fondateur", "password":"000000", "idSchool":2, "idClasse":1 }
             */

            // Je récupère les parents puis je vais greffer les enfants de chacun
            $parents = User::select('users.id as id','users.name as pere','users.username as username','users.phone as phone','users.mother as mother','users.phone_2 as phone_2','users.email as email')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('roles.id',7)
                ->where('users.deleted',0)
//                ->where('users.idSchool', $request->idSchool)
//                ->when($request->idSection !== null, function ($query) use ($request) {
//                    $query->where('users.idSection', $request->idSection);
//                })
                ->orderBy("users.name");

            if(!is_null($request->idClasse)) {
                $parentsID = User::join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->join('schools','schools.id','=','users.idSchool')
                    ->join('classes', 'classes.id', "=", "users.idClasse")
                    ->where('roles.id', 8)
                    ->where(['users.deleted' => 0, 'idClasse' => $request->idClasse])
                    ->pluck('idParent')
                    ->toArray();

                $parents = $parents->whereIn('users.id', $parentsID);
            }

            $parents = $parents->get();

            if(count($parents) == 0){
                return $this->sendResponse("", "Pas de parents");
            }

            foreach ($parents as $parent) {
                $eleves = User::select('users.id as id','users.name as name', 'users.idClasse as idClasse')
                    ->where([
                        'users.deleted' => 0,
                        'users.idParent' => $parent->id
                    ])
                    ->when($request->idClasse !== null, function ($query) use ($request) {
                        $query->where('users.idClasse', $request->idClasse);
                    })
                    ->orderBy('name')
                    ->get();

                $parent->eleves = $eleves;
            }

            $school = School::findOrFail($request->idSchool);

            $class_name = !is_null($request->idClasse) ? Classes::find($request->idClasse)->name : $school->name;

            $code_couleurs = explode(";", Establishment::first()->code_couleur);

            $data = [
                'parents' => $parents,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name ?? $school->name,
                'school' => $school,
                'couleurs' => [@$code_couleurs[0], @$code_couleurs[1]],
                'academic_year' => AcademicYear::getCurrent()->label ?? '-'
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.parents-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'landscape');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "parents-list-".Str::slug($class_name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des parents d'élèves de $class_name");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Générer la liste PDF des enseignants
     *
     * @param ListParentPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listTeachersPDF(ListParentPDFRequest $request)
    {
        try {
            $teachers = User::select('users.id as id', 'users.name as name', 'users.phone as phone', 'users.gender as sexe', 'users.email as email','users.username as username')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
//                ->join('classe_has_user','classe_has_user.user_id','=','users.id')
//                ->join('classes','classes.id','=','classe_has_user.classes_id')
                ->where('roles.id',5)
                ->where('users.deleted',0)
                ->when($request->idSchool !== null, function ($query) use ($request) {
                    $query->where('users.idSchool', $request->idSchool);
                })
                ->when($request->idSection !== null, function ($query) use ($request) {
                    $query->where('users.idSection', $request->idSection);
                })
                ->orderBy("users.name")
                ->with('classes')
                ->get();

            if(count($teachers) == 0){
                return $this->sendResponse("", "Pas d'enseignants");
            }

            $school = School::find($request->idSchool);

            $class_name = !is_null($request->idSection) ? "Section " . Section::find($request->idSection)->name : $school->name;

            $data = [
                'teachers' => $teachers,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name ?? $school->name,
                'school' => $school,
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.teachers-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

//            $filename = "parents-list-".Str::slug($class_name) . ".pdf";
            $filename = "teachers-list-".Str::slug($class_name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des enseignants");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer la liste PDF du Staff
     *
     * @param ListParentPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listStaffPDF(ListStaffPDFRequest $request)
    {
        try {
            $forbiddenRoles = [2,5,7,8]; // Tous les roles sauf founder(2), teacher(5), parent(7) & student(8)

            $staff = User::select('users.id as id','users.name as name','roles.name as role_name','users.phone as phone','users.adresse as adresse','users.email as email','users.username as username')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->whereNotIn('roles.type', $forbiddenRoles)
                ->where('users.deleted',0)
                ->where('users.idSchool', $request->idSchool)
                ->when($request->idSection !== null, function ($query) use ($request) {
                    $query->where('users.idSection', $request->idSection);
                })
                ->orderBy('users.name')
                ->get();

            if(count($staff) == 0){
                return $this->sendResponse("", "Pas de staff");
            }

            $school = School::find($request->idSchool);

            $class_name = $school->name;
            $class_name .= !is_null($request->idSection) ? " - " . Section::find($request->idSection)->name : "";

            $data = [
                'staffs' => $staff,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name ?? $school->name,
                'school' => $school,
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.staff-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "staff-list-".Str::slug($class_name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste du Staff");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer un document PDF pour la liste des pensions Users
     * @param ListPensionPDFRequest $request
     * @return JsonResponse
     */
    public function listPensionUsersPDF(ListPensionPDFRequest $request)
    {
        try {
            /**
             * PAYLOAD VALIDE
             * BD: juniors
             * { "username":"fondateur", "password":"000000", "idSchool":2, "idStudent":751 }
             */

            $pensionUsers = PensionUser::select('users.name as user_name','classes.name as classe_name','tranches.name as tranche_name','pension_users.advancePayment as advancePayment','pension_users.balancePayment as reste','pension_users.payment_mode as payment_mode', DB::raw('DATE_FORMAT(pension_users.created_at, "%d-%m-%Y") as date'))
                ->join('users', 'users.id', '=', 'pension_users.idStudent')
                ->join('classes', 'classes.id', '=', 'users.idClasse')
                ->join('tranches', 'tranches.id', '=', 'pension_users.idTranche')
                ->where('pension_users.idSchool', $request->idSchool)
                ->when($request->idSection !== null, function ($query) use ($request) {
                    $query->where('pension_users.idSection', $request->idSection);
                })
                ->when($request->idStudent !== null, function ($query) use ($request) {
                    $query->where('pension_users.idStudent', $request->idStudent);
                })
                ->when($request->payment_mode !== null, function ($query) use ($request) {
                    $query->where('pension_users.payment_mode', $request->payment_mode);
                })
                ->orderBy('pension_users.id','desc');

            if(!is_null($request->date_start) && !is_null($request->date_end)){
                $date_start = Carbon::createFromFormat('Y-m-d', $request->date_start)->format('Y-m-d 0:0:0');
                $date_end = Carbon::createFromFormat('Y-m-d', $request->date_end)->format('Y-m-d 23:59:59');

                $pensionUsers = $pensionUsers->whereBetween('pension_users.created_at', [
                    $date_start,
                    $date_end
                ]);
            }

            $filter_value = $request->filter_value;
            if(!is_null($filter_value)){
                $pensionUsers->where(function($query) use ($filter_value) {
                    $query->where('pension_users.payment_mode', 'like', "%$filter_value%")
                        ->orWhere('pension_users.created_at', 'like', "%$filter_value%")
                        ->orWhereHas('tranche', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            $school = School::find($request->idSchool);

            $pensionUsers = $pensionUsers->get();

            $data = [
                'somme' => $pensionUsers->sum('advancePayment'),
                'cash' => $pensionUsers->where('payment_mode','Cash')->sum('advancePayment'),
                'om' => $pensionUsers->where('payment_mode','Orange Money')->sum('advancePayment'),
                'bank' => $pensionUsers->where('payment_mode','Bank')->sum('advancePayment'),
                'pensions' => $pensionUsers,
                'school' => $school,
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.pensions-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "pensions-users-list-".Str::slug($school->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des pensions users");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Générer un document PDF pour la liste des fees Users
     *
     * @param ListFeesPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listFeeUsersPDF(ListFeesPDFRequest $request)
    {
        try {
            $feeUsers = FeeUser::select('users.name as user_name','fees.name as fee_name','fee_user.advancePayment as advancePayment','fee_user.payment_mode as payment_mode',DB::raw('DATE_FORMAT(fee_user.created_at, "%d-%m-%Y") as date'))
                ->join('users', 'users.id', '=', 'fee_user.idStudent')
                ->join('fees', 'fees.id', '=', 'fee_user.idFee')
                ->where('fee_user.idSchool', $request->idSchool)
                ->when($request->idSection !== null, function ($query) use ($request) {
                    $query->where('fee_user.idSection', $request->idSection);
                })
                ->when($request->idStudent !== null, function ($query) use ($request) {
                    $query->where('fee_user.idStudent', $request->idStudent);
                })
                ->when($request->idClasse !== null, function ($query) use ($request) {
                    $query->where('users.idClasse', $request->idClasse);
                })
                ->when($request->idFee !== null, function ($query) use ($request) {
                    $query->where('fee_user.idFee', $request->idFee);
                })
                ->when($request->payment_mode !== null, function ($query) use ($request) {
                    $query->where('fee_user.payment_mode', $request->payment_mode);
                })
                ->orderBy('fee_user.id','desc');

            if(!is_null($request->date_start) && !is_null($request->date_end)){
                $date_start = Carbon::createFromFormat('Y-m-d', $request->date_start)->format('Y-m-d 0:0:0');
                $date_end = Carbon::createFromFormat('Y-m-d', $request->date_end)->format('Y-m-d 23:59:59');

                $feeUsers = $feeUsers->whereBetween('fee_user.created_at', [
                    $date_start,
                    $date_end
                ]);
            }

            $filter_value = $request->filter_value;
            if(!is_null($filter_value)){
                $feeUsers->where(function($query) use ($filter_value) {
                    $query->where('payment_mode', 'like', "%$filter_value%")
                        ->orWhere('fee_user.created_at', 'like', "%$filter_value%")
                        ->orWhereHas('fee', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            $school = School::find($request->idSchool);

            $feeUsers = $feeUsers->get();

            $data = [
                'somme' => $feeUsers->sum('advancePayment'),
                'cash' => $feeUsers->where('payment_mode','Cash')->sum('advancePayment'),
                'om' => $feeUsers->where('payment_mode','Orange Money')->sum('advancePayment'),
                'bank' => $feeUsers->where('payment_mode','Bank')->sum('advancePayment'),
                'fees' => $feeUsers,
                'school' => $school,
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.fees-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "fees-users-list-".Str::slug($school->name)."-".date("y-m-d-h-i-s").".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des fee users");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function listSolvablesPDF(InsolvableRequest $request, $category)
    {
        try{
            $results = $this->pensionUserService->pensionUserSituation($request->validated(), ($category == "solvables"));

            if(count($results['data']) == 0){
                return $this->sendError("Pas de résultats");
            }

            $school = School::find($request->idSchool);

            $title = ($category == "solvables")
                ? __('solvables.list_solvables')
                : __('solvables.list_insolvables');

            $data = [
                'title' => $title,
                'students' => $results['data'],
                'school' => $school
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.solvables-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "$category-list-".Str::slug($school->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des $category PDF");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Liste PDF des customers
     *
     * @param Request $request
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function listCustomers(Request $request)
    {
        try {
            $customers = Customer::select('customers.name as name','customers.type as type','customers.phone as phone','customers.email as email','customers.niu as niu')
                ->when($request['type'] !== null, function ($query) use ($request) {
                    $query->where('type', $request['type']);
                })
                ->orderBy('name')
                ->get();


            $school = Establishment::first();

            $data = [
                'title' => "Liste des clients",
                'customers' => $customers,
                'school' => $school,
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.customers-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "customers-list-".Str::slug($school->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des customers PDF");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Liste PDF des invoices
     *
     * @param Request $request
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function listInvoices(InvoiceGetAllRequest $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $statut = $request['statut'] ?? null;
            $mode = $request['mode'] ?? null;
            $idTypeInvoice = $request['idTypeInvoice'] ?? null;
            $idUser = $request['idUser'] ?? null;

            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;

            $invoices = Invoice::query()
                ->when($idSchool !== null, function ($query) use ($idSchool) {
                    $query->where('idSchool', $idSchool);
                })
                ->when($idSection !== null, function ($query) use ($idSection) {
                    $query->where('idSection', $idSection);
                })
                ->when($statut !== null, function ($query) use ($statut) {
                    $query->where('statut', $statut);
                })
                ->when($mode !== null, function ($query) use ($mode) {
                    $query->where('mode', $mode);
                })
                ->when($idTypeInvoice !== null, function ($query) use ($idTypeInvoice) {
                    $query->where('idTypeInvoice', $idTypeInvoice);
                })
                ->when($idUser !== null, function ($query) use ($idUser) {
                    $query->where('invoiceable_id', $idUser);
                })
                ->when(($date_start != null && $date_end != null), function ($query) use ($request) {
                    $date_start = Carbon::createFromFormat('d-m-Y', $request['date_start'])->format('Y-m-d 0:0:0');
                    $date_end = Carbon::createFromFormat('d-m-Y', $request['date_end'])->format('Y-m-d 23:59:59');

                    $query->whereRaw('DATE(date) BETWEEN ? AND ?', [ $date_start, $date_end ]);
                })
                ->orderBy('invoices.reasons')
                ->with('invoiceable','type_invoice')
                ->get();


            if(count($invoices) == 0){
                return $this->sendResponse("", "Pas de dépenses dans cette catégorie");
            }
//            return $invoices;

            $school = Establishment::first();

            $data = [
                'title' => "Liste des dépenses",
                'invoices' => $invoices,
                'school' => $school
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.invoices-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "invoices-list-".Str::slug($school->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des dépenses PDF");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Liste des students d'une classe avec les assessments
     *
     * @param ListUsersWithAssessmentsPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listUsersWithAssessments(ListUsersWithAssessmentsPDFRequest $request)
    {
        try {
            $idClasse = $request->idClasse;

            $classe = Classes::find($idClasse);

            $users = User::select('users.id as id','users.name as name','users.matricule as matricule','users.gender as gender','users.birthday as birthday','users.placeofbirth as placeofbirth','users.country as country','users.repeater as repeater','users.situation as situation')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('roles.id', 8)
                ->where('users.deleted',0)
                ->where('users.idClasse', $idClasse)
                ->orderBy('users.name')
                ->get();

//            if(count($users) == 0){
//                return $this->sendResponse("", "Pas d'élèves");
//            }

            $school = School::find($classe->idSchool);

            $class_name = $classe->name;

            $evaluations = Assessment::where('assessments.idClasse', $idClasse)
                ->limit(4) //TODO: temporarily added
                ->with('typeEvaluations', 'matter')
                ->get();

            foreach ($evaluations as $evaluation) {
                $evaluation['types'] = $evaluation->typeEvaluations;
            }

            $data = [
                'students' => $users,
                'evaluations' => $evaluations,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name,
                'school' => $school,
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.users-list-with-assessments')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'landscape');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "users-".Str::slug($class_name)."-with-assessments.pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de $class_name avec les évaluations");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * listUsersWithAssessmentsByMatter
     *
     * @param ListUsersWithAssessmentsPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listUsersWithAssessmentsByMatter(ListUsersWithAssessmentsByMatterPDFRequest $request)
    {
        try {
            $idAssessment = $request->idAssessment;

            $assessment = Assessment::find($idAssessment);
            $idClasse = $assessment->idClasse;
            $idTrimestre = $request->idTrimestre;

            $classe = Classes::find($idClasse);
            $trimestre = Trimestre::find($idTrimestre);

            $users = User::select('users.id as id','users.name as name','users.matricule as matricule','users.gender as gender','users.birthday as birthday','users.placeofbirth as placeofbirth','users.country as country','users.repeater as repeater','users.situation as situation')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('roles.id', 8)
                ->where('users.deleted',0)
                ->where('users.idClasse', $idClasse)
                ->orderBy('users.name')
                ->get();

//            if(count($users) == 0){
//                return $this->sendResponse("", "Pas d'élèves");
//            }
            $academicYear = $request->idAcademicYear ? AcademicYear::find($request['idAcademicYear']) : AcademicYear::getCurrent();
            $school = School::find($classe->idSchool);

            $class_name = $classe->name;

            $evaluations = AssessmentType::where('idTrimestre', $idTrimestre)
                ->get();

            $matter = $assessment->matter;

            $typesEvaluations = $assessment->typeEvaluations()->orderBy('type_evaluation.id')->get();

            foreach ($typesEvaluations as $typesEvaluation) {
                $chaine = $typesEvaluation->name;
                $chaineSansAccent = strtr($chaine, [
                    'é' => 'e',
                    'è' => 'e',
                    'ê' => 'e',
                    'ë' => 'e',
                    // Ajoutez d'autres remplacements si nécessaire
                ]);

                $chaine = str_replace('^', '', $chaineSansAccent);

                $tmp_name = strtolower(str_replace(' ', '_', $chaine));

                $typesEvaluation['notemax'] = $assessment->$tmp_name;
            }

            $data = [
                'students' => $users,
                'evaluations' => $evaluations,
                'typesEvaluations' => $typesEvaluations,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name,
                'school' => $school,
                'trimestre' => $trimestre,
                'matter' => $matter,
                'assessment' => $assessment,
                'academicYear' => $academicYear,
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.users-list-with-assessments-by-matter')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "users-".Str::slug($class_name)."-with-assessments-for-".Str::slug($matter->name).".pdf";
//            $filename = "students-list-".Str::slug($class_name)."-".date("y-m-d-h-i-s").".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de $class_name avec évaluation");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * listUsersWithAssessmentsByMatterGroup
     *
     * @param ListUsersWithAssessmentsByMatterGroupPDFRequest $request
     * @return \Illuminate\Http\Response
     */
    public function listUsersWithAssessmentsByMatterGroup(ListUsersWithAssessmentsByMatterGroupPDFRequest $request)
    {
        /**
         * On liste tous les assessments de toutes les matières de ce groupe, en dessous des séquences
         */
        try {
            $matterGroup = MatterGroup::findOrFail($request->idMatterGroup);
            $classe = Classes::findOrFail($request->idClasse);

            $idTrimestre = $request->idTrimestre;
            $trimestre = Trimestre::find($idTrimestre);

            $users = User::select('users.id as id','users.name as name','users.matricule as matricule','users.gender as gender','users.birthday as birthday','users.placeofbirth as placeofbirth','users.country as country','users.repeater as repeater','users.situation as situation')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->join('schools','schools.id','=','users.idSchool')
                ->where('roles.id', 8)
                ->where('users.deleted',0)
                ->where('users.idClasse', $request->idClasse)
                ->orderBy('users.name')
                ->get();

//            if(count($users) == 0){
//                return $this->sendResponse("", "Pas d'élèves");
//            }

            $school = School::find($classe->idSchool);

            $class_name = $classe->name;

            $sequences = AssessmentType::where('idTrimestre', $idTrimestre)
                ->get();

            $bareme_total = 0;

            $matters = $matterGroup->matters()->orderBy('matter.name')->get();

            // Je veux ajouter la notemax qui se trouve sur l'évaluation liée à chaque matière
            foreach ($matters as $matter) {
                $assess = Assessment::where('idMatter', $matter->id)
                    ->where('idClasse', $classe->id)
                    ->first();

                $matter->notemax = $assess->notemax;

                $bareme_total += $assess->notemax;
            }

            $data = [
                'students' => $users,
                'school_logo' => $school->logo,
                'school_name' => $school->name,
                'class_name' => $class_name,
                'school' => $school,
                'trimestre' => $trimestre,
                'matterGroup' => $matterGroup,
                'matters' => $matters,
                'sequences' => $sequences,
                'bareme_total' => $bareme_total
            ];

//            return $data;

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.users-list-with-assessments-by-matter-group')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "users-".Str::slug($class_name)."-with-assessments-for-".Str::slug($matterGroup->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des élèves de $class_name avec évaluations par groupe de matière");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Undocumented function
     *
     * @param PdfDesInsolvables $request
     * @return void
     */
    public function listInsolvablesOuSolvablesPDF(PdfDesInsolvablesOuSolvablesRequest $request, $type){

        try{
            $requestData = $request->validated();
            $requestData['type'] = $type;

            $results = $this->feeUserService->solvablesOuInsolvables($requestData);

            //return $results;

            if(count($results['data']) == 0){
                return $this->sendError("Pas de résultats");
            }

            $school = School::find($request->idSchool);
            $fee = Fee::find($request->idFee);

            $title = $type;

            $data = [
                'title' => $title,
                'students' => $results['data'],
                'school' => $school,
                'fee' => $fee
            ];

            $dompdf = new Dompdf();

            // Récupérer la vue
            $view = View::make('documents.feeusers-insolvables-list')->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            $filename = "$type-list-".Str::slug($school->name).".pdf";

            file_put_contents(public_path("pdfs/" . $filename), $dompdf->output());

            return $this->sendResponse(asset("pdfs/" . $filename), "Liste des $type PDF");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }


    public function genererTableauHonneur(HonourRollRequest $request)
    {
        try {
            $idOptionLevel = $request['idOptionLevel'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $idStudent = $request['idUser'] ?? null;
            $moyenneMerit = $request['moyenne'] ?? null;
            $route = $request['route'] ?? null;

            // Récupération des élèves
            $eleves = User::query()
                ->when($idStudent, function ($query) use ($idStudent) {
                    $query->where('id', $idStudent);
                })
                ->whereHas('roles', function ($query) {
                    $query->where('id', 8); // Rôle élève
                })
                ->whereHas('classe', function ($query) use ($idClasse) {
                    if (!is_null($idClasse)) {
                        $query->where('id', $idClasse);
                    }
                })
                ->with(['classe', 'roles'])
                ->get();

//            return $eleves;

            // Cas d'un seul élève (retour direct du PDF)
            if ($idStudent) {
                $eleve = $eleves->first();
                if (!$eleve) {
                    return $this->sendError(__('bulletin.not_found_student'));
                }

                $classe = $eleve->classe;
                $lang = (!is_null($request['idOptionLevel']))
                    ? OptionLevel::find($request['idOptionLevel'])->lang
                    : Section::find($classe['idSection'])->lang;
                $lang = $request['lang'] ?? $lang ?? 'fr';
                App::setLocale(strtolower($lang));

                $ecole = $this->getInfosEcole($classe["id"]);

                $bulletinPrimaireController = new BulletinPrimaireController(
                    new PensionUserService()
                );

                $newRequest = [
                    'idUser' => $eleve->id,
                    'idOptionLevel' => $request['idOptionLevel'] ?? null,
                    'idTrimestre' => $request['idTrimestre'] ?? null
                ];

                if (!is_null($request['idTrimestre'])) {
                    $trimestre = Trimestre::find($request['idTrimestre']);
                    $nomTrim = __('bulletin_primaire.term') . $trimestre['numbering'];
                } else {
                    $nomTrim = null;
                }

                $moyenne = $bulletinPrimaireController->afficherNotesPrimaire2($newRequest)['moyenneAnnuelle'];

                $appreciation = getAppreciationGradeAndColor($moyenne, 20);

                // Même structure de données que votre code original
                $eleveData = $eleve->toArray();
                $eleveData['route'] = $route;
                $eleveData['ecole'] = $ecole;
                $eleveData['classe'] = $classe->name;
                $eleveData['moyenne'] = round($moyenne, 2);
                $eleveData['appreciation'] = $appreciation[2];
                $eleveData['nom_trim'] = strtoupper($nomTrim);
                $eleveData['codeCouleur'] = explode(";", Establishment::first()->code_couleur);

                $fileName = "honour-roll-" . Str::slug($eleveData["name"]);
                $absolutePath = $this->genererDocument($fileName, "documents.honour-roll-$lang", $eleveData, null, 'landscape');
                $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $absolutePath);

                return $this->sendResponse(asset($relativePath), __('bulletin_secondaire.tableau_dhonneur'));
            }

            // Cas multiple élèves (ZIP)
            $classe = Classes::find($idClasse);

            //On configure la langue
            $lang = (!is_null($request['idOptionLevel']))
                ? OptionLevel::find($request['idOptionLevel'])->lang
                : Section::find($classe['idSection'])->lang;
            $lang = $request['lang'] ?? $lang ?? 'fr';
            App::setLocale(strtolower($lang));

            $this->createDirectory('pdfs');
            $zip = new \ZipArchive();
            $zip_file = "Tableaux-honneur-" . Str::slug($classe['name']) . "-" . $lang . "-" . now()->format('Y-m-d') . ".zip";
            $zip->open("pdfs/$zip_file", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

            $liensDocuments = [];
            $hasFiles = false;

            foreach ($eleves as $eleve) {
                $classe = $eleve->classe;

                $ecole = $this->getInfosEcole($classe["id"]);

                $bulletinPrimaireController = new BulletinPrimaireController(
                    new PensionUserService()
                );

                $newRequest = [
                    'idUser' => $eleve->id,
                    'idOptionLevel' => $request['idOptionLevel'] ?? null,
                    'idTrimestre' => $request['idTrimestre'] ?? null
                ];

                if (!is_null($request['idTrimestre'])) {
                    $trimestre = Trimestre::find($request['idTrimestre']);
                    $nomTrim = __('bulletin_primaire.term') . $trimestre['numbering'];
                } else {
                    $nomTrim = null;
                }

                $moyenne = $bulletinPrimaireController->afficherNotesPrimaire2($newRequest)['moyenneAnnuelle'];

                if (!is_null($moyenneMerit) && $moyenne < $moyenneMerit) {
                    continue;
                }

                $hasFiles = true;
                $appreciation = getAppreciationGradeAndColor($moyenne, 20);

                // Même structure de données que votre code original
                $eleveData = $eleve->toArray();
                $eleveData['route'] = $route;
                $eleveData['ecole'] = $ecole;
                $eleveData['classe'] = $classe->name;
                $eleveData['moyenne'] = round($moyenne, 2);
                $eleveData['appreciation'] = $appreciation[2];
                $eleveData['nom_trim'] = strtoupper($nomTrim);
                $eleveData['codeCouleur'] = explode(";", Establishment::first()->code_couleur);

                $fileName = "honour-roll-" . Str::slug($eleveData["name"]);
                $absolutePath = $this->genererDocument($fileName, "documents.honour-roll-$lang", $eleveData, $zip, 'landscape');

                if ($absolutePath) {
                    $liensDocuments[] = $absolutePath;
                }
            }

            $zip->close();

            register_shutdown_function(function () use ($liensDocuments) {
                $this->deletePDFTempFiles($liensDocuments);
            });

            if (!$hasFiles) {
                return $this->sendError(__('bulletin.no_student_meet_merit'));
            }

            return $this->sendResponse(asset("pdfs/" . $zip_file), __('bulletin_secondaire.tableau_dhonneur'));

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
    
    /**
     * Génère le bulletin de paie d'un employé
     * 
     * @param BulletinPaieRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function genererBulletinPaie(BulletinPaieRequest $request)
    {
     try {

        $idInvoice = $request->idInvoice;
        $route = $request['route'] ?? null;

        //Charger invoice avec relations
        $invoice = Invoice::with([
            'salaryComponents',
            'invoiceable', 
            'school'
            
        ])->findOrFail($idInvoice);

        if($invoice->invoiceable_type !== "App\Models\User"){
            return $this->sendError("Cette facture n'est pas liée à un employé");
        }

        $user = $invoice->invoiceable;

        $school = School::find($invoice->idSchool);
        $etab = Establishment::find($school->idEstablishment);
        $ecole = School::where("id", $school->id)->first();


        //  Préparer les composants salaire
        $salary_components = $invoice->salaryComponents->map(function ($component) {

            return [
                'code' => $component->code,
                'name' => $component->name,
                'type' => $component->type,
                'order' => $component->order,
                'base_amount' => $component->pivot->base_amount,
                'coef' => $component->pivot->coef,
                'coef_patronal' => $component->pivot->coef_patronal,
                'base_patronal' => $component->pivot->base_patronal,
                
            ];
        });

        $data = [
            'invoice' => $invoice,
            'user' => $user,
            'school' => $school,
            'etab' => $etab,
            'ecole' => $ecole,
            'salary_components' => $salary_components,
            'total_salarial' => $invoice->Total_Amount_Salary,
            'total_patronal' => $invoice->Total_Amount_Patronal,
            'doc_title' => "Bulletin de paie - ".$user->name,
            'academic_year' => AcademicYear::getCurrent()->label ?? '-',
            "route" => str_contains($request["route"], "juniors") ? "juniors" : $request["route"],
        ];

        $filename = "bulletin-paie-".Str::slug($user->name)."-".$invoice->id;

        $dompdf = new Dompdf();

        $view = View::make('documents.bulletin-paie')->with($data);
        $html = $view->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents(public_path("pdfs/$filename.pdf"), $dompdf->output());

        return $this->sendResponse(
            asset("pdfs/$filename.pdf"),
            "Bulletin de paie généré"
        );

      } catch (\Throwable $th) {
        Log::critical($th->getMessage());
        return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
      }
    }
    /**
     * Upload a PDF file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPdf(Request $request)
    {
        $file = $request->file('pdf');
        $uploadPath = "public/pdfs";
        $originalName = $file->getClientOriginalName();
        $re = $file->move($uploadPath, $originalName);
        return response()->json(['chemin' => $re->getPathname()]);
    }

}
