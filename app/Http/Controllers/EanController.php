<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEanRequest;
use App\Services\ArticleService;
use App\Services\EanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class EanController extends Controller
{
    private ArticleService $articlesService;
    private EanService $eanService;

    /**
     * EanController constructor.
     * @param ArticleService $articlesService
     * @param EanService $eanService
     */
    public function __construct(ArticleService $articlesService, EanService $eanService)
    {
        $this->articlesService = $articlesService;
        $this->eanService = $eanService;
    }

    /**
     * @param StoreEanRequest $request
     * @param int $article_id
     * @return RedirectResponse|Redirector
     */
    public function store(StoreEanRequest $request, int $article_id)
    {
        $article = $this->articlesService->getArticleById($article_id);
        $ean = $this->eanService->getNewEan();
        $this->eanService->updateEan($request, $article, $ean);

        session()->flash('success-message', 'Ean added.');

        return redirect(route('articles.edit', $article->id));
    }

    /**
     * @param int $articleId
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy(int $articleId, int $id)
    {
        $article = $this->articlesService->getArticleById($articleId);
        $ean = $this->eanService->getEanById($article, $id);

        try {
            $this->eanService->deleteEan($ean);
            session()->flash('success-message', 'Ean deleted.');
        } catch (\Exception $e) {
            session()->flash('error-message', 'Cannot delete ean.');
        }

        return redirect(route('articles.edit', $articleId));
    }
}
