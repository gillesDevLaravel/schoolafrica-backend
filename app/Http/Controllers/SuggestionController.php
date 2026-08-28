<?php

namespace App\Http\Controllers;

use App\Http\Requests\Suggestion\SuggestionArchiveRequest;
use App\Http\Requests\Suggestion\SuggestionCreateRequest;
use App\Http\Requests\Suggestion\SuggestionGetRequest;
use App\Http\Requests\Suggestion\SuggestionUpdateRequest;
use App\Http\Resources\SuggestionResource;
use App\Models\Suggestion;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Suggestions / Suggestions
 *
 * Gestion des Suggestions
 */
class SuggestionController extends BaseController
{
    /**
     * Afficher la liste des suggestions
     * @param SuggestionGetRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SuggestionGetRequest $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);
            $filter_value = $request->filter_value ?? null;

            $suggestions = Suggestion::query();

            if ($request->filled('isAnonymous')) {
                $suggestions->where('is_anonymous', $request->isAnonymous);
            }

            if ($request->filled('date_start') && $request->filled('date_end')) {
                $suggestions->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }

            if ($request->filled('user_id')) {
                $suggestions->where('user_id', $request->user_id);
            }

            if ($request->filled('filter_value')) {
                $suggestions->where(function ($q) use ($request) {
                    $q->where('description', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('name', 'like', '%' . $request->filter_value . '%')
                        ->orWhere('created_at', 'like', '%' . $request->filter_value . '%');

                });
            }

            return SuggestionResource::collection(
                $suggestions
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Ajouter une nouvelle suggestion
     * @param SuggestionCreateRequest $request
     * @return mixed
     */
    public function create(SuggestionCreateRequest $request)
    {
        try {
            $suggestion = Suggestion::create([
                'name' => $request['name'] ?? null,
                'description' => $request['description'],
                'user_id' => $request['user_id'] ?? auth()->id(),
                'created_by' => auth()->id(),
                'is_anonymous' => $request['isAnonymous'] ?? false,
                'answer' => $request['answer'] ?? null,
            ]);



            // Si le créateur est un parent, notifier les Staff et la Direction de l'école

            $role = auth()->user()->getRole();
            if ($role && ((int)($role->id) === 7)) { // 7 => rôle Parent (référence utilisée ailleurs dans le projet)
                $idSchool = auth()->user()->idSchool;
                $recipients = User::select('users.id')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('users.deleted', 0)
                    ->whereIn(DB::raw('LOWER(roles.type)'), ['staffs', 'direction'])
                    ->when($idSchool, function ($q) use ($idSchool) {
                        $q->where('users.idSchool', $idSchool);
                    })
                    ->pluck('id')
                    ->toArray();

                if (!empty($recipients)) {
                    Notification::create([
                        'notificationable_type' => Suggestion::class,
                        'notificationable_id' => $suggestion->id,
                        'title' => 'Nouvelle suggestion',
                        'description' => 'Une nouvelle suggestion a été soumise.',
                        'user_id' => null,
                        'grouped_users' => json_encode($recipients),
                    ]);
                }
            }

            Log::info('Ajout réussi de la suggestion', ['author' => auth()->id(), 'suggestion' => $suggestion]);
            return $this->sendResponse(new SuggestionResource($suggestion), __('suggestion.create.success'));
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Afficher une suggestion spécifique
     * @param Suggestion $suggestion
     * @return SuggestionResource
     */
    public function show(Suggestion $suggestion)
    {
        try {
            return new SuggestionResource($suggestion);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Modifier une suggestion spécifique
     * @param SuggestionUpdateRequest $request
     * @param Suggestion $suggestion
     * @return mixed
     */
    public function update(SuggestionUpdateRequest $request, Suggestion $suggestion)
    {
        try {
            // Récupérer le rôle de l'utilisateur authentifié et le convertir en minuscule si nécessaire
            $role = auth()->user()->getRole();
            $roleType = $role->type ?? null;
            $roleType = is_string($roleType) ? strtolower($roleType) : $roleType;


            // Sauvegarder la réponse précédente de la suggestion
            $previousAnswer = $suggestion->answer;

            $suggestion->update([
                'name' => $request['name'] ?? $suggestion->name,
                'description' => $request['description'] ?? $suggestion->description,
                'user_id' => $request['user_id'] ?? $suggestion->user_id,
                'is_anonymous' => $request['isAnonymous'] ?? $suggestion->is_anonymous,
                'answer' => $request['answer'] ?? $suggestion->answer,
                'updated_by' => auth()->id(),
            ]);

            // Notifier l'auteur si une réponse est ajoutée et que l'auteur est différent du créateur
            if (is_null($previousAnswer) && !is_null($suggestion->answer) && $suggestion->user_id !== auth()->id()) {

                    Notification::create([
                        'notificationable_type' => Suggestion::class,
                        'notificationable_id' => $suggestion->id,
                        'title' => 'Réponse à votre suggestion',
                        'description' => 'Votre suggestion a reçu une réponse.',
                        'user_id' => $suggestion->user_id,
                        'grouped_users' => null,
                    ]);

            }
            return $this->sendResponse(SuggestionResource::make($suggestion), __('suggestion.update.success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Archivage multiple des suggestions
     * @param SuggestionArchiveRequest $request
     * @return JsonResponse
     */
    public function trash(SuggestionArchiveRequest $request)
    {
        try {
            $suggestionIds = $request['ids'] ?? [];

            // Permission: seul le créateur peut archiver ses suggestions
            $ownedIds = Suggestion::whereIn('id', $suggestionIds)
                ->where(function ($q) {
                    $q->whereNull('user_id')
                      ->orWhere('user_id', auth()->id());
                })
                ->pluck('id')->toArray();

            if (count($ownedIds) !== count($suggestionIds)) {
                return $this->sendError(__('app.unauthorized') ?? 'Unauthorized', null, 403);
            }

            Suggestion::whereIn('id', $ownedIds)->delete();

            return $this->sendResponse([], __('suggestion.trash.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Restauration multiple des rapports journaliers
     * @param SuggestionArchiveRequest $request
     * @return JsonResponse
     */
    public function restore(SuggestionArchiveRequest $request)
    {
        try {
            $suggestionIds = $request['ids'] ?? null;

            // Restaurer les locations
            Suggestion::withTrashed()->whereIn('id', $suggestionIds)->restore();

            return $this->sendResponse([], __('suggestion.restore.success'), 200);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Fonction de suppression définitive multiple des locations
     * @param SuggestionArchiveRequest $request
     * @return JsonResponse
     */
    public function destroy(SuggestionArchiveRequest $request)
    {
        try {
            $suggestionIds = $request['ids'] ?? [];

            // Permission: seul le créateur peut supprimer définitivement
            $ownedIds = Suggestion::withTrashed()
                ->whereIn('id', $suggestionIds)
                ->where(function ($q) {
                    $q->whereNull('user_id')
                      ->orWhere('user_id', auth()->id());
                })
                ->pluck('id')->toArray();

            if (count($ownedIds) !== count($suggestionIds)) {
                return $this->sendError(__('app.unauthorized') ?? 'Unauthorized', null, 403);
            }

            Suggestion::withTrashed()->whereIn('id', $ownedIds)->forceDelete();

            return $this->sendResponse([], __('suggestion.delete.success'), 204);
        } catch (\Throwable $th) {
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }
}
