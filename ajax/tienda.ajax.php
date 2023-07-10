<?php

require_once "../controller/tienda.controller.php";
require_once "../model/tienda.model.php";

class AjaxTienda
{
  //  Editar Tienda
  public $codTienda;
  public function ajaxEditarTienda()
  {
    $codTienda = $this->codTienda;
    $respuesta = ControllerTiendas::ctrMostrarDatosEditar($codTienda);
    echo json_encode($respuesta);
  }
}

//  Editar Tienda
if(isset($_POST["codTienda"])){
	$editar = new AjaxTienda();
	$editar -> codTienda = $_POST["codTienda"];
	$editar -> ajaxEditarTienda();
}