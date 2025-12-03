@echo off
echo ========================================
echo Actualizando Base de Datos
echo ========================================
echo.

REM Configuracion
set DB_NAME=smartshop
set DB_USER=root
set DB_PASS=

REM Ruta de MySQL (ajustar segun instalacion de Laragon)
set MYSQL_PATH=C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysql.exe

echo Ejecutando database_updates.sql...
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% %DB_NAME% < database_updates.sql

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo Base de datos actualizada exitosamente!
    echo Se crearon las tablas:
    echo - ordenes
    echo - orden_items
    echo ========================================
) else (
    echo.
    echo ========================================
    echo ERROR: Hubo un problema al actualizar la base de datos
    echo ========================================
)

echo.
pause
