<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::with('doctors', 'reviews')->paginate(10);
        return view('front.clinics', compact('clinics'));
    }
    public function show($id)
    {
       $clinic = Clinic::with('doctors', 'reviews', 'services')->findOrFail($id);
        return view('front.clinic', compact('clinic'));
    }

    public function details($id)
    {
        $clinic = Clinic::with('doctors', 'reviews.user','services')->findOrFail($id);
        return view('front.details', compact('clinic'));
    }
    public function doctors($id)
    {
        $clinic = Clinic::with('doctors')->findOrFail($id);
        $doctors = $clinic->doctors;
        return view('front.doctors', compact('clinic', 'doctors'));
    }

    // API
    public function apiIndex()
    {
        return response()->json(['success' => true, 'data' => Clinic::all()]);
    }

    public function apiShow($id)
    {
        return response()->json(['success' => true, 'data' => Clinic::with('doctors')->findOrFail($id)]);
    }
    public function getStats(Clinic $clinic)
{
    $averageRating = $clinic->reviews()->avg('rating');
    $reviewCount = $clinic->reviews()->count();

    return response()->json([
        'success' => true,
        'average_rating' => round($averageRating, 1),
        'review_count' => $reviewCount
    ]);
}
// إضافة دالة list إذا لم تكن موجودة
public function list()
{
    $clinics = Clinic::with('doctors', 'reviews')->paginate(12);
    return view('front.clinics-list', compact('clinics'));
}

// إضافة دالة getStats للتقييمات

}