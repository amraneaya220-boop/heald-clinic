<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Clinic;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    public function index()
    {
        // جلب جميع المدفوعات (بدون علاقات معقدة)
        $payments = Payment::orderBy('created_at', 'desc')->get();
        
        // جلب جميع العيادات
        $clinics = Clinic::orderBy('name', 'asc')->get();
        
        // جلب جميع الإعلانات (إذا كان الجدول موجوداً)
        $ads = [];
        try {
            $ads = Ad::orderBy('title', 'asc')->get();
        } catch (\Exception $e) {
            $ads = [];
        }
        
        // إحصائيات بسيطة
        $totalPayments = Payment::count();
        $totalAmount = Payment::sum('amount') ?? 0;
        $pendingCount = Payment::where('status', 'pending')->count();
        $paidCount = Payment::where('status', 'paid')->count();
        
        return view('super_admin.payments', compact(
            'payments',
            'clinics',
            'ads',
            'totalPayments',
            'totalAmount',
            'pendingCount',
            'paidCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:clinic,ad',
            'entity_id' => 'required|integer',
            'entity_name' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        try {
            $payment = Payment::create([
                'type' => $request->type,
                'entity_id' => $request->entity_id,
                'entity_name' => $request->entity_name,
                'amount' => $request->amount,
                'due_date' => $request->due_date,
                'description' => $request->description,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment request created successfully',
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markAsPaid($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment marked as paid'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting payment: ' . $e->getMessage()
            ], 500);
        }
    }
}