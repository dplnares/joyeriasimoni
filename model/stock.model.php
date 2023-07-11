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

  //  Crear un nuevo stock en una tienda
  public static function mdlCrearRegistroStock($tabla, $datosStockCreate)
  {
    $stmt = Conexion::conn()->prepare("INSERT INTO $tabla (IdTienda, IdProducto, CantidadIngresos, CantidadSalidas, CantidadActual, PrecioUnitario, PrecioTotal, FechaCreacion, FechaActualizacion) VALUES (:IdTienda, :IdProducto, :CantidadIngresos, :CantidadSalidas, :CantidadActual, :PrecioUnitario, :PrecioTotal, :FechaCreacion, :FechaActualizacion)");

    $stmt->bindParam(":IdTienda", $datosStockCreate["IdTienda"], PDO::PARAM_STR);
    $stmt->bindParam(":IdProducto", $datosStockCreate["IdProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":CantidadIngresos", $datosStockCreate["CantidadIngresos"], PDO::PARAM_STR);
    $stmt->bindParam(":CantidadSalidas", $datosStockCreate["CantidadSalidas"], PDO::PARAM_STR);
    $stmt->bindParam(":CantidadActual", $datosStockCreate["CantidadActual"], PDO::PARAM_STR);
    $stmt->bindParam(":PrecioUnitario", $datosStockCreate["PrecioUnitario"], PDO::PARAM_STR);
    $stmt->bindParam(":PrecioTotal", $datosStockCreate["PrecioTotal"], PDO::PARAM_STR);
    $stmt->bindParam(":FechaCreacion", $datosStockCreate["FechaCreacion"], PDO::PARAM_STR);
    $stmt->bindParam(":FechaActualizacion", $datosStockCreate["FechaActualizacion"], PDO::PARAM_STR);
    if($stmt->execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Actualizar el stock actual de una tienda
  public static function mdlUpdateStock($tabla, $codStock, $datosStockUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadIngresos=:CantidadIngresos, CantidadActual=:CantidadActual, PrecioUnitario=:PrecioUnitario, PrecioTotal=:PrecioTotal, FechaActualiza=:FechaActualiza WHERE IdStock=:IdStock");

    $statement -> bindParam(":CantidadIngresos", $datosStockUpdate["CantidadIngresos"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosStockUpdate["CantidadActual"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitario", $datosStockUpdate["PrecioUnitario"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioTotal", $datosStockUpdate["PrecioTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualiza", $datosStockUpdate["FechaActualiza"], PDO::PARAM_STR);
    $statement -> bindParam(":IdStock", $codStock, PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
}