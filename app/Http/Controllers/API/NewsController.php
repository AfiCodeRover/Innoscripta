<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\NewsSearchRequest;
use App\Http\Resources\NewsResource;
use App\Services\Response\NewsService;

class NewsController extends Controller
{
    public function search(NewsSearchRequest $newsSearchRequest, NewsService $newsService)
    {
        $result = $newsService->search($newsSearchRequest);
        $collection = NewsResource::collection($result);
        return response([
            'results'   =>  $collection->count(),
            'data'      =>  $collection
        ]);
    }
}
