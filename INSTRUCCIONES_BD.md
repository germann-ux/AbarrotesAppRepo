# 🔧 Corrección de Base de Datos - Resumen

## ✅ Cambios Realizados

### 1. Actualización de `Database.php`
- ✅ Cambiado de tabla `users` → `usuarios`
- ✅ Campos actualizados:
  - `username` → `nombre`
  - `password` → `password_hash`
  - `created_at` → `creado_en`
- ✅ Agregadas tablas `ordenes` y `orden_items` con referencias correctas

### 2. Actualización de `User.php`
- ✅ Tabla cambiada a `usuarios`
- ✅ Propiedades actualizadas (`nombre`, `password_hash`)
- ✅ Queries SQL corregidas

### 3. Actualización de `AuthController.php`
- ✅ Sesión usa `$_SESSION['nombre']` en lugar de `username`
- ✅ Registro acepta campo `nombre`

## 🚀 Próximos Pasos

### Opción A: Dejar que PHP cree las tablas automáticamente
1. Simplemente accede a: `http://localhost/proyecto2/index.php?action=client`
2. PHP creará automáticamente todas las tablas al conectarse

### Opción B: Crear tablas manualmente (Recomendado)
1. Abre phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `smartshop`
3. Ve a la pestaña **SQL**
4. Pega y ejecuta este código:

```sql
-- Eliminar tablas antiguas si existen
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS orden_items;
DROP TABLE IF EXISTS ordenes;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;
SET FOREIGN_KEY_CHECKS = 1;

-- Crear categorías
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear productos
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  imagen_url VARCHAR(500),
  categoria_id INT,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_productos_categoria
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    ON DELETE SET NULL
);

-- Crear usuarios
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120),
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('client','admin') NOT NULL DEFAULT 'client',
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear órdenes
CREATE TABLE ordenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(50) DEFAULT 'pendiente',
    nombre_cliente VARCHAR(255) NOT NULL,
    email_cliente VARCHAR(255),
    telefono_cliente VARCHAR(50),
    direccion_envio TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear items de orden
CREATE TABLE orden_items (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de prueba
INSERT INTO categorias (nombre) VALUES 
('Electrónica'),
('Ropa'),
('Hogar'),
('Deportes'),
('Libros');

INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, categoria_id) VALUES
('Laptop Ultradelgada Pro', 'Laptop potente y ligera', 899, 45, 'https://cdn.pixabay.com/photo/2016/11/19/15/32/laptop-1839876_960_720.jpg', 1),
('Smartwatch Fitness', 'Reloj inteligente para deporte', 149, 30, 'https://cdn.pixabay.com/photo/2018/01/08/02/34/technology-3068617_960_720.jpg', 1),
('Auriculares Bluetooth', 'Sonido inalámbrico', 79, 120, 'https://cdn.pixabay.com/photo/2016/11/29/09/08/headphones-1868612_960_720.jpg', 1);

-- Crear usuario admin
INSERT INTO usuarios (nombre, email, password_hash, role) VALUES 
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password: admin123
```

5. Haz clic en **"Continuar"**

## ✅ Verificación

Después de ejecutar el SQL, prueba:
1. `http://localhost/proyecto2/index.php?action=client` - Ver catálogo
2. Añadir productos al carrito
3. Completar una compra

¡El error de foreign key debería estar resuelto! 🎉
