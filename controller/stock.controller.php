<?php

class ControllerStock
{
  //  Mostrar el stock actual por proyecto
  public static function ctrMostrarStockActual()
  {
    if(isset($_GET["codTienda"]))
    {
      $tabla = "tba_stock";
      $codTienda = $_GET["codTienda"];
      $respuesta = ModelStock::mdlMostrarStockActual($tabla, $codTienda);
      return $respuesta;
    }
  }

  //  Mostrar el stock actual de un producto en una tienda en específico
  public static function ctrObtenerStockActualProducto($codProducto, $codTienda)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlObtenerStockActualProducto($tabla, $codProducto, $codTienda);
    return $respuesta;
  }

  //  Update del stock actual de un ingreso
  public static function ctrActualizarStockIngreso($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockIngreso($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Update del stock actual de una salida
  public static function ctrActualizarStockSalida($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockSalida($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Crear un nuevo stocck de un producto
  public static function ctrCrearRegistroStock($datosStockCreate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlCrearRegistroStock($tabla, $datosStockCreate);
    return $respuesta;
  }

  //  Mostrar todos los productos en stock
  public static function ctrMostrarProductosEnStock()
  {
    $tabla = "tba_stock";
    $codTienda = $_GET["codTienda"];
    $respuesta = ModelStock::mdlObtenerProductosEnStock($tabla, $codTienda);
    return $respuesta;
  }
}