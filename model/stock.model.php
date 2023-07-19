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

  //  Actualizar el stock luego de eliminarse un ingreso
  public static function mdlUpdateStockIngresoEliminado($tabla, $codStock, $datosStockUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadIngresos=:CantidadIngresos, CantidadActual=:CantidadActual, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdStock=:IdStock");

    $statement -> bindParam(":CantidadIngresos", $datosStockUpdate["CantidadIngresos"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosStockUpdate["CantidadActual"], PDO::PARAM_STR);
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

  //  Actualizar el stock luego de eliminarse una salida
  public static function mdlUpdateStockSalidaEliminado($tabla, $codStock, $datosStockUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadSalidas=:CantidadSalidas, CantidadActual=:CantidadActual, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdStock=:IdStock");

    $statement -> bindParam(":CantidadSalidas", $datosStockUpdate["CantidadSalidas"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosStockUpdate["CantidadActual"], PDO::PARAM_STR);
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
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdStock, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual, tba_stock.PrecioUnitario FROM $tabla WHERE tba_stock.IdTienda = $codTienda and tba_stock.IdProducto = $codProducto");
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

  //  Obtener reporte por tienda
  public static function mdlObtenerReporteTienda($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_stock.IdProducto, tba_stock.CantidadActual, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual, tba_stock.PrecioUnitario, tba_stock.PrecioTotal, tba_stock.FechaActualizacion, tba_producto.DescripcionProducto, tba_producto.CodProducto FROM $tabla INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto WHERE tba_stock.IdTienda = $codTienda");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Obtener el stock general de un recurso, si devuelve un valor
  public static function mdlObtenerStockGeneral($campo,$valor)
  {
    if($campo == "nombreProducto")
    {
      $stmt = Conexion::conn()->prepare("SELECT tba_stock.IdTienda, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual, tba_stock.PrecioUnitario, tba_stock.PrecioTotal, tba_stock.FechaActualizacion, tba_producto.CodProducto, tba_producto.DescripcionProducto, tba_tienda.CodTienda, tba_tienda.NombreTienda FROM tba_stock INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto INNER JOIN tba_tienda ON tba_stock.IdTienda = tba_tienda.IdTienda WHERE tba_producto.DescripcionProducto like '%$valor%' ");
    }
    if($campo == "codigoProducto")
    {
      $stmt = Conexion::conn()->prepare("SELECT tba_stock.IdTienda, tba_stock.IdProducto, tba_stock.CantidadIngresos, tba_stock.CantidadSalidas, tba_stock.CantidadActual, tba_stock.PrecioUnitario, tba_stock.PrecioTotal, tba_stock.FechaActualizacion, tba_producto.CodProducto, tba_producto.DescripcionProducto, tba_tienda.CodTienda, tba_tienda.NombreTienda FROM tba_stock INNER JOIN tba_producto ON tba_stock.IdProducto = tba_producto.IdProducto INNER JOIN tba_tienda ON tba_stock.IdTienda = tba_tienda.IdTienda WHERE tba_producto.CodProducto like '$valor' ");
    }
    $stmt -> execute();
    return $stmt -> fetchAll();
  }
  
  //  Actualizar el stock por edición de un ingreso
  public static function mdlActualizarStockIngreso($tabla, $datosUpdateStock)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadIngresos=:CantidadIngresos, CantidadActual=:CantidadActual, FechaActualizacion=:FechaActualizacion, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdProducto=:IdProducto AND IdTienda=:IdTienda");

    $statement -> bindParam(":CantidadIngresos", $datosUpdateStock["CantidadIngresos"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosUpdateStock["CantidadActual"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioTotal", $datosUpdateStock["PrecioTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdateStock["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdProducto", $datosUpdateStock["IdProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosUpdateStock["IdTienda"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  

  //  Actualizar el stock por edición de una salida
  public static function mdlActualizarStockSalida($tabla, $datosUpdateStock)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadSalidas=:CantidadSalidas, CantidadActual=:CantidadActual, FechaActualizacion=:FechaActualizacion, PrecioTotal=:PrecioTotal, FechaActualizacion=:FechaActualizacion WHERE IdProducto=:IdProducto AND IdTienda=:IdTienda");

    $statement -> bindParam(":CantidadSalidas", $datosUpdateStock["CantidadSalidas"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadActual", $datosUpdateStock["CantidadActual"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioTotal", $datosUpdateStock["PrecioTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdateStock["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdProducto", $datosUpdateStock["IdProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosUpdateStock["IdTienda"], PDO::PARAM_STR);
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