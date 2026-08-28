<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StudentMoyennePerAssessmentRequest;
use App\Models\Classes;
use App\Models\School;
use App\Services\CalculeMoyenneParSequenceService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MoyenneController extends BaseController
{
    protected $calculMoyenneEtudiantService;

    public function __construct(CalculeMoyenneParSequenceService $calculMoyenneEtudiantService)
    {
        $this->calculMoyenneEtudiantService = $calculMoyenneEtudiantService;
    }

    /**
     * Obtenir la moyenne d'un élève sur les différentes séquences
     *
     * @param StudentMoyennePerAssessmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function moyenneParSequence(StudentMoyennePerAssessmentRequest $request)
    {
        try {
            $school = School::whereId($request->idSchool)
                ->select('name','scholar_level')
                ->first();

            // je récupère tous les users qui sont dans le même classe que idStudent
            $students_list = User::where(['deleted' => 0, 'idClasse' => User::find($request->idStudent)->idClasse])
                ->pluck('id')
                ->toArray();

            if(is_null($school)){
                return $this->sendError("Ecole invalide", [], 404);
            }

            switch ($school->scholar_level){
                case "Secondary":
                    $data = $this->calculMoyenneEtudiantService->calculMoyenneEtudiantSecondaire($request->all(), $students_list);
                    break;
                case "Nursery":
                    $data = $this->calculMoyenneEtudiantService->calculMoyenneEleveMaternelle($request->all(), $students_list);
                    break;
                case "Primary":
                    $data = $this->calculMoyenneEtudiantService->calculMoyenneElevePrimaire($request->all(), $students_list);
                    break;
                case "University":
                    $data = $this->calculMoyenneEtudiantService->calculMoyenneEleveUniversitaire($request->all(), $students_list);
                    break;
                default:
                    return $this->sendError("Cas d'école pas encore géré", [], 500);
                    break;
            }

            return $this->sendResponse($data, "Moyenne pour séquence");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
