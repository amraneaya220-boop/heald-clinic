

<?php $__env->startSection('title', 'Subscription Plans'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .plans-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }
    
    .plans-container h2 {
        font-size: 32px;
        color: #1e293b;
        margin-bottom: 10px;
        text-align: center;
    }
    
    .plans-subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 40px;
        font-size: 16px;
    }
    
    /* Trial Banner */
    .trial-banner {
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 24px;
        padding: 25px 30px;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        color: white;
        box-shadow: 0 10px 25px rgba(16,185,129,0.2);
    }
    
    .trial-banner .trial-text {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .trial-banner .trial-text i {
        font-size: 40px;
    }
    
    .trial-banner .trial-text h3 {
        font-size: 22px;
        margin-bottom: 5px;
    }
    
    .trial-banner .trial-text p {
        opacity: 0.9;
    }
    
    .btn-trial {
        background: white;
        color: #059669;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .btn-trial:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Plans Grid */
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }
    
    .plan-card {
        background: white;
        border-radius: 28px;
        padding: 35px;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: 1px solid #f1f5f9;
        position: relative;
    }
    
    .plan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    
    .plan-card.popular {
        border: 2px solid #f59e0b;
    }
    
    .popular-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background: #f59e0b;
        color: white;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }
    
    .plan-card h3 {
        font-size: 24px;
        color: #1e293b;
        margin-bottom: 15px;
    }
    
    .price {
        font-size: 42px;
        font-weight: 800;
        color: #6366f1;
        margin-bottom: 5px;
    }
    
    .price-period {
        font-size: 14px;
        color: #64748b;
    }
    
    .discount {
        background: #fef3c7;
        color: #d97706;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }
    
    .features {
        list-style: none;
        margin: 25px 0;
        padding: 0;
        text-align: left;
    }
    
    .features li {
        padding: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #475569;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .features li i {
        color: #10b981;
        width: 20px;
    }
    
    .btn-subscribe {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        padding: 14px 20px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        font-size: 15px;
        transition: all 0.3s;
        margin-top: 15px;
    }
    
    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(99,102,241,0.3);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .plans-container {
            padding: 20px;
        }
        .plans-grid {
            grid-template-columns: 1fr;
        }
        .trial-banner {
            flex-direction: column;
            text-align: center;
        }
        .trial-banner .trial-text {
            flex-direction: column;
        }
    }
</style>

