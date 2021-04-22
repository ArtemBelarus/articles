<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    const TEST_ARTICLE_ID = 1;

    private MockInterface $articleServiceMock;
    private Article $testArticle;

    protected function setUp(): void
    {
        parent::setUp();

        $testArticle = Article::factory()->make(['id' => self::TEST_ARTICLE_ID]);
        $this->testArticle = $testArticle;

        $this->articleServiceMock = Mockery::mock(ArticleService::class);
        app()->instance(ArticleService::class, $this->articleServiceMock);
    }

    public function testArticlesControllerIndex()
    {
        $this->articleServiceMock
            ->shouldReceive('getAllArticles')
            ->once()
            ->andReturn(new LengthAwarePaginator([], 0, 1));

        $response = $this->get(route('articles.index'));
        $response->assertStatus(200);
    }

    public function testArticlesControllerEdit()
    {
        $this->articleServiceMock
            ->shouldReceive('getArticleById')
            ->once()
            ->andReturn($this->testArticle);

        $response = $this->get(route('articles.edit', self::TEST_ARTICLE_ID));
        $response->assertStatus(200);
    }
}
