<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\FeeResource;
use App\Http\Requests\Staffs\FeeRequest;
use App\Http\Requests\Staffs\FeeGetAllRequest;
use App\Models\Fee;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\FeeUser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group Fee
 */
class FeeController extends BaseController
{
    /**
     * Listing des frais
     *
     * @param FeeGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|Response
     */
    public function index(FeeGetAllRequest $request)
    {
        try {
            $fee = $request->validated();
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $idLevel = $request['idLevel'] ?? null;
            $idClasse = $request['idClasse'] ?? null;
            $required = $request['required'] ?? null;
            $idOptionLevel = $request['idOptionLevel'] ?? null;

            $fees = Fee::query();

            if(!is_null($idSchool)) {
                $fees = $fees->where('fees.idSchool', $idSchool);
            }

            if(!is_null($idSection)) {
                $fees = $fees->where('fees.idSection', $idSection);
            }


            if(!is_null($required)) $fees = $fees->where('fees.required',$required);

            if(!is_null($idLevel)){
                switch ($idOptionLevel) {
                    case null:
                        $fees = $fees->select('fees.id as id','fees.name as name','fees.price as price','fees.deadline as deadline','fees.idOptionLevel as idOptionLevel','fees.idSchool as idSchool','fees.idSection as idSection')
                            ->join('fee_has_level','fee_has_level.fee_id','=','fees.id')
                            ->join('levels','levels.id','=','fee_has_level.level_id')
                            ->where('fee_has_level.level_id',$request['idLevel']);
                        break;

                    default:
                        $fees = $fees->select('fees.id as id','fees.name as name','fees.price as price','fees.deadline as deadline','fees.idOptionLevel as idOptionLevel','fees.idSchool as idSchool','fees.idSection as idSection')
                            ->join('fee_has_level','fee_has_level.fee_id','=','fees.id')
                            ->join('levels','levels.id','=','fee_has_level.level_id')
                            ->where('fee_has_level.level_id',$request['idLevel'])
//                            ->where('fees.idClasse',$request['idClasse']) // idClasse n'existe pas sur la table fees
                            ->where('fees.idOptionLevel',$request['idOptionLevel']);
                        break;
                }
            }

            return FeeResource::collection(
                $fees
                    ->orderBy("fees.id", "desc")
                    ->get()
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeeRequest $request
     * @return FeeResource|JsonResponse
     */
    public function store(FeeRequest $request)
    {
        try {
            $fee = $request->validated();

            $fee = Fee::create([
                'name' => $fee['name'],
                'description' => $fee['description'] ?? null,
                'price' => $fee['price'],
                'deadline' => $request['deadline'],
                'order' => $request['order'] ?? null,
                'required' => $request['required'] ?? false,
                'idOptionLevel' => $request['idOptionLevel'] ?? null,
                'type_of_recipe_id' => $request['idTypeOfRecipe'] ?? null,
                'idSchool' => $fee['idSchool'],
                'idSection' => $fee['idSection'] ?? null,
                'created_by' => auth()->user()->id
            ]);

            if(!empty($request['levels'])){
                $fee->levels()->sync($request['levels']);
            }

            return new FeeResource($fee);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Fee $fee,$id)
    {
        try {
            $fee = Fee::find($id);
            return new FeeResource($fee);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     * "name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(FeeRequest $request,Fee $fee, $id)
    {
        //Rendre impossible la modification si le prix change
        try {
            $fee = Fee::findOrFail($id);

            //verifier si des paiements ont déjà été effectuées
            $nbrPaiements = FeeUser::where("idFee", $id)->count();
            if ($nbrPaiements > 0){

                //verifier si le prix a changé
                if($request["price"] != $fee->price){
                    return $this->sendError("impossible de modifier car le prix a changé et {$nbrPaiements} personne(s) on déjà payé)");
                }
            }



            $fee->name = $request['name'];
            $fee->description = $request['description'] ?? $fee->description;
            $fee->price = $request['price'];
            $fee->deadline = $request['deadline'];
            $fee->order = $request['order'] ?? $fee->order;
            $fee->required = $request['required'] ?? $fee->required;
            $fee->idOptionLevel = $request['idOptionLevel'] ?? null;
            $fee->idSchool = $request['idSchool'];
            $fee->idSection =  $request['idSection'];
            $fee->type_of_recipe_id =  $request['idTypeOfRecipe'] ?? $fee->type_of_recipe_id;
            $fee->updated_by = auth()->user()->id;

            $fee->save();

            if(!empty($request['levels'])){
                $fee->levels()->sync($request['levels']);
            }

            return new FeeResource($fee);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *"name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Fee $fee,$id)
    {
        try {
            $fee = Fee::findOrFail($id);

            //verifier si des paiements ont déjà été effectuées
            $nbrPaiements = FeeUser::where("idFee", $id)->count();
            if ($nbrPaiements > 0){

                return $this->sendError("impossible de supprimer car {$nbrPaiements} personne(s) on déjà payé)");

            }

            $feeUser = FeeUser::where('idFee',$id)->get();

            if(count($feeUser) != 0){
                return $this->sendError('impossible, paiement fee existant');
            }else{
//                $fee->delete();
                $fee->update([
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
}
