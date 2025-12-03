<!-- Sidebar -->
<div id="sidebar" class="sidebar w-64 h-full lg:h-auto bg-[#FFFFFF] border-r border-[#EAEDF0] shadow-lg fixed lg:relative z-20">
  <div class="flex flex-col h-full">

    <!-- Branding -->
    <div class="p-4 border-b border-[#EAEDF0] flex items-center">
      <h1 class="text-xl font-bold tracking-tight text-[#013A4A]">
        MiTiendita
      </h1>
    </div>
    
    <!-- Links -->
    <div class="flex flex-col flex-grow p-4 space-y-2 text-sm">

      <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        
        <!-- Dashboard -->
        <a 
          href="index.php?view=dashboard" 
          class="sidebar-link flex items-center px-4 py-3 rounded-lg font-medium 
                 text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition
                 <?php echo (!isset($_GET['view']) || $_GET['view'] == 'dashboard') 
                    ? 'bg-[#013A4A] text-white border-l-4 border-[#4ECB71]' 
                    : ''; ?>">
          <i class="fas fa-tachometer-alt mr-3 
                    <?php echo (!isset($_GET['view']) || $_GET['view'] == 'dashboard') 
                      ? 'text-white' 
                      : 'text-[#013A4A]'; ?>">
          </i>
          <span>Dashboard</span>
        </a>
        
        <!-- Productos -->
        <a 
          href="index.php?view=productos" 
          class="sidebar-link flex items-center px-4 py-3 rounded-lg font-medium 
                 text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition
                 <?php echo (isset($_GET['view']) && $_GET['view'] == 'productos') 
                    ? 'bg-[#013A4A] text-white border-l-4 border-[#4ECB71]' 
                    : ''; ?>">
          <i class="fas fa-box mr-3 
                    <?php echo (isset($_GET['view']) && $_GET['view'] == 'productos') 
                      ? 'text-white' 
                      : 'text-[#013A4A]'; ?>">
          </i>
          <span>Productos</span>
        </a>
        
        <!-- Analytics -->
        <a 
          href="index.php?view=analytics" 
          class="sidebar-link flex items-center px-4 py-3 rounded-lg font-medium 
                 text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition
                 <?php echo (isset($_GET['view']) && $_GET['view'] == 'analytics') 
                    ? 'bg-[#013A4A] text-white border-l-4 border-[#4ECB71]' 
                    : ''; ?>">
          <i class="fas fa-chart-line mr-3 
                    <?php echo (isset($_GET['view']) && $_GET['view'] == 'analytics') 
                      ? 'text-white' 
                      : 'text-[#013A4A]'; ?>">
          </i>
          <span>Analytics</span>
        </a>
        
        <!-- Órdenes / Ventas -->
        <a 
          href="index.php?view=ordenes" 
          class="sidebar-link flex items-center px-4 py-3 rounded-lg font-medium 
                 text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition
                 <?php echo (isset($_GET['view']) && $_GET['view'] == 'ordenes') 
                    ? 'bg-[#013A4A] text-white border-l-4 border-[#4ECB71]' 
                    : ''; ?>">
          <i class="fas fa-shopping-cart mr-3 
                    <?php echo (isset($_GET['view']) && $_GET['view'] == 'ordenes') 
                      ? 'text-white' 
                      : 'text-[#013A4A]'; ?>">
          </i>
          <span>Órdenes / Ventas</span>
        </a>

      <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>

        <!-- Catálogo cliente -->
        <a 
          href="index.php?view=client_dashboard" 
          class="sidebar-link flex items-center px-4 py-3 rounded-lg font-medium 
                 text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition
                 <?php echo (isset($_GET['view']) && $_GET['view'] == 'client_dashboard') 
                    ? 'bg-[#013A4A] text-white border-l-4 border-[#4ECB71]' 
                    : ''; ?>">
          <i class="fas fa-store mr-3 
                    <?php echo (isset($_GET['view']) && $_GET['view'] == 'client_dashboard') 
                      ? 'text-white' 
                      : 'text-[#013A4A]'; ?>">
          </i>
          <span>Catálogo</span>
        </a>

      <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <div class="p-4 border-t border-[#EAEDF0] bg-[#FFFFFF]">
      <a 
        href="javascript:void(0)" 
        id="btn-start-over" 
        class="flex items-center px-4 py-2 text-sm rounded-lg 
               text-[#013A4A] hover:bg-[#EAEDF0] hover:text-[#013A4A] transition"
      >
        <i class="fas fa-redo mr-2 text-[#013A4A]"></i>
        <span>Start Over</span>
      </a>
    </div>

  </div>
</div>
