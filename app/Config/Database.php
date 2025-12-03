<?php

/**
 * Singleton Database Connection Class
 * Handles automatic database and table creation if they do not exist.
 */
class Database {
    private $host = "localhost";
    private $db_name = "smartshop";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Try to connect normally
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Auto-initialize tables to prevent "Table not found" errors
            $this->initTables();
            
        } catch(PDOException $exception) {
            // If database not found, try to create it
            if ($exception->getCode() == 1049) { // Unknown database
                try {
                    $tempConn = new PDO("mysql:host=" . $this->host, $this->username, $this->password);
                    $tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $tempConn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` CHARACTER SET utf8 COLLATE utf8_general_ci");
                    
                    // Retry connection
                    $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                    $this->conn->exec("set names utf8");
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Initialize tables after creating DB
                    $this->initTables();
                    
                } catch(PDOException $e) {
                    echo "Connection error (Creation failed): " . $e->getMessage();
                }
            } else {
                echo "Connection error: " . $exception->getMessage();
            }
        }

        return $this->conn;
    }

    private function initTables() {
        if ($this->conn) {
            // Create Users Table (usuarios)
            $sqlUsers = "CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(120),
                email VARCHAR(160) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                role ENUM('client', 'admin') NOT NULL DEFAULT 'client',
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sqlUsers);

            // Create Default Admin if not exists
            $checkAdmin = $this->conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = 'admin@example.com'");
            $checkAdmin->execute();
            if ($checkAdmin->fetchColumn() == 0) {
                $password = password_hash('admin123', PASSWORD_DEFAULT);
                $insertAdmin = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password_hash, role) VALUES ('Admin', 'admin@example.com', :password, 'admin')");
                $insertAdmin->bindParam(':password', $password);
                $insertAdmin->execute();
            }

            // Create Categories Table
            $sqlCategories = "CREATE TABLE IF NOT EXISTS categorias (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(80) NOT NULL,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sqlCategories);

            // Create Products Table
            $sqlProducts = "CREATE TABLE IF NOT EXISTS productos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(120) NOT NULL,
                descripcion TEXT,
                precio DECIMAL(10, 2) NOT NULL DEFAULT 0,
                stock INT NOT NULL DEFAULT 0,
                imagen_url VARCHAR(500),
                categoria_id INT,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_productos_categoria
                    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
                    ON DELETE SET NULL
            )";
            $this->conn->exec($sqlProducts);
            
            // Create Orders Table
            $sqlOrdenes = "CREATE TABLE IF NOT EXISTS ordenes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NULL,
                total DECIMAL(10, 2) NOT NULL,
                estado VARCHAR(50) DEFAULT 'pendiente',
                nombre_cliente VARCHAR(255) NOT NULL,
                email_cliente VARCHAR(255),
                telefono_cliente VARCHAR(50),
                direccion_envio TEXT,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $this->conn->exec($sqlOrdenes);
            
            // Create Order Items Table
            $sqlOrdenItems = "CREATE TABLE IF NOT EXISTS orden_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                orden_id INT NOT NULL,
                producto_id INT NOT NULL,
                nombre_producto VARCHAR(255) NOT NULL,
                cantidad INT NOT NULL,
                precio_unitario DECIMAL(10, 2) NOT NULL,
                subtotal DECIMAL(10, 2) NOT NULL,
                creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE,
                FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            $this->conn->exec($sqlOrdenItems);
        }
    }
}
?>
