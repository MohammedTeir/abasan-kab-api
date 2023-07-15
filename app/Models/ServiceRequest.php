<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * Get the images associated with the service request.
    */

    protected $fillable = [
        'service_category_id',
        'service_id',
        'beneficiary_pin',
        'status',
        'rejection_reason'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

      /**
     * Get the user associated with the service request.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'beneficiary_pin', 'pin');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function getImagesUrlAttribute()
    {
        $imagesUrl = [];

        foreach ($this->images as $image) {
            $imagesUrl[] = Storage::disk('s3')->url($image->url);
        }

        return $imagesUrl;
    }
}
