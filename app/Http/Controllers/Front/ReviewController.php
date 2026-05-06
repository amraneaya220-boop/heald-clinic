<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ✅ إضافة review (web)
    public function store(Request $request)
    {
        $data = $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        $data['patient_name'] = Auth::check() ? Auth::user()->name : 'Guest';
        $data['review_date'] = now();

        Review::create($data);

        return back()->with('success', 'Thank you for your review!');
    }

    // ✅ API: جلب reviews تاع clinic
    public function apiGet($id)
    {
        $reviews = Review::where('clinic_id', $id)
            ->latest('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    // ✅ API: إضافة review
    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string'
        ]);

        $data['patient_name'] = Auth::check() ? Auth::user()->name : 'Guest';
        $data['review_date'] = now();

        $review = Review::create($data);

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    // (اختياري) نفس apiGet لكن بالquery
    public function getReviews(Request $request)
    {
        return $this->apiGet($request->query('id'));
    }
    public function getClinicReviews(Clinic $clinic)
    {
        $reviews = $clinic->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $reviews->items(),
            'total' => $reviews->total()
        ]);
    }
}