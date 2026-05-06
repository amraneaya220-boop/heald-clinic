<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{
    public function index()
    {
        $patient = Patient::where('user_id', Auth::id())->first();
        
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Patient profile not found');
        }
        
        $invoices = Invoice::where('patient_id', $patient->id)
            ->orderBy('invoice_date', 'desc')
            ->get();
        
        return view('patient.invoices', compact('patient', 'invoices'));
    }
    
    public function show($id)
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return redirect()->route('patient.index')->with('error', 'Patient profile not found');
        }

        $invoice = Invoice::where('id', $id)
            ->where('patient_id', $patient->id)
            ->with(['doctor', 'clinic', 'appointment'])
            ->firstOrFail();
        
        return view('patient.invoice-details', compact('invoice', 'patient'));
    }
    public function apiIndex()
{
    $patient = Patient::where('user_id', Auth::id())->first();
    $invoices = Invoice::where('patient_id', $patient->id)
        ->orderBy('invoice_date', 'desc')
        ->get();
    
    return response()->json(['success' => true, 'data' => $invoices]);
}

public function apiShow($id)
{
    $patient = Patient::where('user_id', Auth::id())->first();

    if (!$patient) {
        return response()->json(['success' => false, 'message' => 'Patient profile not found'], 404);
    }

    $invoice = Invoice::where('id', $id)
        ->where('patient_id', $patient->id)
        ->with(['doctor', 'clinic', 'appointment'])
        ->firstOrFail();
    
    return response()->json(['success' => true, 'data' => $invoice]);
}
}