<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function apiIndex()
    {
        $doctor = Auth::user()->doctor;
        $notifications = Notification::where('user_type', 'doctor')
            ->where('user_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $unreadCount = $notifications->where('is_read', false)->count();
        return response()->json(['success' => true, 'data' => $notifications, 'unread_count' => $unreadCount]);
    }

    public function apiMarkAsRead($id)
    {
        $doctor = Auth::user()->doctor;
        $notification = Notification::where('id', $id)
            ->where('user_type', 'doctor')
            ->where('user_id', $doctor->id)
            ->firstOrFail();
        $notification->is_read = true;
        $notification->save();
        return response()->json(['success' => true]);
    }
}