<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MunicipalityAbout extends Model
{
    use HasFactory;

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