<div class="plans-container">
    <h2>💰 Choose Your Subscription Plan</h2>
    <p class="plans-subtitle">Select the best plan for your clinic needs</p>
    
    <?php if($remainingTrials > 0): ?>
    <div class="trial-banner">
        <div class="trial-text">
            <i class="fas fa-gift"></i>
            <div>
                <h3><?php echo e($remainingTrials); ?> Free Trial<?php echo e($remainingTrials > 1 ? 's' : ''); ?> Available!</h3>
                <p>Test all features before committing to a subscription</p>
            </div>
        </div>
        <form action="<?php echo e(route('clinic.subscription.use-trial')); ?>" method="POST" style="display: inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-trial">
                <i class="fas fa-play"></i> Start Free Trial
            </button>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="plans-grid">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="plan-card <?php echo e($key == 'yearly' ? 'popular' : ''); ?>">
            <?php if($key == 'yearly'): ?>
                <div class="popular-badge">⭐ Most Popular</div>
            <?php endif; ?>
            <h3><?php echo e($plan['name']); ?></h3>
            <div class="price"><?php echo e(number_format($plan['price'], 2)); ?> <span style="font-size: 18px;">DZD</span></div>
            <div class="price-period">per <?php echo e($plan['duration']); ?></div>
            <?php if(isset($plan['discount'])): ?>
                <div class="discount"><?php echo e($plan['discount']); ?></div>
            <?php endif; ?>
            
            <ul class="features">
                <?php $__currentLoopData = $plan['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><i class="fas fa-check-circle"></i> <?php echo e($feature); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            
            <button class="btn-subscribe" onclick="openPaymentModal('<?php echo e($key); ?>', '<?php echo e($plan['name']); ?>', <?php echo e($plan['price']); ?>)">
                <i class="fas fa-credit-card"></i> Subscribe Now
            </button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal" style="display: none;">
    <div class="payment-modal-content">
        <div class="payment-modal-header">
            <h3><i class="fas fa-credit-card"></i> Complete Payment</h3>
            <button class="payment-modal-close" onclick="closePaymentModal()">&times;</button>
        </div>
        
        <form id="paymentForm" method="POST" action="<?php echo e(route('clinic.subscription.subscribe')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="plan" id="selectedPlan">
            <input type="hidden" name="amount" id="selectedAmount">
            
            <!-- Payment Method Selection -->
            <div class="payment-methods">
                <div class="payment-method-item" onclick="selectPaymentMethod('cih')">
                    <div class="payment-method-radio">
                        <input type="radio" name="payment_method" value="cih" id="method_cih" required>
                    </div>
                    <div class="payment-method-icon">
                        <img src="https://upload.wikimedia.org/wikipedia/fr/thumb/1/1a/Logo_CIH_Bank.svg/1200px-Logo_CIH_Bank.svg.png" alt="CIH Bank" style="width: 50px;">
                    </div>
                    <div class="payment-method-info">
                        <strong>CIH Bank</strong>
                        <small>Paiement par carte CIH</small>
                    </div>
                </div>
                
                <div class="payment-method-item" onclick="selectPaymentMethod('edahabia')">
                    <div class="payment-method-radio">
                        <input type="radio" name="payment_method" value="edahabia" id="method_edahabia">
                    </div>
                    <div class="payment-method-icon">
                        <i class="fas fa-credit-card" style="font-size: 40px; color: #10b981;"></i>
                    </div>
                    <div class="payment-method-info">
                        <strong>Edahabia</strong>
                        <small>Carte Edahabia (CPA)</small>
                    </div>
                </div>
                
                <div class="payment-method-item" onclick="selectPaymentMethod('bank_transfer')">
                    <div class="payment-method-radio">
                        <input type="radio" name="payment_method" value="bank_transfer" id="method_bank">
                    </div>
                    <div class="payment-method-icon">
                        <i class="fas fa-university" style="font-size: 40px; color: #6366f1;"></i>
                    </div>
                    <div class="payment-method-info">
                        <strong>Bank Transfer</strong>
                        <small>Virement bancaire</small>
                    </div>
                </div>
            </div>
            
            <!-- CIH Payment Form -->
            <div id="cihForm" class="payment-detail-form" style="display: none;">
                <h4><i class="fas fa-credit-card"></i> CIH Bank Details</h4>
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX" maxlength="19">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Expiry Date</label>
                        <input type="text" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="password" placeholder="XXX" maxlength="4">
                    </div>
                </div>
            </div>
            
            <!-- Edahabia Payment Form -->
            <div id="edahabiaForm" class="payment-detail-form" style="display: none;">
                <h4><i class="fas fa-mobile-alt"></i> Edahabia Details</h4>
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX" maxlength="19">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" placeholder="05XX XX XX XX">
                </div>
            </div>
            
            <!-- Bank Transfer Form -->
            <div id="bankForm" class="payment-detail-form" style="display: none;">
                <h4><i class="fas fa-building"></i> Bank Transfer Details</h4>
                <div class="bank-info">
                    <p><strong>Beneficiary:</strong> MediEase Clinic</p>
                    <p><strong>Bank:</strong> BEA Bank Algeria</p>
                    <p><strong>IBAN:</strong> DZ 1234 5678 9012 3456 7890 123</p>
                    <p><strong>SWIFT:</strong> BEAADZAL</p>
                    <p><strong>Amount:</strong> <span id="bankAmount">0</span> DZD</p>
                </div>
                <div class="form-group">
                    <label>Transfer Reference</label>
                    <input type="text" class="form-control" placeholder="Enter transfer reference">
                </div>
                <div class="form-group">
                    <label>Upload Receipt (Optional)</label>
                    <input type="file" class="form-control" accept="image/*,.pdf">
                </div>
            </div>
            
            <div class="payment-summary">
                <div class="summary-row">
                    <span>Plan:</span>
                    <span id="summaryPlan">-</span>
                </div>
                <div class="summary-row">
                    <span>Amount:</span>
                    <span id="summaryAmount">0 DZD</span>
                </div>
                <div class="summary-row total">
                    <span>Total to Pay:</span>
                    <span id="summaryTotal">0 DZD</span>
                </div>
            </div>
            
            <button type="submit" class="btn-confirm-payment">
                <i class="fas fa-check-circle"></i> Confirm Payment
            </button>
        </form>
    </div>
</div>

<style>
    /* Payment Modal Styles */
    .payment-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .payment-modal-content {
        background: white;
        width: 550px;
        max-width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 28px;
        animation: modalPop 0.3s ease;
    }
    
    .payment-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .payment-modal-header h3 {
        font-size: 20px;
        color: #1e293b;
        margin: 0;
    }
    
    .payment-modal-close {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: #94a3b8;
        transition: all 0.2s;
    }
    
    .payment-modal-close:hover {
        color: #ef4444;
    }
    
    .payment-methods {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .payment-method-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .payment-method-item:hover {
        border-color: #6366f1;
        background: #f8fafc;
    }
    
    .payment-method-item.selected {
        border-color: #6366f1;
        background: #eef2ff;
    }
    
    .payment-method-radio input {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .payment-method-icon {
        width: 50px;
        text-align: center;
    }
    
    .payment-method-info strong {
        display: block;
        color: #1e293b;
        font-size: 15px;
    }
    
    .payment-method-info small {
        color: #64748b;
        font-size: 12px;
    }
    
    .payment-detail-form {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    
    .payment-detail-form h4 {
        color: #1e293b;
        margin-bottom: 15px;
        font-size: 16px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #1e293b;
        font-weight: 500;
        font-size: 13px;
    }
    
    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .form-group input:focus {
        outline: none;
        border-color: #6366f1;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .bank-info {
        background: #eef2ff;
        padding: 15px;
        border-radius: 16px;
        margin-bottom: 15px;
    }
    
    .bank-info p {
        margin: 8px 0;
        font-size: 13px;
        color: #1e293b;
    }
    
    .payment-summary {
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        color: #475569;
        font-size: 14px;
    }
    
    .summary-row.total {
        font-weight: 700;
        color: #1e293b;
        font-size: 16px;
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
        padding-top: 12px;
    }
    
    .btn-confirm-payment {
        width: calc(100% - 50px);
        margin: 20px 25px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-confirm-payment:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16,185,129,0.3);
    }
    
    @keyframes modalPop {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    let selectedPlanKey = '';
    let selectedPlanName = '';
    let selectedPlanPrice = 0;
    
    function openPaymentModal(planKey, planName, price) {
        selectedPlanKey = planKey;
        selectedPlanName = planName;
        selectedPlanPrice = price;
        
        document.getElementById('selectedPlan').value = planKey;
        document.getElementById('selectedAmount').value = price;
        document.getElementById('summaryPlan').innerText = planName;
        document.getElementById('summaryAmount').innerText = price.toLocaleString() + ' DZD';
        document.getElementById('summaryTotal').innerText = price.toLocaleString() + ' DZD';
        document.getElementById('bankAmount').innerText = price.toLocaleString();
        
        document.getElementById('paymentModal').style.display = 'flex';
    }
    
    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
        // Reset forms
        document.querySelectorAll('.payment-detail-form').forEach(form => {
            form.style.display = 'none';
        });
        document.querySelectorAll('.payment-method-item').forEach(item => {
            item.classList.remove('selected');
        });
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.checked = false;
        });
    }
    
    function selectPaymentMethod(method) {
        // Update UI
        document.querySelectorAll('.payment-method-item').forEach(item => {
            item.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
        
        // Check radio
        document.getElementById(`method_${method}`).checked = true;
        
        // Show corresponding form
        document.getElementById('cihForm').style.display = 'none';
        document.getElementById('edahabiaForm').style.display = 'none';
        document.getElementById('bankForm').style.display = 'none';
        
        if (method === 'cih') {
            document.getElementById('cihForm').style.display = 'block';
        } else if (method === 'edahabia') {
            document.getElementById('edahabiaForm').style.display = 'block';
        } else if (method === 'bank_transfer') {
            document.getElementById('bankForm').style.display = 'block';
        }
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('paymentModal');
        if (event.target === modal) {
            closePaymentModal();
        }
    }
    
    // Handle form submission
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedMethod) {
            e.preventDefault();
            alert('Veuillez sélectionner un mode de paiement');
            return;
        }
        
        // Here you can add validation for each payment method
        if (selectedMethod.value === 'cih') {
            const cardNumber = document.querySelector('#cihForm input[placeholder*="XXXX"]');
            if (cardNumber && cardNumber.value.trim().length < 16) {
                e.preventDefault();
                alert('Veuillez entrer un numéro de carte valide');
                return;
            }
        }
        
        // Show loading
        const submitBtn = document.querySelector('.btn-confirm-payment');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/subscription/plans.blade.php ENDPATH**/ ?>