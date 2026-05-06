

<?php $__env->startSection('title', 'Login - MediEase'); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;min-height:100vh;display:flex;flex-direction:column;background: linear-gradient(135deg, #0f2027 0%, #203a43 40%, #2c5364 100%);position:relative;}
    body::before{content:"";position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(30,58,138,0.25);backdrop-filter:blur(2px);z-index:-1;}
    .login-container{max-width:480px;width:100%;margin:40px auto;}
    .login-card{background:transparent;}
    .login-title{text-align:center;margin-bottom:35px;}
    .login-title h2{color:white;font-size:34px;font-weight:700;text-shadow:0 2px 10px rgba(0,0,0,0.3);}
    .login-title p{color:rgba(255,255,255,0.8);font-size:14px;margin-top:8px;}
    .type-selector{display:flex;gap:12px;margin-bottom:35px;background:rgba(255,255,255,0.12);padding:6px;border-radius:60px;}
    .type-btn{flex:1;padding:12px;border:none;background:transparent;border-radius:50px;font-weight:600;cursor:pointer;color:white;font-size:14px;transition:0.3s;}
    .type-btn.active{background:white;color:#1e3a8a;}
    .type-btn:hover{background:rgba(255,255,255,0.2);color:white;}
    .method-selector{display:flex;gap:15px;margin-bottom:30px;border-bottom:2px solid rgba(255,255,255,0.25);padding-bottom:12px;}
    .method-btn{flex:1;padding:8px;border:none;background:transparent;font-weight:600;cursor:pointer;color:rgba(255,255,255,0.7);font-size:14px;transition:0.3s;}
    .method-btn.active{color:white;border-bottom:2px solid white;margin-bottom:-14px;}
    .input-group{margin-bottom:22px;}
    .input-group label{display:block;margin-bottom:8px;font-weight:600;color:white;font-size:13px;}
    .input-group input{width:100%;padding:14px 16px;border:none;border-radius:20px;font-size:15px;outline:none;background:rgba(255,255,255,0.9);transition:0.3s;}
    .input-group input:focus{background:white;box-shadow:0 0 0 3px rgba(59,130,246,0.3);}
    .phone-wrapper{display:flex;gap:12px;align-items:center;}
    .country-code{width:80px;background:rgba(255,255,255,0.9);border:none;border-radius:20px;padding:14px;font-weight:bold;color:#1e3a8a;text-align:center;}
    .forgot-password{text-align:right;margin-bottom:25px;}
    .forgot-password a{color:rgba(255,255,255,0.8);text-decoration:none;font-size:12px;}
    .forgot-password a:hover{text-decoration:underline;}
    .btn-login{width:100%;padding:15px;background:white;color:#1e3a8a;border:none;border-radius:60px;font-size:16px;font-weight:700;cursor:pointer;transition:0.3s;}
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 10px 20px rgba(0,0,0,0.2);}
    .register-link{text-align:center;margin-top:30px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.2);}
    .register-link p{color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:5px;}
    .register-link a{color:white;text-decoration:none;font-weight:600;}
    .register-link a:hover{text-decoration:underline;}
    .modal{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:1000;justify-content:center;align-items:center;}
    .modal-content{background:white;max-width:450px;width:90%;border-radius:35px;padding:30px;}
    .modal-content h3{color:#1e3a8a;margin-bottom:20px;text-align:center;}
    .modal-content input{width:100%;padding:14px;border:2px solid #e2e8f0;border-radius:20px;margin-bottom:15px;}
    .modal-content button{width:100%;padding:12px;background:#1e3a8a;color:white;border:none;border-radius:60px;font-weight:600;cursor:pointer;}
    .close-modal{text-align:right;cursor:pointer;font-size:26px;color:#64748b;}
    .error-message{color:#ff6b6b;font-size:11px;margin-top:5px;display:none;}
    .error-message-server{color:#ff6b6b;font-size:13px;text-align:center;margin-bottom:15px;background:rgba(255,0,0,0.1);padding:10px;border-radius:30px;}
    /* Navbar - تصميم أزرق */
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
    .nav-center a{text-decoration:none;color:white;font-weight:600;font-size:15px;transition:0.3s;}
    .nav-center a:hover{color:#3b82f6;}
    .sidebar{position:fixed;top:0;left:-280px;width:280px;height:100%;background:rgba(255,255,255,0.1);backdrop-filter:blur(20px);color:white;transition:left 0.3s;padding-top:80px;z-index:1000;border-right:1px solid rgba(255,255,255,0.2);}
    .sidebar .close-icon{display:flex;justify-content:center;margin-bottom:30px;}
    .sidebar .close-icon span{font-size:30px;cursor:pointer;background:rgba(255,255,255,0.2);width:50px;height:50px;border-radius:50%;display:flex;align-items:center;justify-content:center;}
    .sidebar a{display:block;padding:15px 30px;color:white;text-decoration:none;font-size:16px;border-bottom:1px solid rgba(255,255,255,0.1);transition:0.3s;}
    .sidebar a:hover{background:rgba(255,255,255,0.15);padding-left:40px;}
    @media (max-width:768px){.navbar{padding:12px 15px;}.logo{font-size:22px;}.login-container{margin:30px auto;padding:0 20px;}}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="close-icon"><span onclick="toggleMenu()">✕</span></div>
    <a href="#" id="aboutLink">📖 About</a>
    <a href="#" id="contactLink">📞 Contact</a>
    <a href="#">📢 Announcement</a>
    <a href="#">💊 Medical Advice</a>
</div>

<!-- Navbar (the only header element) -->


<!-- Login Form (title removed) -->
<div class="login-container">
    <div class="login-card">
        <div class="login-body">
            <div class="type-selector">
                <button type="button" class="type-btn <?php echo e(($type ?? 'patient') == 'clinic' ? 'active' : ''); ?>" data-type="clinic" onclick="selectType('clinic')">🏥 Clinic</button>
                <button type="button" class="type-btn <?php echo e(($type ?? 'patient') == 'doctor' ? 'active' : ''); ?>" data-type="doctor" onclick="selectType('doctor')">👨‍⚕️ Doctor</button>
                <button type="button" class="type-btn <?php echo e(($type ?? 'patient') == 'patient' ? 'active' : ''); ?>" data-type="patient" onclick="selectType('patient')">👤 Patient</button>
            </div>
            
            <div class="method-selector">
                <button type="button" class="method-btn active" data-method="email" onclick="selectMethod('email')">📧 Email</button>
                <button type="button" class="method-btn" data-method="phone" onclick="selectMethod('phone')">📱 Phone (+213)</button>
            </div>
            
            <form method="POST" action="<?php echo e(route('login.post')); ?>" id="loginForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="role" id="loginRole" value="<?php echo e($type ?? 'patient'); ?>">
                
                <div id="emailFields">
                    <div class="input-group">
                        <label id="emailLabel">Email Address</label>
                        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="you@example.com">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="error-message-server"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div id="phoneFields" style="display:none;">
                    <div class="input-group">
                        <label id="phoneLabel">Phone Number</label>
                        <div class="phone-wrapper">
                            <span class="country-code">+213</span>
                            <input type="tel" id="phone" name="phone" placeholder="5XX XX XX XX" maxlength="9">
                        </div>
                        <div id="phoneError" class="error-message">Please enter a valid Algerian number (05, 06, or 07 followed by 8 digits)</div>
                        <small style="color:rgba(255,255,255,0.7);">Enter 9 digits: starts with 5, 6, or 7 (e.g., 551234567)</small>
                    </div>
                </div>
                
                <div class="input-group">
                    <label id="passwordLabel">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message-server"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <?php if(session('error')): ?>
                    <div class="error-message-server"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                
                <div class="forgot-password">
                    <a href="#" onclick="openResetModal()" id="forgotLink">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn-login" id="signInBtn">Sign In →</button>
            </form>
            
            <div class="register-link">
                <p id="registerText">Don't have an account?</p>
                <a id="registerLink" href="<?php echo e(route('register', ['type' => ($type ?? 'patient')])); ?>">Create an Account</a>
            </div>
        </div>
    </div>
</div>

<!-- Reset Modal (unchanged) -->
<div id="resetModal" class="modal">
    <div class="modal-content">
        <div class="close-modal" onclick="closeResetModal()">&times;</div>
        <h3>Reset Password</h3>
        <div id="resetStep1">
            <div class="method-selector" style="border-bottom:none; margin-bottom:10px;">
                <button type="button" class="method-btn" data-method="resetEmail" onclick="selectResetMethod('email')">📧 Email</button>
                <button type="button" class="method-btn" data-method="resetPhone" onclick="selectResetMethod('phone')">📱 Phone (+213)</button>
            </div>
            <div id="resetEmailField"><input type="email" id="resetEmail" placeholder="Enter your email"></div>
            <div id="resetPhoneField" style="display:none;">
                <div class="phone-wrapper"><span class="country-code">+213</span><input type="tel" id="resetPhone" placeholder="5XX XX XX XX" maxlength="9"></div>
                <div id="resetPhoneError" class="error-message">Please enter a valid Algerian number (05, 06, or 07 followed by 8 digits)</div>
            </div>
            <button onclick="sendResetCode()">Send Verification Code</button>
        </div>
        <div id="resetStep2" style="display:none;">
            <input type="text" id="resetCode" placeholder="Enter 6-digit code" maxlength="6">
            <input type="password" id="newPassword" placeholder="New password">
            <input type="password" id="confirmPassword" placeholder="Confirm password">
            <button onclick="confirmReset()">Reset Password</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Global variables
var currentType = "<?php echo e($type ?? 'patient'); ?>";
var currentMethod = "email";
var resetMethod = "email";
var resetCodeStore = {};
var resetIdentifier = "";

// Toggle sidebar
function toggleMenu(){
    var sidebar = document.getElementById("sidebar");
    if(sidebar.style.left === "0px"){ sidebar.style.left = "-280px"; }
    else { sidebar.style.left = "0px"; }
}

// Phone validation for Algeria
function isValidAlgerianPhone(phone){
    if(!phone) return false;
    var phoneStr = phone.toString().replace(/\s/g, '');
    if(phoneStr.length !== 9) return false;
    var first = phoneStr.charAt(0);
    return (first === '5' || first === '6' || first === '7');
}

function getFullPhone(){
    var phone = document.getElementById("phone").value.trim().replace(/\s/g, '');
    if(!isValidAlgerianPhone(phone)) return null;
    return "+213" + phone;
}

function getResetFullPhone(){
    var phone = document.getElementById("resetPhone").value.trim().replace(/\s/g, '');
    if(!isValidAlgerianPhone(phone)) return null;
    return "+213" + phone;
}

// Select user type (Clinic, Doctor, Patient)
function selectType(type){
    currentType = type;
    document.querySelectorAll(".type-btn").forEach(btn => {
        if(btn.getAttribute("data-type") === type) btn.classList.add("active");
        else btn.classList.remove("active");
    });
    document.getElementById("loginRole").value = type;
    updateRegisterLink();
    // updateLoginTitle(); // removed because title no longer exists
    var langSelect = document.querySelector(".lang select");
    if(langSelect) changeLang(langSelect.value);
    
    // Update URL without reload
    var url = new URL(window.location.href);
    url.searchParams.set('type', type);
    window.history.pushState({}, '', url);
}

// Removed updateLoginTitle function because there is no login-title div

function selectMethod(method){
    currentMethod = method;
    document.querySelectorAll(".method-btn").forEach(btn => {
        if(btn.getAttribute("data-method") === method) btn.classList.add("active");
        else btn.classList.remove("active");
    });
    document.getElementById("emailFields").style.display = method === "email" ? "block" : "none";
    document.getElementById("phoneFields").style.display = method === "phone" ? "block" : "none";
    
    // Enable/disable form fields based on method
    if(method === "email"){
        document.getElementById("email").disabled = false;
        if(document.getElementById("phone")) document.getElementById("phone").disabled = true;
    } else {
        if(document.getElementById("email")) document.getElementById("email").disabled = true;
        document.getElementById("phone").disabled = false;
    }
}

function selectResetMethod(method){
    resetMethod = method;
    document.querySelectorAll("#resetStep1 .method-btn").forEach(btn => {
        if(btn.getAttribute("data-method") === ("reset"+method.charAt(0).toUpperCase()+method.slice(1))) btn.classList.add("active");
        else btn.classList.remove("active");
    });
    document.getElementById("resetEmailField").style.display = method === "email" ? "block" : "none";
    document.getElementById("resetPhoneField").style.display = method === "phone" ? "block" : "none";
}

function updateRegisterLink(){
    var registerLink = document.getElementById("registerLink");
    if(registerLink){
        registerLink.href = "<?php echo e(url('/register')); ?>?type=" + currentType;
    }
}

// Handle form submission to include phone/email based on method
document.getElementById("loginForm").addEventListener("submit", function(e){
    if(currentMethod === "phone"){
        var fullPhone = getFullPhone();
        if(!fullPhone){
            e.preventDefault();
            document.getElementById("phoneError").style.display = "block";
            return;
        }
        document.getElementById("phoneError").style.display = "none";
        // Create hidden input for phone if needed
        var phoneInput = document.createElement("input");
        phoneInput.type = "hidden";
        phoneInput.name = "phone_full";
        phoneInput.value = fullPhone;
        this.appendChild(phoneInput);
        
        // Disable email field so it doesn't submit
        if(document.getElementById("email")) document.getElementById("email").disabled = true;
    } else {
        var email = document.getElementById("email").value.trim();
        if(!email){
            e.preventDefault();
            alert("Please enter your email address");
            return;
        }
        if(document.getElementById("phone")) document.getElementById("phone").disabled = true;
    }
});

// Reset password functions (unchanged)
function sendResetCode(){
    var identifier = "";
    if(resetMethod === "email"){
        identifier = document.getElementById("resetEmail").value.trim();
        if(!identifier || !identifier.includes("@")){ alert("Enter a valid email"); return; }
    } else {
        var phone = document.getElementById("resetPhone").value.trim().replace(/\s/g, '');
        if(!isValidAlgerianPhone(phone)){ alert("Enter a valid Algerian phone number (05, 06, or 07)"); return; }
        identifier = "+213" + phone;
    }
    
    // Check if user exists in localStorage (for demo)
    var userFound = false;
    for(var i=0; i<localStorage.length; i++){
        var key = localStorage.key(i);
        try{
            var user = JSON.parse(localStorage.getItem(key));
            if(user && ((user.email && user.email === identifier) || (user.phone && user.phone === identifier))){
                userFound = true;
                break;
            }
        } catch(e){}
    }
    if(!userFound){ alert("No account found"); return; }
    
    var code = Math.floor(100000 + Math.random() * 900000).toString();
    resetCodeStore[identifier] = code;
    resetIdentifier = identifier;
    alert("Verification code: " + code + "\n(For demo purposes)");
    
    document.getElementById("resetStep1").style.display = "none";
    document.getElementById("resetStep2").style.display = "block";
}

function confirmReset(){
    var code = document.getElementById("resetCode").value.trim();
    var newPass = document.getElementById("newPassword").value;
    var confirmPass = document.getElementById("confirmPassword").value;
    
    if(!code || !newPass || !confirmPass){ alert("Please fill all fields"); return; }
    if(code.length !== 6){ alert("Code must be 6 digits"); return; }
    if(resetCodeStore[resetIdentifier] !== code){ alert("Invalid code"); return; }
    if(newPass !== confirmPass){ alert("Passwords do not match"); return; }
    if(newPass.length < 6){ alert("Password must be at least 6 characters"); return; }
    
    for(var i=0; i<localStorage.length; i++){
        var key = localStorage.key(i);
        try{
            var user = JSON.parse(localStorage.getItem(key));
            if(user && ((user.email && user.email === resetIdentifier) || (user.phone && user.phone === resetIdentifier))){
                user.password = newPass;
                localStorage.setItem(key, JSON.stringify(user));
                break;
            }
        } catch(e){}
    }
    alert("Password reset successfully!");
    closeResetModal();
    document.getElementById("password").value = "";
}

function openResetModal(){
    document.getElementById("resetModal").style.display = "flex";
    document.getElementById("resetStep1").style.display = "block";
    document.getElementById("resetStep2").style.display = "none";
    document.getElementById("resetEmail").value = "";
    document.getElementById("resetPhone").value = "";
    document.getElementById("resetCode").value = "";
    document.getElementById("newPassword").value = "";
    document.getElementById("confirmPassword").value = "";
}

function closeResetModal(){
    document.getElementById("resetModal").style.display = "none";
}

// Multi-language function (removed references to loginTitle and loginSubtitle)
function changeLang(lang){
    var homeLink = document.getElementById("homeLink");
    var aboutLink = document.getElementById("aboutLink");
    var contactLink = document.getElementById("contactLink");
    var clinicBtn = document.querySelector(".type-btn[data-type='clinic']");
    var doctorBtn = document.querySelector(".type-btn[data-type='doctor']");
    var patientBtn = document.querySelector(".type-btn[data-type='patient']");
    var emailMethod = document.querySelector(".method-btn[data-method='email']");
    var phoneMethod = document.querySelector(".method-btn[data-method='phone']");
    var emailLabel = document.getElementById("emailLabel");
    var phoneLabel = document.getElementById("phoneLabel");
    var passwordLabel = document.getElementById("passwordLabel");
    var forgotLink = document.getElementById("forgotLink");
    var signInBtn = document.getElementById("signInBtn");
    var registerText = document.getElementById("registerText");
    var registerLink = document.getElementById("registerLink");
    
    if(lang === "ar"){
        document.body.dir = "rtl";
        if(homeLink) homeLink.innerText = "الرئيسية";
        if(aboutLink) aboutLink.innerText = "📖 من نحن";
        if(contactLink) contactLink.innerText = "📞 اتصل بنا";
        if(clinicBtn) clinicBtn.innerHTML = "🏥 عيادة";
        if(doctorBtn) doctorBtn.innerHTML = "👨‍⚕️ طبيب";
        if(patientBtn) patientBtn.innerHTML = "👤 مريض";
        if(emailMethod) emailMethod.innerHTML = "📧 بريد إلكتروني";
        if(phoneMethod) phoneMethod.innerHTML = "📱 هاتف (+213)";
        if(emailLabel) emailLabel.innerHTML = "البريد الإلكتروني";
        if(phoneLabel) phoneLabel.innerHTML = "رقم الهاتف";
        if(passwordLabel) passwordLabel.innerHTML = "كلمة المرور";
        if(forgotLink) forgotLink.innerText = "نسيت كلمة المرور؟";
        if(signInBtn) signInBtn.innerHTML = "تسجيل الدخول ←";
        if(registerText) registerText.innerText = "ليس لديك حساب؟";
        if(registerLink) registerLink.innerText = "إنشاء حساب";
    }
    else if(lang === "fr"){
        document.body.dir = "ltr";
        if(homeLink) homeLink.innerText = "Accueil";
        if(aboutLink) aboutLink.innerText = "📖 À propos";
        if(contactLink) contactLink.innerText = "📞 Contact";
        if(clinicBtn) clinicBtn.innerHTML = "🏥 Clinique";
        if(doctorBtn) doctorBtn.innerHTML = "👨‍⚕️ Médecin";
        if(patientBtn) patientBtn.innerHTML = "👤 Patient";
        if(emailMethod) emailMethod.innerHTML = "📧 E-mail";
        if(phoneMethod) phoneMethod.innerHTML = "📱 Téléphone (+213)";
        if(emailLabel) emailLabel.innerHTML = "Adresse e-mail";
        if(phoneLabel) phoneLabel.innerHTML = "Numéro de téléphone";
        if(passwordLabel) passwordLabel.innerHTML = "Mot de passe";
        if(forgotLink) forgotLink.innerText = "Mot de passe oublié ?";
        if(signInBtn) signInBtn.innerHTML = "Se connecter →";
        if(registerText) registerText.innerText = "Vous n'avez pas de compte ?";
        if(registerLink) registerLink.innerText = "Créer un compte";
    }
    else{
        document.body.dir = "ltr";
        if(homeLink) homeLink.innerText = "Home";
        if(aboutLink) aboutLink.innerText = "📖 About";
        if(contactLink) contactLink.innerText = "📞 Contact";
        if(clinicBtn) clinicBtn.innerHTML = "🏥 Clinic";
        if(doctorBtn) doctorBtn.innerHTML = "👨‍⚕️ Doctor";
        if(patientBtn) patientBtn.innerHTML = "👤 Patient";
        if(emailMethod) emailMethod.innerHTML = "📧 Email";
        if(phoneMethod) phoneMethod.innerHTML = "📱 Phone (+213)";
        if(emailLabel) emailLabel.innerHTML = "Email Address";
        if(phoneLabel) phoneLabel.innerHTML = "Phone Number";
        if(passwordLabel) passwordLabel.innerHTML = "Password";
        if(forgotLink) forgotLink.innerText = "Forgot password?";
        if(signInBtn) signInBtn.innerHTML = "Sign In →";
        if(registerText) registerText.innerText = "Don't have an account?";
        if(registerLink) registerLink.innerText = "Create an Account";
    }
}

// Initialize page
updateRegisterLink();
// Initialize method selector (email by default)
selectMethod('email');

// Preserve old email value if exists
var oldEmail = "<?php echo e(old('email')); ?>";
if(oldEmail && document.getElementById("email")){
    document.getElementById("email").value = oldEmail;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/front/login.blade.php ENDPATH**/ ?>