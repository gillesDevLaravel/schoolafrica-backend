<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Admin\KeyRequest;
use App\Http\Requests\Staffs\LicenceRequest;
use App\Http\Resources\Admin\KeyResource;
use Illuminate\Support\Facades\Log;

/**
 * @group Key
 */
class KeyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $key = Key::select('id','establishment','cle','route','logo')
                        ->get();

            return KeyResource::collection($key);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getroute(LicenceRequest $request)
    {
        try {
            $key = $request->validated();
            $key = Key::select('route','logo')
                        ->where('cle', '=', $request['cle'])
                        ->first();
            switch ($key) {
                case null:
                    return $this->sendError('Vérifiez votre clé');
                    break;

                default:
                    return $this->sendResponse($key, 'route retrieved successfully.');
                    break;
            }

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeyRequest $request)
    {
        try {
            $key = $request->validated();
            $key = new Key();
            $key->establishment = $request['establishment'];
            $key->cle = substr($request['establishment'], -3)."-".rand(1000,9999)."-2023";
            $key->route = $request['route'];
            $key->logo = $request['logo'] ?? null;
            $key->created_by = auth()->user()->id;
            $key->save();
            return new KeyResource($key);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Key $key,$id)
    {
        try {
            $key = key::find($id);
            return new KeyResource($key);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $key = key::find($id);
            $key->establishment = $request['establishment'] ?? $key['establishment'];
            $key->route = $request['route'] ?? $key['route'];
            if(!empty($request['cle'])){
                $key->cle = substr($request['establishment'], -3)."-".rand(1000,9999)."-2023";
            }else{
                $key->cle = $key['cle'];
            }
            $key->logo = $request['logo'] ?? $key['logo'];
            $key->updated_by = auth()->user()->id;
            $key->save();

            return new KeyResource($key);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Key $key,$id)
    {
        try {
            $key = Key::find($id);
            $key->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
