

<?php $__env->startSection('title', 'MediEase - Find Best Clinics in Algeria'); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    /* نفس الـ Styles الخاصة بالصفحة الرئيسية (احتفظ بها كما هي) */
    .hero{padding:120px 20px 80px 20px;text-align:center;}
    .hero-content h1{font-size:3.8rem;font-weight:800;margin-bottom:20px;color:white;text-shadow:0 4px 20px rgba(0,0,0,0.3);letter-spacing:-1px;background:linear-gradient(135deg,#fff,#3b82f6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
    .hero-content p{font-size:1.3rem;margin-bottom:45px;color:rgba(255,255,255,0.92);text-shadow:0 2px 8px rgba(0,0,0,0.2);font-weight:400;}
    .search-container{max-width:800px;margin:0 auto;position:relative;}
    .search-box{display:flex;gap:12px;background:rgba(255,255,255,0.1);backdrop-filter:blur(20px);padding:8px;border-radius:80px;border:1px solid rgba(59,130,246,0.4);box-shadow:0 10px 30px rgba(0,0,0,0.2);}
    .search-box input{flex:1;padding:18px 25px;border:none;border-radius:60px;font-size:16px;outline:none;background:white;color:#1e293b;font-weight:500;box-shadow:0 2px 8px rgba(0,0,0,0.05);}
    .search-box button{padding:18px 38px;border:none;border-radius:60px;font-size:16px;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:white;cursor:pointer;font-weight:700;transition:0.2s;box-shadow:0 4px 15px rgba(37,99,235,0.4);}
    .search-suggestions{position:absolute;top:100%;left:0;right:0;background:white;border-radius:20px;margin-top:8px;box-shadow:0 20px 40px rgba(0,0,0,0.15);max-height:350px;overflow-y:auto;z-index:50;display:none;}
    .suggestion-item{padding:14px 20px;display:flex;align-items:center;gap:12px;cursor:pointer;border-bottom:1px solid #f1f5f9;}
    .suggestion-item:hover{background:#eff6ff;}
    .about-modern{margin-top:80px;background:rgba(25,45,65,0.5);backdrop-filter:blur(20px);padding:70px 40px;border-top:1px solid rgba(59,130,246,0.2);border-bottom:1px solid rgba(59,130,246,0.2);}
    .services-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:35px;margin-bottom:30px;}
    .service-item{background:rgba(255,255,255,0.05);border-radius:28px;padding:40px 30px;text-align:center;backdrop-filter:blur(10px);border:1px solid rgba(59,130,246,0.25);transition:0.35s;cursor:pointer;}
    .service-item:hover{transform:translateY(-8px);background:rgba(59,130,246,0.12);}
    .service-icon{font-size:54px;margin-bottom:25px;background:linear-gradient(135deg,#3b82f6,#60a5fa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}
    .service-item h3{color:white;font-size:22px;margin-bottom:15px;font-weight:700;}
    .service-item p{color:rgba(255,255,255,0.75);font-size:14px;line-height:1.7;}
    .sections-bottom{background:rgba(25,45,65,0.4);backdrop-filter:blur(15px);padding:50px 30px;}
    .section{text-align:center;padding:30px 20px;max-width:800px;margin:0 auto;}
    .section h2{color:white;margin-bottom:15px;font-size:32px;font-weight:700;}
    .reviews-container{max-width:800px;margin:0 auto;padding:30px 20px;}
    .reviews-container h2{color:white;text-align:center;margin-bottom:30px;font-size:32px;}
    .review-form{background:rgba(255,255,255,0.05);border-radius:30px;padding:35px;border:1px solid rgba(59,130,246,0.25);max-width:600px;margin:0 auto;backdrop-filter:blur(10px);}
    .star-rating{display:flex;justify-content:center;gap:12px;}
    .star{font-size:38px;color:rgba(255,255,255,0.3);cursor:pointer;}
    .star.active,.star:hover{color:#3b82f6;}
    .review-form textarea{width:100%;padding:16px;border:none;border-radius:20px;background:rgba(255,255,255,0.95);margin-bottom:20px;}
    .btn-submit{width:100%;padding:16px;background:linear-gradient(135deg,#2563eb,#1d4ed8);color:white;border:none;border-radius:60px;cursor:pointer;}
    .reviews-list{margin-top:30px;max-height:280px;overflow-y:auto;}
    .review-item{background:rgba(255,255,255,0.06);border-radius:20px;padding:18px;margin-bottom:12px;}
    .review-header{display:flex;align-items:center;gap:12px;margin-bottom:10px;}
    .review-avatar{width:38px;height:38px;background:linear-gradient(135deg,#3b82f6,#60a5fa);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;}
    .review-stars{color:#3b82f6;font-size:12px;letter-spacing:2px;}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="hero" id="home">
    <div class="hero-content">
        <h1 id="title"><?php echo app('translator')->get('Book Your Medical Appointment Easily'); ?></h1>
        <p id="desc"><?php echo app('translator')->get('Find the best clinics and doctors in Algeria'); ?></p>
        <div class="search-container">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="<?php echo app('translator')->get('Search for clinic or doctor...'); ?>" autocomplete="off">
                <button onclick="searchItem()" id="searchBtn"><i class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
            </div>
            <div class="search-suggestions" id="searchSuggestions"></div>
        </div>
    </div>
</section>

<div class="about-modern" id="about">
    <div class="container-modern">
        <div class="modern-title">
            <h2 id="aboutMainTitle"><?php echo app('translator')->get('About MediEase'); ?></h2>
            <p id="aboutMainDesc"><?php echo app('translator')->get('Your comprehensive healthcare management platform in Algeria'); ?></p>
        </div>
        <div class="services-grid">
            <?php
                $services = [
                    ['icon'=>'fa-building', 'title'=>'Multi-Clinic Management', 'desc'=>'Manage multiple clinics efficiently. Browse, search and book appointments at the best clinics across Algeria with ease.'],
                    ['icon'=>'fa-calendar-check', 'title'=>'Smart Appointment System', 'desc'=>'Organize patient bookings seamlessly. Schedule, reschedule or cancel appointments with real-time availability updates.'],
                    ['icon'=>'fa-notes-medical', 'title'=>'Doctor Directory & Profiles', 'desc'=>'Comprehensive doctor listings with specialties, experience, ratings, and working hours. Find the right specialist for your needs.'],
                    ['icon'=>'fa-bullhorn', 'title'=>'Medical Announcements', 'desc'=>'Stay updated with the latest health news, clinic promotions, vaccination campaigns, and medical events in your area.'],
                    ['icon'=>'fa-comment-medical', 'title'=>'Medical Advice & Guidance', 'desc'=>'Access reliable health tips, preventive care recommendations, and professional medical guidance for better health management.'],
                    ['icon'=>'fa-star', 'title'=>'Patient Reviews & Ratings', 'desc'=>'Share your healthcare experiences and read genuine patient reviews to make informed decisions about clinics and doctors.']
                ];
            ?>
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="service-item">
                <div class="service-icon"><i class="fas <?php echo e($service['icon']); ?>"></i></div>
                <h3><?php echo app('translator')->get($service['title']); ?></h3>
                <p><?php echo app('translator')->get($service['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<div class="sections-bottom">
    <section id="contact" class="section">
        <h2><i class="fas fa-phone-alt"></i> <?php echo app('translator')->get('Contact Us'); ?></h2>
        <p><i class="fas fa-envelope"></i> Email: MediEase@gmail.com</p>
        <p><i class="fas fa-phone"></i> Phone: 0555 00 00 00</p>
    </section>
    <hr>
    <div class="reviews-container">
        <h2><i class="fas fa-star"></i> <?php echo app('translator')->get('Your Experience'); ?></h2>
        <div class="review-form">
            <div class="rating-container">
                <label><?php echo app('translator')->get('Rating:'); ?></label>
                <div class="star-rating" id="starRating">
                    <span class="star" data-rating="1">☆</span><span class="star" data-rating="2">☆</span><span class="star" data-rating="3">☆</span><span class="star" data-rating="4">☆</span><span class="star" data-rating="5">☆</span>
                </div>
                <div class="rating-text" id="ratingText"><?php echo app('translator')->get('Click to rate'); ?></div>
            </div>
            <textarea id="reviewFeedback" placeholder="<?php echo app('translator')->get('Write your experience...'); ?>"></textarea>
            <button class="btn-submit" onclick="submitReview()"><i class="fas fa-paper-plane"></i> <?php echo app('translator')->get('Send Feedback'); ?></button>
        </div>
        <div class="reviews-list" id="reviewsList">
            <div class="no-reviews" id="noReviewsMsg"><?php echo app('translator')->get('No reviews yet. Be the first to share your experience!'); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // ==================== تعريف جميع الدوال هنا (لضمان عدم وجود أخطاء) ====================
    
    // دوال القائمة الجانبية والقوائم المنسدلة (يجب أن تكون معرفة قبل استخدامها)
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
            en: { login: "Login ▼", register: "Register ▼", home: "Home", about: "About", contact: "Contact", searchPlaceholder: "Search for clinic or doctor...", searchBtn: "Search", aboutMainTitle: "About MediEase", aboutMainDesc: "Your comprehensive healthcare management platform in Algeria", contactTitle: "Contact Us", reviewsTitle: "Your Experience", ratingLabel: "Rating:", reviewPlaceholder: "Write your experience...", submitBtn: "Send Feedback", noReviews: "No reviews yet. Be the first to share your experience!" },
            ar: { login: "تسجيل الدخول ▼", register: "تسجيل ▼", home: "الرئيسية", about: "من نحن", contact: "اتصل بنا", searchPlaceholder: "ابحث عن عيادة أو طبيب...", searchBtn: "بحث", aboutMainTitle: "حول MediEase", aboutMainDesc: "منصتك الشاملة لإدارة الرعاية الصحية في الجزائر", contactTitle: "اتصل بنا", reviewsTitle: "تقييمك", ratingLabel: "التقييم:", reviewPlaceholder: "اكتب تجربتك...", submitBtn: "إرسال التقييم", noReviews: "لا توجد تقييمات بعد. كن أول من يشارك تجربتك!" },
            fr: { login: "Connexion ▼", register: "Inscription ▼", home: "Accueil", about: "À propos", contact: "Contact", searchPlaceholder: "Rechercher une clinique ou un médecin...", searchBtn: "Rechercher", aboutMainTitle: "À propos de MediEase", aboutMainDesc: "Votre plateforme complète de gestion des soins de santé en Algérie", contactTitle: "Contactez-nous", reviewsTitle: "Votre Expérience", ratingLabel: "Évaluation:", reviewPlaceholder: "Écrivez votre expérience...", submitBtn: "Envoyer", noReviews: "Pas encore d'avis. Soyez le premier à partager votre expérience!" }
        };
        var t = texts[lang] || texts.en;
        
        var loginBtn = document.getElementById("loginBtn");
        var registerBtn = document.getElementById("registerBtn");
        var homeLink = document.getElementById("homeLink");
        var aboutLink = document.getElementById("aboutLink");
        var contactLink = document.getElementById("contactLink");
        var searchInput = document.getElementById("searchInput");
        var searchBtn = document.getElementById("searchBtn");
        var aboutMainTitle = document.getElementById("aboutMainTitle");
        var aboutMainDesc = document.getElementById("aboutMainDesc");
        var contactTitle = document.querySelector(".section h2");
        var reviewsTitle = document.querySelector(".reviews-container h2");
        var ratingLabel = document.querySelector(".rating-container label");
        var reviewTextarea = document.getElementById("reviewFeedback");
        var submitBtn = document.querySelector(".btn-submit");
        var noReviewsMsg = document.getElementById("noReviewsMsg");
        
        if (loginBtn) loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> ' + t.login;
        if (registerBtn) registerBtn.innerHTML = '<i class="fas fa-user-plus"></i> ' + t.register;
        if (homeLink) homeLink.innerText = t.home;
        if (aboutLink) aboutLink.innerText = t.about;
        if (contactLink) contactLink.innerText = t.contact;
        if (searchInput) searchInput.placeholder = t.searchPlaceholder;
        if (searchBtn) searchBtn.innerHTML = '<i class="fas fa-search"></i> ' + t.searchBtn;
        if (aboutMainTitle) aboutMainTitle.innerText = t.aboutMainTitle;
        if (aboutMainDesc) aboutMainDesc.innerText = t.aboutMainDesc;
        if (contactTitle) contactTitle.innerHTML = '<i class="fas fa-phone-alt"></i> ' + t.contactTitle;
        if (reviewsTitle) reviewsTitle.innerHTML = '<i class="fas fa-star"></i> ' + t.reviewsTitle;
        if (ratingLabel) ratingLabel.innerText = t.ratingLabel;
        if (reviewTextarea) reviewTextarea.placeholder = t.reviewPlaceholder;
        if (submitBtn) submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> ' + t.submitBtn;
        if (noReviewsMsg) noReviewsMsg.innerText = t.noReviews;
        
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

    // ==================== منطق البحث والتقييمات ====================
    var clinicsData = <?php echo json_encode($clinics ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
var doctorsData = <?php echo json_encode($doctors ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    var allItems = [];
    clinicsData.forEach(c => { allItems.push({name: c.name, detail: c.location, type: "clinic", data: c}); });
    doctorsData.forEach(d => { allItems.push({name: d.name, detail: d.specialty + " - " + (d.clinic?.name || ''), type: "doctor", data: d}); });

    var defaultClinicId = (clinicsData.length > 0) ? clinicsData[0].id : 1;
    var searchInput = document.getElementById("searchInput");
    var suggestionsDiv = document.getElementById("searchSuggestions");

    if (searchInput) {
        searchInput.addEventListener("input", function() {
            var query = this.value.toLowerCase().trim();
            if(query === "") { suggestionsDiv.style.display = "none"; return; }
            var matches = allItems.filter(item => item.name.toLowerCase().includes(query) || item.detail.toLowerCase().includes(query)).slice(0,8);
            if(matches.length === 0) { suggestionsDiv.style.display = "none"; return; }
            var html = "";
            matches.forEach(item => {
                html += `<div class="suggestion-item" data-name="${item.name}" data-type="${item.type}">
                            <div class="suggestion-icon">${item.type==="clinic"?"🏥":"👨‍⚕️"}</div>
                            <div class="suggestion-content"><div class="suggestion-name">${item.name}</div><div class="suggestion-detail">${item.detail}</div></div>
                            <div class="suggestion-type">${item.type==="clinic"?"Clinic":"Doctor"}</div>
                         </div>`;
            });
            suggestionsDiv.innerHTML = html;
            suggestionsDiv.style.display = "block";
            document.querySelectorAll(".suggestion-item").forEach(el => {
                el.addEventListener("click", function() {
                    searchInput.value = this.getAttribute("data-name");
                    suggestionsDiv.style.display = "none";
                });
            });
        });
    }

    document.addEventListener("click", function(e) {
        if (searchInput && suggestionsDiv && !searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = "none";
        }
    });

    function searchItem() {
        var query = searchInput.value.trim();
        if(query === "") { alert("Please enter a clinic or doctor name"); return; }
        var match = allItems.find(item => item.name.toLowerCase() === query.toLowerCase()) || allItems.find(item => item.name.toLowerCase().includes(query.toLowerCase()));
        if(!match) { alert("No clinic or doctor found."); return; }
        if(match.type === "clinic") window.location.href = `/clinic/${match.data.id}`;
        else window.location.href = `/doctor/${match.data.id}`;
    }

    // نظام التقييمات
    var currentRating = 0;
    var stars = document.querySelectorAll(".star");
    stars.forEach(star => {
        star.addEventListener("click", function() { setRating(parseInt(this.getAttribute("data-rating"))); });
        star.addEventListener("mouseover", function() { highlightStars(parseInt(this.getAttribute("data-rating"))); });
    });
    document.getElementById("starRating").addEventListener("mouseleave", function() { highlightStars(currentRating); });

    function highlightStars(r) {
        stars.forEach((star,i) => {
            star.innerHTML = i < r ? "★" : "☆";
            star.classList.toggle("active", i < r);
        });
    }

    function setRating(r) {
        currentRating = r;
        highlightStars(r);
        var t = ["", "Poor", "Fair", "Good", "Very Good", "Excellent"];
        document.getElementById("ratingText").innerHTML = r > 0 ? "★".repeat(r) + " " + t[r] : "Click to rate";
    }

    function submitReview() {
        var feedback = document.getElementById("reviewFeedback").value.trim();
        if(currentRating === 0) { alert("Please select a rating"); return; }
        if(feedback === "") { alert("Please write your feedback"); return; }
        fetch('/api/reviews', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                rating: currentRating,
                comment: feedback,
                reviewable_type: 'App\\Models\\Clinic',
                reviewable_id: defaultClinicId
            })
        }).then(response => response.json())
          .then(data => {
              if(data.success) {
                  alert("Thank you for your review!");
                  document.getElementById("reviewFeedback").value = "";
                  currentRating = 0;
                  highlightStars(0);
                  document.getElementById("ratingText").innerHTML = "Click to rate";
                  displayReviews();
              } else {
                  alert("Error submitting review. Please try again.");
              }
          })
          .catch(error => {
              console.error("Error:", error);
              alert("Network error. Please try again.");
          });
    }

    function displayReviews() {
        fetch(`/api/reviews/clinic/${defaultClinicId}`)
            .then(response => response.json())
            .then(data => {
                var reviewsList = document.getElementById("reviewsList");
                var noReviewsMsg = document.getElementById("noReviewsMsg");
                if(data.success && data.data.length > 0) {
                    if(noReviewsMsg) noReviewsMsg.style.display = "none";
                    var html = "";
                    data.data.forEach(review => {
                        var starsDisplay = "★".repeat(review.rating) + "☆".repeat(5 - review.rating);
                        html += `
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-avatar">👤</div>
                                    <div class="review-info">
                                        <div class="review-name">${review.user ? review.user.name : 'User'}</div>
                                        <div class="review-stars">${starsDisplay}</div>
                                    </div>
                                </div>
                                <div class="review-text">"${escapeHtml(review.comment)}"</div>
                                <div class="review-date">${new Date(review.created_at).toLocaleDateString()}</div>
                            </div>
                        `;
                    });
                    reviewsList.innerHTML = html;
                } else {
                    if(noReviewsMsg) noReviewsMsg.style.display = "block";
                }
            })
            .catch(error => console.error("Error loading reviews:", error));
    }

    function escapeHtml(str) {
        if(!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if(m === '&') return '&amp;';
            if(m === '<') return '&lt;';
            if(m === '>') return '&gt;';
            return m;
        });
    }

    // تحميل التقييمات عند تحميل الصفحة
    window.addEventListener("DOMContentLoaded", function() {
        displayReviews();
    });
    // ==================== الضغط على شعار MediEase 3 مرات للتوجيه إلى Login Super Admin ====================
(function() {
    let logoClicks = 0;
    let logoTimer;
    let clickCount = 0;
    
    // البحث عن شعار MediEase
    function findLogo() {
        let logo = document.querySelector('.logo');
        if (!logo) logo = document.querySelector('.navbar h2');
        if (!logo) logo = document.querySelector('h2.logo');
        if (!logo) {
            const allElements = document.querySelectorAll('*');
            for (let element of allElements) {
                if (element.innerText && element.innerText.trim() === 'MediEase') {
                    logo = element;
                    break;
                }
            }
        }
        return logo;
    }
    
    const logo = findLogo();
    
    if (logo) {
        // إضافة cursor pointer
        logo.style.cursor = 'pointer';
        logo.style.transition = 'transform 0.1s ease';
        
        logo.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            logoClicks++;
            clickCount++;
            
            // تأثير الضغط
            logo.style.transform = 'scale(0.95)';
            setTimeout(() => {
                logo.style.transform = 'scale(1)';
            }, 150);
            
            // بدء المؤقت عند أول ضغطة
            if (logoClicks === 1) {
                logoTimer = setTimeout(() => {
                    logoClicks = 0;
                    clickCount = 0;
                }, 3000);
            }
            
            // عند 3 ضغطات متتالية
            if (logoClicks === 3) {
                clearTimeout(logoTimer);
                logoClicks = 0;
                
                // تأثير اهتزاز للتنبيه
                logo.style.animation = 'shake 0.3s ease';
                setTimeout(() => {
                    logo.style.animation = '';
                }, 300);
                
                // التوجيه إلى صفحة Login الخاصة بـ Super Admin
                window.location.href = "<?php echo e(route('admin.login.form')); ?>";
            }
        });
        
        // إضافة تأثير اهتزاز
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);
    } else {
        // محاولة مرة أخرى بعد تحميل الصفحة
        setTimeout(() => {
            const logoRetry = document.querySelector('.logo, .navbar h2, h2.logo');
            if (logoRetry && !logoRetry._clickHandler) {
                logoRetry.style.cursor = 'pointer';
                logoRetry._clickHandler = true;
                
                let retryClicks = 0;
                let retryTimer;
                
                logoRetry.addEventListener('click', function() {
                    retryClicks++;
                    
                    if (retryClicks === 1) {
                        retryTimer = setTimeout(() => { retryClicks = 0; }, 3000);
                    }
                    
                    if (retryClicks === 3) {
                        clearTimeout(retryTimer);
                        retryClicks = 0;
                        window.location.href = "<?php echo e(route('admin.login.form')); ?>";
                    }
                });
            }
        }, 500);
    }
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/front/index.blade.php ENDPATH**/ ?>