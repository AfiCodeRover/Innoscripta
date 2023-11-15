<?php

namespace App\Services\Fetch;

use App\Services\Contract\FetchServiceContract;
use App\Utilities\DateFormatter;
use Illuminate\Support\Facades\Http;

class GuardianAPIService implements FetchServiceContract
{
    use DateFormatter;

    // The API key for the NewsAPI
    private $apiKey;

    // The base URL for the NewsAPI
    private $baseUrl = 'https://content.guardianapis.com';

    // The mock object for the NewsAPI service
    private $mockNewsApiService;

    // The constructor that accepts the API key and the mock object
    public function __construct(string $apiKey, $mockNewsApiService = null)
    {
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
            $endpoint = '/search';

            // The query parameters for the request
            $query = [
                'show-fields' => 'byline,bodyText',
                'from-date' => strval($date['from']),
                'to-date'   =>  strval($date['to']),
                'sortBy'   =>   'publishedAt',
                'api-key' => $this->apiKey,
            ];

            // Send a GET request to the NewsAPI and get the response
            $response = Http::get($this->baseUrl . $endpoint, $query);

            // Return the data and status code from the response
            return [
                'data' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            // Handle connection errors and return a 502 status code
            return [
                'status' => 502,
                'message' => __("error.api.502", ['APIName' => 'Guardian'])
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
