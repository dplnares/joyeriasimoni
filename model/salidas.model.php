<?php

require_once "conexion.php";

class ModelSalidas
{
  //  Mostrar todas las salidas de una tienda, modificar la tabla si se quiere con el nombre del proveedor o con si se pone en otra tabla
  public static function mdlMostrarSalidasTienda($tabla, $codTienda, $tipoMovimiento)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_movimiento.IdMovimiento, tba_movimiento.IdTipoMovimiento, tba_movimiento.IdTienda, tba_movimiento.IdUsuario, tba_movimiento.NumeroDocumento, tba_movimiento.NombreProveedor, tba_movimiento.Total, tba_movimiento.FechaCreacion FROM $tabla WHERE tba_movimiento.IdTienda = $codTienda AND tba_movimiento.IdTipoMovimiento = $tipoMovimiento");
    $statement -> execute();
    return $statement -> fetchAll();
  }
}