@echo off
setlocal EnableDelayedExpansion
echo ========================================
echo Actualizando Base de Datos
echo ========================================
echo.

REM Configuracion
set "DB_NAME=smartshop"
set "DB_USER=root"
set "DB_PASS="
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

echo Ejecutando database_updates.sql con: %MYSQL_EXE%
set "MYSQL_CMD=\"%MYSQL_EXE%\""

%MYSQL_CMD% -u %DB_USER% -p%DB_PASS% %DB_NAME% < database_updates.sql

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
