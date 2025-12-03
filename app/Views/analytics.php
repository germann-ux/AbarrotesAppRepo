            <div class="bg-white rounded-lg shadow p-6 mb-6">
              <h3 class="text-lg font-medium text-gray-800 mb-4">Estadísticas de Uso</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-4 bg-gray-50 rounded-lg">
                  <h4 class="text-sm text-gray-500 mb-1">Total Productos</h4>
                  <p class="text-2xl font-semibold"><?php echo $totalProducts; ?></p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                  <h4 class="text-sm text-gray-500 mb-1">Productos Recientes</h4>
                  <p class="text-2xl font-semibold"><?php echo count($recentProducts); ?></p>
                </div>
              </div>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="p-6 border-b">
                <h3 class="text-lg font-medium text-gray-800">Productos Añadidos Recientemente</h3>
              </div>
              <ul class="divide-y divide-gray-200">
                <?php if(empty($recentProducts)): ?>
                    <li class="p-4 text-gray-500 text-center">No hay actividad reciente.</li>
                <?php else: ?>
                    <?php foreach($recentProducts as $product): ?>
                    <li class="p-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-plus text-green-500"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Producto añadido: <?php echo $product['nombre']; ?></p>
                            <p class="text-sm text-gray-500">Categoría: <?php echo $product['categoria']; ?></p>
                        </div>
                        </div>
                        <span class="text-sm text-gray-500"><?php echo $product['creado_en']; ?></span>
                    </div>
                    </li>
                    <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
