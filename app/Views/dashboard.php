            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <div class="stat-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-indigo-100 mr-4">
                    <i class="fas fa-box text-indigo-500"></i>
                  </div>
                  <div>
                    <h3 class="text-gray-500 text-sm">Total Productos</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?php echo $totalProducts; ?></p>
                  </div>
                </div>
              </div>
              
              <div class="stat-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-tags text-green-500"></i>
                  </div>
                  <div>
                    <h3 class="text-gray-500 text-sm">Categorías</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?php echo $totalCategories; ?></p>
                  </div>
                </div>
              </div>
              
              <div class="stat-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                  <div class="p-3 rounded-full bg-red-100 mr-4">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                  </div>
                  <div>
                    <h3 class="text-gray-500 text-sm">Productos con bajo stock</h3>
                    <p class="text-2xl font-semibold text-gray-800"><?php echo $lowStock; ?></p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
              <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-700 font-medium mb-4">Stock por Categoría</h3>
                <div class="chart-container">
                  <canvas id="stockByCategory"></canvas>
                </div>
              </div>
              
              <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-700 font-medium mb-4">Distribución de Categorías</h3>
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
