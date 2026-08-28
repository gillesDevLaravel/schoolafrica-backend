<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\Admin\InsolvableRequest;
use App\Http\Requests\Admin\SolvableRequest;
use App\Http\Requests\Admin\StudentsPensionSummaryRequest;
use App\Http\Requests\BalancePensionRequest;
use App\Http\Requests\Staffs\ArchiveOrRestorePensionUserRequest;
use App\Http\Requests\Staffs\PensionUserGetAllRequest;
use App\Http\Requests\Staffs\PensionUserRequest;
use App\Models\PensionUser;
use App\Services\PDFService;
use App\Services\PensionUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Pension User
 */
class PensionUserController extends BaseController
{
    protected $pensionUserService, $pdfService;

    public function __construct(PensionUserService $pensionUserService,PDFService $pdfService)
    {
        $this->pensionUserService = $pensionUserService;
        $this->pdfService = $pdfService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PensionUserGetAllRequest $request
     * @return array|\Illuminate\Http\Response
     */
    public function index(PensionUserGetAllRequest $request)
    {
        try {
            return $this->pensionUserService->getPensionUsers($request->validated());
        }catch (ServiceException $se) {
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }catch (\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    public function indexArchives(PensionUserGetAllRequest $request)
    {
        try {
            return $this->pensionUserService->getPensionUsers($request->validated(), true);

        }catch(ServiceException $se) {
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }catch(\Throwable $th) {
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PensionUserRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function store(PensionUserRequest $request)
    {
        /**
         *Bd : Juniors
         *{"paymentDate": "", "receiptNumber": "", "operator": "", "payment_mode": "Cash", "advancePayment": 160000, "idStudent": 910}
         */
        try {
            $reference = PensionUser::lockForUpdate()->latest()->first()["reference"]?? null; //Recuperation du dernier numero de reference enregistré
            $reference = (int) $reference + 1; //Incrémentation pour obtenir le numéro de reference suivant
            $reference = str_pad($reference, 7, '0', STR_PAD_LEFT); //

            $requestData = $request->validated();
            $requestData["reference"] = $reference;

            $result = $this->pensionUserService->storePensionUser($requestData);

            DB::commit();//On applique et on libere la table

            return $result;
        } catch (ServiceException $se) {
            DB::rollBack(); //On annule et on libere la table
            $msg = $se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        } catch (\Throwable $th) {
            DB::rollBack(); //ON annule et on libere la table
            $msg = $th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine();
            Log::critical($msg);
            return $this->sendError(__('app.error_occured'), [], 404, $msg);
        }

    }

    public function storepdf(PensionUserRequest $request)
    {
        try {
            $requestData = $request->validated();
            $responseData = $this->pensionUserService->storePensionUser($requestData);
            if (is_string($responseData)){
                $data = json_decode($responseData, true);
                return $data;
            }

            $filePath = $this->pdfService->generatePDFFromArrayOfObjects($responseData, 'recus.pension.receipt2');
            return response()->download($filePath, 'receipt.pdf')->deleteFileAfterSend(true);


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

    public function balancePension(BalancePensionRequest $request)
    {
        try {
            $requestData = $request->all();

            return $this->pensionUserService->balancePensionUser($requestData);
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

    public function balancePensionWithBourse(BalancePensionRequest $request)
    {
        try {
            $requestData = $request->all();

            return $this->pensionUserService->balancePensionWithBourse($requestData);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $pensionUser = $this->pensionUserService->showPensionUser($id);
            return $pensionUser;
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
     * @return \Illuminate\Http\Response
     */
    public function getpdf($id)
    {
        try {
            $pensionUser = $this->pensionUserService->showPensionUser($id);
            $filePath = $this->pdfService->generatePDF($pensionUser, 'recus.pension.receipt');
            return response()->download($filePath, 'receipt.pdf')->deleteFileAfterSend(true);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
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
    public function update(PensionUserRequest $request, $id)
    {


    }

    /**
     * Lister les insolvables de la pension/tranche
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function insolvable(InsolvableRequest $request)
    {
        try {
            $requestData = $request->validated();

            return $this->pensionUserService->insolvablePensionUser($requestData);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Lister les solvables de la pension/tranche
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function solvables(SolvableRequest $request)
    {
        try {
            $requestData = $request->validated();

            return $this->pensionUserService->solvablePensionUser($requestData);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
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
    public function destroy($id)
    {
        try {
            $this->pensionUserService->destroyPensionUser($id);
            return response(null, 200);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Archive/Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiveOrRestore(ArchiveOrRestorePensionUserRequest $request)
    {
        try {
            $this->pensionUserService->archiveOrRestore($request->validated());

            return $this->sendResponse("Opération effectuée avec succès", []);
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'), null, 404);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function getsumtransaction(Request $request)
    {
        try {
            $requestData = $request->all();
            $sumTransaction = $this->pensionUserService->getSumTransactionPensionUser($requestData);
            return $sumTransaction;
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    public function getpensiontransaction(Request $request)
    {
        try {
            $requestData = $request->all();
            $pensionTransactions = $this->pensionUserService->getPensionTransaction($requestData);
            return $pensionTransactions;
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Get student pension summary with bourse info
     *
     * @param StudentsPensionSummaryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStudentPensionSummary(StudentsPensionSummaryRequest $request)
    {
        try {
            $data = $this->pensionUserService->getStudentsPensionSummary($request->validated());
            return $this->sendResponse($data, 'Information');
        } catch (ServiceException $se) {
            Log::critical($se->getMessage() . " in file " . $se->getFile() . " on line " . $se->getLine());
            return $this->sendError(__('app.error_occured'));
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
