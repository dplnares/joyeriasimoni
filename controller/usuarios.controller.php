<?php

class ControllerUsuarios
{
  //  Verificar los valores para iniciar sesión  
  static public function ctrIniciarSesion()
  {
    if (isset($_POST["inputEmail"]))
    {
      $passwordCrypt = crypt($_POST["inputPassword"], '$2a$07$usesomesillystringfore2uDLvp1Ii2e./U9C8sBjqp8I90dH6hi');
      $email = $_POST["inputEmail"];
      $tabla = "tba_usuario";
      $parametro = "CorreoUsuario";

      $datosUsuario = ModelUsuarios::mdlMostrarUnUsuario($tabla, $parametro, $email);

      if($datosUsuario["CorreoUsuario"] == $_POST["inputEmail"] && $datosUsuario["PasswordUsuario"] == $passwordCrypt)
      {
        $_SESSION["login"] = "ok";
        $_SESSION["emailUsuario"] = $datosUsuario["CorreoUsuario"];
        $_SESSION["perfilUsuario"] = $datosUsuario["IdPerfil"];
        $_SESSION["nombreUsuario"] = $datosUsuario["NombreUsuario"];
        
        //  Registramos la fecha para el último login --> Colocar en un solo método para guardar varios registros
        date_default_timezone_set('America/Bogota');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $ultimoLogin = $fecha.' '.$hora;

        echo '<script>
            window.location = "home";
          </script>';
        $registrarLogin = ModelUsuarios::mdlActualizarUltimoLogin($tabla, $ultimoLogin, $datosUsuario["IdUsuario"]);
        if ($registrarLogin == "ok")
        {
          echo '<script>
            window.location = "home";
          </script>';
        }
      }
      else
      {
        echo '<br><div class="alert alert-danger">Error en los datos ingresados, vuelve a intentarlo</div>';
      }
    }
  }

  //  Mostrar todos los usuarios actuales
  static public function ctrMostrarUsuarios()
  {
    $tabla = "tba_usuario";
    $listaUsuarios = ModelUsuarios::mdlMostrarUsuarios($tabla);
    return $listaUsuarios;
  }

  //  Agregar un nuevo usuario
  static public function ctrCrearUsuario()
  {
    if(isset($_POST["nombreUsuario"]))
    {
      $tabla = "tba_usuario";
      $passwordCrypt = crypt($_POST["passwordUsuario"], '$2a$07$usesomesillystringfore2uDLvp1Ii2e./U9C8sBjqp8I90dH6hi');
      $datosCreate = array(
        "NombreUsuario" => $_POST["nombreUsuario"],
        "CorreoUsuario" => $_POST["correoUsuario"],
        "PasswordUsuario" => $passwordCrypt,
        "IdPerfilUsuario" => $_POST["perfilUsuario"],
        "FechaCreacion"=>date("Y-m-d"),
        "FechaActualizacion"=>date("Y-m-d"),
      );

      $respuesta = ModelUsuarios::mdlIngresarUsuario($tabla, $datosCreate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "¡Usuario ingresado Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
        </script>';
      }	
    }
  }

  //  Mostrar los perfiles de los usuarios
  static public function ctrMostrarPerfiles()
  {
    $tabla = "tba_perfilusuario";
    $listaPerfiles = ModelUsuarios::mdlMostrarPerfiles($tabla);
    return $listaPerfiles;
  }











  //  Editar Usuario
  static public function ctrEditarUsuario()
  {
    if(isset($_POST["editarNombre"]))
    {
      $tabla = "tba_usuario";
      $datosUpdate = array(
        "NombreUsuario" =>  $_POST["editarNombre"],
        "CorreoUsuario" => $_POST["editarCorreo"],
        "CodPerfil" => $_POST["editarPerfil"],
        "CodUsuario" => $_POST["codUsuario"],
      );

      $respuesta = ModelUsuarios::mdlUpdateUsuario($tabla, $datosUpdate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "¡Usuario editado Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
        </script>';
      }
    }
  }

  //  Eliminar usuario
  public static function ctrBorrarUsuario()
  {
    if (isset($_GET["codUsuario"]))
    {
      $tabla = "tba_usuario";
      $codUsuario = $_GET["codUsuario"];
      $respuesta = ModelUsuarios::mdlEliminarUsuario($tabla, $codUsuario);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "¡Usuario editado Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "usuarios";
						}
					});
        </script>';
      }
    }
  }

}