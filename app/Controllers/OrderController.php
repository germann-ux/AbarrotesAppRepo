<?php
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../helpers/url.php';

class OrderController {
    
    /**
     * Muestra todas las órdenes para el administrador
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar que sea admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            redirect_to('index.php?action=client');
        }
        
        $database = new Database();
        $db = $database->getConnection();
        
        // Obtener todas las órdenes
        $query = "SELECT o.*, COUNT(oi.id) as items_count 
                  FROM ordenes o 
                  LEFT JOIN orden_items oi ON o.id = oi.orden_id 
                  GROUP BY o.id 
                  ORDER BY o.creado_en DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../Views/orders.php';
    }
    
    /**
     * API para obtener todas las órdenes
     */
    public function apiGetAll() {
        header('Content-Type: application/json');
        
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "SELECT o.*, COUNT(oi.id) as items_count 
                  FROM ordenes o 
                  LEFT JOIN orden_items oi ON o.id = oi.orden_id 
                  GROUP BY o.id 
                  ORDER BY o.creado_en DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($orders);
    }
    
    /**
     * API para obtener detalles de una orden
     */
    public function apiGetById() {
        header('Content-Type: application/json');
        
        $orderId = $_GET['id'] ?? 0;
        
        if ($orderId <= 0) {
            http_response_code(400);
            echo json_encode(["message" => "ID inválido"]);
            return;
        }
        
        $database = new Database();
        $db = $database->getConnection();
        $orderModel = new Order($db);
        
        $order = $orderModel->getById($orderId);
        $items = $orderModel->getOrderItems($orderId);
        
        if ($order) {
            $order['items'] = $items;
            echo json_encode($order);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Orden no encontrada"]);
        }
    }
    
    /**
     * API para actualizar estado de orden
     */
    public function apiUpdateStatus() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Método no permitido"]);
            return;
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        $orderId = $data['id'] ?? 0;
        $status = $data['status'] ?? '';
        
        if ($orderId <= 0 || empty($status)) {
            http_response_code(400);
            echo json_encode(["message" => "Datos inválidos"]);
            return;
        }
        
        $database = new Database();
        $db = $database->getConnection();
        
        $query = "UPDATE ordenes SET estado = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->bindParam(2, $orderId);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Estado actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al actualizar el estado"]);
        }
    }
}
?>
