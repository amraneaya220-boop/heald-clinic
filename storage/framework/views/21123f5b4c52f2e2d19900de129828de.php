

<?php $__env->startSection('title', $clinic->name); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    /* نفس الـ styles من clinic (7).html */
    .card{max-width:450px;width:100%;background:white;border-radius:32px;overflow:hidden;box-shadow:0 25px 45px rgba(0,0,0,0.25);margin:40px auto;}
    .image{width:100%;height:260px;overflow:hidden;}
    .image img{width:100%;height:100%;object-fit:cover;}
    .content{padding:28px 25px 32px;text-align:center;}
    h1{font-size:26px;font-weight:700;color:#1e3a8a;margin-bottom:8px;}
    .location{color:#64748b;margin:8px 0;font-size:14px;background:#f1f5f9;padding:6px 16px;border-radius:50px;display:inline-flex;align-items:center;gap:6px;}
    .stars{font-size:22px;margin:18px 0;letter-spacing:3px;color:#fbbf24;}
    .divider{width:60px;height:3px;background:linear-gradient(90deg,#3b82f6,#8b5cf6);margin:15px auto 0;}
    .buttons{display:flex;gap:15px;margin-top:22px;justify-content:center;}
    .back,.details{padding:12px 28px;border-radius:50px;font-weight:600;cursor:pointer;border:none;font-size:14px;}
    .back{background:#3b82f6;color:white;}
    .details{background:#8b5cf6;color:white;}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="image">
        <img src="<?php echo e($clinic->image ?? 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=600&h=350&fit=crop'); ?>" alt="<?php echo e($clinic->name); ?>">
    </div>
    <div class="content">
        <h1><?php echo e($clinic->name); ?></h1>
        <div class="location">📍 <?php echo e($clinic->location); ?></div>
        <div class="stars"><?php echo str_repeat('⭐', round($clinic->rating ?? 4)); ?> (<?php echo e($clinic->rating ?? 4); ?>.0)</div>
        <div class="divider"></div>
        <div class="buttons">
            <button class="back" onclick="history.back()">← Back</button>
            <button class="details" onclick="window.location.href='<?php echo e(route('clinic.details', $clinic->id)); ?>'">📋 Show Details</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/front/clinic.blade.php ENDPATH**/ ?>