<?php

require_once "../controller/producto.controller.php";
require_once "../model/producto.model.php";

class AjaxProductos
{
  //  Editar Producto
  public $codProducto;
  public function ajaxEditarProducto()
  {
    $codProducto = $this->codProducto;
    $respuesta = ControllerProductos::ctrMostrarDatosEditar($codProducto);
    echo json_encode($respuesta);
  }
}

//  Editar Producto
if(isset($_POST["codProducto"])){
	$editar = new AjaxProductos();
	$editar -> codProducto = $_POST["codProducto"];
	$editar -> ajaxEditarProducto();
}