<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>  $this->id,
            'title'         =>  $this->title,
            'author'        =>  ucfirst($this->author),
            'category'      =>  $this->category,
            'source'        =>  $this->source,
            'content'       =>  $this->body,
            'reference_url' =>  $this->url,
            'publish_date'  =>  $this->publish_at
        ];
    }
}
