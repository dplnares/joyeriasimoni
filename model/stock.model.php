<?php

require_once "conexion.php";

class ModelStock
{
  //  Mostrar el stock actual de una tienda
  public static function mdlMostrarStockActual($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdStock, tba_stock.IdTienda, tba_stock.IdProducto, tba_stock.CantidadStock, tba_stock.PrecioTotal, tba_stock.FechaCreacion, tba_producto.DescripcionProducto, tba_producto.CodProducto, tba_producto.PrecioUnitarioProducto FROM $tabla INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto WHERE tba_stock.IdTienda = $codTienda AND tba_stock.CantidadStock > 0");
    $statement -> execute();
    return $statement -> fetchAll();
  }
}