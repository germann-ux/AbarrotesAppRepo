    <!-- Sidebar -->
    <div id="sidebar" class="sidebar w-64 h-full shadow-lg fixed lg:relative z-20">
      <div class="flex flex-col h-full">
        <div class="p-4 border-b flex items-center">
          <h1 class="text-xl font-semibold text-gray-800">MiTiendita</h1>
        </div>
        
        <div class="flex flex-col flex-grow p-4 space-y-2">
          <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="index.php?view=dashboard" class="sidebar-link <?php echo (!isset($_GET['view']) || $_GET['view'] == 'dashboard') ? 'active' : ''; ?> flex items-center px-4 py-3 rounded-lg">
              <i class="fas fa-tachometer-alt mr-3 text-gray-600"></i>
              <span>Dashboard</span>
            </a>
            
            <a href="index.php?view=productos" class="sidebar-link <?php echo (isset($_GET['view']) && $_GET['view'] == 'productos') ? 'active' : ''; ?> flex items-center px-4 py-3 rounded-lg">
              <i class="fas fa-box mr-3 text-gray-600"></i>
              <span>Productos</span>
            </a>
            
            <a href="index.php?view=analytics" class="sidebar-link <?php echo (isset($_GET['view']) && $_GET['view'] == 'analytics') ? 'active' : ''; ?> flex items-center px-4 py-3 rounded-lg">
              <i class="fas fa-chart-line mr-3 text-gray-600"></i>
              <span>Analytics</span>
            </a>
            
            <a href="index.php?view=ordenes" class="sidebar-link <?php echo (isset($_GET['view']) && $_GET['view'] == 'ordenes') ? 'active' : ''; ?> flex items-center px-4 py-3 rounded-lg">
              <i class="fas fa-shopping-cart mr-3 text-gray-600"></i>
              <span>Órdenes / Ventas</span>
            </a>
          <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
             <a href="index.php?view=client_dashboard" class="sidebar-link <?php echo (isset($_GET['view']) && $_GET['view'] == 'client_dashboard') ? 'active' : ''; ?> flex items-center px-4 py-3 rounded-lg">
              <i class="fas fa-store mr-3 text-gray-600"></i>
              <span>Catálogo</span>
            </a>
          <?php endif; ?>
        </div>
        
        <div class="p-4 border-t">
          <a href="javascript:void(0)" id="btn-start-over" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
            <i class="fas fa-redo mr-2"></i>
            <span>Start Over</span>
          </a>
        </div>
      </div>
    </div>
