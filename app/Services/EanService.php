<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Ean;
use Exception;
use Illuminate\Http\Request;

class EanService
{
    /**
     * @return Ean
     */
    public function getNewEan(): Ean
    {
        return new Ean();
    }

    /**
     * @param Article $article
     * @param int $id
     * @return Ean|null
     */
    public function getEanById(Article $article, int $id): ?Ean
    {
        /** @var Ean $ean */
        $ean = $article->eans()->where('eans.id', $id)->first();
        return $ean;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param Ean $ean
     * @return Ean
     */
    public function updateEan(Request $request, Article $article, Ean $ean): Ean
    {
        $valueSearch = str_replace(ArticleService::ESCAPE_CHARACTERS, '', $request['value']);

        $ean->fill($request->all() + ['article_id' => $article->id, 'value_search' => $valueSearch]);
        $ean->save();

        return $ean;
    }

    /**
     * @param Ean $ean
     * @throws Exception
     */
    public function deleteEan(Ean $ean)
    {
        $ean->delete();
    }
}