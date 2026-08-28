<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\PensionResource;
use App\Http\Requests\Staffs\PensionRequest;
use App\Http\Requests\Staffs\PensionGetAllRequest;
use App\Models\Pension;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\PensionTrancheFeeRequest;
use App\Http\Resources\Staffs\FeePensionTrancheResource;
use App\Http\Resources\Staffs\PensionFeeTrancheResource;
use App\Http\Resources\Staffs\TranchePensionFeeResource;
use App\Models\Fee;
use App\Models\PensionUser;
use App\Models\Tranche;
use Illuminate\Support\Facades\Log;

/**
 * @group Pension
 */
class PensionController extends BaseController
{
    /**
     * Listing des pensions
     *
     * @param PensionGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(PensionGetAllRequest $request)
    {
        try {
            $pension = $request->validated();
            $idLevel = $request['idLevel'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idTypeOfRecipe = $request['idTypeOfRecipe'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page

            $pensions = Pension::where('idSchool',$pension['idSchool']);

            if(!is_null($idSection)) $pensions = $pensions->where('idSection',$pension['idSection']);
            if(!is_null($idTypeOfRecipe)) $pensions = $pensions->where('type_of_recipe_id',$pension['idTypeOfRecipe']);

            if(!is_null($idLevel)) $pensions = $pensions->where('idLevel', $idLevel);
            if(!is_null($idOptionLevel)) $pensions = $pensions->where('idOptionLevel', $idOptionLevel);

            return PensionResource::collection(
                $pensions
                    ->orderBy("id", "desc")
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter une pension
     *
     * @param PensionRequest $request
     * @return PensionResource|\Illuminate\Http\Response
     */
    public function store(PensionRequest $request)
    {
        try {
            $pensionsData = $request->pensions;
            $pensions = array();

            foreach ($pensionsData as $pensionData) {
                $level = Level::find($pensionData['idLevel']);

                $pension = Pension::updateOrCreate([
                    'idLevel' => $pensionData['idLevel'],
                ],[
                    'name' => $pensionData['name'] ?? null, // hummm ... 11/11/2024
                    'price' => $pensionData['price'],
                    'nbrTranche' => $pensionData['nbrTranche'],
                    'idLevel' => $pensionData['idLevel'],
                    'idOptionLevel' => $pensionData['idOptionLevel'] ?? null,
                    'idSchool' => $level->idSchool,
                    'idSection' => $level->idSection,
                    'type_of_recipe_id' => $pensionData['idTypeOfRecipe'] ?? null,
                    'created_by' => auth()->user()->id
                ]);
            }

            return $this->sendResponse(PensionResource::collection($pensions), 'Pensions created successfully.');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une pension
     *
     * @param Pension $pension
     * @param $id
     * @return PensionResource|\Illuminate\Http\Response
     */
    public function show(Pension $pension,$id)
    {
        try {
            $pension = Pension::findOrFail($id);
            return new PensionResource($pension);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'une pension
     *{
     *"name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}
     * @param Request $request
     * @param $id
     * @return PensionResource|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $pension = Pension::findOrFail($id);

            //verifier si des paiements ont déjà été effectuées
            $nbrTranches = Tranche::where("idPension", $id)->count();
            if ($nbrTranches > 0){
                //verifier si le prix a changé
                if(!is_null($request["price"]) && $request["price"] != $pension->price){
                    return $this->sendError("impossible de modifier car le prix a changé et {$nbrTranches} tranche(s) on déjà été crées)");
                }
            }


            $pension->name = $request['name'] ?? $pension->name;
            $pension->price = $request['price'] ?? $pension->price;
            $pension->nbrTranche = $request['nbrTranche'] ?? $pension->nbrTranche;
            $pension->idLevel = $request['idLevel'] ?? $pension->idLevel;
            $pension->idOptionLevel = $request['idOptionLevel'] ?? $pension['idOptionLevel'];
            $pension->type_of_recipe_id = $request['idTypeOfRecipe'] ?? $pension['type_of_recipe_id'];

            if(!is_null($request['idLevel'])){
                $level = Level::find($request['idLevel']);

                $pension->idSchool = $level->idSchool ?? $pension->idSchool;
                $pension->idSection =  $level->idSection ?? $pension->idSection;
            }

            $pension->updated_by = auth()->user()->id;

            $pension->save();
            return new PensionResource($pension);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une pension
     *"name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}
     *
     * @param Pension $pension
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pension $pension,$id)
    {
        try {
            //verifier si des tranches ont déjà été crées
            $nbrTranche = Tranche::where("idPension", $id)->count();
            if ($nbrTranche > 0){

                return $this->sendError("impossible de supprimer car {$nbrTranche} tranche(s) on déjà été crée");
            }

            $pension = Pension::findOrFail($id);
            $pensionUser = PensionUser::where('idPension',$id)->get();

            if(count($pensionUser)){
                return $this->sendError('impossible, paiement pension existant');
            }else{
//                $pension->delete();
                $pension->update([
                    'deleted' => true,
                    'deleted_by' => auth()->user()->id,
                ]);

                return $this->sendResponses(null);
            }
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function pensionTrancheFees(PensionTrancheFeeRequest $request)
    {
        try {
            $tabAll = array();
            $pensiontranchefee = $request->validated();
            $pension = PensionFeeTrancheResource::collection(
                            Pension::where('idSchool',$pensiontranchefee['idSchool'])
                                    ->where('idSection',$pensiontranchefee['idSection'])
                                    ->where('idLevel',$pensiontranchefee['idLevel'])->get()
                        );

            $tabAll['pension'] = $pension;

            $fee = FeePensionTrancheResource::collection(
                        Fee::select('fees.id as id','fees.name as name','fees.price as price','fees.deadline as deadline','fees.idOptionLevel as idOptionLevel',
                        'fees.idSchool as idSchool','fees.idSection as idSection')
                                ->join('fee_has_level','fee_has_level.fee_id','=','fees.id')
                                ->join('levels','levels.id','=','fee_has_level.level_id')
                                ->where('fees.idSchool',$pensiontranchefee['idSchool'])
                                ->where('fees.idSection',$pensiontranchefee['idSection'])
                                ->where('fee_has_level.level_id',$pensiontranchefee['idLevel'])->get()
                    );

            $tabAll['fee'] = $fee;

            $tranche = TranchePensionFeeResource::collection(
                            Tranche::where('idSchool',$pensiontranchefee['idSchool'])
                                    ->where('idSection',$pensiontranchefee['idSection'])
                                    ->where('idPension',$pension[0]['id'])->get()
                        );

            $tabAll['tranche'] = $tranche;


            return $this->sendResponse($tabAll, 'Success');
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
