<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingReport\MeetingReportArchiveRequest;
use App\Http\Requests\MeetingReport\MeetingReportCreateRequest;
use App\Http\Requests\MeetingReport\MeetingReportGetRequest;
use App\Http\Requests\MeetingReport\MeetingReportUpdateRequest;
use App\Http\Resources\MeetingReportResource;
use App\Models\MeetingReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;


/**
 * @group Gestion des Meeting Reports
 *
 * Ce contrôleur gère toutes les opérations CRUD et d'archivage
 * concernant les comptes-rendus de réunion.
 */
class MeetingReportController extends BaseController
{
    /**
     * Affiche la liste des comptes-rendus avec possibilité de filtrage.
     *
     * Filtres disponibles :
     * - name (recherche partielle)
     * - type (exact)
     * - date (exact)
     * - date_start & date_end (plage de dates)
     * - filter_value (recherche globale sur name, type, description, participants)
     *
     * @param  MeetingReportGetRequest  $request
     * @return AnonymousResourceCollection<MeetingReportResource>
     */
    public function index(MeetingReportGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $meetingReports = MeetingReport::query();

            if ($request->filled('name')) {
                $meetingReports->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->filled('type')) {
                $meetingReports->where('type', $request->type);
            }

            if ($request->filled('date')) {
                $meetingReports->whereDate('date', $request->date);
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $meetingReports->whereBetween('date', [$request->date_start, $request->date_end]);
            } elseif ($request->filled('date_start')) {
                $meetingReports->whereDate('date', '>=', $request->date_start);
            } elseif ($request->filled('date_end')) {
                $meetingReports->whereDate('date', '<=', $request->date_end);
            }


            if ($request->filled('filter_value')) {
                $meetingReports->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('type', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('participants', 'like', '%' . $request->filter_value . '%');
                });
            }

            return MeetingReportResource::collection(
                $meetingReports
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouveau compte-rendu.
     *
     * @param  MeetingReportCreateRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "name": "Réunion Conseil d'Administration",
     *   "type": "Conseil d'Administration",
     *   "description": "Compte-rendu de la réunion du 15 mars 2025",
     *   "date": "2025-03-15",
     *   "participants": "Jean Dupont, Marie Martin, Paul Durand"
     * }
     */
    public function create(MeetingReportCreateRequest $request): JsonResponse
    {
    try {
        $data = [];
        foreach ($request->meeting_reports as $meeting_report) {
            $data[] = [
                'name'        => $meeting_report['name'],
                'type'        => $meeting_report['type'],
                'description' => $meeting_report['description'] ?? null,
                'date'        => $meeting_report['date'] ?? null,
                'participants' => $meeting_report['participants'] ?? null,
                'created_by'  => auth()->id(),
            ];
        }
        MeetingReport::insert($data);
        Log::info('Comptes-rendus créés avec succès', ['meeting_reports' => $data]);
        return $this->sendResponse($data, __('meeting_report.create.success'));
    } catch (\Throwable $th) {
        Log::error('Erreur lors de la création des comptes-rendus : ' . $th->getMessage());
        return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
    }
   }

    /**
     * Affiche un compte-rendu spécifique.
     *
     * @param  MeetingReport  $meeting_report
     * @return MeetingReportResource|JsonResponse
     */
    public function show(MeetingReport $meeting_report)
    {
        try {
            return new MeetingReportResource($meeting_report);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'affichage du compte-rendu : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met à jour un compte-rendu existant.
     *
     * @param  MeetingReportUpdateRequest  $request
     * @param  MeetingReport               $meeting_report
     * @return JsonResponse
     */
    public function update(MeetingReportUpdateRequest $request, MeetingReport $meeting_report): JsonResponse
    {
        try {
            $meeting_report->update([
                'name'        => $request['name'] ?? $meeting_report['name'],
                'type'        => $request['type'] ?? $meeting_report['type'],
                'description' => $request['description'] ?? $meeting_report['description'],
                'date'        => $request['date'] ?? $meeting_report['date'],
                'participants' => $request['participants'] ?? $meeting_report['participants'],
                'updated_by'  => auth()->id(),
            ]);
            Log::info('Compte-rendu mis à jour avec succès', ['meeting_report' => $meeting_report]);
            return $this->sendResponse(new MeetingReportResource($meeting_report), __('meeting_report.update.success'));
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du compte-rendu : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des comptes-rendus à la corbeille (soft delete).
     *
     * @param  MeetingReportArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trash(MeetingReportArchiveRequest $request): JsonResponse
    {
        try {
            MeetingReport::whereIn('id', $request->ids)->delete();
            Log::info('Comptes-rendus mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], __('meeting_report.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des comptes-rendus : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des comptes-rendus supprimés (soft delete).
     *
     * @param  MeetingReportArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restore(MeetingReportArchiveRequest $request): JsonResponse
    {
        try {
            MeetingReport::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Comptes-rendus restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], __('meeting_report.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des comptes-rendus : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des comptes-rendus (hard delete).
     *
     * @param  MeetingReportArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroy(MeetingReportArchiveRequest $request): JsonResponse
    {
        try {
            MeetingReport::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Comptes-rendus supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], __('meeting_report.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des comptes-rendus : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
