<?php 
$pageTitle = 'Carrito de Compras';
$showSteps = true;
$currentStep = 1;
require_once __DIR__ . '/header.php'; 
?>

<style>
.cart-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.cart-card {
    background: white;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.cart-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e6e6e6;
    gap: 20px;
}

.cart-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
}

.item-image-placeholder {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    flex-shrink: 0;
}

.item-details {
    flex-grow: 1;
}

.item-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.item-price {
    color: #666;
    font-size: 0.9rem;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-btn {
    width: 35px;
    height: 35px;
    border: 1px solid #e6e6e6;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.2s;
}

.quantity-btn:hover {
    background: #f5f5f5;
    border-color: #3483fa;
}

.quantity-input {
    width: 60px;
    text-align: center;
    border: 1px solid #e6e6e6;
    border-radius: 4px;
    padding: 8px;
    font-weight: 600;
}

.item-total {
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    min-width: 120px;
    text-align: right;
}

.remove-btn {
    background: transparent;
    border: none;
    color: #3483fa;
    cursor: pointer;
    padding: 8px;
    font-size: 1.2rem;
}

.remove-btn:hover {
    color: #2968c8;
}

.summary-card {
    background: white;
    border-radius: 6px;
    padding: 25px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    position: sticky;
    top: 90px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 1rem;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    padding-top: 15px;
    border-top: 1px solid #e6e6e6;
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
}

.checkout-btn {
    background: #3483fa;
    color: white;
    border: none;
    padding: 16px;
    border-radius: 6px;
    font-size: 1.1rem;
    font-weight: 600;
    width: 100%;
    cursor: pointer;
    margin-top: 20px;
    transition: background 0.2s;
}

.checkout-btn:hover {
    background: #2968c8;
}

.continue-shopping {
    color: #3483fa;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 15px;
    font-weight: 600;
}

.continue-shopping:hover {
    text-decoration: underline;
}

.empty-cart {
    text-align: center;
    padding: 60px 20px;
}

.empty-cart-icon {
    font-size: 5rem;
    color: #ccc;
    margin-bottom: 20px;
}

.empty-cart h3 {
    color: #666;
    margin-bottom: 15px;
}

.shipping-info {
    background: #e8f5e9;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.shipping-info i {
    color: #00a650;
    font-size: 1.5rem;
}
</style>

<div class="cart-container">
    <?php if (empty($cartItems)): ?>
        <!-- Carrito Vacío -->
        <div class="cart-card">
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h3>Tu carrito está vacío</h3>
                <p class="text-muted">¡Agrega productos para comenzar tu compra!</p>
                <a href="<?php echo url_for('index.php?action=client'); ?>" class="btn btn-primary mt-3" style="background: #3483fa; border: none; padding: 12px 40px;">
                    <i class="bi bi-bag"></i> Ver Productos
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Items del Carrito -->
            <div class="col-lg-8">
                <div class="cart-card">
                    <h2 class="cart-title">
                        <i class="bi bi-cart3"></i> Carrito de compras (<?php echo count($cartItems); ?> <?php echo count($cartItems) == 1 ? 'producto' : 'productos'; ?>)
                    </h2>
                    
                    <div class="shipping-info">
                        <i class="bi bi-truck"></i>
                        <div>
                            <strong>¡Envío gratis!</strong> en todos tus productos
                        </div>
                    </div>
                    
                    <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <!-- Imagen -->
                        <?php if (!empty($item['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                 class="item-image" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="item-image-placeholder" style="display: none;">
                                <i class="bi bi-image"></i>
                            </div>
                        <?php else: ?>
                            <div class="item-image-placeholder">
                                <i class="bi bi-image"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Detalles -->
                        <div class="item-details">
                            <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="item-price">Precio: $<?php echo number_format($item['price'], 2); ?></div>
                        </div>
                        
                        <!-- Cantidad -->
                        <div class="quantity-controls">
                            <form method="POST" action="<?php echo url_for('index.php?action=update_cart'); ?>" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="quantity" value="<?php echo $item['quantity'] - 1; ?>" class="quantity-btn">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="quantity_display" value="<?php echo $item['quantity']; ?>" 
                                       class="quantity-input" readonly>
                                <button type="submit" name="quantity" value="<?php echo $item['quantity'] + 1; ?>" class="quantity-btn">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Precio Total -->
                        <div class="item-total">
                            $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </div>
                        
                        <!-- Eliminar -->
                        <a href="<?php echo url_for('index.php?action=remove_from_cart&id=' . $item['id']); ?>"
                           class="remove-btn"
                           onclick="return confirm('¿Eliminar este producto?');">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="mt-3">
                        <a href="<?php echo url_for('index.php?action=client'); ?>" class="continue-shopping">
                            <i class="bi bi-arrow-left"></i> Seguir comprando
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Resumen -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <h5 class="mb-3" style="font-weight: 700;">Resumen de compra</h5>
                    
                    <div class="summary-row">
                        <span>Productos (<?php echo count($cartItems); ?>)</span>
                        <span>$<?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    
                    <div class="summary-row" style="color: #00a650;">
                        <span><i class="bi bi-truck"></i> Envío</span>
                        <span>Gratis</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>$<?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    <br>
                    <a href="<?php echo url_for('index.php?action=checkout'); ?>" class="checkout-btn">
                        <i class="bi bi-credit-card"></i> Continuar compra
                    </a>
                    <br>
                    <div class="mt-3 text-center" style="font-size: 0.85rem; color: #666;">
                        <i class="bi bi-shield-check"></i> Compra 100% segura
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
