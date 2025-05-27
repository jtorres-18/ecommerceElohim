-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2025 a las 07:13:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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

CREATE DATABASE IF NOT EXISTS `gelohimg_elohim` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gelohimg_elohim`;

--
-- Estructura de tabla para la tabla `detalles_ventas`
--

CREATE TABLE `detalles_ventas` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `subTotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_ventas`
--

INSERT INTO `detalles_ventas` (`id`, `cantidad`, `id_producto`, `id_venta`, `subTotal`) VALUES
(10, 1, 3, 29, 0),
(11, 1, 3, 30, 0),
(12, 10, 28, 39, 0),
(13, 5, 28, 40, 0),
(14, 1, 28, 80, 0),
(15, 1, 16, 81, 0),
(16, 1, 28, 81, 0),
(17, 3, 1, NULL, 0),
(18, 5, 2, NULL, 0),
(19, 3, 1, NULL, 0),
(20, 5, 2, NULL, 0),
(21, 8, 1, NULL, 0),
(22, 5, 2, NULL, 0),
(23, 5, 2, NULL, 0),
(24, 8, 1, NULL, 0),
(25, 5, 2, NULL, 0),
(26, 8, 16, NULL, 0),
(27, 5, 2, NULL, 0),
(28, 8, 16, NULL, 0),
(29, 5, 28, NULL, 0),
(30, 68, 16, NULL, 0),
(31, 5, 28, NULL, 0),
(32, 68, 16, NULL, 0),
(33, 5, 28, NULL, 0),
(34, 68, 16, NULL, 0),
(35, 5, 28, NULL, 0),
(36, 3, 1, NULL, 0),
(37, 5, 2, NULL, 0),
(38, 3, 1, 82, 7500),
(39, 2, 16, 83, 5400),
(40, 1, 16, 84, 2700),
(41, 1, 15, 84, 3500),
(42, 1, 2, 85, 3200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargo`
--

CREATE TABLE `encargo` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre`) VALUES
(1, 'pendiente'),
(2, 'aprobado'),
(3, 'pendiente_envio'),
(4, 'listo_recoger'),
(5, 'enviado'),
(6, 'recibido'),
(7, 'cancelar');

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
(115, 28, 1, '5fba9d3220e375230a8cbe2d2977ae57', '2025-05-14 04:05:56'),
(116, 28, 1, 'b482cd573b75cc9ba164dd12e0f28fe2', '2025-05-14 04:10:45'),
(117, 28, 1, 'a50fcc59752834b2a1ba0c4186f5321e', '2025-05-14 04:15:35'),
(118, 16, 1, 'a50fcc59752834b2a1ba0c4186f5321e', '2025-05-14 04:15:43'),
(119, 28, 1, 'de544f74ff962c03cb2ab100ae9036d8', '2025-05-14 04:29:56'),
(120, 28, 1, 'f23eb2fa9c5828ecb0e2d3a69cf2a309', '2025-05-14 23:11:12');

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
(16, 'Dp1', 'Deditos de Queso', '2700', 'Deditos crujientes de queso, perfectos para compartir o disfrutar en solitario.', '1', '1'),
(28, 'po132', 'buñuelo', '5000', 'rico y sabroso', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoventa`
--

