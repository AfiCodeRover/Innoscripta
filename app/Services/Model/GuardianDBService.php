<?php

namespace App\Services\Model;

use App\Models\News;

class GuardianDBService
{
    public function insertNews($data): bool
    {
        try {
            News::updateOrCreate(
                ['url' => $data['webUrl']],
                [
                    'title'         =>  $data['webTitle'],
                    'category'      =>  $data['pillarName'],
                    'source'        =>  'Guardian',
                    'author'        =>  $data['fields']['byline'],
                    'url'           =>  $data['webUrl'],
                    'body'          =>  $data['fields']['bodyText'],
                    'publish_at'    =>  $data['webPublicationDate']
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
