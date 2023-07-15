<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MunicipalitySetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'telephone_number',
        'mobile_number',
        'email',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'youtube'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'created_at',
        'updated_at',
        'deleted_at',

    ];

    /**
     * Get the images associated with the municipality setting.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getImagesUrlAttribute()
    {
    $imageUrls = [];

    foreach ($this->images as $image) {
        $imageUrls[] = Storage::disk('s3')->url($image->url);
    }

    return $imageUrls;
    }

}
