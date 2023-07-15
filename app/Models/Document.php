<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document_path',
        'document_category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
    return $this->belongsTo(DocumentCategory::class,'document_category_id');
    }



    public function getDocUrlAttribute(){

        if ($this->document_path) {
            return Storage::disk('s3')->url($this->document_path);
        } else {
            return null;
        }
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d M Y, g:i a');
    }

}
