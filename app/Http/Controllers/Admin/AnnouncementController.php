<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('clinic.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'clinic' => 'required|string',
            'city' => 'required|string',
            'type' => 'required|in:Service,Product,Offer',
            'description' => 'nullable|string',
            'price' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $announcement = Announcement::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Announcement published successfully',
            'announcement' => $announcement
        ]);
    }
}