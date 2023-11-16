<?php

namespace App\Services\Fetch;

use App\Services\Contract\FetchServiceContract;
use App\Utilities\DateFormatter;
use Illuminate\Support\Facades\Http;

class NewsAPIService implements FetchServiceContract
{
    use DateFormatter;

    // Some NewsAPI categories
    private const CATEGORY = ['business', 'technology'];
    
    // The API key for the NewsAPI
    private $apiKey;

    // The base URL for the NewsAPI
    private $baseUrl = 'https://newsapi.org/v2';

    // The mock object for the NewsAPI service
    private $mockNewsApiService;

    // The setter that accepts the API key and the mock object
    public function setCredentials(string $apiKey, $mockNewsApiService = null) : void {
        $this->apiKey = $apiKey;
        $this->mockNewsApiService = $mockNewsApiService;
    }

    // The method that fetches the latest news from the NewsAPI
    public function fetchLatestNews()
    {
        try {
            // If the mock object is not null, use it to return the mocked response
            if ($this->mockNewsApiService) {
                return $this->mockNewsApiService->fetchLatestNews();
            }
            $data = [];
            $date = DateFormatter::dateFormat();
            // dd($date);
            foreach (self::CATEGORY as $category) {
                // Otherwise, use the HTTP client to send a real request to the NewsAPI
                // The endpoint for the latest news
                $endpoint = '/everything';

                // The query parameters for the request
                $query = [
                    'q' => $category,
                    'from' => strval($date['from']),
                    'to'   =>  strval($date['to']),
                    'sortBy'   =>   'publishedAt',
                    'apiKey' => $this->apiKey,
                ];

                // Send a GET request to the NewsAPI and get the response
                $response = Http::get($this->baseUrl . $endpoint, $query);

                $data[$category] = [
                    'data' => $response->json(),
                    'status' => $response->status()
                ];
            }

            // Return the data and status code from the response
            return $data;
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            // Handle connection errors and return a 502 status code
            return [
                'status' => 502,
                'message' => __("error.api.502", ['APIName' => 'NewsAPI'])
            ];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle request-related errors and return a 500 status code
            return [
                'status' => 500,
                'message' => __('error.api.500')
            ];
        } catch (\Throwable $e) {
            // Handle generic exceptions and return a 500 status code
            return [
                'status' => 500,
                'message' => __('error.unexpected')
            ];
        }
    }
}
