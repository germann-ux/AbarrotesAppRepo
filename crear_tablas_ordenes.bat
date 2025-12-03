@echo off
setlocal EnableDelayedExpansion
echo ========================================
echo Creando Tablas de Ordenes en smartshop
echo ========================================
echo.

set "DB_NAME=smartshop"
set "MYSQL_EXE="

REM Permitir que el usuario defina MYSQL_PATH antes de ejecutar
if defined MYSQL_PATH (
    set "MYSQL_EXE=%MYSQL_PATH%"
)

REM Detectar mysql.exe en el PATH del sistema si no se especifico
if not defined MYSQL_EXE (
    for /f "delims=" %%i in ('where mysql 2^>nul') do (
        set "MYSQL_EXE=%%i"
        goto :found_mysql
    )
)

:found_mysql
REM Fallback generico si no se encontro ninguna ruta
if not defined MYSQL_EXE (
    set "MYSQL_EXE=mysql"
)

where "%MYSQL_EXE%" >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se encontro mysql.exe. Agregalo al PATH o define la variable MYSQL_PATH.
    pause
    exit /b 1
)

echo Creando tabla ordenes con: %MYSQL_EXE%
set "MYSQL_CMD=\"%MYSQL_EXE%\""

%MYSQL_CMD% -u root %DB_NAME% -e "CREATE TABLE IF NOT EXISTS ordenes (id INT AUTO_INCREMENT PRIMARY KEY, usuario_id INT NULL, total DECIMAL(10, 2) NOT NULL, estado VARCHAR(50) DEFAULT 'pendiente', nombre_cliente VARCHAR(255) NOT NULL, email_cliente VARCHAR(255), telefono_cliente VARCHAR(50), direccion_envio TEXT, creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"

echo Creando tabla orden_items...
%MYSQL_CMD% -u root %DB_NAME% -e "CREATE TABLE IF NOT EXISTS orden_items (id INT AUTO_INCREMENT PRIMARY KEY, orden_id INT NOT NULL, producto_id INT NOT NULL, nombre_producto VARCHAR(255) NOT NULL, cantidad INT NOT NULL, precio_unitario DECIMAL(10, 2) NOT NULL, subtotal DECIMAL(10, 2) NOT NULL, creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (orden_id) REFERENCES ordenes(id) ON DELETE CASCADE, FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"

echo.
echo Creando indices...
%MYSQL_CMD% -u root %DB_NAME% -e "CREATE INDEX IF NOT EXISTS idx_ordenes_usuario ON ordenes(usuario_id);"
%MYSQL_CMD% -u root %DB_NAME% -e "CREATE INDEX IF NOT EXISTS idx_ordenes_estado ON ordenes(estado);"
%MYSQL_CMD% -u root %DB_NAME% -e "CREATE INDEX IF NOT EXISTS idx_orden_items_orden ON orden_items(orden_id);"
%MYSQL_CMD% -u root %DB_NAME% -e "CREATE INDEX IF NOT EXISTS idx_orden_items_producto ON orden_items(producto_id);"

echo.
echo ========================================
echo Tablas creadas exitosamente!
echo ========================================
pause
