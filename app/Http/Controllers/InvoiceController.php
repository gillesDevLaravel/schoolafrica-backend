<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\InvoiceGetAllRequest;
use App\Http\Requests\Admin\InvoiceStatRequest;
use App\Http\Resources\AdminSimp\InvoiceSimpResource;
use App\Http\Resources\Staffs\FeeUserResource;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Http\Resources\Admin\InvoiceResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\DuplicateInvoiceRequest;
use App\Http\Requests\Invoice\InvoiceArchiveRequest;

/**
 * @group Invoice
 */
class InvoiceController extends BaseController
{
    /**
     * Afficher la liste des invoices
     *
     * @bodyParam idSchool int
     * @bodyParam idSection int
     * @bodyParam statut string paid/unpaid
     * @bodyParam idTypeInvoice int
     * @bodyParam typeUser string customer/user
     * @bodyParam idUser int ID du customer/user
     * @bodyParam date Date
     * @bodyParam date_start Date
     * @bodyParam date_end Date
     * @bodyParam filter_value string La valeur avec laquelle on veut effectuer le filtre
     * @bodyParam pageItems int Le numéro de la page de pagination
     * @bodyParam nbreItems int Le nombre de résultats pour la page de pagination
     *
     * @param InvoiceGetAllRequest $request
     * @return array|\Illuminate\Http\Response
     */
    public function index(InvoiceGetAllRequest $request)
    {
        try {

            $idSchool = $request['idSchool'] ?? null;
            $idSection = $request['idSection'] ?? null;
            $statut = $request['statut'] ?? null;
            $mode = $request['mode'] ?? null;
            $idTypeInvoice = $request['idTypeInvoice'] ?? null;
            $idProduct = $request['idProduct'] ?? null;
            $idUser = $request['idUser'] ?? null;
            $date = $request['date'] ?? null;
            $typeUser = $request['type'] ?? null;
            $type_produit = $request['type_produit'] ?? null;
            $purchase_order_id = $request['purchase_order_id'] ?? null;
            $type = $request['type'] ?? null;
            $pageItems = $request['pageItems'] ?? 1;
            $nbreItems = $request['nbreItems'] ?? 1000000;

            $date_start = $request['date_start'] ?? null;
            $date_end = $request['date_end'] ?? null;

            /**
             * 🔹 Fonction locale : normalise une date en YYYY-MM-DD
             */
            $normalizeDate = function ($value) {
                if (!$value) return null;

                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                    return $value;
                }

                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                    return Carbon::createFromFormat('d-m-Y', $value)->toDateString();
                }

                return null;
            };
            $invoicesQuery = Invoice::query()->whereNull('deleted_at');

            //filtrer par le champ type de la table type_invoice
            if (!is_null($type)) {
                $invoicesQuery->whereHas('type_invoice', function ($query) use ($type) {
                    $query->where('type', $type);
                });
            }

            

            if (!is_null($idSchool)) $invoicesQuery->where('idSchool', $idSchool);
            if (!is_null($idSection)) $invoicesQuery->where('idSection', $idSection);
            if (!is_null($statut)) $invoicesQuery->where('statut', $statut);
            if (!is_null($mode)) $invoicesQuery->where('mode', $mode);
            if (!is_null($purchase_order_id)) $invoicesQuery->where('purchase_order_id', $purchase_order_id);
            if (!is_null($type_produit)) $invoicesQuery->where('type_produit', 'LIKE', "%$type_produit%");
            if (!is_null($idTypeInvoice)) $invoicesQuery->where('idTypeInvoice', $idTypeInvoice);
            if (!is_null($idProduct)) $invoicesQuery->where('idProduct', $idProduct);
            if (!is_null($idUser)) $invoicesQuery->where('invoiceable_id', $idUser);

