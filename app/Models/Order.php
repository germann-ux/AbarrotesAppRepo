<?php
/**
 * Order Model
 * Maneja las operaciones de órdenes/ventas en la base de datos
 */
class Order {
    private $conn;
    private $table_name = "ordenes";
    private $items_table = "orden_items";
    
    public $id;
    public $usuario_id;
    public $total;
    public $estado;
    public $nombre_cliente;
    public $email_cliente;
    public $telefono_cliente;
    public $direccion_envio;
    public $creado_en;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Crea una nueva orden en la base de datos
     * @return int|bool ID de la orden creada o false si falla
     */
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET usuario_id=:usuario_id, 
                      total=:total, 
                      estado=:estado,
                      nombre_cliente=:nombre_cliente, 
                      email_cliente=:email_cliente, 
                      telefono_cliente=:telefono_cliente, 
                      direccion_envio=:direccion_envio";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->usuario_id = $this->usuario_id ?? null;
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->estado = htmlspecialchars(strip_tags($this->estado ?? 'pendiente'));
        $this->nombre_cliente = htmlspecialchars(strip_tags($this->nombre_cliente));
        $this->email_cliente = htmlspecialchars(strip_tags($this->email_cliente));
        $this->telefono_cliente = htmlspecialchars(strip_tags($this->telefono_cliente));
        $this->direccion_envio = htmlspecialchars(strip_tags($this->direccion_envio));
        
        // Bind parameters
        $stmt->bindParam(":usuario_id", $this->usuario_id);
        $stmt->bindParam(":total", $this->total);
        $stmt->bindParam(":estado", $this->estado);
        $stmt->bindParam(":nombre_cliente", $this->nombre_cliente);
        $stmt->bindParam(":email_cliente", $this->email_cliente);
        $stmt->bindParam(":telefono_cliente", $this->telefono_cliente);
        $stmt->bindParam(":direccion_envio", $this->direccion_envio);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    /**
     * Crea items de la orden
     * @param int $orderId ID de la orden
     * @param array $items Array de items del carrito
     * @return bool
     */
    public function createOrderItems($orderId, $items) {
        $query = "INSERT INTO " . $this->items_table . " 
                  SET orden_id=:orden_id, 
                      producto_id=:producto_id, 
                      nombre_producto=:nombre_producto,
                      cantidad=:cantidad, 
                      precio_unitario=:precio_unitario, 
                      subtotal=:subtotal";
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($items as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            
            $stmt->bindParam(":orden_id", $orderId);
            $stmt->bindParam(":producto_id", $item['id']);
            $stmt->bindParam(":nombre_producto", $item['name']);
            $stmt->bindParam(":cantidad", $item['quantity']);
            $stmt->bindParam(":precio_unitario", $item['price']);
            $stmt->bindParam(":subtotal", $subtotal);
            
            if (!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Actualiza el stock de productos después de una orden
     * @param array $items Array de items del carrito
     * @return bool
     */
    public function updateProductStock($items) {
        $query = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        foreach ($items as $item) {
            $stmt->bindParam(":cantidad", $item['quantity']);
            $stmt->bindParam(":id", $item['id']);
            
            if (!$stmt->execute()) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Obtiene una orden por su ID
     * @param int $id ID de la orden
     * @return array|bool
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtiene los items de una orden
     * @param int $orderId ID de la orden
     * @return array
     */
    public function getOrderItems($orderId) {
        $query = "SELECT * FROM " . $this->items_table . " WHERE orden_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $orderId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtiene todas las órdenes de un usuario
     * @param int $userId ID del usuario
     * @return array
     */
    public function getByUserId($userId) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE usuario_id = ? 
                  ORDER BY creado_en DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $userId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
