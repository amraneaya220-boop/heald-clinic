

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;min-height:100vh;display:flex;flex-direction:column;background: linear-gradient(135deg, #0f2027 0%, #203a43 40%, #2c5364 100%);position:relative;}
    body::before{content:"";position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(30,58,138,0.25);backdrop-filter:blur(1px);z-index:-1;}
    .register-container{max-width:600px;width:100%;margin:40px auto;}
    .register-card{background:transparent;}
    .register-title{text-align:center;margin-bottom:30px;}
    .register-title h2{color:white;font-size:32px;font-weight:700;text-shadow:0 2px 10px rgba(0,0,0,0.3);}
    .register-title p{color:rgba(255,255,255,0.8);font-size:14px;margin-top:5px;}
    .type-selector{display:flex;gap:12px;margin-bottom:30px;background:rgba(255,255,255,0.15);padding:6px;border-radius:60px;}
    .type-btn{flex:1;padding:12px;border:none;background:transparent;border-radius:50px;font-weight:600;cursor:pointer;color:white;font-size:14px;transition:0.2s;text-decoration:none;display:inline-block;text-align:center;}
    .type-btn.active{background:white;color:#1e3a8a;}
    .input-group{margin-bottom:20px;}
    .input-group label{display:block;margin-bottom:8px;font-weight:600;color:white;font-size:13px;}
    .input-group label .required{color:#ff6b6b;}
    .input-group input,.input-group select,.input-group textarea{width:100%;padding:14px 16px;border:none;border-radius:20px;font-size:15px;outline:none;background:rgba(255,255,255,0.9);color:#1e293b;font-family:inherit;}
    .input-group input:focus,.input-group select:focus,.input-group textarea:focus{background:white;}
    .input-group input::placeholder,.input-group textarea::placeholder{color:#94a3b8;}
    .row-2{display:grid;grid-template-columns:1fr 1fr;gap:15px;}
    .phone-wrapper{display:flex;gap:10px;align-items:center;}
    .country-code{width:80px;background:rgba(255,255,255,0.9);border:none;border-radius:20px;padding:14px;font-weight:bold;color:#1e3a8a;text-align:center;}
    .btn-register{width:100%;padding:15px;background:white;color:#1e3a8a;border:none;border-radius:60px;font-size:16px;font-weight:700;cursor:pointer;margin-top:10px;transition:0.2s;}
    .btn-register:hover{transform:translateY(-2px);}
    .login-link{text-align:center;margin-top:25px;padding-top:20px;border-top:1px solid rgba(255,255,255,0.2);}
    .login-link p{color:rgba(255,255,255,0.7);font-size:13px;}
    .login-link a{color:white;text-decoration:none;font-weight:600;}
    .error-message{color:#ff6b6b;font-size:12px;margin-top:5px;}
    textarea{resize:vertical;min-height:80px;}
    @media(max-width:600px){.row-2{grid-template-columns:1fr;}}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="register-container">
    <div class="register-card">
        <div class="register-title">
            <h2 id="registerTitle">Register <?php echo e(ucfirst($type ?? 'clinic')); ?></h2>
            <p>Join MediEase today</p>
        </div>
        <div class="register-body">
            <div class="type-selector">
                <a href="<?php echo e(route('register', ['type'=>'clinic'])); ?>" class="type-btn <?php echo e(($type ?? 'clinic') == 'clinic' ? 'active' : ''); ?>">🏥 Clinic</a>
                <a href="<?php echo e(route('register', ['type'=>'doctor'])); ?>" class="type-btn <?php echo e(($type ?? 'clinic') == 'doctor' ? 'active' : ''); ?>">👨‍⚕️ Doctor</a>
                <a href="<?php echo e(route('register', ['type'=>'patient'])); ?>" class="type-btn <?php echo e(($type ?? 'clinic') == 'patient' ? 'active' : ''); ?>">👤 Patient</a>
            </div>

            <form method="POST" action="<?php echo e(route('register.post')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="role" value="<?php echo e($type ?? 'clinic'); ?>">

                <?php if(($type ?? 'clinic') == 'clinic'): ?>
                    <div class="input-group">
                        <label>🏥 Clinic Name <span class="required">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="Enter clinic name">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="input-group">
                        <label>📍 Address <span class="required">*</span></label>
                        <input type="text" name="address" value="<?php echo e(old('address')); ?>" required placeholder="Enter full address">
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Contact <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="input-group">
                            <label>📄 RC Number</label>
                            <input type="text" name="rc" value="<?php echo e(old('rc')); ?>" placeholder="Registre de commerce number">
                            <?php $__errorArgs = ['rc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>🏙️ City</label>
                        <input type="text" name="city" value="<?php echo e(old('city')); ?>" placeholder="e.g., Algiers">
                    </div>
                <?php endif; ?>

                <?php if(($type ?? 'clinic') == 'doctor'): ?>
                    <div class="input-group">
                        <label>👨‍⚕️ Doctor Name <span class="required">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="Enter full name">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>🩺 Specialty <span class="required">*</span></label>
                            <input type="text" name="specialty" value="<?php echo e(old('specialty')); ?>" required placeholder="e.g., Cardiologist">
                            <?php $__errorArgs = ['specialty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="input-group">
                            <label>📜 License Number</label>
                            <input type="text" name="license" value="<?php echo e(old('license')); ?>" placeholder="Medical license number">
                            <?php $__errorArgs = ['license'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Phone Number <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="input-group">
                            <label>🏥 Clinic Name <span class="required">*</span></label>
                            <input type="text" name="clinic_name" value="<?php echo e(old('clinic_name')); ?>" required placeholder="Associated clinic name">
                            <?php $__errorArgs = ['clinic_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>🏢 Clinic Address</label>
                            <input type="text" name="clinic_address" value="<?php echo e(old('clinic_address')); ?>" placeholder="Clinic address">
                        </div>
                        <div class="input-group">
                            <label>📞 Clinic Phone</label>
                            <input type="text" name="clinic_phone" value="<?php echo e(old('clinic_phone')); ?>" placeholder="Clinic phone">
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>⭐ Experience (years)</label>
                            <input type="text" name="experience" value="<?php echo e(old('experience')); ?>" placeholder="e.g., 10+ years">
                        </div>
                        <div class="input-group">
                            <label>💰 Consultation Fee (DZD)</label>
                            <input type="number" name="consultation_fee" value="<?php echo e(old('consultation_fee')); ?>" placeholder="e.g., 2500">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>📖 About</label>
                        <textarea name="about" rows="3" placeholder="Brief description about the doctor..."><?php echo e(old('about')); ?></textarea>
                    </div>
                <?php endif; ?>

                <?php if(($type ?? 'clinic') == 'patient'): ?>
                    <div class="input-group">
                        <label>👤 Full Name <span class="required">*</span></label>
                        <input type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="Enter your full name">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Phone Number <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="input-group">
                            <label>🎂 Date of Birth</label>
                            <input type="date" name="dob" value="<?php echo e(old('dob')); ?>">
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>⚥ Gender</label>
                            <select name="gender">
                                <option value="Male" <?php echo e(old('gender') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                <option value="Female" <?php echo e(old('gender') == 'Female' ? 'selected' : ''); ?>>Female</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>📍 Address</label>
                            <input type="text" name="address" value="<?php echo e(old('address')); ?>" placeholder="Your address">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- الحقول المشتركة لجميع الأدوار -->
                <div class="input-group">
                    <label>📧 Email Address <span class="required">*</span></label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="you@example.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row-2">
                    <div class="input-group">
                        <label>🔒 Password <span class="required">*</span></label>
                        <input type="password" name="password" required placeholder="Create password">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="input-group">
                        <label>✓ Confirm Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Confirm password">
                    </div>
                </div>

                <button type="submit" class="btn-register">✨ Create Account →</button>
            </form>

            <div class="login-link">
                <p>Already have an account?</p>
                <a href="<?php echo e(route('login', ['type'=> ($type ?? 'clinic')])); ?>">Sign In</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // الحفاظ على الترجمة (اختياري)
    function changeLang(lang) {
        window.location.href = '/lang/' + lang;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/front/register.blade.php ENDPATH**/ ?>