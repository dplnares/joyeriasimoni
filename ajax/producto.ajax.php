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

  //  Agregar Producto al detalle del ingreso
  public $idProductoIngreso;
  public function ajaxListarProductosIngreso()
  {
    $idProductoIngreso = $this->idProductoIngreso;
    $respuesta = ControllerProductos::ctrMostrarDatosProducto($idProductoIngreso);
    echo json_encode($respuesta);
  }

  //  Agregar Producto al detalle de la salida
  public $idProductoSalida;
  public function ajaxListarProductosSalida()
  {
    $idProductoSalida = $this->idProductoSalida;
    $respuesta = ControllerProductos::ctrMostrarDatosProducto($idProductoSalida);
    echo json_encode($respuesta);
  }
}

//  Editar Producto
if(isset($_POST["codProducto"])){
	$editar = new AjaxProductos();
	$editar -> codProducto = $_POST["codProducto"];
	$editar -> ajaxEditarProducto();
}

//  Agregar Producto al detalle del ingreso
if(isset($_POST["idProductoIngreso"])){
  $listaProductoIngreso = new AjaxProductos();
	$listaProductoIngreso -> idProductoIngreso = $_POST["idProductoIngreso"];
	$listaProductoIngreso -> ajaxListarProductosIngreso();
}

//  Agregar Producto al detalle de la salida
if(isset($_POST["idProductoSalida"])){
  $listarProductoSalida = new AjaxProductos();
	$listarProductoSalida -> idProductoSalida = $_POST["idProductoSalida"];
	$listarProductoSalida -> ajaxListarProductosSalida();
}