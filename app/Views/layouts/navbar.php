    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <header class="bg-white shadow-sm h-16 flex items-center px-6 justify-between">
        <div class="flex items-center">
          <button id="sidebar-toggle" class="lg:hidden mr-4">
            <i class="fas fa-bars text-gray-600"></i>
          </button>
          <h2 class="text-lg font-medium text-gray-800" id="page-title">
            <?php 
                if(isset($_GET['view'])) {
                    echo ucfirst($_GET['view']);
                } else {
                    echo "Dashboard";
                }
            ?>
          </h2>
        </div>
        
        <div class="flex items-center gap-4">
          <?php if(isset($_SESSION['username'])): ?>
            <span class="text-gray-600 mr-2">Hola, <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['role']); ?>)</span>
            <a href="index.php?action=logout" class="text-red-500 hover:text-red-700 font-medium">Salir</a>
          <?php else: ?>
            <a href="index.php?view=login" class="text-blue-500 hover:text-blue-700 font-medium">Login</a>
          <?php endif; ?>
          <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
            <i class="fas fa-user text-gray-500"></i>
          </div>
        </div>
      </header>
      
      <!-- Main Content Area -->
      <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <!-- Dynamic Content -->
        <div id="content-container">
