<?php
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../helpers/url.php';

class ClientController {
    
    /**
     * Muestra el catálogo de productos
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Obtener productos (búsqueda opcional)
        $searchQuery = trim($_GET['q'] ?? '');
        $productModel = new Product($db);
        $stmt = $searchQuery !== ''
            ? $productModel->search($searchQuery)
            : $productModel->getAll();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener categorías para filtros
        $categoryModel = new Category($db);
        $stmtCat = $categoryModel->getAll();
        $categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
        
        // Obtener contador del carrito
        $cartCount = Cart::getItemCount();
        
        require_once __DIR__ . '/../Views/client/index.php';
    }
    
    /**
     * Añade un producto al carrito
     */
    public function addToCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($productId > 0) {
                $database = new Database();
                $db = $database->getConnection();
                
                // Obtener datos del producto
                $query = "SELECT id, nombre AS name, precio AS price, imagen_url AS image_url, stock 
                          FROM productos WHERE id = ? LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(1, $productId);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($product && $product['stock'] >= $quantity) {
                    Cart::addItem($productId, $product, $quantity);
                    $_SESSION['success_message'] = '✅ Producto añadido al carrito';
                } else {
                    $_SESSION['error_message'] = '❌ Stock insuficiente';
                }
            }
        }

        // Redirigir de vuelta al catálogo
        redirect_to('index.php?action=client');
    }
    
    /**
     * Muestra el carrito de compras
     */
    public function viewCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $cartItems = Cart::getItems();
        $cartTotal = Cart::getTotal();
        $cartCount = Cart::getItemCount();
        
        require_once __DIR__ . '/../Views/client/cart.php';
    }
    
    /**
     * Actualiza la cantidad de un producto en el carrito
     */
    public function updateCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            
            if ($productId > 0) {
                Cart::updateItem($productId, $quantity);
                $_SESSION['success_message'] = 'Carrito actualizado';
            }
        }
        
        redirect_to('index.php?action=cart');
    }
    
    /**
     * Elimina un producto del carrito
     */
    public function removeFromCart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $productId = $_GET['id'] ?? 0;
        
        if ($productId > 0) {
            Cart::removeItem($productId);
            $_SESSION['success_message'] = 'Producto eliminado del carrito';
        }
        
        redirect_to('index.php?action=cart');
    }
    
    /**
     * Muestra la página de checkout
     */
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (Cart::isEmpty()) {
            redirect_to('index.php?action=cart');
        }
        
        $cartItems = Cart::getItems();
        $cartTotal = Cart::getTotal();
        $cartCount = Cart::getItemCount();
        
        require_once __DIR__ . '/../Views/client/checkout.php';
    }
    
    /**
     * Procesa la orden de compra
     */
    public function processOrder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !Cart::isEmpty()) {
            $database = new Database();
            $db = $database->getConnection();
            
            try {
                // Iniciar transacción
                $db->beginTransaction();
                
                // Crear orden
                $orderModel = new Order($db);
                $orderModel->usuario_id = $_SESSION['user_id'] ?? null;
                $orderModel->total = Cart::getTotal();
                $orderModel->estado = 'pendiente';
                $orderModel->nombre_cliente = $_POST['nombre'] ?? '';
                $orderModel->email_cliente = $_POST['email'] ?? '';
                $orderModel->telefono_cliente = $_POST['telefono'] ?? '';
                $orderModel->direccion_envio = $_POST['direccion'] ?? '';
                
                $orderId = $orderModel->create();
                
                if ($orderId) {
                    // Crear items de la orden
                    $cartItems = Cart::getItems();
                    $orderModel->createOrderItems($orderId, $cartItems);
                    
                    // Actualizar stock
                    $orderModel->updateProductStock($cartItems);
                    
                    // Commit transacción
                    $db->commit();
                    
                    // Limpiar carrito
                    Cart::clear();
                    
                    // Redirigir a confirmación
                    redirect_to('index.php?action=order_confirmation&id=' . $orderId);
                } else {
                    throw new Exception('Error al crear la orden');
                }
            } catch (Exception $e) {
                $db->rollBack();
                $_SESSION['error_message'] = 'Error al procesar la orden: ' . $e->getMessage();
                redirect_to('index.php?action=checkout');
            }
        } else {
            redirect_to('index.php?action=cart');
        }
    }
    
    /**
     * Muestra la confirmación de orden
     */
    public function orderConfirmation() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $orderId = $_GET['id'] ?? 0;
        
        if ($orderId > 0) {
            $database = new Database();
            $db = $database->getConnection();
            $orderModel = new Order($db);
            
            $order = $orderModel->getById($orderId);
            $orderItems = $orderModel->getOrderItems($orderId);
            
            require_once __DIR__ . '/../Views/client/order_confirmation.php';
        } else {
            redirect_to('index.php?action=client');
        }
    }
}
?>
