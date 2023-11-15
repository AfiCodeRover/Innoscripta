<?php

namespace App\Services\Model;

use App\Models\News;

class NewsAPIDBService
{
    public function insertNews($data, $category): bool
    {
        try {
            News::updateOrCreate(
                ['url' => $data['url']],
                [
                    'title'         =>  $data['title'],
                    'category'      =>  $category,
                    'source'        =>  $data['source']['name'],
                    'author'        =>  $data['author'],
                    'url'           =>  $data['url'],
                    'body'          =>  $data['content'],
                    'publish_at'    =>  $data['publishedAt']
                ]
            );
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getNews(): object
    {
        //return data by user search
        return response()->json();
    }
}
