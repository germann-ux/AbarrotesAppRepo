document.addEventListener('DOMContentLoaded', function () {
  const stockCanvas = document.getElementById('stockByCategory');
  let stockChart = null;

  if (stockCanvas) {
    const stockLabels = window.dashboardData ? window.dashboardData.stockLabels : ['Sin datos'];
    const stockData = window.dashboardData ? window.dashboardData.stockData : [0];

    const stockCtx = stockCanvas.getContext('2d');
    stockChart = new Chart(stockCtx, {
      type: 'bar',
      data: {
        labels: stockLabels,
        datasets: [{
          label: 'Stock por Categoría',
          data: stockData,
          backgroundColor: 'rgba(59, 130, 246, 0.5)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }

  const categoryCanvas = document.getElementById('categoryDistribution');
  let categoryChart = null;

  if (categoryCanvas) {
    const countLabels = window.dashboardData ? window.dashboardData.countLabels : ['Sin datos'];
    const countData = window.dashboardData ? window.dashboardData.countData : [0];

    const categoryCtx = categoryCanvas.getContext('2d');
    categoryChart = new Chart(categoryCtx, {
      type: 'pie',
      data: {
        labels: countLabels,
        datasets: [{
          label: 'Distribución por Categoría',
          data: countData,
          backgroundColor: [
            'rgba(34, 197, 94, 0.7)',
            'rgba(239, 68, 68, 0.7)',
            'rgba(59, 130, 246, 0.7)',
            'rgba(249, 115, 22, 0.7)',
            'rgba(168, 85, 247, 0.7)',
            'rgba(20, 184, 166, 0.7)',
            'rgba(245, 158, 11, 0.7)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    });
  }

  const sidebarToggle = document.getElementById('sidebar-toggle');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      document.getElementById('sidebar').classList.toggle('active');
    });
  }

  const productModal = document.getElementById('product-modal');
  const btnAddProduct = document.getElementById('btn-add-product');
  const btnCloseModal = document.getElementById('btn-close-modal');
  const btnCancel = document.getElementById('btn-cancel');
  const modalTitle = document.getElementById('modal-title');
  const productForm = document.getElementById('product-form');

  function fetchCategories() {
    const categorySelect = document.getElementById('product-category');
    if (!categorySelect) return;

    fetch('index.php?action=api_get_categories')
      .then(response => response.json())
      .then(data => {
        let options = '<option value="">Seleccionar categoría</option>';
        data.forEach(cat => {
          options += `<option value="${cat.id}">${cat.nombre}</option>`;
        });
        categorySelect.innerHTML = options;
      })
      .catch(error => console.error('Error loading categories:', error));
  }

  fetchCategories();

  function showModal(mode = 'add', productData = null) {
    if (mode === 'add') {
      if (modalTitle) modalTitle.textContent = 'Agregar Producto';
      if (productForm) productForm.reset();
      if (document.getElementById('product-id')) document.getElementById('product-id').value = '';
    } else {
      if (modalTitle) modalTitle.textContent = 'Editar Producto';
      if (productData) {
        document.getElementById('product-id').value = productData.id;
        document.getElementById('product-name').value = productData.nombre;
        document.getElementById('product-category').value = productData.categoria_id;
        document.getElementById('product-price').value = productData.precio;
        document.getElementById('product-stock').value = productData.stock;
        document.getElementById('product-description').value = productData.descripcion;
        document.getElementById('product-image-url').value = productData.imagen_url;
      }
    }

    if (productModal) productModal.classList.remove('hidden');
  }

  function hideModal() {
    if (productModal) productModal.classList.add('hidden');
    document.querySelectorAll('.text-red-600').forEach(el => {
      el.classList.add('hidden');
      el.textContent = '';
    });
  }

  if (btnAddProduct) btnAddProduct.addEventListener('click', () => showModal('add'));
  if (btnCloseModal) btnCloseModal.addEventListener('click', hideModal);
  if (btnCancel) btnCancel.addEventListener('click', hideModal);

  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-edit')) {
      const btn = e.target.closest('.btn-edit');
      const productData = {
        id: btn.getAttribute('data-id'),
        nombre: btn.getAttribute('data-nombre'),
        descripcion: btn.getAttribute('data-descripcion'),
        precio: btn.getAttribute('data-precio'),
        stock: btn.getAttribute('data-stock'),
        imagen_url: btn.getAttribute('data-imagen'),
        categoria_id: btn.getAttribute('data-categoria')
      };
      showModal('edit', productData);
    }
  });

  const deleteModal = document.getElementById('delete-modal');
  const btnCancelDelete = document.getElementById('btn-cancel-delete');
  const btnConfirmDelete = document.getElementById('btn-confirm-delete');
  let currentProductId = null;

  function showDeleteModal(productId) {
    currentProductId = productId;
    if (deleteModal) deleteModal.classList.remove('hidden');
  }

  function hideDeleteModal() {
    if (deleteModal) deleteModal.classList.add('hidden');
    currentProductId = null;
  }

  document.addEventListener('click', function (e) {
    if (e.target.closest('.btn-delete')) {
      const btn = e.target.closest('.btn-delete');
      const productId = btn.getAttribute('data-id');
      showDeleteModal(productId);
    }
  });

  if (btnCancelDelete) btnCancelDelete.addEventListener('click', hideDeleteModal);

  if (btnConfirmDelete) btnConfirmDelete.addEventListener('click', function () {
    const spinner = document.getElementById('loading-spinner');
    if (spinner) spinner.classList.remove('hidden');

    fetch('index.php?action=api_delete_product', {
      method: 'POST',
      body: JSON.stringify({ id: currentProductId })
    })
      .then(response => response.json())
      .then(data => {
        if (spinner) spinner.classList.add('hidden');
        hideDeleteModal();
        alert('Producto eliminado exitosamente');
        location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
        if (spinner) spinner.classList.add('hidden');
        hideDeleteModal();
      });
  });

  /**
   * parametros: nombre, categoria_id, precio, stock, descripcion, imagen_url
   */
  if (productForm) productForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    const name = document.getElementById('product-name').value;
    const category = document.getElementById('product-category').value;
    const price = document.getElementById('product-price').value;
    const stock = document.getElementById('product-stock').value;

    if (isValid) {
      const spinner = document.getElementById('loading-spinner');
      if (spinner) spinner.classList.remove('hidden');

      const productId = document.getElementById('product-id').value;
      const url = productId ? 'index.php?action=api_update_product' : 'index.php?action=api_create_product';

      const data = {
        id: productId,
        nombre: name,
        categoria_id: category,
        precio: price,
        stock: stock,
        descripcion: document.getElementById('product-description').value,
        imagen_url: document.getElementById('product-image-url').value
      };

      fetch(url, {
        method: 'POST',
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(data => {
          if (spinner) spinner.classList.add('hidden');
          hideModal();
          alert('Operación exitosa');
          location.reload();
        })
        .catch(error => {
          console.error('Error:', error);
          if (spinner) spinner.classList.add('hidden');
        });
    }
  });

  const btnStartOver = document.getElementById('btn-start-over');
  if (btnStartOver) btnStartOver.addEventListener('click', function () {
    if (confirm('¿Estás seguro que deseas reiniciar la aplicación?')) {
      alert('Aplicación reiniciada exitosamente.');
      window.location.reload();
    }
  });
  //una madre responsiva que me dio chat xD
  window.addEventListener('resize', function () {
    if (stockChart) stockChart.resize();
    if (categoryChart) categoryChart.resize();
  });
});
