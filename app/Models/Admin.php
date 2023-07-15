<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;


class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image(){
        return $this->morphOne(Image::class , 'imageable');
    }

    public function role(){
        return $this->hasOne(Role::class,'id');
    }

    public function getLastLoginAttribute()
    {
        $lastLogin = new Carbon($this->last_login_at);
        $now = Carbon::now();

        if ($this->last_login_at == null) {
            return 'لم يسجل الدخول من قبل';
        }

        // Check if the last login was less than a minute ago
        if ($now->diffInSeconds($lastLogin) < 60) {
            return 'نشط الآن';
        }

        // Check if the last login was less than an hour ago
        if ($now->diffInMinutes($lastLogin) < 60) {
            return $now->diffInMinutes($lastLogin) . ' دقائق مضت';
        }

        // Check if the last login was less than a day ago
        if ($now->diffInHours($lastLogin) < 24) {
            return $now->diffInHours($lastLogin) . ' ساعة مضت';
        }

        // Check if the last login was less than a week ago
        if ($now->diffInDays($lastLogin) < 7) {
            return $now->diffInDays($lastLogin) . ' أيام مضت';
        }

        // Check if the last login was less than a month ago
        if ($now->diffInWeeks($lastLogin) < 4) {
            return $now->diffInWeeks($lastLogin) . ' أسابيع مضت';
        }

        // Otherwise, return the date in a readable format
        return $lastLogin->format('M jS, Y');
    }


    public function getImageUrlAttribute(){

        if ($this->image) {
            return Storage::disk('s3')->url($this->image->url);
        } else {
            return null;
        }
    }

    public function getJoinedDateAttribute()
    {
        return Carbon::parse($this->created_at)->locale('ar')->isoFormat('Do MMMM YYYY');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
    }

}

