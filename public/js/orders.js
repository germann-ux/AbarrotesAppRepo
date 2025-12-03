(() => {
    const dashboard = document.getElementById("ordersDashboard");
    if (!dashboard) return;

    const baseIndexUrl = dashboard.dataset.baseUrl;
    const ordersGrid = document.getElementById("ordersGrid");
    const filtersContainer = document.getElementById("orderFilters");

    const statTotalOrders = document.getElementById("statTotalOrders");
    const statPendientes = document.getElementById("statPendientes");
    const statCompletadas = document.getElementById("statCompletadas");

    const statusModalEl = document.getElementById("statusModal");
    const detailsModalEl = document.getElementById("orderDetailsModal");
    const btnSaveStatus = document.getElementById("btnSaveStatus");

    const allowedStatuses = ["pendiente", "procesando", "enviada", "completada", "cancelada"];
    let currentFilter = "all";

    // Helpers
    function escapeHtml(value) {
        const s = String(value ?? "");
        return s
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function spinnerHtml() {
        return `
      <div class="flex justify-center py-6">
        <div class="w-6 h-6 border-2 border-slate-900 border-t-transparent rounded-full animate-spin"></div>
      </div>
    `;
    }

    function ucfirst(s) {
        s = String(s ?? "");
        return s ? s[0].toUpperCase() + s.slice(1) : s;
    }

    function getAllCards() {
        return Array.from(document.querySelectorAll(".order-card"));
    }

    function applyFilter() {
        const cards = getAllCards();
        cards.forEach((card) => {
            const st = card.dataset.status;
            const show = currentFilter === "all" || st === currentFilter;
            card.style.display = show ? "" : "none";
        });
    }

    function setActivePill(status) {
        document.querySelectorAll(".filter-pill").forEach((p) => p.classList.remove("active", "bg-slate-900", "text-white"));
        const pill = filtersContainer?.querySelector(`.filter-pill[data-status="${CSS.escape(status)}"]`);
        if (pill) {
            pill.classList.add("active", "bg-slate-900", "text-white");
        }
    }

    function updateStatsFromDom() {
        const cards = getAllCards();
        const counts = Object.fromEntries(allowedStatuses.map((s) => [s, 0]));

        cards.forEach((c) => {
            const st = c.dataset.status;
            if (counts[st] !== undefined) counts[st]++;
        });

        if (statTotalOrders) statTotalOrders.textContent = String(cards.length);
        if (statPendientes) statPendientes.textContent = String(counts.pendiente ?? 0);
        if (statCompletadas) statCompletadas.textContent = String(counts.completada ?? 0);
    }

    // --- Sistema de modales (Tailwind: show/hidden) ---
    function openModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.remove("hidden");
        el.classList.add("flex");
        document.body.classList.add("overflow-hidden");
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.add("hidden");
        el.classList.remove("flex");
        document.body.classList.remove("overflow-hidden");
    }

    // Cerrar al hacer click en botones con data-close-modal
    document.addEventListener("click", (e) => {
        const closeBtn = e.target.closest("[data-close-modal]");
        if (closeBtn) {
            const id = closeBtn.getAttribute("data-close-modal");
            if (id) closeModal(id);
        }
    });

    // Cerrar al hacer click en el fondo oscuro
    [statusModalEl, detailsModalEl].forEach((modal) => {
        if (!modal) return;
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    // Filtros
    if (filtersContainer) {
        filtersContainer.addEventListener("click", (e) => {
            const pill = e.target.closest(".filter-pill");
            if (!pill) return;

            const status = pill.dataset.status || "all";
            currentFilter = status;

            setActivePill(status);
            applyFilter();
        });
    }

    // Acciones de la grid
    if (ordersGrid) {
        ordersGrid.addEventListener("click", (e) => {
            const btn = e.target.closest("button[data-action]");
            if (!btn) return;

            const action = btn.dataset.action;
            const orderId = btn.dataset.orderId;
            if (!orderId) return;

            if (action === "view") {
                viewOrderDetails(orderId);
            } else if (action === "status") {
                const currentStatus = btn.dataset.currentStatus || "pendiente";
                openStatusModal(orderId, currentStatus);
            }
        });
    }

    // Guardar estado
    if (btnSaveStatus) {
        btnSaveStatus.addEventListener("click", () => updateOrderStatus());
    }

    // API helpers
    async function apiGetOrder(orderId) {
        const url = `${baseIndexUrl}?action=api_get_order&id=${encodeURIComponent(orderId)}`;
        const res = await fetch(url, { headers: { Accept: "application/json" } });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return await res.json();
    }

    async function apiUpdateOrderStatus(orderId, newStatus) {
        const url = `${baseIndexUrl}?action=api_update_order_status`;
        const res = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json", Accept: "application/json" },
            body: JSON.stringify({ id: Number(orderId), status: newStatus }),
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return await res.json();
    }

    // Lógica de modales
    function openStatusModal(orderId, currentStatus) {
        document.getElementById("statusOrderId").value = String(orderId);

        const statusSelect = document.getElementById("newStatus");
        statusSelect.value = allowedStatuses.includes(currentStatus) ? currentStatus : "pendiente";

        openModal("statusModal");
    }

    async function updateOrderStatus() {
        const orderId = document.getElementById("statusOrderId").value;
        const newStatus = document.getElementById("newStatus").value;

        if (!allowedStatuses.includes(newStatus)) {
            alert("❌ Estado inválido");
            return;
        }

        try {
            const data = await apiUpdateOrderStatus(orderId, newStatus);

            patchCardStatus(orderId, newStatus);
            updateStatsFromDom();
            applyFilter();

            closeModal("statusModal");
            alert("✅ " + (data.message || "Estado actualizado"));
        } catch (err) {
            console.error(err);
            alert("❌ Error al actualizar");
        }
    }

    function patchCardStatus(orderId, newStatus) {
        const card = document.querySelector(`.order-card[data-order-id="${CSS.escape(String(orderId))}"]`);
        if (!card) return;

        card.dataset.status = newStatus;

        allowedStatuses.forEach((s) => card.classList.remove(`status-${s}`));
        card.classList.add(`status-${newStatus}`);

        const badge = card.querySelector(".order-status");
        if (badge) {
            allowedStatuses.forEach((s) => badge.classList.remove(`status-${s}`));
            badge.classList.add(`status-${newStatus}`);
            badge.textContent = ucfirst(newStatus);
        }

        const btn = card.querySelector(`button[data-action="status"]`);
        if (btn) btn.dataset.currentStatus = newStatus;
    }

    async function viewOrderDetails(orderId) {
        const content = document.getElementById("orderDetailsContent");
        content.innerHTML = spinnerHtml();
        openModal("orderDetailsModal");

        try {
            const order = await apiGetOrder(orderId);
            const items = Array.isArray(order.items) ? order.items : [];

            const itemsHtml = items
                .map((item) => {
                    const nombre = escapeHtml(item.nombre_producto);
                    const cantidad = Number(item.cantidad);
                    const precio = Number(item.precio_unitario);
                    const subtotal = Number(item.subtotal);

                    const precioTxt = Number.isFinite(precio) ? precio.toFixed(2) : "0.00";
                    const subtotalTxt = Number.isFinite(subtotal) ? subtotal.toFixed(2) : "0.00";

                    return `
            <tr class="border-t border-slate-100">
              <td class="px-3 py-2">${nombre}</td>
              <td class="px-3 py-2 text-center">${Number.isFinite(cantidad) ? cantidad : 0}</td>
              <td class="px-3 py-2 text-right">$${precioTxt}</td>
              <td class="px-3 py-2 text-right font-semibold">$${subtotalTxt}</td>
            </tr>
          `;
                })
                .join("");

            const total = Number(order.total);
            const totalTxt = Number.isFinite(total) ? total.toFixed(2) : "0.00";

            const creadoEn = escapeHtml(order.creado_en ?? "");
            const tel = escapeHtml(order.telefono_cliente ?? "—");
            const dir = escapeHtml(order.direccion_envio ?? "—");

            content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm">
          <div class="space-y-1">
            <h6 class="font-semibold text-slate-800 flex items-center gap-2">
              <i class="bi bi-person-circle text-slate-500"></i> Cliente
            </h6>
            <p><strong>Nombre:</strong> ${escapeHtml(order.nombre_cliente)}</p>
            <p><strong>Email:</strong> ${escapeHtml(order.email_cliente)}</p>
            <p><strong>Teléfono:</strong> ${tel}</p>
          </div>
          <div class="space-y-1">
            <h6 class="font-semibold text-slate-800 flex items-center gap-2">
              <i class="bi bi-geo-alt-fill text-slate-500"></i> Envío
            </h6>
            <p>${dir}</p>
            <p><strong>Fecha:</strong> ${creadoEn}</p>
          </div>
        </div>

        <hr class="my-3">

        <h6 class="font-semibold text-slate-800 mb-2 flex items-center gap-2">
          <i class="bi bi-box-seam text-slate-500"></i> Productos
        </h6>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="border-b border-slate-200 bg-slate-50 text-slate-600">
                <th class="px-3 py-2 text-left font-medium">Producto</th>
                <th class="px-3 py-2 text-center font-medium">Cant.</th>
                <th class="px-3 py-2 text-right font-medium">Precio</th>
                <th class="px-3 py-2 text-right font-medium">Subtotal</th>
              </tr>
            </thead>
            <tbody>${itemsHtml}</tbody>
            <tfoot>
              <tr class="border-t border-slate-200 bg-slate-50">
                <td colspan="3" class="px-3 py-2 text-right font-semibold">Total:</td>
                <td class="px-3 py-2 text-right font-bold text-emerald-600">$${totalTxt}</td>
              </tr>
            </tfoot>
          </table>
        </div>
      `;
        } catch (err) {
            console.error(err);
            content.innerHTML = `<div class="py-4 text-sm text-red-600">Error al cargar los detalles de la orden.</div>`;
        }
    }

    // init
    setActivePill("all");
    updateStatsFromDom();
    applyFilter();
})();
