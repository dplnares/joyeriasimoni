<?php

class ControllerSalidas
{
  //  Mostrar todas las salidas de la tienda
  public static function ctrMostrarSalidasTienda()
  {
    if(isset($_GET["codTienda"]))
    {
      $tabla = "tba_movimiento";
      $codTienda = $_GET["codTienda"];
      //  Tipo de movimiento 2 son las salidas
      $tipoMovimiento = 2;
      $respuesta = ModelSalidas::mdlMostrarSalidasTienda($tabla, $codTienda, $tipoMovimiento);
      return $respuesta;
    }
  }
}