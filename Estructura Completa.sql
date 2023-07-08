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

 Date: 08/07/2023 11:02:12
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_categoria
-- ----------------------------

-- ----------------------------
-- Table structure for tba_detallemovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_detallemovimiento`;
CREATE TABLE `tba_detallemovimiento`  (
  `IdDetalleMovimiento` int NOT NULL AUTO_INCREMENT,
  `IdMovimiento` int NOT NULL,
  `IdProducto` int NOT NULL,
  `CantidadMovimiento` int NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdDetalleMovimiento`) USING BTREE,
  INDEX `tba_detallemovimiento_fkMovimiento`(`IdMovimiento`) USING BTREE,
  INDEX `tba_detallemovimiento_fkProducto`(`IdProducto`) USING BTREE,
  CONSTRAINT `tba_detallemovimiento_fkMovimiento` FOREIGN KEY (`IdMovimiento`) REFERENCES `tba_movimiento` (`IdMovimiento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_detallemovimiento_fkProducto` FOREIGN KEY (`IdProducto`) REFERENCES `tba_producto` (`IdProducto`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_detallemovimiento
-- ----------------------------

-- ----------------------------
-- Table structure for tba_movimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_movimiento`;
CREATE TABLE `tba_movimiento`  (
  `IdMovimiento` int NOT NULL AUTO_INCREMENT,
  `IdTipoMovimiento` int NOT NULL,
  `IdTienda` int NOT NULL,
  `IdUsuario` int NOT NULL,
  `CodMovimiento` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `SubTotal` decimal(10, 2) NOT NULL,
  `IGV` decimal(10, 2) NOT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_movimiento
-- ----------------------------

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
  `IdUsuario` int NOT NULL,
  `CodProducto` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DescripcionProducto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `PrecioUnitarioProducto` decimal(10, 2) NOT NULL,
  `PesoProducto` decimal(10, 2) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdProducto`) USING BTREE,
  INDEX `tba_producto_fkCategoria`(`IdCategoria`) USING BTREE,
  INDEX `tba_producto_fkUsuario`(`IdUsuario`) USING BTREE,
  CONSTRAINT `tba_producto_fkCategoria` FOREIGN KEY (`IdCategoria`) REFERENCES `tba_categoria` (`IdCategoria`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_producto
-- ----------------------------

-- ----------------------------
-- Table structure for tba_stock
-- ----------------------------
DROP TABLE IF EXISTS `tba_stock`;
CREATE TABLE `tba_stock`  (
  `IdStock` int NOT NULL AUTO_INCREMENT,
  `IdTienda` int NOT NULL,
  `IdProducto` int NOT NULL,
  `IdUsuario` int NOT NULL,
  `CantidadStock` int NOT NULL,
  `PrecioTotal` decimal(10, 2) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaAcualizacion` datetime NOT NULL,
  PRIMARY KEY (`IdStock`) USING BTREE,
  INDEX `tba_stock_fkTienda`(`IdTienda`) USING BTREE,
  INDEX `tba_stock_fkProducto`(`IdProducto`) USING BTREE,
  INDEX `tba_stock_fkUsuario`(`IdUsuario`) USING BTREE,
  CONSTRAINT `tba_stock_fkProducto` FOREIGN KEY (`IdProducto`) REFERENCES `tba_producto` (`IdProducto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_stock_fkTienda` FOREIGN KEY (`IdTienda`) REFERENCES `tba_tienda` (`IdTienda`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tba_stock_fkUsuario` FOREIGN KEY (`IdUsuario`) REFERENCES `tba_usuario` (`IdUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_stock
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_tienda
-- ----------------------------

-- ----------------------------
-- Table structure for tba_tipomovimiento
-- ----------------------------
DROP TABLE IF EXISTS `tba_tipomovimiento`;
CREATE TABLE `tba_tipomovimiento`  (
  `IdTipoMovimiento` int NOT NULL AUTO_INCREMENT,
  `NombreMovimiento` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`IdTipoMovimiento`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_tipomovimiento
-- ----------------------------

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
  `CelularUsuario` int NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `FechaActualizacion` datetime NOT NULL,
  `UltimaConexion` datetime NOT NULL,
  PRIMARY KEY (`IdUsuario`) USING BTREE,
  INDEX `tba_usuario_fkPerfilUsuario`(`IdPerfilUsuario`) USING BTREE,
  CONSTRAINT `tba_usuario_fkPerfilUsuario` FOREIGN KEY (`IdPerfilUsuario`) REFERENCES `tba_perfilusuario` (`IdPerfilUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tba_usuario
-- ----------------------------
INSERT INTO `tba_usuario` VALUES (1, 1, 'Administrador', 'admin@gmail.com', '$2a$07$usesomesillystringforeh6tvwDNOAiEn9PYXfY79K3vDiKj6Ib6', 987654321, '2023-07-08 10:22:24', '2023-07-08 10:22:26', '2023-07-08 10:23:56');

SET FOREIGN_KEY_CHECKS = 1;
