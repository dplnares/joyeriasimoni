<?php

require_once "conexion.php";

class ModelTiendas
{
  //  Crear una nueva tienda
  public static function mdlIngresarNuevaTienda($tabla, $datosCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (CodTienda, NombreTienda, FechaCreacion, FechaActualizacion) VALUES(:CodTienda, :NombreTienda, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":CodTienda", $datosCreate["CodTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreTienda", $datosCreate["NombreTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaCreacion", $datosCreate["FechaCreacion"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosCreate["FechaActualizacion"], PDO::PARAM_STR);

    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Editar tienda
  public static function mdlUpdateTienda($tabla, $datosUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET NombreTienda=:NombreTienda, CodTienda=:CodTienda, FechaActualizacion=:FechaActualizacion WHERE IdTienda=:IdTienda");
    $statement -> bindParam(":NombreTienda", $datosUpdate["NombreTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":CodTienda", $datosUpdate["CodTienda"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdate["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdTienda", $datosUpdate["IdTienda"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Eliminar tienda
  public static function mdlEliminarTienda($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdTienda = $codTienda");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Mostrar todas las tiendas
  public static function mdlMostrarTiendas($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_tienda.IdTienda, tba_tienda.CodTienda, tba_tienda.NombreTienda, tba_tienda.FechaCreacion FROM $tabla ORDER BY IdTienda ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar datos para editar tienda
  public static function mdlMostrarDatosEditar($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_tienda.IdTienda, tba_tienda.CodTienda, tba_tienda.NombreTienda FROM $tabla WHERE tba_tienda.IdTienda = $codTienda");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Mostrar datos de una tienda
  public static function mdlMostrarUnaTienda($tabla, $codTienda)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_tienda.IdTienda, tba_tienda.NombreTienda FROM $tabla WHERE tba_tienda.IdTienda = $codTienda");
    $statement -> execute();
    return $statement -> fetch();
  }
}