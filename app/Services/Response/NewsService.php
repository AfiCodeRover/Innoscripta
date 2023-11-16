<?php

namespace App\Services\Response;

use App\Models\News;

class NewsService
{
    public function search($searchFields) : object {
        try {
            return News::search($searchFields);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
