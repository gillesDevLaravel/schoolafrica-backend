<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolFolder;
use App\Http\Resources\Staffs\SchoolFolderResource;
use App\Http\Requests\Staffs\SchoolFolderRequest;
use App\Http\Requests\Staffs\SchoolFolderGetAllRequest;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Log;

/**
 * @group School Folder
 */
class SchoolFolderController extends BaseController
{
    /**
     * List des dossiers scolaires
     *
     * @param SchoolFolderGetAllRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(SchoolFolderGetAllRequest $request)
    {
        try {
            $schoolFolder = $request->validated();
            $idSection = $request['idSection'] ?? null;
            $idStudent = $request['idStudent'] ?? null;

            $folders = SchoolFolder::where('idSchool',$schoolFolder['idSchool']);

            if(!is_null($idSection)) $folders = $folders->where('idSection', $idSection);
            if(!is_null($idStudent)) $folders = $folders->where('idStudent', $idStudent);

            return SchoolFolderResource::collection(
                $folders
                    ->orderBy("id", "desc")
                    ->get()
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }


    }

    /**
     * Ajouter un dossier scolaire
     *
     * @param SchoolFolderRequest $request
     * @return SchoolFolderResource|\Illuminate\Http\Response
     */
    public function store(SchoolFolderRequest $request)
    {
        try {
            $schoolFolder = $request->validated();

            $schoolFolder = SchoolFolder::create([
                'idStudent' => $request['idStudent'],
                'medicalCertificate' => $request['medicalCertificate'],
                'lastBulletin' => $request['lastBulletin'],
                'lastDiploma' => $request['lastDiploma'],
                'birthCertificate' => $request['birthCertificate'],
                'idSchool' => $request['idSchool'],
                'idSection' => $request['idSection'],
                'created_by' => auth()->user()->id
            ]);

            return new SchoolFolderResource($schoolFolder);
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
    public function show(SchoolFolder $schoolFolder,$id)
    {
        try {
            $schoolFolder = SchoolFolder::find($id);
            return new SchoolFolderResource($schoolFolder);
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
    public function update(SchoolFolderRequest $request,SchoolFolder $schoolFolder, $id)
    {
        try {
            $schoolFolder = SchoolFolder::find($id);
            $schoolFolder->idStudent = $request['idStudent'];
            $schoolFolder->medicalCertificate = $request['medicalCertificate'];
            $schoolFolder->lastBulletin = $request['lastBulletin'];
            $schoolFolder->lastDiploma = $request['lastDiploma'];
            $schoolFolder->birthCertificate = $request['birthCertificate'];
            $schoolFolder->idSchool = $request['idSchool'];
            $schoolFolder->idSection = $request['idSection'];
            $schoolFolder->updated_by = auth()->user()->id;

            $schoolFolder->save();
            return new SchoolFolderResource($schoolFolder);
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
    public function destroy(SchoolFolder $schoolFolder,$id)
    {
        try {
            $schoolFolder = SchoolFolder::find($id);
            $schoolFolder->delete();

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }
}
