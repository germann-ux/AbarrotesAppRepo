<?php
/**
 * Cart Helper Class
 * Maneja las operaciones del carrito de compras usando sesiones PHP
 */
class Cart {
    
    /**
     * Inicializa el carrito en la sesión si no existe
     * @return void
     */
    private static function initCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    
    /**
     * Añade un producto al carrito o incrementa su cantidad
     * @param int $productId ID del producto
     * @param array $productData Datos del producto (name, price, image_url)
     * @param int $quantity Cantidad a añadir
     * @return bool
     */
    public static function addItem($productId, $productData, $quantity = 1) {
        self::initCart();
        
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $productData['name'],
                'price' => $productData['price'],
                'image_url' => $productData['image_url'] ?? '',
                'quantity' => $quantity
            ];
        }
        return true;
    }
    
    /**
     * Actualiza la cantidad de un producto en el carrito
     * Note: Si la cantidad es 0 o menor, el producto se elimina del carrito.
     * @param int $productId ID del producto
     * @param int $quantity Nueva cantidad
     * @return bool
     */
    public static function updateItem($productId, $quantity) {
        self::initCart();
        
        if ($quantity <= 0) {
            return self::removeItem($productId);
        }
        
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            return true;
        }
        return false;
    }
    
    /**
     * Elimina un producto del carrito
     * @param int $productId ID del producto
     * @return bool
     */
    public static function removeItem($productId) {
        self::initCart();
        
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            return true;
        }
        return false;
    }
    
    /**
     * Obtiene todos los items del carrito
     * @return array
     */
    public static function getItems() {
        self::initCart();
        return $_SESSION['cart'];
    }
    
    /**
     * Obtiene el número total de items en el carrito
     * @return int
     */
    public static function getItemCount() {
        self::initCart();
        $count = 0;
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    /**
     * Calcula el total del carrito
     * @return float
     */
    public static function getTotal() {
        self::initCart();
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
    
    /**
     * Limpia el carrito completamente
     * @return bool
     */
    public static function clear() {
        self::initCart();
        $_SESSION['cart'] = [];
        return true;
    }
    
    /**
     * Verifica si el carrito está vacío
     * @return bool
     */
    public static function isEmpty() {
        self::initCart();
        return empty($_SESSION['cart']);
    }
}
?>
