<?php

require_once "conexion.php";

class ModelCategorias
{
  //  Mostrar todas las categorías
  public static function mdlMostrarCategorias($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_categoria.IdCategoria, tba_categoria.CodCategoria, tba_categoria.NombreCategoria, tba_categoria.DescripcionCategoria, tba_categoria.FechaCreacion FROM $tabla ORDER BY IdCategoria ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  public static function mdlMostrarDatosEditar($tabla, $codCategoria)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_categoria.IdCategoria, tba_categoria.CodCategoria, tba_categoria.NombreCategoria, tba_categoria.DescripcionCategoria FROM $tabla WHERE tba_categoria.IdCategoria = $codCategoria");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Ingresar nueva categoria
  public static function mdlIngresarNuevaCategoria($tabla, $datosCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (CodCategoria, NombreCategoria, DescripcionCategoria, FechaCreacion, FechaActualizacion) VALUES(:CodCategoria, :NombreCategoria, :DescripcionCategoria, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":CodCategoria", $datosCreate["CodCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":NombreCategoria", $datosCreate["NombreCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":DescripcionCategoria", $datosCreate["DescripcionCategoria"], PDO::PARAM_STR);
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

  //  Editar datos categoria
  public static function mdlUpdateCategoria($tabla, $datosUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET NombreCategoria=:NombreCategoria, CodCategoria=:CodCategoria, DescripcionCategoria=:DescripcionCategoria, FechaActualizacion=:FechaActualizacion WHERE IdCategoria=:IdCategoria");
    $statement -> bindParam(":NombreCategoria", $datosUpdate["NombreCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":CodCategoria", $datosUpdate["CodCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":DescripcionCategoria", $datosUpdate["DescripcionCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdate["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdCategoria", $datosUpdate["IdCategoria"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Eliminar categoria
  public static function mdlEliminarCategoria($tabla, $codCategoria)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdCategoria = $codCategoria");
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