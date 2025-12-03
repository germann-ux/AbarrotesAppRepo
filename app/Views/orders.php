<?php require_once __DIR__ . '/layouts/header.php'; ?>

<style>
/* Estilos generales */
.orders-dashboard {
    background: #fafafa;
    min-height: 100vh;
    padding: 20px 0;
}

/* Estadísticas */
.stats-card {
    border-radius: 12px;
    border: 1px solid #e8e8e8;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
    background: white;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    border-color: #d0d0d0;
}

.stats-icon {
    font-size: 2.5rem;
    opacity: 0.08;
    position: absolute;
    right: 20px;
    bottom: 15px;
}

.stats-number {
    font-size: 2.2rem;
    font-weight: 700;
    margin: 8px 0;
    color: #2c3e50;
}

.stats-label {
    font-size: 0.85rem;
    color: #7f8c8d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Filtros */
.filter-pills {
    background: white;
    padding: 18px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    margin-bottom: 25px;
    border: 1px solid #e8e8e8;
}

.filter-pill {
    padding: 8px 20px;
    border-radius: 20px;
    border: 1px solid #d0d0d0;
    background: white;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
    margin: 4px;
    color: #5a5a5a;
    font-size: 0.9rem;
}

.filter-pill:hover {
    background: #f5f5f5;
    border-color: #a0a0a0;
}

.filter-pill.active {
    background: #2c3e50;
    color: white;
    border-color: #2c3e50;
}

/* Grid de órdenes */
.orders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 18px;
    margin-bottom: 30px;
}

/* Tarjeta de orden */
.order-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid #e8e8e8;
    border-left: 3px solid #2c3e50;
    position: relative;
    overflow: hidden;
}

.order-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    border-color: #d0d0d0;
}

.order-card.status-pendiente {
    border-left-color: #95a5a6;
}

.order-card.status-procesando {
    border-left-color: #7f8c8d;
}

.order-card.status-enviada {
    border-left-color: #5a6c7d;
}

.order-card.status-completada {
    border-left-color: #2c3e50;
}

.order-card.status-cancelada {
    border-left-color: #bdc3c7;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eeeeee;
}

.order-id {
    font-size: 1.15rem;
    font-weight: 700;
    color: #2c3e50;
}

.order-status {
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: 1px solid;
}

.status-pendiente { 
    background: #f8f9fa; 
    color: #6c757d; 
    border-color: #dee2e6;
}
.status-procesando { 
    background: #f1f3f5; 
    color: #495057; 
    border-color: #ced4da;
}
.status-enviada { 
    background: #e9ecef; 
    color: #495057; 
    border-color: #adb5bd;
}
.status-completada { 
    background: #2c3e50; 
    color: white; 
    border-color: #2c3e50;
}
.status-cancelada { 
    background: white; 
    color: #95a5a6; 
    border-color: #dee2e6;
}

.customer-info {
    margin-bottom: 15px;
}

.customer-name {
    font-weight: 600;
    font-size: 1.05rem;
    color: #2c3e50;
    margin-bottom: 5px;
}

.customer-email {
    color: #7f8c8d;
    font-size: 0.88rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.order-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 0.7rem;
    color: #95a5a6;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 4px;
    font-weight: 500;
}

