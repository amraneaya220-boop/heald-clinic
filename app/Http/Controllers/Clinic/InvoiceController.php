<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\ClinicSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * عرض صفحة الفواتير
     */
    public function index()
    {
        $clinic = Auth::user();
        $settings = ClinicSetting::where('clinic_id', $clinic->id)->first();
        
        return view('clinic.invoices.index', compact('clinic', 'settings'));
    }

    /**
     * جلب بيانات الفواتير مع الفلاتر
     */
    public function getInvoicesData(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $status = $request->get('status', 'all');
            $start_date = $request->get('start_date', '');
            $end_date = $request->get('end_date', '');
            
            $invoices = Invoice::where('clinic_id', Auth::id())
                ->when($search, function($query, $search) {
                    return $query->where('invoice_number', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%")
                        ->orWhere('patient_phone', 'like', "%{$search}%");
                })
                ->when($status !== 'all', function($query) use ($status) {
                    return $query->where('payment_status', $status);
                })
                ->when($start_date, function($query) use ($start_date) {
                    return $query->whereDate('appointment_date', '>=', $start_date);
                })
                ->when($end_date, function($query) use ($end_date) {
                    return $query->whereDate('appointment_date', '<=', $end_date);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
            // حساب الإحصائيات
            $totalRevenue = Invoice::where('clinic_id', Auth::id())->sum('total_amount');
            $pendingPayments = Invoice::where('clinic_id', Auth::id())->where('payment_status', 'pending')->sum('total_amount');
            $paidPayments = Invoice::where('clinic_id', Auth::id())->where('payment_status', 'paid')->sum('total_amount');
            $averageInvoice = Invoice::where('clinic_id', Auth::id())->avg('total_amount') ?? 0;
            
            $stats = [
                'total_invoices' => Invoice::where('clinic_id', Auth::id())->count(),
                'total_revenue' => number_format($totalRevenue, 2),
                'pending_payments' => number_format($pendingPayments, 2),
                'paid_payments' => number_format($paidPayments, 2),
                'average_invoice' => number_format($averageInvoice, 2),
                'pending_count' => Invoice::where('clinic_id', Auth::id())->where('payment_status', 'pending')->count(),
                'paid_count' => Invoice::where('clinic_id', Auth::id())->where('payment_status', 'paid')->count(),
                'cancelled_count' => Invoice::where('clinic_id', Auth::id())->where('payment_status', 'cancelled')->count(),
            ];
            
            // تنسيق البيانات للواجهة
            $formattedInvoices = $invoices->map(function($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'patient_name' => $invoice->patient_name,
                    'patient_phone' => $invoice->patient_phone,
                    'doctor_name' => $invoice->doctor_name,
                    'appointment_date' => $invoice->appointment_date,
                    'appointment_time' => $invoice->appointment_time,
                    'consultation_type' => $invoice->consultation_type,
                    'consultation_fee' => number_format($invoice->consultation_fee, 2),
                    'lab_fee' => number_format($invoice->lab_fee, 2),
                    'extra_fee' => number_format($invoice->extra_fee, 2),
                    'total_amount' => number_format($invoice->total_amount, 2),
                    'payment_method' => $invoice->payment_method,
                    'payment_status' => $invoice->payment_status,
                    'created_at' => $invoice->created_at->format('Y-m-d H:i:s'),
                ];
            });
            
            return response()->json([
                'success' => true,
                'data' => $formattedInvoices,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            Log::error('getInvoicesData error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * إنشاء فاتورة جديدة
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'invoice_number' => 'required|string|unique:invoices,invoice_number',
                'patient_name' => 'required|string|max:255',
                'patient_phone' => 'required|string|max:20',
                'doctor_name' => 'required|string|max:255',
                'appointment_date' => 'required|date',
                'appointment_time' => 'required|string',
                'consultation_type' => 'nullable|string|max:255',
                'consultation_fee' => 'required|numeric|min:0',
                'lab_fee' => 'required|numeric|min:0',
                'extra_fee' => 'required|numeric|min:0',
                'total_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|in:cash,card,bank_transfer,insurance',
                'payment_status' => 'required|in:pending,paid,cancelled',
                'notes' => 'nullable|string',
            ]);
            
            $validated['clinic_id'] = Auth::id();
            
            $invoice = Invoice::create($validated);
            
            // تسجيل النشاط
            Log::info('New invoice created', [
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'clinic_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الفاتورة بنجاح',
                'data' => $invoice
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('store invoice error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الفاتورة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث حالة الدفع
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $invoice = Invoice::where('clinic_id', Auth::id())->findOrFail($id);
            
            $request->validate([
                'payment_status' => 'required|in:pending,paid,cancelled'
            ]);
            
            $oldStatus = $invoice->payment_status;
            $invoice->update(['payment_status' => $request->payment_status]);
            
            Log::info('Invoice payment status updated', [
                'invoice_id' => $invoice->id,
                'old_status' => $oldStatus,
                'new_status' => $request->payment_status,
                'clinic_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الدفع بنجاح',
                'data' => $invoice
            ]);
            
        } catch (\Exception $e) {
            Log::error('updatePaymentStatus error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث حالة الدفع'
            ], 500);
        }
    }

    /**
     * حذف فاتورة
     */
    public function destroy($id)
    {
        try {
            $invoice = Invoice::where('clinic_id', Auth::id())->findOrFail($id);
            $invoiceNumber = $invoice->invoice_number;
            $invoice->delete();
            
            Log::info('Invoice deleted', [
                'invoice_id' => $id,
                'invoice_number' => $invoiceNumber,
                'clinic_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الفاتورة بنجاح'
            ]);
            
        } catch (\Exception $e) {
            Log::error('destroy invoice error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الفاتورة'
            ], 500);
        }
    }
    
    /**
     * تحديث إعدادات العيادة
     */
    public function updateSettings(Request $request)
    {
        try {
            $validated = $request->validate([
                'clinic_name' => 'required|string|max:255',
                'clinic_address' => 'nullable|string',
                'clinic_phone' => 'nullable|string|max:20',
                'clinic_email' => 'nullable|email|max:255',
                'clinic_hours' => 'nullable|string',
                'vat_percentage' => 'nullable|numeric|min:0|max:100',
                'currency' => 'nullable|string|size:3',
                'invoice_footer' => 'nullable|string',
            ]);
            
            $validated['clinic_id'] = Auth::id();
            
            $settings = ClinicSetting::updateOrCreate(
                ['clinic_id' => Auth::id()],
                $validated
            );
            
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الإعدادات بنجاح',
                'data' => $settings
            ]);
            
        } catch (\Exception $e) {
            Log::error('updateSettings error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الإعدادات'
            ], 500);
        }
    }
    
    /**
     * جلب إحصائيات إضافية للوحة التحكم
     */
    public function getStats(Request $request)
    {
        try {
            $period = $request->get('period', 'month'); // month, year, all
            
            $query = Invoice::where('clinic_id', Auth::id());
            
            if ($period === 'month') {
                $query->whereMonth('created_at', now()->month);
            } elseif ($period === 'year') {
                $query->whereYear('created_at', now()->year);
            }
            
            $stats = [
                'total_revenue' => number_format($query->sum('total_amount'), 2),
                'total_invoices' => $query->count(),
                'average_invoice' => number_format($query->avg('total_amount') ?? 0, 2),
                'paid_amount' => number_format((clone $query)->where('payment_status', 'paid')->sum('total_amount'), 2),
                'pending_amount' => number_format((clone $query)->where('payment_status', 'pending')->sum('total_amount'), 2),
                'paid_count' => (clone $query)->where('payment_status', 'paid')->count(),
                'pending_count' => (clone $query)->where('payment_status', 'pending')->count(),
                'cancelled_count' => (clone $query)->where('payment_status', 'cancelled')->count(),
            ];
            
            // جلب آخر 5 فواتير
            $recentInvoices = Invoice::where('clinic_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($invoice) {
                    return [
                        'id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'patient_name' => $invoice->patient_name,
                        'total_amount' => number_format($invoice->total_amount, 2),
                        'payment_status' => $invoice->payment_status,
                        'created_at' => $invoice->created_at->format('Y-m-d')
                    ];
                });
            
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'recent_invoices' => $recentInvoices
            ]);
            
        } catch (\Exception $e) {
            Log::error('getStats error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * إنشاء رقم فاتورة تلقائي
     */
    public function generateInvoiceNumber()
    {
        try {
            $lastInvoice = Invoice::where('clinic_id', Auth::id())
                ->orderBy('id', 'desc')
                ->first();
            
            if ($lastInvoice && preg_match('/(\d+)$/', $lastInvoice->invoice_number, $matches)) {
                $lastNumber = intval($matches[1]);
                $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '00001';
            }
            
            $prefix = 'INV-' . date('Ymd') . '-';
            $invoiceNumber = $prefix . $newNumber;
            
            return response()->json([
                'success' => true,
                'invoice_number' => $invoiceNumber
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'invoice_number' => 'INV-' . date('Ymd') . '-001'
            ]);
        }
    }
}