CREATE TABLE `tipoventa` (
  `id` int(11) NOT NULL,
  `nombreVenta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoventa`
--

INSERT INTO `tipoventa` (`id`, `nombreVenta`) VALUES
(1, 'local'),
(2, 'ecommerce'),
(3, 'encargo\r\n');

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
(39, 'pureba', '789456123', 'neiraherrera2016@gmail.com', 'prueba1', '$2y$10$dPr6aDc5ueD4NksMY/AI7Oeky9HZC17iwNiVEh3EuSOmpVRNl5PgC', 2),
(41, 'luis perez', '711887906', 'juansebastiantorresherrera05@gmail.com', 'vendedor1', '$2y$10$F84V0nA0qt52JYcqCrivke4HOmC2EuntAXupinw0bz8y0heAFZSiG', 3),
(42, 'Cliente Mostrador', '0000000000', 'mostrador@local.com', 'mostrador', '$2y$10$iVu1b9FzCoKJkSpKacg0veRdEd/.pL6Y/9rwNK79FDB2BC4Go5kGu', 1),
(43, 'luis perez', '71188790', 'juansebastiantorresherrera0@gmail.com', 'vendedor', '$2y$10$qcIXYmrs1rOoIGEYfO7ra.GBCeAp3w/0FtSx8Mjga8NCtAbL62KqG', 1),
(44, 'juan ', '18866464', 'juansebastiantorresherrera55@gmail.com', 'prueba12', '$2y$10$kRbuRr8FpScJWLarQb63K.6gpfMA3o0prjRitcwUcYn.y/qv3LW9.', 3);

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
  `id_cliente` int(11) DEFAULT NULL,
  `id_vendedor` int(255) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `id_tipoVenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `factura`, `total_venta`, `direccion`, `fecha_hora`, `metodo_pago`, `id_cliente`, `id_vendedor`, `id_estado`, `id_tipoVenta`) VALUES
(28, '1746633609429', 3800, 'calleq', '2025-05-07 11:00:09', 'efectivo', 39, 0, 6, 0),
(29, '1746634007114', 2500, 'dsfsafa', '2025-05-07 11:06:47', 'efectivo', 39, 0, 5, 0),
(30, '1746634242313', 3800, 'calleq', '2025-05-07 11:10:42', 'efectivo', 39, 0, 4, 0),
(39, '1746652236', 50000, 'LOCAL', '2025-05-07 16:10:36', 'efectivo', 42, 43, 7, 0),
(40, '1746652739', 25000, 'LOCAL', '2025-05-07 16:18:59', 'efectivo', 42, 43, 6, 0),
(41, '1746901180563', 2500, 'calleq', '2025-05-10 13:19:40', 'efectivo', 43, 0, 2, 0),
(42, '1746904074669', 5000, 'calleq', '2025-05-10 14:07:54', 'efectivo', 43, 0, 1, 0),
(43, '1746907009088', 5000, 'gfhfgh', '2025-05-10 14:56:48', 'efectivo', 43, 0, 1, 0),
(44, '1746907433672', 5000, 'gdfgdfg', '2025-05-10 15:03:53', 'efectivo', 43, 0, 1, 0),
(45, '1746907690387', 5000, 'fghf5', '2025-05-10 15:08:09', 'efectivo', 43, 0, 1, 0),
(46, '1746908024122', 5000, 'sdfsdf', '2025-05-10 15:13:43', 'efectivo', 43, 0, 2, 0),
(47, '1746908423934', 5000, 'gfhfgh', '2025-05-10 15:22:01', 'efectivo', 43, 0, 1, 0),
(48, '1746909316419', 5000, 'bdfvbdfb', '2025-05-10 15:35:24', 'efectivo', 43, 0, 1, 0),
(49, '1746909725371', 5000, 'fsdg', '2025-05-10 15:42:10', 'efectivo', 43, 0, 1, 0),
(50, '1746910450208', 5000, 'frgdfg', '2025-05-10 15:54:31', 'efectivo', 43, 0, 1, 0),
(51, '1746910783901', 5000, 'frgdfg', '2025-05-10 15:59:45', 'efectivo', 43, 0, 1, 0),
(52, '1746911035355', 5000, 'dfsdf', '2025-05-10 16:04:08', 'efectivo', 43, 0, 1, 0),
(53, '1746911725397', 5000, 'gfhfgh', '2025-05-10 16:15:28', 'efectivo', 43, 0, 1, 0),
(54, '1746912054779', 5000, 'dsfsafa', '2025-05-10 16:20:55', 'efectivo', 43, 0, 1, 0),
(55, '1746912524892', 5000, 'calleq', '2025-05-10 16:28:47', 'efectivo', 43, 0, 7, 0),
(56, '1746912581657', 5000, 'calleq', '2025-05-10 16:29:42', 'efectivo', 43, 0, 6, 0),
(57, '1746912670007', 5000, 'calleq', '2025-05-10 16:31:12', 'efectivo', 43, 0, 5, 0),
(58, '1746912774873', 5000, 'calleq', '2025-05-10 16:32:54', 'efectivo', 43, 0, 4, 0),
(59, '1746914845403', 5000, 'calleq', '2025-05-10 17:07:25', 'efectivo', 43, 0, 3, 0),
(60, '1746914980450', 5000, 'gfhfgh', '2025-05-10 17:09:39', 'transferencia', 44, 0, 2, 0),
(61, '1746929009325', 5000, 'calleq', '2025-05-10 21:03:28', 'efectivo', 43, 0, 1, 0),
(62, '1746929052754', 5000, 'jhgjkghkg', '2025-05-10 21:04:12', 'efectivo', 43, 0, 1, 0),
(63, '1746929501279', 5000, 'gfhfgh', '2025-05-10 21:11:40', 'efectivo', 43, 0, 1, 0),
(64, '1746929695331', 5000, 'dsfsafa', '2025-05-10 21:14:54', 'tarjeta', 43, 0, 1, 0),
(65, '1746929965901', 5000, 'calleq', '2025-05-10 21:25:57', 'tarjeta', 43, 0, 1, 0),
(66, '1746930642876', 5000, 'gfhfgh', '2025-05-10 21:30:41', 'transferencia', 43, 0, 1, 0),
(67, '1746930654670', 5000, 'gfhfgh', '2025-05-10 21:30:54', 'transferencia', 43, 0, 1, 0),
(68, '1746930703940', 5000, 'gfhfgh', '2025-05-10 21:31:43', 'transferencia', 43, 0, 1, 0),
(69, '1746931473640', 5000, 'calleq', '2025-05-10 21:44:36', 'efectivo', 43, 0, 1, 0),
(70, '1746931528647', 5000, 'calleq', '2025-05-10 21:45:36', 'transferencia', 43, 0, 1, 0),
(71, '1746931691127', 5000, 'gfhfgh', '2025-05-10 21:48:11', 'efectivo', 43, 0, 1, 0),
(72, '1746931774644', 5000, 'calleq', '2025-05-10 21:49:35', 'efectivo', 43, 0, 1, 0),
(73, '1746932463075592', 10000, 'calleq', '2025-05-10 22:01:03', 'efectivo', 43, 0, 1, 0),
(74, '174693269710624', 0, 'calleq', '2025-05-10 22:04:57', 'efectivo', 43, 0, 1, 0),
(75, '1747193485638', 5000, 'gfhfgh', '2025-05-13 22:31:25', 'efectivo', 43, 0, 1, 0),
(76, '1747193662764', 15000, 'gfhfgh', '2025-05-13 22:34:22', 'tarjeta', 43, 0, 1, 0),
(77, '1747194401968', 5000, 'calleq', '2025-05-13 22:46:44', 'transferencia', 43, 0, 1, 0),
(78, '1747194940907', 5000, 'calleq', '2025-05-13 22:55:41', 'transferencia', 43, 0, 1, 0),
(79, '1747195593657', 5000, 'calleq', '2025-05-13 23:06:36', 'tarjeta', 43, 0, 1, 0),
(80, '1747195855935', 5000, 'calleq', '2025-05-13 23:10:55', 'transferencia', 43, 0, 1, 0),
(81, '1747196195413', 7700, 'juan', '2025-05-13 23:16:35', 'efectivo', 43, 0, 2, 0),
(82, '1747976028709', 7500, 'LOCAL', '2025-05-22 23:53:48', 'efectivo', 43, 0, 1, 3),
(83, '1747976249561', 5400, 'LOCAL', '2025-05-22 23:57:28', 'efectivo', 43, 0, 1, 3),
(84, '1747976453343', 6200, 'LOCAL', '2025-05-23 00:00:52', 'efectivo', 43, 0, 1, 3),
(85, '1747977024245', 3200, 'LOCAL', '2025-05-23 00:10:23', 'efectivo', 43, 0, 1, 3);

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
-- Indices de la tabla `encargo`
--
ALTER TABLE `encargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `tipoventa`
--
ALTER TABLE `tipoventa`
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
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `fk_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `encargo`
--
ALTER TABLE `encargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotoproducts`
--
ALTER TABLE `fotoproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `pedidostemporales`
--
ALTER TABLE `pedidostemporales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

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
  ADD CONSTRAINT `fk_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id`),
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;