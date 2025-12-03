@echo off
cls
echo ==========================================
echo   REPARADOR DE TABLAS DE ORDENES
echo   Base de datos: smartshop
echo ==========================================
echo.

set MYSQL_BIN=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin
set DB_NAME=smartshop

echo [1/2] Conectando a la base de datos...
"%MYSQL_BIN%\mysql.exe" -u root %DB_NAME% -e "SELECT 'Conexion exitosa' as status;" >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se pudo conectar a la base de datos %DB_NAME%
    pause
    exit /b 1
)

echo [2/2] Reparando tablas (DROP & CREATE)...
"%MYSQL_BIN%\mysql.exe" -u root %DB_NAME% < fix_orders_table.sql

if errorlevel 1 (
    echo.
    echo ==========================================
    echo ERROR: Hubo un problema al reparar
    echo ==========================================
) else (
    echo.
    echo ==========================================
    echo TABLAS REPARADAS EXITOSAMENTE!
    echo ==========================================
    echo.
    echo Se corrigio la referencia a la tabla 'users'.
    echo Ya puedes intentar comprar de nuevo.
)

echo.
pause
