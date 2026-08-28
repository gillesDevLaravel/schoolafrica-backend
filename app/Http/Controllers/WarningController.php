<?php

namespace App\Http\Controllers;

use App\Http\Requests\Warning\WarningDestroyRequest;
use App\Http\Requests\Warning\WarningGetRequest;
use App\Http\Requests\Warning\WarningRestoreRequest;
use App\Http\Requests\Warning\WarningStoreRequest;
use App\Http\Requests\Warning\WarningTrashRequest;
use App\Http\Requests\Warning\WarningUpdateRequest;
use App\Http\Resources\WarningResource;
use App\Models\Notification;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Avertissements
 * Gestion des avertissements
 */
class WarningController extends BaseController
{
    /**
     * Lister les avertissements
     *
     * @param WarningGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(WarningGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $warnings = Warning::query()
                ->where('deleted', (boolean) $request->trashed); // il y'aura toujours une valeur dans $trashed

            if ($request->idUser) $warnings->where('idUser', $request->idUser);
            if ($request->date) $warnings->where('date', $request->date);

            // Filtres par plage de dates
            if ($request->filled('start_date')) {
                $warnings->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $warnings->whereDate('date', '<=', $request->end_date);
            }

            // Filtrage par valeur de recherche par raison et par nom d'utilisateur l'utilisateur
            if ($request->filled('filter_value')) {
                $warnings->where(function ($query) use ($request) {
                    $query->where('reason', 'like', '%' . $request->filter_value . '%')
                        ->orwhereHas('user', function($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->filter_value . '%');
                        });
                });
            }

            return WarningResource::collection(
                $warnings
                ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un avertissement
     *
     * @param Warning $warning
     * @return WarningResource|\Illuminate\Http\JsonResponse
     */
    public function show(Warning $warning)
    {
        try {
            return new WarningResource($warning);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un ou plusieurs avertissements
     *
     * @param WarningStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WarningStoreRequest $request)
    {
        try {
            $warnings = array();

            $author = auth()->user();

            foreach ($request->warnings as $warning) {
                $tmp_warning = Warning::create([
                    'idUser' => $warning['idUser'],
                    'reason' => $warning['reason'],
                    'date' => $warning['date'],
                    'created_by' => $author->id,
                ]);

                $concerned_user = User::select('id', 'name', 'idParent')->find($warning['idUser']);

                //TODO: Notifier l'utilisateur et son parent si y'en a
                Notification::create([
                    'notificationable_type' => Warning::class,
                    'notificationable_id' => $tmp_warning->id,
                    'title' => "⚠️⚠️ ". __('warning.notif_title') ." ⚠️⚠️",
                    'description' => $warning['reason'] . "\n\n" . __('warning.notif_description') . "{$author->name}",
                    'grouped_users' => json_encode([$concerned_user->id, $concerned_user->idParent]),
                    'user_id' => null
                ]);

                $warnings[] = $tmp_warning;
                Log::info("Ajout d'un avertissement ", ['warning' => $tmp_warning->id, 'author' => $author->id]);
            }

            return $this->sendResponse(WarningResource::collection($warnings), 'Avertissement(s) ajouté(s) avec succès.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier les détails d'un avertissement
     *
     * @param WarningUpdateRequest $request
     * @param Warning $warning
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(WarningUpdateRequest $request, Warning $warning)
    {
        try {
            $warning->update([
                'idUser' => $request->idUser ?? $warning->idUser,
                'reason' => $request->reason ?? $warning->reason,
                'date' => $request->date ?? $warning->date,
                'updated_by' => auth()->user()->id,
            ]);
            $warning->save();

            return $this->sendResponse(
                new WarningResource($warning),
                "Avertissement mis à jour avec succès."
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre un ou plusieurs produits en corbeille
     *
     * @param WarningTrashRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash(WarningTrashRequest $request)
    {
        try {
            Warning::whereIn('id', $request->idWarnings)->each(function ($warning) {
                $warning->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::critical("Avertissement mis en corbeille.", ['warning' => $warning->id, 'author' => auth()->user()->id]);
            });

            return $this->sendResponse([],  'Avertissement(s) mis en corbeille.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Restaurer un ou plusieurs produits de la corbeille
     *
     * @param WarningRestoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(WarningRestoreRequest $request)
    {
        try {
            $warnings = Warning::whereIn('id', $request->idWarnings)
                ->get();

            foreach ($warnings as $warning) {
                $warning->update([
                    'deleted' => false,
                    'deleted_by' => auth()->user()->id,
                ]);

                Log::info("Restauration d'avertissement(s) de la corbeille.", ['warning' => $warning->id, 'author' => auth()->user()->id]);
            }

            return response()->json([
                'message' => 'Avertissement(s) restauré avec succès.',
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimmer un ou plusieurs avertissement(s)
     *
     * @param WarningDestroyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(WarningDestroyRequest $request)
    {
        try {
            Warning::whereIn('id', $request->idWarnings)->each(function ($warning) {
                Log::critical("Avertissement supprimé.", ['warning' => $warning->id, 'author' => auth()->user()->id]);

                $warning->delete();
            });

            return $this->sendResponse([],  'Avertissement(s) supprimés avec succès.');

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
