<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];
    protected $fillable = [
        'service_category_id',
        'service_name',
        'price',
        'required_time',
        'required_documents'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }


}
