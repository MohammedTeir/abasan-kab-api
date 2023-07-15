<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'is_featured' , 'is_published','tags'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'deleted_at',

    ];

    protected $casts = [
        'tags' => 'json',
    ];

    /**
     * Get the images associated with the news.
     */

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


     /**
     * Scope a query to only include published news.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeRecentlyPublished($query)
{
    return $query->orderBy('created_at', 'desc');
}

    public function getImagesUrlAttribute()
    {
        $imagesUrl = [];

        foreach ($this->images as $image) {
            $imagesUrl[] = Storage::disk('s3')->url($image->url);
        }

        return $imagesUrl;
    }



}
