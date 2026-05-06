<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediEase - Welcome</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

      body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    background: url("<?php echo e(asset('images/logo.jpg')); ?>") no-repeat center center;
    background-size: cover;   /* يخلي الصورة تغطي كامل الصفحة */

    overflow: hidden;
}

        /* Overlay */
        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7));
            backdrop-filter: blur(6px);
        }

        .container {
            position: relative;
            text-align: center;
            color: white;
            animation: fadeIn 1.5s ease;
            z-index: 1;
        }

        /* اللوجو أكبر */
        .logo {
            font-size: 80px;
            margin-bottom: 15px;
            filter: drop-shadow(0 0 20px rgba(0, 114, 255, 0.9));
            animation: float 3s infinite ease-in-out;
        }
         .logo-img {
                 width: 150px;   /* غيّر الحجم كما تحب */
                 height: 150px;
                 object-fit: contain;
}
        /* الاسم بتدرج */
        h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #ffffff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 2px;
        }

        /* جملة قوية */
        p {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        /* الزر */
        .btn {
            padding: 18px 60px;
            font-size: 20px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(45deg, #00c6ff, #0072ff);
            color: white;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 0 25px rgba(0, 114, 255, 0.7);
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 40px rgba(0, 114, 255, 1);
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes float {
            0%,100% {transform: translateY(0);}
            50% {transform: translateY(-12px);}
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="logo"></div>
        <h1>MediEase</h1>
        <p>Experience healthcare the smarter, faster, and easier way</p>
<a href="<?php echo e(route('front')); ?>" class="btn">Enter Platform</a>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/startpage.blade.php ENDPATH**/ ?>