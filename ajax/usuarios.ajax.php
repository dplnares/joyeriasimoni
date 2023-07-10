<?php

require_once "../controller/usuarios.controller.php";
require_once "../model/usuarios.model.php";

class AjaxUsuarios
{
  //  Editar Usuario
  public $codUsuario;
  public function ajaxEditarUsuario()
  {
    $codUsuario = $this->codUsuario;
    $respuesta = ControllerUsuarios::ctrMostrarDatosEditar($codUsuario);
    echo json_encode($respuesta);
  }
}

//  Editar usuario
if(isset($_POST["codUsuario"])){
	$editar = new AjaxUsuarios();
	$editar -> codUsuario = $_POST["codUsuario"];
	$editar -> ajaxEditarUsuario();
}