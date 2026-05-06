<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        // جلب جميع الحجوزات مع العلاقات المرتبطة بها
        $bookings = Booking::with(['clinic', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // إحصائيات إضافية
        $totalBookings = Booking::count();
        $totalRevenue = Booking::sum('amount') ?? 0;
        $totalCommission = Booking::sum('commission') ?? 0;
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        
        return view('super_admin.bookings', compact(
            'bookings',
            'totalBookings',
            'totalRevenue',
            'totalCommission',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        try {
            $booking = Booking::findOrFail($id);
            $booking->status = $request->status;
            $booking->save();

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            return response()->json([
                'success' => true,
                'message' => 'Booking deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['clinic', 'doctor'])->findOrFail($id);
        return view('super_admin.booking-details', compact('booking'));
    }

    public function export()
    {
        $bookings = Booking::with(['clinic', 'doctor'])->get();
        
        // تصدير إلى CSV
        $filename = 'bookings_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w');
        
        // إضافة رؤوس الأعمدة
        fputcsv($handle, ['ID', 'Patient Name', 'Clinic', 'Doctor', 'Date', 'Amount', 'Commission', 'Status']);
        
        // إضافة البيانات
        foreach ($bookings as $booking) {
            fputcsv($handle, [
                $booking->id,
                $booking->patient_name,
                $booking->clinic->name ?? 'N/A',
                $booking->doctor->name ?? 'N/A',
                $booking->appointment_date,
                $booking->amount,
                $booking->commission,
                $booking->status
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}