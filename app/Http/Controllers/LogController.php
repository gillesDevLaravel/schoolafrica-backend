<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LogAllRequest;
use App\Http\Requests\Admin\LogStoreRequest;
use App\Http\Requests\Admin\ProjectAllRequest;
use App\Http\Resources\Admin\LogResource;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;

class LogController extends BaseController
{
    /**
     * Lister les logs
     *
     * @param LogAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(LogAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $date = $request->date;
            $idUser = $request->idUser;
            $idStudent = $request->idStudent;

            $logs = Log::query();

            if(!is_null($date)) $logs = $logs->whereDate('created_at', $date);
            if(!is_null($idUser)) $logs = $logs->where('idUser', $idUser);
            if(!is_null($idStudent)) $logs = $logs->where('idStudent', $idStudent);

            if(!is_null($filter_value)){
                $logs->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orwhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orwhereHas('student', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return LogResource::collection(
                $logs
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            FacadesLog::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un log
     *
     * @urlParam $id integer required
     * @return LogResource|\Illuminate\Http\Response
     */
    public function show($idTransfert)
    {
        try {
            $ransfert = Log::findOrFail($idTransfert);
            return LogResource::make($ransfert);
        }catch (\Throwable $th) {
            FacadesLog::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function store(LogStoreRequest $request)
    {
        try {
            Log::create([
                'idUser' => auth()->user()->id,
                'idStudent' => $request->idStudent,
                'description' => $request->description,
            ]);

            return $this->sendResponse([], 'Log created successfully.');
        }catch (\Throwable $th) {
            FacadesLog::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
