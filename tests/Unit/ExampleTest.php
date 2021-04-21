<?php

namespace Tests\Unit;

use App\Services\ArticleService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testArticlesController()
    {
        $service = Mockery::mock(ArticleService::class);
        app()->instance(\App\Services\ArticleService::class, $service);

        $service
            ->shouldReceive('getAllArticles')
            ->once()
            ->andReturn(new LengthAwarePaginator([], 0, 1));

        $response = $this->get(route('articles.index'));
        $response->assertStatus(200);
    }
}
