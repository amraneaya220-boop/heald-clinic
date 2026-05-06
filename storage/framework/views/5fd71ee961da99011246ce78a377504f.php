
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($doctor->name); ?> - MediEase</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        /* === Exact styles from doctors-profile (3).html === */
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;min-height:100vh;display:flex;flex-direction:column;background: linear-gradient(135deg, #0f2027 0%, #203a43 40%, #2c5364 100%);position:relative;}
        body::before{content:"";position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(30,58,138,0.2);backdrop-filter:blur(2px);z-index:-1;}

        /* Sidebar - transparent */
        .sidebar{position:fixed;top:0;left:-280px;width:280px;height:100%;background:rgba(15,32,39,0.85);backdrop-filter:blur(20px);color:white;transition:left 0.3s ease;padding-top:30px;z-index:1000;border-right:1px solid rgba(255,255,255,0.2);}
        .sidebar .close-icon{display:flex;justify-content:center;margin-bottom:30px;}
        .sidebar .close-icon span{font-size:30px;cursor:pointer;background:rgba(255,255,255,0.15);width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:0.3s;color:white;}
        .sidebar .close-icon span:hover{background:rgba(255,255,255,0.3);}
        .sidebar a{display:block;padding:15px 30px;color:white;text-decoration:none;transition:0.2s;font-size:16px;font-weight:500;border-bottom:1px solid rgba(255,255,255,0.1);}
        .sidebar a:hover{background:rgba(255,255,255,0.15);padding-left:40px;}

        .card{max-width:650px;width:100%;background:transparent;margin:40px auto;}
        .header{background:transparent;padding:30px 20px 20px 20px;text-align:center;}
        .header .icon{font-size:80px;background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);width:120px;height:120px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;}
        .header h1{color:white;font-size:28px;text-shadow:0 2px 5px rgba(0,0,0,0.2);}
        .header p{color:rgba(255,255,255,0.85);font-size:16px;}

        .content{padding:20px 30px 30px 30px;background:transparent;}
        .section{background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border-radius:25px;padding:20px;margin-bottom:20px;}
        .section h3{color:white;margin-bottom:15px;border-bottom:2px solid rgba(255,255,255,0.2);padding-bottom:10px;}

        .row{display:flex;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.1);}
        .row:last-child{border-bottom:none;}
        .label{font-weight:600;width:130px;color:rgba(255,255,255,0.8);font-size:14px;}
        .value{color:white;flex:1;font-size:14px;}

        .price{background:rgba(255,255,255,0.2);padding:5px 12px;border-radius:50px;display:inline-block;font-weight:600;color:white;}
        .stars{color:#fbbf24;letter-spacing:2px;}

        .btn-group{display:flex;gap:15px;margin-top:20px;}
        .btn{flex:1;padding:14px;border:none;border-radius:60px;font-size:16px;font-weight:600;cursor:pointer;transition:0.2s;}
        .btn-back{background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.3);}
        .btn-back:hover{background:rgba(255,255,255,0.35);}
        .btn-book{background:#f59e0b;color:white;}
        .btn-book:hover{background:#d97706;}

        .auth-message{text-align:center;margin-top:10px;}
        .auth-message p{color:white;margin-bottom:15px;font-size:14px;}
        .auth-buttons{display:flex;gap:10px;}
        .btn-login,.btn-register{flex:1;padding:12px;border:none;border-radius:50px;font-size:14px;font-weight:600;cursor:pointer;}
        .btn-login{background:#0284c7;color:white;}
        .btn-register{background:#10b981;color:white;}

        /* Experience section */
        .experience-section{background:rgba(255,255,255,0.1);backdrop-filter:blur(10px);border-radius:25px;padding:20px;margin-top:20px;}
        .experience-section h3{color:white;font-size:20px;margin-bottom:15px;display:flex;align-items:center;gap:8px;border-bottom:2px solid rgba(255,255,255,0.2);padding-bottom:10px;}
        .experience-section h3 span{color:#fbbf24;}
        .rating-box-exp{background:rgba(255,255,255,0.08);border-radius:15px;padding:18px;margin-bottom:15px;}
        .rating-row-exp{display:flex;align-items:center;gap:15px;flex-wrap:wrap;}
        .rating-label-exp{color:white;font-size:15px;font-weight:600;min-width:70px;}
        .rating-stars-box-exp{display:flex;align-items:center;gap:10px;flex:1;}
        .star-rating-exp{display:flex;gap:5px;}
        .star-exp{font-size:28px;color:rgba(255,255,255,0.3);cursor:pointer;transition:0.2s;}
        .star-exp:hover,.star-exp.active{color:#fbbf24;}
        .rating-text-exp{color:#fbbf24;font-size:16px;font-weight:600;margin-left:10px;}
        .feedback-box-exp textarea{width:100%;padding:14px;border:none;border-radius:15px;font-size:14px;outline:none;background:rgba(255,255,255,0.9);color:#1e293b;resize:vertical;min-height:90px;font-family:inherit;margin-bottom:15px;}
        .feedback-box-exp textarea:focus{background:white;}
        .feedback-box-exp textarea::placeholder{color:#94a3b8;}
        .btn-send-exp{width:100%;padding:13px;background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:50px;font-size:15px;font-weight:700;cursor:pointer;transition:0.2s;display:flex;align-items:center;justify-content:center;gap:8px;}
        .btn-send-exp:hover{background:linear-gradient(135deg,#d97706,#f59e0b);transform:translateY(-2px);}
        .reviews-list-exp{margin-top:20px;max-height:200px;overflow-y:auto;padding-right:5px;}
        .review-item-exp{background:rgba(255,255,255,0.08);border-radius:15px;padding:12px;margin-bottom:10px;border:1px solid rgba(255,255,255,0.1);}
        .review-header-exp{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;}
        .review-stars-exp{color:#fbbf24;font-size:13px;letter-spacing:2px;}
        .review-text-exp{color:rgba(255,255,255,0.9);font-size:13px;line-height:1.5;margin-bottom:4px;}
        .review-date-exp{color:rgba(255,255,255,0.5);font-size:10px;}
        .no-reviews-exp{text-align:center;color:rgba(255,255,255,0.6);padding:15px;font-size:13px;}
        .reviews-list-exp::-webkit-scrollbar{width:5px;}
        .reviews-list-exp::-webkit-scrollbar-track{background:rgba(255,255,255,0.1);border-radius:10px;}
        .reviews-list-exp::-webkit-scrollbar-thumb{background:rgba(255,255,255,0.3);border-radius:10px;}

        /* Navbar */
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
        .nav-center a{text-decoration:none;color:white;font-weight:600;font-size:15px;}
        .nav-item > a::after{content:'';position:absolute;bottom:0;left:0;width:0;height:2px;background:#3b82f6;transition:width 0.3s;}
        .nav-item > a:hover::after{width:100%;}
        .nav-item > a:hover{color:#3b82f6;}

        @media(max-width:600px){.row{flex-direction:column;}.label{width:100%;margin-bottom:5px;}.btn-group{flex-direction:column;}.auth-buttons{flex-direction:column;}.rating-row-exp{flex-direction:column;align-items:flex-start;}}
        body[dir="rtl"] .sidebar{left:auto;right:-280px;}
        body[dir="rtl"] .sidebar a:hover{padding-right:40px;padding-left:30px;}
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="close-icon"><span onclick="toggleMenu()">✕</span></div>
    <a href="#" id="aboutLink">📖 About</a>
    <a href="#" id="contactLink">📞 Contact</a>
    <a href="#" id="announceLink">📢 Announcements</a>
    <a href="#" id="adviceLink">💊 Medical Advice</a>
</div>

<div class="navbar">
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
    <h2 class="logo">Medi<span>Ease</span></h2>
    <div class="nav-center"><a href="<?php echo e(url('/')); ?>" id="homeLink">Home</a></div>
    <div class="lang">
        <select onchange="changeLang(this.value)">
            <option value="en">EN</option>
            <option value="ar">AR</option>
            <option value="fr">FR</option>
        </select>
    </div>
</div>

<div class="card">
    <div class="header">
        <div class="icon">👨‍⚕️</div>
        <h1 id="docName"><?php echo e($doctor->name); ?></h1>
        <p id="docSpecialty"><?php echo e($doctor->specialty); ?></p>
    </div>
    <div class="content">
        <div class="section">
            <h3 id="personalInfoTitle">📋 Personal Information</h3>
            <div class="row"><div class="label" id="fullNameLabel">Full Name</div><div class="value" id="fullName"><?php echo e($doctor->name); ?></div></div>
            <div class="row"><div class="label" id="specialtyLabel">Specialty</div><div class="value" id="specialty"><?php echo e($doctor->specialty); ?></div></div>
            <div class="row"><div class="label" id="clinicLabel">Clinic</div><div class="value" id="clinic"><?php echo e($doctor->clinic->name ?? ''); ?></div></div>
            <div class="row"><div class="label" id="experienceLabel">Experience</div><div class="value" id="experience"><?php echo e($doctor->experience ?? '10+ years'); ?></div></div>
            <div class="row"><div class="label" id="hoursLabel">Working Hours</div><div class="value" id="hours"><?php echo e($doctor->working_hours ?? 'Saturday - Thursday: 9:00 AM - 5:00 PM'); ?></div></div>
            <div class="row"><div class="label" id="phoneLabel">Phone</div><div class="value" id="phone"><?php echo e($doctor->phone); ?></div></div>
        </div>
        <div class="section">
            <h3 id="feeTitle">💰 Consultation Fee</h3>
            <div class="row"><div class="label" id="visitPriceLabel">Visit Price</div><div class="value"><span class="price" id="fee"><?php echo e($doctor->consultation_fee ?? '2500 DZD'); ?></span></div></div>
        </div>
        <div class="section">
            <h3 id="ratingTitle">⭐ Rating</h3>
            <div class="row"><div class="label" id="ratingLabelMain">Rating</div>
                <div class="value">
                    <span class="stars" id="stars">
                        <?php
                            $rating = $doctor->rating ?? 4;
                            $full = floor($rating);
                            $empty = 5 - $full;
                        ?>
                        <?php for($i=0; $i<$full; $i++): ?>⭐<?php endfor; ?>
                        <?php for($i=0; $i<$empty; $i++): ?>☆<?php endfor; ?>
                    </span>
                    <span id="ratingText">(<?php echo e(number_format($rating,1)); ?>/5 - <?php echo e($doctor->reviewCount ?? 0); ?> reviews)</span>
                </div>
            </div>
        </div>
        <div class="section">
            <h3 id="aboutTitle">📖 About</h3>
            <div class="value" id="about" style="line-height:1.6;"><?php echo e($doctor->about ?? 'Experienced medical professional.'); ?></div>
        </div>

        <div id="experienceContainer"></div>
        <div id="actionContainer"></div>
    </div>
</div>

<script>
    // ========== TRANSLATIONS (same as HTML) ==========
    var currentLang = "en";
    var translations = {
        en: {
            aboutLink: "📖 About", contactLink: "📞 Contact", announceLink: "📢 Announcements", adviceLink: "💊 Medical Advice", homeLink: "Home",
            personalInfoTitle: "📋 Personal Information", fullNameLabel: "Full Name", specialtyLabel: "Specialty", clinicLabel: "Clinic",
            experienceLabel: "Experience", hoursLabel: "Working Hours", phoneLabel: "Phone", feeTitle: "💰 Consultation Fee",
            visitPriceLabel: "Visit Price", ratingTitle: "⭐ Rating", ratingLabelMain: "Rating", aboutTitle: "📖 About",
            yourExperience: "⭐ Your Experience", ratingTextExp: "Rating:", placeholderExp: "Write your experience...", sendBtn: "📤 Send",
            noReviews: "No reviews yet. Be the first to share your experience!",
            loginRequired: "👤 Login or Register to book an appointment", loginBtn: "🔐 Login", registerBtn: "📝 Register",
            bookBtn: "📅 Book Appointment", backBtn: "← Back"
        },
        ar: {
            aboutLink: "📖 من نحن", contactLink: "📞 اتصل بنا", announceLink: "📢 إعلانات", adviceLink: "💊 نصائح طبية", homeLink: "الرئيسية",
            personalInfoTitle: "📋 المعلومات الشخصية", fullNameLabel: "الاسم الكامل", specialtyLabel: "التخصص", clinicLabel: "العيادة",
            experienceLabel: "الخبرة", hoursLabel: "ساعات العمل", phoneLabel: "الهاتف", feeTitle: "💰 رسوم الاستشارة",
            visitPriceLabel: "سعر الزيارة", ratingTitle: "⭐ التقييم", ratingLabelMain: "التقييم", aboutTitle: "📖 نبذة",
            yourExperience: "⭐ تقييمك", ratingTextExp: "التقييم:", placeholderExp: "اكتب تجربتك...", sendBtn: "📤 إرسال",
            noReviews: "لا توجد تقييمات بعد. كن أول من يشارك تجربتك!",
            loginRequired: "👤 سجل الدخول أو أنشئ حساباً لحجز موعد", loginBtn: "🔐 تسجيل الدخول", registerBtn: "📝 إنشاء حساب",
            bookBtn: "📅 احجز موعداً", backBtn: "← رجوع"
        },
        fr: {
            aboutLink: "📖 À propos", contactLink: "📞 Contact", announceLink: "📢 Annonces", adviceLink: "💊 Conseils médicaux", homeLink: "Accueil",
            personalInfoTitle: "📋 Informations personnelles", fullNameLabel: "Nom complet", specialtyLabel: "Spécialité", clinicLabel: "Clinique",
            experienceLabel: "Expérience", hoursLabel: "Horaires", phoneLabel: "Téléphone", feeTitle: "💰 Honoraires",
            visitPriceLabel: "Prix de la visite", ratingTitle: "⭐ Évaluation", ratingLabelMain: "Évaluation", aboutTitle: "📖 À propos",
            yourExperience: "⭐ Votre expérience", ratingTextExp: "Évaluation:", placeholderExp: "Écrivez votre expérience...", sendBtn: "📤 Envoyer",
            noReviews: "Aucun avis pour le moment. Soyez le premier à partager votre expérience!",
            loginRequired: "👤 Connectez-vous ou inscrivez-vous pour réserver", loginBtn: "🔐 Connexion", registerBtn: "📝 Inscription",
            bookBtn: "📅 Réserver", backBtn: "← Retour"
        }
    };

    function changeLang(lang){
        currentLang = lang;
        document.body.dir = lang === "ar" ? "rtl" : "ltr";
        var t = translations[lang];
        document.getElementById("aboutLink").innerText = t.aboutLink;
        document.getElementById("contactLink").innerText = t.contactLink;
        document.getElementById("announceLink").innerText = t.announceLink;
        document.getElementById("adviceLink").innerText = t.adviceLink;
        document.getElementById("homeLink").innerText = t.homeLink;
        document.getElementById("personalInfoTitle").innerText = t.personalInfoTitle;
        document.getElementById("fullNameLabel").innerText = t.fullNameLabel;
        document.getElementById("specialtyLabel").innerText = t.specialtyLabel;
        document.getElementById("clinicLabel").innerText = t.clinicLabel;
        document.getElementById("experienceLabel").innerText = t.experienceLabel;
        document.getElementById("hoursLabel").innerText = t.hoursLabel;
        document.getElementById("phoneLabel").innerText = t.phoneLabel;
        document.getElementById("feeTitle").innerText = t.feeTitle;
        document.getElementById("visitPriceLabel").innerText = t.visitPriceLabel;
        document.getElementById("ratingTitle").innerText = t.ratingTitle;
        document.getElementById("ratingLabelMain").innerText = t.ratingLabelMain;
        document.getElementById("aboutTitle").innerText = t.aboutTitle;

        var expTitle = document.querySelector(".experience-section h3");
        if(expTitle) expTitle.innerHTML = "<span>⭐</span> " + t.yourExperience;
        var ratingLabelExp = document.querySelector(".rating-label-exp");
        if(ratingLabelExp) ratingLabelExp.innerText = t.ratingTextExp;
        var feedbackTextarea = document.getElementById("feedbackText");
        if(feedbackTextarea) feedbackTextarea.placeholder = t.placeholderExp;
        var sendBtnExp = document.querySelector(".btn-send-exp");
        if(sendBtnExp) sendBtnExp.innerHTML = "📤 " + t.sendBtn;
        var noReviewsMsg = document.querySelector(".no-reviews-exp");
        if(noReviewsMsg && noReviewsMsg.innerText !== "") noReviewsMsg.innerText = t.noReviews;

        updateActionButtons();
    }

    function toggleMenu(){
        var s = document.getElementById("sidebar");
        s.style.left = s.style.left === "0px" ? "-280px" : "0px";
    }

    // ========== AUTH / BOOKING ==========
    function updateActionButtons(){
        var t = translations[currentLang];
        var loggedIn = <?php echo e(auth()->check() ? 'true' : 'false'); ?>;
        var actionHtml = '<div class="btn-group"><button class="btn btn-back" onclick="history.back()">' + t.backBtn + '</button>';
        if(!loggedIn){
            actionHtml += '</div><div class="auth-message"><p>' + t.loginRequired + '</p><div class="auth-buttons"><button class="btn-login" onclick="goToLogin()">' + t.loginBtn + '</button><button class="btn-register" onclick="goToRegister()">' + t.registerBtn + '</button></div></div>';
        } else {
            actionHtml += '<button class="btn btn-book" onclick="bookAppointment()">' + t.bookBtn + '</button></div>';
        }
        document.getElementById("actionContainer").innerHTML = actionHtml;
    }

    function goToLogin(){
        window.location.href = "<?php echo e(route('login', ['type'=>'patient'])); ?>";
    }
    function goToRegister(){
        window.location.href = "<?php echo e(route('register', ['type'=>'patient'])); ?>";
    }
    function bookAppointment(){
        window.location.href = "<?php echo e(route('appointment.create', $doctor->id)); ?>";
    }

    // ========== EXPERIENCE SECTION (REVIEWS) ==========
    var doctorId = <?php echo e($doctor->id); ?>;
    var doctorRating = 0;
    var ratingTexts = ["", "Poor", "Fair", "Good", "Very Good", "Excellent"];
    var ratingTextsAr = ["", "ضعيف", "مقبول", "جيد", "جيد جداً", "ممتاز"];
    var ratingTextsFr = ["", "Médiocre", "Moyen", "Bien", "Très bien", "Excellent"];

    function getRatingText(rating){
        if(currentLang === "ar") return ratingTextsAr[rating];
        if(currentLang === "fr") return ratingTextsFr[rating];
        return ratingTexts[rating];
    }

    function buildExperienceSection(){
        var t = translations[currentLang];
        var html = '<div class="experience-section">';
        html += '<h3><span>⭐</span> ' + t.yourExperience + '</h3>';
        html += '<div class="rating-box-exp">';
        html += '<div class="rating-row-exp">';
        html += '<span class="rating-label-exp">' + t.ratingTextExp + '</span>';
        html += '<div class="rating-stars-box-exp">';
        html += '<div class="star-rating-exp" id="starRatingExp">';
        for(var i=1;i<=5;i++) html += '<span class="star-exp" data-rating="'+i+'">☆</span>';
        html += '</div>';
        html += '<span class="rating-text-exp" id="ratingTextExp"></span>';
        html += '</div></div></div>';
        html += '<div class="feedback-box-exp">';
        html += '<textarea id="feedbackText" placeholder="' + t.placeholderExp + '"></textarea>';
        html += '</div>';
        html += '<button class="btn-send-exp" onclick="submitExperience()">📤 ' + t.sendBtn + '</button>';
        html += '<div class="reviews-list-exp" id="reviewsListExp"></div>';
        html += '</div>';

        document.getElementById("experienceContainer").innerHTML = html;

        var starsExp = document.querySelectorAll(".star-exp");
        for(var i=0; i<starsExp.length; i++){
            starsExp[i].addEventListener("click", function(){
                doctorRating = parseInt(this.getAttribute("data-rating"));
                updateStarsExp();
            });
            starsExp[i].addEventListener("mouseover", function(){
                var r = parseInt(this.getAttribute("data-rating"));
                highlightStarsExp(r);
            });
        }
        document.getElementById("starRatingExp").addEventListener("mouseleave", function(){
            updateStarsExp();
        });

        displayReviewsExp();
    }

    function highlightStarsExp(rating){
        var starsExp = document.querySelectorAll(".star-exp");
        for(var i=0; i<starsExp.length; i++){
            if(i < rating){
                starsExp[i].innerHTML = "★";
                starsExp[i].style.color = "#fbbf24";
            } else {
                starsExp[i].innerHTML = "☆";
                starsExp[i].style.color = "rgba(255,255,255,0.3)";
            }
        }
    }

    function updateStarsExp(){
        var starsExp = document.querySelectorAll(".star-exp");
        var textSpan = document.getElementById("ratingTextExp");
        for(var i=0; i<starsExp.length; i++){
            if(i < doctorRating){
                starsExp[i].innerHTML = "★";
                starsExp[i].classList.add("active");
            } else {
                starsExp[i].innerHTML = "☆";
                starsExp[i].classList.remove("active");
            }
        }
        if(doctorRating > 0){
            textSpan.innerText = getRatingText(doctorRating);
        } else {
            textSpan.innerText = "";
        }
    }

    function submitExperience(){
        var feedback = document.getElementById("feedbackText").value.trim();
        if(doctorRating === 0){
            alert("Please select a rating");
            return;
        }
        if(feedback === ""){
            alert("Please write your feedback");
            return;
        }

        fetch('<?php echo e(url("/api/reviews")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                rating: doctorRating,
                comment: feedback,
                reviewable_type: 'App\\Models\\Doctor',
                reviewable_id: doctorId
            })
        }).then(response => response.json()).then(data => {
            doctorRating = 0;
            updateStarsExp();
            document.getElementById("feedbackText").value = "";
            displayReviewsExp();
            alert("Thank you for your feedback!");
        }).catch(error => {
            alert("An error occurred. Please try again.");
        });
    }

    function displayReviewsExp(){
        fetch('<?php echo e(url("/api/reviews/doctor")); ?>/'+doctorId)
            .then(response => response.json())
            .then(data => {
                var t = translations[currentLang];
                var listHtml = "";
                if(data.data.length === 0){
                    listHtml = '<div class="no-reviews-exp">' + t.noReviews + '</div>';
                } else {
                    for(var i=0; i<data.data.length; i++){
                        var r = data.data[i];
                        listHtml += '<div class="review-item-exp">';
                        listHtml += '<div class="review-header-exp">';
                        listHtml += '<span class="review-stars-exp">' + "★".repeat(r.rating) + "☆".repeat(5-r.rating) + '</span>';
                        listHtml += '<span class="review-date-exp">' + new Date(r.created_at).toLocaleDateString() + '</span>';
                        listHtml += '</div>';
                        listHtml += '<div class="review-text-exp">"' + r.comment + '"</div>';
                        listHtml += '</div>';
                    }
                }
                document.getElementById("reviewsListExp").innerHTML = listHtml;
            });
    }

    // Initialize page
    updateActionButtons();
    buildExperienceSection();
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/front/doctor-profile.blade.php ENDPATH**/ ?>