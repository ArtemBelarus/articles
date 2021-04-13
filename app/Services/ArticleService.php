<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;

class ArticleService
{
    const PAGE_SIZE = 20;
    const ESCAPE_CHARACTERS = [' ', '.', '-'];

    /**
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function getAllArticles(array $filter = []): LengthAwarePaginator
    {
        $qb = Article::query()->orderBy('id', 'ASC');

        if (!empty($filter['number'])) {
            $number = str_replace(self::ESCAPE_CHARACTERS, '', $filter['number']);
            $qb->where('number_search', 'LIKE', $number . '%');
        }

        if (!empty($filter['code_value']) && !empty($filter['code_type'])) {
            $codeValue = str_replace(self::ESCAPE_CHARACTERS, '', $filter['code_value']);
            $codeType = $filter['code_type'];

            $qb->whereIn('articles.id', function ($q) use ($codeValue, $codeType) {
                $q->select('article_id')->from($codeType)->where('value_search', $codeValue);
            });
        }

        return $qb->paginate(self::PAGE_SIZE);
    }

    /**
     * @return Article
     */
    public function getNewArticle(): Article
    {
        return new Article();
    }

    /**
     * @param int $id
     * @return Article
     */
    public function getArticleById(int $id): Article
    {
        /** @var Article $article */
        $article = Article::query()->find($id);

        if (empty($article)) {
            Redirect::back()->with('error-message', 'Article not found.')->send();
        }

        return $article;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return Article
     */
    public function updateArticle(Request $request, Article $article): Article
    {
        $numberSearch = str_replace(self::ESCAPE_CHARACTERS, '', $request['number']);

        $article->fill($request->all() + ['number_search' => $numberSearch]);
        $article->save();

        return $article;
    }

    /**
     * @param Article $article
     * @throws \Exception
     */
    public function deleteArticle(Article $article)
    {
        // delete related codes here, because myisam = no foreign
        $article->original_codes()->delete();
        $article->related_numbers()->delete();
        $article->eans()->delete();

        $article->delete();
    }
}
