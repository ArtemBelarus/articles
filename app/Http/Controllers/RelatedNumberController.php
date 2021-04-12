<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRelatedNumberRequest;
use App\Services\ArticleService;
use App\Services\RelatedNumberService;

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

    public function store(StoreRelatedNumberRequest $request, int $article_id)
    {
        $article = $this->articlesService->getArticleById($article_id);
        $relatedNumber = $this->relatedNumberService->getNewRelatedNumber();
        $this->relatedNumberService->updateRelatedNumber($request, $article, $relatedNumber);

        session()->flash('success-message', 'Related number added.');

        return redirect(route('articles.edit', $article->id));
    }

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
