<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $clinics = Clinic::with('doctors')->get();
        $doctors = Doctor::with('clinic')->get();
        $reviews = Review::with('user')->latest()->take(10)->get();
        
        // تنقية البيانات من الرموز الضارة
        $clinics = $this->sanitizeCollection($clinics);
        $doctors = $this->sanitizeCollection($doctors);
        
        return view('front.index', compact('clinics', 'doctors', 'reviews'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $clinics = Clinic::where('name', 'like', "%$query%")->get();
        $doctors = Doctor::where('name', 'like', "%$query%")->orWhere('specialty', 'like', "%$query%")->get();
        
        $clinics = $this->sanitizeCollection($clinics);
        $doctors = $this->sanitizeCollection($doctors);
        
        return response()->json(['clinics' => $clinics, 'doctors' => $doctors]);
    }
    
    private function sanitizeCollection($collection)
    {
        foreach ($collection as $item) {
            foreach ($item->getAttributes() as $key => $value) {
                if (is_string($value)) {
                    $item->$key = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }
            }
        }
        return $collection;
    }
}