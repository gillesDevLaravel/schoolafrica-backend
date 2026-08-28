<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\Admin\PackageRequest;
use App\Http\Requests\Package\PackageArchiveRequest;
use App\Http\Resources\Admin\PackageResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group Package
 */
class PackageController extends BaseController
{
    /**
     * Lister les packages
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return PackageResource::collection(
                Package::orderBy("id", "desc")->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Ajouter un package
     *
     * @param PackageRequest $request
     * @return PackageResource|\Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        try {
            $package = $request->validated();

            $package = new Package();

            $package->name = $request['name'];
            $package->level = $request['level'];
            $package->price = $request['price'];
            $package->duration = $request['duration'];
            $package->description = $request['description'];
            $package->website = $request['website'] ?? false;
            $package->mail_pro = $request['mail_pro'] ?? false;
            $package->status = $request['status'] ?? false;
            $package->created_by = $request['created_by'] ?? auth()->user()->id;
            $package->save();

            return new PackageResource($package);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les détails d'un package
     *
     * @param Package $package
     * @param $id
     * @return PackageResource|\Illuminate\Http\Response
     */
    public function show(Package $package,$id)
    {
        try {
            $package = Package::find($id);
            return new PackageResource($package);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * maj des infos d'un package
     *
     * @param PackageRequest $request
     * @param Package $package
     * @param $id
     * @return PackageResource|\Illuminate\Http\Response
     */
    public function update(PackageRequest $request, Package $package,$id)
    {
        try {
            $package = Package::find($id);
            $package->name = $request['name'];
            $package->level = $request['level'];
            $package->price = $request['price'];
            $package->duration = $request['duration'];
            $package->description = $request['description'];
            $package->website = $request['website'] ?? false;
            $package->mail_pro = $request['mail_pro'] ?? false;
            $package->status = $request['status'] ?? false;
            $package->updated_by = $request['updated_by'] ?? auth()->user()->id;
            $package->save();

            return new PackageResource($package);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un package
     *
     * @param Package $package
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Package $package,$id)
    {
        try {
            $package = Package::find($id);
            $package->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Archiver plusieurs packages
     *
     * @param PackageArchiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function trashBulk(PackageArchiveRequest $request)
    {
        try {
            $ids = $request->validated()['ids'];
            Package::whereIn('id', $ids)->delete();
            
            return $this->sendResponse([], __('packages.trash_bulk_success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer plusieurs packages
     *
     * @param PackageArchiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function restoreBulk(PackageArchiveRequest $request)
    {
        try {
            $ids = $request->validated()['ids'];
            Package::withTrashed()->whereIn('id', $ids)->restore();
            
            return $this->sendResponse([], __('packages.restore_bulk_success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer définitivement plusieurs packages
     *
     * @param PackageArchiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(PackageArchiveRequest $request)
    {
        try {
            $ids = $request->validated()['ids'];
            Package::withTrashed()->whereIn('id', $ids)->forceDelete();
            
            return $this->sendResponse([], __('packages.destroy_bulk_success'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
