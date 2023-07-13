<?php 

//  Librerias
//  require_once "library/PhpSpreadsheet\src\PhpSpreadsheet\Writer\Xlsx";

//  Controllers
require_once "controller/plantilla.controller.php";
require_once "controller/usuarios.controller.php";
require_once "controller/tienda.controller.php";
require_once "controller/categoria.controller.php";
require_once "controller/producto.controller.php";
require_once "controller/stock.controller.php";
require_once "controller/ingresos.controller.php";
require_once "controller/salidas.controller.php";

//  Models
require_once "model/usuarios.model.php";
require_once "model/tienda.model.php";
require_once "model/categoria.model.php";
require_once "model/producto.model.php";
require_once "model/stock.model.php";
require_once "model/ingresos.model.php";
require_once "model/salidas.model.php";

$plantilla = new ControllerPlantilla();
$plantilla -> ctrPlantilla();