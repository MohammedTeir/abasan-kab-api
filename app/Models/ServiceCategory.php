<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['name', 'description'];

    /**
     * Get the services associated with the service category.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
