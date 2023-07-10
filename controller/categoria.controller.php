<?php

class ControllerCategorias
{
  //  Agregar nueva categoria
  public static function ctrCrearCategoria()
  {
    if(isset($_POST["nombreCategoria"]))
    {
      $tabla = "tba_categoria";
      $datosCreate = array(
        "NombreCategoria" => $_POST["nombreCategoria"],
        "CodCategoria" => $_POST["codigoCategoria"],
        "DescripcionCategoria" => $_POST["descripcionCategoria"],
        "FechaCreacion"=> date("Y-m-d"),
        "FechaActualizacion"=> date("Y-m-d"),
      );

      $respuesta = ModelCategorias::mdlIngresarNuevaCategoria($tabla, $datosCreate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Categoria Creada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "categoria";
						}
					});
        </script>';
      }	
    }
  }

  //  Editar Categoria
  public static function ctrEditarCategoria()
  {
    if(isset($_POST["editarNombre"]))
    {
      $tabla = "tba_categoria";
      $datosUpdate = array(
        "NombreCategoria" =>  $_POST["editarNombre"],
        "CodCategoria" => $_POST["editarCodigo"],
        "DescripcionCategoria" => $_POST["editarDescripcion"],
        "IdCategoria" => $_POST["codCategoria"],
        "FechaActualizacion" => date("Y-m-d"),
      );

      $respuesta = ModelCategorias::mdlUpdateCategoria($tabla, $datosUpdate);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Categoria Editada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "categoria";
						}
					});
        </script>';
      }
    }
  }

  //  Eliminar Categoria
  public static function ctrEliminarCategoria()
  {
    if (isset($_GET["codCategoria"]))
    {
      $tabla = "tba_categoria";
      $codCategoria = $_GET["codCategoria"];
      $respuesta = ModelCategorias::mdlEliminarCategoria($tabla, $codCategoria);
      if($respuesta == "ok")
      {
        echo '
        <script>
          Swal.fire({
            icon: "success",
            title: "Correcto",
            text: "Categoria Eliminada Correctamente!",
          }).then(function(result){
						if(result.value){
							window.location = "categoria";
						}
					});
        </script>';
      }
    }
  }

  //  Mostrar todas las categorias datable
  public static function ctrMostrarCategorias()
  {
    $tabla = "tba_categoria";
    $listaCategorias = ModelCategorias::mdlMostrarCategorias($tabla);
    return $listaCategorias;
  }

  //  Mostrar datos para editar categoria
  public static function ctrMostrarDatosEditar($codCategoria)
  {
    $tabla = "tba_categoria";
    $datosTienda = ModelCategorias::mdlMostrarDatosEditar($tabla, $codCategoria);
    return $datosTienda;
  }

  //  Mostrar las categorias para un producto
  public static function ctrMostrarCategoriaSelect()
  {
    $tabla = "tba_categoria";
    $listaCategorias = ModelCategorias::mdlMostrarCategoriasSelect($tabla);
    return $listaCategorias;
  }
  
}