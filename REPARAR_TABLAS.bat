@echo off
setlocal EnableDelayedExpansion
cls
echo ==========================================
echo   REPARADOR DE TABLAS DE ORDENES
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

echo [1/2] Conectando a la base de datos con: %MYSQL_EXE%
set "MYSQL_CMD=\"%MYSQL_EXE%\""

%MYSQL_CMD% -u root %DB_NAME% -e "SELECT 'Conexion exitosa' as status;" >nul 2>&1
if errorlevel 1 (
    echo ERROR: No se pudo conectar a la base de datos %DB_NAME%
    pause
    exit /b 1
)

echo [2/2] Reparando tablas (DROP & CREATE)...
%MYSQL_CMD% -u root %DB_NAME% < fix_orders_table.sql

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
