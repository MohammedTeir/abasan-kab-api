<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_pin',
        'message',
        'is_read',
    ];

    /**
     * Get the user associated with the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_pin', 'pin');
    }

    public function getNotificationTimeAttribute()
    {
        $notificationTime = new Carbon($this->created_at);
        $now = Carbon::now();



        // Check if the last login was less than a minute ago
        if ($now->diffInSeconds($notificationTime) < 60) {
            return 'الآن';
        }

        // Check if the last login was less than an hour ago
        if ($now->diffInMinutes($notificationTime) < 60) {
            return $now->diffInMinutes($notificationTime) . ' دقائق مضت';
        }

        // Check if the last login was less than a day ago
        if ($now->diffInHours($notificationTime) < 24) {
            return $now->diffInHours($notificationTime) . ' ساعة مضت';
        }

        // Check if the last login was less than a week ago
        if ($now->diffInDays($notificationTime) < 7) {
            return $now->diffInDays($notificationTime) . ' أيام مضت';
        }

        // Check if the last login was less than a month ago
        if ($now->diffInWeeks($notificationTime) < 4) {
            return $now->diffInWeeks($notificationTime) . ' أسابيع مضت';
        }

        // Otherwise, return the date in a readable format
        return $notificationTime->format('M jS, Y');
    }
}
