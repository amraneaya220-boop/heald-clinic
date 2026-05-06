{{-- resources/views/clinic/announcements/index.blade.php --}}
@extends('clinic.layouts.clinic')

@section('title', 'Medical Ads')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #f5f7fe 0%, #eef2fa 100%);
        min-height: 100vh;
        padding: 30px 20px 50px;
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Header Premium */
    .header {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 18px 32px;
        margin-bottom: 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        box-shadow: 0 15px 35px rgba(0, 30, 60, 0.08);
        border: 1px solid rgba(66, 153, 225, 0.15);
    }

    .logo-section h1 {
        font-size: 1.8rem;
        font-weight: 800;
        background: linear-gradient(120deg, #0b4f6c, #1e88e5, #0d9488);
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .logo-section p {
        color: #5a6e7c;
        font-size: 0.8rem;
        margin-top: 5px;
        font-weight: 500;
    }

    .add-btn {
        background: linear-gradient(105deg, #0f7b5e, #0d9488);
        border: none;
        color: white;
        padding: 12px 28px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        font-family: 'Inter';
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 18px rgba(13, 148, 136, 0.25);
    }

    .add-btn:hover {
        transform: translateY(-2px);
        background: linear-gradient(105deg, #0a6b52, #0b7e73);
        box-shadow: 0 12px 22px rgba(13, 148, 136, 0.35);
    }

    /* Horizontal Scroll - One Row Cards */
    .horizontal-scroll {
        overflow-x: auto;
        overflow-y: hidden;
        white-space: nowrap;
        padding: 12px 8px 20px 8px;
        scroll-behavior: smooth;
        cursor: grab;
        scrollbar-width: thin;
    }

    .horizontal-scroll:active {
        cursor: grabbing;
    }

    .cards-row {
        display: inline-flex;
        gap: 24px;
        padding: 0 8px;
    }

    .card {
        background: white;
        border-radius: 24px;
        width: 300px;
        display: inline-block;
        white-space: normal;
        transition: all 0.35s cubic-bezier(0.2, 0, 0, 1);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        cursor: pointer;
        border: 1px solid rgba(200, 220, 240, 0.6);
        vertical-align: top;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 35px rgba(0, 20, 50, 0.12);
    }

    .card-img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        border-radius: 24px 24px 0 0;
    }

    .card-content {
        padding: 18px 16px 20px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #134b73;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .clinic-name {
        background: #e6f3ff;
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #1e6f9f;
        margin: 8px 0 5px;
    }

    .city-info {
        color: #6b7f8f;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 5px;
        margin: 6px 0;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eff6ff;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        color: #2563eb;
        margin-top: 8px;
    }

    .view-btn-card {
        width: 100%;
        margin-top: 16px;
        padding: 10px;
        background: #f0f5fe;
        border: none;
        border-radius: 40px;
        font-weight: 700;
        font-family: 'Inter';
        color: #1f6392;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: 0.2s;
    }

    .view-btn-card:hover {
        background: #e2edfc;
        color: #0f4e74;
    }

    /* Scrollbar Style */
    .horizontal-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .horizontal-scroll::-webkit-scrollbar-track {
        background: #e0e7f0;
        border-radius: 10px;
    }
    .horizontal-scroll::-webkit-scrollbar-thumb {
        background: #0d9488;
        border-radius: 10px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 25, 47, 0.8);
        backdrop-filter: blur(8px);
        justify-content: center;
        align-items: center;
        z-index: 2000;
    }

    .modal-box {
        background: #ffffff;
        width: 90%;
        max-width: 550px;
        max-height: 85vh;
        overflow-y: auto;
        border-radius: 32px;
        padding: 30px 28px;
        position: relative;
        animation: modalPop 0.25s ease;
        box-shadow: 0 35px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 24px;
        font-size: 28px;
        cursor: pointer;
        color: #94a3b8;
        transition: 0.2s;
    }

    .modal-close:hover {
        color: #dc2626;
    }

    .modal-title {
        font-size: 1.7rem;
        font-weight: 800;
        color: #134b73;
        border-left: 5px solid #0d9488;
        padding-left: 18px;
        margin-bottom: 25px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 6px;
        color: #2c4c6e;
        font-size: 0.85rem;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2edf7;
        border-radius: 18px;
        font-family: 'Inter';
        font-size: 0.9rem;
        transition: 0.2s;
        background: #fefefe;
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #0d9488;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }

    .double-input {
        display: flex;
        gap: 15px;
    }

    .double-input .form-group {
        flex: 1;
    }

    .preview-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 20px;
        margin-top: 12px;
        display: none;
        border: 2px solid #cbd5e1;
    }

    .save-btn {
        background: linear-gradient(95deg, #0f7b5e, #0d9488);
        width: 100%;
        border: none;
        padding: 14px;
        border-radius: 40px;
        font-weight: 800;
        font-size: 1rem;
        color: white;
        font-family: 'Inter';
        margin-top: 15px;
        cursor: pointer;
        transition: 0.2s;
    }

    .save-btn:hover {
        background: linear-gradient(95deg, #0a624b, #0b7a6f);
        transform: scale(1.01);
    }

    .detail-item {
        display: flex;
        align-items: baseline;
        padding: 12px 0;
        border-bottom: 1px solid #eef2f8;
        gap: 12px;
        flex-wrap: wrap;
    }

    .detail-label {
        font-weight: 800;
        min-width: 100px;
        color: #1a4f74;
    }

    .detail-value {
        color: #2d3e50;
        flex: 1;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255,255,255,0.7);
        border-radius: 40px;
        color: #4b6e8a;
        width: 100%;
        min-width: 300px;
    }

    footer {
        text-align: center;
        margin-top: 45px;
        color: #6c86a3;
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            text-align: center;
        }
        .card {
            width: 270px;
        }
    }
</style>

<div class="main-container">
    <div class="header">
        <div class="logo-section">
            <h1><i class="fas fa-heartbeat"></i> MediConnect</h1>
            <p><i class="fas fa-star-of-life"></i> Trusted Medical Services & Products</p>
        </div>
        <button class="add-btn" id="openAddBtn"><i class="fas fa-plus-circle"></i> Add New Ad</button>
    </div>

    <!-- Horizontal Scroll Section - One Row -->
    <div class="horizontal-scroll" id="scrollContainer">
        <div class="cards-row" id="adsRow"></div>
    </div>

    <footer>
        <i class="fas fa-shield-check"></i> Your trusted medical advertising platform
    </footer>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-box">
        <span class="modal-close" onclick="closeDetailModal()">&times;</span>
        <div class="modal-title"><i class="fas fa-file-medical"></i> Ad Details</div>
        <div id="detailContent"></div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-box">
        <span class="modal-close" onclick="closeAddModal()">&times;</span>
        <div class="modal-title"><i class="fas fa-plus-hexagon"></i> Create New Ad</div>
        
        <div class="form-group">
            <label><i class="fas fa-heading"></i> Ad Title *</label>
            <input type="text" id="adTitle" placeholder="e.g., Advanced Dental Whitening">
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-hospital"></i> Clinic / Center Name</label>
            <input type="text" id="adClinic" placeholder="Wellness Medical Center">
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-map-marker-alt"></i> City</label>
            <input type="text" id="adCity" placeholder="New York, London, Dubai...">
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-user-md"></i> Doctor / Specialist</label>
            <input type="text" id="adDoctor" placeholder="Dr. James Wilson">
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-tags"></i> Ad Type</label>
            <select id="adType">
                <option value="Service">🩺 Medical Service</option>
                <option value="Product">💊 Health Product</option>
                <option value="Offer">🎁 Special Offer</option>
            </select>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-paragraph"></i> Description</label>
            <textarea id="adDesc" rows="3" placeholder="Detailed description of the service or product..."></textarea>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-money-bill-wave"></i> Price</label>
            <input type="text" id="adPrice" placeholder="e.g., $199 / 5000 DA">
        </div>
        
        <div class="double-input">
            <div class="form-group">
                <label><i class="fas fa-calendar-alt"></i> Start Date</label>
                <input type="date" id="adStart">
            </div>
            <div class="form-group">
                <label><i class="fas fa-calendar-check"></i> End Date</label>
                <input type="date" id="adEnd">
            </div>
        </div>
        
        <div class="form-group">
            <label><i class="fas fa-camera"></i> Ad Image</label>
            <input type="file" id="adImageFile" accept="image/*">
            <img id="imagePreview" class="preview-img" alt="Preview">
        </div>
        
        <button class="save-btn" id="publishBtn"><i class="fas fa-check-circle"></i> Publish Ad</button>
    </div>
</div>

<!-- Font Awesome & Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
    // CSRF Token setup for AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let tempImageUrl = "";

    // Fetch all ads from database
    async function fetchAds() {
        try {
            const response = await fetch('{{ route("clinic.announcements.data") }}');
            const data = await response.json();
            if (data.success) {
                renderAds(data.data);
            } else {
                console.error('Failed to fetch ads');
                renderAds([]);
            }
        } catch (error) {
            console.error('Error fetching ads:', error);
            renderAds([]);
        }
    }

    // Render Ads in Horizontal Row
    function renderAds(ads) {
        const row = document.getElementById('adsRow');
        if (!row) return;
        
        if (ads.length === 0) {
            row.innerHTML = `<div class="empty-state">
                <i class="fas fa-notes-medical fa-4x"></i>
                <h3>No Medical Ads Yet</h3>
                <p>Click "Add New Ad" to share your service or product</p>
            </div>`;
            return;
        }
        
        row.innerHTML = '';
        ads.forEach((ad, idx) => {
            let typeIcon = ad.type === 'Service' ? '🩺' : (ad.type === 'Product' ? '💊' : '🎁');
            const imageUrl = ad.image_url || 'https://placehold.co/600x400/bfdbfe/1e3a8a?text=Medical+Ad';
            const card = document.createElement('div');
            card.className = 'card';
            card.innerHTML = `
                <img class="card-img" src="${escapeHtml(imageUrl)}" alt="${escapeHtml(ad.title)}" onerror="this.src='https://placehold.co/600x400/bfdbfe/1e3a8a?text=Medical+Ad'">
                <div class="card-content">
                    <div class="card-title"><i class="fas fa-hand-holding-heart"></i> ${escapeHtml(ad.title)}</div>
                    <div class="clinic-name"><i class="fas fa-building"></i> ${escapeHtml(ad.clinic)}</div>
                    <div class="city-info"><i class="fas fa-location-dot"></i> ${escapeHtml(ad.city)}</div>
                    <span class="type-badge">${typeIcon} ${escapeHtml(ad.type)}</span>
                    <button class="view-btn-card" data-id="${ad.id}"><i class="fas fa-eye"></i> View Details</button>
                </div>
            `;
            row.appendChild(card);
        });
        
        // Add click events to buttons
        document.querySelectorAll('.view-btn-card').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.getAttribute('data-id'));
                showDetails(id);
            });
        });
    }
    
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    // Show Details Modal - fetch single ad data
    async function showDetails(id) {
        try {
            const response = await fetch(`{{ url("clinic/announcements") }}/${id}`);
            const data = await response.json();
            if (data.success) {
                const ad = data.data;
                const container = document.getElementById('detailContent');
                container.innerHTML = `
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-heading"></i> Title:</span><span class="detail-value">${escapeHtml(ad.title)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-hospital"></i> Clinic:</span><span class="detail-value">${escapeHtml(ad.clinic)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-city"></i> City:</span><span class="detail-value">${escapeHtml(ad.city)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-user-md"></i> Doctor:</span><span class="detail-value">${escapeHtml(ad.doctor)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-tag"></i> Type:</span><span class="detail-value">${escapeHtml(ad.type)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-align-left"></i> Description:</span><span class="detail-value">${escapeHtml(ad.description)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-coins"></i> Price:</span><span class="detail-value">${escapeHtml(ad.price)}</span></div>
                    <div class="detail-item"><span class="detail-label"><i class="fas fa-calendar-week"></i> Validity:</span><span class="detail-value">${ad.start_date || 'Not set'} → ${ad.end_date || 'Not set'}</span></div>
                `;
                document.getElementById('detailModal').style.display = 'flex';
            }
        } catch (error) {
            console.error('Error fetching ad details:', error);
            alert('Could not load ad details');
        }
    }
    
    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
    }
    
    // Image Upload Handler
    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            if (tempImageUrl) URL.revokeObjectURL(tempImageUrl);
            tempImageUrl = URL.createObjectURL(file);
            const preview = document.getElementById('imagePreview');
            preview.src = tempImageUrl;
            preview.style.display = 'block';
        } else {
            tempImageUrl = '';
            document.getElementById('imagePreview').style.display = 'none';
        }
    }
    
    // Open Add Modal
    function openAddModal() {
        document.getElementById('adTitle').value = '';
        document.getElementById('adClinic').value = '';
        document.getElementById('adCity').value = '';
        document.getElementById('adDoctor').value = '';
        document.getElementById('adType').value = 'Service';
        document.getElementById('adDesc').value = '';
        document.getElementById('adPrice').value = '';
        document.getElementById('adStart').value = '';
        document.getElementById('adEnd').value = '';
        document.getElementById('adImageFile').value = '';
        if (tempImageUrl) {
            URL.revokeObjectURL(tempImageUrl);
            tempImageUrl = '';
        }
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('addModal').style.display = 'flex';
    }
    
    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }
    
    // Publish New Ad to Database
    async function publishNewAd() {
        const title = document.getElementById('adTitle').value.trim();
        if (!title) {
            alert('Please enter an ad title');
            return;
        }
        
        const formData = new FormData();
        formData.append('title', title);
        formData.append('clinic', document.getElementById('adClinic').value.trim() || 'Medical Center');
        formData.append('city', document.getElementById('adCity').value.trim() || 'Not specified');
        formData.append('doctor', document.getElementById('adDoctor').value.trim() || 'General Doctor');
        formData.append('type', document.getElementById('adType').value);
        formData.append('description', document.getElementById('adDesc').value.trim() || 'No description provided');
        formData.append('price', document.getElementById('adPrice').value.trim() || 'Contact for price');
        formData.append('start_date', document.getElementById('adStart').value);
        formData.append('end_date', document.getElementById('adEnd').value);
        
        const fileInput = document.getElementById('adImageFile');
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }
        
        try {
            const response = await fetch('{{ route("clinic.announcements.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });
            
            const data = await response.json();
            if (data.success) {
                fetchAds(); // Refresh the ads list
                closeAddModal();
                alert('✅ Ad published successfully!');
                
                // Clean up temp image URL
                if (tempImageUrl && tempImageUrl.startsWith('blob:')) {
                    URL.revokeObjectURL(tempImageUrl);
                }
                tempImageUrl = '';
                
                // Auto scroll to show new ad
                setTimeout(() => {
                    const scrollContainer = document.getElementById('scrollContainer');
                    if (scrollContainer) {
                        scrollContainer.scrollLeft = scrollContainer.scrollWidth;
                    }
                }, 100);
            } else {
                alert('Error: ' + (data.message || 'Could not save ad'));
            }
        } catch (error) {
            console.error('Error publishing ad:', error);
            alert('An error occurred while publishing the ad');
        }
    }
    
    // Delete Ad
    async function deleteAd(id) {
        if (confirm('Are you sure you want to delete this ad?')) {
            try {
                const response = await fetch(`{{ url("clinic/announcements") }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    fetchAds(); // Refresh the list
                    alert('Ad deleted successfully');
                } else {
                    alert('Error deleting ad');
                }
            } catch (error) {
                console.error('Error deleting ad:', error);
                alert('An error occurred while deleting the ad');
            }
        }
    }
    
    // Drag to scroll functionality
    function initDragScroll() {
        const slider = document.getElementById('scrollContainer');
        if (!slider) return;
        
        let isDown = false;
        let startX;
        let scrollLeft;
        
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5;
            slider.scrollLeft = scrollLeft - walk;
        });
    }
    
    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        fetchAds();
        initDragScroll();
        
        const openBtn = document.getElementById('openAddBtn');
        if (openBtn) openBtn.addEventListener('click', openAddModal);
        
        const publishBtn = document.getElementById('publishBtn');
        if (publishBtn) publishBtn.addEventListener('click', publishNewAd);
        
        const fileInput = document.getElementById('adImageFile');
        if (fileInput) fileInput.addEventListener('change', handleImageUpload);
        
        // Close modals on outside click
        window.onclick = (event) => {
            const addModal = document.getElementById('addModal');
            const detailModal = document.getElementById('detailModal');
            if (event.target === addModal) closeAddModal();
            if (event.target === detailModal) closeDetailModal();
        };
    });
</script>
@endsection