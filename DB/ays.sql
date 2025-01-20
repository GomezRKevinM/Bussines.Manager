-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-07-2024 a las 01:56:08
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
-- Base de datos: `ays`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alert`
--

CREATE TABLE `alert` (
  `alert_config` varchar(40) NOT NULL,
  `tipo_cant` varchar(50) NOT NULL,
  `cantidad` int(100) NOT NULL,
  `color_cantidad_normal` varchar(50) NOT NULL,
  `color_cantidad_baja` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `alert`
--

INSERT INTO `alert` (`alert_config`, `tipo_cant`, `cantidad`, `color_cantidad_normal`, `color_cantidad_baja`) VALUES
('default', 'Cantidad', 10, '#12D332', '#FF3333'),
('default', 'Cantidad', 10, '#12D332', '#FF3333');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `caja_id` int(5) NOT NULL,
  `caja_numero` int(5) NOT NULL,
  `caja_nombre` varchar(100) NOT NULL,
  `caja_efectivo` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`caja_id`, `caja_numero`, `caja_nombre`, `caja_efectivo`) VALUES
(1, 1, 'Caja Principal', 796900.00),
(5, 2, 'Transferencias', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(7) NOT NULL,
  `categoria_nombre` varchar(50) NOT NULL,
  `categoria_ubicacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `categoria_nombre`, `categoria_ubicacion`) VALUES
(3, 'Cerveza', 'Local'),
(4, 'Gaseosa', 'Local'),
(5, 'Jugos Naturales', 'Local'),
(8, 'Suero Rehidratante', 'Local'),
(9, 'Atunes', 'Local'),
(10, 'Sopa Instantanea', 'Local'),
(11, 'Dulces', 'Local'),
(12, 'Mecatos', 'Local'),
(13, 'Cereales', 'Local'),
(14, 'Aseo Cocina', 'Local'),
(15, 'Alimentos para Mascotas', 'Local'),
(16, 'Aseo y Limpieza', 'Local'),
(17, 'Aseo Personal', 'Local'),
(18, 'Salsas', 'Local'),
(19, 'Condimentos', 'Local'),
(20, 'celulares', 'Local'),
(21, 'computadores', 'Local');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL,
  `cliente_tipo_documento` varchar(20) NOT NULL,
  `cliente_numero_documento` varchar(35) NOT NULL,
  `cliente_nombre` varchar(50) NOT NULL,
  `cliente_apellido` varchar(50) NOT NULL,
  `cliente_provincia` varchar(30) NOT NULL,
  `cliente_ciudad` varchar(30) NOT NULL,
  `cliente_direccion` varchar(70) NOT NULL,
  `cliente_telefono` varchar(20) NOT NULL,
  `cliente_email` varchar(50) NOT NULL,
  `cliente_ventas` int(200) NOT NULL,
  `cliente_llamadas` int(200) NOT NULL,
  `cliente_visitas` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_tipo_documento`, `cliente_numero_documento`, `cliente_nombre`, `cliente_apellido`, `cliente_provincia`, `cliente_ciudad`, `cliente_direccion`, `cliente_telefono`, `cliente_email`, `cliente_ventas`, `cliente_llamadas`, `cliente_visitas`) VALUES
(1, 'Otro', 'N/A', 'Publico', 'General', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 1, 0, 0),
(2, 'Cedula', '1001943092', 'Kevin Manunel', 'Gomez Rojas', 'Bolivar', 'Cartagena', 'Campestre', '3158500852', 'kevingomezdp2212@gmail.com', 4, 0, 0),
(3, 'Cedula', '1007456852', 'Wilmer', 'Barragan', 'Bolivar', 'Cartagena', 'Manga', '3150854562', 'wilmer@example.com', 3, 0, 0),
(4, 'Pasaporte', 'PS-45025', 'Myke', 'Bent', 'Bolivar', 'Cartagena', 'El laguito', '+511042564715', 'mykepeep22@yahoo.com', 0, 0, 0),
(5, 'NIT', '901569988-2', 'KORANTOS', 'SAS', 'Bolivar', 'Cartagena', 'Parques de Bolivar', '3118160908', 'Nosubministrado@email.com', 0, 0, 0),
(6, 'NIT', '999999-1', 'JAVIS COLOR', 'Ferretería', 'Bolivar', 'Cartagena', 'La Consolata', '3015825960', '', 0, 0, 0),
(7, 'Cedula', '1143337859', 'Maria Eugenia', 'Rojas Guerra', 'Bolivar', 'Cartagena', 'Ciudadela 2000 manzana 6 Lt 36', '3013861279', 'maryairg@gmail.com', 1, 0, 0),
(8, 'Cedula', '1005267848', 'Aldair', 'Martinez Orejuela', 'Bolivar', 'Turbaco', 'Arboleda Cll2 #45-20D', '3124532550', 'aldair@gmail.com', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codebar`
--

