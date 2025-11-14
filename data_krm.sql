-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-11-2025 a las 17:52:18
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
(7, 'Obra Gris'),
(8, 'Electricidad'),
(9, 'Cielo Razo'),
(10, 'Mano de Obra'),
(11, 'Escamadores');

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
(119, 34, '2025-11-11 13:47:49');

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
  `id_categoria` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `id_categoria`) VALUES
(15, 'Varilla nro 3', 7),
(16, 'mt3 Arena', 7),
(17, 'Cable nro 12', 8),
(18, 'Toma corriente doble', 8),
(19, 'Tablilla PVC', 9),
(20, 'Mano de Obra - Electricidad', 10);

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
(99, 119, 'Tabla', 50.00, 150.00, 1.00, 10, 'Blanco', 100000.00, 1000000.00);

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
  `id_usuario` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `mensaje`) VALUES
(1, 'Renan', 'renangalvan@gmail.com', 'hola'),
(2, 'Renan', 'renangalvan@gmail.com', 'hola'),
(3, 'Renan', 'renangalvan@gmail.com', 'hola'),
(4, 'Renan', 'renangalvan@gmail.com', 'hola'),
(5, 'Alberto', 'renangalvan@gmail.com', 'chao'),
(6, 'Manuel', 'renangalvan@gmail.com', 'manuel');

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
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos_cotizacion`
--
ALTER TABLE `productos_cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos_factura`
--
ALTER TABLE `productos_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `tabla_datos`
--
ALTER TABLE `tabla_datos`
  MODIFY `id_tabla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
