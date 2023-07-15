<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'cover_image'];
    protected $hidden = ['created_at', 'updated_at'];


    /**
     * Get all of the images models associated with the album.
     */
    public function images()
    {
        return $this->morphMany(Media::class, 'mediable');
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
