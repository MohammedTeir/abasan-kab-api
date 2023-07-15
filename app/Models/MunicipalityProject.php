<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MunicipalityProject extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'category_id', 'status'];

    /**
     * Get the category associated with the project.
     */
    public function category()
    {
        return $this->belongsTo(MunicipalityProjectsCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getImagesUrlAttribute()
    {
        $imagesUrl = [];

        foreach ($this->images as $image) {
            $imagesUrl[] = Storage::disk('s3')->url($image->url);
        }

        return $imagesUrl;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d M Y, g:i a');
    }


}
