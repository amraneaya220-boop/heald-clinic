

<?php $__env->startSection('title', 'Ads'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <h3><i class="fas fa-ad"></i> Manage Advertisements</h3>
        <button class="btn-sm" id="openAddAdModal" style="padding: 10px 20px;"><i class="fas fa-plus"></i> Add Ad</button>
    </div>
    <div id="adsList">
        <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="background: #1e3a5f; border-radius: 20px; padding: 15px; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">
            <div>
                <?php if($ad->type == 'image'): ?>
                    <img src="<?php echo e($ad->url); ?>" style="max-width: 150px; max-height: 80px; border-radius: 12px;" alt="ad">
                <?php else: ?>
                    <video width="150" style="max-height: 80px; border-radius: 12px;">
                        <source src="<?php echo e($ad->url); ?>">
                    </video>
                <?php endif; ?>
            </div>
            <div style="flex: 2;">
                <strong><?php echo e($ad->title); ?></strong><br>
                <small><?php echo e(ucfirst($ad->type)); ?> | Expires: <?php echo e($ad->expiry_date); ?></small>
            </div>
            <div>
                <button class="btn-sm btn-danger" onclick="deleteAd(<?php echo e($ad->id); ?>)">Delete</button>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div id="addAdModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>New Advertisement</h3>
        <div class="form-group">
            <label>Title</label>
            <input type="text" id="adTitle">
        </div>
        <div class="form-group">
            <label>Type</label>
            <select id="adType">
                <option value="image">Image</option>
                <option value="video">Video</option>
            </select>
        </div>
        <div class="form-group">
            <label>File URL</label>
            <input type="url" id="adUrl" placeholder="https://example.com/ad.jpg">
        </div>
        <div class="form-group">
            <label>Target Link (optional)</label>
            <input type="url" id="adLink" placeholder="https://...">
        </div>
        <div class="form-group">
            <label>Duration (days)</label>
            <input type="number" id="adDuration" value="30">
        </div>
        <button class="btn-sm" id="saveAdBtn">Publish</button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const addModal = document.getElementById('addAdModal');
    document.getElementById('openAddAdModal').onclick = () => addModal.style.display = 'flex';
    document.querySelector('#addAdModal .close').onclick = () => addModal.style.display = 'none';

    document.getElementById('saveAdBtn').onclick = () => {
        const title = document.getElementById('adTitle').value;
        const type = document.getElementById('adType').value;
        const url = document.getElementById('adUrl').value;
        const link = document.getElementById('adLink').value;
        const duration = document.getElementById('adDuration').value;

        if (title && url) {
            fetch('<?php echo e(route("admin.ads.store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ title, type, url, link, duration })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
        }
    };

    function deleteAd(id) {
        if (confirm('Delete this ad?')) {
            fetch(`<?php echo e(url('admin/ads')); ?>/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
        }
    }

    window.onclick = (e) => { if (e.target === addModal) addModal.style.display = 'none'; };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/ads.blade.php ENDPATH**/ ?>