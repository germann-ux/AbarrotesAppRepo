        </div>
      </main>
    </div>
  </div>
  
  <!-- Product Form Modal -->
  <div id="product-modal" class="modal fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full relative z-10">
      <div class="p-6">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
          <h3 class="text-lg font-medium text-gray-900" id="modal-title">Agregar Producto</h3>
          <button id="btn-close-modal" class="text-gray-400 hover:text-gray-500">
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <form id="product-form" class="space-y-4">
          <input type="hidden" id="product-id">
          
          <div>
            <label for="product-name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="product-name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
            <p class="mt-1 text-sm text-red-600 hidden" id="error-name"></p>
          </div>
          
          <div>
            <label for="product-category" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <select id="product-category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" required>
              <option value="">Seleccionar categoría</option>
              <!-- Categories loaded via JS -->
            </select>
            <p class="mt-1 text-sm text-red-600 hidden" id="error-category"></p>
          </div>
          
          <div>
            <label for="product-price" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm">$</span>
              </div>
              <input type="number" id="product-price" class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" step="0.01" min="0" required>
            </div>
            <p class="mt-1 text-sm text-red-600 hidden" id="error-price"></p>
          </div>
          
          <div>
            <label for="product-stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" id="product-stock" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" min="0" required>
            <p class="mt-1 text-sm text-red-600 hidden" id="error-stock"></p>
          </div>
          
          <div>
            <label for="product-description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
            <textarea id="product-description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"></textarea>
          </div>
          
          <div>
            <label for="product-image-url" class="block text-sm font-medium text-gray-700 mb-1">URL de Imagen</label>
            <input type="url" id="product-image-url" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" placeholder="https://ejemplo.com/imagen.jpg">
          </div>
          
          <div class="flex justify-end pt-4 border-t space-x-3">
            <button type="button" id="btn-cancel" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
              Cancelar
            </button>
            <button type="submit" class="btn-primary py-2 px-4 rounded-md shadow-sm text-sm font-medium text-white focus:outline-none">
              Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Delete Confirmation Modal -->
  <div id="delete-modal" class="modal fixed inset-0 z-50 overflow-y-auto hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black bg-opacity-50"></div>
    <div class="modal-content bg-white rounded-lg shadow-xl max-w-md w-full relative z-10">
      <div class="p-6">
        <div class="mb-5 text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-900">¿Eliminar producto?</h3>
          <p class="text-gray-500 mt-2">¿Estás seguro que deseas eliminar este producto? Esta acción no se puede deshacer.</p>
        </div>
        <div class="flex justify-center space-x-3">
          <button id="btn-cancel-delete" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
            Cancelar
          </button>
          <button id="btn-confirm-delete" class="py-2 px-4 bg-red-600 hover:bg-red-700 rounded-md shadow-sm text-sm font-medium text-white focus:outline-none">
            Sí, eliminar
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Loading Spinner -->
  <div id="loading-spinner" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="loader h-12 w-12 border-4 border-gray-200 rounded-full"></div>
  </div>
  
  <script src="public/js/main.js"></script>
</body>
</html>
