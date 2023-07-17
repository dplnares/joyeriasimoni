<?php

require_once "conexion.php";

class ModelUsuarios
{
  //  Actualizar el último login de un usuario
  static public function mdlActualizarUltimoLogin($tabla, $ultimoLogin, $codUsuario)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET UltimaConexion=:UltimaConexion WHERE tba_usuario.IdUsuario = $codUsuario");
    $statement -> bindParam(":UltimaConexion", $ultimoLogin, PDO::PARAM_STR);
    if ($statement->execute()){
			return "ok";	
		}
    else
    {
			return "error";
		}
  }

  //  Ingresar un nuevo usuario
  static public function mdlIngresarUsuario($tabla, $datosCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (NombreUsuario, CorreoUsuario, PasswordUsuario, IdPerfilUsuario, FechaCreacion, FechaActualizacion) VALUES(:NombreUsuario, :CorreoUsuario, :PasswordUsuario, :IdPerfilUsuario, :FechaCreacion, :FechaActualizacion)");
    $statement -> bindParam(":NombreUsuario", $datosCreate["NombreUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CorreoUsuario", $datosCreate["CorreoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":PasswordUsuario", $datosCreate["PasswordUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":IdPerfilUsuario", $datosCreate["IdPerfilUsuario"], PDO::PARAM_STR);
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
  
  //  Editar datos de un usuario
  public static function mdlUpdateUsuario($tabla, $datosUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET NombreUsuario=:NombreUsuario, CorreoUsuario=:CorreoUsuario, IdPerfilUsuario=:IdPerfilUsuario, FechaActualizacion=:FechaActualizacion WHERE IdUsuario=:IdUsuario");
    $statement -> bindParam(":NombreUsuario", $datosUpdate["NombreUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CorreoUsuario", $datosUpdate["CorreoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":IdPerfilUsuario", $datosUpdate["IdPerfilUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":IdUsuario", $datosUpdate["IdUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":FechaActualizacion", $datosUpdate["FechaActualizacion"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Eliminar usuario
  public static function mdlEliminarUsuario($tabla, $codUsuario)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE IdUsuario = $codUsuario");
    if ($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }


  //  Obtener todos los datos de un usuario en específico
  static public function mdlMostrarUnUsuario($tabla, $parametro, $email)
  {
    $statement = Conexion::conn()->prepare("SELECT * FROM $tabla WHERE $parametro = :$parametro");
    $statement -> bindParam(":".$parametro, $email , PDO::PARAM_STR);
    $statement -> execute();
    return $statement -> fetch();
  }
  
  //  Mostrar todos los usuarios
  static public function mdlMostrarUsuarios($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_usuario.IdUsuario, tba_usuario.NombreUsuario, tba_usuario.CorreoUsuario, tba_usuario.IdPerfilUsuario, tba_perfilusuario.NombrePerfil FROM $tabla INNER JOIN tba_perfilusuario ON tba_usuario.IdPerfilUsuario = tba_perfilusuario.IdPerfilUsuario ORDER BY IdUsuario ASC");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar todos los perfiles
  static public function mdlMostrarPerfiles($tabla)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_perfilusuario.IdPerfilUsuario, tba_perfilusuario.NombrePerfil FROM $tabla");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Mostrar los datos a editar de un usuario
  public static function mdlMostrarDatosEditar($tabla, $codUsuario)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_usuario.IdUsuario, tba_usuario.NombreUsuario, tba_usuario.CorreoUsuario, tba_usuario.IdPerfilUsuario, tba_perfilusuario.NombrePerfil FROM $tabla INNER JOIN tba_perfilusuario ON tba_usuario.IdPerfilUsuario = tba_perfilusuario.IdPerfilUsuario WHERE tba_usuario.IdUsuario = $codUsuario");
    $statement -> execute();
    return $statement -> fetch();
  }
}