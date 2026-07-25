-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2026 a las 03:02:33
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
-- Base de datos: `sistema_facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` char(2) NOT NULL,
  `nomcategoria` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `nomcategoria`) VALUES
('01', 'Lácteos'),
('02', 'Bebidas'),
('03', 'Abarrotes'),
('04', 'Limpieza'),
('05', 'Embutidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` varchar(10) NOT NULL,
  `nomcliente` varchar(128) DEFAULT NULL,
  `ruccliente` varchar(11) DEFAULT NULL,
  `dircliente` varchar(128) DEFAULT NULL,
  `telcliente` varchar(9) DEFAULT NULL,
  `emailcliente` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nomcliente`, `ruccliente`, `dircliente`, `telcliente`, `emailcliente`) VALUES
('CLI0000001', 'Comercial El Sol S.A.C.', '20123456781', 'Av. Ejército 123, Arequipa', '954123456', 'contacto@elsol.com'),
('CLI0000002', 'Distribuidora San Juan', '20876543212', 'Calle Mercaderes 456', '987654321', 'ventas@sanjuan.pe'),
('CLI0000003', 'Tiendas El Progreso', '20555444333', 'Av. Dolores 789', '912345678', 'informes@elprogreso.com'),
('CLI0000004', 'Juan Carlos Mendoza', '10456789123', 'Urb. Yanahuara Mz B Lt 4', '934567890', 'jmendoza@gmail.com'),
('CLI0000005', 'Botica y Minimarket Luz', '20444333221', 'Av. Porongoche 321', '943210987', 'luz_minimarket@hotmail.com'),
('CLI0000006', 'Ana María Flores', '10987654321', 'Calle Jerusalén 102', '965432109', 'aflores@gmail.com'),
('CLI0000007', 'Supermercado Misti', '20999888777', 'Av. Cayma 555', '976543210', 'compras@misti.com'),
('CLI0000008', 'Gaston Acurio EIRL', '20333222111', 'Av. Parra 888', '921098765', 'contacto@gaston.pe'),
('CLI0000009', 'Cevichería El Marinero', '20777666555', 'Av. Salaverry 234', '989012345', 'elmarinero@gmail.com'),
('CLI0000010', 'Lucía Paredes Silva', '10234567890', 'Calle Paucarpata 612', '910987654', 'lparedes@outlook.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicionventa`
--

CREATE TABLE `condicionventa` (
  `idcondicion` char(2) NOT NULL,
  `nomcondicion` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicionventa`
--

INSERT INTO `condicionventa` (`idcondicion`, `nomcondicion`) VALUES
('01', 'Contado'),
('02', 'Crédito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `iddetalle` int(11) NOT NULL,
  `idfactura` int(11) DEFAULT NULL,
  `idproducto` varchar(10) DEFAULT NULL,
  `cant` int(11) DEFAULT NULL,
  `cosuni` decimal(19,4) DEFAULT NULL,
  `preuni` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`iddetalle`, `idfactura`, `idproducto`, `cant`, `cosuni`, `preuni`) VALUES
(1, 1, 'PROD000001', 10, 3.2000, 4.2000),
(2, 1, 'PROD000009', 20, 2.1000, 3.0000),
(3, 2, 'PROD000003', 30, 4.0000, 6.0000),
(4, 2, 'PROD000002', 10, 6.5000, 8.5000),
(5, 3, 'PROD000001', 50, 3.2000, 4.2000),
(6, 3, 'PROD000003', 40, 4.0000, 6.0000),
(7, 3, 'PROD000006', 10, 12.0000, 16.5000),
(8, 4, 'PROD000008', 5, 3.8000, 5.5000),
(9, 4, 'PROD000010', 10, 1.8000, 2.8000),
(10, 5, 'PROD000002', 50, 6.5000, 8.5000),
(11, 5, 'PROD000004', 30, 8.0000, 11.5000),
(12, 5, 'PROD000005', 25, 7.5000, 10.0000),
(13, 6, 'PROD000007', 20, 4.5000, 6.2000),
(14, 6, 'PROD000009', 50, 2.1000, 3.0000),
(15, 7, 'PROD000008', 15, 3.8000, 5.5000),
(16, 7, 'PROD000010', 20, 1.8000, 2.8000),
(17, 8, 'PROD000003', 100, 4.0000, 6.0000),
(18, 8, 'PROD000001', 30, 3.2000, 4.2000),
(19, 9, 'PROD000005', 20, 7.5000, 10.0000),
(20, 9, 'PROD000006', 10, 12.0000, 16.5000),
(21, 10, 'PROD000002', 40, 6.5000, 8.5000),
(22, 10, 'PROD000004', 20, 8.0000, 11.5000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idfactura` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `idcliente` varchar(10) DEFAULT NULL,
  `idusuario` varchar(3) DEFAULT NULL,
  `fechareg` datetime DEFAULT NULL,
  `idcondicion` char(2) DEFAULT NULL,
  `valorventa` decimal(10,4) DEFAULT NULL,
  `igv` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`idfactura`, `fecha`, `idcliente`, `idusuario`, `fechareg`, `idcondicion`, `valorventa`, `igv`) VALUES
(1, '2026-07-01', 'CLI0000001', 'U02', '2026-07-01 10:30:00', '01', 102.0000, 18.3600),
(2, '2026-07-02', 'CLI0000002', 'U02', '2026-07-02 11:15:00', '02', 265.0000, 47.7000),
(3, '2026-07-05', 'CLI0000001', 'U03', '2026-07-05 15:40:00', '01', 615.0000, 110.7000),
(4, '2026-07-10', 'CLI0000004', 'U02', '2026-07-10 09:20:00', '01', 55.5000, 9.9900),
(5, '2026-07-12', 'CLI0000007', 'U03', '2026-07-12 16:10:00', '02', 1020.0000, 183.6000),
(6, '2026-07-15', 'CLI0000003', 'U02', '2026-07-15 12:00:00', '01', 274.0000, 49.3200),
(7, '2026-07-18', 'CLI0000005', 'U03', '2026-07-18 17:05:00', '01', 138.5000, 24.9300),
(8, '2026-07-20', 'CLI0000007', 'U02', '2026-07-20 10:45:00', '02', 726.0000, 130.6800),
(9, '2026-07-22', 'CLI0000008', 'U03', '2026-07-22 14:30:00', '01', 365.0000, 65.7000),
(10, '2026-07-24', 'CLI0000002', 'U02', '2026-07-24 18:00:00', '01', 570.0000, 102.6000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` varchar(10) NOT NULL,
  `idproveedor` varchar(3) DEFAULT NULL,
  `nomproducto` varchar(128) DEFAULT NULL,
  `unimed` varchar(15) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `cosuni` decimal(10,4) DEFAULT NULL,
  `preuni` decimal(10,4) DEFAULT NULL,
  `idcategoria` char(2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `idproveedor`, `nomproducto`, `unimed`, `stock`, `cosuni`, `preuni`, `idcategoria`, `estado`) VALUES
('PROD000001', 'P01', 'Leche Evaporada 400g', 'Lata', 150, 3.2000, 4.2000, '01', '1'),
('PROD000002', 'P02', 'Aceite Vegetal 1L', 'Botella', 80, 6.5000, 8.5000, '03', '1'),
('PROD000003', 'P03', 'Cerveza Pilsen 620ml', 'Botella', 200, 4.0000, 6.0000, '02', '1'),
('PROD000004', 'P04', 'Detergente en Polvo 1kg', 'Bolsa', 60, 8.0000, 11.5000, '04', '1'),
('PROD000005', 'P05', 'Jamón del País 250g', 'Empaque', 40, 7.5000, 10.0000, '05', '1'),
('PROD000006', 'P06', 'Café Instantáneo 200g', 'Frasco', 50, 12.0000, 16.5000, '03', '1'),
('PROD000007', 'P07', 'Yogurt Fresa 1L', 'Botella', 90, 4.5000, 6.2000, '01', '1'),
('PROD000008', 'P08', 'Crema Dental 100ml', 'Caja', 120, 3.8000, 5.5000, '04', '1'),
('PROD000009', 'P09', 'Fideos Tallarín 500g', 'Bolsa', 300, 2.1000, 3.0000, '03', '1'),
('PROD000010', 'P10', 'Jabón de Tocador 90g', 'Unidad', 100, 1.8000, 2.8000, '04', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` varchar(3) NOT NULL,
  `nomproveedor` varchar(128) DEFAULT NULL,
  `rucproveedor` varchar(11) DEFAULT NULL,
  `dirproveedor` varchar(128) DEFAULT NULL,
  `telproveedor` varchar(9) DEFAULT NULL,
  `emailproveedor` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `nomproveedor`, `rucproveedor`, `dirproveedor`, `telproveedor`, `emailproveedor`) VALUES
('P01', 'Gloria S.A.', '20100018625', 'Av. Industrial 456, Lima', '911111111', 'ventas@gloria.com.pe'),
('P02', 'Alicorp S.A.A.', '20100055237', 'Av. Argentina 4793, Callao', '922222222', 'contacto@alicorp.com.pe'),
('P03', 'Backus y Johnston', '20100113610', 'Av. Alfonso Ugarte 800', '933333333', 'pedidos@backus.pe'),
('P04', 'Procter & Gamble Perú', '20100125898', 'Av. Materiales 2030', '944444444', 'atencion@pg.com'),
('P05', 'San Fernando S.A.', '20100154308', 'Av. República de Panamá', '955555555', 'ventas@san-fernando.com.pe'),
('P06', 'Nestlé Perú S.A.', '20100168350', 'Av. Las Begonias 441', '966666666', 'servicio@nestle.com.pe'),
('P07', 'Laive S.A.', '20100095499', 'Av. Nicolás de Piérola 601', '977777777', 'contacto@laive.pe'),
('P08', 'Colgate-Palmolive Perú', '20100023410', 'Av. Primavera 120', '988888888', 'soporte@colgate.com'),
('P09', 'Molitalia S.A.', '20100034521', 'Av. Venezuela 2850', '999999999', 'pedidos@molitalia.com.pe'),
('P10', 'Unilever Andina Perú', '20100045632', 'Av. Paseo de la República', '900000000', 'contacto@unilever.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` varchar(3) NOT NULL,
  `nomusuario` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `apellidos` varchar(64) DEFAULT NULL,
  `nombres` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nomusuario`, `password`, `apellidos`, `nombres`, `email`, `estado`) VALUES
('U01', 'admin', '123456', 'Pérez', 'Juan', 'admin@correo.com', '1'),
('U02', 'vendedor1', '123456', 'Pérez Gómez', 'Carlos', 'cperez@sistema.com', '1'),
('U03', 'cajero1', '123456', 'López Torres', 'María', 'mlopez@sistema.com', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `condicionventa`
--
ALTER TABLE `condicionventa`
  ADD PRIMARY KEY (`idcondicion`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`iddetalle`),
  ADD KEY `fk_detalle_factura` (`idfactura`),
  ADD KEY `fk_detalle_producto` (`idproducto`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idfactura`),
  ADD KEY `fk_factura_cliente` (`idcliente`),
  ADD KEY `fk_factura_usuario` (`idusuario`),
  ADD KEY `fk_factura_condicion` (`idcondicion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_producto_proveedor` (`idproveedor`),
  ADD KEY `fk_producto_categoria` (`idcategoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `idfactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `fk_detalle_factura` FOREIGN KEY (`idfactura`) REFERENCES `facturas` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_factura_cliente` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_condicion` FOREIGN KEY (`idcondicion`) REFERENCES `condicionventa` (`idcondicion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_proveedor` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`idproveedor`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
