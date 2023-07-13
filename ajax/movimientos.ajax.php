<?php

require_once "../controller/ingresos.controller.php";
require_once "../controller/salidas.controller.php";
require_once "../model/ingresos.model.php";
require_once "../model/salidas.model.php";

class AjaxMovimientos
{
  //  Devolver detalle del ingreso
  public $codMovimientoVisualizarIngreso;
  public function ajaxMostrarDetalleMovimientoIngreso()
  {
    $codMovimientoVisualizarIngreso = $this->codMovimientoVisualizarIngreso;
    $respuesta = ControllerIngresos::ctrMostrarDetalleIngreso($codMovimientoVisualizarIngreso);
    echo json_encode($respuesta);
  }

  //  Devolver detalle de la salida
  public $codMovimientoVisualizarSalida;
  public function ajaxMostrarDetalleMovimientoSalida()
  {
    $codMovimientoVisualizarSalida = $this->codMovimientoVisualizarSalida;
    $respuesta = ControllerSalidas::ctrMostrarDetalleSalida($codMovimientoVisualizarSalida);
    echo json_encode($respuesta);
  }
}

//  Visualizar Ingreso
if(isset($_POST["codMovimientoVisualizarIngreso"])){
	$mostrarMovimiento = new AjaxMovimientos();
	$mostrarMovimiento -> codMovimientoVisualizarIngreso = $_POST["codMovimientoVisualizarIngreso"];
	$mostrarMovimiento -> ajaxMostrarDetalleMovimientoIngreso();
}

//  Visualizar Salida
if(isset($_POST["codMovimientoVisualizarSalida"])){
	$mostrarMovimiento = new AjaxMovimientos();
	$mostrarMovimiento -> codMovimientoVisualizarSalida = $_POST["codMovimientoVisualizarSalida"];
	$mostrarMovimiento -> ajaxMostrarDetalleMovimientoSalida();
}

