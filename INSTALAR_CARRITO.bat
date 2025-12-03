@echo off
cls
echo ==========================================
echo   INSTALADOR DE TABLAS DE ORDENES
echo   Base de datos: smartshop
echo ==========================================
echo.

set MYSQL_BIN=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin
set DB_NAME=smartshop

echo [1/3] Verificando MySQL...
if not exist "%MYSQL_BIN%\mysql.exe" (
    echo ERROR: No se encontro MySQL en la ruta esperada
    echo Ruta buscada: %MYSQL_BIN%
    pause
    exit /b 1
)

echo [2/3] Conectando a la base de datos %DB_NAME%...
"%MYSQL_BIN%\mysql.exe" -u root %DB_NAME% -e "SELECT 'Conexion exitosa' as status;" >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se pudo conectar a la base de datos %DB_NAME%
    echo Asegurate de que la base de datos existe y Laragon esta corriendo
    pause
    exit /b 1
)

echo [3/3] Creando tablas de ordenes...
"%MYSQL_BIN%\mysql.exe" -u root %DB_NAME% < install_orders.sql

if errorlevel 1 (
    echo.
    echo ==========================================
    echo ERROR: Hubo un problema al crear las tablas
    echo ==========================================
) else (
    echo.
    echo ==========================================
    echo TABLAS CREADAS EXITOSAMENTE!
    echo ==========================================
    echo.
    echo Se crearon las siguientes tablas:
    echo  - ordenes
    echo  - orden_items
    echo.
    echo Ya puedes usar el sistema de carrito de compras!
)

echo.
pause
