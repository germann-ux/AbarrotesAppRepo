<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
  
  <!-- Total Productos -->
  <div class="stat-card bg-white border border-[#EAEDF0] rounded-xl shadow-sm p-6">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-[#EAEDF0] mr-4">
        <i class="fas fa-box text-[#013A4A]"></i>
      </div>
      <div>
        <h3 class="text-xs font-medium tracking-wide text-[#013A4A] opacity-70">
          Total Productos
        </h3>
        <p class="text-2xl font-bold text-[#4ECB71]">
          <?php echo $totalProducts; ?>
        </p>
      </div>
    </div>
  </div>
  
  <!-- Categorías -->
  <div class="stat-card bg-white border border-[#EAEDF0] rounded-xl shadow-sm p-6">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-[#EAEDF0] mr-4">
        <i class="fas fa-tags text-[#F2B544]"></i>
      </div>
      <div>
        <h3 class="text-xs font-medium tracking-wide text-[#013A4A] opacity-70">
          Categorías
        </h3>
        <p class="text-2xl font-bold text-[#4ECB71]">
          <?php echo $totalCategories; ?>
        </p>
      </div>
    </div>
  </div>
  
  <!-- Productos con bajo stock -->
  <div class="stat-card bg-white border border-[#EAEDF0] rounded-xl shadow-sm p-6">
    <div class="flex items-center">
      <div class="p-3 rounded-full bg-[#EAEDF0] mr-4">
        <i class="fas fa-exclamation-triangle text-[#F2B544]"></i>
      </div>
      <div>
        <h3 class="text-xs font-medium tracking-wide text-[#013A4A] opacity-70">
          Productos con bajo stock
        </h3>
        <p class="text-2xl font-bold text-[#013A4A]">
          <?php echo $lowStock; ?>
        </p>
      </div>
    </div>
  </div>

</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  
  <div class="bg-white border border-[#EAEDF0] rounded-xl shadow-sm p-6">
    <h3 class="text-base font-semibold text-[#013A4A] mb-4">
      Stock por Categoría
    </h3>
    <div class="chart-container">
      <canvas id="stockByCategory"></canvas>
    </div>
  </div>
  
  <div class="bg-white border border-[#EAEDF0] rounded-xl shadow-sm p-6">
    <h3 class="text-base font-semibold text-[#013A4A] mb-4">
      Distribución de Categorías
    </h3>
    <div class="chart-container">
      <canvas id="categoryDistribution"></canvas>
    </div>
  </div>

</div>

<script>
  window.dashboardData = {
      stockLabels: <?php echo json_encode($stockLabels); ?>,
      stockData: <?php echo json_encode($stockData); ?>,
      countLabels: <?php echo json_encode($countLabels); ?>,
      countData: <?php echo json_encode($countData); ?>
  };
</script>
