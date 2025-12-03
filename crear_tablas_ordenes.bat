@echo off
echo ========================================
echo Creando Tablas de Ordenes en smartshop
echo ========================================
echo.

REM Ruta de MySQL en Laragon
set MYSQL_PATH=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe

echo Creando tabla ordenes...
"%MYSQL_PATH%" -u root smartshop -e "CREATE TABLE IF NOT EXISTS ordenes (id INT AUTO_INCREMENT PRIMARY KEY, usuario_id INT NULL, total DECIMAL(10, 2) NOT NULL, estado VARCHAR(50) DEFAULT 'pendiente', nombre_cliente VARCHAR(255) NOT NULL, email_cliente VARCHAR(255), telefono_cliente VARCHAR(50), direccion_envio TEXT, creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"

echo Creando tabla orden_items...
"%MYSQL_PATH%" -u root smartshop -e "CREATE TABLE IF NOT EXISTS orden_items (id INT AUTO_INCREMENT PRIMARY KEY, orden_id INT NOT NULL, producto_id INT NOT NULL, nombre_producto VARCHAR(255) NOT NULL, cantidad INT NOT NULL, precio_unitario DECIMAL(10, 2) NOT NULL, subtotal DECIMAL(10, 2) NOT NULL, creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE, FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"

echo.
echo Creando indices...
"%MYSQL_PATH%" -u root smartshop -e "CREATE INDEX IF NOT EXISTS idx_ordenes_usuario ON ordenes(usuario_id);"
"%MYSQL_PATH%" -u root smartshop -e "CREATE INDEX IF NOT EXISTS idx_ordenes_estado ON ordenes(estado);"
"%MYSQL_PATH%" -u root smartshop -e "CREATE INDEX IF NOT EXISTS idx_orden_items_orden ON orden_items(orden_id);"
"%MYSQL_PATH%" -u root smartshop -e "CREATE INDEX IF NOT EXISTS idx_orden_items_producto ON orden_items(producto_id);"

echo.
echo Verificando tablas...
"%MYSQL_PATH%" -u root smartshop -e "SHOW TABLES;"

echo.
echo ========================================
echo Tablas creadas exitosamente!
echo ========================================
pause
