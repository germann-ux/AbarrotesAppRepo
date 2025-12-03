<?php
// fix_db.php
require_once 'app/Config/Database.php';

header('Content-Type: text/plain');

echo "========================================\n";
echo "   REPARADOR DE BASE DE DATOS\n";
echo "========================================\n\n";

try {
    $database = new Database();
    $db = $database->getConnection();
    
    echo "[1/4] Conexión exitosa.\n";
    
    // 1. Eliminar tablas incorrectas
    echo "[2/4] Eliminando tablas antiguas...\n";
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    $db->exec("DROP TABLE IF EXISTS orden_items");
    $db->exec("DROP TABLE IF EXISTS ordenes");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    // 2. Crear tabla ordenes (CORREGIDA)
    echo "[3/4] Creando tabla 'ordenes' (referencia a 'users')...\n";
    $sqlOrdenes = "CREATE TABLE ordenes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NULL,
        total DECIMAL(10, 2) NOT NULL,
        estado VARCHAR(50) DEFAULT 'pendiente',
        nombre_cliente VARCHAR(255) NOT NULL,
        email_cliente VARCHAR(255),
        telefono_cliente VARCHAR(50),
        direccion_envio TEXT,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $db->exec($sqlOrdenes);
    
    // 3. Crear tabla orden_items
    echo "[4/4] Creando tabla 'orden_items'...\n";
    $sqlItems = "CREATE TABLE orden_items (
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
    $db->exec($sqlItems);
    
    echo "\n========================================\n";
    echo "   ¡REPARACIÓN COMPLETADA CON ÉXITO! \n";
    echo "========================================\n";
    echo "Ya puedes volver a intentar tu compra.";

} catch (Exception $e) {
    echo "\nERROR CRÍTICO:\n";
    echo $e->getMessage();
}
?>
