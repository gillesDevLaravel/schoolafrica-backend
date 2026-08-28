<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\FeeUserSolvableRequest;
use App\Http\Requests\Staffs\ArchiveOrRestoreFeeUserRequest;
use App\Http\Resources\Staffs\FeeUserSolvableResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Staffs\FeeUserRequest;
use App\Http\Requests\Staffs\FeeUserRequestGetAll;
use App\Http\Resources\Staffs\FeeUserResource;
use App\Models\Fee;
use App\Models\FeeUser;
use App\Services\FeeUserService;
use App\Services\PDFService;
use App\Exceptions\ServiceException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Fee User
 */
class FeeUserController extends BaseController
{
    protected $feeUserService, $pdfService;

    public function __construct(FeeUserService $feeUserService,PDFService $pdfService)
    {
        $this->feeUserService = $feeUserService;
        $this->pdfService = $pdfService;
    }

    /**
     * Listing des frais utilisateurs
     *
     * @param FeeUserRequestGetAll $request
     * @return JsonResponse|array
     */
    public function index(FeeUserRequestGetAll $request)
    {
        try {
            return $this->feeUserService->getAllFeeUsers($request->validated());
        } catch (ServiceException $se) {
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }  catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    /**
     * Listing des frais utilisateurs
     *
     * @param FeeUserRequestGetAll $request
     * @return array|Response
     */
    public function indexArchives(FeeUserRequestGetAll $request)
    {
        try {
            return $this->feeUserService->getAllFeeUsers($request->validated(), true);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        }  catch (\Throwable $th) {
            return $this->sendError($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeeUserRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function store(FeeUserRequest $request)
    {
        /**
         * Bd : Juniors
         * {"paymentDate": "","receiptNumber": "","operator": "","payment_mode": "Cash","advancePayment": 12,"idStudent": 910,"idFee": 6,"idPension": null,"idLevel": 3,"idSection": 2,"idSchool": 2, "telephone": null }
         */
        try {
            $reference = FeeUser::lockForUpdate()->latest()->first()["reference"]?? null; //Recuperation du dernier numero de reference enregistré
            $reference = (int) $reference + 1; //Incrémentation pour obtenir le numéro de reference suivant
            $reference = str_pad($reference, 7, '0', STR_PAD_LEFT); //

            $requestData = $request->validated();
            $requestData["reference"] = $reference;

            $result = $this->feeUserService->storeFeeUser($requestData);

            DB::commit(); //On applique les migrations pour liberer la table

            return $result;
        } catch (ServiceException $se) {
            DB::rollBack(); //On annuele les migrations por liberer la table
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        } catch (\Throwable $th) {
            DB::rollBack(); //On annuele les migrations por liberer la table
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    public function storepdf(FeeUserRequest $request)
    {
        try {
            $requestData = $request->validated();
            $responseData = $this->feeUserService->storeFeeUser($requestData);
            if (is_string($responseData)){
                $data = json_decode($responseData, true);
                return $data;
            }
            $filePath = $this->pdfService->generateFee2PDF($responseData, 'recus.fee.receipt');
            return response()->download($filePath, 'receipt.pdf')->deleteFileAfterSend(true);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    public function balancefee(Request $request)
    {
        try {
            $requestData = $request->all();
            $responseData = $this->feeUserService->calculateBalanceFeeUser($requestData);
            return $responseData;
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $responseData = $this->feeUserService->showFeeUser($id);
            return $responseData;
        } catch (ServiceException $se) {
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        } catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    /**
     * Get Pdf the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getpdf($id)
    {
        try {
            $responseData = $this->feeUserService->showFeeUser($id);
            $filePath = $this->pdfService->generateFeePDF($responseData, 'recus.fee.receipt');
            return response()->download($filePath, 'receipt.pdf')->deleteFileAfterSend(true);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->feeUserService->deleteFeeUser($id);
            return response(null, 200);
        } catch (ServiceException $se) {
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        } catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    /**
     * Restore the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function archiveOrRestore(ArchiveOrRestoreFeeUserRequest $request)
    {
        try {
            $this->feeUserService->archiveOrRestore($request->validated());

            return $this->sendResponse("Opération effectuée avec succès", []);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }

    /**
     * Lister les solvables/insolvables d'un frais annexe
     *
     * @param FeeUserSolvableRequest $request
     * @param $type
     * @return array|Response
     */
    public function solvablesOuInsolvables(FeeUserSolvableRequest $request, $type)
    {
        /**
         * PAYLOAD VALIDE
         * BD: u989816557_juniors
         * { "username":"fondateur", "password":"000000", "idSchool":2, "idClasse":6, "idFee":1 }
         */
        try {
            $requestData = $request->validated();
            $requestData['type'] = $type;

            return $this->feeUserService->solvablesOuInsolvables($requestData);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'));
        }
    }
}
