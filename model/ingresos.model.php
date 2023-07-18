<?php

require_once "conexion.php";

class ModelIngresos
{
  //  Agregar un nuevo ingreso
  public static function mdlIngresarCabeceraIngreso($tabla, $datosCabecera)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdTipoMovimiento, IdTienda, CreadoUsuario, ActualizaUsuario, NumeroDocumento, NombreProveedor, Total, FechaMovimiento, FechaCreacion, FechaActualizacion) VALUES(:IdTipoMovimiento, :IdTienda, :CreadoUsuario, :ActualizaUsuario, :NumeroDocumento, :NombreProveedor, :Total, :FechaMovimiento, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":IdTipoMovimiento", $datosCabecera["IdTipoMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosCabecera["IdTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":CreadoUsuario", $datosCabecera["CreadoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":ActualizaUsuario", $datosCabecera["ActualizaUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":NumeroDocumento", $datosCabecera["NumeroDocumento"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreProveedor", $datosCabecera["NombreProveedor"], PDO::PARAM_STR);
    $statement -> bindParam(":Total", $datosCabecera["Total"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaMovimiento", $datosCabecera["FechaMovimiento"], PDO::PARAM_STR);
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

  //  Editar la cabecera de un ingreso
  public static function mdlEditarCabeceraIngreso($tabla, $codIngreso, $datosUpdateCabecera)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET ActualizaUsuario=:ActualizaUsuario, NumeroDocumento=:NumeroDocumento, NombreProveedor=:NombreProveedor, Total=:Total, FechaMovimiento=:FechaMovimiento, FechaActualizacion=:FechaActualizacion WHERE tba_movimiento.IdMovimiento = $codIngreso");
    $statement -> bindParam(":ActualizaUsuario", $datosUpdateCabecera["ActualizaUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":NumeroDocumento", $datosUpdateCabecera["NumeroDocumento"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreProveedor", $datosUpdateCabecera["NombreProveedor"], PDO::PARAM_STR);
    $statement -> bindParam(":Total", $datosUpdateCabecera["Total"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaMovimiento", $datosUpdateCabecera["FechaMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdateCabecera["FechaActualizacion"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }
  
  //  Actualizar el detalle del ingreso
  public static function mdlActualizarDetalleIngreso($tabla, $datosUpdateDetalle)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET CantidadMovimiento=:CantidadMovimiento, ParcialTotal=:ParcialTotal, FechaActualizacion=:FechaActualizacion WHERE IdMovimiento=:IdMovimiento AND IdProducto=:IdProducto");
    $statement -> bindParam(":CantidadMovimiento", $datosUpdateDetalle["CantidadMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":ParcialTotal", $datosUpdateDetalle["ParcialTotal"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdateDetalle["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdMovimiento", $datosUpdateDetalle["IdMovimiento"], PDO::PARAM_STR);
    $statement -> bindParam(":IdProducto", $datosUpdateDetalle["IdProducto"], PDO::PARAM_STR);
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
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTipoMovimiento, tba_movimiento.IdTienda, tba_movimiento.CreadoUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreProveedor, tba_movimiento.Total, tba_movimiento.FechaCreacion, tba_movimiento.FechaMovimiento FROM $tabla WHERE tba_movimiento.IdTienda = $codTienda AND tba_movimiento.IdTipoMovimiento = $tipoMovimiento");
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
  
  //  Mostrar detalle del movimiento registrado
  public static function mdlOBtenerDetalleIngresoEditar($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento, tba_detallemovimiento.PrecioUnitario, tba_detallemovimiento.ParcialTotal, tba_producto.DescripcionProducto, tba_producto.CodProducto, tba_producto.PesoProducto, tba_producto.PrecioUnitarioProducto FROM $tabla INNER JOIN tba_producto ON tba_detallemovimiento.IdProducto = tba_producto.IdProducto WHERE tba_detallemovimiento.IdMovimiento = $codIngreso");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Obtener lista antigua de productos
  public static function mdlObtenerListaAntigua($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_detallemovimiento.IdProducto, tba_detallemovimiento.CantidadMovimiento FROM $tabla WHERE tba_detallemovimiento.IdMovimiento = $codIngreso");
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

  //  Redirigir a la modificacion de un ingreso
  public static function mdlObtenerCabeceraIngreso($tabla, $codIngreso)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTienda, tba_movimiento.CreadoUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreProveedor, tba_movimiento.Total, tba_movimiento.FechaMovimiento, tba_tienda.NombreTienda FROM $tabla INNER JOIN tba_tienda ON tba_movimiento.IdTienda = tba_tienda.IdTienda WHERE tba_movimiento.IdMovimiento = $codIngreso");
    $statement -> execute();
    return $statement -> fetch();
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

  //  Eliminar el detalle del ingreso 
  public static function mdlEliminarEditarDetalleIngreso($tabla, $codIngreso, $idProducto)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdMovimiento = $codIngreso and IdProducto=$idProducto");
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