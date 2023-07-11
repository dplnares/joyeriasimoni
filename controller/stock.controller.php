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
  public static function ctrObtenerStockActual($codProducto, $codTienda)
  {
    $stmt = Conexion::conn()->prepare("SELECT tba_stock.IdStock, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stockCantidadActual FROM tba_stock WHERE tba_stock.IdTienda = $codTienda and tba_stock.IdProducto = $codProducto");
    $stmt -> execute();
    return $stmt -> fetch();
  }

  //  Update del stock actual
  public static function ctrActualizarStock($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStock($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Crear un nuevo stocck de un producto
  public static function ctrCrearRegistroStock($datosStockCreate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlCrearRegistroStock($tabla, $datosStockCreate);
    return $respuesta;
  }
}