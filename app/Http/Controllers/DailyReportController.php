<?php

namespace App\Http\Controllers;

use App\Http\Requests\DailyReport\DailyReportArchiveRequest;
use App\Http\Requests\DailyReport\DailyReportCreateRequest;
use App\Http\Requests\DailyReport\DailyReportGetRequest;
use App\Http\Requests\DailyReport\DailyReportUpdateRequest;
use App\Http\Resources\DailyReportResource;
use App\Models\DailyReport;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

/**
 * @group Rapports journalier / Daily reports
 *
 * Gestion des rapports journaliers
 */
class DailyReportController extends BaseController
{
    /**
     * Afficher la liste des rapports journaliers filtrés.
     * @param DailyReportGetRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(DailyReportGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->filter_value;

            $daylyReports = DailyReport::query();
            if ($request->filled('idUser')) {
                $daylyReports->where('user_id', $request->idUser);
            }
            if ($request->filled('date')) {
                $daylyReports->where('date', $request->date);
            } 
            
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $daylyReports->whereBetween('date', [$request->date_start, $request->date_end]);
            }

            if ($request->filled('filter_value')) {
                $daylyReports->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('comments', 'like', '%' . $request->filter_value . '%');
                });
            }

            return DailyReportResource::collection(
                $daylyReports
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Ajouter un nouveau rapport journalier.
     * @param DailyReportCreateRequest $request
     * @return mixed
     */
    public function create(DailyReportCreateRequest $request)
    {
        try {
            $dailyReport = DailyReport::create([
                'name' => $request['name'] ?? null,
                'date' => $request['date'],
                'description' => $request['description'] ?? null,
                'comments' => $request['comments'] ?? null,
                'user_id' => $request['user_id'],
                'created_by' => auth()->id(),
            ]);

            Log::info('Ajout réussi du rapport journalier', ['author' => auth()->id(), 'daily_report' => $dailyReport]);

            return $this->sendResponse(new DailyReportResource($dailyReport), __('daily_report.create.success'));
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher un rapport journalier spécifique.
     * @param DailyReport $dailyReport
     * @return DailyReportResource|JsonResponse
     */
    public function show(DailyReport $dailyReport)
    {
        try {
            return new DailyReportResource($dailyReport);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param DailyReportUpdateRequest $request
     * @param DailyReport $dailyReport
     * @return JsonResponse
     */
    public function update(DailyReportUpdateRequest $request, DailyReport $dailyReport)
    {
        try {


            $dailyReport->update([
                'name' => $request['name'] ?? $dailyReport->name,
                'date' => $request['date'] ?? $dailyReport->date,
                'description' => $request['description'] ?? $dailyReport->description,
                'comments' => $request['comments'] ?? $dailyReport->comments,
                'user_id' => $request['user_id'] ?? $dailyReport->user_id,
                'updated_by' => auth()->id(),
            ]);

            Log::info('Modification réussie du rapport journalier', ['author' => auth()->id(), 'daily_report' => $dailyReport]);
            return $this->sendResponse(DailyReportResource::make($dailyReport), __('daily_report.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Archivage multiple des rapports journalier
     * @param DailyReportArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(DailyReportArchiveRequest $request)
    {
        try {
            $dailyReport = $request['ids'] ?? null;

            // Désactiver les locations
            DailyReport::whereIn('id', $dailyReport)->delete();

            return $this->sendResponse([], __('daily_report.trash.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Restauration multiple des rapports journaliers
     * @param DailyReportArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(DailyReportArchiveRequest $request)
    {
        try {
            $dailyReport = $request['ids'] ?? null;

            // Restaurer les locations
            DailyReport::withTrashed()->whereIn('id', $dailyReport)->restore();

            return $this->sendResponse([], __('daily_report.restore.success'), 200);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des locations
     * @param DailyReportArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(DailyReportArchiveRequest $request)
    {
        try {
            $dailyReport = $request['ids'] ?? null;

            // Suppression définitive
            DailyReport::withTrashed()->whereIn('id', $dailyReport)->forceDelete();

            return $this->sendResponse([], __('daily_report.delete.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }
}
