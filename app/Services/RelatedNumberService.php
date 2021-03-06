<?php

namespace App\Services;

use App\Models\Article;
use App\Models\RelatedNumber;
use Exception;
use Illuminate\Http\Request;

class RelatedNumberService
{
    /**
     * @return RelatedNumber
     */
    public function getNewRelatedNumber(): RelatedNumber
    {
        return new RelatedNumber();
    }

    /**
     * @param Article $article
     * @param int $id
     * @return RelatedNumber|null
     */
    public function getRelatedNumberById(Article $article, int $id): ?RelatedNumber
    {
        /** @var RelatedNumber $relatedNumber */
        $relatedNumber = $article->related_numbers()->where('related_numbers.id', $id)->first();
        return $relatedNumber;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param RelatedNumber $relatedNumber
     * @return RelatedNumber
     */
    public function updateRelatedNumber(Request $request, Article $article, RelatedNumber $relatedNumber): RelatedNumber
    {
        $valueSearch = str_replace(ArticleService::ESCAPE_CHARACTERS, '', $request['value']);

        $relatedNumber->fill($request->all() + ['article_id' => $article->id, 'value_search' => $valueSearch]);
        $relatedNumber->save();

        return $relatedNumber;
    }

    /**
     * @param RelatedNumber $relatedNumber
     * @throws Exception
     */
    public function deleteRelatedNumber(RelatedNumber $relatedNumber)
    {
        $relatedNumber->delete();
    }
}