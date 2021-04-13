<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRelatedNumberRequest;
use App\Services\ArticleService;
use App\Services\RelatedNumberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RelatedNumberController extends Controller
{
    private ArticleService $articlesService;
    private RelatedNumberService $relatedNumberService;

    /**
     * RelatedNumberController constructor.
     * @param ArticleService $articlesService
     * @param RelatedNumberService $relatedNumberService
     */
    public function __construct(ArticleService $articlesService, RelatedNumberService $relatedNumberService)
    {
        $this->articlesService = $articlesService;
        $this->relatedNumberService = $relatedNumberService;
    }

    /**
     * @param StoreRelatedNumberRequest $request
     * @param int $article_id
     * @return RedirectResponse|Redirector
     */
    public function store(StoreRelatedNumberRequest $request, int $article_id)
    {
        $article = $this->articlesService->getArticleById($article_id);
        $relatedNumber = $this->relatedNumberService->getNewRelatedNumber();
        $this->relatedNumberService->updateRelatedNumber($request, $article, $relatedNumber);

        session()->flash('success-message', 'Related number added.');

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
        $relatedNumber = $this->relatedNumberService->getRelatedNumberById($article, $id);

        try {
            $this->relatedNumberService->deleteRelatedNumber($relatedNumber);
            session()->flash('success-message', 'Related number deleted.');
        } catch (\Exception $e) {
            session()->flash('error-message', 'Cannot delete related number.');
        }

        return redirect(route('articles.edit', $articleId));
    }
}
