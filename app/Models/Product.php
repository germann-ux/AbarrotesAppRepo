<?php
class Product {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $imagen_url;
    public $categoria_id;
    public $categoria_nombre;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT p.id,
                         p.nombre,
                         p.nombre AS name,
                         p.descripcion, 
                         p.descripcion AS description, 
                         p.precio, 
                         p.precio AS price, 
                         p.stock, 
                         p.imagen_url, 
                         p.imagen_url AS image_url, 
                         p.categoria_id, 
                         c.nombre AS categoria_nombre,
                         c.nombre AS category_name 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categorias c ON p.categoria_id = c.id
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function search($term) {
        $query = "SELECT p.id,
                         p.nombre,
                         p.nombre AS name,
                         p.descripcion,
                         p.descripcion AS description,
                         p.precio,
                         p.precio AS price,
                         p.stock,
                         p.imagen_url,
                         p.imagen_url AS image_url,
                         p.categoria_id,
                         c.nombre AS categoria_nombre,
                         c.nombre AS category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN categorias c ON p.categoria_id = c.id
                  WHERE p.nombre LIKE :search OR p.descripcion LIKE :search
                  ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($query);
        $searchTerm = "%" . $term . "%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET
                    nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, imagen_url=:imagen_url, categoria_id=:categoria_id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->imagen_url = htmlspecialchars(strip_tags($this->imagen_url));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":imagen_url", $this->imagen_url);
        $stmt->bindParam(":categoria_id", $this->categoria_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET
                    nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, imagen_url=:imagen_url, categoria_id=:categoria_id
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->imagen_url = htmlspecialchars(strip_tags($this->imagen_url));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":imagen_url", $this->imagen_url);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Statistics Methods
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countLowStock($threshold = 10) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE stock < ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $threshold);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getStockByCategory() {
        $query = "SELECT c.nombre, SUM(p.stock) as total_stock 
                  FROM " . $this->table_name . " p
                  JOIN categorias c ON p.categoria_id = c.id
                  GROUP BY c.id, c.nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getCountByCategory() {
        $query = "SELECT c.nombre, COUNT(p.id) as total_products 
                  FROM " . $this->table_name . " p
                  JOIN categorias c ON p.categoria_id = c.id
                  GROUP BY c.id, c.nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getRecent($limit = 5) {
        $query = "SELECT p.nombre, c.nombre as categoria, p.creado_en 
                  FROM " . $this->table_name . " p
                  LEFT JOIN categorias c ON p.categoria_id = c.id
                  ORDER BY p.creado_en DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
?>
