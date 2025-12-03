<div class="bg-white border border-[#EAEDF0] rounded-xl shadow-sm overflow-hidden">

  <div class="p-6 border-b border-[#EAEDF0]">
    <h3 class="text-lg font-semibold text-[#013A4A]">
      Productos Añadidos Recientemente
    </h3>
  </div>

  <ul class="divide-y divide-[#EAEDF0]">

    <?php if(empty($recentProducts)): ?>
      <li class="p-6 text-center text-[#013A4A] opacity-60">
        No hay actividad reciente.
      </li>

    <?php else: ?>
      <?php foreach($recentProducts as $product): ?>
        <li class="p-4 hover:bg-[#EAEDF072] transition">

          <div class="flex items-center justify-between">

            <!-- Left -->
            <div class="flex items-center">

              <div class="h-10 w-10 rounded-full bg-[#4ECB7130] flex items-center justify-center">
                <i class="fas fa-plus text-[#4ECB71]"></i>
              </div>

              <div class="ml-4">
                <p class="text-sm font-semibold text-[#013A4A]">
                  Producto añadido: <?php echo $product['nombre']; ?>
                </p>
                <p class="text-sm text-[#013A4A] opacity-70">
                  Categoría: <?php echo $product['categoria']; ?>
                </p>
              </div>

            </div>

            <!-- Right -->
            <span class="text-sm text-[#013A4A] opacity-60">
              <?php echo $product['creado_en']; ?>
            </span>

          </div>

        </li>
      <?php endforeach; ?>
    <?php endif; ?>

  </ul>

</div>
