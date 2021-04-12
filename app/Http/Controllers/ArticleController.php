<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleService;

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

    public function store(StoreArticleRequest $request)
    {
        $article = $this->articlesService->getNewArticle();
        $article = $this->articlesService->updateArticle($request, $article);

        session()->flash('success-message', 'Article added.');

        return redirect(route('articles.edit', $article->id));
    }

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

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = $this->articlesService->getArticleById($id);
        $article = $this->articlesService->updateArticle($request, $article);

        session()->flash('success-message', 'Article saved.');

        return redirect(route('articles.edit', $article->id));
    }

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
