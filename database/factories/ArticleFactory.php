<?php

namespace Database\Factories;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Article::class;

    /**
     * @return array
     */
    public function definition()
    {
        $number = Str::random(16);
        $numberSearch = str_replace(ArticleService::ESCAPE_CHARACTERS, '', $number);

        return [
            'number' => $number,
            'number_search' => $numberSearch,
        ];
    }
}