CREATE TABLE `codebar` (
  `codigo_id` int(11) NOT NULL,
  `codigo_nombre` varchar(200) NOT NULL,
  `codigo_codigo` varchar(100) NOT NULL,
  `producto_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `codebar`
--

INSERT INTO `codebar` (`codigo_id`, `codigo_nombre`, `codigo_codigo`, `producto_id`) VALUES
(1, 'Carro', 'L4F0D5W5K1-1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `compra_id` int(11) NOT NULL,
  `compra_codigo` varchar(200) NOT NULL,
  `compra_fecha` date NOT NULL,
  `compra_hora` int(17) NOT NULL,
  `compra_total` decimal(30,2) NOT NULL,
  `compra_pagado` decimal(30,2) NOT NULL,
  `compra_cambio` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`compra_id`, `compra_codigo`, `compra_fecha`, `compra_hora`, `compra_total`, `compra_pagado`, `compra_cambio`, `usuario_id`, `supplier_id`, `caja_id`) VALUES
(3, 'M0W9E9N6E0-1', '2024-06-20', 2, 100.00, 100.00, 0.00, 1, 6, 1),
(4, 'Q1J8H9Q9R9-2', '2024-06-20', 4, 1000.00, 1000.00, 0.00, 1, 1, 1),
(5, 'F5W5C4B0O1-3', '2024-06-21', 3, 1000.00, 1000.00, 0.00, 7, 6, 1),
(6, 'W6Q6N9H0R4-4', '2024-06-21', 3, 1000.00, 1000.00, 0.00, 7, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_detalle`
--

CREATE TABLE `compra_detalle` (
  `compra_detalle_id` int(11) NOT NULL,
  `compra_detalle_cantidad` int(10) NOT NULL,
  `compra_detalle_precio_compra` decimal(30,2) NOT NULL,
  `compra_detalle_precio` decimal(30,2) NOT NULL,
  `compra_detalle_total` decimal(30,2) NOT NULL,
  `compra_detalle_descripcion` varchar(200) NOT NULL,
  `compra_coment` varchar(2000) NOT NULL,
  `compra_codigo` varchar(200) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compra_detalle`
--

INSERT INTO `compra_detalle` (`compra_detalle_id`, `compra_detalle_cantidad`, `compra_detalle_precio_compra`, `compra_detalle_precio`, `compra_detalle_total`, `compra_detalle_descripcion`, `compra_coment`, `compra_codigo`, `producto_id`) VALUES
(3, 10, 10.00, 1500.00, 100.00, 'Hit Mora 500ml', 'Compra de productos', 'M0W9E9N6E0-1', 23),
(4, 100, 10.00, 6000.00, 1000.00, 'Hit Frutas Tropicales 1L', 'Compra de productos', 'Q1J8H9Q9R9-2', 11),
(5, 100, 10.00, 6000.00, 1000.00, 'Hit Mango 1L', 'Compra de productos', 'F5W5C4B0O1-3', 13),
(6, 100, 10.00, 2000.00, 1000.00, 'Cereal Kelloggs Zucaritas 39gr', 'Compra de productos', 'W6Q6N9H0R4-4', 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `cotizacion_id` int(30) NOT NULL,
  `cotizacion_codigo` varchar(200) NOT NULL,
  `cotizacion_fecha` date NOT NULL,
  `cotizacion_hora` varchar(17) NOT NULL,
  `cotizacion_total` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`cotizacion_id`, `cotizacion_codigo`, `cotizacion_fecha`, `cotizacion_hora`, `cotizacion_total`, `usuario_id`, `cliente_id`, `caja_id`) VALUES
(15957659, 'R5S2G2W6W3-1', '2024-06-12', '11:06 am', 1500.00, 1, 1, 1),
(15957660, 'G0X0T6D9E9-2', '2024-06-24', '01:49 pm', 680000.00, 1, 1, 1),
(15957661, 'G9A4M7J4I2-3', '2024-06-24', '02:14 pm', 120000.00, 1, 6, 1),
(15957662, 'K3T2L1D6P5-4', '2024-06-24', '02:20 pm', 910000.00, 1, 1, 1),
(15957663, 'J9Q5P6S3U2-5', '2024-06-24', '02:29 pm', 680000.00, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_detalle`
--

CREATE TABLE `cotizacion_detalle` (
  `cotizacion_detalle_id` int(100) NOT NULL,
  `cotizacion_detalle_cantidad` int(10) NOT NULL,
  `cotizacion_detalle_precio_compra` decimal(30,2) NOT NULL,
  `cotizacion_detalle_precio` decimal(30,2) NOT NULL,
  `cotizacion_detalle_total` decimal(30,2) NOT NULL,
  `cotizacion_detalle_descripcion` varchar(200) NOT NULL,
  `cotizacion_detalle_detalles` varchar(2000) NOT NULL,
  `cotizacion_codigo` varchar(200) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cotizacion_detalle`
--

INSERT INTO `cotizacion_detalle` (`cotizacion_detalle_id`, `cotizacion_detalle_cantidad`, `cotizacion_detalle_precio_compra`, `cotizacion_detalle_precio`, `cotizacion_detalle_total`, `cotizacion_detalle_descripcion`, `cotizacion_detalle_detalles`, `cotizacion_codigo`, `producto_id`) VALUES
(15957660, 1, 10.00, 1500.00, 1500.00, 'Colombiana 400ml', '', 'R5S2G2W6W3-1', 25),
(15957661, 1, 600000.00, 680000.00, 680000.00, 'Computador i3', '', 'G0X0T6D9E9-2', 55),
(15957662, 1, 60000.00, 120000.00, 120000.00, 'Lector Codigo de Barras', '', 'G9A4M7J4I2-3', 56),
(15957663, 1, 600000.00, 680000.00, 680000.00, 'Computador i3', '', 'K3T2L1D6P5-4', 55),
(15957664, 1, 90000.00, 110000.00, 110000.00, 'Impresora Ticket 80mm', '', 'K3T2L1D6P5-4', 57),
(15957665, 1, 60000.00, 120000.00, 120000.00, 'Lector Codigo de Barras', '', 'K3T2L1D6P5-4', 56),
(15957666, 1, 600000.00, 680000.00, 680000.00, 'Computador i3', 'Computador i3 de cuarta generación.', 'J9Q5P6S3U2-5', 55);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diseño`
--

CREATE TABLE `diseño` (
  `diseño_id` int(11) NOT NULL,
  `nav_color` varchar(20) NOT NULL,
  `nav_text_color` varchar(20) NOT NULL,
  `body_color` varchar(20) NOT NULL,
  `titulo_color` varchar(20) NOT NULL,
  `diseño_tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `diseño`
--

INSERT INTO `diseño` (`diseño_id`, `nav_color`, `nav_text_color`, `body_color`, `titulo_color`, `diseño_tipo`) VALUES
(1, '#3f51b5', '#FFF', '#ffffff', '#000000', 'predeterminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL,
  `empresa_nombre` varchar(90) NOT NULL,
  `empresa_nit` varchar(50) NOT NULL,
  `empresa_telefono` varchar(20) NOT NULL,
  `empresa_email` varchar(50) NOT NULL,
  `empresa_direccion` varchar(100) NOT NULL,
  `logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`empresa_id`, `empresa_nombre`, `empresa_nit`, `empresa_telefono`, `empresa_email`, `empresa_direccion`, `logo`) VALUES
(1, 'AyS Soluciones', '31374595-8', '3157450142', 'ayssolucionesdevelop@gmail.com', 'Diag 30 Crr50B #50B', 'Kevin_43.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_finish`
--

CREATE TABLE `fecha_finish` (
  `usuario_id` int(11) NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamada`
--

CREATE TABLE `llamada` (
  `llamada_id` int(11) NOT NULL,
  `llamada_fecha` date NOT NULL,
  `llamada_hora` varchar(17) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `llamada_estado` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `llamada`
--

INSERT INTO `llamada` (`llamada_id`, `llamada_fecha`, `llamada_hora`, `cliente_id`, `llamada_estado`) VALUES
(10, '2024-07-26', '13:40', 7, 'pendiente'),
(11, '2024-07-13', '15:20', 5, 'Realizada'),
(12, '2024-07-11', '07:22', 2, 'Realizada'),
(13, '2024-07-01', '21:18', 2, 'Realizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `presentacion_id` int(11) NOT NULL,
  `presentacion_nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`presentacion_id`, `presentacion_nombre`) VALUES
(1, 'Unidad'),
(6, 'caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(20) NOT NULL,
  `producto_codigo` varchar(77) NOT NULL,
  `producto_nombre` varchar(100) NOT NULL,
  `producto_vence` date NOT NULL,
  `producto_stock_total` int(25) NOT NULL,
  `producto_tipo_unidad` varchar(20) NOT NULL,
  `producto_precio_compra` decimal(30,2) NOT NULL,
  `producto_precio_venta` decimal(30,2) NOT NULL,
  `producto_marca` varchar(35) NOT NULL,
  `producto_modelo` varchar(35) NOT NULL,
  `producto_estado` varchar(20) NOT NULL,
  `producto_foto` varchar(500) NOT NULL,
  `categoria_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `producto_codigo`, `producto_nombre`, `producto_vence`, `producto_stock_total`, `producto_tipo_unidad`, `producto_precio_compra`, `producto_precio_venta`, `producto_marca`, `producto_modelo`, `producto_estado`, `producto_foto`, `categoria_id`) VALUES
(11, '3809', 'Hit Frutas Tropicales 1L', '0000-00-00', 0, 'Unidad', 10.00, 6000.00, 'Postobón Hit', 'Lx12', 'Habilitado', '3809_65.png', 5),
(12, '3808', 'Hit Naranja Piña 1L', '0000-00-00', 12, '', 10.00, 6000.00, 'Postobón Hit', 'Lx12', 'Habilitado', '3808_79.png', 5),
(13, '3807', 'Hit Mango 1L', '0000-00-00', 112, '', 10.00, 6000.00, 'Postobón Hit', 'Lx12', 'Habilitado', '3807_2.png', 5),
(14, '3806', 'Hit Mora 1L', '0000-00-00', 10, '', 10.00, 6000.00, 'Postobón Hit', 'Tetra Lx12', 'Habilitado', '3806_67.png', 5),
(16, '2955', 'Uva pet 1.5Lt', '0000-00-00', 12, '', 10.00, 2500.00, 'Postobón', 'pet 1.5x12', 'Habilitado', '2955_92.jpg', 4),
(17, '0869', 'Pepsi 500ml', '0000-00-00', 10, '', 10.00, 1500.00, 'Postobón', 'S.I pet1500mlx12 P.E', 'Habilitado', '0869_1.png', 4),
(18, '0312', 'Manzana Postobón 1.5Lt', '0000-00-00', 12, '', 10.00, 2500.00, 'Postobón', 'pet 1.5Lx12 P.E', 'Habilitado', '0312_7.jpg', 4),
(22, '2987', 'Hit Naranja-Piña 500ml', '0000-00-00', 12, '', 10.00, 1500.00, 'Postobón Hit', 'P500ml', 'Habilitado', '2987_22.png', 5),
(23, '2985', 'Hit Mora 500ml', '0000-00-00', 22, '', 10.00, 1500.00, 'Postobón Hit', 'P500ml', 'Habilitado', '2985_27.png', 5),
(24, '0885', 'Pepsi 400ml', '0000-00-00', 15, '', 10.00, 1500.00, 'Pepsi', 'S.I Pet 400mlx15', 'Habilitado', '0885_59.png', 4),
(25, '5024', 'Colombiana 400ml', '0000-00-00', 199, 'Unidad', 10.00, 1500.00, 'Postobón', 'P400x15 PreEsp', 'Habilitado', '5024_17.png', 4),
(26, '3192', 'Manzana 400ml', '0000-00-00', 15, '', 10.00, 1500.00, 'Postobón', 'Pet 400x15', 'Habilitado', '3192_16.jpg', 4),
(27, '1636', 'Refresco Hit FruiTrop 200ml', '0000-00-00', 24, '', 10.00, 1500.00, 'Postobón Hit', 'HitFruiTrop200x24', 'Habilitado', '1636_70.jpg', 5),
(28, '5231', 'Hit Nectar Manzana 1Lt', '0000-00-00', 50, '', 10.00, 10000.00, 'Postobón Hit', 'TetraLitro', 'Habilitado', '5231_63.png', 5),
(29, '5232', 'Hit Nectar Pera 1Lt', '0000-00-00', 7000, 'Unidad', 10.00, 10000.00, 'Postobón Hit', 'TetraLitro', 'Habilitado', '5232_20.png', 5),
(31, '109361', 'Electrolit Fresa 625ml', '0000-00-00', 14, '', 10.00, 7000.00, 'Electrolit', 'Botella 625ml', 'Habilitado', '109361_40.jpg', 8),
(32, '109359', 'Electrolit Uva 625ml', '0000-00-00', 20, '', 10.00, 7000.00, 'Electrolit', 'Botella 625ml', 'Habilitado', '109359_56.png', 8),
(33, '10360', 'Electrolit coco 625ml', '0000-00-00', 98, 'Unidad', 10.00, 7000.00, 'Electrolit', 'Botella 625ml', 'Habilitado', '10360_79.jpg', 8),
(34, '109365', 'Electrolit Mandarina', '0000-00-00', 198, 'Unidad', 10.00, 7000.00, 'Electrolit', 'Botella 625ml', 'Habilitado', '109365_14.jpg', 8),
(36, 'AS8241', 'Sopa instantánea con fideos Ajinomen Pollo y verduras 80g', '0000-00-00', 20, '', 10.00, 3000.00, 'Ajinomen', 'Sopa i. Pollo y Verduras 80gr', 'Habilitado', 'AS8241_4.png', 10),
(40, '112510', 'Golosinas Fini Roller Ristra 20gr', '0000-00-00', 18, '', 10.00, 1000.00, 'Fini Roller', 'Ristra 20 gr', 'Habilitado', '112510_1.png', 11),
(41, '112425', 'Cereal Kelloggs Zucaritas 39gr', '0000-00-00', 72, 'Unidad', 10.00, 2000.00, 'Kelloggs', 'Paketicos Bolsa 39gr', 'Habilitado', '112425_87.png', 13),
(42, '108058', 'Esponja Everhouse Oro Plata', '0000-00-00', 20, 'Sobre', 10.00, 4000.00, 'Everhouse', 'Oro Platax6Und', 'Habilitado', '108058_2.png', 14),
(43, '108057', 'Esponja Everhouse Doble Uso', '0000-00-00', 20, '', 10.00, 4500.00, 'Everhouse', 'Doble Usox6Und', 'Habilitado', '108057_42.png', 14),
(44, '111831', 'Pedigree Humedo Puppy Res 100gr', '0000-00-00', 20, '', 10.00, 3500.00, 'Pedigree', 'Alimento Humedo', 'Habilitado', '111831_94.png', 15),
(45, '111835', 'Pedigree Humedo Res 100gr', '0000-00-00', 20, '', 10.00, 3500.00, 'Pedigree', 'Alimento Humedo', 'Habilitado', '111835_72.png', 15),
(46, '111834', 'Pedigree R pequeñas Pollo 100gr', '0000-00-00', 20, '', 10.00, 3500.00, 'Pedigree', 'Alimento Humedo', 'Habilitado', '111834_52.png', 15),
(49, 'D53817', 'Jabón Top Terra Azul 230g', '0000-00-00', 20, '', 10.00, 2000.00, 'Top Terra', 'Azul 230g', 'Habilitado', 'D53817_70.png', 16),
(50, '7989', 'Oka Loka Fusión 168gr', '0000-00-00', 12, '', 10.00, 1500.00, 'Super', 'Oka Loka', 'Habilitado', '7989_15.jpg', 11),
(51, '62771', 'Salsa De tomate San Jorge 85gr', '0000-00-00', 12, '', 10.00, 5500.00, 'San Jorge', 'Salsa de Tomate 85gr', 'Habilitado', '62771_42.png', 18),
(52, '7547', 'Super Menta Helada', '0000-00-00', 100, '', 10.00, 200.00, 'Super', 'Menta Helada', 'Habilitado', '7547_64.png', 11),
(53, '7702535027127', 'coca', '0000-00-00', 900, 'Unidad', 10.00, 2500.00, 'coca', 'coca', 'Habilitado', '', 4),
(55, 'COPi3', 'Computador i3', '0000-00-00', 100, 'Unidad', 600000.00, 680000.00, 'Dell', 'Escritorio', 'Habilitado', 'COPi3_28.png', 21),
(56, 'LEC000120', 'Lector Codigo de Barras', '0000-00-00', 100, 'Unidad', 60000.00, 120000.00, 'Generica', 'pistola', 'Habilitado', 'LEC000120_17.jpg', 21),
(57, '1000124', 'Impresora Ticket 80mm', '0000-00-00', 99, 'Unidad', 90000.00, 110000.00, 'Generic', 'impresora', 'Habilitado', '', 21),
(58, '450004560', 'Kepra levetiracetam 100mg/ml', '0000-00-00', 18, 'Unidad', 10000.00, 114000.00, 'General', 'general', 'Habilitado', '', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedor`
--

CREATE TABLE `provedor` (
  `supplier_id` int(10) NOT NULL,
  `supplier_nombre` varchar(250) NOT NULL,
  `supplier_representante` varchar(70) NOT NULL,
  `supplier_provincia` varchar(30) NOT NULL,
  `supplier_ciudad` varchar(30) NOT NULL,
  `supplier_direccion` varchar(70) NOT NULL,
  `supplier_telefono` varchar(20) NOT NULL,
  `supplier_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `provedor`
--

INSERT INTO `provedor` (`supplier_id`, `supplier_nombre`, `supplier_representante`, `supplier_provincia`, `supplier_ciudad`, `supplier_direccion`, `supplier_telefono`, `supplier_email`) VALUES
(1, 'Proveedor General', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'),
(6, 'TECNIL', 'kevin', 'Bolivar', 'Cartagena', 'Libertador cll2B #60B-55', '3215970852', 'kevingomez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `servicio_id` int(20) NOT NULL,
  `servicio_codigo` varchar(77) NOT NULL,
  `servicio_nombre` varchar(100) NOT NULL,
  `producto_stock_total` int(25) NOT NULL,
  `servicio_precio` decimal(30,2) NOT NULL,
  `servicio_estado` varchar(20) NOT NULL,
  `servicio_foto` varchar(500) NOT NULL,
  `categoria_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`servicio_id`, `servicio_codigo`, `servicio_nombre`, `producto_stock_total`, `servicio_precio`, `servicio_estado`, `servicio_foto`, `categoria_id`) VALUES
(3, 'CODEX1212', 'arreglar pantalla', 0, 90000.00, 'Habilitado', 'default.jpg', 20),
(6, 'CODEX4321', 'display samsung', -3, 150000.00, 'Habilitado', 'CODEX4321_21.jpg', 20),
(8, '454545', 'ejemplo', -1, 20000.00, 'Habilitado', '', 20),
(9, 'EXAMP123', 'Ejemplo2', 0, 1000.00, 'Habilitado', '', 20),
(10, 'PAQ0015', 'Paq 15 Host. Email x4', 0, 270000.00, 'Habilitado', '', 21),
(11, 'DOM1', 'Domicilio 1-5km', 1, 8000.00, 'Habilitado', '', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `venta_id` int(30) NOT NULL,
  `venta_codigo` varchar(200) NOT NULL,
  `venta_fecha` date NOT NULL,
  `venta_hora` varchar(17) NOT NULL,
  `venta_total` decimal(30,2) NOT NULL,
  `venta_pagado` decimal(30,2) NOT NULL,
  `venta_cambio` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`venta_id`, `venta_codigo`, `venta_fecha`, `venta_hora`, `venta_total`, `venta_pagado`, `venta_cambio`, `usuario_id`, `cliente_id`, `caja_id`) VALUES
(8, 'M4K2X2F5K4-1', '2024-06-14', '03:59 pm', 151000.00, 151000.00, 0.00, 1, 1, 1),
(9, 'J2R9L6T5R8-2', '2024-06-20', '01:19 pm', 270000.00, 270000.00, 0.00, 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_detalle`
--

CREATE TABLE `servicios_detalle` (
  `venta_detalle_id` int(100) NOT NULL,
  `venta_detalle_cantidad` int(10) NOT NULL,
  `venta_detalle_precio_venta` decimal(30,2) NOT NULL,
  `venta_detalle_total` decimal(30,2) NOT NULL,
  `venta_detalle_descripcion` varchar(200) NOT NULL,
  `venta_codigo` varchar(200) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `servicios_detalle`
--

INSERT INTO `servicios_detalle` (`venta_detalle_id`, `venta_detalle_cantidad`, `venta_detalle_precio_venta`, `venta_detalle_total`, `venta_detalle_descripcion`, `venta_codigo`, `producto_id`) VALUES
(9, 1, 1000.00, 1000.00, 'Ejemplo2', 'M4K2X2F5K4-1', 9),
(10, 1, 150000.00, 150000.00, 'display samsung', 'M4K2X2F5K4-1', 6),
(11, 1, 270000.00, 270000.00, 'Paq 15 Host. Email x4', 'J2R9L6T5R8-2', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(7) NOT NULL,
  `usuario_nombre` varchar(50) NOT NULL,
  `usuario_apellido` varchar(50) NOT NULL,
  `usuario_email` varchar(50) NOT NULL,
  `usuario_usuario` varchar(30) NOT NULL,
  `usuario_clave` varchar(535) NOT NULL,
  `usuario_foto` varchar(200) NOT NULL,
  `caja_id` int(5) NOT NULL,
  `usuario_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `caja_id`, `usuario_rol`) VALUES
(1, 'Administrador', 'Principal', '', 'Administrador', '$2y$10$Jgm6xFb5Onz/BMdIkNK2Tur8yg/NYEMb/tdnhoV7kB1BwIG4R05D2', 'Kevin_43.png', 1, 'Administrador'),
(5, 'Gloria', 'de Dios', 'kevingomezdp2212@gmail.com', 'GloriaDeDios', '$2y$10$6slPPwGl0Y/GPuRCPBA4.OgSzMV1L0Ql1uc0HrepFesJAB0RZxumm', 'Gloria_64.png', 1, 'Admin'),
(7, 'Lubeck', 'Administrador', 'CopierComputer@gmail.com', 'CopierComputer', '$2y$10$zqfY8xexQUHP2BA/u/DKtez5wkh3P3AnRYl3rGgNzqDJuVSExyap6', 'Lubeck_23.jpg', 1, 'Admin'),
(8, 'Laura Sofia', 'Durango Ortiz', 'durangoortizlaurasofia@gmail.com', 'lau1608', '$2y$10$NAZTmNcI1IlvbSIE1zI9ZOEJuza7.Wo8ghIk50Rp/eoh7I6UN1oCW', '', 5, 'Empleado'),
(9, 'Juan Camilo', 'Gomez Rojas', 'juank@gmail.com', 'juankmilo', '$2y$10$BlF5HR5ioDMJ59CvHs/ipegyosXaSSnm3zy6atrdzQxHheIGylR5.', '', 1, 'Cajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `venta_id` int(30) NOT NULL,
  `venta_codigo` varchar(200) NOT NULL,
  `venta_fecha` date NOT NULL,
  `venta_hora` varchar(17) NOT NULL,
  `venta_total` decimal(30,2) NOT NULL,
  `venta_pagado` decimal(30,2) NOT NULL,
  `venta_cambio` decimal(30,2) NOT NULL,
  `usuario_id` int(7) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `caja_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`venta_id`, `venta_codigo`, `venta_fecha`, `venta_hora`, `venta_total`, `venta_pagado`, `venta_cambio`, `usuario_id`, `cliente_id`, `caja_id`) VALUES
(17, 'K1X3N4M5O6-1', '2024-06-07', '01:49 pm', 7000.00, 7000.00, 0.00, 5, 1, 1),
(18, 'F8E5H1Q5D5-2', '2024-06-08', '03:26 pm', 2500.00, 2500.00, 0.00, 1, 1, 1),
(19, 'L8G5W0C8K7-3', '2024-06-15', '02:47 pm', 2500.00, 2500.00, 0.00, 1, 1, 1),
(20, 'R4I5G3F7F1-4', '2024-06-16', '01:47 pm', 1500.00, 2000.00, 500.00, 1, 1, 1),
(21, 'B8G9W7R5K7-5', '2024-03-16', '03:13 pm', 16500.00, 20000.00, 3500.00, 1, 2, 1),
(22, 'F4Q1W2C4W1-6', '2024-06-17', '05:15 pm', 100000.00, 120000.00, 20000.00, 1, 1, 1),
(23, 'T5F6V5L5E8-7', '2024-06-15', '11:58 am', 228000.00, 230000.00, 2000.00, 1, 7, 1),
(25, 'M8Y2V6D9E3-9', '2024-07-09', '01:26 am', 12000.00, 15000.00, 3000.00, 1, 1, 1),
(27, 'S6M0M9J4G5-11', '2024-07-09', '10:32 am', 20000.00, 20000.00, 0.00, 1, 3, 1),
(28, 'O0B3V0I3C1-12', '2024-07-09', '10:33 am', 10000.00, 10000.00, 0.00, 1, 3, 1),
(29, 'G1D8E5V7G2-13', '2024-07-09', '10:33 am', 40000.00, 40000.00, 0.00, 1, 3, 1),
(32, 'E2N7U0V1O8-16', '2024-07-13', '01:15 am', 6000.00, 6000.00, 0.00, 1, 8, 1),
(36, 'X0C9P8W6K5-16', '2024-07-13', '02:47 am', 7000.00, 7000.00, 0.00, 1, 2, 1),
(37, 'N2O1B8I7T7-15', '2024-07-13', '02:28 pm', 6000.00, 6000.00, 0.00, 1, 2, 1),
(38, 'T8V7G7C7A5-16', '2024-07-13', '02:28 pm', 8500.00, 8500.00, 0.00, 1, 1, 1),
(40, 'Q5N7D8Q7A0-18', '2024-07-13', '02:29 pm', 1500.00, 1500.00, 0.00, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `venta_detalle_id` int(100) NOT NULL,
  `venta_detalle_cantidad` int(10) NOT NULL,
  `venta_detalle_precio_compra` decimal(30,2) NOT NULL,
  `venta_detalle_precio_venta` decimal(30,2) NOT NULL,
  `venta_detalle_total` decimal(30,2) NOT NULL,
  `venta_detalle_descripcion` varchar(200) NOT NULL,
  `venta_codigo` varchar(200) NOT NULL,
  `producto_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`venta_detalle_id`, `venta_detalle_cantidad`, `venta_detalle_precio_compra`, `venta_detalle_precio_venta`, `venta_detalle_total`, `venta_detalle_descripcion`, `venta_codigo`, `producto_id`) VALUES
(19, 1, 10.00, 7000.00, 7000.00, 'Electrolit coco 625ml', 'K1X3N4M5O6-1', 33),
(20, 1, 10.00, 2500.00, 2500.00, 'coca', 'F8E5H1Q5D5-2', 53),
(21, 1, 10.00, 2500.00, 2500.00, 'coca', 'L8G5W0C8K7-3', 53),
(22, 1, 10.00, 1500.00, 1500.00, 'Colombiana 400ml', 'R4I5G3F7F1-4', 25),
(23, 10, 10.00, 1500.00, 15000.00, 'Colombiana 400ml', 'B8G9W7R5K7-5', 25),
(24, 1, 10.00, 1500.00, 1500.00, 'Pepsi 500ml', 'B8G9W7R5K7-5', 17),
(25, 10, 10.00, 10000.00, 100000.00, 'Hit Nectar Manzana 1Lt', 'F4Q1W2C4W1-6', 28),
(26, 2, 10000.00, 114000.00, 228000.00, 'Kepra levetiracetam 100mg/ml', 'T5F6V5L5E8-7', 58),
(28, 6, 10.00, 2000.00, 12000.00, 'Cereal Kelloggs Zucaritas 39gr', 'M8Y2V6D9E3-9', 41),
(30, 2, 10.00, 10000.00, 20000.00, 'Hit Nectar Pera 1Lt', 'S6M0M9J4G5-11', 29),
(31, 1, 10.00, 10000.00, 10000.00, 'Hit Nectar Pera 1Lt', 'O0B3V0I3C1-12', 29),
(32, 4, 10.00, 10000.00, 40000.00, 'Hit Nectar Pera 1Lt', 'G1D8E5V7G2-13', 29),
(35, 1, 10.00, 6000.00, 6000.00, 'Hit Frutas Tropicales 1L', 'E2N7U0V1O8-16', 11),
(39, 1, 10.00, 7000.00, 7000.00, 'Electrolit Fresa 625ml', 'X0C9P8W6K5-16', 31),
(40, 1, 10.00, 6000.00, 6000.00, 'Hit Mora 1L', 'N2O1B8I7T7-15', 14),
(41, 1, 10.00, 1500.00, 1500.00, 'Pepsi 500ml', 'T8V7G7C7A5-16', 17),
(42, 1, 10.00, 7000.00, 7000.00, 'Electrolit coco 625ml', 'T8V7G7C7A5-16', 33),
(44, 1, 10.00, 1500.00, 1500.00, 'Colombiana 400ml', 'Q5N7D8Q7A0-18', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `visita_id` int(11) NOT NULL,
  `visita_fecha` date NOT NULL,
  `visita_hora` varchar(17) NOT NULL,
  `visita_estado` varchar(70) NOT NULL,
  `cliente_id` int(10) NOT NULL,
  `visita_direccion` varchar(200) NOT NULL,
  `visita_ref` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `visitas`
--

INSERT INTO `visitas` (`visita_id`, `visita_fecha`, `visita_hora`, `visita_estado`, `cliente_id`, `visita_direccion`, `visita_ref`) VALUES
(1, '2024-07-19', '14:31', 'Pendiente', 5, 'territorio mio', 'Sin Referencia'),
(2, '2024-07-12', '15:17', 'Realizada', 6, 'La Consolata', 'Sin Referencia'),
(3, '2024-07-20', '02:22', 'Pendiente', 7, 'Ciudadela 2000 manzana 6 Lt 36', 'Sin Referencia'),
(4, '2024-07-14', '08:35', 'Pendiente', 3, 'San fernando #45-50B', 'Sin Referencia'),
(6, '2024-07-15', '16:00', 'Pendiente', 7, 'Ciudadela 2000 manzana 6 Lt 36', 'Sin Referencia'),
(7, '2024-07-15', '16:00', 'Pendiente', 7, 'Bosque Cll2 Mnz 3 #45', 'Sin Referencia'),
(8, '2024-08-22', '08:38', 'Pendiente', 8, 'Arboleda Cll2 #45-20D', 'Exito Castellana'),
(10, '2024-07-12', '15:17', 'Realizada', 2, 'La Consolata', 'Sin Referencia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`caja_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `codebar`
--
ALTER TABLE `codebar`
  ADD PRIMARY KEY (`codigo_id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`compra_id`),
  ADD UNIQUE KEY `compra_codigo` (`compra_codigo`) USING BTREE,
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`supplier_id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indices de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD PRIMARY KEY (`compra_detalle_id`),
  ADD KEY `compra_codigo` (`compra_codigo`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`cotizacion_id`),
  ADD KEY `cotizacion_codigo` (`cotizacion_codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `cotizacion_detalle`
--
ALTER TABLE `cotizacion_detalle`
  ADD PRIMARY KEY (`cotizacion_detalle_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `cotizacion_codigo` (`cotizacion_codigo`);

--
-- Indices de la tabla `diseño`
--
ALTER TABLE `diseño`
  ADD PRIMARY KEY (`diseño_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`),
  ADD KEY `logo` (`logo`);

--
-- Indices de la tabla `fecha_finish`
--
ALTER TABLE `fecha_finish`
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `llamada`
--
ALTER TABLE `llamada`
  ADD PRIMARY KEY (`llamada_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`presentacion_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `producto_tipo_unidad` (`producto_tipo_unidad`);

--
-- Indices de la tabla `provedor`
--
ALTER TABLE `provedor`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`servicio_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`venta_id`),
  ADD UNIQUE KEY `venta_codigo` (`venta_codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `servicios_detalle`
--
ALTER TABLE `servicios_detalle`
  ADD PRIMARY KEY (`venta_detalle_id`),
  ADD KEY `venta_codigo` (`venta_codigo`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `caja_id` (`caja_id`),
  ADD KEY `usuario_foto` (`usuario_foto`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`venta_id`),
  ADD UNIQUE KEY `venta_codigo` (`venta_codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `caja_id` (`caja_id`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`venta_detalle_id`),
  ADD KEY `venta_id` (`venta_codigo`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`visita_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `caja_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `codebar`
--
ALTER TABLE `codebar`
  MODIFY `codigo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  MODIFY `compra_detalle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `cotizacion_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15957664;

--
-- AUTO_INCREMENT de la tabla `cotizacion_detalle`
--
ALTER TABLE `cotizacion_detalle`
  MODIFY `cotizacion_detalle_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15957667;

--
-- AUTO_INCREMENT de la tabla `diseño`
--
ALTER TABLE `diseño`
  MODIFY `diseño_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `llamada`
--
ALTER TABLE `llamada`
  MODIFY `llamada_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `presentacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `provedor`
--
ALTER TABLE `provedor`
  MODIFY `supplier_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `servicio_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `venta_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `servicios_detalle`
--
ALTER TABLE `servicios_detalle`
  MODIFY `venta_detalle_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `venta_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `venta_detalle_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `visita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `provedor` (`supplier_id`),
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`);

--
-- Filtros para la tabla `compra_detalle`
--
ALTER TABLE `compra_detalle`
  ADD CONSTRAINT `compra_detalle_ibfk_1` FOREIGN KEY (`compra_codigo`) REFERENCES `compra` (`compra_codigo`),
  ADD CONSTRAINT `compra_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_2` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`),
  ADD CONSTRAINT `cotizaciones_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `cotizaciones_ibfk_4` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`);

--
-- Filtros para la tabla `cotizacion_detalle`
--
ALTER TABLE `cotizacion_detalle`
  ADD CONSTRAINT `cotizacion_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `cotizacion_detalle_ibfk_3` FOREIGN KEY (`cotizacion_codigo`) REFERENCES `cotizaciones` (`cotizacion_codigo`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`logo`) REFERENCES `usuario` (`usuario_foto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `llamada`
--
ALTER TABLE `llamada`
  ADD CONSTRAINT `llamada_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`);

--
-- Filtros para la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD CONSTRAINT `servicio_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`),
  ADD CONSTRAINT `servicios_ibfk_3` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`);

--
-- Filtros para la tabla `servicios_detalle`
--
ALTER TABLE `servicios_detalle`
  ADD CONSTRAINT `servicios_detalle_ibfk_1` FOREIGN KEY (`venta_codigo`) REFERENCES `servicios` (`venta_codigo`),
  ADD CONSTRAINT `servicios_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `servicio` (`servicio_id`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`),
  ADD CONSTRAINT `venta_ibfk_3` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`caja_id`);

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`),
  ADD CONSTRAINT `venta_detalle_ibfk_3` FOREIGN KEY (`venta_codigo`) REFERENCES `venta` (`venta_codigo`);

--
-- Filtros para la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`cliente_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
