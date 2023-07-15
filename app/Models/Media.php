<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['url','mediable_id','mediable_type'];

    protected $hidden = ['mediable_id', 'mediable_type', 'created_at', 'updated_at'];

    public function mediable(){
        return $this->morphTo();
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
