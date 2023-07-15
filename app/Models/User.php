<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;


use function PHPSTORM_META\map;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable  , SoftDeletes ;


    protected $primaryKey='pin';

    /**
     * Find the user instance for the given username.
     */
    public function findForPassport(string $username): User
    {
        return $this->where('pin', $username)->first();
    }

       /**
     * Validate the password of the user for the Passport password grant.
     */
    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

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
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'activation_code',
        'status',

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
            return "https://cdn-icons-png.flaticon.com/512/1144/1144760.png";
        }
    }


    public function getJoinedDateAttribute()
    {
        return $this->created_at->format('d M Y, g:i a');
    }

    public function getLastLoginFormatAttribute()
    {
        $datetime = new DateTime($this->last_login_at);
        return $datetime->format('d M Y, g:i a');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
    }

    /**
     * Get the service requests associated with the user.
     */
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'beneficiary_pin', 'pin');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'complainant_pin', 'pin');
    }

}