            if (!is_null($date)) {
                $normalizedDate = $normalizeDate($date);
                if ($normalizedDate) {
                    $invoicesQuery->whereRaw("
                    STR_TO_DATE(
                        date,
                        CASE
                            WHEN date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'
                            THEN '%Y-%m-%d'
                            ELSE '%d-%m-%Y'
                        END
                    ) = ?
                ", [$normalizedDate]);
                }
            }

            if (!is_null($typeUser)) {
                $invoiceable_type = ($typeUser === 'customer') ? Customer::class : User::class;
                $invoicesQuery->where('invoiceable_type', $invoiceable_type);
            }

            if (!empty($date_start) && !empty($date_end)) {
                $startDate = $normalizeDate($date_start);
                $endDate   = $normalizeDate($date_end);

                if ($startDate && $endDate) {
                    $invoicesQuery->whereRaw("
                    STR_TO_DATE(
                        date,
                        CASE
                            WHEN date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'
                            THEN '%Y-%m-%d'
                            ELSE '%d-%m-%Y'
                        END
                    ) BETWEEN ? AND ?
                ", [$startDate, $endDate]);
                }
            }

            $filter_value = $request['filter_value'] ?? null;
            if (!is_null($filter_value)) {
                $invoicesQuery->where(function ($query) use ($filter_value) {
                    $query->where('reasons', 'like', "%$filter_value%")
                        ->orWhere('date', 'like', "%$filter_value%")
                        ->orWhere('statut', 'like', "%$filter_value%")
                        ->orWhere('mode', 'like', "%$filter_value%")
                        ->orWhere('number', 'like', "%$filter_value%")
                        ->orWhereHas('type_invoice', function ($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHas('product', function ($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        })
                        ->orWhereHasMorph(
                            'invoiceable',
                            [User::class, Customer::class],
                            function ($q) use ($filter_value) {
                                $q->where('name', 'like', "%$filter_value%");
                            }
                        );
                });
            }

            // Totaux AVANT pagination (logique inchangée)
            $totalQuery = clone $invoicesQuery;
            $allInvoicesForTotals = $totalQuery->get();

            $totalAdvancePayment = $allInvoicesForTotals->where('statut', 'paid')->sum('amount');
            $totalAdvancePaymentOM = $allInvoicesForTotals->where('statut', 'paid')->where('mode', 'Orange Money')->sum('amount');
            $totalAdvancePaymentCash = $allInvoicesForTotals->where('statut', 'paid')->where('mode', 'Cash')->sum('amount');
            $totalAdvancePaymentBank = $allInvoicesForTotals->where('statut', 'paid')->where('mode', 'Bank')->sum('amount');
            $totalAdvancePaymentMomo = $allInvoicesForTotals->where('statut', 'paid')->where('mode', 'Mobile Money')->sum('amount');

            // Pagination + tri corrigé (chronologique réel)
            $invoices = $invoicesQuery
                ->orderByRaw("
                STR_TO_DATE(
                    date,
                    CASE
                        WHEN date REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'
                        THEN '%Y-%m-%d'
                        ELSE '%d-%m-%Y'
                    END
                ) DESC
            ")
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            $meta = [
                'current_page' => $invoices->currentPage(),
                'last_page' => $invoices->lastPage(),
                'to' => $invoices->lastItem(),
                'total' => $invoices->total(),
            ];

            return [
                'data' => InvoiceResource::collection($invoices),
                'meta' => $meta,
                'sommes' => number_format($totalAdvancePayment),
                'om' => number_format($totalAdvancePaymentOM),
                'momo' => number_format($totalAdvancePaymentMomo),
                'cash' => number_format($totalAdvancePaymentCash),
                'bank' => number_format($totalAdvancePaymentBank),
            ];

        } catch (\Throwable $th) {
            Log::critical(
                $th->getMessage() . ' in ' . $th->getFile() . ' on line ' . $th->getLine()
            );

            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Ajouter un invoice
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        try {
            foreach ($request->invoices as $invoice) {

                $dateString = $invoice['date'];

                // Vérifier si la date est déjà au format Y-m-d
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
                    // Si ce n'est pas le bon format, formater la date
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $dateString)->format('Y-m-d');
                } else {
                    // Si c'est déjà au bon format, on garde la date telle quelle
                    $formattedDate = $dateString;
                }

                $inv = Invoice::create([
                    'amount' => $invoice['amount'],
                    'reasons' => $invoice['reasons'],
                    'purchase_order_id' => $invoice['purchase_order_id'] ?? null,
                    'image' => $invoice['image'] ?? null,
                    'payment_deadline' => $invoice['payment_deadline'] ?? null,
                    'date' => $formattedDate,
                    'idSchool' => $invoice['idSchool'],
                    'idSection' => $invoice['idSection'] ?? null,
                    'created_by' => auth()->user()->id,
                    'invoiceable_type' => ($invoice['typeUser']=='customer') ? "App\Models\Customer" : "App\Models\User",
                    'invoiceable_id' => $invoice['idUser'],
                    'statut' => $invoice['statut'],
                    'mode' => $invoice['mode'],
                    'number' => $invoice['number'] ?? null,
                    'type_produit' => $invoice['type_produit'] ?? null,
                    'quantite' => $invoice['quantite'] ?? null,
                    'prix_unitaire' => $invoice['prix_unitaire'] ?? null,
                    'idTypeInvoice' => $invoice['idTypeInvoice'],
                    'idProduct' => $invoice['idProduct'] ?? null,
                ]);

                // Créer les enregistrements dans la table pivot si des salary components sont fournis
                if (isset($invoice['salary_components']) && is_array($invoice['salary_components'])) {
                    foreach ($invoice['salary_components'] as $component) {
                        $inv->salaryComponents()->attach($component['salary_component_id'], [
                            'base_amount' => $component['base_amount'] ?? 0,
                            'coef' => $component['coef'] ?? 0,
                            'base_patronal' => $component['base_patronal'] ?? 0,
                            'coef_patronal' => $component['coef_patronal'] ?? 0,
                        ]);
                    }
                }

//                if(isset($invoice['image']) && !is_null($invoice['image'])){
//                    $file = $invoice['image'];
//                    $uploadPath = "public/invoices";
//                    $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                    $file->move($uploadPath,$originalImage);
//
//                    $inv->image = $originalImage;
//                    $inv->save();
//                }

                Log::info("Ajout d'un invoice", ['auteur' => auth()->user()->id, 'invoice' => $inv->id]);
            }
            return $this->sendResponse([], "Invoices créés avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Afficher les infos d'un invoice
     *
     * @urlParam id int required
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            return new InvoiceResource($invoice);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Modifier les infos d'un invoice
     *
     * @urlParam id int required
     *
     * @param InvoiceRequest $request
     * @return InvoiceResource|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Valider les données de mise à jour
            $request->validate((new InvoiceRequest())->updateRules());

            $invoice = Invoice::findOrFail($id);
            $invoice->amount = $request['amount'] ?? $invoice->amount;
            $invoice->reasons = $request['reasons'] ?? $invoice->reasons;
            $invoice->purchase_order_id = $request['purchase_order_id'] ?? $invoice->purchase_order_id;
            $invoice->image = $request['image'] ?? $invoice->image;
            $invoice->payment_deadline = $request['payment_deadline'] ?? $invoice->payment_deadline;
            $invoice->idSchool = $request['idSchool'] ?? $invoice->idSchool;
            $invoice->idSection = $request['idSection'] ?? $invoice->idSection;
            $invoice->updated_by = auth()->user()->id;

            $invoice->invoiceable_type = ($request->type=='customer') ? Customer::class : User::class;
            $invoice->invoiceable_id = $request->idUser ?? $invoice->invoiceable_id;
            $invoice->date = $request['date'] ?? $invoice->date;
            $invoice->statut = $request['statut'] ?? $invoice->statut;
            $invoice->mode = $request['mode'] ?? $invoice->mode;
            $invoice->number = $request['number'] ?? $invoice->number;
            $invoice->type_produit = $request['type_produit'] ?? $invoice->type_produit;
            $invoice->quantite = $request['quantite'] ?? $invoice->quantite;
            $invoice->prix_unitaire = $request['prix_unitaire'] ?? $invoice->prix_unitaire;
            $invoice->idTypeInvoice = $request['idTypeInvoice'] ?? $invoice->idTypeInvoice;
            $invoice->idProduct = $request['idProduct'] ?? $invoice->idProduct;

//            if(!is_null($request->image)){
//                $file = $request->file('image');
//                $uploadPath = "public/invoices";
//                $originalImage = Str::uuid().".".$file->getClientOriginalExtension();
//
//                $file->move($uploadPath,$originalImage);
//
//                $invoice->image = $originalImage;
//            }
            $invoice->save();

            // Mise à jour des salary components associés (si fournis)
            if ($request->filled('salary_components')) {
                $invoice->salaryComponents()->detach();

                $salaryComponentData = [];
                foreach ($request->salary_components as $component) {
                    $salaryComponentData[$component['salary_component_id']] = [
                        'base_amount' => $component['base_amount'],
                        'coef' => $component['coef'],
                        'base_patronal' => $component['base_patronal'],
                        'coef_patronal' => $component['coef_patronal'],
                    ];
                }
                // Synchronise les salary components avec les nouvelles données
                $invoice->salaryComponents()->sync($salaryComponentData);
            }

            Log::info("maj d'un invoice", ['auteur' => auth()->user()->id, 'invoice' => $invoice->id]);

            return new InvoiceResource($invoice);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }

    }

    /**
     * Supprimer un invoice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice, $id)
    {
        try {
            $invoice = Invoice::find($id);

            if(!is_null($invoice)){
                Log::critical("Suppression d'un invoice", ['auteur' => auth()->user()->id, 'invoice' => $invoice->id]);
                //unlink($invoice->image);
                $invoice->delete();
            }

            return response(null, 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    public function statistiquesInvoices(InvoiceStatRequest $request)
    {
        try {
            // Je sélectionne toutes les écoles(qui se trouvent au moins sur la table invoices) et pour chaque école je commence la danse

            $schoolsWithInvoices = DB::table('invoices as i')
                ->join('schools as s', 'i.idSchool', '=', 's.id')
                ->whereNull('i.deleted_at')
                ->where('i.statut', 'paid')
                ->selectRaw('s.id as idSchool, s.name as school, SUM(i.amount) as somme_totale')
                ->when($request['idSchool'] !== null, function ($query) use ($request) {
                    $query->where('idSchool', $request['idSchool']);
                })
                ->groupBy('s.id', 's.name')
                ->get();

            $schools = array();

            /**
             * Si y'a rien à faire, baaah je ne fais rien !
             */
            if(count($schoolsWithInvoices) == 0){
                return $this->sendResponses([
                    'schools' => null
                ]);
            }

            foreach ($schoolsWithInvoices as $key => $school){
                $schools[$key]['name'] = $school->school;
                $schools[$key]['somme'] = $school->somme_totale;

                /**
                 * J'ajoute la somme des invoices par type
                 */
                $invoicesOfThisSchoolPerType = DB::table('invoices')
                    ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                    ->where('invoices.idSchool', $school->idSchool)
                    ->whereNull('invoices.deleted_at')
                    ->where('invoices.statut', 'paid')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('invoices.idSection', $request['idSection']);
                    })
                    ->select(DB::raw('SUM(invoices.amount) as somme_type'), 'type_invoices.name as type_name')
                    ->groupBy('invoices.idTypeInvoice', 'type_invoices.name')
                    ->get();
                foreach ($invoicesOfThisSchoolPerType as $invoicesPerType) {
                    $schools[$key]['types'][] = [
                        'type' => $invoicesPerType->type_name,
                        'somme' => $invoicesPerType->somme_type,
                    ];
                }

                /*
                 * J'ajoute la somme des invoices par mois et par type
                 */

                // Je récupère d'abord tous les mois qui apparaissent dans la table invoice pour cette école
                $invoicesPerMonth = DB::table('invoices')
                    ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                    ->where('invoices.idSchool', $school->idSchool)
                    ->whereNull('invoices.deleted_at')
                    ->where('invoices.statut', 'paid')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('idSection', $request['idSection']);
                    })
                    ->select(
                        DB::raw('SUM(invoices.amount) as somme_month'),
                        DB::raw('DATE_FORMAT(invoices.date, "%Y-%m") as month_year')
                    )
                    ->groupBy('month_year')
                    ->get();

