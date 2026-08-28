<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Staffs\SchoolSupplyResource;
use App\Http\Requests\Staffs\SchoolSupplyRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\SchoolSupply;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * @group School Supplier
 */
class SchoolSupplyController extends BaseController
{
    /**
     * Afficher la liste des fournitures scolaires
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pageItems = $request->get('pageItems', 1);
            $nbreItems = $request->get('nbreItems', 1000000);

            $query = SchoolSupply::query()
                ->where('idSchool', $request['idSchool']);

            if ($request->filled('idSection')) {
                $query->where('idSection', $request->idSection);
            }

            if ($request->filled('idLevel')) {
                $query->where('idLevel', $request->idLevel);
            }

            if ($request->filled('idOptionLevel')) {
                $query->where('idOptionLevel', $request->idOptionLevel);
            }

            return SchoolSupplyResource::collection(
                $query->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SchoolSupplyRequest $request
     * @return JsonResponse|SchoolSupplyResource
     */
    public function store(SchoolSupplyRequest $request)
    {
        try {
            $schoolSupply = $request->validated();

            $schoolSupply = SchoolSupply::create([
                'image' => $schoolSupply['image'] ?? null,
                'description' => $schoolSupply['description'] ?? null,
                'supply' => $schoolSupply['supply'],
                'idLevel' => $schoolSupply['idLevel'],
                'idOptionLevel' => $request['idOptionLevel'] ?? null,
                'idSchool' => $request['idSchool'],
                'idSection' => $request['idSection'],
                'created_by' => auth()->user()->id
            ]);

            $idsClasses = $request['idsClasses'] ?? [];

            if (!empty($idsClasses)){
                $schoolSupply->classes()->attach($idsClasses);
            }

            return new SchoolSupplyResource($schoolSupply);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolSupply $schoolSupply,$id)
    {
        try {
            $schoolSupply = SchoolSupply::find($id);
            return new SchoolSupplyResource($schoolSupply);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolSupplyRequest $request,SchoolSupply $schoolSupply, $id)
    {
        try {
            $schoolSupply = SchoolSupply::find($id);
            $schoolSupply->image = $request['image'] ?? $schoolSupply->image;
            $schoolSupply->description = $request['description'] ?? $schoolSupply->description;
            $schoolSupply->supply = $request['supply'];
            $schoolSupply->idLevel = $request['idLevel'];
            $schoolSupply->idOptionLevel = $request['idOptionLevel'] ?? $schoolSupply['idOptionLevel'];
            $schoolSupply->idSchool = $request['idSchool'];
            $schoolSupply->idSection = $request['idSection'];
            $schoolSupply->updated_by = auth()->user()->id;



            $idsClasses = $request['idsClasses'] ?? [];

            if (!empty($idsClasses)){
                $schoolSupply->classes()->sync($idsClasses);
            }

            $schoolSupply->save();
            return new SchoolSupplyResource($schoolSupply);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolSupply $schoolSupply,$id)
    {
        try {
            $schoolSupply = SchoolSupply::find($id);
            $schoolSupply->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 404, $th->getMessage());
        }

    }
}
