<?php 
$pageTitle = '¡Compra Exitosa!';
$showSteps = true;
$currentStep = 3;
require_once __DIR__ . '/header.php'; 
?>

<style>
.confirmation-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.success-card {
    background: white;
    border-radius: 6px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.success-icon {
    width: 80px;
    height: 80px;
    background: #e8f5e9;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.success-icon i {
    font-size: 40px;
    color: #00a650;
}

.success-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.success-message {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.order-info {
    background: #f5f5f5;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 30px;
    text-align: left;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e6e6e6;
}

.info-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-label {
    color: #666;
    font-weight: 500;
}

.info-value {
    color: #333;
    font-weight: 600;
}

.actions {
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn-primary-custom {
    background: #3483fa;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}

.btn-primary-custom:hover {
    background: #2968c8;
    color: white;
}

.btn-secondary-custom {
    background: white;
    color: #3483fa;
    border: 1px solid #3483fa;
    padding: 12px 30px;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary-custom:hover {
    background: #f5f5f5;
}

.product-list {
    text-align: left;
    margin-top: 20px;
}

.product-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.product-item:last-child {
    border-bottom: none;
}

.product-icon {
    width: 50px;
    height: 50px;
    background: #f5f5f5;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
}

.product-info {
    flex-grow: 1;
}

.product-name {
    font-weight: 600;
    color: #333;
}

.product-qty {
    font-size: 0.9rem;
    color: #666;
}

.product-price {
    font-weight: 600;
    color: #333;
}
</style>

<div class="confirmation-container">
    <div class="success-card">
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        
        <h1 class="success-title">¡Gracias por tu compra!</h1>
        <p class="success-message">
            Tu pedido #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?> ha sido confirmado.
            <br>
            Te enviamos los detalles a <strong><?php echo htmlspecialchars($order['email_cliente']); ?></strong>
        </p>
        
        <div class="order-info">
            <div class="info-row">
                <span class="info-label">Cliente</span>
                <span class="info-value"><?php echo htmlspecialchars($order['nombre_cliente']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Dirección</span>
                <span class="info-value"><?php echo htmlspecialchars($order['direccion_envio']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Pagado</span>
                <span class="info-value" style="font-size: 1.2rem; color: #3483fa;">$<?php echo number_format($order['total'], 2); ?></span>
            </div>
        </div>
        
        <div class="product-list">
            <h5 class="mb-3">Lo que compraste:</h5>
            <?php foreach ($orderItems as $item): ?>
            <div class="product-item">
                <div class="product-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="product-info">
                    <div class="product-name"><?php echo htmlspecialchars($item['nombre_producto']); ?></div>
                    <div class="product-qty">Cantidad: <?php echo $item['cantidad']; ?></div>
                </div>
                <div class="product-price">
                    $<?php echo number_format($item['subtotal'], 2); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="actions mt-4">
            <a href="/proyecto2/index.php?action=client" class="btn-primary-custom">
                Seguir comprando
            </a>
            <button onclick="window.print()" class="btn-secondary-custom">
                <i class="bi bi-printer"></i> Imprimir
            </button>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
