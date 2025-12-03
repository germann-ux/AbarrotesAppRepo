<?php 
$pageTitle = 'Finalizar Compra';
$showSteps = true;
$currentStep = 2;
require_once __DIR__ . '/header.php'; 
?>

<style>
.checkout-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.checkout-card {
    background: white;
    border-radius: 6px;
    padding: 25px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #3483fa;
}

.form-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

.form-control {
    border-radius: 6px;
    padding: 10px 12px;
    border: 1px solid #ccc;
}

.form-control:focus {
    border-color: #3483fa;
    box-shadow: 0 0 0 2px rgba(52, 131, 250, 0.2);
}

.summary-card {
    background: white;
    border-radius: 6px;
    padding: 25px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    position: sticky;
    top: 90px;
}

.summary-item {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f5f5f5;
}

.summary-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.summary-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #eee;
}

.summary-details {
    flex-grow: 1;
}

.summary-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.summary-qty {
    font-size: 0.8rem;
    color: #999;
}

.summary-price {
    font-weight: 600;
    color: #333;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 1rem;
    color: #666;
}

.total-final {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
}

.confirm-btn {
    background: linear-gradient(135deg, #3483fa 0%, #2968c8 100%);
    color: white;
    border: none;
    padding: 18px 24px;
    border-radius: 8px;
    font-size: 1.15rem;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    margin-top: 20px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(52, 131, 250, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.confirm-btn:hover {
    background: linear-gradient(135deg, #2968c8 0%, #1e4fa0 100%);
    box-shadow: 0 6px 20px rgba(52, 131, 250, 0.5);
    transform: translateY(-2px);
}

.confirm-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(52, 131, 250, 0.3);
}

.back-link {
    display: inline-block;
    margin-top: 15px;
    color: #3483fa;
    text-decoration: none;
    font-weight: 500;
}

.back-link:hover {
    text-decoration: underline;
}

.secure-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #00a650;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 20px;
    background: #e8f5e9;
    padding: 10px;
    border-radius: 4px;
}
</style>

<div class="checkout-container">
    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-8">
            <form method="POST" action="<?php echo url_for('index.php?action=process_order'); ?>" id="checkoutForm">
                <div class="checkout-card">
                    <div class="section-title">
                        <i class="bi bi-person-circle"></i> Datos de Contacto
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Tal cual figura en tu INE">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono celular</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required placeholder="Para contactarte en la entrega">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Para enviarte el recibo de compra">
                        </div>
                    </div>
                </div>
                
                <div class="checkout-card">
                    <div class="section-title">
                        <i class="bi bi-geo-alt-fill"></i> Dirección de Envío
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección completa</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="3" required placeholder="Calle, número, colonia, código postal, ciudad, referencias..."></textarea>
                    </div>
                </div>
                
                <div class="d-none d-lg-block">
                    <button type="submit" class="confirm-btn">
                        <i class="bi bi-check-circle-fill"></i>
                        Confirmar Compra
                    </button>
                    <div class="text-center">
                        <a href="<?php echo url_for('index.php?action=cart'); ?>" class="back-link">
                            <i class="bi bi-arrow-left"></i> Volver al carrito
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Resumen -->
        <div class="col-lg-4">
            <div class="summary-card">
                <div class="section-title">Resumen de compra</div>
                
                <div class="secure-badge">
                    <i class="bi bi-shield-check"></i> Compra 100% protegida
                </div>
                
                <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                    <?php foreach ($cartItems as $item): ?>
                    <div class="summary-item">
                        <?php if (!empty($item['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="summary-img" alt="Producto">
                        <?php else: ?>
                            <div class="summary-img d-flex align-items-center justify-content-center bg-light text-muted">
                                <i class="bi bi-image"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="summary-details">
                            <div class="summary-name"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="summary-qty">Cant: <?php echo $item['quantity']; ?></div>
                        </div>
                        <div class="summary-price">
                            $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="total-row">
                    <span>Productos</span>
                    <span>$<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <div class="total-row" style="color: #00a650;">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>
                
                <div class="total-final">
                    <span>Total</span>
                    <span>$<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                
                <div class="d-lg-none">
                    <button type="submit" form="checkoutForm" class="confirm-btn">
                        <i class="bi bi-check-circle-fill"></i>
                        Confirmar Compra
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
