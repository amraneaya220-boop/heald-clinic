@extends('patient.layouts.patient')

@section('title', 'Dashboard')

@section('content')
<div class="card-white">
    <h2><i class="fas fa-tachometer-alt"></i> Welcome to Your Dashboard</h2>
    <p>You are logged in as a patient!</p>
    
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
</div>
@endsection