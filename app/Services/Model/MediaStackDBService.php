<?php

namespace App\Services\Model;

use App\Models\News;

class MediaStackDBService
{
    public function insertNews($data): bool
    {
        try {
            News::updateOrCreate(
                ['url' => $data['url']],
                [
                    'title'         =>  $data['title'],
                    'category'      =>  $data['category'],
                    'source'        =>  $data['source'],
                    'author'        =>  $data['author'] ?? "",
                    'url'           =>  $data['url'],
                    'body'          =>  $data['description'],
                    'publish_at'    =>  $data['published_at']
                ]
            );
            return true;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    public function getNews(): object
    {
        //return data by user search
        return response()->json();
    }
}
