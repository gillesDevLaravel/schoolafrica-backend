<?php

namespace App\Http\Controllers;

use App\Enums\MoratoriumStatusEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\Moratorium\MoratoriumArchiveRequest;
use App\Http\Requests\Moratorium\MoratoriumGetRequest;
use App\Http\Requests\Moratorium\MoratoriumStoreRequest;
use App\Http\Requests\Moratorium\MoratoriumUpdateRequest;
use App\Http\Resources\MoratoriumResource;
use App\Models\Moratorium;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @group Moratoires
 * Gestion des Moratoires
 */
class MoratoriumController extends BaseController
{
    /**
     * Afficher la liste des moratoires filtrée
     * @param MoratoriumGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(MoratoriumGetRequest $request)
    {
        try {
            $pageItems = $request->pageItems ?? 1;
            $nbreItems = $request->nbreItems ?? 1000000;

            $moratoriums = Moratorium::query()
                ->when($request->idUser, function ($q) use ($request) {
                    $q->where('idUser', $request->idUser);
                })
                ->when($request->idUserApprove, function ($q) use ($request) {
                    $q->where('idUserApprove', $request->idUserApprove);
                })
                ->when($request->status, function ($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->start_date_from, function ($q) use ($request) {
                    $q->whereDate('startDate', '>=', $request->start_date_from);
                })
                ->when($request->start_date_to, function ($q) use ($request) {
                    $q->whereDate('startDate', '<=', $request->start_date_to);
                })
                ->when($request->end_date_from, function ($q) use ($request) {
                    $q->whereDate('endDate', '>=', $request->end_date_from);
                })
                ->when($request->end_date_to, function ($q) use ($request) {
                    $q->whereDate('endDate', '<=', $request->end_date_to);
                })
                ->when($request->filter_value, function ($q) use ($request) {
                    $q->where(function ($query) use ($request) {
                        $query->where('reason', 'like', '%' . $request->filter_value . '%')
                            ->orWhere('status', 'like', '%' . $request->filter_value . '%');
                    });
                });

            return MoratoriumResource::collection(
                $moratoriums->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    /**
     * Ajouter un nouveau moratoire
     * @param MoratoriumStoreRequest $request
     * @return JsonResponse
     */
    public function store(MoratoriumStoreRequest $request): JsonResponse
    {
        try {
            $moratorium = Moratorium::create([
                'idUser' => $request->idUser,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'reason' => $request->reason,
                'note_comptable' => $request->note_comptable,
                'note_fondatrice' => $request->note_fondatrice,
                'status' => $request->status ?? MoratoriumStatusEnum::VALID,
                'createdBy' => auth()->id(),
                'idUserApprove' => $request->idUserApprove,
            ]);

            return $this->sendResponse(new MoratoriumResource($moratorium), __('moratorium.create.success'));

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }


    /**
     * Afficher un moratoire spécifique
     * @param Moratorium $moratorium
     * @return MoratoriumResource|JsonResponse
     */
    public function show(Moratorium $moratorium)
    {

        try {
            return new MoratoriumResource($moratorium);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Modifier un moratoire spécifique
     * @param MoratoriumUpdateRequest $request
     * @param Moratorium $moratorium
     * @return JsonResponse
     */
    public function update(MoratoriumUpdateRequest $request, Moratorium $moratorium)
    {
        try {
            if ($moratorium->status === MoratoriumStatusEnum::APPROVED) {
                return $this->sendError(__('update.impossible'));
            }

            $moratorium->update([
                'idUser' => $request->idUser ?? $moratorium->idUser,
                'startDate' => $request->startDate ?? $moratorium->startDate,
                'endDate' => $request->endDate ?? $moratorium->endDate,
                'reason' => $request->reason ?? $moratorium->reason,
                'note_comptable' => $request->note_comptable ?? $moratorium->note_comptable,
                'note_fondatrice' => $request->note_fondatrice ?? $moratorium->note_fondatrice,
                'updatedBy' => auth()->id(),
                //'idUserApprove' => $request->idUserApprove ?? $request->idUserApprove,
            ]);

            if ($request->status === MoratoriumStatusEnum::APPROVED && $moratorium->idUserApprove === auth()->id()){
                $moratorium->update([
                    'status' => $request->status
                ]);
            }else if($request->status === MoratoriumStatusEnum::APPROVED && $moratorium->idUserApprove !== auth()->id()){
                return $this->sendError(__('moratorium.update.approve_error'));
            }

            return $this->sendResponse(new MoratoriumResource($moratorium), __('moratorium.update.success'));

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Mettre un moratoire à la corbeille
     * @param MoratoriumArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(MoratoriumArchiveRequest $request): JsonResponse
    {
        try {
            $moratoriums = Moratorium::whereIn('id', $request->ids)->get();

            $moratoriums->each(function ($moratorium) {
                $moratorium->delete();
            });

            return $this->sendResponse(
                MoratoriumResource::collection($moratoriums),
                __('moratorium.archive.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Retirer un ou plusieurs moratoires de la corbeille (restauration).
     * @param MoratoriumArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(MoratoriumArchiveRequest $request): JsonResponse
    {
        try {
            $moratoriums = Moratorium::onlyTrashed()->whereIn('id', $request->ids)->get();

            $moratoriums->each(function ($moratorium) {
                $moratorium->restore();
            });

            return $this->sendResponse(
                MoratoriumResource::collection($moratoriums),
                __('moratorium.restore.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement un ou plusieurs moratoires.
     * @param MoratoriumArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(MoratoriumArchiveRequest $request): JsonResponse
    {
        try {
            $moratoriums = Moratorium::onlyTrashed()->whereIn('id', $request->ids)->get();

            $moratoriums->each(function ($moratorium) {
                $moratorium->forceDelete();
            });

            return $this->sendResponse(
                MoratoriumResource::collection($moratoriums),
                __('moratorium.destroy.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

}
