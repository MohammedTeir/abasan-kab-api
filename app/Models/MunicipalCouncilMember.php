<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MunicipalCouncilMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'position', 'mobile_number', 'cv_path',
    ];

    protected $hidden = [
        'created_at', 'updated_at',
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

    public function getCvUrlAttribute(){

        if ($this->cv_path) {
            return Storage::disk('s3')->url($this->cv_path);
        } else {
            return null;
        }
    }
}
