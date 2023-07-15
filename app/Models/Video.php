<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the associated media for the video.
     */
    public function video()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

}
