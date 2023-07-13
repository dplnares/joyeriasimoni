<?php

require_once "conexion.php";

class ModelIngresos
{
  //  Agregar un nuevo ingreso
  public static function mdlIngresarCabeceraIngreso($tabla, $datosCabecera)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdTipoMovimiento, IdTienda, IdUsuario, NumeroDocumento, NombreProveedor, Total, FechaCreacion, FechaActualizacion) VALUES(:IdTipoMovimiento, :IdTienda, :IdUsuario, :NumeroDocumento, :NombreProveedor, :Total, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":IdTipoMovimiento", $datosCabecera["IdTipoMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosCabecera["IdTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":IdUsuario", $datosCabecera["IdUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":NumeroDocumento", $datosCabecera["NumeroDocumento"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreProveedor", $datosCabecera["NombreProveedor"], PDO::PARAM_STR);
    $statement -> bindParam(":Total", $datosCabecera["Total"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaCreacion", $datosCabecera["FechaCreacion"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosCabecera["FechaActualizacion"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Agregar el detalle del ingreso
  public static function mdlIngresarDetalleIngreso($tabla, $datosDetalle)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdMovimiento, IdProducto, CantidadMovimiento, PrecioUnitario, ParcialTotal, FechaCreacion, FechaActualizacion) VALUES(:IdMovimiento, :IdProducto, :CantidadMovimiento, :PrecioUnitario, :ParcialTotal, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":IdMovimiento", $datosDetalle["IdMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":IdProducto", $datosDetalle["IdProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":CantidadMovimiento", $datosDetalle["CantidadMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitario", $datosDetalle["PrecioUnitario"], PDO::PARAM_STR);
    $statement -> bindParam(":ParcialTotal", $datosDetalle["ParcialTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaCreacion", $datosDetalle["FechaCreacion"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosDetalle["FechaActualizacion"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Obtener el último id registrado
  public static function mdlObtenerUltimoId($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT MAX(IdMovimiento) as id FROM $tabla");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Mostrar todos los ingresos de una tienda
  public static function mdlMostrarIngresosTienda($tabla, $codTienda, $tipoMovimiento)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTipoMovimiento, tba_movimiento.IdTienda, tba_movimiento.IdUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreProveedor, tba_movimiento.Total, tba_movimiento.FechaCreacion FROM $tabla WHERE tba_movimiento.IdTienda = $codTienda AND tba_movimiento.IdTipoMovimiento = $tipoMovimiento");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar detalle del movimiento registrado
  public static function mdlMostrarDetalleIngreso($tabla, $codMovimiento)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento, tba_detallemovimiento.PrecioUnitario, tba_detallemovimiento.ParcialTotal, tba_producto.DescripcionProducto FROM $tabla INNER JOIN tba_producto ON tba_detallemovimiento.IdProducto = tba_producto.IdProducto WHERE tba_detallemovimiento.IdMovimiento = $codMovimiento");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Obtener lista que se va a eliminar
  public static function mdlObtenerListaEliminar($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento FROM $tabla WHERE tba_detallemovimiento.IdMovimiento = $codIngreso");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Eliminar cabecera del registro seleccionado
  public static function mdlEliminarCabeceraIngreso($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdMovimiento = $codIngreso");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Eliminar el detalle del ingreso 
  public static function mdlEliminarDetalleIngreso($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdMovimiento = $codIngreso");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
}