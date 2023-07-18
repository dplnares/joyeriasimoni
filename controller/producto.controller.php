<?php

class ControllerProductos
{
  //  Crear un nuevo producto
  public static function ctrCrearProducto()
  {
    if(isset($_POST["nombreProducto"]))
    {
      $tabla = "tba_producto";
      $datosCreate = array(
        "IdCategoria" => $_POST["categoriaProducto"],
        "CodProducto" => $_POST["codigoProducto"],
        "DescripcionProducto" => $_POST["nombreProducto"],
        "PrecioUnitarioProducto" => $_POST["precioProducto"],
        "PesoProducto" => $_POST["pesoProducto"],
        "CreadoUsuario" => $_SESSION["idUsuario"],
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "FechaCreacion"=> date("Y-m-d"),
        "FechaActualizacion"=> date("Y-m-d"),
      );

      $respuesta = ModelProductos::mdlIngresarNuevoProducto($tabla, $datosCreate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Prducto Registrado Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "producto";
						}
					});
        </script>';
      }	
    }
  }

  //  Editar producto
  public static function ctrEditarProducto()
  {
    if(isset($_POST["editarNombre"]))
    {
      $tabla = "tba_producto";
      $datosUpdate = array(
        "DescripcionProducto" =>  $_POST["editarNombre"],
        "CodProducto" => $_POST["editarCodigo"],
        "IdCategoria" => $_POST["editarCategoria"],
        "PrecioUnitarioProducto" => $_POST["editarPrecio"],
        "PesoProducto" => $_POST["editarPeso"],
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "FechaActualizacion" => date("Y-m-d"),
        "IdProducto" => $_POST["codProducto"]
      );

      $respuesta = ModelProductos::mdlUpdateProducto($tabla, $datosUpdate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Tienda Editada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "producto";
						}
					});
        </script>';
      }
    }
  }

  //  Eliminar productos
  public static function ctrEliminarProductos()
  {
    if (isset($_GET["codProducto"]))
    {
      $tabla = "tba_producto";
      $codProducto = $_GET["codProducto"];
      $respuesta = ModelProductos::mdlEliminarProducto($tabla, $codProducto);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Producto Eliminado Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "producto";
						}
					});
        </script>';
      }
    }
  }
  
  //  Mostrar todos los productos
  public static function ctrMostrarProductos()
  {
    $tabla = "tba_producto";
    $listaProductos = ModelProductos::mdlMostrarProductos($tabla);
    return $listaProductos;
  }

  //  Mostrar datos para editar producto
  public static function ctrMostrarDatosEditar($codProducto)
  {
    $tabla = "tba_producto";
    $datosProducto = ModelProductos::mdlMostrarDatosEditar($tabla, $codProducto);
    return $datosProducto;
  }

  //  Mostrar listado de productos para ingresos
  public static function ctrMostrarProductosModalIngreso()
  {
    $tabla = "tba_producto";
    $listaProductos = ModelProductos::mdlMostrarProductosModal($tabla);
    return $listaProductos;
  }

  //  Mostrar los datos de un producto en específico
  public static function ctrMostrarDatosProducto($codProducto)
  {
    $tabla = "tba_producto";
    $datosProducto = ModelProductos::mdlMostrarDatosProducto($tabla, $codProducto);
    return $datosProducto;
  }

  //  Obtener el precio unitario de un producto
  public static function ctrObtenerPrecioUnitario($codProducto)
  {
    $tabla = "tba_producto";
    $respuesta = ModelProductos::mdlObtenerPrecioUnitario($tabla, $codProducto);
    return $respuesta;
  }
}