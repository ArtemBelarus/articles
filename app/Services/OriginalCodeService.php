<?php

namespace App\Services;

use App\Models\Article;
use App\Models\OriginalCode;
use Exception;
use Illuminate\Http\Request;

class OriginalCodeService
{
    /**
     * @return OriginalCode
     */
    public function getNewOriginalCode(): OriginalCode
    {
        return new OriginalCode();
    }

    /**
     * @param Article $article
     * @param int $id
     * @return OriginalCode|null
     */
    public function getOriginalCodeById(Article $article, int $id): ?OriginalCode
    {
        /** @var OriginalCode $originalCode */
        $originalCode = $article->original_codes()->where('original_codes.id', $id)->first();
        return $originalCode;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param OriginalCode $originalCode
     * @return OriginalCode
     */
    public function updateOriginalCode(Request $request, Article $article, OriginalCode $originalCode): OriginalCode
    {
        $valueSearch = str_replace(ArticleService::ESCAPE_CHARACTERS, '', $request['value']);

        $originalCode->fill($request->all() + ['article_id' => $article->id, 'value_search' => $valueSearch]);
        $originalCode->save();

        return $originalCode;
    }

    /**
     * @param OriginalCode $originalCode
     * @throws Exception
     */
    public function deleteOriginalCode(OriginalCode $originalCode)
    {
        $originalCode->delete();
    }
}