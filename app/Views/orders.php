<?php require_once __DIR__ . '/layouts/header.php'; ?>

<?php
$orders = $orders ?? [];
if (!is_array($orders)) $orders = [];

$allowedEstados = ['pendiente','procesando','enviada','completada','cancelada'];
$normalizeEstado = function ($estado) use ($allowedEstados) {
    $estado = strtolower(trim((string)$estado));
    return in_array($estado, $allowedEstados, true) ? $estado : 'pendiente';
};

// Stats en una pasada
$totalOrders = count($orders);
$counts = array_fill_keys($allowedEstados, 0);
$totalSales = 0.0;

foreach ($orders as $o) {
    $st = $normalizeEstado($o['estado'] ?? '');
    $counts[$st] = ($counts[$st] ?? 0) + 1;
    $totalSales += (float)($o['total'] ?? 0);
}

$baseIndexUrl = url_for('index.php');
?>

<style>
/* Puedes conservar tus estilos anteriores (stats-card, order-card, etc.) */
.orders-dashboard {
    background: #EAEDF0; /* gris neutro de la paleta */
    min-height: 100vh;
    padding: 24px 0;
}
</style>

<div
  id="ordersDashboard"
  class="orders-dashboard"
  data-base-url="<?php echo htmlspecialchars($baseIndexUrl, ENT_QUOTES, 'UTF-8'); ?>"
