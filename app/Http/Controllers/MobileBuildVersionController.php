<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\MobileBuildVersionStoreRequest;
use App\Models\MobileBuildVersion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Mobile Builds
 */
class MobileBuildVersionController extends BaseController
{
    protected $ack = "5367fd5d-a26c-45af-9e01-f3d256244d1d"; // access key que l'utilisateur (notifié) doit aussi m'envoyer dans le body
    public function store(MobileBuildVersionStoreRequest $request)
    {
        try {
            // On doit s'assurer que c'est bien le mobile (#Ohrel) qui m'envoie ces infos

            if(isset($request->ack) && $request->ack === $this->ack){
                MobileBuildVersion::updateOrCreate([
                    'build_number' => $request->build_number
                ],[
                    'build_number' => $request->build_number,
                    'verified' => $request->verified ?? false,
                ]);

                Log::info("Mise à jour de la valeur de build de l'app mobile. NewValue : {$request->build_number}");
            }else{
                Log::critical("Illegal access to mobile build version store. IP/PORT {$_SERVER['REMOTE_ADDR']}::{$_SERVER['REMOTE_PORT']} ");
            }

            return $this->sendResponse([], "build value updated");
        } catch (\Throwable $th){
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Mettre à jour la version de build de l'utilisateur
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserBuildVersion(Request $request)
    {
        try {
            // On récupère (TOUJOURS) la dernière version du build
            $build = MobileBuildVersion::orderBy('id', 'desc')->first();

            // Je récupère l'utilisateur authentifié
            $user = User::find(auth()->user()->id);

            //m.a.j de son build_number
            $user->build_number = $build->build_number;
            $user->save();

            return $this->sendResponse([], "User's build value updated");
        } catch (\Throwable $th){
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
