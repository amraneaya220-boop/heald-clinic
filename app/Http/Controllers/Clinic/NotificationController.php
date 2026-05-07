<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('clinic.notifications.index');
    }

    public function getData(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'data' => []]);
        }

        $doctorIds = \App\Models\Doctor::where('clinic_id', $clinic->id)->pluck('id');
        $query = Notification::whereIn('doctor_id', $doctorIds);

        $notifications = $query->orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = (clone $query)->where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    public function markAsRead(Notification $notification): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctorIds = \App\Models\Doctor::where('clinic_id', $clinic->id)->pluck('id');
        if (!in_array($notification->doctor_id, $doctorIds->toArray())) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        $notification->is_read = true;
        $notification->save();
        return response()->json(['success' => true]);
    }

    public function markAllAsRead(): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctorIds = \App\Models\Doctor::where('clinic_id', $clinic->id)->pluck('id');
        Notification::whereIn('doctor_id', $doctorIds)->where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function clearAll(): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctorIds = \App\Models\Doctor::where('clinic_id', $clinic->id)->pluck('id');
        Notification::whereIn('doctor_id', $doctorIds)->delete();
        return response()->json(['success' => true]);
    }

    public function unreadCount(): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctorIds = \App\Models\Doctor::where('clinic_id', $clinic->id)->pluck('id');
        $count = Notification::whereIn('doctor_id', $doctorIds)->where('is_read', false)->count();
        return response()->json(['success' => true, 'count' => $count]);
    }
    public function pendingApproval()
    {
        return view('clinic.pending_approval');
    }
}