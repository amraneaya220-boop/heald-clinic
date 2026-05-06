<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - MediEase</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #3b82f6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* خلفية متحركة */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 40px;
            padding: 50px 45px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .logo span {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        h2 {
            color: #1e293b;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 35px;
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
        }

        .input-group label i {
            color: #3b82f6;
            margin-right: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 16px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .input-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(37,99,235,0.3);
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 18px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-size: 13px;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error i {
            font-size: 18px;
        }

        .back-home {
            margin-top: 25px;
            display: inline-block;
            color: #3b82f6;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .back-home:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .info-box {
            background: #f1f5f9;
            border-radius: 15px;
            padding: 15px;
            margin-top: 25px;
            text-align: left;
        }

        .info-box p {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .info-box p i {
            color: #3b82f6;
            width: 20px;
        }

        .info-box .demo-credentials {
            font-family: monospace;
            font-size: 11px;
            color: #1e293b;
            background: white;
            padding: 8px;
            border-radius: 10px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">Medi<span>Ease</span></div>
        <div class="badge">
            <i class="fas fa-shield-alt"></i> Super Admin Portal
        </div>
        <h2>Welcome Back</h2>
        <p class="subtitle">Sign in to access the administrative dashboard</p>

        <?php if(session('error')): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="input-group">
                <label><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" name="email" required placeholder="superadmin@mediease.com" value="<?php echo e(old('email')); ?>">
            </div>
            <div class="input-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
            </button>
        </form>

        <a href="/" class="back-home">
            <i class="fas fa-arrow-left"></i> Back to Homepage
        </a>

       
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/login.blade.php ENDPATH**/ ?>