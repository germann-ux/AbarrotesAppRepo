<?php 
$pageTitle = 'Catálogo de Productos';
$showSteps = false;
require_once __DIR__ . '/header.php'; 
?>

<style>
/* Filtros */
.filters-bar {
    background: white;
    padding: 15px;
    margin: 20px 0;
    border-radius: 6px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.filter-btn {
    border: 1px solid #e6e6e6;
    background: white;
    padding: 8px 16px;
    border-radius: 20px;
    margin: 5px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.filter-btn:hover, .filter-btn.active {
    background: #3483fa;
    color: white;
    border-color: #3483fa;
}

/* Productos estilo Mercado Libre */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 40px;
}

.product-card {
    background: white;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.2s;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    transform: translateY(-4px);
}

.product-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: #f5f5f5;
}

.product-image-placeholder {
    width: 100%;
    height: 220px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.product-body {
    padding: 16px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-price {
    font-size: 1.5rem;
    font-weight: 400;
    color: #333;
    margin-bottom: 8px;
}

.product-title {
    font-size: 0.875rem;
    color: #666;
    margin-bottom: 8px;
    line-height: 1.4;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-shipping {
    color: #00a650;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.product-category {
    font-size: 0.75rem;
    color: #999;
    margin-bottom: 12px;
}

.add-to-cart-btn {
    background: #3483fa;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 6px;
    font-weight: 600;
    width: 100%;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: auto;
}

.add-to-cart-btn:hover {
    background: #2968c8;
}

.add-to-cart-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.stock-badge {
    display: inline-block;
    background: #e8f5e9;
    color: #2e7d32;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.low-stock {
    background: #fff3cd;
    color: #856404;
}
</style>

<!-- Contenido Principal -->
<div class="container">
    <!-- Filtros -->
    <div class="filters-bar">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <strong>Categorías:</strong>
                <button class="filter-btn active" data-category="all">
                    <i class="bi bi-grid-fill"></i> Todas
                </button>
                <?php foreach ($categories as $category): ?>
                <button class="filter-btn" data-category="<?php echo $category['id']; ?>">
                    <?php echo htmlspecialchars($category['nombre']); ?>
                </button>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($searchQuery)): ?>
            <div class="text-muted small">
                Mostrando resultados para "<?php echo htmlspecialchars($searchQuery); ?>" (<?php echo count($products); ?>)
            </div>
            <?php endif; ?>
        </div>
    </div>

        <!-- Grid de Productos -->
        <div class="products-grid">
            <?php if (empty($products)): ?>
                <div class="alert alert-warning w-100" role="alert">
                    No se encontraron productos que coincidan con tu búsqueda.
                </div>
            <?php endif; ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?php echo $product['categoria_id']; ?>">
                <!-- Imagen -->
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                         class="product-image" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="product-image-placeholder" style="display: none;">
                        <i class="bi bi-image"></i>
                    </div>
                <?php else: ?>
                    <div class="product-image-placeholder">
                        <i class="bi bi-image"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Información -->
                <div class="product-body">
                    <div class="product-price">
                        $<?php echo number_format($product['price'], 2); ?>
                    </div>
                    
                    <div class="product-title">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </div>
                    
                    <div class="product-shipping">
                        <i class="bi bi-truck"></i> Envío gratis
                    </div>
                    
                    <div class="product-category">
                        <i class="bi bi-tag"></i> <?php echo htmlspecialchars($product['category_name'] ?? 'General'); ?>
                    </div>
                    
                    <?php if ($product['stock'] < 10 && $product['stock'] > 0): ?>
                    <span class="stock-badge low-stock">¡Últimas <?php echo $product['stock']; ?> unidades!</span>
                    <?php elseif ($product['stock'] > 0): ?>
                    <span class="stock-badge">Stock: <?php echo $product['stock']; ?> disponibles</span>
                    <?php endif; ?>
                    
                    <!-- Botón añadir -->
                    <form method="POST" action="<?php echo url_for('index.php?action=add_to_cart'); ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-to-cart-btn" <?php echo $product['stock'] <= 0 ? 'disabled' : ''; ?>>
                            <i class="bi bi-cart-plus"></i>
                            <?php echo $product['stock'] > 0 ? 'Agregar al carrito' : 'Sin stock'; ?>
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
    // Filtro de categorías
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Actualizar botones activos
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar productos
            document.querySelectorAll('.product-card').forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Búsqueda simple
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                const title = card.querySelector('.product-title').textContent.toLowerCase();
                card.style.display = title.includes(search) ? 'flex' : 'none';
            });
        });
    }
    </script>

<?php require_once __DIR__ . '/footer.php'; ?>