.detail-value {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.order-total {
    background: #2c3e50;
    color: white;
    padding: 14px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 15px;
}

.total-label {
    font-size: 0.75rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

.total-amount {
    font-size: 1.6rem;
    font-weight: 700;
    margin-top: 4px;
}

.order-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    flex: 1;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 0.9rem;
}

.btn-view {
    background: #2c3e50;
    color: white;
    border-color: #2c3e50;
}

.btn-view:hover {
    background: #1a252f;
    border-color: #1a252f;
}

.btn-status {
    background: white;
    color: #5a5a5a;
    border-color: #d0d0d0;
}

.btn-status:hover {
    background: #f5f5f5;
    border-color: #a0a0a0;
}

/* Modal mejorado */
.modal-content {
    border-radius: 12px;
    border: 1px solid #e8e8e8;
}

.modal-header {
    background: #2c3e50;
    color: white;
    border-radius: 12px 12px 0 0;
    border-bottom: none;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #95a5a6;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.3;
}
</style>

<div class="orders-dashboard">
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">
                <i class="bi bi-box-seam"></i> Panel de Órdenes
            </h1>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-label"><i class="bi bi-receipt"></i> Total Órdenes</div>
                        <div class="stats-number"><?php echo count($orders); ?></div>
                        <i class="bi bi-receipt-cutoff stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-label"><i class="bi bi-hourglass-split"></i> Pendientes</div>
                        <div class="stats-number">
                            <?php echo count(array_filter($orders, fn($o) => $o['estado'] === 'pendiente')); ?>
                        </div>
                        <i class="bi bi-clock-history stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-label"><i class="bi bi-check-circle"></i> Completadas</div>
                        <div class="stats-number">
                            <?php echo count(array_filter($orders, fn($o) => $o['estado'] === 'completada')); ?>
                        </div>
                        <i class="bi bi-check2-all stats-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="card-body">
                        <div class="stats-label"><i class="bi bi-currency-dollar"></i> Ventas Totales</div>
                        <div class="stats-number">
                            $<?php echo number_format(array_sum(array_column($orders, 'total')), 0); ?>
                        </div>
                        <i class="bi bi-cash-stack stats-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filter-pills">
            <strong class="me-3">Filtrar por estado:</strong>
            <button class="filter-pill active" onclick="filterOrders('all')">
                <i class="bi bi-grid-fill"></i> Todas
            </button>
            <button class="filter-pill" onclick="filterOrders('pendiente')">
                ⏳ Pendientes
            </button>
            <button class="filter-pill" onclick="filterOrders('procesando')">
                ⚙️ Procesando
            </button>
            <button class="filter-pill" onclick="filterOrders('enviada')">
                🚚 Enviadas
            </button>
            <button class="filter-pill" onclick="filterOrders('completada')">
                ✅ Completadas
            </button>
            <button class="filter-pill" onclick="filterOrders('cancelada')">
                ❌ Canceladas
            </button>
        </div>

        <!-- Grid de Órdenes -->
        <?php if (empty($orders)): ?>
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h4>No hay órdenes aún</h4>
            <p>Las órdenes aparecerán aquí cuando los clientes realicen compras.</p>
        </div>
        <?php else: ?>
        <div class="orders-grid" id="ordersGrid">
            <?php foreach ($orders as $order): ?>
            <div class="order-card status-<?php echo $order['estado']; ?>" data-status="<?php echo $order['estado']; ?>">
                <!-- Header -->
                <div class="order-header">
                    <div class="order-id">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></div>
                    <div class="order-status status-<?php echo $order['estado']; ?>">
                        <?php echo ucfirst($order['estado']); ?>
                    </div>
                </div>

                <!-- Cliente -->
                <div class="customer-info">
                    <div class="customer-name">
                        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($order['nombre_cliente']); ?>
                    </div>
                    <div class="customer-email">
                        <i class="bi bi-envelope"></i>
                        <?php echo htmlspecialchars($order['email_cliente']); ?>
                    </div>
                </div>

                <!-- Detalles -->
                <div class="order-details">
                    <div class="detail-item">
                        <div class="detail-label">Items</div>
                        <div class="detail-value">
                            <i class="bi bi-box"></i> <?php echo $order['items_count']; ?> productos
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Fecha</div>
                        <div class="detail-value">
                            <i class="bi bi-calendar3"></i> <?php echo date('d/m/Y', strtotime($order['creado_en'])); ?>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="order-total">
                    <div class="total-label">Total de la Orden</div>
                    <div class="total-amount">$<?php echo number_format($order['total'], 2); ?></div>
                </div>

                <!-- Acciones -->
                <div class="order-actions">
                    <button class="action-btn btn-view" onclick="viewOrderDetails(<?php echo $order['id']; ?>)">
                        <i class="bi bi-eye-fill"></i> Ver Detalles
                    </button>
                    <button class="action-btn btn-status" onclick="openStatusModal(<?php echo $order['id']; ?>, '<?php echo $order['estado']; ?>')">
                        <i class="bi bi-arrow-repeat"></i> Cambiar
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal para detalles -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-receipt"></i> Detalles de la Orden</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar estado -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-repeat"></i> Cambiar Estado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="statusOrderId">
                <label class="form-label fw-bold">Nuevo Estado:</label>
                <select class="form-select form-select-lg" id="newStatus">
                    <option value="pendiente">⏳ Pendiente</option>
                    <option value="procesando">⚙️ Procesando</option>
                    <option value="enviada">🚚 Enviada</option>
                    <option value="completada">✅ Completada</option>
                    <option value="cancelada">❌ Cancelada</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="updateOrderStatus()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
// Filtrar órdenes
function filterOrders(status) {
    const cards = document.querySelectorAll('.order-card');
    const pills = document.querySelectorAll('.filter-pill');
    
    pills.forEach(pill => pill.classList.remove('active'));
    event.target.closest('.filter-pill').classList.add('active');
    
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Abrir modal de estado
function openStatusModal(orderId, currentStatus) {
    document.getElementById('statusOrderId').value = orderId;
    document.getElementById('newStatus').value = currentStatus;
    new bootstrap.Modal(document.getElementById('statusModal')).show();
}

// Actualizar estado
function updateOrderStatus() {
    const orderId = document.getElementById('statusOrderId').value;
    const newStatus = document.getElementById('newStatus').value;
    
    fetch('/proyecto2/index.php?action=api_update_order_status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: orderId, status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        alert('✅ ' + data.message);
        location.reload();
    })
    .catch(error => {
        alert('❌ Error al actualizar');
        console.error(error);
    });
}

// Ver detalles
function viewOrderDetails(orderId) {
    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    const content = document.getElementById('orderDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border text-primary"></div></div>';
    modal.show();
    
    fetch('/proyecto2/index.php?action=api_get_order&id=' + orderId)
        .then(response => response.json())
        .then(order => {
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td>${item.nombre_producto}</td>
                        <td class="text-center">${item.cantidad}</td>
                        <td class="text-end">$${parseFloat(item.precio_unitario).toFixed(2)}</td>
                        <td class="text-end fw-bold">$${parseFloat(item.subtotal).toFixed(2)}</td>
                    </tr>
                `;
            });
            
            content.innerHTML = `
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6><i class="bi bi-person-circle"></i> Cliente</h6>
                        <p class="mb-1"><strong>Nombre:</strong> ${order.nombre_cliente}</p>
                        <p class="mb-1"><strong>Email:</strong> ${order.email_cliente}</p>
                        <p class="mb-1"><strong>Teléfono:</strong> ${order.telefono_cliente}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="bi bi-geo-alt-fill"></i> Envío</h6>
                        <p>${order.direccion_envio}</p>
                        <p class="mb-1"><strong>Fecha:</strong> ${new Date(order.creado_en).toLocaleString()}</p>
                    </div>
                </div>
                <hr>
                <h6><i class="bi bi-box-seam"></i> Productos</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>${itemsHtml}</tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td class="text-end fw-bold text-success">$${parseFloat(order.total).toFixed(2)}</td>
                        </tr>
                    </tfoot>
                </table>
            `;
        })
        .catch(error => {
            content.innerHTML = '<div class="alert alert-danger">Error al cargar</div>';
        });
}
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
