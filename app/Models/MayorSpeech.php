<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MayorSpeech extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

        'deleted_at',

    ];

    public function image(){
        return $this->morphOne(Image::class , 'imageable');
    }

    public function getImageUrlAttribute(){

        if ($this->image) {
            return Storage::disk('s3')->url($this->image->url);
        } else {
            return null;
        }
    }

}
