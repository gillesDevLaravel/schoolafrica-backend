<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Http\Controllers\BaseController as BaseController;

/**
 * @group Role
 */
class RoleController extends BaseController
{
    /**
     * Lister les roles
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $type = $request['type'] ?? null;

            $roles = Role::query();

            if(!is_null($type)) $roles = $roles->where('type', $request['type']);
            if(!is_null($idSchool)) $roles = $roles->where('idSchool', $idSchool);
            if(!is_null($idSection)) $roles = $roles->where('idSection', $idSection);

            return RoleResource::collection(
                $roles
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Ajouter un role
     *
     * @param RoleRequest $request
     * @return RoleResource|\Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = $request->validated();

            $role = new Role();
            $role->name = $request['name'];
            $role->guard_name = 'web';
            $role->description = $request['description'] ?? null;
            $role->type = $request['type'] ?? null;
            $role->idSchool = $request['idSchool'] ?? null;
            $role->idSection = $request['idSection'] ?? null;

            $permissions = $request['permissions'];

            $role->save();
            $role->syncPermissions($permissions);

            return new RoleResource($role);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un role
     *
     * @param $id
     * @return RoleResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            return new RoleResource($role);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un role
     *
     * @param RoleUpdateRequest $request
     * @param $id
     * @return RoleResource|\Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            $role = $request->validated();

            $role = Role::findOrFail($id);
            $role->name = $request['name'] ?? $role->name;
//            $role->guard_name = 'web';
            $role->description = $request['description'] ?? $role->description;
            $role->type = $request['type'];
            $role->idSchool = $request['idSchool'] ?? $role->idSchool;
            $role->idSection = $request['idSection'] ?? $role->idSection;
            $permissions = $request['permissions'];
            $role->save();
            $role->syncPermissions($permissions);

            return new RoleResource($role);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un rôle
     *
     * @param Role $role
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Role $role,$id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function getPermissions()
    {
        return $this->belongsTo(Permission::class);
    }
}
