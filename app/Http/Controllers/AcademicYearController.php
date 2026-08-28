<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Admin\AcademicYearDeleteRequest;
use App\Http\Requests\Admin\AcademicYearTrashRequest;
use App\Http\Requests\Admin\AcademicYearGetRequest;
use App\Http\Requests\Admin\AcademicYearRequest;
use App\Http\Requests\Admin\AcademicYearUpdateRequest;
use App\Http\Resources\Admin\SchoolYearResource;
use App\Models\School;
use App\Models\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group School Year
 */
class AcademicYearController extends BaseController
{
    /**
     * Afficher les SchoolYear
     * @param AcademicYearGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(AcademicYearGetRequest $request)
    {
        try {
            $pageItems = $request->pageItems ?? 1;
            $nbreItems = $request->nbreItems ?? 10000;
            $filter_value = $request->filter_value;

            $school_years = AcademicYear::query();

            $school_years_filters = [
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'deleted' => (boolean) $request->trashed,
            ];
            foreach ($school_years_filters as $column => $value) {
                if (!is_null($value)) {
                    $school_years->where("academic_years.$column", $value);
                }
            }

            if ($request->filled('filter_value')) {
                $school_years->where('name', 'like', '%' . $filter_value . '%');
            }

            return SchoolYearResource::collection(
                $school_years
                    ->orderBy("academic_years.id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un SchoolYear
     * @param AcademicYearRequest $request
     * @return SchoolYearResource|JsonResponse
     */
    public function store(AcademicYearRequest $request)
    {
        try {
            $SchoolYear = new AcademicYear();

            $SchoolYear->name = $request->name;
            $SchoolYear->start_date = $request->start_date;
            $SchoolYear->end_date = $request->end_date;
            $SchoolYear->previous_academic_year_id = $request->previousAcademicYearId;

            $SchoolYear->created_by =  auth()->user()->id;
            $SchoolYear->save();

            return new SchoolYearResource($SchoolYear);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un SchoolYear
     * @param $id
     * @return SchoolYearResource|JsonResponse
     */
    public function show($id)
    {
        try {
            $SchoolYear = AcademicYear::find($id);
            return new SchoolYearResource($SchoolYear);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un SchoolYear
     * @param AcademicYearUpdateRequest $request
     * @param $id
     * @return SchoolYearResource|JsonResponse
     */
    public function update(AcademicYearUpdateRequest $request, $id)
    {
        try {
            $SchoolYear = AcademicYear::find($id);
            $SchoolYear->name = $request['name'] ?? $SchoolYear['name'];
            $SchoolYear->start_date = $request->start_date ?? $SchoolYear->start_date;
            $SchoolYear->end_date = $request->end_date ?? $SchoolYear->end_date;
            $SchoolYear->previous_academic_year_id = $request->previousAcademicYearId ?? $SchoolYear->previous_academic_year_id;

            $SchoolYear->updated_by =  auth()->user()->id;
            $SchoolYear->save();

            return new SchoolYearResource($SchoolYear);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un SchoolYear
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function destroy(AcademicYearDeleteRequest $request, $id)
    {
        try {
            $SchoolYear = AcademicYear::find($id);

            //AVANT DE SUPPRIMER, s'assurer que cet élément est mis en corbeille (c'est la meilleure façon de s'assurer
            // que les vérifications sont déjà faites si on veut éviter de les dupliquer)
            if($SchoolYear->deleted){
                $SchoolYear->delete();

                return response(null, 200);
            }else{
                return $this->sendError(__('app.trash_b4_deletion'));
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Archiver une ou plusieurs années scolaires
     *
     * @param AcademicYearTrashRequest $request
     * @return JsonResponse
     */
    public function trash(AcademicYearTrashRequest $request)
    {
        try {
            $user = auth()->user();

            AcademicYear::whereIn('id', $request->ids)->each(function ($academicyear) use ($user) {
                //TODO: S'assurer que cette année scolaire n'a pas encore été liée à autre chose

                $can_be_deleted = true;

                if($can_be_deleted){
                    $academicyear->update([
                        'deleted' => true,
                        'deleted_by' => auth()->user()->id,
                    ]);

                    Log::critical("Année Academique mise en corbeille.", ['academicyear' => $academicyear->id, 'author' => $user->id]);
                }else{
                    return $this->sendError(__('app.deletion_blocked'));
                }
            });

            return $this->sendResponse([],  'Année(s) Academique mise en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
          return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une ou plusieurs années scolaires
     *
     * @param AcademicYearTrashRequest $request
     * @return JsonResponse
     */
    public function restore(AcademicYearTrashRequest $request)
    {
        try {
            $user = auth()->user();

            AcademicYear::whereIn('id', $request->ids)->each(function ($academicyear) use ($user) {
                $academicyear->update([
                    'deleted' => false
                ]);

                Log::critical("Année(s) Academique restaurée.", ['academicyear' => $academicyear->id, 'author' => $user->id]);
            });

            return $this->sendResponse([],  'Année(s) Academique restaurée.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
           return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
