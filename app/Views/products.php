            <div class="flex justify-between items-center mb-6">
              <h3 class="text-xl font-medium text-gray-800">Listado de Productos</h3>
              <button id="btn-add-product" class="btn-primary px-4 py-2 rounded-lg text-white flex items-center">
                <i class="fas fa-plus mr-2"></i> Agregar Producto
              </button>
            </div>
            
            <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="table-responsive">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        <div class="flex items-center">Imagen</div>
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        <div class="flex items-center">Nombre <i class="fas fa-sort ml-1"></i></div>
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        <div class="flex items-center">Categoría <i class="fas fa-sort ml-1"></i></div>
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        <div class="flex items-center">Precio <i class="fas fa-sort ml-1"></i></div>
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                        <div class="flex items-center">Stock <i class="fas fa-sort ml-1"></i></div>
                      </th>
                      <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Acciones
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200" id="product-table-body">
                    <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay productos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $product): ?>
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($product['imagen_url']): ?>
                                <img src="<?php echo $product['imagen_url']; ?>" class="product-image rounded-md">
                            <?php else: ?>
                                <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center"><i class="fas fa-image text-gray-400"></i></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo $product['nombre']; ?></div>
                            <div class="text-xs text-gray-500 truncate w-48"><?php echo $product['descripcion']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <?php echo $product['categoria_nombre']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            $<?php echo $product['precio']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo $product['stock']; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-indigo-600 hover:text-indigo-900 mr-3 btn-edit" 
                                data-id="<?php echo $product['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($product['nombre']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($product['descripcion']); ?>"
                                data-precio="<?php echo $product['precio']; ?>"
                                data-stock="<?php echo $product['stock']; ?>"
                                data-imagen="<?php echo htmlspecialchars($product['imagen_url']); ?>"
                                data-categoria="<?php echo $product['categoria_id']; ?>"
                            >
                            <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900 btn-delete" data-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- Mobile Product Cards (shown only on small screens) -->
            <div class="md:hidden space-y-4 mt-4" id="product-cards">
                <?php if(!empty($products)): ?>
                    <?php foreach($products as $product): ?>
                    <div class="product-card bg-white p-4 rounded-lg shadow">
                        <div class="flex items-center mb-3">
                        <?php if($product['imagen_url']): ?>
                            <img src="<?php echo $product['imagen_url']; ?>" class="w-12 h-12 rounded-md mr-3">
                        <?php else: ?>
                            <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center mr-3"><i class="fas fa-image text-gray-400"></i></div>
                        <?php endif; ?>
                        <div>
                            <h4 class="font-medium text-gray-900"><?php echo $product['nombre']; ?></h4>
                        </div>
                        </div>
                        <div class="flex justify-between mb-2">
                        <span class="text-sm text-gray-500">Categoría:</span>
                        <span class="px-2 text-xs font-semibold rounded-full bg-green-100 text-green-800"><?php echo $product['categoria_nombre']; ?></span>
                        </div>
                        <div class="flex justify-between mb-2">
                        <span class="text-sm text-gray-500">Precio:</span>
                        <span class="text-sm font-medium">$<?php echo $product['precio']; ?></span>
                        </div>
                        <div class="flex justify-between mb-3">
                        <span class="text-sm text-gray-500">Stock:</span>
                        <span class="text-sm font-medium"><?php echo $product['stock']; ?></span>
                        </div>
                        <div class="flex justify-end space-x-2">
                        <button class="p-2 text-indigo-600 hover:text-indigo-900 btn-edit" 
                                data-id="<?php echo $product['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($product['nombre']); ?>"
                                data-descripcion="<?php echo htmlspecialchars($product['descripcion']); ?>"
                                data-precio="<?php echo $product['precio']; ?>"
                                data-stock="<?php echo $product['stock']; ?>"
                                data-imagen="<?php echo htmlspecialchars($product['imagen_url']); ?>"
                                data-categoria="<?php echo $product['categoria_id']; ?>"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="p-2 text-red-600 hover:text-red-900 btn-delete" data-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
