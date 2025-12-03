-- ==========================================
-- PLANTILLA BASE DE DATOS PROYECTO TIENDA
-- ==========================================
-- Ajustar SOLO:
--  - Nombre de la base de datos
--  - Datos de categorías
--  - Datos de productos
--  - (Opcional) nombre de usuarios demo
-- ==========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

-- ==========================================
-- BASE DE DATOS
-- Cambiar `AbarrotesDB` por el nombre del proyecto si se desea
-- ==========================================

CREATE DATABASE IF NOT EXISTS `AbarrotesDB` 
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;
USE `AbarrotesDB`;

-- Si ya seleccionas la base desde fuera, deja solo el comentario de referencia:
-- Base de datos: `AbarrotesDB`

-- ==========================================
-- DROP TABLES (orden correcto por FKs)
-- ==========================================

DROP TABLE IF EXISTS `orden_items`;
DROP TABLE IF EXISTS `ordenes`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `usuarios`;
DROP TABLE IF EXISTS `categorias`;

-- ==========================================
-- TABLA: categorias
-- ==========================================

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------
-- DATOS: categorias
-- Temática: tienda de abarrotes
-- ------------------------------------------

INSERT INTO `categorias` (`id`, `nombre`, `creado_en`) VALUES
(1, 'Abarrotes básicos',      '2025-11-28 22:47:41'), -- arroz, frijol, azúcar, aceite...
(2, 'Lácteos y huevos',       '2025-11-28 22:47:41'),
(3, 'Bebidas y refrescos',    '2025-11-28 22:47:41'),
(4, 'Limpieza del hogar',     '2025-11-28 22:47:41'),
(5, 'Cuidado personal',       '2025-11-28 22:47:41');

-- ==========================================
-- TABLA: productos
-- ==========================================

CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen_url` varchar(500) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_productos_categoria` (`categoria_id`),
  CONSTRAINT `fk_productos_categoria`
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`)
    ON UPDATE CASCADE
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------
-- DATOS: productos
-- CAMBIAR COMPLETAMENTE SEGÚN PROYECTO
-- Ejemplo de temática: arroz, frijol, leche,
-- refrescos, detergente, shampoo, etc.
-- ------------------------------------------

-- INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen_url`, `categoria_id`, `creado_en`) VALUES
-- (1, 'Arroz super extra 1kg', 'Arroz blanco de grano largo', 28.50, 50, NULL, 1, '2025-11-28 22:47:41'),
-- (... más filas ...);
INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen_url`, `categoria_id`, `creado_en`) VALUES
(1, 'Arroz blanco 1 kg', 'Arroz blanco pulido bolsa de 1 kilogramo, ideal para uso diario en casa.', 28.50, 120, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(2, 'Frijol negro 1 kg', 'Frijol negro entero a granel en presentación de 1 kilogramo.', 34.90, 95, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(3, 'Frijol pinto 1 kg', 'Frijol pinto seleccionado en bolsa de 1 kilogramo.', 33.50, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(4, 'Azúcar estándar 1 kg', 'Azúcar estándar de caña en bolsa de 1 kilogramo.', 27.00, 140, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(5, 'Azúcar refinada 1 kg', 'Azúcar refinada de alta pureza en presentación de 1 kilogramo.', 29.00, 90, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(6, 'Sal de mesa yodada 1 kg', 'Sal yodada en bolsa de 1 kilogramo para consumo diario.', 13.50, 110, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(7, 'Aceite vegetal 1 L', 'Aceite vegetal comestible botella de 1 litro.', 48.90, 70, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(8, 'Aceite de canola 900 ml', 'Aceite de canola ligero en botella de 900 mililitros.', 52.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(9, 'Harina de trigo 1 kg', 'Harina de trigo todo uso para repostería y panadería.', 31.50, 85, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(10, 'Harina de maíz nixtamalizado 1 kg', 'Harina de maíz para tortillas y antojitos mexicanos.', 24.90, 130, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(11, 'Pasta para sopa fideo 200 g', 'Pasta tipo fideo para preparar sopas caseras.', 10.50, 200, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(12, 'Pasta para sopa codito 200 g', 'Pasta tipo codito en bolsa de 200 gramos.', 11.00, 180, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(13, 'Purê de tomate 210 g', 'Purê de tomate sazonado listo para guisos y pastas.', 9.90, 160, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(14, 'Atún en agua 140 g', 'Lata de atún aleta amarilla en agua, 140 gramos.', 21.50, 150, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(15, 'Atún en aceite 140 g', 'Lata de atún en aceite vegetal, 140 gramos.', 22.50, 140, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(16, 'Sardinas en salsa de tomate 155 g', 'Sardinas en salsa de tomate enlatadas.', 19.90, 90, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(17, 'Chícharos enlatados 400 g', 'Chícharos tiernos en lata de 400 gramos.', 18.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(18, 'Elotes enlatados 400 g', 'Granos de elote amarillo enlatados.', 18.50, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(19, 'Consomé de pollo 1 kg', 'Condimento en polvo sabor pollo para sazonar alimentos.', 75.00, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(20, 'Caldo de pollo en cubos 12 pzas', 'Cubos de caldo de pollo para sopas y guisos.', 29.90, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(21, 'Mermelada de fresa 500 g', 'Mermelada de fresa en frasco de 500 gramos.', 39.90, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(22, 'Mermelada de durazno 500 g', 'Mermelada de durazno para pan y postres.', 39.90, 45, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(23, 'Mayonesa 390 g', 'Mayonesa clásica en frasco de 390 gramos.', 34.50, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(24, 'Mostaza 220 g', 'Mostaza amarilla para hot dogs y hamburguesas.', 16.90, 55, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(25, 'Salsa de soya 150 ml', 'Salsa de soya para sazonar platillos orientales.', 12.50, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(26, 'Salsa picante roja 150 ml', 'Salsa picante roja para tacos y botanas.', 11.90, 100, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(27, 'Sopa instantánea vaso sabor pollo', 'Sopa instantánea en vaso sabor pollo.', 15.00, 140, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(28, 'Tortillas de maíz 1 kg', 'Tortillas de maíz frescas por kilo.', 22.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(29, 'Tortillas de harina 20 pzas', 'Tortillas de harina de trigo paquete con 20 piezas.', 36.00, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 1, '2025-11-28 22:47:41'),
(30, 'Leche entera 1 L', 'Leche entera pasteurizada en envase de 1 litro.', 25.50, 90, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(31, 'Leche descremada 1 L', 'Leche descremada baja en grasa envase de 1 litro.', 26.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(32, 'Leche deslactosada 1 L', 'Leche deslactosada semidescremada de 1 litro.', 27.50, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(33, 'Yogur bebible fresa 1 L', 'Yogur líquido sabor fresa en envase de 1 litro.', 35.90, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(34, 'Yogur natural 900 g', 'Yogur natural sin azúcar en bote de 900 gramos.', 39.90, 35, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(35, 'Queso fresco 500 g', 'Queso fresco tipo ranchero en pieza de 500 gramos.', 68.00, 25, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(36, 'Queso panela 400 g', 'Queso panela ligero en pieza de 400 gramos.', 64.00, 25, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(37, 'Queso Oaxaca 500 g', 'Queso tipo Oaxaca ideal para quesadillas.', 89.00, 20, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(38, 'Mantequilla con sal 90 g', 'Mantequilla con sal en barra de 90 gramos.', 23.50, 45, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(39, 'Margarina 90 g', 'Margarina untable en barra de 90 gramos.', 15.90, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(40, 'Crema ácida 250 ml', 'Crema ácida de vaca en vaso de 250 mililitros.', 24.90, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(41, 'Crema ácida 450 ml', 'Crema ácida en presentación familiar de 450 mililitros.', 36.90, 30, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(42, 'Huevo blanco pieza', 'Huevo blanco fresco vendido por pieza.', 3.00, 400, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(43, 'Huevo rojo pieza', 'Huevo rojo fresco vendido por pieza.', 3.20, 250, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(44, 'Huevo blanco docena', 'Paquete con 12 huevos blancos frescos.', 38.00, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(45, 'Huevo rojo docena', 'Paquete con 12 huevos rojos frescos.', 40.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(46, 'Queso manchego rebanado 200 g', 'Queso manchego rebanado para sandwiches.', 52.00, 35, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(47, 'Flan napolitano individual', 'Flan napolitano listo para comer por porción.', 18.50, 30, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(48, 'Gelatina de leche sabor vainilla 1 L', 'Gelatina de leche sabor vainilla lista para servir.', 32.00, 18, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(49, 'Leche en polvo 800 g', 'Leche entera en polvo en bolsa de 800 gramos.', 129.00, 15, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 2, '2025-11-28 22:47:41'),
(50, 'Refresco cola 600 ml', 'Bebida gaseosa sabor cola botella de 600 mililitros.', 17.50, 120, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(51, 'Refresco naranja 600 ml', 'Refresco sabor naranja botella de 600 mililitros.', 16.50, 110, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(52, 'Refresco limón 2 L', 'Refresco sabor limón en botella de 2 litros.', 32.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(53, 'Refresco cola 2.5 L', 'Refresco sabor cola botella de 2.5 litros.', 39.90, 70, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(54, 'Agua purificada 600 ml', 'Agua purificada en botella de 600 mililitros.', 9.00, 150, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(55, 'Agua purificada 1.5 L', 'Agua purificada botella de 1.5 litros.', 13.50, 120, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(56, 'Agua mineral 600 ml', 'Agua mineral gasificada en botella de 600 mililitros.', 11.50, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(57, 'Jugo de naranja 1 L', 'Bebida de naranja pasteurizada en envase de 1 litro.', 29.90, 55, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(58, 'Néctar de durazno 1 L', 'Néctar de durazno con pulpa en envase de 1 litro.', 28.50, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(59, 'Bebida isotónica sabor cítricos 600 ml', 'Bebida hidratante sabor cítricos en botella de 600 mililitros.', 18.50, 65, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(60, 'Bebida energética lata 473 ml', 'Bebida energética en lata de 473 mililitros.', 39.00, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(61, 'Café soluble clásico 100 g', 'Café soluble clásico frasco de 100 gramos.', 52.00, 35, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(62, 'Café soluble descafeinado 100 g', 'Café soluble descafeinado frasco de 100 gramos.', 58.00, 20, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(63, 'Café molido 250 g', 'Café molido para cafetera en paquete de 250 gramos.', 75.00, 18, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(64, 'Chocolate en polvo 400 g', 'Bebida en polvo sabor chocolate para leche.', 49.90, 45, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(65, 'Té negro 25 sobres', 'Caja con 25 sobres de té negro.', 28.00, 30, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(66, 'Té de manzanilla 25 sobres', 'Caja con 25 sobres de té de manzanilla.', 27.00, 30, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(67, 'Té verde 25 sobres', 'Caja con 25 sobres de té verde.', 29.50, 25, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(68, 'Bebida sabor horchata 1 L', 'Bebida sabor horchata lista para tomar.', 26.90, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(69, 'Jarabe para agua fresca sabor jamaica 1 L', 'Concentrado sabor jamaica para preparar agua fresca.', 41.00, 25, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 3, '2025-11-28 22:47:41'),
(70, 'Detergente en polvo 1 kg', 'Detergente en polvo para ropa de uso diario.', 39.90, 70, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(71, 'Detergente líquido 850 ml', 'Detergente líquido para ropa de color y delicada.', 42.00, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(72, 'Jabón de barra para ropa 400 g', 'Jabón de barra para prelavado y manchas difíciles.', 18.50, 90, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(73, 'Suavizante de telas 850 ml', 'Suavizante de telas aroma fresco.', 34.90, 45, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(74, 'Cloro 1 L', 'Blanqueador líquido para limpieza y desinfección.', 19.90, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(75, 'Limpiador multiusos 1 L', 'Limpiador líquido multiusos con aroma cítrico.', 28.50, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(76, 'Limpiador para pisos 1 L', 'Limpiador especializado para pisos cerámicos y vinílicos.', 30.00, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(77, 'Desinfectante en aerosol 360 ml', 'Desinfectante en aerosol para superficies y ambientes.', 59.00, 25, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(78, 'Toallas de papel 2 rollos', 'Paquete con 2 rollos de toalla de papel absorbente.', 27.00, 55, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(79, 'Servilletas blancas 200 pzas', 'Paquete con 200 servilletas de papel blancas.', 19.50, 100, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(80, 'Bolsa para basura 30 L paquete 10 pzas', 'Bolsas para basura tamaño mediano paquete con 10 piezas.', 24.00, 70, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(81, 'Bolsa para basura 60 L paquete 10 pzas', 'Bolsas para basura tamaño grande paquete con 10 piezas.', 34.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(82, 'Fibra para tallar', 'Fibra abrasiva para limpieza de trastes.', 6.00, 120, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(83, 'Esponja para trastes', 'Esponja doble capa para lavado de loza y utensilios.', 9.00, 110, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(84, 'Jabón lavatrastes líquido 750 ml', 'Detergente líquido lavatrastes en botella de 750 mililitros.', 29.90, 65, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 4, '2025-11-28 22:47:41'),
(85, 'Jabón de tocador barra 125 g', 'Jabón de tocador con aroma fresco en barra de 125 gramos.', 12.00, 140, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(86, 'Jabón de tocador barra 3 pzas', 'Paquete con 3 jabones de tocador surtidos.', 32.00, 90, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(87, 'Shampoo cabello normal 750 ml', 'Shampoo para cabello normal en presentación de 750 mililitros.', 54.90, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(88, 'Shampoo anticaspa 400 ml', 'Shampoo anticaspa para uso diario.', 49.90, 40, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(89, 'Acondicionador 400 ml', 'Acondicionador para suavizar y desenredar el cabello.', 47.00, 35, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(90, 'Crema corporal 400 ml', 'Crema corporal hidratante para piel seca.', 45.00, 30, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(91, 'Desodorante en barra 50 g', 'Desodorante en barra para hombre 48 horas de protección.', 39.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(92, 'Desodorante en aerosol 150 ml', 'Desodorante en aerosol para mujer con fragancia floral.', 45.00, 55, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(93, 'Pasta dental 100 ml', 'Pasta dental con flúor para protección contra caries.', 29.00, 100, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(94, 'Cepillo dental adulto', 'Cepillo dental para adulto con cerdas medias.', 19.00, 120, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(95, 'Cepillo dental infantil', 'Cepillo dental infantil con mango ergonómico.', 18.00, 80, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(96, 'Hilo dental 50 m', 'Hilo dental de 50 metros para higiene bucal.', 27.00, 45, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(97, 'Rastrillo desechable 2 pzas', 'Paquete con 2 rastrillos desechables de doble hoja.', 24.00, 70, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(98, 'Toallas sanitarias paquete 10 pzas', 'Toallas sanitarias con alas paquete de 10 piezas.', 32.00, 60, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(99, 'Papel higiénico 4 rollos', 'Paquete con 4 rollos de papel higiénico doble hoja.', 35.00, 85, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41'),
(100, 'Gel para cabello 250 g', 'Gel fijador para cabello presentación de 250 gramos.', 26.00, 50, 'https://via.placeholder.com/800x500?text=Producto+abarrotes', 5, '2025-11-28 22:47:41');

-- ==========================================
-- TABLA: usuarios
-- ==========================================

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) DEFAULT NULL,
  `email` varchar(160) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('client','admin') NOT NULL DEFAULT 'client',
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------
-- DATOS: usuarios
-- Valores default para pruebas
-- Contraseña para ambos: 123456
-- hash: $2y$10$dEfmwMuW5S3kKfSspkrZauaqAGluNeZnhzJ7RPQTlgwOAIQEfmTLO
-- ------------------------------------------

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password_hash`, `role`, `creado_en`) VALUES
(1, 'Cliente Mostrador', 'cliente@abarrotesdemo.com', '$2y$10$dEfmwMuW5S3kKfSspkrZauaqAGluNeZnhzJ7RPQTlgwOAIQEfmTLO', 'client', NOW()),
(2, 'Admin Abarrotes',   'admin@abarrotesdemo.com',   '$2y$10$dEfmwMuW5S3kKfSspkrZauaqAGluNeZnhzJ7RPQTlgwOAIQEfmTLO', 'admin', NOW());

-- ==========================================
-- TABLA: ordenes
-- ==========================================

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NULL,
  `total` decimal(10, 2) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'pendiente',
  `nombre_cliente`   varchar(255) NOT NULL,
  `email_cliente`    varchar(255) DEFAULT NULL,
  `telefono_cliente` varchar(50)  DEFAULT NULL,
  `direccion_envio`  text         DEFAULT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_ordenes_usuario` (`usuario_id`),
  CONSTRAINT `fk_ordenes_usuario`
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLA: orden_items
-- ==========================================

CREATE TABLE `orden_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orden_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `nombre_producto`  varchar(255) NOT NULL,
  `cantidad`         int(11) NOT NULL,
  `precio_unitario`  decimal(10, 2) NOT NULL,
  `subtotal`         decimal(10, 2) NOT NULL,
  `creado_en` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_orden_items_orden` (`orden_id`),
  KEY `idx_orden_items_producto` (`producto_id`),
  CONSTRAINT `fk_orden_items_orden`
    FOREIGN KEY (`orden_id`) REFERENCES `ordenes`(`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_orden_items_producto`
    FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`)
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
