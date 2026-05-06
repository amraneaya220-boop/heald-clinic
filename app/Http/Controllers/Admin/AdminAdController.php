<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminAdController extends Controller
{
    public function index()
    {
        // جلب جميع الإعلانات
        $ads = Ad::orderBy('created_at', 'desc')->get();
        
        // إحصائيات الإعلانات
        $activeAds = Ad::where('status', 'active')->count();
        $inactiveAds = Ad::where('status', 'inactive')->count();
        $totalAds = Ad::count();
        
        return view('super_admin.ads', compact('ads', 'activeAds', 'inactiveAds', 'totalAds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video',
            'url' => 'required|url',
            'link' => 'nullable|url',
            'expiry_date' => 'required|date',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $ad = Ad::create([
                'title' => $request->title,
                'type' => $request->type,
                'url' => $request->url,
                'link' => $request->link,
                'expiry_date' => $request->expiry_date,
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Advertisement added successfully',
                'ad' => $ad
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding advertisement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $ad = Ad::findOrFail($id);
            $ad->status = $request->status;
            $ad->save();

            return response()->json([
                'success' => true,
                'message' => 'Advertisement status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating advertisement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ad = Ad::findOrFail($id);
            $ad->delete();

            return response()->json([
                'success' => true,
                'message' => 'Advertisement deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting advertisement: ' . $e->getMessage()
            ], 500);
        }
    }
}