<?php

namespace App\Http\Controllers\RH;

use App\Enums\NoteFraiStatusEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ProjectAllRequest;
use App\Http\Requests\Staffs\NoteFraisAllRequest;
use App\Http\Requests\Staffs\NoteFraisDownloadRequest;
use App\Http\Requests\Staffs\NoteFraisStoreRequest;
use App\Http\Requests\Staffs\NoteFraisUpdateRequest;
use App\Http\Resources\Staffs\NoteFraisResource;
use App\Interfaces\PDFGeneratorInterface;
use App\Models\NoteFrais;
use App\Models\Notification;
use App\Services\PDFGlobalGeneratorService;
use Carbon\Carbon;
use Google\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NoteFraisController extends BaseController implements PDFGeneratorInterface
{
    protected $pdfGlobalGenerator;

    public function __construct(PDFGlobalGeneratorService $pdfGlobalGenerator)
    {
        $this->pdfGlobalGenerator = $pdfGlobalGenerator;
    }

    /**
     * Lister les notes de frais non supprimées
     *
     * @param ProjectAllRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(NoteFraisAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $idUser = $request->idUser ?? null;
            $status = $request->status ?? null;
            $date = $request->date ?? null;
            $idUserApprove = $request->idUserApprove ?? null;

            $notes = NoteFrais::query();

            if(!is_null($idUser)) $notes = $notes->where('idUser',$request['idUser']);
            if(!is_null($status)) $notes = $notes->where('status',$request['status']);
            if(!is_null($idUserApprove)) $notes = $notes->where('idUserApprove',$request['idUserApprove']);

            // Filtres par plage de dates
            if ($request->filled('start_date')) {
                $notes->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $notes->whereDate('date', '<=', $request->end_date);
            }

            if(!is_null($date)){
                // Vérifier si la date est déjà au format Y-m-d
                if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    // Si ce n'est pas le bon format, formater la date
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                } else {
                    // Si c'est déjà au bon format, on garde la date telle quelle
                    $formattedDate = $date;
                }

                $notes = $notes->where('note_frais.date', "like", "%$formattedDate%");
            }

            if(!is_null($filter_value)){
                $notes->where(function($query) use ($filter_value) {
                    $query->where('libelle', 'like', "%$filter_value%")
                        ->orWhere('status', 'like', "%$filter_value%")
                        ->orWhereHas('user', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            // Comptages par statut
            $statusCounts = [
                'in_progress' => (clone $notes)->where('status', 'in_progress')->count(),
                'pending' => (clone $notes)->where('status', 'pending')->count(),
                'approved' => (clone $notes)->where('status', 'approved')->count(),
                'rejected' => (clone $notes)->where('status', 'rejected')->count(),
            ];

            $paginated = $notes
                ->orderBy('id', 'desc')
                ->paginate($nbreItems, ['*'], 'page', $pageItems);

            return response()->json([
                'data' => NoteFraisResource::collection($paginated),
                'counts_by_status' => $statusCounts,
                'meta' => [
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                ],
            ]);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une note de frais
     *
     * @param $idNoteFrais
     * @return NoteFraisResource|JsonResponse
     */
    public function show($idNoteFrais)
    {
        try {
            $note_frais = NoteFrais::findOrFail($idNoteFrais);
            return NoteFraisResource::make($note_frais);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une ou plusieurs notes de frais.
     * L'enregistrement génère un fichier PDF ou ZIP contenant les PDFs des notes de frais crées
     *
     * @param NoteFraisStoreRequest $request
     * @return JsonResponse
     */
    public function store(NoteFraisStoreRequest $request)
    {
        try {
            $note_frais = $request->note_frais;
            $notes = array();

            foreach ($note_frais as $note) {
                // ce serait trop étrange de créer 2 notes de frais (sameUser,sameLibelle,sameAmount)... du coup on va empêcher ça
                $notes[] = NoteFrais::firstOrCreate([
                    'idUser' => $note['idUser'] ?? auth()->user()->id,
                    'libelle' => $note['libelle'],
                    'amount' => $note['amount'],
                ],[
                    'idUser' => $note['idUser'] ?? auth()->user()->id, // si ce champ n'est pas fourni, on prend l'id de celui qui crée la note
                    'idUserApprove' => $note['idUserApprove'],
                    'libelle' => $note['libelle'],
                    'amount' => $note['amount'],
                    'date'         => Carbon::createFromFormat('d-m-Y', $note['date'])->format('Y-m-d'),
                    'description' => $note['description'],
                    'status' => $note['status'] ?? NoteFraiStatusEnum::IN_PROGRESS,
                    'created_by' => auth()->user()->id,
                ])->id;

                Notification::create([
                    'notificationable_type' => NoteFrais::class,
                    'notificationable_id' => last($notes),
                    'title' => __('notifs.note_frais_title'),
                    'description' => $note['libelle'] . " : " . $note['amount'] . ".",
                    'user_id' => $note['idUserApprove'],
                    'grouped_users' => null
                ]);
            }

            $pdf_or_zip = $this->generatePDFs($notes);

            return $this->sendResponse($pdf_or_zip, "Note de frais");

//            return NoteFraisResource::collection($notes);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une note de frais
     *
     * @param NoteFraisUpdateRequest $request
     * @param $id
     * @return NoteFraisResource|JsonResponse
     */
    public function update(NoteFraisUpdateRequest $request, $id)
    {
        try {
            $note_frais = NoteFrais::findOrFail($id);

            $notify_user = false; // est-ce qu'on doit notifier le user après la m.a.j ?
            $notify_idUserApprove = false; // est-ce qu'on doit notifier le responsable après la m.a.j ?

            if($request->status !== $note_frais->status){
                $notify_user = true;
                $notify_idUserApprove = true; // on le notifie aussi que la note de frais doit être vérifiée
            }
            if($request->idUserApprove !== $note_frais->idUserApprove){ // si il a changé la personne qui doit appro
                $notify_idUserApprove = true;
            }

            $note_frais->update([
                'idUser' => $request->idUser ?? $note_frais->idUser,
                'idUserApprove' => $request->idUserApprove ?? $note_frais->idUserApprove,
                'libelle' => $request->libelle ?? $note_frais->libelle,
                'amount' => $request->amount ?? $note_frais->amount,
//                'status' => (auth()->id() == $note_frais->idUserApprove && $request->status) ? $request->status : $note_frais->status,
                'date' => !empty($request['date'])
                    ? Carbon::createFromFormat('d-m-Y', $request['date'])->format('Y-m-d')
                    : $note_frais->date,
                'description' => $request->description ?? $note_frais->description,
                'updated_by' => auth()->user()->id,
            ]);

            // On permet la modification du statut uniquement si
            //      c'est celui qui a été désigné comme responsable de l'approbation
            //      et que le statut envoyé est différent celui présent
            if((auth()->id() === $note_frais->idUserApprove) && ($request->status != $note_frais->status) ){
                $note_frais->status = $request->status ?? $note_frais->status;
                $note_frais->save();
            }

            if($notify_user){
                // on veut notifier la personne si le statut a changé
                Notification::create([
                    'notificationable_type' => NoteFrais::class,
                    'notificationable_id' => $note_frais->id,
                    'title' => __('notifs.note_frais_traitment_title'),
                    'description' => $request->status . "\n". $note_frais->libelle . " : " . $note_frais->amount . ".",
                    'user_id' => $note_frais['idUser'],
                    'grouped_users' => null
                ]);
            }
            if($notify_idUserApprove){
                // On notifie aussi le responsable qu'il doit approuver/rejeter la note de frais
                Notification::create([
                    'notificationable_type' => NoteFrais::class,
                    'notificationable_id' => $note_frais->id,
                    'title' => __('notifs.note_frais_title'),
                    'description' => $note_frais['libelle'] . " : " . $note_frais['amount'] . ".", //$request->status . "\n". $note_frais->libelle . " : " . $note_frais->amount . ".",
                    'user_id' => $note_frais['idUser'],
                    'grouped_users' => null
                ]);
            }

            return NoteFraisResource::make($note_frais);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer une note de frais à la corbeille
     *
     * @param $id
     * @return JsonResponse
     */
    public function trash($id)
    {
        try {
            $note_frais = NoteFrais::find($id);
            if(is_null($note_frais)){
                return $this->sendError("Note de frais inexistante ou déjà dans la corbeille. Impossible de supprimer");
            }

            $note_frais->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return $this->sendResponse([], "Note de frais supprimée avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer une note de frais de la corbeille
     * NB: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return NoteFraisResource|JsonResponse
     */
    public function restore($id)
    {
        try {
            $note_frais = NoteFrais::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->first();

            if(is_null($note_frais)){
                return $this->sendError("Note de frais inexistante ou déjà restaurée. Impossible d'effectuer cette opération");
            }

            $note_frais->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return NoteFraisResource::make($note_frais);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * RE-Télécharger une ou plusieurs notes de frais
     *
     * @param NoteFraisDownloadRequest $request
     * @return JsonResponse|mixed|String
     */
    public function download(NoteFraisDownloadRequest $request)
    {
        try {
            $notes_frais = $this->generatePDFs($request->idsNoteFrais);

            return $this->sendResponse($notes_frais, "Notes de frais");
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    function generatePDFs(array $idsNoteFrais): string
    {
        try {
            $notes_frais = NoteFrais::whereIn('id', $idsNoteFrais)
                ->get()
                ->toArray();

            $docs = array();

            foreach ($notes_frais as $note) {
                $filename = Str::slug($note['libelle']);

                $data = [
                    'name' => $filename
                ];
                $pdf_generated = $this->pdfGlobalGenerator->generatePDF("welcome_mod", $data, $filename);

                if(! strpos($pdf_generated, ".pdf")){
                    throw new Exception($pdf_generated);
                }

                $docs[] = [
                    'name' => $filename, // je pourais avoir besoin de ce nom plus tard
                    'link' => $pdf_generated,
                ];
            }

            // si on a un seul doc, on retourne le PDF, sinon on va générer le ZIP avant de retourner ce dernier
            if(count($docs) == 1){
                $returnValue = $docs[0]['link'];
            }
            else{
                $returnValue = $this->pdfGlobalGenerator->generateZIP($docs, "notes-de-frais");
            }

            return $returnValue;
        }
        catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
