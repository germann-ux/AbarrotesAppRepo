<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">

  <!-- Header -->
  <header class="bg-white border-b border-[#EAEDF0] h-16 flex items-center px-6 justify-between shadow-sm">
    <div class="flex items-center">
      <button id="sidebar-toggle" class="lg:hidden mr-4">
        <i class="fas fa-bars text-[#013A4A]"></i>
      </button>

      <h2 class="text-lg font-semibold text-[#013A4A]" id="page-title">
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
        <span class="text-[#013A4A] text-sm mr-2">
          Hola, <?php echo htmlspecialchars($_SESSION['username']); ?> 
          (<?php echo htmlspecialchars($_SESSION['role']); ?>)
        </span>
        <a 
          href="index.php?action=logout" 
          class="text-[#D64545] hover:text-[#013A4A] font-medium transition"
        >
          Salir
        </a>

      <?php else: ?>

        <a 
          href="index.php?view=login" 
          class="text-[#013A4A] hover:text-[#4ECB71] font-medium transition"
        >
          Login
        </a>

      <?php endif; ?>

      <div class="w-10 h-10 rounded-full bg-[#EAEDF0] flex items-center justify-center">
        <i class="fas fa-user text-[#013A4A]"></i>
      </div>

    </div>
  </header>

  <!-- Main Content Area -->
  <main class="flex-1 overflow-y-auto p-6 bg-[#FFFFFF]">
    <!-- Dynamic Content -->
    <div id="content-container">
