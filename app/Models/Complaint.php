<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'complainant_pin',
        'complaint_title',
        'complaint_content',
        'status',
        'closed_at',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'complainant_pin', 'pin');
    }

    /**
     * Get the images associated with the news.
     */

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


}
