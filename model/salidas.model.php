<?php

require_once "conexion.php";

class ModelSalidas
{
  //  Mostrar todas las salidas de una tienda, modificar la tabla si se quiere con el nombre del proveedor o con si se pone en otra tabla
  public static function mdlMostrarSalidasTienda($tabla, $codTienda, $tipoMovimiento)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTipoMovimiento, tba_movimiento.IdTienda, tba_movimiento.CreadoUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreCliente, tba_movimiento.Total, tba_movimiento.FechaCreacion FROM $tabla WHERE tba_movimiento.IdTienda = $codTienda AND tba_movimiento.IdTipoMovimiento = $tipoMovimiento");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Agregar la cabecera de la salida
  public static function mdlIngresarCabeceraSalida($tabla, $datosCabecera)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdTipoMovimiento, IdTienda, CreadoUsuario, ActualizaUsuario, NumeroDocumento, NombreCliente, Total, FechaCreacion, FechaActualizacion) VALUES(:IdTipoMovimiento, :IdTienda, :CreadoUsuario, :ActualizaUsuario, :NumeroDocumento, :NombreCliente, :Total, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":IdTipoMovimiento", $datosCabecera["IdTipoMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosCabecera["IdTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":CreadoUsuario", $datosCabecera["CreadoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":ActualizaUsuario", $datosCabecera["ActualizaUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":NumeroDocumento", $datosCabecera["NumeroDocumento"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreCliente", $datosCabecera["NombreCliente"], PDO::PARAM_STR);
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

  //  Agregar el detalle de la salida
  public static function mdlIngresarDetalleSalida($tabla, $datosDetalle)
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

  //  Mostrar el detalle de la salida
  public static function mdlMostrarDetalleSalida($tabla, $codMovimiento)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento, tba_detallemovimiento.PrecioUnitario, tba_detallemovimiento.ParcialTotal, tba_producto.DescripcionProducto FROM $tabla INNER JOIN tba_producto ON tba_detallemovimiento.IdProducto = tba_producto.IdProducto WHERE tba_detallemovimiento.IdMovimiento = $codMovimiento");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Obtener lista que se va a eliminar
  public static function mdlObtenerListaEliminar($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento FROM $tabla WHERE tba_detallemovimiento.IdMovimiento = $codSalida");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  
  //  Eliminar el detalle de la salida 
  public static function mdlEliminarDetalleSalida($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdMovimiento = $codSalida");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
  
  //  Eliminar cabecera del registro seleccionado
  public static function mdlEliminarCabeceraSalida($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdMovimiento = $codSalida");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Obtener la cabecera del movimiento
  public static function mdlObtenerCabeceraSalida($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTienda, tba_movimiento.CreadoUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreCliente, tba_movimiento.Total, tba_movimiento.FechaMovimiento, tba_tienda.NombreTienda FROM $tabla INNER JOIN tba_tienda ON tba_movimiento.IdTienda = tba_tienda.IdTienda WHERE tba_movimiento.IdMovimiento = $codSalida");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Obtener el detalle del movimiento
  public static function mdlOBtenerDetalleSalidaEditar($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento, tba_detallemovimiento.PrecioUnitario, tba_detallemovimiento.ParcialTotal, tba_producto.DescripcionProducto, tba_producto.CodProducto, tba_producto.PesoProducto, tba_producto.PrecioUnitarioProducto FROM $tabla INNER JOIN tba_producto ON tba_detallemovimiento.IdProducto = tba_producto.IdProducto WHERE tba_detallemovimiento.IdMovimiento = $codSalida");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Obtener el detalle anterior de la salida
  public static function mdlObtenerListaAntigua($tabla, $codSalida)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento FROM $tabla WHERE tba_detallemovimiento.IdMovimiento = $codSalida");
    $statement -> execute();
    return $statement -> fetchAll();
  }
}