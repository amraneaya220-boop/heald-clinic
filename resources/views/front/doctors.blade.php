@extends('layouts.front')

@section('title', $clinic->name . ' - Doctors')

@section('extra_styles')
<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
    min-height:100vh;
    background: linear-gradient(135deg, #0f2027 0%, #203a43 40%, #2c5364 100%);
    position:relative;
}

body::before{
    content:"";
    position:fixed;
    top:0;left:0;
    width:100%;height:100%;
    background:rgba(30,58,138,0.25);
    backdrop-filter:blur(1px);
    z-index:-1;
}

.container{
    max-width:800px;
    margin:40px auto;
    padding:0 20px;
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:30px;
}

.header h1{
    color:white;
    font-size:34px;
    font-weight:700;
    text-shadow:0 2px 10px rgba(0,0,0,0.3);
}

.header p{
    color:rgba(255,255,255,0.8);
    font-size:14px;
    margin-top:5px;
}

.count-badge{
    display:inline-block;
    background:rgba(255,255,255,0.15);
    padding:8px 20px;
    border-radius:50px;
    margin-top:12px;
    color:white;
    font-weight:600;
}

/* SEARCH */
.search-box input{
    width:100%;
    padding:15px 20px;
    border:none;
    border-radius:60px;
    background:rgba(255,255,255,0.9);
    margin-bottom:25px;
    font-size:14px;
    outline:none;
    transition:0.2s;
}

.search-box input:focus{
    box-shadow:0 0 0 3px rgba(139,92,246,0.4);
}

/* DOCTORS LIST */
.doctors-list{
    list-style:none;
    display:flex;
    flex-direction:column;
    gap:15px;
}

/* CARD */
.doctor-item{
    background:rgba(255,255,255,0.12);
    border-radius:20px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:18px;
    cursor:pointer;
    transition:all 0.25s ease;
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.15);
}

.doctor-item:hover{
    transform:translateX(10px) scale(1.02);
    background:rgba(255,255,255,0.2);
}

/* ICON */
.doctor-icon{
    font-size:45px;
    background:rgba(255,255,255,0.15);
    width:70px;
    height:70px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
}

/* INFO */
.doctor-info{
    flex:1;
}

.doctor-name{
    font-weight:700;
    color:white;
    font-size:18px;
}

.doctor-specialty{
    font-size:13px;
    color:rgba(255,255,255,0.85);
    margin-top:4px;
}

.doctor-clinic{
    font-size:12px;
    color:rgba(255,255,255,0.6);
    margin-top:3px;
}

/* BACK BUTTON */
.btn-back{
    width:100%;
    padding:15px;
    background:rgba(255,255,255,0.2);
    color:white;
    border:1px solid rgba(255,255,255,0.3);
    border-radius:60px;
    margin-top:25px;
    cursor:pointer;
    font-size:14px;
    transition:0.2s;
}

.btn-back:hover{
    background:rgba(255,255,255,0.3);
}

/* NO RESULTS */
.no-results{
    text-align:center;
    padding:50px;
    color:white;
    background:rgba(255,255,255,0.1);
    border-radius:20px;
}
</style>
@endsection
@section('content')
<div class="container">
    <div class="header">
        <h1>👨‍⚕️ {{ $clinic->name }} - Medical Team</h1>
        <p>Meet our expert doctors</p>
        <span class="count-badge">{{ $doctors->count() }} Doctors</span>
    </div>
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="🔍 Search by name or specialty..." onkeyup="filterDoctors()">
    </div>
    <ul class="doctors-list" id="doctorsList"></ul>
    <button class="btn-back" onclick="history.back()">← Back to Clinic</button>
</div>
@endsection

@section('scripts')
<script>
    var doctors = @json($doctors);
    var filteredDoctors = [...doctors];
    function renderDoctors() {
        var list = document.getElementById("doctorsList");
        if(filteredDoctors.length === 0) { list.innerHTML = '<div class="no-results" style="text-align:center;padding:50px;">😕 No doctors found</div>'; return; }
        var html = "";
        filteredDoctors.forEach((doc, idx) => {
            html += `<li class="doctor-item" onclick="window.location.href='/doctor/${doc.id}'">
                        <div class="doctor-icon">👨‍⚕️</div>
                        <div class="doctor-info">
                            <div class="doctor-name">${doc.name}</div>
                            <div class="doctor-specialty">${doc.specialty} • ⭐ ${doc.rating || 4.0}</div>
                            <div class="doctor-clinic">${doc.clinic?.name || ''}</div>
                        </div>
                     </li>`;
        });
        list.innerHTML = html;
    }
    function filterDoctors() {
        var term = document.getElementById("searchInput").value.toLowerCase();
        filteredDoctors = doctors.filter(d => d.name.toLowerCase().includes(term) || d.specialty.toLowerCase().includes(term));
        renderDoctors();
    }
    renderDoctors();
</script>
@endsection