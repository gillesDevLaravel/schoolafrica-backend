<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolDelay\SchoolDelayArchiveRequest;
use App\Http\Requests\SchoolDelay\SchoolDelayCreateRequest;
use App\Http\Requests\SchoolDelay\SchoolDelayGetRequest;
use App\Http\Requests\SchoolDelay\SchoolDelayUpdateRequest;
use App\Http\Resources\SchoolDelayResource;
use App\Models\Course;
use App\Models\Notification;
use App\Models\School;
use App\Models\SchoolDelay;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Gestion Retard Scolaire | School Delay
 *
 * Ce contrôleur gère toutes les opérations CRUD et d’archivage
 * concernant le Retard Scolaire.
 */
class SchoolDelayController extends BaseController
{
    /**
     * Récupère la liste paginée des retards scolaires.
     * Permet de filtrer par idStudent, idCourse, date, hour.
     * La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).
     *
     * @param SchoolDelayGetRequest $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function index(SchoolDelayGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = SchoolDelay::query()->with(['user', 'course']);

            // Filtre par idClasse via la relation user
            if ($request->filled('idClasse')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('idClasse', $request->idClasse);
                });
            }

            // Filtre par idStudent spécifique
            if ($request->filled('idStudent')) {
                $query->where('idStudent', $request->idStudent);
            }

            // Filtre par nom/prénom de l'élève
            if ($request->filled('filter_value')) {
                $filter = $request->filter_value;
                $query->whereHas('user', function ($q) use ($filter) {
                    $q->where('name', 'like', "%{$filter}%");
                });
            }
            //filtre avec date_start et date_end
            if ($request->filled('date_start') && $request->filled('date_end')) {
                $query->whereBetween('date', [$request->date_start, $request->date_end]);
            }
            // Autres filtres
            if ($request->filled('idCourse')) {
                $query->where('idCourse', $request->idCourse);
            }
            if ($request->filled('date')) {
                $query->whereDate('date', $request->date);
            }
            if ($request->filled('hour')) {
                $query->where('hour', $request->hour);
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            return SchoolDelayResource::collection(
                $query->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical(
                'Erreur lors de la récupération des retards scolaires : ' . $th->getMessage()
            );
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouveau retard scolaire.
     *
     * @param SchoolDelayCreateRequest $request
     * @return JsonResponse
     */
    public function create(SchoolDelayCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();
            $createdBy = auth()->id();
            $now = now();

            // Récupération des élèves et écoles
            $students = User::whereIn('id', $validated['idStudents'])
                ->with('school')
                ->get()
                ->keyBy('id');

            // Récupération du cours si défini
            $course = null;
            if (!empty($validated['idCourse'])) {
                $course = Course::with('matter')->find($validated['idCourse']);
            }

            $delaysData = [];
            $notificationsData = [];

            foreach ($validated['idStudents'] as $studentId) {
                if (!isset($students[$studentId])) {
                    continue; // Ignorer les IDs non valides
                }

                $student = $students[$studentId];
                $school  = $student->school;

                // Préparer les données du retard
                $delaysData[] = [
                    'hour'        => $validated['hour'],
                    'date'        => $validated['date'],
                    'description' => $validated['description'] ?? null,
                    'type'        => $validated['type'] ?? null,
                    'idStudent'   => $studentId,
                    'idCourse'    => $validated['idCourse'] ?? null,
                    'created_by'  => $createdBy,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ];

                // Préparer la notification correspondante
                $description = ($course && $course->matter)
                    ? __('notifs.delay_desc', [
                        'nom'           => $student->name,
                        'cours_libelle' => $course->matter->libelle,
                        'date'          => $validated['date'],
                        'heure'         => $validated['hour'],
                    ])
                    : __('notifs.delay_desc_no_course', [
                        'nom'   => $student->name,
                        'date'  => $validated['date'],
                        'heure' => $validated['hour'],
                    ]);

                $notificationsData[] = [
                    'notificationable_type' => SchoolDelay::class,
                    'notificationable_id'   => null, // sera mis à jour après insert
                    'title'                 => __('notifs.delay_title'),
                    'description'           => $description,
                    'user_id'               => $student->idParent
                        ? $student->idParent
                        : $student->id,
                    'grouped_users'         => null,
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ];
            }

            // Insert batch des retards
            SchoolDelay::insert($delaysData);

            // Récupérer les IDs des retards créés
            $delays = SchoolDelay::where('created_by', $createdBy)
                ->where('date', $validated['date'])
                ->whereIn('idStudent', $validated['idStudents'])
                ->get();

            // Mettre à jour notificationable_id
            foreach ($notificationsData as $key => &$notif) {
                if (isset($delays[$key])) {
                    $notif['notificationable_id'] = $delays[$key]->id;
                }
            }

            // Insert batch des notifications
            Notification::insert($notificationsData);

            DB::commit();

            return $this->sendResponse(
                SchoolDelayResource::collection($delays),
                __('schoolDelay.create.success')
            );

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::critical('Erreur lors de la création des retards scolaires : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un retard scolaire.
     *
     * @param SchoolDelay $schoolDelay
     * @return SchoolDelayResource
     */
    public function show(SchoolDelay $schoolDelay): SchoolDelayResource
    {
        return new SchoolDelayResource($schoolDelay);
    }

    /**
     * Met à jour un retard scolaire existant.
     *
     * @param SchoolDelayUpdateRequest $request
     * @param SchoolDelay $schoolDelay
     * @return JsonResponse
     */
    public function update(SchoolDelayUpdateRequest $request, SchoolDelay $schoolDelay): JsonResponse
    {
        try {
            $schoolDelay->update($request->validated() + ['updated_by' => auth()->id()]);
            Log::info('Retard scolaire mis à jour avec succès', [
                'schoolDelay' => $schoolDelay
            ]);
            return $this->sendResponse(
                new SchoolDelayResource($schoolDelay),
                __('schoolDelay.update.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du retard scolaire : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime temporairement un ou plusieurs retards scolaires (mise à la corbeille).
     *
     * @param SchoolDelayArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(SchoolDelayArchiveRequest $request): JsonResponse
    {
        try {
            SchoolDelay::whereIn('id', $request->ids)->delete();
            Log::info('Retards scolaires mis à la corbeille', [
                'ids' => $request->ids
            ]);
            return $this->sendResponse([], __('schoolDelay.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des retards scolaires : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure un ou plusieurs retards scolaires supprimés.
     *
     * @param SchoolDelayArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(SchoolDelayArchiveRequest $request): JsonResponse
    {
        try {
            SchoolDelay::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Retards scolaires restaurés', [
                'ids' => $request->ids
            ]);
            return $this->sendResponse([], __('schoolDelay.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des retards scolaires : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement un ou plusieurs retards scolaires.
     *
     * @param SchoolDelayArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(SchoolDelayArchiveRequest $request): JsonResponse
    {
        try {
            SchoolDelay::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Retards scolaires supprimés définitivement', [
                'ids' => $request->ids
            ]);
            return $this->sendResponse([], __('schoolDelay.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des retards scolaires : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

}
