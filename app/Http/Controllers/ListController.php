<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListFeeAndPensionUserPeriodRequest;
use App\Services\FeeUserService;
use App\Services\PensionUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Contrôleur de gestion des états financiers (frais & pensions).
 *
 * Ce contrôleur permet de récupérer un résumé financier regroupant :
 * - La liste paginée des utilisateurs liés aux pensions
 * - La liste paginée des utilisateurs liés aux frais
 * - Le calcul des totaux (sommes, OM, MoMo, cash, banques)
 *
 * @group Listes personnalisees
 */
class ListController extends BaseController
{
    protected $feeUserService;
    protected $pensionUserService;

    public function __construct(FeeUserService $feeUserService, PensionUserService $pensionUserService)
    {
        $this->feeUserService = $feeUserService;
        $this->pensionUserService = $pensionUserService;
    }

    /**
     * Récupère le résumé financier (pensions + frais) avec pagination.
     *
     * La pagination est configurable via :
     * - `pageItems` : page actuelle
     * - `nbreItems` : nombre d'éléments par page
     *
     * @param ListFeeAndPensionUserPeriodRequest $request
     * @return JsonResponse
     */
    public function getFinancialSummary(ListFeeAndPensionUserPeriodRequest $request)
    {
        try {
            // Préparer les données pour PensionUsers
            $pensionRequestData = [
                'idSchool' => $request->idSchool,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
            ];

            // Préparer les données pour FeeUsers
            $feeRequestData = [
                'idSchool' => $request->idSchool,
                'date_start' => $request->date_start,
                'date_end' => $request->date_end,
            ];

            // Récupérer les données via vos méthodes existantes
            $pensionData = $this->pensionUserService->getPensionUsers($pensionRequestData);
            $feeData = $this->feeUserService->getAllFeeUsers($feeRequestData);

            // Calculer les totaux combinés
            $combinedTotals = $this->calculateCombinedTotalsFromExisting($pensionData, $feeData);

            $banksArray = [];
            foreach ($combinedTotals['banks'] ?? [] as $name => $amount) {
                $banksArray[] = ['name' => $name, 'amount' => $amount];
            }


            return response()->json([
                'success' => true,
                'data' => [
                    'pensionUsers' => $pensionData['data'],
                    'feeUsers' => $feeData['data'],
                    'sommes' => $combinedTotals['sommes'],
                    'om' => $combinedTotals['om'],
                    'momo' => $combinedTotals['momo'],
                    'cash' => $combinedTotals['cash'],
                    'bank' => $combinedTotals['bank'],
                    'banks' => $banksArray,
                ],
                'period' => [
                    'start_date' => $request->date_start,
                    'end_date' => $request->date_end
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des données financières',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Calcul des totaux combinés entre pensions et frais.
     *
     * @param array $pensionData
     * @param array $feeData
     * @return array
     */
    private function calculateCombinedTotalsFromExisting(array $pensionData, array $feeData): array
    {
        // Convertir les sommes formatées en nombres
        $pensionTotal = floatval(str_replace([' ', ','], '', $pensionData['sommes']));
        $pensionOM = floatval(str_replace([' ', ','], '', $pensionData['om']));
        $pensionMomo = floatval(str_replace([' ', ','], '', $pensionData['momo']));
        $pensionCash = floatval(str_replace([' ', ','], '', $pensionData['cash']));
        $pensionBank = floatval(str_replace([' ', ','], '', $pensionData['bank']));

        $feeTotal = floatval(str_replace([' ', ','], '', $feeData['sommes']));
        $feeOM = floatval(str_replace([' ', ','], '', $feeData['om']));
        $feeMomo = floatval(str_replace([' ', ','], '', $feeData['momo']));
        $feeCash = floatval(str_replace([' ', ','], '', $feeData['cash']));
        $feeBank = floatval(str_replace([' ', ','], '', $feeData['bank']));


        $pensions = collect($pensionData['data'])->toArray();
        $fees = collect($feeData['data'])->toArray();

        $combined = array_merge($pensions, $fees); // maintenant c'est un tableau indexé


        $banks = [];
        foreach ($combined as $pensionOrFee) {
            if ($pensionOrFee['payment_mode'] === 'Bank') {
                $operator = $pensionOrFee['operator'];
                $advance = $pensionOrFee['advancePayment'];
                if (!isset($banks[$operator])) {
                    $banks[$operator] = $advance;
                } else {
                    $banks[$operator] += $advance;
                }
            }
        }

        // Calculer les totaux combinés
        $combinedTotal = $pensionTotal + $feeTotal;
        $combinedOM = $pensionOM + $feeOM;
        $combinedMomo = $pensionMomo + $feeMomo;
        $combinedCash = $pensionCash + $feeCash;
        $combinedBank = $pensionBank + $feeBank;

        return [
            'sommes' => number_format($combinedTotal),
            'om' => number_format($combinedOM),
            'momo' => number_format($combinedMomo),
            'cash' => number_format($combinedCash),
            'bank' => number_format($combinedBank),
            'banks' => $banks,
        ];
    }
}
