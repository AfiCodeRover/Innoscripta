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
}
