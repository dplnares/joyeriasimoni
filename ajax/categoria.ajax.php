<?php

require_once "../controller/categoria.controller.php";
require_once "../model/categoria.model.php";

class AjaxCategoria
{
  //  Editar Tienda
  public $codCategoria;
  public function ajaxEditarCategoria()
  {
    $codCategoria = $this->codCategoria;
    $respuesta = ControllerCategorias::ctrMostrarDatosEditar($codCategoria);
    echo json_encode($respuesta);
  }
}

//  Editar Tienda
if(isset($_POST["codCategoria"])){
	$editar = new AjaxCategoria();
	$editar -> codCategoria = $_POST["codCategoria"];
	$editar -> ajaxEditarCategoria();
}