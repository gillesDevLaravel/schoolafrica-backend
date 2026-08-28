<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentTransportUser\PaymentTransportUserArchiveRequest;
use App\Http\Requests\PaymentTransportUser\PaymentTransportUserBalanceRequest;
use App\Http\Requests\PaymentTransportUser\PaymentTransportUserCreateRequest;
use App\Http\Requests\PaymentTransportUser\PaymentTransportUserGetRequest;
use App\Http\Requests\PaymentTransportUser\PaymentTransportUserUpdateRequest;
use App\Http\Resources\PaymentTransportUserResource;
use App\Models\Notification;
use App\Models\PaymentTransportUser;
use App\Models\TransportUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Contrôleur de gestion des paiements pour les utilisateurs de transport
 *
 * Ce contrôleur permet de gérer les opérations CRUD sur les entités PaymentTransportUser :
 * - Liste des paiements
 * - Création d'un paiement
 * - Consultation d'un paiement
 * - Mise à jour d'un paiement
 * - Suppression temporaire (mise à la corbeille)
 * - Restauration d'un paiement supprimé
 * - Suppression définitive
 *
 * @group Gestion des Paiements des Utilisateurs de Transport
 */
class PaymentTransportUserController extends BaseController
{
    /**
     *  Récupère la liste paginée des paiements.
     *
     *  Permet de filtrer par `student_id` et `transport_id`.
     *  La pagination est configurable via `pageItems` (page actuelle) et `nbreItems` (nombre d'éléments par page).
     *
     * @param PaymentTransportUserGetRequest $request
     * @return array
     */
    public function index(PaymentTransportUserGetRequest $request): array
    {
        try {
            $requestData = $request->validated();
            $archives = $requestData['archives'] ?? false;

            // Base query avec jointures nécessaires
            $query = PaymentTransportUser::with(['transportUser.student', 'transportUser.transport'])
                ->select('payment_transport_users.*');

            // Gestion des archives
            if ($archives) {
                $query->withoutGlobalScope('isDeleted')->where('deleted', 1);
            }

            // Filtres de base
            $transportUserId = $requestData['transport_user_id'] ?? null;
            $paymentMode = $requestData['payment_mode'] ?? null;
            $telephone = $requestData['telephone'] ?? null;
            $reference = $requestData['reference'] ?? null;
            $paymentDate = $requestData['payment_date'] ?? null;
            $dateStart = $requestData['date_start'] ?? null;
            $dateEnd = $requestData['date_end'] ?? null;
            $idStudent = $requestData['idStudent'] ?? null;
            $idClasse = $requestData['idClasse'] ?? null;

            // Application des filtres
            if (!is_null($transportUserId)) {
                $query->where('transport_user_id', $transportUserId);
            }
            if (!is_null($telephone)) {
                $query->where('telephone', $telephone);
            }
            if (!is_null($reference)) {
                $query->where('reference', $reference);
            }
            if (!is_null($paymentMode)) {
                $query->where('payment_mode', $paymentMode);
            }
            if (!is_null($paymentDate)) {
                $query->whereDate('payment_date', $paymentDate);
            }

            // Filtre par étudiant
            if (!is_null($idStudent)) {
                $query->whereHas('transportUser', function($q) use ($idStudent) {
                    $q->where('idStudent', $idStudent);
                });
            }

            // Filtre par classe
            if (!is_null($idClasse)) {
                $query->whereHas('transportUser.student', function($q) use ($idClasse) {
                    $q->where('idClasse', $idClasse);
                });
            }

            // Filtre par période
            if (!is_null($dateStart) && !is_null($dateEnd)) {
                $dateStart = Carbon::createFromFormat('Y-m-d', $dateStart)->format('Y-m-d 00:00:00');
                $dateEnd = Carbon::createFromFormat('Y-m-d', $dateEnd)->format('Y-m-d 23:59:59');
                $query->whereBetween('payment_date', [$dateStart, $dateEnd]);
            }

            // Filtre de recherche globale
            $filterValue = $requestData['filter_value'] ?? null;
            if (!is_null($filterValue)) {
                $query->where(function ($q) use ($filterValue) {
                    $q->where('payment_mode', 'like', "%$filterValue%")
                        ->orWhere('payment_date', 'like', "%$filterValue%")
                        ->orWhere('telephone', 'like', "%$filterValue%")
                        ->orWhere('reference', 'like', "%$filterValue%")
                        ->orWhere('receipt_number', 'like', "%$filterValue%")
                        ->orWhereHas('transportUser', function($q) use ($filterValue) {
                            $q->whereHas('student', function($q) use ($filterValue) {
                                $q->where('name', 'like', "%$filterValue%");
                            })->orWhereHas('transport', function($q) use ($filterValue) {
                                $q->where('name', 'like', "%$filterValue%");
                            });
                        });
                });
            }

            // Récupération des résultats pour calculs
            $allPayments = $query->get();

            // Calcul des totaux
            $totalAdvancePayment = $allPayments->sum('advance_payment');
            $totalAdvancePaymentOM = $allPayments->where('payment_mode', 'Orange Money')->sum('advance_payment');
            $totalAdvancePaymentMOMO = $allPayments->whereIn('payment_mode', ['Mobile Money', 'MOMO'])->sum('advance_payment');
            $totalAdvancePaymentCash = $allPayments->where('payment_mode', 'Cash')->sum('advance_payment');
            $totalAdvancePaymentBank = $allPayments->where('payment_mode', 'Bank')->sum('advance_payment');

            // Pagination et métadonnées
            $pageItems = $requestData['pageItems'] ?? 1;
            $nbreItems = $requestData['nbreItems'] ?? 1000000;

            $payments = $query->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            $meta = [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
                'to' => $payments->lastItem(),
                'total' => $payments->total(),
            ];

            // Gestion du regroupement
            $groupBy = $requestData['group_by'] ?? null;
            $dateStart = !empty($requestData['date_start'])
                ? Carbon::createFromFormat('Y-m-d', $requestData['date_start'])->startOfDay()
                : null;
            $dateEnd = !empty($requestData['date_end'])
                ? Carbon::createFromFormat('Y-m-d', $requestData['date_end'])->endOfDay()
                : null;

            $groupedData = collect();

            if (in_array($groupBy, ['day', 'week', 'month']) && $dateStart && $dateEnd) {
                // Regroupement des données existantes
                $grouped = $allPayments->groupBy(function ($item) use ($groupBy) {
                    $date = $item->payment_date ?? $item->created_at;
                    $date = $date instanceof Carbon ? $date : Carbon::parse($date);

                    if ($groupBy === 'day') {
                        return $date->toDateString();
                    } elseif ($groupBy === 'week') {
                        return $date->format('Y') . '-W' . $date->format('W');
                    } elseif ($groupBy === 'month') {
                        return $date->format('Y-m');
                    }
                    return 'unknown';
                });

                // Génération de toutes les périodes
                $allPeriods = [];
                $current = $dateStart->copy();

                while ($current->lte($dateEnd)) {
                    if ($groupBy === 'day') {
                        $key = $current->toDateString();
                        $label = $key;
                        $current->addDay();
                    } elseif ($groupBy === 'week') {
                        $key = $current->format('Y') . '-W' . $current->format('W');
                        $start = $current->copy()->startOfWeek();
                        $end = $current->copy()->endOfWeek();
                        $label = 'Du ' . $start->format('Y-m-d') . ' au ' . $end->format('Y-m-d');
                        $current->addWeek();
                    } elseif ($groupBy === 'month') {
                        $key = $current->format('Y-m');
                        $start = $current->copy()->startOfMonth();
                        $end = $current->copy()->endOfMonth();
                        $label = 'Du ' . $start->format('Y-m-d') . ' au ' . $end->format('Y-m-d');
                        $current->addMonth();
                    }

                    $allPeriods[$key] = $label;
                }

                // Fusion avec les données groupées
                foreach ($allPeriods as $periodKey => $label) {
                    $items = isset($grouped[$periodKey]) ? $grouped[$periodKey] : collect();

                    $groupedData->push([
                        'period' => $label,
                        'transportPayments' => PaymentTransportUserResource::collection($items->values()),
                        'total_advance_payment' => $items->sum('advance_payment'),
                    ]);
                }
            }

            return [
                    'data' => $groupBy
                        ? $groupedData
                        : PaymentTransportUserResource::collection($payments),
                    'meta' => $meta,
                    'sommes' => number_format($totalAdvancePayment),
                    'om' => number_format($totalAdvancePaymentOM),
                    'momo' => number_format($totalAdvancePaymentMOMO),
                    'cash' => number_format($totalAdvancePaymentCash),
                    'bank' => number_format($totalAdvancePaymentBank),
                ];
        } catch (\Throwable $th) {
            \Log::critical('Erreur lors de la récupération des paiements des utilisateurs de transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Crée un nouveau paiement pour un utilisateur de transport.
     *
     * @param PaymentTransportUserCreateRequest $request Requête validée contenant les données du paiement.
     * @return JsonResponse PaymentTransportUser créé encapsulé dans PaymentTransportUserResource
     */
    public function create(PaymentTransportUserCreateRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();
            $montant_total = number_format($requestData['advance_payment']);

            // Retrieve the latest payment record for the transport user
            $transportPayment = PaymentTransportUser::where('transport_user_id', $requestData['transport_user_id'])
                ->latest('created_at')->first();

            // Fetch the transport user and associated user
            $transportUser = TransportUser::findOrFail($requestData['transport_user_id']);
            $student = User::findOrFail($transportUser->student_id);

            // Verify if required payments are made (implement hasPaidRequiredTransport if needed)
            // if (!$this->hasPaidRequiredTransport($student->id, $transportUser->id)) {
            //     return $this->sendError(__('transport_payment.unpaid_transport'), null, 500);
            // }

            // Fetch transport details
            $transport = TransportUser::select('transport_users.id as id', 'transport_users.amount as amount')
                ->where('transport_users.id', $requestData['transport_user_id'])
                ->where('transport_users.student_id', $student->id)
                ->firstOrFail();

            // Payment validation
            if (is_null($requestData['advance_payment'])) {
                return $this->sendError(__('transport_payment.advance_payment_null'), null, 500);
            }

            if ($requestData['advance_payment'] == 0) {
                return $this->sendError(__('transport_payment.advance_payment_zero'), null, 500);
            }

            $tabPayment = [];

            if (!$transportPayment) {
                // No prior payment exists
                if ($requestData['advance_payment'] < 0) {
                    return $this->sendError(__('transport_payment.advance_payment_negative'), null, 500);
                } elseif ($requestData['advance_payment'] > $transport->amount) {
                    return $this->sendError(__('transport_payment.advance_payment_exceeds'), null, 500);
                }

                $payment = new PaymentTransportUser();
                $payment->transport_user_id = $requestData['transport_user_id'];
                $payment->receipt_number = $requestData['receipt_number'] ?? null;
                $payment->scan_receipt = $requestData['scan_receipt'] ?? null;
                $payment->payment_date = $requestData['payment_date'] ?? null;
                $payment->telephone = $requestData['telephone'] ?? null;
                $payment->reference = $requestData['reference'] ?? null;
                $payment->created_by = Auth::id();

                if ($requestData['advance_payment'] < $transport->amount) {
                    $payment->advance_payment = $requestData['advance_payment'];
                    $payment->balance_payment = $transport->amount - $requestData['advance_payment'];
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'avancé';
                } else {
                    $payment->advance_payment = $transport->amount;
                    $payment->balance_payment = 0;
                    $payment->payment_mode = $requestData['payment_mode'];
                    $payment->solvable = 'terminé';
                }

                $payment->save();
                $payment->remaining_fees = $transport->amount; // Track remaining fees

                $tabPayment['PaymentTransport'] = new PaymentTransportUserResource($payment);

                // Create notification
                Notification::create([
                    'notificationable_type' => PaymentTransportUser::class,
                    'notificationable_id' => $payment->id,
                    'title' => __('notifs.transport_payment_title', ['montant_total' => $montant_total, 'transport' => $transport->id]),
                    'description' => __('notifs.transport_payment_desc', [
                        'montant_total' => $montant_total,
                        'transport' => $transport->id,
                        'student_name' => $student->name
                    ]),
                    'grouped_users' => json_encode([$student->id, $student->idParent])
                ]);

                return $this->sendResponse(
                    PaymentTransportUserResource::collection($tabPayment),
                    __('paymentTransportUser.create.success')
                );
            }

            // Prior payment exists
            if ($transportPayment->balance_payment == 0) {
                return $this->sendError(__('transport_payment.fully_paid'), null, 500);
            }

            if ($requestData['advance_payment'] < 0) {
                return $this->sendError(__('transport_payment.advance_payment_negative'), null, 500);
            } elseif ($requestData['advance_payment'] > $transportPayment->balance_payment) {
                return $this->sendError(__('transport_payment.advance_payment_exceeds_remaining'), null, 500);
            }

            $payment = new PaymentTransportUser();
            $payment->transport_user_id = $requestData['transport_user_id'];
            $payment->receipt_number = $requestData['receipt_number'] ?? null;
            $payment->scan_receipt = $requestData['scan_receipt'] ?? null;
            $payment->payment_date = $requestData['payment_date'] ?? null;
            $payment->telephone = $requestData['telephone'] ?? null;
            $payment->reference = $requestData['reference'] ?? null;
            $payment->created_by = Auth::id();

            if ($requestData['advance_payment'] < $transportPayment->balance_payment) {
                $payment->advance_payment = $requestData['advance_payment'];
                $payment->balance_payment = $transportPayment->balance_payment - $requestData['advance_payment'];
                $payment->payment_mode = $requestData['payment_mode'];
                $payment->solvable = 'avancé';
            } else {
                $payment->advance_payment = $requestData['advance_payment'];
                $payment->balance_payment = 0;
                $payment->payment_mode = $requestData['payment_mode'];
                $payment->solvable = 'terminé';
            }

            $payment->save();
            $payment->remaining_fees = $transportPayment->balance_payment; // Track remaining fees

            $tabPayment['PaymentTransport'] = new PaymentTransportUserResource($payment);

            // Create notification
            Notification::create([
                'notificationable_type' => PaymentTransportUser::class,
                'notificationable_id' => $payment->id,
                'title' => __('notifs.transport_payment_title', ['montant_total' => $montant_total, 'transport' => $transport->id]),
                'description' => __('notifs.transport_payment_desc', [
                    'montant_total' => $montant_total,
                    'transport' => $transport->id,
                    'student_name' => $student->name
                ]),
                'grouped_users' => json_encode([$student->id, $student->idParent])
            ]);

            return $this->sendResponse(
                PaymentTransportUserResource::collection($tabPayment),
                __('paymentTransportUser.create.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la création du paiement transport : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Affiche les détails d'un paiement spécifique.
     *
     * @param PaymentTransportUser $paymentTransportUser Paiement à afficher
     * @return PaymentTransportUserResource Détails du paiement
     */
    public function show(PaymentTransportUser $paymentTransportUser): PaymentTransportUserResource
    {
        return new PaymentTransportUserResource($paymentTransportUser);
    }

    /**
     * Met à jour un paiement existant.
     *
     * @param PaymentTransportUserUpdateRequest $request Requête validée contenant les nouvelles données
     * @param PaymentTransportUser $paymentTransportUser Paiement à mettre à jour
     * @return JsonResponse Paiement mis à jour encapsulé dans PaymentTransportUserResource
     */
    public function update(PaymentTransportUserUpdateRequest $request, PaymentTransportUser $paymentTransportUser): JsonResponse
    {
        try {
            $paymentTransportUser->update($request->validated() + ['updated_by' => auth()->id()]);

            Log::info('Paiement utilisateur de transport mis à jour avec succès', [
                'author' => auth()->id(),
                'payment' => $paymentTransportUser
            ]);

            return $this->sendResponse(
                new PaymentTransportUserResource($paymentTransportUser),
                __('paymentTransportUser.update.success')
            );
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à jour du paiement : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime temporairement un ou plusieurs paiements (mise à la corbeille).
     *
     * @param PaymentTransportUserArchiveRequest $request Requête validée contenant les IDs
     * @return JsonResponse Réponse avec succès ou erreur
     */
    public function trash(PaymentTransportUserArchiveRequest $request): JsonResponse
    {
        try {
            PaymentTransportUser::whereIn('id', $request->ids)->delete();
            return $this->sendResponse([], __('paymentTransportUser.trash.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la mise à la corbeille des paiements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure un ou plusieurs paiements supprimés.
     *
     * @param PaymentTransportUserArchiveRequest $request Requête validée contenant les IDs
     * @return JsonResponse Réponse avec succès ou erreur
     */
    public function restore(PaymentTransportUserArchiveRequest $request): JsonResponse
    {
        try {
            PaymentTransportUser::withTrashed()->whereIn('id', $request->ids)->restore();
            return $this->sendResponse([], __('paymentTransportUser.restore.success'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des paiements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement un ou plusieurs paiements.
     *
     * @param PaymentTransportUserArchiveRequest $request Requête validée contenant les IDs
     * @return JsonResponse Réponse avec succès ou erreur
     */
    public function destroy(PaymentTransportUserArchiveRequest $request): JsonResponse
    {
        try {
            PaymentTransportUser::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            return $this->sendResponse([], __('paymentTransportUser.delete.success'), 204);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des paiements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }


    /**
     * Calcule le solde restant à payer pour un utilisateur de transport.
     *
     * @param PaymentTransportUserBalanceRequest $requestData
     * @return array|JsonResponse
     */
    public function calculateBalanceTransportUser(PaymentTransportUserBalanceRequest $requestData)
    {
        try {
            // Vérification de l'étudiant
            $student = User::findOrFail($requestData['student_id']);

            // Récupération du transport lié à l'élève
            $transport = TransportUser::select('transport_users.id as id', 'transport_users.amount as amount')
                ->where('transport_users.id', $requestData['transport_user_id'])
                ->where('transport_users.student_id', $student->id)
                ->firstOrFail();

            // Total des avances déjà payées pour ce transport
            $sumAdvancePayment = PaymentTransportUser::where('transport_user_id', $transport->id)
                ->sum('advance_payment');

            // Calcul du montant restant
            $montantRestant = $transport->amount - $sumAdvancePayment;

            return ['montantRestant' => $montantRestant];
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la suppression définitive des paiements : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
