<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'category',
        'source',
        'author',
        'url',
        'body',
        'publish_at'
    ];

    /**
     * Mutator for the publish_at attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setPublishAtAttribute($value)
    {
        // Set the attribute with the desired format
        $this->attributes['publish_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public static function search($searchFields): object
    {
        return static::query()
            ->where('title', 'like', '%' . $searchFields['query'] . '%')
            ->when($searchFields['category'], function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($searchFields['author'], function ($query, $author) {
                $query->where('author', 'like', '%' . $author . '%');
            })
            ->when($searchFields['source'], function ($query, $source) {
                $query->where('source', 'like', '%' . $source . '%');
            })
            ->when($searchFields['from_date'], function ($query, $from_date) {
                $from = Carbon::parse($from_date)->format("Y-m-d H:i:s");
                $query->whereDate('publish_at', '>=', $from);
            })
            ->when($searchFields['to_date'], function ($query, $to_date) {
                $to = Carbon::parse($to_date)->addDay()->format("Y-m-d H:i:s");
                $query->whereDate('publish_at', '<', $to);
            })
            ->get();
    }
}
