


<?php $__env->startSection('title', 'System Settings'); ?>
<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.main-content {
    padding: 25px 35px;
}

/* ========== HEADER ========== */
.header {
    background: white;
    padding: 20px 25px;
    border-radius: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header h1 {
    color: #0f2b5c;
    font-size: 24px;
    margin-bottom: 5px;
}

.header p {
    color: #64748b;
    font-size: 13px;
}

/* ========== CLINIC IMAGE SECTION ========== */
.clinic-image-section {
    background: white;
    border-radius: 24px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    align-items: center;
}

.image-preview {
    flex: 1;
    min-width: 200px;
    text-align: center;
}

.image-preview img {
    width: 100%;
    max-width: 280px;
    height: 180px;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    border: 3px solid #e2e8f0;
}

.image-upload {
    flex: 2;
}

.image-upload h3 {
    color: #0f2b5c;
    margin-bottom: 15px;
    font-size: 18px;
}

.image-upload input {
    padding: 12px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    width: 100%;
    margin-bottom: 15px;
}

.upload-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 500;
}

.upload-btn:hover {
    background: #1e40af;
}

/* ========== CARDS ========== */
.settings-card {
    background: white;
    border-radius: 24px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.settings-card h2 {
    color: #0f2b5c;
    font-size: 20px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.settings-card .subtitle {
    color: #64748b;
    font-size: 13px;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

/* ========== GRID ========== */
.grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.input-group label {
    font-weight: 600;
    color: #1e293b;
    font-size: 14px;
}

.input-group input,
.input-group select,
.input-group textarea {
    padding: 12px 15px;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-size: 14px;
    transition: all 0.2s;
    outline: none;
}

.input-group input:focus,
.input-group select:focus,
.input-group textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

/* ========== SCHEDULE TABLE ========== */
.schedule-table-container {
    overflow-x: auto;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

th {
    background: #f8fafc;
    color: #1e3a8a;
    font-weight: 600;
}

.delete-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 6px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s;
}

.delete-btn:hover {
    background: #dc2626;
    color: white;
}

/* ========== PRICING & SERVICES ========== */
.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.price-item {
    background: #f8fafc;
    padding: 15px;
    border-radius: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e2e8f0;
}

.price-item .info b {
    color: #0f2b5c;
    display: block;
}

.price-item .info small {
    color: #64748b;
    font-size: 11px;
}

.price-item input {
    width: 120px;
    padding: 8px;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    font-weight: 500;
    text-align: right;
}

.price-item input:focus {
    border-color: #2563eb;
    outline: none;
}

.service-item {
    background: #f8fafc;
    padding: 15px;
    border-radius: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    border: 1px solid #e2e8f0;
}

.service-item .info b {
    color: #0f2b5c;
}

.service-item .info small {
    color: #64748b;
    font-size: 11px;
}

.service-price {
    font-weight: bold;
    color: #2563eb;
    font-size: 18px;
}

/* ========== TAGS ========== */
.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
}

.tag {
    background: #dbeafe;
    color: #1e3a8a;
    padding: 8px 15px;
    border-radius: 30px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.tag button {
    background: #ef4444;
    color: white;
    border: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 12px;
}

.tag button:hover {
    background: #dc2626;
}

/* ========== BUTTONS ========== */
.btn-primary {
    background: #2563eb;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 500;
    margin-top: 15px;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #1e40af;
    transform: scale(1.02);
}

.btn-success {
    background: #16a34a;
    color: white;
    border: none;
    padding: 14px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
    font-size: 16px;
    margin-top: 20px;
    transition: all 0.2s;
}

.btn-success:hover {
    background: #15803d;
}

/* ========== EMERGENCY BANNER ========== */
.emergency-banner {
    background: linear-gradient(135deg, #fef3c7, #fffbeb);
    border-left: 4px solid #f59e0b;
    padding: 15px 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.emergency-banner span {
    color: #b45309;
    font-weight: 500;
}

@media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media print {
    .header, .settings-card, .btn-primary, .btn-success {
        display: none !important;
    }
}
</style>

<div class="main-content">
    <div class="header">
        <div>
            <h1>⚙️ System Settings</h1>
            <p>Configure clinic information, pricing, and services</p>
        </div>
        <div id="emergencyBadge" class="emergency-banner">
            <span>🚨 Emergency Mode: <strong id="emergencyStatus">OFF</strong></span>
        </div>
    </div>

    <!-- CLINIC IMAGE SECTION -->
    <div class="clinic-image-section">
        <div class="image-preview">
            <img id="clinicImage" src="https://placehold.co/400x250/e2e8f0/64748b?text=Clinic+Photo" alt="Clinic Image">
        </div>
        <div class="image-upload">
            <h3>🏥 Clinic Photo</h3>
            <input type="file" id="imageUpload" accept="image/*">
            <button class="upload-btn" onclick="uploadClinicImage()">📸 Upload Image</button>
            <p style="font-size: 12px; color: #64748b; margin-top: 10px;">Recommended size: 800x450px</p>
        </div>
    </div>

    <!-- CLINIC INFORMATION -->
    <div class="settings-card">
        <h2>🏥 Clinic Information</h2>
        <div class="subtitle">Basic clinic details displayed everywhere</div>
        <div class="grid-2">
            <div class="input-group">
                <label>Clinic Name</label>
                <input type="text" id="clinicName" placeholder="Enter clinic name">
            </div>
            <div class="input-group">
                <label>Phone Number</label>
                <input type="text" id="phone" placeholder="+213 XX XXX XXXX">
            </div>
            <div class="input-group">
                <label>Location / Address</label>
                <input type="text" id="location" placeholder="Full address">
            </div>
            <div class="input-group">
                <label>Emergency Mode</label>
                <select id="emergency">
                    <option value="OFF">⚪ Emergency OFF</option>
                    <option value="ON">🚨 Emergency ON</option>
                </select>
            </div>
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" id="email" placeholder="clinic@heald.com">
            </div>
            <div class="input-group">
                <label>Clinic Description</label>
                <textarea id="description" rows="3" placeholder="Brief description about the clinic..."></textarea>
            </div>
        </div>
    </div>

    <!-- WORKING SCHEDULE -->
    <div class="settings-card">
        <h2>📅 Working Schedule</h2>
        <div class="subtitle">Define working days and hours</div>
        <div class="grid-2">
            <div class="input-group"><label>Date</label><input type="date" id="scheduleDate"></div>
            <div class="input-group"><label>Start Time</label><input type="time" id="startTime"></div>
            <div class="input-group"><label>End Time</label><input type="time" id="endTime"></div>
            <div class="input-group"><label>Break Start</label><input type="time" id="breakStart"></div>
            <div class="input-group"><label>Break End</label><input type="time" id="breakEnd"></div>
        </div>
        <button class="btn-primary" onclick="addSchedule()">+ Add Schedule</button>
        <div class="schedule-table-container">
            <table id="scheduleTable">
                <thead>
                    <tr><th>Date</th><th>Start</th><th>End</th><th>Break</th><th>Action</th></tr>
                </thead>
                <tbody id="scheduleBody"></tbody>
             </table>
        </div>
    </div>

    <!-- SERVICES PRICING (MODIFIABLE) -->
    <div class="settings-card">
        <h2>💰 Services Pricing</h2>
        <div class="subtitle">Modify fixed medical services prices (DZD)</div>
        <div class="pricing-grid">
            <div class="price-item">
                <div class="info"><b>🩺 Consultation</b><small>Doctor visit (Standard)</small></div>
                <input type="number" id="consultPrice" placeholder="Price in DZD" step="100">
            </div>
            <div class="price-item">
                <div class="info"><b>🩻 Radiology</b><small>X-ray service</small></div>
                <input type="number" id="radioPrice" placeholder="Price in DZD" step="500">
            </div>
            <div class="price-item">
                <div class="info"><b>🧠 MRI</b><small>Magnetic resonance</small></div>
                <input type="number" id="mriPrice" placeholder="Price in DZD" step="1000">
            </div>
            <div class="price-item">
                <div class="info"><b>📸 CT Scan</b><small>Computer tomography</small></div>
                <input type="number" id="scanPrice" placeholder="Price in DZD" step="1000">
            </div>
        </div>
        <p style="font-size: 12px; color: #64748b; margin-top: 12px;">✏️ Click on any price field to modify, then click "Save Prices".</p>
        <button class="btn-primary" onclick="updatePrices()">💾 Save Prices</button>
    </div>

    <!-- CUSTOM SERVICES -->
    <div class="settings-card">
        <h2>➕ Custom Services</h2>
        <div class="subtitle">Add your own clinic services with prices</div>
        <div class="grid-2">
            <div class="input-group"><label>Service Name</label><input type="text" id="serviceName" placeholder="e.g., Blood Test"></div>
            <div class="input-group"><label>Price (DA)</label><input type="number" id="servicePrice" placeholder="Price"></div>
            <div class="input-group"><label>Description</label><input type="text" id="serviceDesc" placeholder="Brief description"></div>
        </div>
        <button class="btn-primary" onclick="addCustomService()">+ Add Service</button>
        <div id="servicesList" style="margin-top: 15px;"></div>
    </div>

    <!-- SPECIALTIES -->
    <div class="settings-card">
        <h2>🩺 Medical Specialties</h2>
        <div class="subtitle">Specialties offered at the clinic</div>
        <div class="grid-2">
            <div class="input-group"><label>New Specialty</label><input type="text" id="specialtyInput" placeholder="e.g., Cardiology"></div>
        </div>
        <button class="btn-primary" onclick="addSpecialty()">+ Add Specialty</button>
        <div id="specialsList" class="tags-container"></div>
    </div>

    <!-- SAVE BUTTON -->
    <button class="btn-success" onclick="saveAllSettings()">💾 Save All Settings</button>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ========== LOAD ALL SETTINGS FROM DATABASE ==========
    async function loadSettings() {
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.data")); ?>');
            const data = await response.json();
            if (data.success) {
                // Load clinic info
                document.getElementById('clinicName').value = data.clinic.name || '';
                document.getElementById('phone').value = data.clinic.phone || '';
                document.getElementById('location').value = data.clinic.location || '';
                document.getElementById('emergency').value = data.clinic.emergency_mode || 'OFF';
                document.getElementById('email').value = data.clinic.email || '';
                document.getElementById('description').value = data.clinic.description || '';
                
                // Load prices
                document.getElementById('consultPrice').value = data.prices.consult || 2500;
                document.getElementById('radioPrice').value = data.prices.radio || 4000;
                document.getElementById('mriPrice').value = data.prices.mri || 12000;
                document.getElementById('scanPrice').value = data.prices.scan || 15000;
                
                // Load custom services
                renderServices(data.customServices);
                
                // Load schedules
                renderSchedules(data.schedules);
                
                // Load specialties
                renderSpecialties(data.specialties);
                
                // Load clinic image
                if (data.clinic.image) {
                    document.getElementById('clinicImage').src = data.clinic.image;
                }
                
                // Update emergency badge
                updateEmergencyBadge();
                
                // Update sidebar clinic name
                if (data.clinic.name) {
                    document.querySelector('.sidebar h2').innerText = data.clinic.name;
                }
            }
        } catch (error) {
            console.error('Error loading settings:', error);
        }
    }
    
    // ========== RENDER CUSTOM SERVICES ==========
    function renderServices(services) {
        const container = document.getElementById('servicesList');
        if (!container) return;
        container.innerHTML = '';
        if (services && services.length > 0) {
            services.forEach(service => {
                container.innerHTML += `
                    <div class="service-item">
                        <div class="info">
                            <b>${escapeHtml(service.name)}</b>
                            <small>${escapeHtml(service.description || 'No description')}</small>
                        </div>
                        <div class="service-price">${parseInt(service.price).toLocaleString()} DA</div>
                        <button class="delete-btn" onclick="deleteService(${service.id})">Delete</button>
                    </div>
                `;
            });
        } else {
            container.innerHTML = '<p style="color: #64748b; text-align: center;">No custom services added yet.</p>';
        }
    }
    
    // ========== RENDER SCHEDULES ==========
    function renderSchedules(schedules) {
        const tbody = document.getElementById('scheduleBody');
        if (!tbody) return;
        tbody.innerHTML = '';
        if (schedules && schedules.length > 0) {
            schedules.forEach(schedule => {
                tbody.innerHTML += `
                    <tr>
                        <td>${escapeHtml(schedule.schedule_date)}</td>
                        <td>${escapeHtml(schedule.start_time)}</td>
                        <td>${escapeHtml(schedule.end_time)}</td>
                        <td>${escapeHtml(schedule.break_start || '---')} - ${escapeHtml(schedule.break_end || '---')}</td>
                        <td><button class="delete-btn" onclick="deleteSchedule(${schedule.id})">Delete</button></td>
                    </table>
                `;
            });
        } else {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No schedules added yet.</td></tr>';
        }
    }
    
    // ========== RENDER SPECIALTIES ==========
    function renderSpecialties(specialties) {
        const container = document.getElementById('specialsList');
        if (!container) return;
        container.innerHTML = '';
        if (specialties && specialties.length > 0) {
            specialties.forEach((specialty, index) => {
                container.innerHTML += `
                    <span class="tag">
                        ${escapeHtml(specialty.name || specialty)}
                        <button onclick="deleteSpecialty(${specialty.id || index})">✕</button>
                    </span>
                `;
            });
        }
    }
    
    // ========== UPDATE CLINIC INFO ==========
    async function updateClinicInfo() {
        const data = {
            name: document.getElementById('clinicName').value,
            phone: document.getElementById('phone').value,
            location: document.getElementById('location').value,
            emergency_mode: document.getElementById('emergency').value,
            email: document.getElementById('email').value,
            description: document.getElementById('description').value
        };
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.clinic.update")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Clinic info updated successfully!');
                loadSettings();
            } else {
                alert('Error updating clinic info');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== UPDATE PRICES ==========
    async function updatePrices() {
        const prices = {
            consult: document.getElementById('consultPrice').value,
            radio: document.getElementById('radioPrice').value,
            mri: document.getElementById('mriPrice').value,
            scan: document.getElementById('scanPrice').value
        };
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.prices.update")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(prices)
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Prices updated successfully!');
            } else {
                alert('Error updating prices');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== ADD CUSTOM SERVICE ==========
    async function addCustomService() {
        const name = document.getElementById('serviceName').value.trim();
        const price = document.getElementById('servicePrice').value;
        const description = document.getElementById('serviceDesc').value.trim();
        
        if (!name || !price) {
            alert('Please enter service name and price');
            return;
        }
        
        const data = { name, price, description };
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.services.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Service added successfully!');
                document.getElementById('serviceName').value = '';
                document.getElementById('servicePrice').value = '';
                document.getElementById('serviceDesc').value = '';
                loadSettings();
            } else {
                alert('Error adding service');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== DELETE CUSTOM SERVICE ==========
    async function deleteService(id) {
        if (confirm('Are you sure you want to delete this service?')) {
            try {
                const response = await fetch(`<?php echo e(url('clinic/settings/services')); ?>/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    alert('✅ Service deleted successfully!');
                    loadSettings();
                } else {
                    alert('Error deleting service');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    }
    
    // ========== ADD SCHEDULE ==========
    async function addSchedule() {
        const scheduleDate = document.getElementById('scheduleDate').value;
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const breakStart = document.getElementById('breakStart').value;
        const breakEnd = document.getElementById('breakEnd').value;
        
        if (!scheduleDate || !startTime || !endTime) {
            alert('Please fill date, start time and end time');
            return;
        }
        
        const data = {
            schedule_date: scheduleDate,
            start_time: startTime,
            end_time: endTime,
            break_start: breakStart,
            break_end: breakEnd
        };
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.schedules.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Schedule added successfully!');
                document.getElementById('scheduleDate').value = '';
                document.getElementById('startTime').value = '';
                document.getElementById('endTime').value = '';
                document.getElementById('breakStart').value = '';
                document.getElementById('breakEnd').value = '';
                loadSettings();
            } else {
                alert('Error adding schedule');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== DELETE SCHEDULE ==========
    async function deleteSchedule(id) {
        if (confirm('Are you sure you want to delete this schedule?')) {
            try {
                const response = await fetch(`<?php echo e(url('clinic/settings/schedules')); ?>/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    alert('✅ Schedule deleted successfully!');
                    loadSettings();
                } else {
                    alert('Error deleting schedule');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    }
    
    // ========== ADD SPECIALTY ==========
    async function addSpecialty() {
        const specialty = document.getElementById('specialtyInput').value.trim();
        
        if (!specialty) {
            alert('Please enter a specialty name');
            return;
        }
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.specialties.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name: specialty })
            });
            const result = await response.json();
            if (result.success) {
                alert('✅ Specialty added successfully!');
                document.getElementById('specialtyInput').value = '';
                loadSettings();
            } else {
                alert('Error adding specialty');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== DELETE SPECIALTY ==========
    async function deleteSpecialty(id) {
        if (confirm('Are you sure you want to delete this specialty?')) {
            try {
                const response = await fetch(`<?php echo e(url('clinic/settings/specialties')); ?>/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });
                const result = await response.json();
                if (result.success) {
                    alert('✅ Specialty deleted successfully!');
                    loadSettings();
                } else {
                    alert('Error deleting specialty');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred');
            }
        }
    }
    
    // ========== UPLOAD CLINIC IMAGE ==========
    async function uploadClinicImage() {
        const fileInput = document.getElementById('imageUpload');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Please select an image first');
            return;
        }
        
        const formData = new FormData();
        formData.append('image', file);
        
        try {
            const response = await fetch('<?php echo e(route("clinic.settings.image.upload")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                document.getElementById('clinicImage').src = result.image_url;
                alert('✅ Image uploaded successfully!');
            } else {
                alert('Error uploading image');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    }
    
    // ========== SAVE ALL SETTINGS ==========
    async function saveAllSettings() {
        await updateClinicInfo();
        await updatePrices();
        alert('✅ All settings saved successfully!');
    }
    
    // ========== UPDATE EMERGENCY BADGE ==========
    function updateEmergencyBadge() {
        const emergency = document.getElementById('emergency').value;
        const statusElement = document.getElementById('emergencyStatus');
        const banner = document.getElementById('emergencyBadge');
        
        if (statusElement) statusElement.innerText = emergency;
        
        if (emergency === 'ON') {
            banner.style.background = 'linear-gradient(135deg, #fee2e2, #fecaca)';
            banner.style.borderLeftColor = '#dc2626';
            if (banner.querySelector('span')) banner.querySelector('span').style.color = '#991b1b';
        } else {
            banner.style.background = 'linear-gradient(135deg, #fef3c7, #fffbeb)';
            banner.style.borderLeftColor = '#f59e0b';
            if (banner.querySelector('span')) banner.querySelector('span').style.color = '#b45309';
        }
    }
    
    // ========== HELPER FUNCTION ==========
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    // ========== EVENT LISTENERS ==========
    document.getElementById('emergency').addEventListener('change', updateEmergencyBadge);
    
    // ========== INITIALIZE ==========
    document.addEventListener('DOMContentLoaded', function() {
        loadSettings();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/settings/index.blade.php ENDPATH**/ ?>