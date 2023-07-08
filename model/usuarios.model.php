<?php

require_once "conexion.php";

class ModelUsuarios
{
  //  Obtener todos los datos de un usuario en específico
  static public function mdlMostrarUnUsuario($tabla, $parametro, $email)
  {
    $statement = Conexion::conn()->prepare("SELECT * FROM $tabla WHERE $parametro = :$parametro");
    $statement -> bindParam(":".$parametro, $email , PDO::PARAM_STR);
    $statement -> execute();
    return $statement -> fetch();
  }

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
    $statement = Conexion::conn()->prepare("SELECT tba_perfilusuario.IdPerfil, tba_perfilusuario.NombrePerfil FROM $tabla");
    $statement -> execute();
    return $statement -> fetchAll();
  }

  //  Ingresar un nuevo usuario
  static public function mdlIngresarUsuario($tabla, $datosCreate)
  {
    $statement = Conexion::conn()->prepare("INSERT INTO $tabla (NombreUsuario, CorreoUsuario, PasswordUsuario, CodPerfil, CodArea) VALUES(:NombreUsuario, :CorreoUsuario, :PasswordUsuario, :CodPerfil, :CodArea)");
    $statement -> bindParam(":NombreUsuario", $datosCreate["NombreUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CorreoUsuario", $datosCreate["CorreoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":PasswordUsuario", $datosCreate["PasswordUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CodPerfil", $datosCreate["CodPerfil"], PDO::PARAM_STR);
    $statement -> bindParam(":CodArea", $datosCreate["CodArea"], PDO::PARAM_STR);

    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "error";
    }
  }

  //  Mostrar los datos a editar de un usuario
  public static function mdlMostrarDatosEditar($tabla, $codUsuario)
  {
    $statement = Conexion::conn()->prepare("SELECT tba_usuario.IdUsuario, tba_usuario.NombreUsuario, tba_usuario.CodArea, tba_usuario.CorreoUsuario, tba_usuario.IdPerfilUsuario, tba_areausuario.NombreArea, tba_perfilusuario.NombrePerfil FROM $tabla INNER JOIN tba_areausuario ON tba_usuario.CodArea = tba_areausuario.CodArea INNER JOIN tba_perfilusuario ON tba_usuario.IdPerfilUsuario = tba_perfilusuario.IdPerfil WHERE tba_usuario.IdUsuario = $codUsuario");
    $statement -> execute();
    return $statement -> fetch();
  }

  //  Editar datos de un usuario
  public static function mdlUpdateUsuario($tabla, $datosUpdate)
  {
    $statement = Conexion::conn()->prepare("UPDATE $tabla SET NombreUsuario=:NombreUsuario, CorreoUsuario=:CorreoUsuario, CodArea=:CodArea, CodPerfil=:CodPerfil WHERE CodUsuario=:CodUsuario");
    $statement -> bindParam(":NombreUsuario", $datosUpdate["NombreUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CorreoUsuario", $datosUpdate["CorreoUsuario"], PDO::PARAM_STR);
    $statement -> bindParam(":CodArea", $datosUpdate["CodArea"], PDO::PARAM_STR);
    $statement -> bindParam(":CodPerfil", $datosUpdate["CodPerfil"], PDO::PARAM_STR);
    $statement -> bindParam(":CodUsuario", $datosUpdate["CodUsuario"], PDO::PARAM_STR);
    if($statement -> execute())
    {
      return "ok";
    }
    else
    {
      return "erro";
    }
  }

  //  Eliminar usuario
  public static function mdlEliminarUsuario($tabla, $codUsuario)
  {
    $statement = Conexion::conn()->prepare("DELETE FROM $tabla WHERE CodUsuario = $codUsuario");
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