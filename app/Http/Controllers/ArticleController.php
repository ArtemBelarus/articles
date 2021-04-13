<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ArticleController extends Controller
{
    private ArticleService $articlesService;

    /**
     * ArticleController constructor.
     * @param ArticleService $articlesService
     */
    public function __construct(ArticleService $articlesService)
    {
        $this->articlesService = $articlesService;
    }

    /**
     * @param ArticleRequest $request
     * @return Factory|View
     */
    public function index(ArticleRequest $request)
    {
        $filter = [
            'number' => $request['number'],
            'code_type' => $request['code_type'],
            'code_value' => $request['code_value'],
        ];

        $articles = $this->articlesService->getAllArticles($filter);

        return view('articles.list', [
            'articles' => $articles,
            'filter' => $filter
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('articles.edit', [
            'isNew' => true,
            'article' => $this->articlesService->getNewArticle(),
            'originalCodes' => [],
            'relatedNumbers' => [],
            'eans' => [],
        ]);
    }

    /**
     * @param StoreArticleRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(StoreArticleRequest $request)
    {
        $article = $this->articlesService->getNewArticle();
        $article = $this->articlesService->updateArticle($request, $article);

        session()->flash('success-message', 'Article added.');

        return redirect(route('articles.edit', $article->id));
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $article = $this->articlesService->getArticleById($id);

        $originalCodes = $article->original_codes;
        $relatedNumbers = $article->related_numbers;
        $eans = $article->eans;

        return view('articles.edit', [
            'isNew' => false,
            'article' => $article,
            'originalCodes' => $originalCodes,
            'relatedNumbers' => $relatedNumbers,
            'eans' => $eans,
        ]);
    }

    /**
     * @param UpdateArticleRequest $request
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articlesService->getArticleById($id);
        $article = $this->articlesService->updateArticle($request, $article);

        session()->flash('success-message', 'Article saved.');

        return redirect(route('articles.edit', $article->id));
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $article = $this->articlesService->getArticleById($id);

        try {
            $this->articlesService->deleteArticle($article);
            session()->flash('success-message', 'Article deleted.');
        } catch (\Exception $e) {
            session()->flash('error-message', 'Cannot delete article.');
        }

        return redirect(route('articles.index'));
    }
}
