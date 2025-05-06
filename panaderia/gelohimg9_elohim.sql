-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-04-2025 a las 21:10:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gelohimg_elohim`
--

CREATE DATABASE IF NOT EXISTS `gelohimg9_elohim` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gelohimg9_elohim`;

--
-- Estructura de tabla para la tabla `detalles_ventas`
--

CREATE TABLE `detalles_ventas` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_venta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_ventas`
--

INSERT INTO `detalles_ventas` (`id`, `cantidad`, `id_producto`, `id_venta`) VALUES
(3, 1, 1, 21),
(4, 1, 1, 22),
(5, 1, 1, 23),
(6, 1, 2, 24),
(7, 1, 1, 25),
(8, 5, 1, 26),
(9, 1, 3, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotoproducts`
--

CREATE TABLE `fotoproducts` (
  `id` int(11) NOT NULL,
  `products_id` int(11) DEFAULT NULL,
  `foto1` varchar(100) DEFAULT NULL,
  `foto2` varchar(100) DEFAULT NULL,
  `foto3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotoproducts`
--

INSERT INTO `fotoproducts` (`id`, `products_id`, `foto1`, `foto2`, `foto3`) VALUES
(1, 1, 'https://i.postimg.cc/VvCv67C7/Imagen-de-Whats-App-2023-10-16-a-las-13-43-02-b362dc4c-2.jpg', NULL, NULL),
(2, 2, 'https://i.postimg.cc/05bt8ht8/Imagen-de-Whats-App-2023-10-16-a-las-13-43-48-4766a1a8.jpg', NULL, NULL),
(3, 3, 'https://i.postimg.cc/2SKyfb3j/Imagen-de-Whats-App-2023-10-16-a-las-13-43-52-de1255ce.jpg', NULL, NULL),
(4, 4, 'https://i.postimg.cc/PJShz9wf/Imagen-de-Whats-App-2023-10-16-a-las-13-43-55-c94d8def.jpg', NULL, NULL),
(5, 5, 'https://i.postimg.cc/xCRSnhgG/Imagen-de-Whats-App-2023-10-16-a-las-13-43-59-5c8dc29c.jpg', NULL, NULL),
(6, 6, 'https://i.postimg.cc/h42qwFXc/Imagen-de-Whats-App-2023-10-16-a-las-13-44-27-6c1ef703.jpg', NULL, NULL),
(7, 7, 'https://i.postimg.cc/rmqvngcD/Imagen-de-Whats-App-2023-10-16-a-las-13-44-29-6e6178f5.jpg', NULL, NULL),
(8, 8, 'https://i.postimg.cc/BvBzKDD4/Imagen-de-Whats-App-2023-10-16-a-las-13-44-32-2a7be15b.jpg', NULL, NULL),
(9, 9, 'https://i.postimg.cc/mDd6ds8n/Imagen-de-Whats-App-2023-10-16-a-las-13-44-32-e8d07102.jpg', NULL, NULL),
(10, 10, 'https://i.postimg.cc/xdVrHn4y/Imagen-de-Whats-App-2023-10-16-a-las-13-44-27-6475b3e9.jpg', NULL, NULL),
(11, 11, 'fotosProductos/11/1.webp', NULL, NULL),
(12, 12, 'fotosProductos/12/1.webp', NULL, NULL),
(13, 13, 'fotosProductos/13/1.webp', NULL, NULL),
(14, 14, 'fotosProductos/14/1.webp', NULL, NULL),
(15, 15, 'fotosProductos/15/1.webp', NULL, NULL),
(16, 16, 'fotosProductos/16/1.webp', NULL, NULL),
(28, 28, 'Captura de pantalla 2025-04-20 190726.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidostemporales`
--

CREATE TABLE `pedidostemporales` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tokenCliente` varchar(100) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidostemporales`
--

INSERT INTO `pedidostemporales` (`id`, `producto_id`, `cantidad`, `tokenCliente`, `fecha`) VALUES
(51, 1, 1, 'rq4RXhE7QeH2M3Z4NYNmrXvrtEWWxVQ2', '2023-10-16 06:00:16'),
(52, 2, 1, 'agM9vngj0gj8k484DHRa6DN6AJCmQXYM', '2023-10-16 06:40:21'),
(54, 1, 3, 'Md0qKqMDncCHAWnTYrZqHE0zBWrVpHwT', '2023-10-16 21:28:55'),
(55, 2, 1, 'Md0qKqMDncCHAWnTYrZqHE0zBWrVpHwT', '2023-10-16 21:29:27'),
(56, 1, 5, 'bJvuJU3k2Vu4N7eTvE8af8w4qVV8XWxw', '2023-10-18 14:13:03'),
(59, 12, 2, 'aY92u9pFED0zYgCZxXvcnPB479AJcWCN', '2023-10-18 21:20:26'),
(60, 1, 2, 'aY92u9pFED0zYgCZxXvcnPB479AJcWCN', '2023-10-18 21:21:01'),
(61, 3, 1, 'aY92u9pFED0zYgCZxXvcnPB479AJcWCN', '2023-10-18 21:21:37'),
(62, 2, 1, 'aY92u9pFED0zYgCZxXvcnPB479AJcWCN', '2023-10-18 21:22:03'),
(63, 1, 1, '0nXwiAbehZVWNuGNiUJxRMhDqkb2MM29', '2023-10-19 17:10:59'),
(65, 3, 1, 'RkMtaWrU0NGwAYn7P6M3KZGNpCQuE4N0', '2023-10-19 17:29:21'),
(66, 2, 1, 'hpxj7zd8PgUePD2u7QY4dBeqrKBJdkTP', '2025-04-25 17:54:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nameProd` varchar(250) DEFAULT NULL,
  `precio` varchar(250) DEFAULT NULL,
  `description_Prod` text DEFAULT NULL,
  `estado` varchar(50) NOT NULL DEFAULT '1',
  `categoria` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `codigo`, `nameProd`, `precio`, `description_Prod`, `estado`, `categoria`) VALUES
(1, '0', 'Pan de Maíz', '2500', 'Delicioso pan de maíz recién horneado, perfecto para el desayuno o la merienda.', '1', '1'),
(2, '0', 'Arepas Rellenas', '3200', 'Arepas doraditas rellenas de queso, chicharrón y guacamole. ¡Una explosión de sabor!', '1', '2'),
(3, '0', 'Rosca de Queso', '4500', 'Una rosca suave y esponjosa, rellena de queso fresco. Irresistible.', '1', ''),
(4, '0', 'Croissants de Chocolate', '3800', 'Croissants crujientes rellenos de chocolate derretido. Pura indulgencia.', '1', ''),
(5, '0', 'Almojábanas', '2800', 'Almojábanas calientes y esponjosas, ideales para acompañar con café o chocolate caliente.', '1', ''),
(6, '0', 'Empanadas de Carne', '2900', 'Empanadas rellenas de carne molida sazonada, una deliciosa opción para cualquier momento del día.', '1', ''),
(7, '0', 'Torta de Tres Leches', '5500', 'Nuestra famosa torta de tres leches, empapada en una mezcla de leche condensada, evaporada y crema.', '1', ''),
(8, '0', 'Galletas de Avena', '2200', 'Galletas saludables de avena con trozos de frutas secas y nueces.', '1', ''),
(9, '0', 'Muffins de Arándanos', '3200', 'Muffins esponjosos repletos de jugosos arándanos. Una delicia para el paladar.', '1', ''),
(10, '0', 'Pandequeso', '2600', 'Pequeñas bolitas de queso horneadas hasta obtener una textura crujiente por fuera y suave por dentro.', '1', ''),
(11, '0', 'Palitos de Queso', '2700', 'Palitos de pan horneados con queso derretido en su interior, ideales como aperitivo.', '1', ''),
(12, '0', 'Pastelitos de Piña', '4000', 'Deliciosos pastelitos rellenos de piña y azúcar moreno, perfectos para el postre.', '1', ''),
(13, '0', 'Cuñapes', '2900', 'Cuñapes frescos y esponjosos, una delicia boliviana con queso y almidón de yuca.', '1', ''),
(14, '0', 'Torta de Chocolate', '4800', 'Torta de chocolate rica y decadente, cubierta con ganache de chocolate.', '1', ''),
(15, '0', 'Pan Integral', '3500', 'Pan integral recién horneado, rico en fibra y sabor para una alimentación saludable.', '1', ''),
(16, '0', 'Deditos de Queso', '2700', 'Deditos crujientes de queso, perfectos para compartir o disfrutar en solitario.', '1', ''),
(28, 'po132', 'buñuelo', '5000', 'rico y sabroso', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `documento` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  `tipo_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `documento`, `correo`, `usuario`, `contraseña`, `tipo_usuario`) VALUES
(28, 'juan', NULL, 'juantorres@gmal.com', NULL, 'tienda12', 1),
(29, 'juan', NULL, 'admin1@elohim.com', NULL, 'elohim23', 2),
(30, 'Juan Pablo Madrigal Castañeda ', NULL, 'juanmarcas2013@hotmail.es', NULL, 'JPMC1312', 1),
(31, 'Juan ', NULL, 'juansebastiantorresherrera0@gmail.com', NULL, 'tienda12', 1),
(32, 'Jsjaja', NULL, 'juantorres@gmail.com', NULL, 'jsjsjs', 1),
(33, 'Juan ', NULL, 'juansebastiantorresherrera@gmail.com', NULL, 'tienda12', 1),
(34, 'Vergara', NULL, 'neiderxavier@gmail.com', NULL, '123456789', 1),
(35, 'Jheral ', NULL, 'jheralcardenas12345@gmail.com', NULL, '3045759635', 1),
(36, 'Juan', NULL, 'juan_k1@hotmail.com', NULL, '12345', 1),
(37, 'juan', NULL, 'juan12@gamil.com', NULL, 'tienda12', 1),
(39, 'pureba', '789456123', 'neiraherrera2016@gmail.com', 'prueba1', '$2y$10$dPr6aDc5ueD4NksMY/AI7Oeky9HZC17iwNiVEh3EuSOmpVRNl5PgC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `factura` varchar(255) DEFAULT NULL,
  `total_venta` float DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `metodo_pago` varchar(255) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `factura`, `total_venta`, `direccion`, `fecha_hora`, `metodo_pago`, `id_cliente`) VALUES
(21, '1697436031163', 2.5, 'csf', '2023-10-16 01:00:31', 'efectivo', 28),
(22, '1697436443502', 2.5, 'csf', '2023-10-16 01:07:23', 'efectivo', 28),
(23, '1697436464510', 2.5, 'ft54', '2023-10-16 01:07:44', 'efectivo', 28),
(24, '1697438429036', 3.2, 'gfdsfd', '2023-10-16 01:40:29', 'efectivo', 28),
(25, '1697442208677', 2.5, 'hghjg', '2023-10-16 02:43:28', 'transferecia', 28),
(26, '1697638435100', 12.5, 'Poli', '2023-10-18 09:13:54', 'tarjeta', 33),
(27, '1697736586371', 4.5, 'csda', '2023-10-19 12:29:46', 'tarjeta', 37);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `fotoproducts`
--
ALTER TABLE `fotoproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `fotoproducts`
--
ALTER TABLE `fotoproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD CONSTRAINT `detalles_ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `detalles_ventas_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;