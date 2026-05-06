<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class NotificationController extends Controller
{
    private function getPatient()
    {
        return Patient::where('user_id', Auth::id())->firstOrFail();
    }
    
    public function apiIndex()
    {
        $patient = $this->getPatient();
        $notifications = Notification::where('user_type', 'patient')
            ->where('user_id', $patient->user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $unreadCount = $notifications->where('is_read', false)->count();
        
        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    public function apiMarkAsRead($id)
    {
        $patient = $this->getPatient();
        $notification = Notification::where('id', $id)
            ->where('user_type', 'patient')
            ->where('user_id', $patient->user_id)
            ->firstOrFail();
        
        $notification->is_read = true;
        $notification->save();
        
        return response()->json(['success' => true]);
    }
    
    public function apiMarkAllAsRead()
    {
        $patient = $this->getPatient();
        Notification::where('user_type', 'patient')
            ->where('user_id', $patient->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }
    
    public function apiClearAll()
    {
        $patient = $this->getPatient();
        Notification::where('user_type', 'patient')
            ->where('user_id', $patient->user_id)
            ->delete();
        
        return response()->json(['success' => true]);
    }
}