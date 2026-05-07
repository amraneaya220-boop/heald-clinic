<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminClinicController extends Controller
{
    public function index()
    {
        // جلب جميع العيادات مع معلومات المستخدم المرتبطة بها
        $clinics = Clinic::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('super_admin.clinics', compact('clinics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'subscription' => 'nullable|in:monthly,yearly',
        ]);

        try {
            DB::beginTransaction();

            // إنشاء مستخدم جديد للعيادة
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'clinic',
            ]);

            // إنشاء العيادة
            $clinic = Clinic::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'location' => $request->location,
                'phone' => $request->phone,
                'commission_rate' => $request->commission_rate ?? 10,
                'status' => 'active',
                'is_approved' => true,  // إذا أضافها الأدمن مباشرة تكون موافقة
                'approved_at' => now(),
                'subscription_status' => 'trial',
                'trial_used' => 0,
                'max_trials' => 2
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Clinic created successfully',
                'clinic' => $clinic
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating clinic: ' . $e->getMessage()
            ], 500);
        }
    }

    public function renew(Request $request, $id)
    {
        try {
             $clinic = Clinic::findOrFail($id);
            $clinic->subscription_end_date = now()->addYear();
            $clinic->subscription_status = 'active';
            $clinic->save();

            return response()->json([
                'success' => true,
                'message' => 'Clinic renewed successfully',
                'new_expiry' => $clinic->paid_until->format('Y-m-d')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error renewing clinic: ' . $e->getMessage()
            ], 500);
        }
    }
    // قائمة العيادات المنتظرة الموافقة
public function pending()
    {
        $pendingClinics = Clinic::with('user')
            ->where('is_approved', false)
            ->orWhereNull('is_approved')
            ->orderBy('created_at', 'asc')
            ->get();
        
        $approvedCount = Clinic::where('is_approved', true)->count();
        $pendingCount = Clinic::where('is_approved', false)->count();
        $totalCount = Clinic::count();
        
        return view('super_admin.clinics_pending', compact('pendingClinics', 'approvedCount', 'pendingCount', 'totalCount'));
    }

// الموافقة على عيادة
 public function approve($id)
    {
        try {
            $clinic = Clinic::findOrFail($id);
            $clinic->is_approved = true;
            $clinic->approved_at = now();
            $clinic->subscription_status = 'trial';  // تبدأ كتجربة
            $clinic->trial_used = 0;
            $clinic->max_trials = 2;
            $clinic->status = 'active';
            $clinic->save();
            
            // يمكن إرسال إشعار للعيادة هنا
            // Notification::send($clinic->user, new ClinicApprovedNotification($clinic));
            
            return response()->json([
                'success' => true,
                'message' => 'Clinic approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error approving clinic: ' . $e->getMessage()
            ], 500);
        }
    }
    

// رفض عيادة
 public function reject($id)
    {
        try {
            $clinic = Clinic::findOrFail($id);
            
            // حذف المستخدم المرتبط
            if ($clinic->user) {
                $clinic->user->delete();
            }
            
            // حذف العيادة
            $clinic->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Clinic rejected and removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting clinic: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $clinic = Clinic::findOrFail($id);
            
            // حذف المستخدم المرتبط بالعيادة
            if ($clinic->user) {
                $clinic->user->delete();
            }
            
            // حذف العيادة
            $clinic->delete();

            return response()->json([
                'success' => true,
                'message' => 'Clinic deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting clinic: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,suspended'
        ]);

        try {
            $clinic = Clinic::findOrFail($id);
            $clinic->status = $request->status;
            $clinic->save();

            return response()->json([
                'success' => true,
                'message' => 'Clinic status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }
}