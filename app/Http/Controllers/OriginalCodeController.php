<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOriginalCodeRequest;
use App\Models\Article;
use App\Services\ArticleService;
use App\Services\OriginalCodeService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class OriginalCodeController
{
    private ArticleService $articlesService;
    private OriginalCodeService $originalCodeService;

    /**
     * OriginalCodeController constructor.
     * @param ArticleService $articlesService
     * @param OriginalCodeService $originalCodeService
     */
    public function __construct(ArticleService $articlesService, OriginalCodeService $originalCodeService)
    {
        $this->articlesService = $articlesService;
        $this->originalCodeService = $originalCodeService;
    }

    /**
     * @param StoreOriginalCodeRequest $request
     * @param Article $article
     * @return RedirectResponse|Redirector
     */
    public function store(StoreOriginalCodeRequest $request, Article $article)
    {
        $originalCode = $this->originalCodeService->getNewOriginalCode();
        $this->originalCodeService->updateOriginalCode($request, $article, $originalCode);

        session()->flash('success-message', 'Original code added.');

        return redirect(route('articles.edit', $article->id));
    }

    /**
     * @param Article $article
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy(Article $article, int $id)
    {
        $originalCode = $this->originalCodeService->getOriginalCodeById($article, $id);
        if (empty($originalCode)) {
            return back()->with('error-message', 'Original code not found.');
        }

        try {
            $this->originalCodeService->deleteOriginalCode($originalCode);
            session()->flash('success-message', 'Original code deleted.');
        } catch (Exception $e) {
            session()->flash('error-message', 'Cannot delete original code.');
        }

        return redirect(route('articles.edit', $article->id));
    }
}