                foreach ($invoicesPerMonth as $invoicesForM) {
                    // je récupère en groupant par mois, les invoices de cette école
                    $invoicesPerMonthPerType = DB::table('invoices')
                        ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                        ->where('invoices.idSchool', $school->idSchool)
                        ->whereNull('invoices.deleted_at')
                        ->where('invoices.statut', 'paid')
                        ->when($request['idSection'] !== null, function ($query) use ($request) {
                            $query->where('invoices.idSection', $request['idSection']);
                        })
                        ->whereRaw("DATE_FORMAT(invoices.date, '%Y-%m') = ?", [date('Y-m', strtotime($invoicesForM->month_year))])
                        ->select(
                            DB::raw('SUM(invoices.amount) as somme_month'),
                            'type_invoices.name as type_name',
                            DB::raw("DATE_FORMAT(invoices.date, '%M %Y') as month_year")
                        )
                        ->groupBy('month_year', 'type_invoices.name')
                        ->get();

                    $tmp_types = [];
                    foreach ($invoicesPerMonthPerType as $invoicesPerMPerT) {
                        $tmp_types[] = [
                            'type' => $invoicesPerMPerT->type_name,
                            'somme' => $invoicesPerMPerT->somme_month
                        ];
                    }

                    $schools[$key]['months'][] = [
                        'month' => self::formatMonthYear($invoicesForM->month_year),
                        'somme' => $invoicesForM->somme_month,
                        'types' => $tmp_types
                    ];
                }
            }

            return $this->sendResponses($schools);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    protected static function formatMonthYear($monthYear)
    {
        $date = \DateTime::createFromFormat('Y-m', $monthYear);
        if ($date !== false) {
            return $date->format('F Y');
        } else {
            return $monthYear;
        }
    }

    /**
     * Statistiques des invoices en incluant les invoices de chaque type dans chaque mois
     *
     * @param InvoiceStatRequest $request
     * @return \Illuminate\Http\Response
     */
    public function statistiquesInvoicesParType(InvoiceStatRequest $request)
    {
        try {
            // Je sélectionne toutes les écoles(qui se trouvent au moins sur la table invoices) et pour chaque école je commence la danse

            $schoolsWithInvoices = DB::table('invoices as i')
                ->join('schools as s', 'i.idSchool', '=', 's.id')
                ->selectRaw('s.id as idSchool, s.name as school, SUM(i.amount) as somme_totale')
                ->when($request['idSchool'] !== null, function ($query) use ($request) {
                    $query->where('idSchool', $request['idSchool']);
                })
                ->whereNull('i.deleted_at')
                ->where('i.statut', 'paid')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('idSection', $request['idSection']);
                })
                ->groupBy('s.id', 's.name')
                ->get();

            $schools = array();

            /**
             * Si y'a rien à faire, baaah je ne fais rien !
             */
            if(count($schoolsWithInvoices) == 0){
                return $this->sendResponses([
                    'schools' => null
                ]);
            }

            foreach ($schoolsWithInvoices as $key => $school){
                $schools[$key]['name'] = $school->school;
                $schools[$key]['somme'] = $school->somme_totale;

                /**
                 * J'ajoute la somme des invoices par type
                 */
                $invoicesOfThisSchoolPerType = DB::table('invoices')
                    ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                    ->where('invoices.idSchool', $school->idSchool)->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('invoices.idSection', $request['idSection']);
                    })
                    ->whereNull('invoices.deleted_at')
                    ->select(DB::raw('SUM(invoices.amount) as somme_type'), 'type_invoices.name as type_name')
                    ->groupBy('invoices.idTypeInvoice', 'type_invoices.name')
                    ->get();
                foreach ($invoicesOfThisSchoolPerType as $invoicesPerType) {
                    $schools[$key]['types'][] = [
                        'type' => $invoicesPerType->type_name,
                        'somme' => $invoicesPerType->somme_type,
                    ];
                }

                /*
                 * J'ajoute la somme des invoices par mois et par type
                 */

                // Je récupère d'abord tous les mois qui apparaissent dans la table invoice pour cette école
                $invoicesPerMonth = DB::table('invoices')
                    ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                    ->where('invoices.idSchool', $school->idSchool)
                    ->whereNull('invoices.deleted_at')
                    ->where('invoices.statut', 'paid')
                    ->when($request['idSection'] !== null, function ($query) use ($request) {
                        $query->where('invoices.idSection', $request['idSection']);
                    })
                    ->select(
                        DB::raw('SUM(invoices.amount) as somme_month'),
                        DB::raw('DATE_FORMAT(invoices.date, "%Y-%m") as month_year')
                    )
                    ->groupBy('month_year')
                    ->get();

                foreach ($invoicesPerMonth as $invoicesForM) {
                    // je récupère en groupant par mois, les invoices de cette école
                    $invoicesPerMonthPerType = DB::table('invoices')
                        ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                        ->where('invoices.idSchool', $school->idSchool)
                        ->whereNull('invoices.deleted_at')
                        ->where('invoices.statut', 'paid')
                        ->when($request['idSection'] !== null, function ($query) use ($request) {
                            $query->where('invoices.idSection', $request['idSection']);
                        })
                        ->whereRaw("DATE_FORMAT(invoices.date, '%Y-%m') = ?", [date('Y-m', strtotime($invoicesForM->month_year))])
                        ->select(
                            DB::raw('SUM(invoices.amount) as somme_month'),
                            'type_invoices.name as type_name',
                            'type_invoices.id as type_id',
                            DB::raw("DATE_FORMAT(invoices.date, '%M %Y') as month_year")
                        )
                        ->groupBy('month_year', 'type_invoices.name', 'type_invoices.id')
                        ->get();

                    $tmp_types = [];
                    foreach ($invoicesPerMonthPerType as $invoicesPerMPerT) {
                        $tmp_depenses = Invoice::where('idTypeInvoice', $invoicesPerMPerT->type_id)
                            ->where('invoices.idSchool', $school->idSchool)
                            ->when($request['idSection'] !== null, function ($query) use ($request) {
                                $query->where('invoices.idSection', $request['idSection']);
                            })
                            ->whereRaw("DATE_FORMAT(invoices.date, '%Y-%m') = ?", [date('Y-m', strtotime($invoicesForM->month_year))])
                            ->get();

                        $tmp_types[] = [
                            'type' => $invoicesPerMPerT->type_name,
                            'somme' => $invoicesPerMPerT->somme_month,
                            'invoices' => InvoiceSimpResource::collection($tmp_depenses)
                        ];
                    }

                    $schools[$key]['months'][] = [
                        'month' => self::formatMonthYear($invoicesForM->month_year),
                        'somme' => $invoicesForM->somme_month,
                        'types' => $tmp_types
                    ];
                }
            }

            return $this->sendResponses($schools);
        }
        catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Statistiques des entrées & sorties par mois
     *
     * @param InvoiceStatRequest $request
     * @return \Illuminate\Http\Response
     */
    public function statistiquesParMois(InvoiceStatRequest $request)
    {
        try {
            // Je récupère d'abord tous les mois qui apparaissent dans la table invoice pour cette école
            $invoicesPerMonth = DB::table('invoices')
                ->join('type_invoices', 'type_invoices.id', '=', 'invoices.idTypeInvoice')
                ->where('invoices.idSchool', $request->idSchool)
                ->whereNull('invoices.deleted_at')
                ->where('invoices.statut', 'paid')
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('invoices.idSection', $request['idSection']);
                })
                ->select(
                    DB::raw('SUM(invoices.amount) as somme_month'),
                    DB::raw('DATE_FORMAT(invoices.date, "%Y-%m") as month_year')
                )
                ->groupBy('month_year')
                ->get();

            $pensionUsersPerMonth = DB::table('pension_users')
                ->where('pension_users.idSchool', $request->idSchool)
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('pension_users.idSection', $request['idSection']);
                })
                ->select(
                    DB::raw('SUM(pension_users.advancePayment) as somme_month'),
                    DB::raw('DATE_FORMAT(pension_users.created_at, "%Y-%m") as month_year')
                )
                ->groupBy('month_year')
                ->get();

            $feeUsersPerMonth = DB::table('fee_user')
                ->where('fee_user.idSchool', $request->idSchool)
                ->when($request['idSection'] !== null, function ($query) use ($request) {
                    $query->where('fee_user.idSection', $request['idSection']);
                })
                ->select(
                    DB::raw('SUM(fee_user.advancePayment) as somme_month'),
                    DB::raw('DATE_FORMAT(fee_user.created_at, "%Y-%m") as month_year')
                )
                ->groupBy('month_year')
                ->get();

            $allMonths = collect($invoicesPerMonth)
                ->merge($pensionUsersPerMonth)
                ->merge($feeUsersPerMonth)
                ->pluck('month_year')
                ->unique()
                ->sort();

            $stats = array();

            foreach ($allMonths as $month){
                $stats[] = [
                    'month' => self::formatMonthYear($month),
                    'depenses' => $invoicesPerMonth->where('month_year', $month)->first()->somme_month ?? 0,
                    'entrees' => (@$pensionUsersPerMonth->where('month_year', $month)->first()->somme_month) ?? 0
                        + (@$feeUsersPerMonth->where('month_year', $month)->first()->somme_month) ?? 0,
                ];
            }

            return $this->sendResponses($stats);
        }
        catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Dupliquer une ou plusieurs factures avec une nouvelle date
     * 
     * @bodyParam invoices_id array required Tableau des IDs des factures à dupliquer
     * @bodyParam date string required Nouvelle date pour les factures (format Y-m-d)
     * 
     * @param DuplicateInvoiceRequest $request
     * @return \Illuminate\Http\Response
     */
