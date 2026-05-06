<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('clinic.announcements.index');
    }

    public function getData(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'data' => []]);
        }

        $query = Announcement::where('clinic_id', $clinic->id)->orderBy('created_at', 'desc');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $announcements = $query->paginate(15);
        return response()->json(['success' => true, 'data' => $announcements]);
    }

    public function store(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'عيادة غير موجودة'], 400);
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:info,warning,success,danger',
            'expires_at'  => 'nullable|date',
        ]);

        $data['clinic_id'] = $clinic->id;
        $announcement = Announcement::create($data);

        return response()->json(['success' => true, 'data' => $announcement]);
    }catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }


    public function destroy(Announcement $announcement): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if ($announcement->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        $announcement->delete();
        return response()->json(['success' => true]);
    }
}