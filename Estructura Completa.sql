/*
 Navicat Premium Data Transfer

 Source Server         : MyDBSQL
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : db_joyeriasimoni

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 13/07/2023 17:41:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tba_categoria
-- ----------------------------
DROP TABLE IF EXISTS `tba_categoria`;
CREATE TABLE `tba_categoria`  (
  `IdCategoria` int NOT NULL AUTO_INCREMENT,
  `CodCategoria` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NombreCategoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DescripcionCategoria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdCategoria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_categoria
-- ----------------------------
INSERT INTO `tba_categoria` VALUES (1, 'ANL', 'ANILLOS', 'ANILLOS DE TODO TIPO DE MATERIAL', '2023-07-10 10:28:29', '2023-07-10 10:28:33');
INSERT INTO `tba_categoria` VALUES (2, 'PLS', 'PULSERAS', 'PULSERAS DE ORO', '2023-07-10 00:00:00', '2023-07-10 00:00:00');

-- ----------------------------
-- Table structure for tba_detallemovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_detallemovimiento`;
CREATE TABLE `tba_detallemovimiento`  (
  `IdDetalleMovimiento` int NOT NULL AUTO_INCREMENT,
  `IdMovimiento` int NOT NULL,
  `IdProducto` int NOT NULL,
  `CantidadMovimiento` int NOT NULL,
  `PrecioUnitario` decimal(10, 2) NOT NULL,
  `ParcialTotal` decimal(10, 2) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdDetalleMovimiento`) USING BTREE,
  INDEX `tba_detallemovimiento_fkMovimiento`(`IdMovimiento`) USING BTREE,
  INDEX `tba_detallemovimiento_fkProducto`(`IdProducto`) USING BTREE,
  CONSTRAINT `tba_detallemovimiento_fkMovimiento` FOREIGN KEY (`IdMovimiento`) REFERENCES `tba_movimiento` (`IdMovimiento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_detallemovimiento_fkProducto` FOREIGN KEY (`IdProducto`) REFERENCES `tba_producto` (`IdProducto`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_detallemovimiento
-- ----------------------------
INSERT INTO `tba_detallemovimiento` VALUES (1, 10, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (2, 11, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (3, 12, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (4, 13, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (5, 14, 2, 2, 123.00, 246.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (6, 15, 2, 2, 123.00, 246.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (7, 16, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (8, 17, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (9, 18, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (10, 19, 2, 23, 123.00, 2829.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (11, 20, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (12, 21, 2, 3, 123.00, 369.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (13, 22, 1, 4, 150.00, 600.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (14, 23, 1, 5, 150.00, 750.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (15, 23, 2, 5, 123.00, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (16, 24, 2, 8, 123.00, 984.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');
INSERT INTO `tba_detallemovimiento` VALUES (17, 25, 1, 8, 150.00, 1200.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');

-- ----------------------------
-- Table structure for tba_movimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_movimiento`;
CREATE TABLE `tba_movimiento`  (
  `IdMovimiento` int NOT NULL AUTO_INCREMENT,
  `IdTipoMovimiento` int NOT NULL,
  `IdTienda` int NOT NULL,
  `IdUsuario` int NOT NULL,
  `NumeroDocumento` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NombreProveedor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `NombreCliente` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `SubTotal` decimal(10, 2) NULL DEFAULT NULL,
  `IGV` decimal(10, 2) NULL DEFAULT NULL,
  `Total` decimal(10, 2) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdMovimiento`) USING BTREE,
  INDEX `tba_movimiento_fkTipoMovimiento`(`IdTipoMovimiento`) USING BTREE,
  INDEX `tba_movimiento_fkTienda`(`IdTienda`) USING BTREE,
  INDEX `tba_movimiento_fkUsuario`(`IdUsuario`) USING BTREE,
  CONSTRAINT `tba_movimiento_fkTienda` FOREIGN KEY (`IdTienda`) REFERENCES `tba_tienda` (`IdTienda`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_movimiento_fkTipoMovimiento` FOREIGN KEY (`IdTipoMovimiento`) REFERENCES `tba_tipomovimiento` (`IdTipoMovimiento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_movimiento_fkUsuario` FOREIGN KEY (`IdUsuario`) REFERENCES `tba_usuario` (`IdUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_movimiento
-- ----------------------------
INSERT INTO `tba_movimiento` VALUES (4, 1, 1, 1, '001-0001', 'Don Pedro', NULL, 100.00, 18.00, 118.00, '2023-07-18 17:20:29', '2023-07-18 17:20:32');
INSERT INTO `tba_movimiento` VALUES (5, 1, 1, 1, '001-002121', 'Don Jose', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (6, 1, 1, 1, '001-00212133', 'Don Mario', NULL, NULL, NULL, 492.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (7, 1, 1, 1, '001-002555', 'Don Mario', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (8, 1, 1, 1, '001-6666', 'Don Marioa', NULL, NULL, NULL, 738.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (9, 1, 1, 1, '001-9999', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (10, 1, 1, 1, '001-9999', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (11, 1, 1, 1, '001-9999', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (12, 1, 1, 1, '001-9999', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (13, 1, 1, 1, '001-9999', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (14, 1, 1, 1, '001-1231231', 'Don Carlos', NULL, NULL, NULL, 246.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (15, 1, 1, 1, '001-1231231', 'Don Carlos', NULL, NULL, NULL, 246.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (16, 1, 1, 1, '001-2345234', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (17, 1, 1, 1, '001-0025551231', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (18, 1, 1, 1, '001-0025551231', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (19, 1, 1, 1, '001-6666', 'Don Carlos', NULL, NULL, NULL, 2829.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (20, 1, 1, 1, '001-00212133123', 'Don Carlos', NULL, NULL, NULL, 615.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (21, 1, 1, 1, '001-99991231', 'Don Carlos', NULL, NULL, NULL, 369.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (22, 1, 1, 1, '001-9999', 'Don Mario', NULL, NULL, NULL, 600.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (23, 1, 1, 1, '001-6666', 'Don Carlos', NULL, NULL, NULL, 1365.00, '2023-07-12 00:00:00', '2023-07-12 00:00:00');
INSERT INTO `tba_movimiento` VALUES (24, 2, 1, 1, '001-45645', NULL, 'Carlos', NULL, NULL, 984.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');
INSERT INTO `tba_movimiento` VALUES (25, 1, 3, 1, '001-9999', 'Don Jose', NULL, NULL, NULL, 0.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');

-- ----------------------------
-- Table structure for tba_perfilusuario
-- ----------------------------
DROP TABLE IF EXISTS `tba_perfilusuario`;
CREATE TABLE `tba_perfilusuario`  (
  `IdPerfilUsuario` int NOT NULL AUTO_INCREMENT,
  `NombrePerfil` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IdPerfilUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_perfilusuario
-- ----------------------------
INSERT INTO `tba_perfilusuario` VALUES (1, 'Administrador');
INSERT INTO `tba_perfilusuario` VALUES (2, 'Vendedor');

-- ----------------------------
-- Table structure for tba_producto
-- ----------------------------
DROP TABLE IF EXISTS `tba_producto`;
CREATE TABLE `tba_producto`  (
  `IdProducto` int NOT NULL AUTO_INCREMENT,
  `IdCategoria` int NOT NULL,
  `CodProducto` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DescripcionProducto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PrecioUnitarioProducto` decimal(10, 2) NOT NULL,
  `PesoProducto` decimal(10, 2) NOT NULL,
  `CreadoUsuario` int NOT NULL,
  `ActualizaUsuario` int NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdProducto`) USING BTREE,
  INDEX `tba_producto_fkCategoria`(`IdCategoria`) USING BTREE,
  INDEX `tba_producto_fkUsuario`(`CreadoUsuario`) USING BTREE,
  CONSTRAINT `tba_producto_fkCategoria` FOREIGN KEY (`IdCategoria`) REFERENCES `tba_categoria` (`IdCategoria`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_producto
-- ----------------------------
INSERT INTO `tba_producto` VALUES (1, 1, 'AMBARRRR', 'ANILLO DE AMBAR', 150.00, 20.00, 1, 0, '2023-07-10 11:27:38', '2023-07-10 00:00:00');
INSERT INTO `tba_producto` VALUES (2, 2, 'AAA', 'RELOJ X', 123.00, 1.00, 1, 12, '2023-07-10 00:00:00', '2023-07-10 00:00:00');

-- ----------------------------
-- Table structure for tba_stock
-- ----------------------------
DROP TABLE IF EXISTS `tba_stock`;
CREATE TABLE `tba_stock`  (
  `IdStock` int NOT NULL AUTO_INCREMENT,
  `IdTienda` int NOT NULL,
  `IdProducto` int NOT NULL,
  `CantidadIngresos` int NOT NULL,
  `CantidadSalidas` int NOT NULL,
  `CantidadActual` int NOT NULL,
  `PrecioUnitario` float(10, 2) NOT NULL,
  `PrecioTotal` decimal(10, 2) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdStock`) USING BTREE,
  INDEX `tba_stock_fkTienda`(`IdTienda`) USING BTREE,
  INDEX `tba_stock_fkProducto`(`IdProducto`) USING BTREE,
  CONSTRAINT `tba_stock_fkProducto` FOREIGN KEY (`IdProducto`) REFERENCES `tba_producto` (`IdProducto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_stock_fkTienda` FOREIGN KEY (`IdTienda`) REFERENCES `tba_tienda` (`IdTienda`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_stock
-- ----------------------------
INSERT INTO `tba_stock` VALUES (1, 1, 2, 53, 8, 45, 123.00, 984.00, '2023-07-12 00:00:00', '2023-07-14 00:00:00');
INSERT INTO `tba_stock` VALUES (2, 1, 1, 4, 0, 4, 150.00, 1350.00, '2023-07-12 00:00:00', '2023-07-14 00:00:00');
INSERT INTO `tba_stock` VALUES (3, 3, 1, 12, 0, 12, 150.00, 1800.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');
INSERT INTO `tba_stock` VALUES (4, 3, 2, 3, 0, 3, 123.00, 369.00, '2023-07-13 00:00:00', '2023-07-13 00:00:00');

-- ----------------------------
-- Table structure for tba_tienda
-- ----------------------------
DROP TABLE IF EXISTS `tba_tienda`;
CREATE TABLE `tba_tienda`  (
  `IdTienda` int NOT NULL AUTO_INCREMENT,
  `CodTienda` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NombreTienda` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdTienda`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_tienda
-- ----------------------------
INSERT INTO `tba_tienda` VALUES (1, 'TND-01', 'TIENDA 1', '2023-07-11 09:40:16', '2023-07-11 09:40:20');
INSERT INTO `tba_tienda` VALUES (3, 'TND-02', 'TIENDA 2', '2023-07-10 00:00:00', '2023-07-10 00:00:00');

-- ----------------------------
-- Table structure for tba_tipomovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_tipomovimiento`;
CREATE TABLE `tba_tipomovimiento`  (
  `IdTipoMovimiento` int NOT NULL AUTO_INCREMENT,
  `NombreMovimiento` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`IdTipoMovimiento`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_tipomovimiento
-- ----------------------------
INSERT INTO `tba_tipomovimiento` VALUES (1, 'Ingresos');
INSERT INTO `tba_tipomovimiento` VALUES (2, 'Salidas');

-- ----------------------------
-- Table structure for tba_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tba_usuario`;
CREATE TABLE `tba_usuario`  (
  `IdUsuario` int NOT NULL AUTO_INCREMENT,
  `IdPerfilUsuario` int NOT NULL,
  `NombreUsuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CorreoUsuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PasswordUsuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `CelularUsuario` int NULL DEFAULT NULL,
  `FechaCreacion` date NOT NULL,
  `FechaActualizacion` date NOT NULL,
  `UltimaConexion` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`) USING BTREE,
  INDEX `tba_usuario_fkPerfilUsuario`(`IdPerfilUsuario`) USING BTREE,
  CONSTRAINT `tba_usuario_fkPerfilUsuario` FOREIGN KEY (`IdPerfilUsuario`) REFERENCES `tba_perfilusuario` (`IdPerfilUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_usuario
-- ----------------------------
INSERT INTO `tba_usuario` VALUES (1, 1, 'Administrador', 'admin@gmail.com', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 987654321, '2023-07-08', '2023-07-08', '2023-07-13 15:10:09');

SET FOREIGN_KEY_CHECKS = 1;
