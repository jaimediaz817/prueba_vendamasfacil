-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2019 a las 04:51:15
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_virtual_practica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_producto`
--

CREATE TABLE `categorias_producto` (
  `cate_id_pk` int(11) NOT NULL,
  `cate_nombres` varchar(100) NOT NULL,
  `cate_estado` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias_producto`
--

INSERT INTO `categorias_producto` (`cate_id_pk`, `cate_nombres`, `cate_estado`) VALUES
(1, 'joyas', 1),
(2, 'calzado', 1),
(3, 'camisetas', 1),
(4, 'Tecnología', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `prod_id_pk` int(11) NOT NULL,
  `cate_id_fk` int(11) DEFAULT NULL,
  `prod_nombres` varchar(45) DEFAULT NULL,
  `prod_descripcion` varchar(200) DEFAULT NULL,
  `prod_peso` decimal(5,3) DEFAULT NULL,
  `prod_cantidad` int(11) DEFAULT NULL,
  `prod_tipo_publicacion` varchar(45) DEFAULT NULL,
  `prod_estado` int(11) DEFAULT '1',
  `prod_fecha_publicacion` date DEFAULT NULL,
  `prod_estado_publicacion` int(11) DEFAULT '0',
  `prod_precio_usd` decimal(5,2) DEFAULT NULL,
  `prod_precio_publicacion` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`prod_id_pk`, `cate_id_fk`, `prod_nombres`, `prod_descripcion`, `prod_peso`, `prod_cantidad`, `prod_tipo_publicacion`, `prod_estado`, `prod_fecha_publicacion`, `prod_estado_publicacion`, `prod_precio_usd`, `prod_precio_publicacion`) VALUES
(29, 2, 'Tenis Nike', 'importados de la USA', '10.000', 1, '01', 1, '2019-04-13', 1, '5.00', '328900.00'),
(30, 3, 'Camibuso Lacose', 'bbb', '11.000', 1, '01', 1, '2019-04-12', 1, '25.00', '423900.00'),
(31, 3, 'Camisa Arturo calle', 'Almacenes de cadena colombia S.A', '13.000', 2, '01', 1, '2019-04-12', 1, '35.00', '516900.00'),
(32, 2, 'Tenis Diesel', 'Importados de la china', '12.000', 1, '02', 1, '2019-04-11', 1, '45.00', '516900.00'),
(33, 1, 'Cadena Plata', 'Importada de Eurpa', '2.800', 1, '02', 1, '2019-04-13', 1, '100.00', '688900.00'),
(34, 3, 'Camiseta deportiva', 'Adidas importada', '22.000', 1, '01', 1, '2019-04-10', 1, '20.00', '752900.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usua_id_pk` int(11) NOT NULL,
  `usua_login` varchar(45) NOT NULL,
  `usua_password` varchar(200) NOT NULL,
  `usua_estado` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usua_id_pk`, `usua_login`, `usua_password`, `usua_estado`) VALUES
(1, 'jdiaz', '81dc9bdb52d04dc20036dbd8313ed055', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  ADD PRIMARY KEY (`cate_id_pk`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`prod_id_pk`),
  ADD KEY `fk_categorias_producto_idx` (`cate_id_fk`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usua_id_pk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_producto`
--
ALTER TABLE `categorias_producto`
  MODIFY `cate_id_pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `prod_id_pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usua_id_pk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categorias_producto` FOREIGN KEY (`cate_id_fk`) REFERENCES `categorias_producto` (`cate_id_pk`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
