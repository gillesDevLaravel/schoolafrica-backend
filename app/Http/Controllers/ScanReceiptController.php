<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanReceipt\ScanReceiptArchiveRequest;
use App\Http\Requests\ScanReceipt\ScanReceiptCreateRequest;
use App\Http\Requests\ScanReceipt\ScanReceiptGetRequest;
use App\Http\Requests\ScanReceipt\ScanReceiptUpdateRequest;
use App\Http\Resources\ScanReceiptResource;
use App\Models\AcademicYear;
use App\Models\ScanReceipt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Gestion des reçus scannés
 *
 * API pour gérer les reçus scannés des paiements pour les utilisateurs.
 */
class ScanReceiptController extends BaseController
{
    /**
     * Liste les reçus scannés avec pagination et filtres.
     * @param ScanReceiptGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ScanReceiptGetRequest $request)
    {
        try {
            $pageItems = $request->pageItems ?? 1;
            $nbreItems = $request->nbreItems ?? 1000000;
            $idAcademicYear = $request->idAcademicYear ?? (AcademicYear::getCurrent() ? AcademicYear::getCurrent()->id : null);

            $scanReceipt = ScanReceipt::query()
                ->with(['student']) // Charger la relation student pour filtrer sur le nom
                ->when($idAcademicYear, function ($q) use ($idAcademicYear) {
                    return $q->where('idAcademicYear', $idAcademicYear);
                })
                ->when($request->idSchool, function ($q) use ($request) {
                    return $q->where('idSchool', $request->idSchool);
                })
                ->when($request->idStudent, function ($q) use ($request) {
                    return $q->where('idStudent', $request->idStudent);
                })
                ->when($request->created_at, function ($q) use ($request) {
                    // Vérifier le format avec regex
                    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $request->created_at)) {
                        // Format avec heure complète
                        return $q->where('created_at', $request->created_at);
                    } else {
                        // Format date simple
                        return $q->whereDate('created_at', $request->created_at);
                    }
                })
                ->when($request->filter_value, function ($q) use ($request) {
                    // Filtrer sur le nom de l'étudiant via la relation
                    return $q->whereHas('student', function ($studentQuery) use ($request) {
                        $studentQuery->where('name', 'like', '%' . $request->filter_value . '%');
                    });
                });

            return ScanReceiptResource::collection(
                $scanReceipt->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Crée un nouveau reçu scanné.
     * @param ScanReceiptCreateRequest $request
     * @return JsonResponse
     */
    public function create(ScanReceiptCreateRequest $request)
    {
        try {
            $scanReceipt = ScanReceipt::create([
                'idAcademicYear' => $request->idAcademicYear ?? (AcademicYear::getCurrent() ? AcademicYear::getCurrent()->id : 1),
                'idSchool' => $request->idSchool,
                'idStudent' => $request->idStudent,
                'image_scan' => $request->image_scan,
                'created_by' => auth()->id()
            ]);

            return $this->sendResponse(new ScanReceiptResource($scanReceipt), __('scan_receipt.create.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.create.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un reçu scanné.
     * @param ScanReceipt $scanReceipt
     * @return ScanReceiptResource|JsonResponse
     */
    public function show(ScanReceipt $scanReceipt)
    {
        try {
            return new ScanReceiptResource($scanReceipt);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Met à jour un reçu scanné existant.
     * @param ScanReceiptUpdateRequest $request
     * @param ScanReceipt $scanReceipt
     * @return JsonResponse
     */
    public function update(ScanReceiptUpdateRequest $request, ScanReceipt $scanReceipt)
    {
        try {
            $scanReceipt->update([
                'idAcademicYear' => $request->idAcademicYear ?? $scanReceipt->idAcademicYear,
                'idSchool' => $request->idSchool ?? $scanReceipt->idSchool,
                'idStudent' => $request->idStudent ?? $scanReceipt->idStudent,
                'image_scan' => $request->image_scan ?? $scanReceipt->image_scan,
                'updated_by' => auth()->id()
            ]);

            return $this->sendResponse(new ScanReceiptResource($scanReceipt), __('scan_receipt.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.update.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Met un ou plusieurs reçus scannés à la corbeille.
     * @param ScanReceiptArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(ScanReceiptArchiveRequest $request): JsonResponse
    {
        try {
            $scanReceipts = ScanReceipt::whereIn('id', $request->ids)->get();
            $scanReceipts->each(function ($scanReceipt) {
                $scanReceipt->delete();
            });

            return $this->sendResponse(
                ScanReceiptResource::collection($scanReceipts),
                __('scan_receipt.archive.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.archive.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Restaure un ou plusieurs reçus scannés depuis la corbeille.
     * @param ScanReceiptArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(ScanReceiptArchiveRequest $request): JsonResponse
    {
        try {
            $scanReceipts = ScanReceipt::onlyTrashed()->whereIn('id', $request->ids)->get();
            $scanReceipts->each(function ($scanReceipt) {
                $scanReceipt->restore();
            });

            return $this->sendResponse(
                ScanReceiptResource::collection($scanReceipts),
                __('scan_receipt.restore.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.restore.error'), null, 404, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement un ou plusieurs reçus scannés.
     * @param ScanReceiptArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(ScanReceiptArchiveRequest $request): JsonResponse
    {
        try {
            $scanReceipts = ScanReceipt::onlyTrashed()->whereIn('id', $request->ids)->get();
            $scanReceipts->each(function ($scanReceipt) {
                $scanReceipt->forceDelete();
            });

            return $this->sendResponse(
                ScanReceiptResource::collection($scanReceipts),
                __('scan_receipt.destroy.success')
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('scan_receipt.destroy.error'), null, 404, $th->getMessage());
        }
    }
}
