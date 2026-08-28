<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\BookGetRequest;
use App\Http\Requests\Admin\BookStoreRequest;
use App\Http\Requests\Book\BookArchiveRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\Book;
use App\Models\PensionUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Book
 */
class BookController extends BaseController
{
    /**
     * Lister les livres
     *
     * @param BookGetRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(BookGetRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;

            $books = Book::query();

            if(!is_null($request->idSchool)) $books = $books->where('idSchool', $request->idSchool);
            if(!is_null($request->idSection)) $books = $books->where('idSection', $request->idSection);
            if(!is_null($request->idLevel)) $books = $books->where('idLevel', $request->idLevel);
            if(!is_null($request->status)) $books = $books->where('status', $request->status);

            if(!is_null($filter_value)){
                $books->where(function($query) use ($filter_value) {
                    $query->where('name', 'like', "%$filter_value%");
                });
            }

            return BookResource::collection(
                $books
                    ->orderBy('name')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'un livre
     *
     * @param $idBook
     * @return BookResource|\Illuminate\Http\JsonResponse
     */
    public function show($idBook)
    {
        try {
            $book = Book::findOrFail($idBook);
            return BookResource::make($book);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer un nouveau livre
     *
     * @param BookStoreRequest $request
     * @return BookResource|\Illuminate\Http\JsonResponse
     */
    public function store(BookStoreRequest $request)
    {
        try {
            $book = Book::create([
                'name' => $request->name,
                'photo' => $request->photo ?? null,
                'status' => $request->status ?? "available",
                'auteur' => $request->auteur ?? null,
                'editeur' => $request->editeur ?? null,
                'date_publication' => $request->date_publication ?? null,
                'idSchool' => $request->idSchool ?? null,
                'idSection' => $request->idSection ?? null,
                'idLevel' => $request->idLevel ?? null,
                'created_by' => auth()->user()->id,
            ]);

            return BookResource::make($book);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'un livre
     *
     * @param BookStoreRequest $request
     * @param $idBook
     * @return BookResource|\Illuminate\Http\JsonResponse
     */
    public function update(BookStoreRequest $request, $idBook)
    {
        try {
            $book = Book::findOrFail($idBook);

            $book->name = $request->name ?? $book->name;
            $book->photo = $request->photo ?? $book->photo;
            $book->status = $request->status ?? $book->status;
            $book->auteur = $request->auteur ?? $book->auteur;
            $book->editeur = $request->editeur ?? $book->editeur;
            $book->date_publication = $request->date_publication ?? $book->date_publication;
            $book->idSchool = $request->idSchool ?? $book->idSchool;
            $book->idSection = $request->idSection ?? $book->idSection;
            $book->idLevel = $request->idLevel ?? $book->idLevel;
            $book->updated_by = auth()->user()->id;
            $book->save();

            return BookResource::make($book);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprimer un livre (si il n'a jamais été affecté à un utilisateur)
     *
     * @param $idBook
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($idBook)
    {
        try {
            $book = Book::findOrFail($idBook);

            if($book->locations()->count() != 0 || $book->status == "unavailable"){
                return $this->sendError("Impossible de supprimer qui a déjà fait l'objet d'une location.", "");
            }

//            $book->delete();
            $book->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);
            return $this->sendResponse([], "Suppression effectuée avec succès");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Met des livres à la corbeille (soft delete).
     *
     * @param  BookArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function trashBulk(BookArchiveRequest $request): JsonResponse
    {
        try {

            Book::whereIn('id', $request->ids)->delete();
            Log::info('Books mis à la corbeille', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaure des livres supprimés (soft delete).
     *
     * @param  BookArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function restoreBulk(BookArchiveRequest $request): JsonResponse
    {
        try {
            
            Book::withTrashed()->whereIn('id', $request->ids)->restore();
            Log::info('Books restaurés', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Restauration effectuée avec succès', 200);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Supprime définitivement des livres (hard delete).
     *
     * @param  BookArchiveRequest  $request
     * @return JsonResponse
     *
     * Exemple payload attendu :
     * {
     *   "ids": [1, 2, 3]
     * }
     */
    public function destroyBulk(BookArchiveRequest $request): JsonResponse
    {
        try {
            Book::withTrashed()->whereIn('id', $request->ids)->forceDelete();
            Log::info('Books supprimés définitivement', ['ids' => $request->ids]);
            return $this->sendResponse([], 'Suppression effectuée avec succès', 204);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
            return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
