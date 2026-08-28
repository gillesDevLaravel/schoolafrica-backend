<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CertificatTransfertRequest;
use App\Http\Requests\Admin\ProjectAllRequest;
use App\Http\Resources\Admin\CertificatTransfertResource;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\CertificatTransfert;
use App\Models\Cycle;
use App\Models\Establishment;
use App\Models\Project;
use App\Models\School;
use App\Models\User;
use App\Traits\ManageDirectoryTrait;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CertificatDeTransfertController extends BaseController
{
    use ManageDirectoryTrait;

    public function __construct()
    {
        $this->createDirectory('pdfs'); // Beaucoup de méthodes dans ce controlleur utilisent ce dossier
    }

    /**
     * Lister les projets non supprimés
     *
     * @param ProjectAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(ProjectAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $projects = CertificatTransfert::query();

            if(!is_null($filter_value)){
                $projects->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhere('name', 'like', "%$filter_value%");
                });
            }

            return CertificatTransfertResource::collection(
                $projects
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un certificat de transfert
     *
     * @urlParam $id integer required
     * @return CertificatTransfertResource|\Illuminate\Http\Response
     */
    public function show($idTransfert)
    {
        try {
            $ransfert = CertificatTransfert::findOrFail($idTransfert);
            return CertificatTransfertResource::make($ransfert);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Effectuer un tranfert d'élève et générer un PDF
     *
     * @param CertificatTransfertRequest $request
     * @return \Illuminate\Http\Response
     */
    public function certificatTransfert(CertificatTransfertRequest $request)
    {
        try {
            CertificatTransfert::updateOrCreate([
                'idStudent' => $request->idStudent
            ],[
                'idStudent' => $request->idStudent,
                'reason' => $request->reason,
                'to' => $request->country,
                'on' => $request->date ?? null,
                'academic_year' => $request->academic_year,
                'created_by' => auth()->user()->id,
            ]);

            $idStudent = $request->idStudent;
            $country = $request->country;

            $user = User::select('users.id as id','users.name as name','users.country as country','users.gender as gender','users.birthday as birthday','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.adresse as adresse','users.idCycle as idCycle','users.idParent as idParent','users.idClasse as idClasse','users.placeofbirth as placeofbirth','users.situation as situation','users.repeater as repeater','users.matricule as matricule','users.phone as phone','schools.scholar_level as scholar_level',
                'classes.name as classe_name','classes.name as classeName',
                'schools.logo as school_logo', 'schools.name as school_name','schools.adresse as schoolAdresse',
                'section.name as sectionName',
                'levels.name as levelName','levels.idCycle as idCycle'
//                ,'u2.name as father', 'u2.mother as mother', 'u2.name as parentName'
            )
                ->join('schools','schools.id','=','users.idSchool')
                ->join('section','section.id','=','users.idSection')
                ->join('classes', 'classes.id', "=", "users.idClasse")
                ->join('levels', 'levels.id', "=", "users.idLevel")
//                ->join('users as u2', 'u2.id', "=", "users.idParent")
                ->where('users.deleted', 0)
                ->where('users.id', $idStudent)
                ->first();

            if(is_null($user)){
                return $this->sendError("Elève introuvable.", "", 422);
            }

            $code_couleurs = explode(";", Establishment::first()->code_couleur);

//            $director = User::select('users.id as id','users.name as name','users.phone as phone','users.nationality as nationality','users.city as city','users.country as country','users.email as email','users.gender as gender','users.username as username','users.birthday as birthday','users.password as password','users.cni as cni','users.idSchool as idSchool','users.idSection as idSection','users.photo as photo','users.created_at as created_at','users.updated_at as updated_at','users.created_by as created_by','users.updated_by as updated_by','users.adresse as adresse','users.salary as salary','users.hourlyPrice as hourlyPrice','users.idMatter as idMatter','users.idLevel as idLevel','users.idOptionLevel as idOptionLevel','roles.id as idRole','users.idCycle as idCycle')
//                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
//                ->join('roles','model_has_roles.role_id','=','roles.id')
//                ->where('roles.id', 3)
//                ->where('users.idSchool', $request->idSchool)
//                ->first();

            $parent = User::select('id', 'name', 'mother')->find($user->idParent); // on récupère le parent à côté pour éviter que le join plus haut ne trouve pas aussi l'enfant (si idParent null)

            $data = [
                'user' => $user,
                'country' => $country,
                'reason' => $request->reason,
                'dateNaissance' => $user->birthday, //->format("d M Y"),
                'lieuNaissance' => $user->placeofbirth,
                'father' => @$parent->name, // peut être null
                'mother' => @$parent->mother, // peut être null
                'cursusEtudiant' => $user->classeName,
                'school_logo' => $user->school_logo,
                'school' => School::find($user->idSchool),
                'cycle_name' => Cycle::find($user->idCycle)->name,
                'academic_year' => getAcademicYear(" - "),
                'couleurs' => [@$code_couleurs[0], @$code_couleurs[1]],
//                'director' => $director
            ];

            $filename = Str::slug($user->name);

            $dompdf = new Dompdf();

            // Récupérer la vue
            $folder = "documents.certificat-transfert";

            if (view()->exists($folder."." . $request->route)) {
                $vue = $folder."." . $request->route;
            } else {
                $vue = $folder.".default";
            }

            $view = View::make($vue)->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            file_put_contents(public_path("pdfs/$filename-cert-transfert.pdf"), $dompdf->output());

            return $this->sendResponse(asset("pdfs/$filename-cert-transfert.pdf"), "Certificat de transfert");

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
