<?php

require_once "conexion.php";

class ModelProductos
{
  //  Ingresar un nuevo producto
  public static function mdlIngresarNuevoProducto($tabla, $datosCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (IdCategoria, CodProducto, DescripcionProducto, PrecioUnitarioProducto, PesoProducto, CreadoUsuario, ActualizaUsuario, FechaCreacion, FechaActualizacion) VALUES(:IdCategoria, :CodProducto, :DescripcionProducto, :PrecioUnitarioProducto, :CreadoUsuario, :ActualizaUsuario, :PesoProducto, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":IdCategoria", $datosCreate["IdCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":CodProducto", $datosCreate["CodProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":DescripcionProducto", $datosCreate["DescripcionProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitarioProducto", $datosCreate["PrecioUnitarioProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":PesoProducto", $datosCreate["PesoProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":CreadoUsuario", $datosCreate["CreadoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":ActualizaUsuario", $datosCreate["ActualizaUsuario"], PDO::PARAM_STR);  
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

  //  Actualizar producto
  public static function mdlUpdateProducto($tabla, $datosUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET DescripcionProducto=:DescripcionProducto, CodProducto=:CodProducto, IdCategoria=:IdCategoria, PrecioUnitarioProducto=:PrecioUnitarioProducto, PesoProducto=:PesoProducto, ActualizaUsuario=:ActualizaUsuario, FechaActualizacion=:FechaActualizacion WHERE IdProducto=:IdProducto");
    $statement -> bindParam(":DescripcionProducto", $datosUpdate["DescripcionProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":CodProducto", $datosUpdate["CodProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":IdCategoria", $datosUpdate["IdCategoria"], PDO::PARAM_STR);
    $statement -> bindParam(":PrecioUnitarioProducto", $datosUpdate["PrecioUnitarioProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":PesoProducto", $datosUpdate["PesoProducto"], PDO::PARAM_STR);
    $statement -> bindParam(":ActualizaUsuario", $datosUpdate["ActualizaUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdate["FechaActualizacion"], PDO::PARAM_STR);
    $statement -> bindParam(":IdProducto", $datosUpdate["IdProducto"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Eliminar un producto
  public static function mdlEliminarProducto($tabla, $codProducto)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdProducto = $codProducto");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Mostrar todos los productos
  public static function mdlMostrarProductos($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_producto.IdProducto, tba_producto.IdCategoria, tba_producto.CreadoUsuario, tba_producto.CodProducto, tba_producto.DescripcionProducto, tba_producto.PrecioUnitarioProducto, tba_producto.PesoProducto, tba_categoria.CodCategoria FROM $tabla INNER JOIN tba_categoria ON tba_producto.IdCategoria = tba_categoria.IdCategoria ORDER BY IdProducto ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar datos para editar producto
  public static function mdlMostrarDatosEditar($tabla, $codProducto)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_producto.IdProducto, tba_producto.IdCategoria, tba_producto.CodProducto, tba_producto.DescripcionProducto, tba_producto.PrecioUnitarioProducto, tba_producto.PesoProducto FROM $tabla WHERE tba_producto.IdProducto = $codProducto");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Mostrar los productos para el modal de ingresos
  public static function mdlMostrarProductosModal($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_producto.IdProducto, tba_producto.CodProducto, tba_producto.DescripcionProducto FROM $tabla ORDER BY IdProducto ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar los datos de un producto
  public static function mdlMostrarDatosProducto($tabla, $codProducto)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_producto.IdProducto, tba_producto.CodProducto, tba_producto.DescripcionProducto, tba_producto.PrecioUnitarioProducto, tba_producto.PesoProducto FROM $tabla WHERE tba_producto.IdProducto = $codProducto");
    $statement -> execute();
    return $statement -> fetch();
  }
}