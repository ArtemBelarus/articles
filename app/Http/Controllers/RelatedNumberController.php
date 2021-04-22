<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRelatedNumberRequest;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\RelatedNumberService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RelatedNumberController
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
     * @param Article $article
     * @return RedirectResponse|Redirector
     */
    public function store(StoreRelatedNumberRequest $request, Article $article)
    {
        $relatedNumber = $this->relatedNumberService->getNewRelatedNumber();
        $this->relatedNumberService->updateRelatedNumber($request, $article, $relatedNumber);

        session()->flash('success-message', 'Related number added.');

        return redirect(route('articles.edit', $article->id));
    }

    /**
     * @param Article $article
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy(Article $article, int $id)
    {
        $relatedNumber = $this->relatedNumberService->getRelatedNumberById($article, $id);
        if (empty($relatedNumber)) {
            return back()->with('error-message', 'Related number not found.');
        }

        try {
            $this->relatedNumberService->deleteRelatedNumber($relatedNumber);
            session()->flash('success-message', 'Related number deleted.');
        } catch (Exception $e) {
            session()->flash('error-message', 'Cannot delete related number.');
        }

        return redirect(route('articles.edit', $article->id));
    }
}
