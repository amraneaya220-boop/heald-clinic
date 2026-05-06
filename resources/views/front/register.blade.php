@extends('layouts.front')

@section('title', 'Register')

@section('extra_styles')
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
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <div class="register-title">
            <h2 id="registerTitle">Register {{ ucfirst($type ?? 'clinic') }}</h2>
            <p>Join MediEase today</p>
        </div>
        <div class="register-body">
            <div class="type-selector">
                <a href="{{ route('register', ['type'=>'clinic']) }}" class="type-btn {{ ($type ?? 'clinic') == 'clinic' ? 'active' : '' }}">🏥 Clinic</a>
                <a href="{{ route('register', ['type'=>'doctor']) }}" class="type-btn {{ ($type ?? 'clinic') == 'doctor' ? 'active' : '' }}">👨‍⚕️ Doctor</a>
                <a href="{{ route('register', ['type'=>'patient']) }}" class="type-btn {{ ($type ?? 'clinic') == 'patient' ? 'active' : '' }}">👤 Patient</a>
            </div>

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <input type="hidden" name="role" value="{{ $type ?? 'clinic' }}">

                @if(($type ?? 'clinic') == 'clinic')
                    <div class="input-group">
                        <label>🏥 Clinic Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter clinic name">
                        @error('name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="input-group">
                        <label>📍 Address <span class="required">*</span></label>
                        <input type="text" name="address" value="{{ old('address') }}" required placeholder="Enter full address">
                        @error('address') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Contact <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        <div class="input-group">
                            <label>📄 RC Number</label>
                            <input type="text" name="rc" value="{{ old('rc') }}" placeholder="Registre de commerce number">
                            @error('rc') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="input-group">
                        <label>🏙️ City</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="e.g., Algiers">
                    </div>
                @endif

                @if(($type ?? 'clinic') == 'doctor')
                    <div class="input-group">
                        <label>👨‍⚕️ Doctor Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter full name">
                        @error('name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>🩺 Specialty <span class="required">*</span></label>
                            <input type="text" name="specialty" value="{{ old('specialty') }}" required placeholder="e.g., Cardiologist">
                            @error('specialty') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        <div class="input-group">
                            <label>📜 License Number</label>
                            <input type="text" name="license" value="{{ old('license') }}" placeholder="Medical license number">
                            @error('license') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Phone Number <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        <div class="input-group">
                            <label>🏥 Clinic Name <span class="required">*</span></label>
                            <input type="text" name="clinic_name" value="{{ old('clinic_name') }}" required placeholder="Associated clinic name">
                            @error('clinic_name') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>🏢 Clinic Address</label>
                            <input type="text" name="clinic_address" value="{{ old('clinic_address') }}" placeholder="Clinic address">
                        </div>
                        <div class="input-group">
                            <label>📞 Clinic Phone</label>
                            <input type="text" name="clinic_phone" value="{{ old('clinic_phone') }}" placeholder="Clinic phone">
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>⭐ Experience (years)</label>
                            <input type="text" name="experience" value="{{ old('experience') }}" placeholder="e.g., 10+ years">
                        </div>
                        <div class="input-group">
                            <label>💰 Consultation Fee (DZD)</label>
                            <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}" placeholder="e.g., 2500">
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label>📖 About</label>
                        <textarea name="about" rows="3" placeholder="Brief description about the doctor...">{{ old('about') }}</textarea>
                    </div>
                @endif

                @if(($type ?? 'clinic') == 'patient')
                    <div class="input-group">
                        <label>👤 Full Name <span class="required">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter your full name">
                        @error('name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>📞 Phone Number <span class="required">*</span></label>
                            <div class="phone-wrapper">
                                <span class="country-code">+213</span>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="5XX XX XX XX" maxlength="9">
                            </div>
                            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                        </div>
                        <div class="input-group">
                            <label>🎂 Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') }}">
                        </div>
                    </div>
                    
                    <div class="row-2">
                        <div class="input-group">
                            <label>⚥ Gender</label>
                            <select name="gender">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label>📍 Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Your address">
                        </div>
                    </div>
                @endif

                <!-- الحقول المشتركة لجميع الأدوار -->
                <div class="input-group">
                    <label>📧 Email Address <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com">
                    @error('email') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="row-2">
                    <div class="input-group">
                        <label>🔒 Password <span class="required">*</span></label>
                        <input type="password" name="password" required placeholder="Create password">
                        @error('password') <div class="error-message">{{ $message }}</div> @enderror
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
                <a href="{{ route('login', ['type'=> ($type ?? 'clinic')]) }}">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // الحفاظ على الترجمة (اختياري)
    function changeLang(lang) {
        window.location.href = '/lang/' + lang;
    }
</script>
@endsection