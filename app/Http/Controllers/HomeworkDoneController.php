<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staffs\HomeworkDoneDownloadRequest;
use App\Http\Requests\Staffs\HomeworkDoneGetAllRequest;
use App\Http\Requests\Staffs\HomeworkDoneRequest;
use App\Http\Resources\Staffs\HomeworkDoneResource;
use App\Models\HomeworkDone;
use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * @group Homework Done
 */
class HomeworkDoneController extends BaseController
{
    /**
     * Afficher la liste des HomeworkDone
     *
     * @param HomeworkDoneGetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(HomeworkDoneGetAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request['filter_value'] ?? null; // nbre de résultats de la page

            $hwdones = HomeworkDone::query();

            if(!is_null($request['idSchool'])) $hwdones = $hwdones->where('idSchool',$request['idSchool']);
            if(!is_null($request['idSection'])) $hwdones = $hwdones->where('idSection',$request['idSection']);
            if(!is_null($request['idHomework'])) $hwdones = $hwdones->where('idHomework',$request['idHomework']);
            if(!is_null($request['idStudent'])) $hwdones = $hwdones->where('idStudent',$request['idStudent']);
            if(!is_null($request['date'])) $hwdones = $hwdones->where('created_at', "LIKE", "%{$request['date']}%");
            
            if(!is_null($request['date_start']) && !is_null($request['date_end'])) {
                $hwdones = $hwdones->whereBetween('created_at', [$request['date_start'], $request['date_end']]);
            }
            
            if (!is_null($request['idTeacher'])) {
                $hwdones->whereHas('homework', function ($q) use ($request) {
                    $q->where('idTeacher', $request['idTeacher']);
                });
            }

            if(!is_null($filter_value)){
                $hwdones->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('homework', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return HomeworkDoneResource::collection(
                $hwdones->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param HomeworkDoneRequest $request
     * @return HomeworkDoneResource
     */
    public function store(HomeworkDoneRequest $request)
    {
        try {
            $homeworkDoneDone = $request->validated();

            $homeworkDoneDone = new HomeworkDone();

            $homeworkDoneDone->description = $request['description'];
            $homeworkDoneDone->idStudent = $request['idStudent'];
            $homeworkDoneDone->idHomework = $request['idHomework'];
            $student = User::find($request['idStudent']);
            $classe = $student && $student->idClasse
                ? Classes::find($student->idClasse)
                : null;

            $homeworkDoneDone->idSchool = $student->idSchool ?? null;
            $homeworkDoneDone->idSection = $classe->idSection ?? ($student->idSection ?? $request['idSection'] ?? null);
            $homeworkDoneDone->created_by = auth()->user()->id;
            $homeworkDoneDone->save();

            return new HomeworkDoneResource($homeworkDoneDone);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HomeworkDone $homeworkDoneDone,$id)
    {
        try {
            $homeworkDoneDone = HomeworkDone::find($id);
            return new HomeworkDoneResource($homeworkDoneDone);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeworkDone $homeworkDoneDone,$id)
    {
        try {
            $homeworkDoneDone = HomeworkDone::find($id);
            $homeworkDoneDone->description = $request['description'] ?? $homeworkDoneDone['description'];
            $homeworkDoneDone->idStudent = $request['idStudent'] ?? $homeworkDoneDone['idStudent'];
            $homeworkDoneDone->idHomework = $request['idHomework'] ?? $homeworkDoneDone['idHomework'];
            $homeworkDoneDone->idSchool = $request['idSchool'] ?? $homeworkDoneDone->idSchool;
            $homeworkDoneDone->idSection = $request['idSection'] ?? $homeworkDoneDone->idSection;
            $homeworkDoneDone->updated_by = auth()->user()->id;
            $homeworkDoneDone->save();

            return new HomeworkDoneResource($homeworkDoneDone);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeworkDone $homeworkDoneDone,$id)
    {
        try {
            $homeworkDoneDone = HomeworkDone::find($id);
            $homeworkDoneDone->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function download(HomeworkDoneDownloadRequest $request)
    {
        try {
            $idStudent = $request->idStudent;
            $idHomework = $request->idHomework;
            $idHomeworkDone = $request->idHomeworkDone;

            $homework_dones = HomeworkDone::query()
                ->when(!is_null($idStudent), function ($query) use ($idStudent) {
                    $query->where('idStudent', $idStudent);
                })
                ->when(!is_null($idHomework), function ($query) use ($idHomework) {
                    $query->where('idHomework', $idHomework);
                })
                ->when(!is_null($idHomeworkDone), function ($query) use ($idHomeworkDone) {
                    $query->where('idHomeworkDone', $idHomeworkDone);
                })
//                ->with('student', 'homework')
                ->get();

            if(count($homework_dones) === 0){
                return $this->sendError("Aucun résultat trouvé");
            }

            $data = [
                'homework_dones' => json_encode(HomeworkDoneResource::collection($homework_dones)),
                'school' => School::select('id', 'name', 'logo')
                    ->where('id', $homework_dones[0]->idSchool)
                    ->firstOrFail(),
            ];

//            return $data;


            $filename = Str::slug("Homework dones").".pdf";

            $dompdf = new Dompdf();

            $folder = "documents.homeworkdones";

            $route = $request->route;

            (view()->exists($folder."." . $route))
                ? $vue = $folder."." . $route
                : $vue = $folder.".default";

            // Récupérer la vue
            $view = View::make($vue)->with($data);

            // Récupérer le contenu de la vue
            $html = $view->render();

            // Charger le contenu HTML dans Dompdf
            $dompdf->loadHtml($html);

            // (Optionnel) Définir la taille et l'orientation du papier
            $dompdf->setPaper('A4', 'portrait');

            // Exécuter le rendu du PDF
            $dompdf->render();

            file_put_contents(public_path("pdfs/$filename"), $dompdf->output());

            return $this->sendResponse(asset("pdfs/$filename"), "Liste des devoirs faits.");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
