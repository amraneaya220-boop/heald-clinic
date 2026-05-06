<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MediEase')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
    <style>
        /* جميع الـ Styles الخاصة بك (احتفظ بها كما هي) */
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter','Segoe UI',sans-serif;background:url("https://images.unsplash.com/photo-1576091160550-2173dba999ef") no-repeat center center;background-size:cover;background-attachment:fixed;color:#1e293b;min-height:100vh;}
        body::before{content:"";position:fixed;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg, rgba(15,32,39,0.55) 0%, rgba(25,45,65,0.5) 100%);backdrop-filter:blur(3px);z-index:-1;}
        .navbar{background:rgba(25,45,65,0.85);backdrop-filter:blur(20px);padding:18px 40px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:99;width:100%;border-bottom:1px solid rgba(59,130,246,0.3);flex-wrap:wrap;box-shadow:0 4px 20px rgba(0,0,0,0.15);}
        .logo{color:white;font-size:30px;font-weight:800;letter-spacing:-1px;text-shadow:0 2px 10px rgba(0,0,0,0.3);background:linear-gradient(135deg,#fff,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
        .logo span{color:#3b82f6;-webkit-text-fill-color:#3b82f6;}
        .menu-icon-container{display:flex;align-items:center;gap:20px;}
        .menu-icon{font-size:24px;cursor:pointer;color:white;background:rgba(59,130,246,0.2);width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:0.3s;backdrop-filter:blur(5px);border:1px solid rgba(59,130,246,0.3);}
        .menu-icon:hover{background:rgba(59,130,246,0.4);transform:scale(1.05);}
        .lang{background:rgba(59,130,246,0.15);padding:8px 20px;border-radius:50px;backdrop-filter:blur(8px);border:1px solid rgba(59,130,246,0.3);}
        .lang select{background:transparent;border:none;cursor:pointer;font-weight:600;font-size:14px;color:white;outline:none;}
        .lang select option{color:#1e3a8a;}
        .nav-center{display:flex;align-items:center;justify-content:center;gap:35px;flex:1;}
        .nav-item{position:relative;}
        .nav-item > a{text-decoration:none;color:rgba(255,255,255,0.95);font-weight:600;font-size:15px;padding:8px 0;display:inline-block;transition:0.2s;position:relative;}
        .nav-item > a::after{content:'';position:absolute;bottom:0;left:0;width:0;height:2px;background:#3b82f6;transition:width 0.3s;}
        .nav-item > a:hover::after{width:100%;}
        .nav-item > a:hover{color:#3b82f6;}
        .dropdown-content{position:absolute;top:calc(100% + 12px);left:0;background:rgba(255,255,255,0.98);backdrop-filter:blur(10px);min-width:340px;box-shadow:0 25px 50px rgba(0,0,0,0.2);border-radius:20px;z-index:100;display:none;max-height:450px;overflow-y:auto;border:1px solid rgba(59,130,246,0.2);}
        .dropdown-content.show{display:block;animation:fadeIn 0.2s ease;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(-10px);}to{opacity:1;transform:translateY(0);}}
        .dropdown-header{padding:18px 22px;background:linear-gradient(135deg,#1e3a8a,#2563eb);font-weight:700;color:white;border-bottom:1px solid rgba(255,255,255,0.2);position:sticky;top:0;font-size:15px;border-radius:20px 20px 0 0;}
        .dropdown-items a{display:flex;align-items:center;gap:14px;padding:15px 22px;color:#1e293b;text-decoration:none;font-size:14px;transition:0.2s;border-bottom:1px solid #eef2ff;}
        .dropdown-items a:last-child{border-bottom:none;}
        .dropdown-items a:hover{background:#eff6ff;color:#2563eb;transform:translateX(5px);}
        .dropdown-items a small{display:block;font-size:11px;color:#64748b;margin-top:3px;}
        .nav-right{display:flex;gap:15px;align-items:center;}
        .auth-dropdown{position:relative;display:inline-block;}
        .auth-dropbtn{background:rgba(59,130,246,0.15);backdrop-filter:blur(8px);border:1px solid rgba(59,130,246,0.4);padding:10px 22px;cursor:pointer;font-size:14px;font-weight:600;color:white;border-radius:50px;transition:0.2s;display:flex;align-items:center;gap:8px;}
        .auth-dropbtn:hover{background:rgba(59,130,246,0.3);transform:translateY(-2px);}
        .auth-dropdown-content{position:absolute;top:calc(100% + 10px);right:0;background:rgba(255,255,255,0.98);backdrop-filter:blur(10px);min-width:220px;box-shadow:0 20px 40px rgba(0,0,0,0.15);border-radius:18px;z-index:100;display:none;border:1px solid rgba(59,130,246,0.2);}
        .auth-dropdown-content.show{display:block;animation:fadeIn 0.2s ease;}
        .auth-dropdown-content a{color:#1e293b;padding:14px 22px;text-decoration:none;display:flex;align-items:center;gap:12px;font-size:14px;transition:0.15s;border-bottom:1px solid #eef2ff;}
        .auth-dropdown-content a:last-child{border-bottom:none;}
        .auth-dropdown-content a:hover{background:#eff6ff;color:#2563eb;padding-left:28px;}
        .sidebar{position:fixed;top:0;left:-300px;width:300px;height:100%;background:rgba(15,32,55,0.96);backdrop-filter:blur(25px);color:white;transition:left 0.3s cubic-bezier(0.4,0,0.2,1);padding-top:40px;z-index:1000;border-right:1px solid rgba(59,130,246,0.3);}
        .sidebar .close-icon{display:flex;justify-content:center;margin-bottom:40px;}
        .sidebar .close-icon span{font-size:28px;cursor:pointer;background:rgba(59,130,246,0.2);width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:0.3s;color:white;border:1px solid rgba(59,130,246,0.3);}
        .sidebar .close-icon span:hover{background:rgba(59,130,246,0.4);transform:rotate(90deg);}
        .sidebar a{display:block;padding:16px 35px;color:white;text-decoration:none;transition:0.2s;font-size:16px;font-weight:500;border-bottom:1px solid rgba(255,255,255,0.08);}
        .sidebar a:hover{background:rgba(59,130,246,0.2);padding-left:45px;}
        .sidebar a i{margin-right:12px;width:24px;color:#3b82f6;}
        @media (max-width:768px){.navbar{padding:15px 20px;}.logo{font-size:24px;}}
        body[dir="rtl"] .sidebar{left:auto;right:-300px;}
        body[dir="rtl"] .sidebar a:hover{padding-right:45px;padding-left:35px;}
        body[dir="rtl"] .dropdown-content{left:auto;right:0;}
        body[dir="rtl"] .auth-dropdown-content{right:auto;left:0;}
    </style>
    @yield('extra_styles')
</head>
<body>

<div id="sidebar" class="sidebar">
    <div class="close-icon"><span onclick="toggleMenu()"><i class="fas fa-times"></i></span></div>
    <a href="{{ route('home') }}#about"><i class="fas fa-info-circle"></i> <span id="aboutLink">About</span></a>
    <a href="{{ route('home') }}#contact"><i class="fas fa-envelope"></i> <span id="contactLink">Contact</span></a>
    <a href="#"><i class="fas fa-bullhorn"></i> <span id="announceLink">Announcement</span></a>
    <a href="#"><i class="fas fa-stethoscope"></i> <span id="adviceLink">Medical Advice</span></a>
</div>

<div class="navbar">
    <div class="menu-icon-container">
        <div class="menu-icon" onclick="toggleMenu()"><i class="fas fa-bars"></i></div>
        <h2 class="logo">Medi<span>Ease</span></h2>
    </div>
    <div class="nav-center">
        <div class="nav-item"><a href="{{ route('home') }}" id="homeLink">Home</a></div>
        <div class="nav-item">
            <a href="#" onclick="toggleDropdown('clinicsDropdown'); return false;">Clinics <i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-content" id="clinicsDropdown">
                <div class="dropdown-header"><i class="fas fa-hospital"></i> All Clinics</div>
                <div id="clinicsList" class="dropdown-items">
                    @if(isset($clinics) && count($clinics))
                        @foreach($clinics as $clinic)
                            <a href="{{ route('clinic.show', $clinic->id) }}">
                                <i class="fas fa-hospital"></i>
                                <div style="flex:1"><strong>{{ $clinic->name }}</strong><br><small>{{ $clinic->location }}</small></div>
                            </a>
                        @endforeach
                    @else
                        <div style="padding: 10px; text-align:center;">No clinics available</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="nav-item">
            <a href="#" onclick="toggleDropdown('doctorsDropdown'); return false;">Doctors <i class="fas fa-chevron-down"></i></a>
            <div class="dropdown-content" id="doctorsDropdown">
                <div class="dropdown-header"><i class="fas fa-user-md"></i> All Doctors</div>
                <div id="doctorsList" class="dropdown-items">
                    @if(isset($doctors) && count($doctors))
                        @foreach($doctors as $doctor)
                            <a href="{{ route('doctor.show', $doctor->id) }}">
                                <i class="fas fa-user-md"></i>
                                <div style="flex:1"><strong>{{ $doctor->name }}</strong><br><small>{{ $doctor->specialty }} - {{ $doctor->clinic->name ?? '' }}</small></div>
                            </a>
                        @endforeach
                    @else
                        <div style="padding: 10px; text-align:center;">No doctors available</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="nav-right">
        <div class="lang">
            <select onchange="changeLang(this.value)">
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 EN</option>
                <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>🇸🇦 AR</option>
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 FR</option>
            </select>
        </div>
        <div class="auth-dropdown">
            <button class="auth-dropbtn" onclick="toggleAuthDropdown('loginDropdown'); return false;" id="loginBtn"><i class="fas fa-sign-in-alt"></i> Login ▼</button>
            <div class="auth-dropdown-content" id="loginDropdown">
                <a href="{{ route('login', ['type'=>'clinic']) }}"><i class="fas fa-hospital"></i> Clinic Login</a>
                <a href="{{ route('login', ['type'=>'doctor']) }}"><i class="fas fa-user-md"></i> Doctor Login</a>
                <a href="{{ route('login', ['type'=>'patient']) }}"><i class="fas fa-user"></i> Patient Login</a>
            </div>
        </div>
        <div class="auth-dropdown">
            <button class="auth-dropbtn" onclick="toggleAuthDropdown('registerDropdown'); return false;" id="registerBtn"><i class="fas fa-user-plus"></i> Register ▼</button>
            <div class="auth-dropdown-content" id="registerDropdown">
                <a href="{{ route('register', ['type'=>'clinic']) }}"><i class="fas fa-hospital"></i> Clinic Register</a>
                <a href="{{ route('register', ['type'=>'doctor']) }}"><i class="fas fa-user-md"></i> Doctor Register</a>
                <a href="{{ route('register', ['type'=>'patient']) }}"><i class="fas fa-user"></i> Patient Register</a>
            </div>
        </div>
    </div>
</div>

<main>
    @yield('content')
</main>

<script>
    // ==================== الدوال الأساسية للقوائم واللغة ====================
    function toggleMenu() {
        var sidebar = document.getElementById("sidebar");
        if (sidebar) {
            sidebar.style.left = sidebar.style.left === "0px" ? "-300px" : "0px";
        }
    }

    var activeDropdown = null;
    var activeAuthDropdown = null;

    function toggleDropdown(id) {
        var dropdown = document.getElementById(id);
        if (!dropdown) return;
        if (activeDropdown && activeDropdown !== dropdown) activeDropdown.classList.remove("show");
        dropdown.classList.toggle("show");
        activeDropdown = dropdown.classList.contains("show") ? dropdown : null;
        if (activeAuthDropdown) {
            activeAuthDropdown.classList.remove("show");
            activeAuthDropdown = null;
        }
    }

    function toggleAuthDropdown(id) {
        var dropdown = document.getElementById(id);
        if (!dropdown) return;
        if (activeAuthDropdown && activeAuthDropdown !== dropdown) activeAuthDropdown.classList.remove("show");
        dropdown.classList.toggle("show");
        activeAuthDropdown = dropdown.classList.contains("show") ? dropdown : null;
        if (activeDropdown) {
            activeDropdown.classList.remove("show");
            activeDropdown = null;
        }
    }

    // إغلاق القوائم عند النقر خارجها
    document.addEventListener("click", function(e) {
        if (!e.target.closest(".nav-item") && !e.target.closest(".dropdown-content")) {
            if (activeDropdown) {
                activeDropdown.classList.remove("show");
                activeDropdown = null;
            }
        }
        if (!e.target.closest(".auth-dropdown") && !e.target.closest(".auth-dropdown-content")) {
            if (activeAuthDropdown) {
                activeAuthDropdown.classList.remove("show");
                activeAuthDropdown = null;
            }
        }
    });

    // دالة تغيير اللغة
    function changeLang(lang) {
        document.body.dir = lang === "ar" ? "rtl" : "ltr";
        var texts = {
            en: { login: "Login ▼", register: "Register ▼", home: "Home", about: "About", contact: "Contact", searchPlaceholder: "Search for clinic or doctor...", searchBtn: "Search" },
            ar: { login: "تسجيل الدخول ▼", register: "تسجيل ▼", home: "الرئيسية", about: "من نحن", contact: "اتصل بنا", searchPlaceholder: "ابحث عن عيادة أو طبيب...", searchBtn: "بحث" },
            fr: { login: "Connexion ▼", register: "Inscription ▼", home: "Accueil", about: "À propos", contact: "Contact", searchPlaceholder: "Rechercher une clinique ou un médecin...", searchBtn: "Rechercher" }
        };
        var t = texts[lang] || texts.en;
        
        var loginBtn = document.getElementById("loginBtn");
        var registerBtn = document.getElementById("registerBtn");
        var homeLink = document.getElementById("homeLink");
        var aboutLink = document.getElementById("aboutLink");
        var contactLink = document.getElementById("contactLink");
        var searchInput = document.getElementById("searchInput");
        var searchBtn = document.getElementById("searchBtn");
        
        if (loginBtn) loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> ' + t.login;
        if (registerBtn) registerBtn.innerHTML = '<i class="fas fa-user-plus"></i> ' + t.register;
        if (homeLink) homeLink.innerText = t.home;
        if (aboutLink) aboutLink.innerText = t.about;
        if (contactLink) contactLink.innerText = t.contact;
        if (searchInput) searchInput.placeholder = t.searchPlaceholder;
        if (searchBtn) searchBtn.innerHTML = '<i class="fas fa-search"></i> ' + t.searchBtn;
        
        localStorage.setItem('selectedLang', lang);
    }

    // استعادة اللغة المحفوظة
    var savedLang = localStorage.getItem('selectedLang');
    if (savedLang) {
        var langSelect = document.querySelector('.lang select');
        if (langSelect && langSelect.value !== savedLang) {
            langSelect.value = savedLang;
            changeLang(savedLang);
        }
    }
</script>

@yield('scripts')

</body>
</html>