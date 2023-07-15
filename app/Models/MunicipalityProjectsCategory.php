<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalityProjectsCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['created_at','updated_at'];

     /**
     * Get the projects associated with the category.
     */
    public function projects()
    {
        return $this->hasMany(MunicipalityProject::class, 'category_id');
    }


}
