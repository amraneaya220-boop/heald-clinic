<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'Accepted')
            ->latest()
            ->get();

        return view('clinic.invoices.index', compact('appointments'));
    }
}