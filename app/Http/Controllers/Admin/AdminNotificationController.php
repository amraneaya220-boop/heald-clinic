<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class AdminNotificationController extends Controller {
    public function index() { return view("super_admin.notifications"); }
    
    public function markAsRead($id) { return response()->json(["success"=>true]); }
    public function markAllAsRead() { return response()->json(["success"=>true]); }
    public function clearAll() { return response()->json(["success"=>true]); }
}