<?php

class ControllerTiendas
{
  //  Crear nueva tienda
  static public function ctrCrearTienda()
  {
    if(isset($_POST["nombreTienda"]))
    {
      $tabla = "tba_tienda";
      $datosCreate = array(
        "NombreTienda" => $_POST["nombreTienda"],
        "CodTienda" => $_POST["codigoTienda"],
        "FechaCreacion"=> date("Y-m-d"),
        "FechaActualizacion"=> date("Y-m-d"),
      );

      $respuesta = ModelTiendas::mdlIngresarNuevaTienda($tabla, $datosCreate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Tienda Registrada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "tienda";
						}
					});
        </script>';
      }	
    }
  }

  //  Editar Tienda
  static public function ctrEditarTienda()
  {
    if(isset($_POST["editarNombre"]))
    {
      $tabla = "tba_tienda";
      $datosUpdate = array(
        "NombreTienda" =>  $_POST["editarNombre"],
        "CodTienda" => $_POST["editarCodigo"],
        "IdTienda" => $_POST["codTienda"],
        "FechaActualizacion" => date("Y-m-d"),
      );

      $respuesta = ModelTiendas::mdlUpdateTienda($tabla, $datosUpdate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Tienda Editada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "tienda";
						}
					});
        </script>';
      }
    }
  }

  //  Eliminar Tienda
  static public function ctrEliminarTienda()
  {
    if (isset($_GET["codTienda"]))
    {
      $tabla = "tba_tienda";
      $codTienda = $_GET["codTienda"];
      $respuesta = ModelTiendas::mdlEliminarTienda($tabla, $codTienda);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Tienda Eliminada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "tienda";
						}
					});
        </script>';
      }
    }
  }

  //  Mostrar todas las tiendas
  public static function ctrMostrarTiendas()
  {
    $tabla = "tba_tienda";
    $listaTiendas = ModelTiendas::mdlMostrarTiendas($tabla);
    return $listaTiendas;
  }

  //  Mostrar datos para editar tienda
  public static function ctrMostrarDatosEditar($codTienda)
  {
    $tabla = "tba_tienda";
    $datosTienda = ModelTiendas::mdlMostrarDatosEditar($tabla, $codTienda);
    return $datosTienda;
  }

  //  Mostrar datos de una tienda
  public static function ctrMostrarUnaTienda($codTienda)
  {
    $tabla = "tba_tienda";
    $datosTienda = ModelTiendas::mdlMostrarUnaTienda($tabla, $codTienda);
    return $datosTienda;
  }
}