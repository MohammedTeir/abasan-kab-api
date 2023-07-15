<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function index()
    {
        // Retrieve all notifications
        $notifications = Notification::all();

        return response()->view('notifications',compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        // Find the notification by ID

        if (!$notification) {
            return response()->json([
                'message' => 'الاٍشعار غير موجود.',
            ], 404);
        }

        // Mark the notification as read
        $notification->is_read = true;
        $notification->save();

        return response()->json([
            'message' => 'تم تحديد الإشعار كمقروء.',
        ], 200);
    }



    public function clearAllNotifications()
    {

         // Clear all notifications for the user
        Notification::truncate();

        return response()->json([
            'message' => 'تم مسح جميع الإشعارات بنجاح.',
        ], 200);
    }
}
