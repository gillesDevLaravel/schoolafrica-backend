<?php

namespace App\Http\Controllers;

use App\Http\Requests\BourseRequest;
use App\Http\Resources\Admin\BourseResource;
use App\Models\Bourse;
use App\Models\PensionUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Bourse
 */
class BourseController extends BaseController
{
    /**
     * Lister les bourses
     *
     * @bodyParam idSchool int
     * @bodyParam idSection int
     * @bodyParam pageItems int Le numéro de la page de pagination
     * @bodyParam nbreItems int Le nombre de résultats pour la page de pagination
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $bourses = Bourse::query();

            if(!is_null($request->idSchool)) $bourses = $bourses->where('idSchool', $request->idSchool);

            if(!is_null($request->idSection)) $bourses = $bourses->where('idSection', $request->idSection);

            $paginatedBourses = $bourses
                ->orderBy('name')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            // Calcul des statistiques globales des bourses
            $stats = $this->calculateBourseStats($request->idSchool, $request->idSection);

            return response()->json([
                'data' => BourseResource::collection($paginatedBourses),
                'stats' => $stats,
                'meta' => [
                    'current_page' => $paginatedBourses->currentPage(),
                    'last_page' => $paginatedBourses->lastPage(),
                    'per_page' => $paginatedBourses->perPage(),
                    'total' => $paginatedBourses->total(),
                ],
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Calculer les statistiques des bourses
     *
     * @param int|null $idSchool
     * @param int|null $idSection
     * @return array
     */
    private function calculateBourseStats($idSchool = null, $idSection = null)
    {
     $usersWithBourse = User::whereNotNull('users.idBourse')
        ->where('users.deleted', false);

     if (!is_null($idSchool)) {
        $usersWithBourse->where('users.idSchool', $idSchool);
     }

     if (!is_null($idSection)) {
        $usersWithBourse->where('users.idSection', $idSection);
     }

     // Nombre total
     $bourses_number = $usersWithBourse->count();

     // Montant total
     $bourses_amount = (clone $usersWithBourse)
        ->join('bourses', 'users.idBourse', '=', 'bourses.id')
        ->sum('bourses.amount');

     // Nombre utilisé
     $bourses_number_used = (clone $usersWithBourse)
        ->where('users.isBourseUsed', true)
        ->count();

     // Montant utilisé
     $bourses_amount_used = (clone $usersWithBourse)
        ->where('users.isBourseUsed', true)
        ->join('bourses', 'users.idBourse', '=', 'bourses.id')
        ->sum('bourses.amount');

     // Nombre non utilisé
     $bourses_number_not_used = (clone $usersWithBourse)
        ->where('users.isBourseUsed', false)
        ->count();

     // Montant non utilisé
     $bourses_amount_not_used = (clone $usersWithBourse)
        ->where('users.isBourseUsed', false)
        ->join('bourses', 'users.idBourse', '=', 'bourses.id')
        ->sum('bourses.amount');

     return [
        'bourses_number' => $bourses_number,
        'bourses_amount' => $bourses_amount,
        'bourses_number_used' => $bourses_number_used,
        'bourses_amount_used' => $bourses_amount_used,
        'bourses_number_not_used' => $bourses_number_not_used,
        'bourses_amount_not_used' => $bourses_amount_not_used,
      ];
    }

    /**
     * Afficher les détails d'une bourse
     *
     * @urlParam id int required
     * @return BourseResource|\Illuminate\Http\Response
     */
    public function show($idBourse)
    {
        try {
            $bourse = Bourse::findOrFail($idBourse);
            return BourseResource::make($bourse);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une nouvelle bourse
     *
     * @param BourseRequest $request
     * @return BourseResource|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->bourses as $bourse) {
                Bourse::create([
                    'name' => $bourse['name'],
                    'description' => $bourse['description'],
                    'amount' => $bourse['amount'],
                    'idSchool' => $bourse['idSchool'],
                    'idSection' => $bourse['idSection'] ?? null,
                    'created_by' => auth()->user()->id,
                ]);
            }

            return $this->sendResponse([], "Bourses créées avec succès");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une bourse
     *
     * @urlParam id int required
     *
     * @param BourseRequest $request
     * @return BourseResource|\Illuminate\Http\Response
     */
    public function update(Request $request, $idBourse)
    {
        try {
            $bourse = Bourse::findOrFail($idBourse);

            // Vérifier si la bourse est déjà utilisée dans pensionUsers avant de modifier le montant
            if ($request->has('amount') && $request->amount != $bourse->amount) {
                $pensionsWithBourse = PensionUser::where('idBourse', $bourse->id)->count();
                if ($pensionsWithBourse > 0) {
                    return $this->sendError("Impossible de modifier le montant d'une bourse qui a déjà été utilisée dans un paiement.");
                }
            }
            $bourse->name = $request->name ?? $bourse->name;
            $bourse->description = $request->description ?? $bourse->description;
            $bourse->amount = $request->amount ?? $bourse->amount;
            $bourse->idSchool = $request->idSchool ?? $bourse->idSchool;
            $bourse->idSection = $request->idSection ?? $bourse->idSection;
            $bourse->updated_by = auth()->user()->id;
            $bourse->save();

            return BourseResource::make($bourse);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer une bourse (si elle n'a pas encore été affecté à un utilisateur)
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response|void
     */
    public function destroy($idBourse)
    {
        try {
            $bourse = Bourse::findOrFail($idBourse);

            // on supprime uniquement si aucun user n'a ça sur son compte et aussi si ça n'existe pas dans pensionUsers
            $boursiersUsers = User::where('idBourse', $bourse->id)->count();
            $pensionsWithBourse = PensionUser::where('idBourse', $bourse->id)->count();
            if($boursiersUsers != 0 || $pensionsWithBourse != 0){
                return $this->sendError("Impossible de supprimer une bourse qui a déjà été affecté à un utilisateur.");
            }
            $bourse->delete();
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
