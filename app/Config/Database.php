<?php

/**
 * Singleton Database Connection Class
 * Handles automatic database and table creation if they do not exist.
 * Ahora también puede inicializar el esquema desde un script .sql.
 */
class Database {
    private $host     = "localhost";
    private $port     = 3307;           // Puerto configurable
    private $db_name  = "AbarrotesDB";  // Debe coincidir con el script
    private $username = "root";
    private $password = "";

    // Ruta al archivo SQL de inicialización
    private $sqlFile  = __DIR__ . "/../../Utils/ScriptInicio.sql";

    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Try to connect normally
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8mb4");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Auto-initialize tables to prevent "Table not found" errors
            $this->initTables();
            
        } catch(PDOException $exception) {
            // If database not found, try to create it
            if ($exception->getCode() == 1049) { // Unknown database
                try {
                    $tempConn = new PDO(
                        "mysql:host=" . $this->host . ";port=" . $this->port,
                        $this->username,
                        $this->password
                    );
                    $tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $tempConn->exec(
                        "CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` 
                         CHARACTER SET utf8mb4 
                         COLLATE utf8mb4_unicode_ci"
                    );
                    
                    // Retry connection
                    $this->conn = new PDO(
                        "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                        $this->username,
                        $this->password
                    );
                    $this->conn->exec("set names utf8mb4");
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
        if (!$this->conn) {
            return;
        }

        // Verificar que el archivo SQL existe
        if (!file_exists($this->sqlFile)) {
            // Si quieres que truene fuerte, puedes cambiar a die().
            echo "Archivo SQL de inicialización no encontrado en: " . $this->sqlFile;
            return;
        }

        // Truco rápido: validar si una tabla clave existe (productos)
        try {
            $check = $this->conn
                ->query("SHOW TABLES LIKE 'productos'")
                ->fetchColumn();
        } catch (PDOException $e) {
            echo "Error al comprobar tablas existentes: " . $e->getMessage();
            return;
        }

        // Si la tabla ya existe, asumimos que el script ya se importó
        if ($check) {
            return;
        }

        // Leer archivo SQL
        $sql = file_get_contents($this->sqlFile);
        if ($sql === false || trim($sql) === '') {
            echo "No se pudo leer el archivo SQL o está vacío: " . $this->sqlFile;
            return;
        }

        // Ejecutar el script
        try {
            // MySQL/MariaDB permiten múltiples sentencias con exec
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            echo "Error al importar la base de datos desde el script: " . $e->getMessage();
        }
    }
}
?>
