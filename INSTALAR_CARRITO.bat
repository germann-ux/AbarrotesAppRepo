@echo off
setlocal EnableDelayedExpansion
cls
echo ==========================================
echo   INSTALADOR DE TABLAS DE ORDENES
echo   Base de datos: smartshop
echo ==========================================
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

echo [1/3] Verificando MySQL en: %MYSQL_EXE%

set "MYSQL_CMD=\"%MYSQL_EXE%\""

%MYSQL_CMD% --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se pudo ejecutar MySQL. Verifica tu instalacion.
    pause
    exit /b 1
)

echo [2/3] Conectando a la base de datos %DB_NAME%...
%MYSQL_CMD% -u root %DB_NAME% -e "SELECT 'Conexion exitosa' as status;" >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se pudo conectar a la base de datos %DB_NAME%
    echo Asegurate de que la base de datos existe y MySQL esta corriendo
    pause
    exit /b 1
)

echo [3/3] Creando tablas de ordenes...
%MYSQL_CMD% -u root %DB_NAME% < install_orders.sql

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
