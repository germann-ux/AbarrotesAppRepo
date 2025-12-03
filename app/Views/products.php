<div class="flex justify-between items-center mb-6">
  <h3 class="text-xl font-semibold text-[#013A4A]">
    Listado de Productos
  </h3>
  <button
    id="btn-add-product"
    class="px-4 py-2 rounded-lg text-white flex items-center text-sm font-medium
           bg-[#013A4A] hover:bg-[#4ECB71] transition"
  >
    <i class="fas fa-plus mr-2 text-xs"></i> Agregar Producto
  </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-[#EAEDF0] overflow-hidden">
  <div class="table-responsive">
    <table class="min-w-full divide-y divide-[#EAEDF0]">
      <thead class="bg-[#EAEDF0]">
        <tr>
          <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide cursor-pointer">
            <div class="flex items-center">Imagen</div>
          </th>
          <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide cursor-pointer">
            <div class="flex items-center">
              Nombre <i class="fas fa-sort ml-1 text-[10px] opacity-70"></i>
            </div>
          </th>
          <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide cursor-pointer">
            <div class="flex items-center">
              Categoría <i class="fas fa-sort ml-1 text-[10px] opacity-70"></i>
            </div>
          </th>
          <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide cursor-pointer">
            <div class="flex items-center">
              Precio <i class="fas fa-sort ml-1 text-[10px] opacity-70"></i>
            </div>
          </th>
          <th class="px-6 py-3 text-left text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide cursor-pointer">
            <div class="flex items-center">
              Stock <i class="fas fa-sort ml-1 text-[10px] opacity-70"></i>
            </div>
          </th>
          <th class="px-6 py-3 text-right text-[11px] font-semibold text-[#013A4A] uppercase tracking-wide">
            Acciones
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-[#EAEDF0]" id="product-table-body">
        <?php if(empty($products)): ?>
          <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-[#013A4A] opacity-60">
              No hay productos registrados.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach($products as $product): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php if($product['imagen_url']): ?>
                  <img src="<?php echo $product['imagen_url']; ?>" class="product-image rounded-md">
                <?php else: ?>
                  <div class="w-12 h-12 bg-[#EAEDF0] rounded-md flex items-center justify-center">
                    <i class="fas fa-image text-[#013A4A] opacity-40"></i>
                  </div>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-[#013A4A]">
                  <?php echo $product['nombre']; ?>
                </div>
                <div class="text-xs text-[#013A4A] opacity-70 truncate w-48">
                  <?php echo $product['descripcion']; ?>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                             bg-[#4ECB71] bg-opacity-15 text-[#013A4A] border border-[#4ECB71] border-opacity-50">
                  <?php echo $product['categoria_nombre']; ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#013A4A] opacity-80">
                $<?php echo $product['precio']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-[#013A4A] opacity-80">
                <?php echo $product['stock']; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button
                  class="mr-3 btn-edit text-[#013A4A] hover:text-[#4ECB71] transition"
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
                <button
                  class="btn-delete text-[#D64545] hover:text-[#013A4A] transition"
                  data-id="<?php echo $product['id']; ?>"
                >
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
      <div class="product-card bg-white p-4 rounded-xl shadow-sm border border-[#EAEDF0]">
        <div class="flex items-center mb-3">
          <?php if($product['imagen_url']): ?>
            <img src="<?php echo $product['imagen_url']; ?>" class="w-12 h-12 rounded-md mr-3">
          <?php else: ?>
            <div class="w-12 h-12 bg-[#EAEDF0] rounded-md flex items-center justify-center mr-3">
              <i class="fas fa-image text-[#013A4A] opacity-40"></i>
            </div>
          <?php endif; ?>
          <div>
            <h4 class="font-semibold text-sm text-[#013A4A]">
              <?php echo $product['nombre']; ?>
            </h4>
          </div>
        </div>

        <div class="flex justify-between mb-2">
          <span class="text-sm text-[#013A4A] opacity-70">Categoría:</span>
          <span class="px-2 text-xs font-semibold rounded-full bg-[#4ECB71] bg-opacity-15 text-[#013A4A] border border-[#4ECB71] border-opacity-50">
            <?php echo $product['categoria_nombre']; ?>
          </span>
        </div>

        <div class="flex justify-between mb-2">
          <span class="text-sm text-[#013A4A] opacity-70">Precio:</span>
          <span class="text-sm font-semibold text-[#013A4A]">
            $<?php echo $product['precio']; ?>
          </span>
        </div>

        <div class="flex justify-between mb-3">
          <span class="text-sm text-[#013A4A] opacity-70">Stock:</span>
          <span class="text-sm font-semibold text-[#013A4A]">
            <?php echo $product['stock']; ?>
          </span>
        </div>

        <div class="flex justify-end space-x-2">
          <button
            class="p-2 text-[#013A4A] hover:text-[#4ECB71] btn-edit transition"
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
          <button
            class="p-2 text-[#D64545] hover:text-[#013A4A] btn-delete transition"
            data-id="<?php echo $product['id']; ?>"
          >
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
