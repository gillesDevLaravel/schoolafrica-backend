<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\PageLivreAllRequest;
use App\Http\Requests\Admin\PageLivreStoreRequest;
use App\Http\Requests\Admin\PageLivreUpdateRequest;
use App\Http\Resources\Admin\PageLivreResource;
use App\Models\PageLivre;
use Illuminate\Support\Facades\Log;

class PageLivreController extends BaseController
{
    /**
     * Lister les pages d'un livre
     *
     * @param PageLivreAllRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PageLivreAllRequest $request)
    {
        try {
            $pageItems = $request['pageItems'] ?? 1; // page de pagination
            $nbreItems = $request['nbreItems'] ?? 1000000; // nbre de résultats de la page
            $filter_value = $request->filter_value;
            $idBook = $request->idBook;
            $titre = $request->titre;

            $pages = PageLivre::query();

            if(!is_null($request->idBook)) $pages = $pages->where('idBook', $idBook);
            if(!is_null($request->titre)) $pages = $pages->where('titre', $titre);

            if(!is_null($filter_value)){
                $pages->where(function($query) use ($filter_value) {
                    $query->where('description', 'like', "%$filter_value%")
                        ->orWhere('titre', 'like', "%$filter_value%")
                        ->orWhere('sous_titre', 'like', "%$filter_value%")
                        ->orwhereHas('book', function($q) use ($filter_value) {
                            $q->where('name', 'like', "%$filter_value%");
                        });
                });
            }

            return PageLivreResource::collection(
                $pages
                    ->orderBy('id', 'desc')
                    ->paginate($nbreItems, ['*'], 'page', $pageItems)
            );
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Afficher les détails d'une page de livre
     *
     * @param $idPageLivre
     * @return PageLivreResource|\Illuminate\Http\JsonResponse
     */
    public function show($idPageLivre)
    {
        try {
            $pageLivre = PageLivre::findOrFail($idPageLivre);
            return PageLivreResource::make($pageLivre);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Enregistrer une ou plusieurs pages d'un livre
     *
     * @param PageLivreStoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function store(PageLivreStoreRequest $request)
    {
        try {
            $idBook = $request->idBook;

            $pagesLivre = $request->pages;
            $pages = array();

            foreach ($pagesLivre as $pageLivre) {
                $pages[] = PageLivre::firstOrCreate([
                    'idBook' => $idBook,
                    'titre' => $pageLivre['titre'],
                    'sous_titre' => $pageLivre['sous_titre'] ?? null,
                ],[
                    'idBook' => $idBook,
                    'titre' => $pageLivre['titre'],
                    'sous_titre' => $pageLivre['sous_titre'] ?? null,
                    'description' => $pageLivre['description'],
                    'created_by' => auth()->user()->id,
                ]);
            }

            return PageLivreResource::collection($pages);
        }catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * maj des infos d'une page de livre
     *
     * @param PageLivreUpdateRequest $request
     * @param $id
     * @return PageLivreResource|\Illuminate\Http\Response
     */
    public function update(PageLivreUpdateRequest $request, $id)
    {
        try {
            $pageLivre = PageLivre::findOrFail($id);

            $pageLivre->update([
                'titre' => $request->titre ?? $pageLivre->titre,
                'sous_titre' => $request->sous_titre ?? $pageLivre->sous_titre,
                'description' => $request->description ?? $pageLivre->description,
                'updated_by' => auth()->user()->id,
            ]);

            return PageLivreResource::make($pageLivre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Envoyer une page de livre à la corbeille
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trash($id)
    {
        try {
            $pageLivre = PageLivre::findOrFail($id);

            $pageLivre->update([
                'deleted_by' => auth()->user()->id,
                'deleted' => true
            ]);

            return $this->sendResponse([], "Page de Livre supprimée avec succès.");
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }

    /**
     * Restaurer uune page de livre de la corbeille
     * NB: Il n'est pas possible de restaurer un élément qui n'est pas ACUTELLEMENT à l'état Corbeille
     *
     * @param $id
     * @return PageLivreResource|\Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        try {
            $pageLivre = PageLivre::withoutGlobalScope('isDeleted')
                ->where([
                    'deleted' => true,
                    'id' => $id
                ])->firstOrFail();

            $pageLivre->update([
                'updated_by' => auth()->user()->id,
                'deleted' => false
            ]);

            return PageLivreResource::make($pageLivre);
        } catch (\Throwable $th) {
            Log::critical($th->getMessage() . " in file " . $th->getFile() . " on line " . $th->getLine());
             return $this->sendError(__('app.error_occured'), null, 500, $th->getMessage());
        }
    }
}
