# 🛒 Sistema de Carrito de Compras - Instalación

## ⚡ Instalación Rápida

### Paso 1: Crear las Tablas de Órdenes

Ejecuta el instalador:
```
INSTALAR_CARRITO.bat
```

Esto creará las tablas `ordenes` y `orden_items` en la base de datos `smartshop`.

### Paso 2: Acceder al Catálogo

Abre tu navegador en:
```
http://localhost/proyecto2/index.php?action=client
```

## 📋 Características Implementadas

### Para Clientes
- ✅ Catálogo de productos con diseño moderno
- ✅ Filtros por categoría
- ✅ Añadir productos al carrito
- ✅ Ver y editar carrito
- ✅ Proceso de checkout
- ✅ Confirmación de orden

### Para Administradores
- ✅ Ver todas las órdenes realizadas
- ✅ Cambiar estados de órdenes
- ✅ Ver detalles completos de cada venta
- ✅ Estadísticas de ventas

## 🧪 Prueba el Sistema

### Como Cliente:
1. Ir a: `http://localhost/proyecto2/index.php?action=client`
2. Añadir productos al carrito
3. Ver el carrito: `http://localhost/proyecto2/index.php?action=cart`
4. Proceder al checkout
5. Completar la compra

### Como Administrador:
1. Iniciar sesión con:
   - Email: `admin@example.com`
   - Password: `admin123`
2. Ir a "Órdenes / Ventas" en el sidebar
3. Ver y gestionar todas las órdenes

## 🔧 Solución de Problemas

### El carrito no funciona
1. Verifica que las tablas estén creadas ejecutando `INSTALAR_CARRITO.bat`
2. Asegúrate de que Laragon esté corriendo
3. Verifica que la base de datos sea `smartshop`

### No se muestran productos
1. Asegúrate de tener productos en la base de datos
2. Verifica la tabla `productos` en phpMyAdmin

### Errores de sesión
1. Las sesiones se manejan automáticamente
2. Si hay problemas, limpia el caché del navegador

## 📂 Archivos Importantes

- `install_orders.sql` - Script SQL de instalación
- `INSTALAR_CARRITO.bat` - Instalador automático
- `app/Controllers/ClientController.php` - Controlador del cliente
- `app/Controllers/OrderController.php` - Controlador de órdenes
- `app/Models/Cart.php` - Modelo del carrito
- `app/Models/Order.php` - Modelo de órdenes
- `app/Views/client/` - Vistas del cliente
- `app/Views/orders.php` - Vista de órdenes para admin

## 🎯 URLs Principales

- Catálogo: `/proyecto2/index.php?action=client`
- Carrito: `/proyecto2/index.php?action=cart`
- Checkout: `/proyecto2/index.php?action=checkout`
- Admin - Órdenes: `/proyecto2/index.php?view=ordenes`

¡Disfruta tu sistema de carrito de compras! 🎉