public function duplicateInvoices(DuplicateInvoiceRequest $request)
{
    DB::beginTransaction();

    try {
        $duplicatedInvoices = [];
        $invoiceIds = $request->invoices_id ?? [];
        $newDate = $request->date;

        if (empty($invoiceIds) || !$newDate) {
            return $this->sendError(__('Veuillez fournir les IDs des factures et la nouvelle date.'));
        }
        // je Vérifie si la date est valide
        $newDate = Carbon::parse($newDate)->format('Y-m-d');
        // je parcour le tout les id d'invoices a dupliquer
        foreach ($invoiceIds as $invoiceId) {
            // je recupere l'invoice originale
            $originalInvoice = Invoice::find($invoiceId);
            if (!$originalInvoice) continue;
            // je duplique l'invoice
            $newInvoice = $originalInvoice->replicate();
            $newInvoice->date = $newDate;
            $newInvoice->created_by = auth()->id();
            $newInvoice->created_at = now();
            $newInvoice->updated_at = now();
            $newInvoice->save();
            // je stocke l'invoice dupliquée
            $duplicatedInvoices[] = $newInvoice;
        }

        DB::commit();

        return $this->sendResponse(
            InvoiceResource::collection(collect($duplicatedInvoices)),__('Factures dupliquées avec succès')
        );

    } catch (\Throwable $th) {
        DB::rollBack();
        Log::critical('Erreur lors de la duplication des factures: ' . $th->getMessage(), ['trace' => $th->getTraceAsString(), 'invoice_ids' => $request->invoices_id ?? []]);
        return $this->sendError($th->getMessage(), null, 500);
    }
}
     
    /**
     * Archiver des factures (batch)
     * 
     * @bodyParam ids array required Tableau des IDs des factures à archiver
     * 
     * @param InvoiceArchiveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(InvoiceArchiveRequest $request)
    {
        try {
            Invoice::whereIn('id', $request->ids)->update(['deleted_at' => now()]);
            Log::info('Factures archivées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('Factures archivées'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de l\'archivage des factures : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer des factures supprimées (batch)
     * @param InvoiceArchiveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(InvoiceArchiveRequest $request)
    {
        try {
            Invoice::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Factures restaurées', ['ids' => $request->ids]);
            return $this->sendResponse([], __('Factures restaurées'), 200);
        } catch (\Throwable $th) {
            Log::error('Erreur lors de la restauration des factures : ' . $th->getMessage());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
