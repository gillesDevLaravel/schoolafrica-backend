<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Http\Resources\Admin\PermissionResource;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Controllers\BaseController as BaseController;

/**
 * @group Permissions
 */
class PermissionController extends BaseController
{
    /**
     * Récupérer la liste de permissions
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return PermissionResource::collection(
                Permission::orderBy("id", "desc")->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Créer une permission
     *
     * @param PermissionRequest $request
     * @return PermissionResource|\Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            $createdPermissions = [];

            foreach ($request->permissions as $permData) {
                $permission = Permission::create([
                    'name' => $permData['name'],
                    'guard_name' => 'web',
                    'description' => $permData['description'],
                    'ressource' => $permData['ressource'],
                    'created_by' => auth()->id(),
                ]);

                $createdPermissions[] = $permission;
            }

            return PermissionResource::collection($createdPermissions);

        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les infos d'une permission
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $permission = Permission::find($id);
            return new PermissionResource($permission);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une permission
     *
     * @urlParam id int required
     * @param PermissionRequest $request
     * @return PermissionResource|\Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        try {
            $permission = Permission::find($id);
            $permission->name = $request['name'];
            $permission->guard_name = 'web';
            $permission->description = $request['description'] ?? null;
            $permission->ressource = $request['ressource'];
            $permission->updated_by = auth()->user()->id;
            $permission->save();

            return new PermissionResource($permission);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer une permission (si elle n'est pas attribuée à un role)
     *
     * @urlParam id int required
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);

            if($permission->roles()->count() != 0){
                return $this->sendError("Impossible de supprimer une permission qui a étét attribuée à un role");
            }
            $permission->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
