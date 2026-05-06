@extends('layouts.front')

@section('title', $clinic->name . ' - Full Details')

@section('extra_styles')
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
    min-height:100vh;
    display:flex;
    flex-direction:column;
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
.container{max-width:750px;width:100%;margin:40px auto;padding:0 20px;}
.details-card{background:transparent;}
.clinic-gallery{width:100%;height:280px;overflow:hidden;border-radius:30px;margin-bottom:20px;}
.clinic-gallery img{width:100%;height:100%;object-fit:cover;}
.header{text-align:center;margin-bottom:25px;}
.header h1{color:white;font-size:32px;font-weight:700;text-shadow:0 2px 10px rgba(0,0,0,0.3);}
.header p{color:rgba(255,255,255,0.8);font-size:14px;margin-top:5px;}
.content{padding:0;}
.info-section{background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);border-radius:25px;padding:20px;margin-bottom:20px;}
.info-section h3{color:white;font-size:18px;margin-bottom:15px;border-bottom:1px solid rgba(255,255,255,0.2);padding-bottom:10px;display:flex;align-items:center;gap:8px;}
.info-row{display:flex;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.1);}
.info-row:last-child{border-bottom:none;}
.info-icon{width:45px;font-size:22px;}
.info-label{font-weight:600;color:rgba(255,255,255,0.8);width:120px;font-size:14px;}
.info-value{color:white;font-size:14px;flex:1;}
.map-link{color:#fbbf24;text-decoration:none;font-weight:600;}
.map-link:hover{text-decoration:underline;}

.btn-view-doctors{width:100%;padding:15px;background:#8b5cf6;border:none;border-radius:20px;font-size:16px;font-weight:bold;color:white;cursor:pointer;margin:15px 0;text-align:center;transition:0.2s;}
.btn-view-doctors:hover{background:#7c3aed;transform:translateY(-2px);}

.button-group{display:flex;gap:10px;margin-top:20px;}
.btn-back,.btn-book-appointment{flex:1;padding:14px;border:none;border-radius:50px;font-size:14px;font-weight:600;cursor:pointer;transition:0.2s;}
.btn-back{background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.3);}
.btn-back:hover{background:rgba(255,255,255,0.3);}
.btn-book-appointment{background:#f59e0b;color:white;}
.btn-book-appointment:hover{background:#d97706;}

.rating-stars{color:#fbbf24;letter-spacing:2px;}
.review-text{color:rgba(255,255,255,0.7);font-size:12px;margin-left:10px;}
.price-tag{background:rgba(255,255,255,0.2);padding:5px 12px;border-radius:50px;font-size:12px;font-weight:600;color:white;display:inline-block;}
.service-badge{background:rgba(255,255,255,0.15);padding:5px 12px;border-radius:50px;font-size:12px;color:white;margin:3px;display:inline-block;}

/* Experience Section */
.experience-section{background:rgba(255,255,255,0.12);backdrop-filter:blur(10px);border-radius:25px;padding:25px;margin-top:20px;border:1px solid rgba(255,255,255,0.15);}
.experience-section h3{color:white;font-size:22px;font-weight:700;margin-bottom:20px;text-align:center;text-shadow:0 2px 5px rgba(0,0,0,0.2);display:flex;align-items:center;justify-content:center;gap:8px;}
.experience-section h3 span{color:#fbbf24;}

.rating-box{background:rgba(255,255,255,0.08);border-radius:20px;padding:20px;margin-bottom:20px;}
.rating-row{display:flex;align-items:center;gap:15px;flex-wrap:wrap;}
.rating-label{color:white;font-size:15px;font-weight:600;min-width:70px;}
.rating-stars-box{display:flex;align-items:center;gap:10px;flex:1;}
.star-rating-exp{display:flex;gap:5px;}
.star-exp{font-size:28px;color:rgba(255,255,255,0.3);cursor:pointer;transition:0.2s;}
.star-exp:hover,.star-exp.active{color:#fbbf24;}
.rating-text-exp{color:#fbbf24;font-size:16px;font-weight:600;margin-left:10px;}

.feedback-box{margin-bottom:20px;}
.feedback-box textarea{width:100%;padding:15px;border:none;border-radius:15px;font-size:14px;outline:none;background:rgba(255,255,255,0.9);color:#1e293b;resize:vertical;min-height:100px;font-family:inherit;}
.feedback-box textarea:focus{background:white;}
.feedback-box textarea::placeholder{color:#94a3b8;}

.btn-send{width:100%;padding:14px;background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:50px;font-size:16px;font-weight:700;cursor:pointer;transition:0.2s;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-send:hover{background:linear-gradient(135deg,#d97706,#f59e0b);transform:translateY(-2px);}

.reviews-list-exp{margin-top:25px;max-height:300px;overflow-y:auto;padding-right:5px;}
.review-item-exp{background:rgba(255,255,255,0.08);border-radius:15px;padding:15px;margin-bottom:10px;border:1px solid rgba(255,255,255,0.1);}
.review-header-exp{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.review-stars-exp{color:#fbbf24;font-size:14px;letter-spacing:2px;}
.review-text-exp{color:rgba(255,255,255,0.9);font-size:13px;line-height:1.5;margin-bottom:5px;}
.review-date-exp{color:rgba(255,255,255,0.5);font-size:11px;}
.no-reviews-exp{text-align:center;color:rgba(255,255,255,0.6);padding:20px;font-size:14px;}

.reviews-list-exp::-webkit-scrollbar{width:5px;}
.reviews-list-exp::-webkit-scrollbar-track{background:rgba(255,255,255,0.1);border-radius:10px;}
.reviews-list-exp::-webkit-scrollbar-thumb{background:rgba(255,255,255,0.3);border-radius:10px;}

@media(max-width:600px){.container{margin:20px auto;}.rating-row{flex-direction:column;align-items:flex-start;}}
body[dir="rtl"] .sidebar{left:auto;right:-280px;}
body[dir="rtl"] .sidebar a:hover{padding-right:40px;padding-left:30px;}
</style>
@endsection

@section('content')
<div class="container">
    <div class="details-card">
        <div class="clinic-gallery">
            <img src="{{ $clinic->image }}" alt="{{ $clinic->name }}" onerror="this.src='https://placehold.co/750x400/1e3a8a/white?text={{ urlencode($clinic->name) }}'">
        </div>
        
        <div class="header">
            <h1>🏥 {{ $clinic->name }}</h1>
            <p>Complete Clinic Information</p>
        </div>
        
        <div class="content">
            <!-- Contact Information -->
            <div class="info-section">
                <h3>📋 Contact Information</h3>
                <div class="info-row">
                    <div class="info-icon">📍</div>
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $clinic->address }}</div>
                </div>
                <div class="info-row">
                    <div class="info-icon">📞</div>
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $clinic->phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-icon">📧</div>
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $clinic->email ?? 'Not provided' }}</div>
                </div>
                @if($clinic->map_link)
                <div class="info-row">
                    <div class="info-icon">🗺️</div>
                    <div class="info-label">Google Maps</div>
                    <div class="info-value"><a href="{{ $clinic->map_link }}" target="_blank" class="map-link">Open in Google Maps →</a></div>
                </div>
                @endif
                @if($clinic->nearby_landmark)
                <div class="info-row">
                    <div class="info-icon">🕌</div>
                    <div class="info-label">Nearby</div>
                    <div class="info-value">{{ $clinic->nearby_landmark }}</div>
                </div>
                @endif
            </div>
            
            <!-- Working Hours -->
            <div class="info-section">
                <h3>⏰ Working Hours</h3>
                <div class="info-row">
                    <div class="info-icon">🕒</div>
                    <div class="info-label">Schedule</div>
                    <div class="info-value">{{ $clinic->working_hours ?? 'Contact clinic for hours' }}</div>
                </div>
            </div>
            
            <!-- Reviews & Ratings -->
            <div class="info-section">
                <h3>⭐ Reviews & Ratings</h3>
                <div class="info-row">
                    <div class="info-icon">🏆</div>
                    <div class="info-label">Rating</div>
                    <div class="info-value">
                        <span class="rating-stars" id="averageStars"></span>
                        <span class="review-text" id="ratingText">Loading...</span>
                    </div>
                </div>
            </div>
            
            <!-- Price Range -->
            @if($clinic->price_range)
            <div class="info-section">
                <h3>💰 Price Range</h3>
                <div class="info-row">
                    <div class="info-icon">💵</div>
                    <div class="info-label">Cost</div>
                    <div class="info-value"><span class="price-tag">{{ $clinic->price_range }}</span></div>
                </div>
            </div>
            @endif
            
            <!-- Available Services -->
            @if($clinic->services && count($clinic->services) > 0)
            <div class="info-section">
                <h3>🩺 Available Services</h3>
                <div class="info-row">
                    <div class="info-icon">🏥</div>
                    <div class="info-label">Services</div>
                    <div class="info-value">
                        @foreach($clinic->services as $service)
                            <span class="service-badge">✓ {{ $service->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- View Doctors Button -->
            <button class="btn-view-doctors" onclick="goToDoctors()">
                👨‍⚕️ View All Doctors ({{ $clinic->doctors->count() }})
            </button>
            
            <!-- Button Group -->
            <div class="button-group">
                <button class="btn-back" onclick="goBack()">← Back</button>
                <button class="btn-book-appointment" onclick="bookClinicAppointment()">📅 Book Appointment</button>
            </div>
            
            <!-- Experience Section -->
            <div class="experience-section">
                <h3><span>⭐</span> Your Experience</h3>
                <div class="rating-box">
                    <div class="rating-row">
                        <span class="rating-label">Rating:</span>
                        <div class="rating-stars-box">
                            <div class="star-rating-exp" id="starRatingExp">
                                <span class="star-exp" data-rating="1">☆</span>
                                <span class="star-exp" data-rating="2">☆</span>
                                <span class="star-exp" data-rating="3">☆</span>
                                <span class="star-exp" data-rating="4">☆</span>
                                <span class="star-exp" data-rating="5">☆</span>
                            </div>
                            <span class="rating-text-exp" id="ratingTextExp"></span>
                        </div>
                    </div>
                </div>
                <div class="feedback-box">
                    <textarea id="feedbackText" placeholder="Write your experience..."></textarea>
                </div>
                <button class="btn-send" onclick="submitExperience()">📤 Send</button>
                <div class="reviews-list-exp" id="reviewsListExp"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let clinicRating = 0;
let ratingTexts = ["", "Poor", "Fair", "Good", "Very Good", "Excellent"];
let selectedLang = localStorage.getItem('selectedLang') || 'en';
let clinicId = {{ $clinic->id }};

// Rating texts in different languages
const ratingTextsLang = {
    en: ["", "Poor", "Fair", "Good", "Very Good", "Excellent"],
    ar: ["", "ضعيف", "مقبول", "جيد", "جيد جداً", "ممتاز"],
    fr: ["", "Médiocre", "Passable", "Bon", "Très bon", "Excellent"]
};

function changeLang(lang) {
    selectedLang = lang;
    localStorage.setItem('selectedLang', lang);
    
    if(lang === "ar") {
        document.body.dir = "rtl";
        ratingTexts = ratingTextsLang.ar;
    } else if(lang === "fr") {
        document.body.dir = "ltr";
        ratingTexts = ratingTextsLang.fr;
    } else {
        document.body.dir = "ltr";
        ratingTexts = ratingTextsLang.en;
    }
    
    if(clinicRating > 0) {
        const textSpan = document.getElementById("ratingTextExp");
        if(textSpan) textSpan.innerText = ratingTexts[clinicRating];
    }
}

function toggleMenu() {
    let sidebar = document.getElementById("sidebar");
    if(sidebar) {
        if(sidebar.style.left === "0px") {
            sidebar.style.left = "-280px";
        } else {
            sidebar.style.left = "0px";
        }
    }
}

function goBack() {
    window.location.href = "{{ route('clinics.index') }}";
}

function goToDoctors() {
    window.location.href = "{{ route('clinic.doctors', $clinic->id) }}";
}

function checkLoginStatus() {
    // Check if user is logged in via Laravel session
    return {{ auth()->check() ? 'true' : 'false' }};
}

function goToLogin() {
    window.location.href = "{{ route('login') }}?redirect=details&clinic_id={{ $clinic->id }}";
}

function bookClinicAppointment() {
    if(!checkLoginStatus()) {
        if(confirm("You need to login to book an appointment. Go to login page?")) {
            goToLogin();
        }
        return;
    }
    
    // Store clinic info in localStorage for the appointment page
    localStorage.setItem("appointmentClinicName", "{{ $clinic->name }}");
    localStorage.setItem("appointmentClinicAddress", "{{ $clinic->address }}");
    localStorage.setItem("appointmentClinicPhone", "{{ $clinic->phone }}");
    localStorage.setItem("appointmentClinicId", "{{ $clinic->id }}");
    
    window.location.href = "{{ route('appointments.create', ['clinic_id' => $clinic->id]) }}";
}

// Load clinic statistics (average rating)
function loadClinicStats() {
    fetch('/api/clinics/{{ $clinic->id }}/stats')
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const avgRating = data.average_rating || 0;
                const reviewCount = data.review_count || 0;
                
                // Display stars
                const starsContainer = document.getElementById('averageStars');
                if(starsContainer) {
                    starsContainer.innerHTML = getStarRating(avgRating);
                }
                
                // Display rating text
                const ratingTextSpan = document.getElementById('ratingText');
                if(ratingTextSpan) {
                    ratingTextSpan.innerHTML = `(${avgRating.toFixed(1)}/5 - ${reviewCount} ${reviewCount === 1 ? 'review' : 'reviews'})`;
                }
            }
        })
        .catch(error => console.error('Error loading clinic stats:', error));
}

function getStarRating(rating) {
    let fullStars = Math.floor(rating);
    let halfStar = (rating % 1) >= 0.5;
    let stars = "";
    
    for(let i = 0; i < fullStars; i++) stars += "⭐";
    if(halfStar) stars += "½⭐";
    let emptyStars = 5 - Math.ceil(rating);
    for(let i = 0; i < emptyStars; i++) stars += "☆";
    
    return stars;
}

// Experience section functionality
function initStarRating() {
    const stars = document.querySelectorAll(".star-exp");
    
    stars.forEach(star => {
        star.addEventListener("click", function() {
            clinicRating = parseInt(this.getAttribute("data-rating"));
            updateStarsExp();
        });
        
        star.addEventListener("mouseover", function() {
            const rating = parseInt(this.getAttribute("data-rating"));
            highlightStarsExp(rating);
        });
    });
    
    const starContainer = document.getElementById("starRatingExp");
    if(starContainer) {
        starContainer.addEventListener("mouseleave", function() {
            updateStarsExp();
        });
    }
}

function highlightStarsExp(rating) {
    const stars = document.querySelectorAll(".star-exp");
    stars.forEach((star, index) => {
        if(index < rating) {
            star.innerHTML = "★";
            star.style.color = "#fbbf24";
        } else {
            star.innerHTML = "☆";
            star.style.color = "rgba(255,255,255,0.3)";
        }
    });
}

function updateStarsExp() {
    const stars = document.querySelectorAll(".star-exp");
    const textSpan = document.getElementById("ratingTextExp");
    
    stars.forEach((star, index) => {
        if(index < clinicRating) {
            star.innerHTML = "★";
            star.classList.add("active");
        } else {
            star.innerHTML = "☆";
            star.classList.remove("active");
        }
    });
    
    if(clinicRating > 0 && textSpan) {
        textSpan.innerText = ratingTexts[clinicRating];
    } else if(textSpan) {
        textSpan.innerText = "";
    }
}

function submitExperience() {
    const feedback = document.getElementById("feedbackText").value.trim();
    
    if(!checkLoginStatus()) {
        if(confirm("Please login to submit a review. Go to login page?")) {
            goToLogin();
        }
        return;
    }
    
    if(clinicRating === 0) {
        alert("Please select a rating");
        return;
    }
    
    if(feedback === "") {
        alert("Please write your feedback");
        return;
    }
    
    // Submit review via API
    fetch('/api/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            clinic_id: clinicId,
            rating: clinicRating,
            review: feedback
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Reset form
            clinicRating = 0;
            updateStarsExp();
            document.getElementById("feedbackText").value = "";
            
            // Reload reviews and clinic stats
            displayReviewsExp();
            loadClinicStats();
            
            alert("Thank you for your feedback!");
        } else {
            alert(data.message || "Error submitting review");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Error submitting review. Please try again.");
    });
}

function displayReviewsExp() {
    fetch('/api/reviews/clinic/' + clinicId)
        .then(response => response.json())
        .then(data => {
            let listHtml = "";
            
            if(!data.data || data.data.length === 0) {
                listHtml = '<div class="no-reviews-exp">No reviews yet. Be the first to share your experience!</div>';
            } else {
                data.data.forEach(review => {
                    listHtml += `
                        <div class="review-item-exp">
                            <div class="review-header-exp">
                                <span class="review-stars-exp">${"★".repeat(review.rating)}${"☆".repeat(5-review.rating)}</span>
                                <span class="review-date-exp">${new Date(review.created_at).toLocaleDateString()}</span>
                            </div>
                            <div class="review-text-exp">"${escapeHtml(review.review)}"</div>
                            ${review.user ? `<div style="color:rgba(255,255,255,0.6);font-size:11px;margin-top:5px;">- ${review.user.name}</div>` : ''}
                        </div>
                    `;
                });
            }
            
            document.getElementById("reviewsListExp").innerHTML = listHtml;
        })
        .catch(error => console.error('Error loading reviews:', error));
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Initialize all functionality
document.addEventListener('DOMContentLoaded', function() {
    loadClinicStats();
    initStarRating();
    displayReviewsExp();
    
    // Set language from localStorage
    const savedLang = localStorage.getItem('selectedLang');
    if(savedLang && savedLang !== 'en') {
        changeLang(savedLang);
    }
});

// Make functions global for onclick handlers
window.goBack = goBack;
window.goToDoctors = goToDoctors;
window.bookClinicAppointment = bookClinicAppointment;
window.submitExperience = submitExperience;
window.setRating = (r) => { clinicRating = r; updateStarsExp(); };
window.changeLang = changeLang;
window.toggleMenu = toggleMenu;
</script>
@endsection