-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-11-2025 a las 18:06:59
-- Versión del servidor: 11.8.3-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u400283574_krm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(10) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(12, 'Lista de productos fijos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `direccion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `empresa`, `direccion`) VALUES
(34, 'Renan Galván ', '87777849', 'Divisoft', 'Puriscal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `grosor` decimal(5,2) NOT NULL,
  `largo` decimal(10,2) NOT NULL,
  `ancho` decimal(10,2) NOT NULL,
  `area` decimal(10,2) NOT NULL,
  `costo_total` decimal(10,2) NOT NULL,
  `impuesto` decimal(10,2) NOT NULL,
  `costo_impuesto` decimal(10,2) NOT NULL,
  `fecha_insercion` timestamp NULL DEFAULT current_timestamp(),
  `costo_cm_cuadrado` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `impuesto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id`, `cliente_id`, `fecha`) VALUES
(119, 34, '2025-11-11 13:47:49'),
(120, 34, '2025-11-14 14:57:56'),
(121, 34, '2025-11-14 15:48:37'),
(122, 34, '2025-11-14 23:20:07'),
(123, 34, '2025-11-15 07:40:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id_material` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `nombre` varchar(200) DEFAULT NULL,
  `edad` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(10) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `id_categoria` int(10) NOT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `grosor` decimal(10,2) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `id_categoria`, `ancho`, `alto`, `grosor`, `color`, `precio_unitario`) VALUES
(22, 'Tabla Nro 1', 12, 18.00, 30.00, 0.50, NULL, 2500.00),
(23, 'Tabla', 13, NULL, NULL, NULL, NULL, NULL),
(24, 'Tabla Nro 2', 12, 23.00, 30.00, 0.50, NULL, 2950.00),
(25, 'Tabla Nro 3', 12, 23.00, 36.00, 0.50, NULL, 3850.00),
(26, 'Tabla Nro 4', 12, 30.00, 36.00, 0.50, NULL, 4950.00),
(27, 'Tabla Nro 5', 12, 30.00, 50.00, 0.50, NULL, 7000.00),
(28, 'Tabla Nro 6', 12, 36.00, 45.00, 0.50, NULL, 7500.00),
(29, 'Tabla Nro 7', 12, 45.00, 50.00, 0.50, NULL, 11000.00),
(30, 'Tabla Nro 8', 12, 74.00, 30.00, 0.50, NULL, 11000.00),
(31, 'Tabla Nro 9', 12, 74.00, 45.00, 0.50, NULL, 17500.00),
(32, 'Tabla Nro 10', 12, 90.00, 36.00, 0.50, NULL, 17500.00),
(33, 'Tabla Nro 11', 12, 150.00, 30.00, 0.50, NULL, 23000.00),
(34, 'Tabla Nro 12', 12, 150.00, 45.00, 0.50, NULL, 35000.00),
(35, 'Tabla Nro 13', 12, 150.00, 92.00, 0.50, NULL, 69000.00),
(36, 'Empujador de carne', 12, NULL, NULL, NULL, NULL, 17000.00),
(37, 'Descamador', 12, NULL, NULL, NULL, NULL, 2300.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_cotizacion`
--

CREATE TABLE `productos_cotizacion` (
  `id` int(11) NOT NULL,
  `cotizacion_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `grosor` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_factura`
--

CREATE TABLE `productos_factura` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `ancho` decimal(10,2) DEFAULT NULL,
  `alto` decimal(10,2) DEFAULT NULL,
  `grosor` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `color` text NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos_factura`
--

INSERT INTO `productos_factura` (`id`, `factura_id`, `descripcion`, `ancho`, `alto`, `grosor`, `cantidad`, `color`, `precio_unitario`, `total`) VALUES
(99, 119, 'Tabla', 50.00, 150.00, 1.00, 10, 'Blanco', 100000.00, 1000000.00),
(100, 120, 'Tabla Nro 1', 50.00, 50.00, 1.00, 10, 'Blanco', 20000.00, 200000.00),
(101, 121, 'Fierro', 45.00, 45.00, 1.00, 45, 'Blanco', 20000.00, 900000.00),
(102, 122, 'Tabla Nro 1', 50.00, 50.00, 1.00, 20, 'Blanco', 20000.00, 400000.00),
(103, 123, 'Tabla Nro 1', 18.00, 30.00, 0.50, 5, '', 2500.00, 12500.00),
(104, 123, 'Tabla Nro 2', 23.00, 30.00, 0.50, 15, '', 2950.00, 44250.00),
(105, 123, 'Tabla Nro 3', 23.00, 36.00, 0.50, 8, '', 3850.00, 30800.00),
(106, 123, 'Tabla Nro 4', 30.00, 36.00, 0.50, 5, '', 4950.00, 24750.00),
(107, 123, 'Tabla Nro 7', 45.00, 50.00, 0.50, 10, '', 11000.00, 110000.00),
(108, 123, 'Descamador', 0.00, 0.00, 0.00, 20, '', 2300.00, 46000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `renan`
--

CREATE TABLE `renan` (
  `id_nombre` int(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `renan`
--

INSERT INTO `renan` (`id_nombre`, `nombre`) VALUES
(2, 'Lorenita'),
(3, 'Alberto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_datos`
--

CREATE TABLE `tabla_datos` (
  `id_tabla` int(11) NOT NULL,
  `grosor` decimal(10,2) DEFAULT NULL,
  `costo_cm_cuadrado` decimal(10,2) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tabla_datos`
--

INSERT INTO `tabla_datos` (`id_tabla`, `grosor`, `costo_cm_cuadrado`, `color`, `observaciones`) VALUES
(25, 0.50, 4.65, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`) VALUES
(1, 'Administrador', 'admin@krm.com', '$2y$10$I2jT4.V0.f2/iA/2b.eJ9eEC2TylsExh2wt2s20iGz5Etf.1dI9I6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productos_cotizacion`
--
ALTER TABLE `productos_cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_id` (`cotizacion_id`);

--
-- Indices de la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `factura_id` (`factura_id`);

--
-- Indices de la tabla `tabla_datos`
--
ALTER TABLE `tabla_datos`
  ADD PRIMARY KEY (`id_tabla`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `productos_cotizacion`
--
ALTER TABLE `productos_cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `tabla_datos`
--
ALTER TABLE `tabla_datos`
  MODIFY `id_tabla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `productos_cotizacion`
--
ALTER TABLE `productos_cotizacion`
  ADD CONSTRAINT `productos_cotizacion_ibfk_1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`);

--
-- Filtros para la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  ADD CONSTRAINT `productos_factura_ibfk_1` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
