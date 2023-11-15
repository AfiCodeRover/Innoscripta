<?php

namespace Tests\Feature\APIs\NewsAPI;

use App\Services\Fetch\NewsAPIService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class FetchDataTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fetch_latest_news(): void
    {
        // Create a mock object for the NewsAPI service
        $mockNewsApiService = Mockery::mock(NewsApiService::class)->makePartial();

        // Define the mocked response from the NewsAPI
        $mockNewsApiService->shouldReceive('fetchLatestNews')
            ->andReturn([
                'sport' =>  [
                    'data'  =>  [
                        'source'    =>  [
                            "id" => null,
                            "name"  =>  "test.com"
                        ],
                        'title' => 'Mock Article Title 1',
                        'author' => 'Mock Author 1',
                        'description' => 'Mock Article Description 1',
                        'url' => 'https://mock-article-url-1',
                        'publishedAt' => '2023-11-14T18:50:00Z',
                    ],
                    'status'    =>  200
                ],
                'tech'  =>  [
                    'data'  =>  [
                        'source'    =>  [
                            "id" => null,
                            "name"  =>  "test2.com"
                        ],
                        'title' => 'Mock Article Title 2',
                        'author' => 'Mock Author 2',
                        'description' => 'Mock Article Description 2',
                        'url' => 'https://mock-article-url-2',
                        'publishedAt' => '2023-11-14T18:55:00Z',
                    ],
                    'status'    =>  200
                ],
            ]);
        // Create an instance of the NewsApiService class with the mock object
        $newsApiService = new NewsAPIService(env("NEWSAPI_KEY"), $mockNewsApiService);

        // Call the fetchLatestNews() method and collect the result
        $latestNews = $newsApiService->fetchLatestNews();

        // Assert that the returned data is as expected
        $this->assertNotEmpty($latestNews);
        $this->assertCount(2, $latestNews);

        $article = $latestNews['sport']['data'];
        

        $this->assertEquals('test.com', $article['source']['name']);

        $this->assertArrayHasKey('source', $article);
        $this->assertEquals('test.com', $article['source']['name']);

        $this->assertArrayHasKey('title', $article);
        $this->assertEquals('Mock Article Title 1', $article['title']);
        $this->assertArrayHasKey('author', $article);
        $this->assertEquals('Mock Author 1', $article['author']);
        $this->assertArrayHasKey('description', $article);
        $this->assertEquals('Mock Article Description 1', $article['description']);
        $this->assertArrayHasKey('url', $article);
        $this->assertEquals('https://mock-article-url-1', $article['url']);
        $this->assertArrayHasKey('publishedAt', $article);
        $this->assertEquals('2023-11-14T18:50:00Z', $article['publishedAt']);
    }
}
