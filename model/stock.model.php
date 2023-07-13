<?php

require_once "conexion.php";

class ModelStock
{
  //  Mostrar el stock actual de una tienda
  public static function mdlMostrarStockActual($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdStock, tba_stock.IdTienda, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual, tba_stock.PrecioUnitario, tba_stock.PrecioTotal, tba_stock.FechaActualizacion, tba_producto.DescripcionProducto, tba_producto.CodProducto FROM $tabla INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto WHERE tba_stock.IdTienda = $codTienda AND tba_stock.CantidadActual > 0");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Crear un nuevo stock en una tienda
  public static function mdlCrearRegistroStock($tabla, $datosStockCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdTienda, IdProducto, CantidadIngresos, CantidadSalidas, CantidadActual, PrecioUnitario, PrecioTotal, FechaCreacion, FechaActualizacion) VALUES (:IdTienda, :IdProducto, :CantidadIngresos, :CantidadSalidas, :CantidadActual, :PrecioUnitario, :PrecioTotal, :FechaCreacion, :FechaActualizacion)");

    $statement->bindParam(":IdTienda", $datosStockCreate["IdTienda"], PDO::PARAM_STR);
    $statement->bindParam(":IdProducto", $datosStockCreate["IdProducto"], PDO::PARAM_STR);
    $statement->bindParam(":CantidadIngresos", $datosStockCreate["CantidadIngresos"], PDO::PARAM_STR);
    $statement->bindParam(":CantidadSalidas", $datosStockCreate["CantidadSalidas"], PDO::PARAM_STR);
    $statement->bindParam(":CantidadActual", $datosStockCreate["CantidadActual"], PDO::PARAM_STR);
    $statement->bindParam(":PrecioUnitario", $datosStockCreate["PrecioUnitario"], PDO::PARAM_STR);
    $statement->bindParam(":PrecioTotal", $datosStockCreate["PrecioTotal"], PDO::PARAM_STR);
    $statement->bindParam(":FechaCreacion", $datosStockCreate["FechaCreacion"], PDO::PARAM_STR);
    $statement->bindParam(":FechaActualizacion", $datosStockCreate["FechaActualizacion"], PDO::PARAM_STR);
    if($statement->execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Actualizar el stock actual de una tienda
  public static function mdlUpdateStockIngreso($tabla, $codStock, $datosStockUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadIngresos=:CantidadIngresos, CantidadActual=:CantidadActual, PrecioUnitario=:PrecioUnitario, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdStock=:IdStock");

    $statement -> bindParam(":CantidadIngresos", $datosStockUpdate["CantidadIngresos"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosStockUpdate["CantidadActual"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitario", $datosStockUpdate["PrecioUnitario"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioTotal", $datosStockUpdate["PrecioTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosStockUpdate["FechaActualizacion"], PDO::PARAM_STR);
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

  //  Actualizar el stock de una salida
  public static function mdlUpdateStockSalida($tabla, $codStock, $datosStockUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadSalidas=:CantidadSalidas, CantidadActual=:CantidadActual, PrecioUnitario=:PrecioUnitario, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdStock=:IdStock");

    $statement -> bindParam(":CantidadSalidas", $datosStockUpdate["CantidadSalidas"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosStockUpdate["CantidadActual"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitario", $datosStockUpdate["PrecioUnitario"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioTotal", $datosStockUpdate["PrecioTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosStockUpdate["FechaActualizacion"], PDO::PARAM_STR);
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

  //  Obtener el stock actual de un producto 
  public static function mdlObtenerStockActualProducto($tabla, $codProducto, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdStock, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual FROM $tabla WHERE tba_stock.IdTienda = $codTienda and tba_stock.IdProducto = $codProducto");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Obtener los recursos actuales en stock
  public static function mdlObtenerProductosEnStock($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdProducto, tba_stock.CantidadActual, tba_producto.DescripcionProducto, tba_producto.CodProducto FROM $tabla INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto WHERE tba_stock.IdTienda = $codTienda");
    $statement -> execute();
    return $statement -> fetchAll();
  }
}