>
  <div class="max-w-6xl mx-auto px-4">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-2">
      <h1 class="text-2xl font-semibold text-[#013A4A] flex items-center gap-2">
        <i class="bi bi-box-seam text-[#013A4A]"></i>
        <span>Panel de Órdenes</span>
      </h1>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="stats-card bg-white rounded-xl shadow-sm border border-[#EAEDF0] relative overflow-hidden">
        <div class="px-4 py-3">
          <div class="stats-label text-xs font-semibold uppercase tracking-wide text-[#013A4A] flex items-center gap-1 opacity-70">
            <i class="bi bi-receipt"></i> Total Órdenes
          </div>
          <div class="stats-number text-2xl font-bold text-[#4ECB71] mt-1" id="statTotalOrders">
            <?php echo $totalOrders; ?>
          </div>
          <i class="bi bi-receipt-cutoff stats-icon absolute right-4 bottom-2 text-5xl text-[#EAEDF0]"></i>
        </div>
      </div>

      <div class="stats-card bg-white rounded-xl shadow-sm border border-[#EAEDF0] relative overflow-hidden">
        <div class="px-4 py-3">
          <div class="stats-label text-xs font-semibold uppercase tracking-wide text-[#013A4A] flex items-center gap-1 opacity-70">
            <i class="bi bi-hourglass-split"></i> Pendientes
          </div>
          <div class="stats-number text-2xl font-bold text-[#F2B544] mt-1" id="statPendientes">
            <?php echo (int)$counts['pendiente']; ?>
          </div>
          <i class="bi bi-clock-history stats-icon absolute right-4 bottom-2 text-5xl text-[#EAEDF0]"></i>
        </div>
      </div>

      <div class="stats-card bg-white rounded-xl shadow-sm border border-[#EAEDF0] relative overflow-hidden">
        <div class="px-4 py-3">
          <div class="stats-label text-xs font-semibold uppercase tracking-wide text-[#013A4A] flex items-center gap-1 opacity-70">
            <i class="bi bi-check-circle"></i> Completadas
          </div>
          <div class="stats-number text-2xl font-bold text-[#4ECB71] mt-1" id="statCompletadas">
            <?php echo (int)$counts['completada']; ?>
          </div>
          <i class="bi bi-check2-all stats-icon absolute right-4 bottom-2 text-5xl text-[#EAEDF0]"></i>
        </div>
      </div>

      <div class="stats-card bg-white rounded-xl shadow-sm border border-[#EAEDF0] relative overflow-hidden">
        <div class="px-4 py-3">
          <div class="stats-label text-xs font-semibold uppercase tracking-wide text-[#013A4A] flex items-center gap-1 opacity-70">
            <i class="bi bi-currency-dollar"></i> Ventas Totales
          </div>
          <div class="stats-number text-2xl font-bold text-[#4ECB71] mt-1" id="statVentasTotales">
            $<?php echo number_format($totalSales, 0); ?>
          </div>
          <i class="bi bi-cash-stack stats-icon absolute right-4 bottom-2 text-5xl text-[#EAEDF0]"></i>
        </div>
      </div>
    </div>

    <!-- Filtros -->
    <div
      id="orderFilters"
      class="filter-pills bg-white border border-[#EAEDF0] rounded-xl shadow-sm px-4 py-3 mb-6 flex flex-wrap items-center gap-2"
    >
      <strong class="text-sm text-[#013A4A] mr-2">Filtrar por estado:</strong>

      <button
        type="button"
        class="filter-pill active px-3 py-1.5 rounded-full border border-[#013A4A] bg-[#013A4A] text-white text-xs font-medium flex items-center gap-1"
        data-status="all"
      >
        <i class="bi bi-grid-fill text-xs"></i> Todas
      </button>

      <button
        type="button"
        class="filter-pill px-3 py-1.5 rounded-full border border-[#EAEDF0] bg-white text-xs text-[#013A4A] font-medium hover:bg-[#EAEDF0] transition"
        data-status="pendiente"
      >
        ⏳ Pendientes
      </button>

      <button
        type="button"
        class="filter-pill px-3 py-1.5 rounded-full border border-[#EAEDF0] bg-white text-xs text-[#013A4A] font-medium hover:bg-[#EAEDF0] transition"
        data-status="procesando"
      >
        ⚙️ Procesando
      </button>

      <button
        type="button"
        class="filter-pill px-3 py-1.5 rounded-full border border-[#EAEDF0] bg-white text-xs text-[#013A4A] font-medium hover:bg-[#EAEDF0] transition"
        data-status="enviada"
      >
        🚚 Enviadas
      </button>

      <button
        type="button"
        class="filter-pill px-3 py-1.5 rounded-full border border-[#EAEDF0] bg-white text-xs text-[#013A4A] font-medium hover:bg-[#EAEDF0] transition"
        data-status="completada"
      >
        ✅ Completadas
      </button>

      <button
        type="button"
        class="filter-pill px-3 py-1.5 rounded-full border border-[#EAEDF0] bg-white text-xs text-[#013A4A] font-medium hover:bg-[#EAEDF0] transition"
        data-status="cancelada"
      >
        ❌ Canceladas
      </button>
    </div>

    <!-- Grid de órdenes -->
    <?php if (empty($orders)): ?>
      <div class="empty-state bg-white border border-dashed border-[#EAEDF0] rounded-2xl py-16 text-center">
        <div class="empty-icon text-5xl mb-3">📦</div>
        <h4 class="text-lg font-semibold text-[#013A4A] mb-1">No hay órdenes aún</h4>
        <p class="text-sm text-[#013A4A] opacity-70">Las órdenes aparecerán aquí cuando los clientes realicen compras.</p>
      </div>
    <?php else: ?>
      <div
        id="ordersGrid"
        class="orders-grid grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"
      >
        <?php foreach ($orders as $order):
          $id     = (int)($order['id'] ?? 0);
          $estado = $normalizeEstado($order['estado'] ?? 'pendiente');

          $nombre = htmlspecialchars((string)($order['nombre_cliente'] ?? ''), ENT_QUOTES, 'UTF-8');
          $email  = htmlspecialchars((string)($order['email_cliente'] ?? ''), ENT_QUOTES, 'UTF-8');

          $items  = (int)($order['items_count'] ?? 0);
          $creado = (string)($order['creado_en'] ?? '');
          $fecha  = $creado ? date('d/m/Y', strtotime($creado)) : '—';

          $total  = (float)($order['total'] ?? 0);
        ?>
          <div
            class="order-card bg-white border border-[#EAEDF0] rounded-xl shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5 border-l-4 border-l-[#013A4A] relative overflow-hidden"
            data-order-id="<?php echo $id; ?>"
            data-status="<?php echo $estado; ?>"
          >
            <div
              class="order-card bg-white rounded-2xl border border-[#EAEDF0] shadow-md hover:shadow-lg transition-all duration-300 
                     hover:-translate-y-1 relative overflow-hidden p-5 space-y-5"
              data-order-id="<?php echo $id; ?>"
              data-status="<?php echo $estado; ?>"
            >
              <!-- Header -->
              <div class="flex items-center justify-between pb-2 border-b border-[#EAEDF0]">
                <div class="text-sm font-semibold text-[#013A4A]">
                  #<?php echo str_pad((string)$id, 6, '0', STR_PAD_LEFT); ?>
                </div>
                <div
                  class="text-[11px] font-semibold uppercase tracking-wide px-3 py-1 rounded-full 
                         border border-[#EAEDF0] bg-[#EAEDF0] text-[#013A4A]"
                >
                  <?php echo ucfirst($estado); ?>
                </div>
              </div>

              <!-- Cliente -->
              <div class="space-y-1">
                <div class="text-sm font-semibold text-[#013A4A] flex items-center gap-2">
                  <i class="bi bi-person-circle text-[#013A4A] opacity-60"></i> <?php echo $nombre; ?>
                </div>
                <div class="text-xs text-[#013A4A] opacity-70 flex items-center gap-2">
                  <i class="bi bi-envelope text-[#013A4A] opacity-60"></i> <?php echo $email; ?>
                </div>
              </div>

              <!-- Detalles -->
              <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                  <div class="text-[11px] uppercase tracking-wide text-[#013A4A] opacity-60 mb-1">Items</div>
                  <div class="font-semibold text-[#013A4A] flex items-center gap-1">
                    <i class="bi bi-box text-[#013A4A] opacity-60"></i> <?php echo $items; ?> productos
                  </div>
                </div>
                <div>
                  <div class="text-[11px] uppercase tracking-wide text-[#013A4A] opacity-60 mb-1">Fecha</div>
                  <div class="font-semibold text-[#013A4A] flex items-center gap-1">
                    <i class="bi bi-calendar3 text-[#013A4A] opacity-60"></i> <?php echo $fecha; ?>
                  </div>
                </div>
              </div>

              <!-- Total -->
              <div class="bg-[#013A4A] text-white rounded-xl px-4 py-4 text-center shadow-sm">
                <div class="text-[11px] uppercase tracking-wide opacity-80 mb-1">Total de la Orden</div>
                <div class="text-2xl font-bold">$<?php echo number_format($total, 2); ?></div>
              </div>

              <!-- Acciones -->
              <div class="flex gap-3">
                <button
                  type="button"
                  class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-medium px-4 py-2.5 rounded-lg 
                         bg-[#013A4A] text-white hover:bg-[#4ECB71] transition"
                  data-action="view"
                  data-order-id="<?php echo $id; ?>"
                >
                  <i class="bi bi-eye-fill text-[13px]"></i>
                  Ver Detalles
                </button>

                <button
                  type="button"
                  class="flex-1 inline-flex items-center justify-center gap-1.5 text-xs font-medium px-4 py-2.5 rounded-lg 
                         border border-[#EAEDF0] bg-white text-[#013A4A] hover:bg-[#EAEDF0] transition"
                  data-action="status"
                  data-order-id="<?php echo $id; ?>"
                  data-current-status="<?php echo $estado; ?>"
                >
                  <i class="bi bi-arrow-repeat text-[13px]"></i>
                  Cambiar
                </button>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>

<!-- Modal: Detalles (Tailwind, sin Bootstrap) -->
<div
  id="orderDetailsModal"
  class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 px-4"
>
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#EAEDF0]">
      <h5 class="text-sm font-semibold text-[#013A4A] flex items-center gap-2">
        <i class="bi bi-receipt"></i> Detalles de la Orden
      </h5>
      <button
        type="button"
        class="text-[#013A4A] opacity-60 hover:opacity-90 text-xl leading-none"
        data-close-modal="orderDetailsModal"
      >&times;</button>
    </div>
    <div id="orderDetailsContent" class="p-4 overflow-y-auto text-sm text-[#013A4A]">
      <!-- contenido dinámico -->
    </div>
  </div>
</div>

<!-- Modal: Cambiar estado -->
<div
  id="statusModal"
  class="fixed inset-0 z-40 hidden items-center justify-center bg-black/40 px-4"
>
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 border-b border-[#EAEDF0]">
      <h5 class="text-sm font-semibold text-[#013A4A] flex items-center gap-2">
        <i class="bi bi-arrow-repeat"></i> Cambiar Estado
      </h5>
      <button
        type="button"
        class="text-[#013A4A] opacity-60 hover:opacity-90 text-xl leading-none"
        data-close-modal="statusModal"
      >&times;</button>
    </div>

    <div class="p-4 space-y-4 text-sm text-[#013A4A]">
      <input type="hidden" id="statusOrderId">
      <div class="space-y-1">
        <label class="font-semibold text-xs uppercase tracking-wide text-[#013A4A] opacity-70">
          Nuevo Estado
        </label>
        <select
          id="newStatus"
          class="form-select block w-full rounded-lg border border-[#EAEDF0] px-3 py-2 text-sm text-[#013A4A] 
                 focus:outline-none focus:ring-2 focus:ring-[#013A4A] focus:border-[#013A4A]"
        >
          <option value="pendiente">⏳ Pendiente</option>
          <option value="procesando">⚙️ Procesando</option>
          <option value="enviada">🚚 Enviada</option>
          <option value="completada">✅ Completada</option>
          <option value="cancelada">❌ Cancelada</option>
        </select>
      </div>
    </div>

    <div class="px-4 py-3 border-t border-[#EAEDF0] flex justify-end gap-2">
      <button
        type="button"
        class="px-3 py-1.5 text-xs font-medium rounded-lg border border-[#EAEDF0] text-[#013A4A] hover:bg-[#EAEDF0]"
        data-close-modal="statusModal"
      >
        Cancelar
      </button>
      <button
        type="button"
        id="btnSaveStatus"
        class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-[#013A4A] text-white hover:bg-[#012433]"
      >
        Guardar Cambios
      </button>
    </div>
  </div>
</div>

<script src="<?php echo htmlspecialchars(url_for('public/js/orders.js'), ENT_QUOTES, 'UTF-8'); ?>" defer></script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
