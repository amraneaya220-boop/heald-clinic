

<?php $__env->startSection('title', 'Clinic Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ==================== WELCOME CARD STYLES ==================== */
    .welcome-card {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 35px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
        position: relative;
        z-index: 1;
    }
    
    .welcome-text {
        flex: 2;
    }
    
    .welcome-text h1 {
        font-size: 32px;
        margin-bottom: 12px;
        font-weight: 700;
    }
    
    .welcome-text p {
        opacity: 0.9;
        margin-bottom: 25px;
        font-size: 15px;
        line-height: 1.5;
    }
    
    .welcome-text p strong {
        color: #fef3c7;
        font-weight: 700;
    }
    
    .review-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: none;
        padding: 12px 28px;
        border-radius: 50px;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }
    
    .review-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }
    
    .btn-badge {
        background: #f59e0b;
        color: #1e293b;
        border-radius: 50px;
        padding: 2px 10px;
        font-size: 12px;
        font-weight: 700;
        margin-left: 8px;
    }
    
    .welcome-stats {
        flex: 1;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    
    .welcome-stat {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s;
        min-width: 130px;
    }
    
    .welcome-stat:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-3px);
    }
    
    .welcome-stat-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .welcome-stat-icon i {
        font-size: 22px;
        color: white;
    }
    
    .welcome-stat-info {
        display: flex;
        flex-direction: column;
    }
    
    .welcome-stat-value {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.2;
    }
    
    .welcome-stat-label {
        font-size: 11px;
        opacity: 0.8;
    }
    
    /* ==================== STATS GRID ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-info h4 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .stat-info .number {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon i {
        font-size: 24px;
        color: white;
    }

    /* ==================== TWO COLUMNS ==================== */
    .two-columns {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 35px;
    }

    /* Performance Section */
    .performance-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .performance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .performance-header h3 {
        font-size: 18px;
        color: #1e293b;
    }

    .view-all {
        color: #6366f1;
        font-size: 13px;
        text-decoration: none;
    }

    .best-score {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
    }

    .best-score .score {
        font-size: 48px;
        font-weight: 800;
        color: #f59e0b;
    }

    .best-score p {
        color: #92400e;
        font-size: 14px;
        margin-top: 5px;
    }

    .lesson-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 15px;
    }

    .lesson-tag {
        background: #f1f5f9;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 13px;
        color: #1e293b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .lesson-tag:hover {
        background: #6366f1;
        color: white;
    }

    /* Visit Section */
    .visit-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .visit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .month-select {
        background: #f1f5f9;
        border: none;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 13px;
    }

    .progress-circle {
        text-align: center;
        margin: 30px 0;
    }

    .circle-percent {
        font-size: 48px;
        font-weight: 800;
        color: #6366f1;
    }

    .visit-stats {
        margin-top: 20px;
    }

    .visit-stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .visit-stat-label {
        font-size: 13px;
        color: #64748b;
    }

    .visit-stat-value {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ==================== CALENDAR SECTION ==================== */
    .calendar-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        margin-bottom: 35px;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-header h3 {
        font-size: 18px;
        color: #1e293b;
    }

    .event-list {
        margin-top: 15px;
    }

    .event-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .event-time {
        font-size: 12px;
        color: #6366f1;
        font-weight: 600;
    }

    .event-title {
        font-size: 14px;
        color: #1e293b;
        flex: 1;
        margin-left: 15px;
    }

    .event-lessons {
        font-size: 11px;
        color: #94a3b8;
    }

    /* ==================== UPCOMING EVENTS ==================== */
    .upcoming-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        margin-bottom: 35px;
    }

    .upcoming-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .upcoming-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .upcoming-date {
        min-width: 70px;
    }

    .upcoming-date .day {
        font-size: 24px;
        font-weight: 800;
        color: #6366f1;
    }

    .upcoming-date .month {
        font-size: 11px;
        color: #94a3b8;
    }

    .upcoming-info h4 {
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .upcoming-info p {
        font-size: 12px;
        color: #94a3b8;
    }

    /* ==================== TABLE STYLES ==================== */
    .table-container {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 35px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .table-container h2 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-container h2 i {
        color: #6366f1;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px 12px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }

    th {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 600;
        font-size: 12px;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
        font-size: 12px;
    }

    .status-accepted, .status-confirmed {
        background: #dcfce7;
        color: #16a34a;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
        font-size: 12px;
    }

    .status-rejected, .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
        font-size: 12px;
    }

    .action-btn {
        padding: 6px 14px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        margin: 0 3px;
        transition: all 0.2s;
    }

    .btn-accept {
        background: #10b981;
        color: white;
    }

    .btn-accept:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-reject {
        background: #ef4444;
        color: white;
    }

    .btn-reject:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* ==================== REVIEWS SECTION ==================== */
    .reviews-section {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f8fafc;
        padding: 8px 20px;
        border-radius: 50px;
    }

    .avg-rating {
        font-size: 24px;
        font-weight: 800;
        color: #f59e0b;
    }

    .review-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #f1f5f9;
        transition: all 0.2s;
    }

    .review-card:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .reviewer-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .reviewer-name {
        font-weight: 700;
        color: #1e293b;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 14px;
        letter-spacing: 2px;
    }

    .review-text {
        color: #64748b;
        font-size: 13px;
        margin: 10px 0;
        line-height: 1.5;
    }

    .delete-review {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        padding: 5px 14px;
        border-radius: 50px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .delete-review:hover {
        background: #dc2626;
        color: white;
    }

    /* ==================== NOTIFICATIONS ==================== */
    .notifications {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }

    .notifications h2 {
        font-size: 18px;
        margin-bottom: 20px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notifications h2 i {
        color: #6366f1;
    }

    .notif-item {
        background: #f8fafc;
        padding: 14px 16px;
        border-radius: 16px;
        margin-bottom: 10px;
        display: flex;
        gap: 12px;
        border-left: 4px solid #6366f1;
        transition: all 0.2s;
    }

    .notif-item:hover {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    body.rtl .notif-item {
        border-left: none;
        border-right: 4px solid #6366f1;
    }

    .clear-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        cursor: pointer;
        margin-top: 15px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .clear-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }
        
        .welcome-stats {
            justify-content: center;
        }
        
        .welcome-text h1 {
            font-size: 26px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .two-columns {
            grid-template-columns: 1fr;
        }
        
        .reviews-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .welcome-card {
            padding: 25px;
        }
        
        .welcome-stats {
            flex-direction: column;
            width: 100%;
        }
        
        .welcome-stat {
            justify-content: center;
        }
        
        .welcome-text h1 {
            font-size: 22px;
        }
        
        .welcome-text p {
            font-size: 13px;
        }
    }

    /* ==================== RTL SPECIFIC ==================== */
    body.rtl th, body.rtl td {
        text-align: right;
    }

    body.rtl .event-title {
        margin-left: 0;
        margin-right: 15px;
    }

    body.rtl .upcoming-item {
        flex-direction: row-reverse;
    }

    body.rtl .stat-info {
        text-align: right;
    }

    body.rtl .table-container h2 {
        border-left: none;
        border-right: 4px solid #f59e0b;
        padding-left: 0;
        padding-right: 10px;
    }
</style>

<!-- WELCOME SECTION -->
<div class="welcome-card">
    <div class="welcome-content">
        <div class="welcome-text">
            <h1>Hello, <?php echo e(Auth::user()->name ?? 'Admin'); ?>! 👋</h1>
            <p>Welcome back to your clinic dashboard. You have <strong id="pendingCountWelcome">0</strong> pending appointments that need your attention today.</p>
            <button class="review-btn" onclick="window.location.href='<?php echo e(route('clinic.appointments.index')); ?>'">
                <i class="fas fa-eye"></i> Review Appointments
                <span class="btn-badge" id="btnPendingCount">0</span>
            </button>
        </div>
        <div class="welcome-stats">
            <div class="welcome-stat">
                <div class="welcome-stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="welcome-stat-info">
                    <span class="welcome-stat-value" id="todayAppointments">0</span>
                    <span class="welcome-stat-label">Today's Appointments</span>
                </div>
            </div>
            <div class="welcome-stat">
                <div class="welcome-stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="welcome-stat-info">
                    <span class="welcome-stat-value" id="avgRatingWelcome">0.0</span>
                    <span class="welcome-stat-label">Average Rating</span>
                </div>
            </div>
            <div class="welcome-stat">
                <div class="welcome-stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="welcome-stat-info">
                    <span class="welcome-stat-value" id="completionRate">0%</span>
                    <span class="welcome-stat-label">Completion Rate</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATS GRID -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Doctors</h4>
            <div class="number" id="totalDoctors">0</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-user-md"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Patients</h4>
            <div class="number" id="totalPatients">0</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>Total Appointments</h4>
            <div class="number" id="totalAppointments">0</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h4>Pending</h4>
            <div class="number" id="pendingCount">0</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
    </div>
</div>

<!-- TWO COLUMNS (Performance + My visit) -->
<div class="two-columns">
    <!-- Performance Section -->
    <div class="performance-card">
        <div class="performance-header">
            <h3>🏆 Performance</h3>
            <a href="#" class="view-all">View all →</a>
        </div>
        <div class="best-score">
            <div class="score" id="avgRating">0.0</div>
            <p>Patient satisfaction rate</p>
        </div>
        <div class="lesson-tags">
            <span class="lesson-tag">Cardiology</span>
            <span class="lesson-tag">Pediatrics</span>
            <span class="lesson-tag">Neurology</span>
            <span class="lesson-tag">Orthopedics</span>
        </div>
    </div>

    <!-- My visit Section -->
    <div class="visit-card">
        <div class="visit-header">
            <h3>📊 Appointment Rate</h3>
            <select class="month-select" id="monthSelect">
                <option value="12">December</option>
                <option value="11">November</option>
                <option value="10">October</option>
            </select>
        </div>
        <div class="progress-circle">
            <div class="circle-percent" id="visitPercent">0%</div>
            <p>Monthly completion rate</p>
        </div>
        <div class="visit-stats">
            <div class="visit-stat-item">
                <span class="visit-stat-label">Completed</span>
                <span class="visit-stat-value" id="completedRate">0%</span>
            </div>
            <div class="visit-stat-item">
                <span class="visit-stat-label">Cancelled</span>
                <span class="visit-stat-value" id="cancelledRate">0%</span>
            </div>
            <div class="visit-stat-item">
                <span class="visit-stat-label">Pending</span>
                <span class="visit-stat-value" id="pendingRate">0%</span>
            </div>
        </div>
    </div>
</div>

<!-- CALENDAR SECTION (Recent Appointments) -->
<div class="calendar-card">
    <div class="calendar-header">
        <h3><i class="fas fa-calendar-alt"></i> Today's Schedule</h3>
        <span id="eventCount">0 appointments today</span>
    </div>
    <div class="event-list" id="eventList">
        <div class="event-item">
            <div class="event-time">--:--</div>
            <div class="event-title">Loading appointments...</div>
            <div class="event-lessons"></div>
        </div>
    </div>
</div>

<!-- APPOINTMENTS TABLE -->
<div class="table-container">
    <h2><i class="fas fa-list"></i> Recent Appointments</h2>
    <div style="overflow-x: auto;">
        <table id="appointmentsTable">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Specialty</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="appointmentsBody">
                <tr><td colspan="7" style="text-align:center; padding:40px;">
                    <i class="fas fa-spinner fa-spin"></i> Loading appointments...
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- REVIEWS SECTION -->
<div class="reviews-section">
    <div class="reviews-header">
        <h2><i class="fas fa-star"></i> Patient Reviews</h2>
        <div class="rating-summary">
            <span>Average Rating:</span>
            <span class="avg-rating" id="avgRatingDisplay">0.0</span>
            <span>★</span>
            <span id="totalReviewsText">(0 reviews)</span>
        </div>
    </div>
    <div id="reviewsList">
        <div class="review-card" style="text-align: center;">
            <i class="fas fa-spinner fa-spin"></i> Loading reviews...
        </div>
    </div>
</div>

<!-- UPCOMING EVENTS -->
<div class="upcoming-card">
    <div class="upcoming-header">
        <h3><i class="fas fa-calendar-week"></i> Upcoming Events</h3>
        <a href="#" class="view-all">View all →</a>
    </div>
    <div class="upcoming-item">
        <div class="upcoming-date">
            <div class="day">14</div>
            <div class="month">Dec</div>
        </div>
        <div class="upcoming-info">
            <h4>Medical Conference 2025</h4>
            <p>Annual medical conference - 14 December 2025</p>
        </div>
    </div>
    <div class="upcoming-item">
        <div class="upcoming-date">
            <div class="day">21</div>
            <div class="month">Dec</div>
        </div>
        <div class="upcoming-info">
            <h4>Health Awareness Webinar</h4>
            <p>Free webinar for all staff - 21 December 2025</p>
        </div>
    </div>
</div>

<!-- NOTIFICATIONS -->
<div class="notifications">
    <h2><i class="fas fa-bell"></i> Notifications</h2>
    <div id="notifList">
        <div class="notif-item">
            <span>🔔</span>
            <div>
                <strong>Welcome to Clinic Dashboard</strong>
                <div style="font-size:10px; color:#64748b;">Just now</div>
            </div>
        </div>
    </div>
    <button class="clear-btn" onclick="clearAllNotifications()">
        <i class="fas fa-trash-alt"></i> Clear All
    </button>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // ==================== TRANSLATIONS ====================
    let currentLang = localStorage.getItem('clinicLanguage') || 'en';
    let notificationsArray = [];

    // ==================== HELPER ====================
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ==================== NOTIFICATIONS ====================
    function addNotification(msg) {
        notificationsArray.unshift({ 
            msg: msg, 
            time: new Date().toLocaleTimeString(),
            date: new Date().toLocaleDateString()
        });
        if (notificationsArray.length > 15) notificationsArray.pop();
        renderNotifications();
    }

    function renderNotifications() {
        const container = document.getElementById('notifList');
        if (!container) return;
        
        if (notificationsArray.length === 0) {
            container.innerHTML = `<div class="notif-item">📭 No new notifications</div>`;
            document.getElementById('badge').innerText = '0';
            return;
        }
        
        container.innerHTML = '';
        notificationsArray.forEach(n => {
            container.innerHTML += `
                <div class="notif-item">
                    <span>🔔</span>
                    <div>
                        <strong>${escapeHtml(n.msg)}</strong>
                        <div style="font-size:10px; color:#64748b;">${escapeHtml(n.date)} ${escapeHtml(n.time)}</div>
                    </div>
                </div>
            `;
        });
        document.getElementById('badge').innerText = notificationsArray.length;
    }

    function clearAllNotifications() { 
        notificationsArray = []; 
        renderNotifications();
        addNotification('All notifications cleared');
    }

    // ==================== FETCH STATS ====================
    async function fetchStats() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.stats")); ?>');
            const data = await res.json();
            if (data.success) {
                // Update stats cards
                document.getElementById('totalDoctors').innerText = data.data.totalDoctors || 0;
                document.getElementById('totalPatients').innerText = data.data.totalPatients || 0;
                document.getElementById('totalAppointments').innerText = data.data.totalAppointments || 0;
                document.getElementById('pendingCount').innerText = data.data.pendingAppointments || 0;
                
                // Update welcome section
                document.getElementById('pendingCountWelcome').innerText = data.data.pendingAppointments || 0;
                document.getElementById('btnPendingCount').innerText = data.data.pendingAppointments || 0;
                document.getElementById('todayAppointments').innerText = data.data.todayAppointments || 0;
                document.getElementById('avgRatingWelcome').innerText = data.data.avgRating || '0.0';
                
                // Calculate rates
                const total = data.data.totalAppointments || 1;
                const completed = data.data.acceptedAppointments || 0;
                const cancelled = data.data.rejectedAppointments || 0;
                const pending = data.data.pendingAppointments || 0;
                const completionRate = Math.round((completed / total) * 100);
                
                document.getElementById('visitPercent').innerText = completionRate + '%';
                document.getElementById('completedRate').innerText = completionRate + '%';
                document.getElementById('cancelledRate').innerText = Math.round((cancelled / total) * 100) + '%';
                document.getElementById('pendingRate').innerText = Math.round((pending / total) * 100) + '%';
                document.getElementById('completionRate').innerText = completionRate + '%';
                document.getElementById('avgRating').innerText = data.data.avgRating || '0.0';
            }
        } catch(e) { 
            console.error("Stats fetch error", e); 
        }
    }

    // ==================== FETCH RECENT APPOINTMENTS ====================
    async function fetchRecentAppointments() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.recent")); ?>');
            const data = await res.json();
            const tbody = document.getElementById('appointmentsBody');
            const eventList = document.getElementById('eventList');
            
            if (data.success && data.appointments && data.appointments.length > 0) {
                document.getElementById('eventCount').innerText = data.appointments.length + ' appointments today';
                
                if (eventList) {
                    eventList.innerHTML = '';
                    data.appointments.slice(0, 5).forEach(app => {
                        eventList.innerHTML += `
                            <div class="event-item">
                                <div class="event-time">${app.time || '--:--'}</div>
                                <div class="event-title">${escapeHtml(app.doctor_name || 'Doctor')}</div>
                                <div class="event-lessons">${escapeHtml(app.patient_name || 'Patient')}</div>
                            </div>
                        `;
                    });
                }
                
                tbody.innerHTML = '';
                data.appointments.forEach(app => {
                    let statusClass = app.status === 'Pending' ? 'status-pending' :
                                    (app.status === 'Accepted' ? 'status-accepted' : 'status-rejected');
                    tbody.innerHTML += `
                        <tr>
                            <td>${escapeHtml(app.patient_name || '—')}</td>
                            <td>${escapeHtml(app.doctor_name || '—')}</td>
                            <td>${escapeHtml(app.specialty || '—')}</td>
                            <td>${app.date || '—'}</td>
                            <td>${app.time || '—'}</td>
                            <td><span class="${statusClass}">${app.status || 'Pending'}</span></td>
                            <td class="action-group">
                                <button class="action-btn btn-accept" onclick="updateStatus(${app.id}, 'Accepted')">✓ Accept</button>
                                <button class="action-btn btn-reject" onclick="updateStatus(${app.id}, 'Rejected')">✗ Reject</button>
                            </td>
                        </table>
                    `;
                });
            } else {
                tbody.innerHTML = '</tr><td colspan="7" style="text-align:center; padding:40px;">No appointments found</td></tr>';
                if (eventList) {
                    eventList.innerHTML = '<div class="event-item"><div class="event-time">--:--</div><div class="event-title">No appointments today</div><div class="event-lessons"></div></div>';
                }
            }
        } catch(e) { 
            console.error("Recent appointments fetch error", e); 
        }
    }

    // ==================== UPDATE APPOINTMENT STATUS ====================
    async function updateStatus(id, status) {
        try {
            const res = await fetch(`/clinic/appointments/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ status })
            });
            const result = await res.json();
            if (result.success) {
                fetchStats();
                fetchRecentAppointments();
                addNotification(`✅ Appointment #${id} ${status.toLowerCase()}`);
            }
        } catch(e) { 
            console.error("Update status error", e); 
        }
    }

    // ==================== FETCH REVIEWS ====================
    async function fetchReviews() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.reviews")); ?>');
            const data = await res.json();
            const container = document.getElementById('reviewsList');
            
            if (data.success && data.reviews && data.reviews.length > 0) {
                let total = data.reviews.reduce((sum, r) => sum + r.rating, 0);
                let avg = (total / data.reviews.length).toFixed(1);
                document.getElementById('avgRatingDisplay').innerText = avg;
                document.getElementById('totalReviewsText').innerText = `(${data.reviews.length} reviews)`;
                
                container.innerHTML = '';
                data.reviews.slice(0, 5).forEach(review => {
                    let stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                    container.innerHTML += `
                        <div class="review-card">
                            <div class="reviewer-info">
                                <span class="reviewer-name">👤 ${escapeHtml(review.patient_name)}</span>
                                <span class="review-stars">${stars}</span>
                                <span class="review-date">📅 ${review.date}</span>
                            </div>
                            <div class="review-text">"${escapeHtml(review.review)}"</div>
                            <button class="delete-review" onclick="deleteReview(${review.id})">🗑️ Delete</button>
                        </div>
                    `;
                });
            } else {
                container.innerHTML = '<div class="review-card" style="text-align: center;">⭐ No reviews yet. Be the first to review!</div>';
            }
        } catch(e) { 
            console.error("Reviews fetch error", e); 
        }
    }

    async function deleteReview(id) {
        if (confirm('Delete this review?')) {
            try {
                await fetch(`/clinic/reviews/${id}`, { 
                    method: 'DELETE', 
                    headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' } 
                });
                fetchReviews();
                addNotification("✅ Review deleted");
            } catch(e) { console.error(e); }
        }
    }

    // ==================== INIT ====================
    document.addEventListener('DOMContentLoaded', function() {
        fetchStats();
        fetchRecentAppointments();
        fetchReviews();
        addNotification("Welcome to Clinic Dashboard");
        
        // Refresh data every 30 seconds
        setInterval(() => {
            fetchStats();
            fetchRecentAppointments();
        }, 30000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/dashboard.blade.php ENDPATH**/ ?>