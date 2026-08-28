<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrCodeRequest;
use App\Models\Key;
use App\Models\PresenceTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * @group QR Code
 */
class QRCodeController extends BaseController
{
    /**
     * Générer un hash pour le QR Code
     *
     * @param QrCodeRequest $request
     * @bodyParam idClasse int ID de la classe pour laquelle on génère le hash du QR Code
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function generateQRCode(QrCodeRequest $request)
    {
        $idSchool = $request->input('idSchool');

        $cle = Key::where('route', $request['route'])->first();

        if(is_null($cle)){
            return $this->sendError("Clé invalide"); // ...
        }

        $cle->update([
            'qr_key' => Str::uuid()
        ]);

        // Crypter l'ID de l'école avec le salt
        $dataWithSalt = "$idSchool-----" . $cle->qr_key;

        if(!is_null($request->idClasse)){
            $dataWithSalt .= "-----".$request->idClasse;
        }

        $encryptedData = Crypt::encryptString($dataWithSalt);

        // Générer le QR code à partir des données cryptées
//        $qrCode = QrCode::format('png')->size(300)->generate($encryptedData);

        Log::critical("Nouveau QR Code généré", ['auteur' => auth()->user()->id, 'qr_key' => $cle->qr_key]);

        return $this->sendResponses($encryptedData);
    }

    /**
     * Enregistrer la présence par scan de QR Code
     *
     * @bodyParam secret string required Hash dans le QR Code
     * @bodyParam route string required
     * @bodyParam scanPerCourse boolean required Est-ce que la personne doit scanner à chaque cours ou pas ?
     * @bodyParam type string required teacher/staff
     * @bodyParam idCourse int required_if:scanPerCourse,true
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storePresenceTeacherByQRCode(Request $request)
    {
        $this->validate($request, [
            'secret' => "required",
            'route' => "required",
            'scanPerCourse' => "required|boolean",
            'type' => "required|in:teacher,staff",
            'idCourse' => 'required_if:scanPerCourse,true'
        ]);

        try {
            $cle = Key::where('route', $request['route'])->first(); // je récupère la bonne clé pour décrypter le secret

            if(is_null($cle)){
                return $this->sendError("Clé invalide");
            }

            $decryptedDataWithSalt = Crypt::decryptString($request->secret);

            $secret_parties = explode("-----", $decryptedDataWithSalt);

            $qr_idSchool = $secret_parties[0]; // idSchool qui se trouve dans le qr code
            $user_idSchool = auth()->user()->idSchool;  // idSchool qui se trouve dans le compte utilisateur

            $qr_idClasse = $secret_parties[2] ?? null; // idClasse qui se trouve dans le qr code

            if(($qr_idSchool != $user_idSchool) || ($cle->qr_key != $secret_parties[1])){
                return $this->sendError("Code QR invalide");
            }

//            if(!is_null($qr_idClasse) && $qr_idClasse != $request->idClasse){
            if($request['type'] === 'teacher' && is_null($qr_idClasse)){
                return $this->sendError("Classe invalide");
            }

            // Arrivé ici signifie qu'il est bon
            if(!$request->scanPerCourse){
                $presenceteacher = PresenceTeacher::where([
                    'date' => date("Y-m-d", time()),
                    'idTeacher' => auth()->user()->id
                ])->first();

                if(is_null($presenceteacher)){
                    $presenceteacher = PresenceTeacher::create([
                        'idTeacher' => auth()->user()->id,
                        'date' => date("Y-m-d", time()),
                        'hour' => date("H:i:s", time()),
                        'arrivalTime' => date("H:i:s", time()),
                        'idSchool' => auth()->user()->idSchool ?? $request['idSchool'],
                        'idSection' => auth()->user()->idSection ?? $request['idSection'],
                        'idClasse' => $qr_idClasse ?? null,
                        'created_by' => auth()->user()->id,
                        'savingType' => 'qr',
                        'type' => $request->type,
                        'scanPerCourse' => false
                    ]);

                    $msg_log = "#arrivée";
                }else if(is_null($presenceteacher->departureTime)){
                    $presenceteacher->update([
                        'departureTime' => date("H:i:s", time())
                    ]);
                    $presenceteacher->save();

                    $msg_log = "#départ";
                }else{
                    return $this->sendError("Impossible de scanner une autre fois pour cette journée. Pour toute erreur, veuillez vous rapprocher de votre administrateur");
//                throw new \Exception("Impossible de scanner une autre fois pour cette journée. Pour toute erreur, veuillez vous rapprocher de votre administrateur");
                }
            }
            else{
                $presenceteacher = PresenceTeacher::create([
                    'idTeacher' => auth()->user()->id,
                    'date' => date("Y-m-d", time()),
                    'hour' => date("H:i:s", time()),
                    'idSchool' => auth()->user()->idSchool ?? $request['idSchool'],
                    'idSection' => auth()->user()->idSection ?? $request['idSection'],
                    'idCourse' => $request->idCourse,
                    'idClasse' => $qr_idClasse ?? null,
                    'savingType' => 'qr',
                    'type' => $request->type,
                    'created_by' => auth()->user()->id,
                    'scanPerCourse' => true
                ]);

                $msg_log = ""; // RAS
            }

            if(isset($msg_log)){
                Log::info("Enregistrement de présence enseignant par QR Code $msg_log", ['auteur' => auth()->user()->id, 'presenceteacher' => $presenceteacher->id]);
            }

            return $this->sendResponses("Présence enregistrée avec succès!");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
