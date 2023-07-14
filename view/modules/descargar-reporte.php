<?php

require_once "../../controller/categoria.controller.php";
require_once "../../controller/ingresos.controller.php";
require_once "../../controller/producto.controller.php";
require_once "../../controller/salidas.controller.php";
require_once "../../controller/stock.controller.php";
require_once "../../controller/tienda.controller.php";
require_once "../../controller/reportes.controller.php";

require_once "../../model/categoria.model.php";
require_once "../../model/ingresos.model.php";
require_once "../../model/producto.model.php";
require_once "../../model/salidas.model.php";
require_once "../../model/stock.model.php";
require_once "../../model/tienda.model.php";


//  Exportar reporte de stock por tienda
if(isset($_GET["reporteStockTienda"]))
{
	$reporteStockTienda = new ControllerReportes();
	$reporteStockTienda -> ctrDescargarReporteStock($_GET["reporteStockTienda"]);
}