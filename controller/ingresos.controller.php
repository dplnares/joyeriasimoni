<?php

class ControllerIngresos
{
  //  Agregar un nuevo Ingreso
  public static function ctrCrearIngreso()
  {
    if(isset($_POST["numeroDocumentoIngreso"]))
		{
      //  Datos para agregar la cabecera del ingreso
      $tablaCabecera = "tba_movimiento";
      $tiendaActual = $_POST["codTienda"];

      $datosCabecera = array(
        "IdTipoMovimiento" => "1",
        "IdTienda" => $tiendaActual,
        "CreadoUsuario" => $_SESSION["idUsuario"],
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["numeroDocumentoIngreso"],
        "NombreProveedor" => $_POST["nombreProveedor"],
        "Total" => $_POST["nuevoTotalIngreso"],
        "FechaMovimiento" => $_POST["fechaDeIngreso"],
        "FechaCreacion"=> date("Y-m-d"),
        "FechaActualizacion"=> date("Y-m-d")
      );
		
      $respuestaCabecera = ModelIngresos::mdlIngresarCabeceraIngreso($tablaCabecera, $datosCabecera);
      $idUltimoMovimiento = ModelIngresos::mdlObtenerUltimoId($tablaCabecera);
      
      //  Ingresar el detalle del ingreso registrado si se ingreso la cabecera correctamente
      if($respuestaCabecera == "ok")
      {
        //  Obtener todos los recursos registrados y agregar cada uno a la tabla detalle de movimiento
        $listarProductos = json_decode($_POST["listarProductosIngreso"], true);
        $tablaDetalle = "tba_detallemovimiento";
        
        foreach ($listarProductos as $key => $value) 
        {
          $idMovimiento = $idUltimoMovimiento["id"];
          $idProducto = $value["CodRecurso"];
          $cantidad = $value["Cantidad"];
          $precioUnitario = $value["PrecioUnitario"];
          $parcial = $value["ParcialProducto"];

          $datosDetalle = array(
            "IdMovimiento" => $idMovimiento,
            "IdProducto" => $idProducto,
            "CantidadMovimiento"=> $cantidad,
            "PrecioUnitario"=> $precioUnitario,
            "ParcialTotal" => $parcial,
            "FechaCreacion"=> date("Y-m-d"),
            "FechaActualizacion"=> date("Y-m-d")
          );

          $respuestaDetalle = ModelIngresos::mdlIngresarDetalleIngreso($tablaDetalle, $datosDetalle);
        
          //  Actualizar el stock luego de que se agrego correctamente el detalle del ingreso
          if($respuestaDetalle == "ok")
          {
            $stockActual = ControllerStock::ctrObtenerStockActualProducto($idProducto, $tiendaActual);
            //  Si el stock de ese producto es cero, se creará un nuevo registro. Caso contrario se actualizará el registro previo
            if($stockActual != null)
            {
              $nuevaCantidadIngreso = $stockActual["CantidadIngresos"] + $cantidad;
              $cantidadActual = $nuevaCantidadIngreso - $stockActual["CantidadSalidas"];
              $nuevoParcial = $cantidadActual * $precioUnitario;

              $datosStockUpdate = array(
                "CantidadIngresos" => $nuevaCantidadIngreso,
                "CantidadActual" => $cantidadActual,
                "PrecioUnitario" => $precioUnitario,
                "PrecioTotal" => $nuevoParcial,
                "FechaActualizacion" => date("Y-m-d")
              );
              $respuestaStock = ControllerStock::ctrActualizarStockIngreso($stockActual["IdStock"], $datosStockUpdate);
            }
            else
            {
              $datosStockCreate = array(
                "IdTienda" => $tiendaActual,
                "IdProducto" => $idProducto,
                "CantidadIngresos"=> $cantidad,
                "CantidadSalidas"=> 0,
                "CantidadActual"=> $cantidad,
                "PrecioUnitario"=> $precioUnitario,
                "PrecioTotal"=> $parcial,
                "FechaCreacion"=> date("Y-m-d"),
                "FechaActualizacion"=> date("Y-m-d")
              );
              $respuestaStock = ControllerStock::ctrCrearRegistroStock($datosStockCreate);
            }
          }
        }
        if ($respuestaStock == "ok")
        {
          echo '
            <script>
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "Ingreso registrado Correctamente!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$tiendaActual.'";
                }
              });
            </script>
          ';
        }
        else
        {
          echo '
            <script>
              Swal.fire({
                icon: "error",
                title: "Correcto",
                text: "¡Error al ingresar el registro!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$tiendaActual.'";
                }
              });
            </script>
          ';
        }
      }
      else
      {
        echo '
          <script>
            Swal.fire({
              icon: "error",
              title: "Correcto",
              text: "¡Error al ingresar el registro!",
            }).then(function(result){
              if(result.value){
                window.location = "index.php?ruta=ingresos&codTienda='.$tiendaActual.'";
              }
            });
          </script>
        ';
      }
    }
  }

  //  Editar Ingreso
  public static function ctrEditarIngresos()
  {
    if(isset($_POST["listarProductosIngreso"]))
		{
      $tablaCabecera = "tba_movimiento";
      $tablaDetalle = "tba_detallemovimiento";
      $codIngreso = $_POST["codIngreso"];
      $codTienda = $_POST["codTienda"];

      $l3 = array();
      $l4 = array();
      $listaAntigua = ModelIngresos::mdlObtenerListaAntigua($tablaDetalle, $codIngreso);
      $listaNueva = json_decode($_POST["listarProductosIngreso"], true);

      //  Agregar los valores de cada listado nuevo y antiguo en los arrays l3 y l4
      foreach ($listaAntigua as $value) 
      {
        $l3[]=array(
        "IdProducto"=>$value["IdProducto"],
        "CantidadMovimiento"=>$value["CantidadMovimiento"],
        "ParcialTotal"=>$value["ParcialTotal"]
        );
      }

      foreach ($listaNueva as $value) 
      {
        $l4[]=array(
        "IdProducto"=>$value["CodRecurso"],
        "CantidadMovimiento"=>$value["Cantidad"],
        "ParcialTotal"=>$value["ParcialProducto"]
        );
      }

      //  Comparar las listas, sin son iguales continua con el siguiente bucle. Si son distintas elimina la lista actual del detalle 
      foreach ($l3 as $valueL3)
      {
        $contar = 0;
        foreach ($l4 as $valueL4)
        {
          if($valueL3["IdProducto"] == $valueL4["IdProducto"])
          {
            continue;			
          }
          else
          {
            $contar = $contar+1;
            if($contar == count($l4))
            {
              //  Si se eliminó un recurso, este debe restarse del stock que tiene la tienda
              $Eliminar = ModelIngresos::mdlEliminarEditarDetalleIngreso($tablaDetalle, $codIngreso, $valueL3["IdProducto"]);
              if($Eliminar == "ok")
              {
                ControllerStock::ctrEliminarUnRecursoIngreso($codTienda, $valueL3["IdProducto"], $valueL3["CantidadMovimiento"]);
              }
            }
          }
        }
      }

      //  Comparar las listas y actualizar el movimiento con el nuevo detalle
      foreach ($l4 as $valueL4) 
      {
        $contar=0;
        foreach($l3 as $valueL3)
        {
          //  De tener los mismo valores en las guías del ingreso, solo actualizaremos los valores y el precio del ingreso
          if($valueL4["IdProducto"] == $valueL3["IdProducto"])
          {
            $datosUpdateDetalle = array(
              "IdMovimiento" => $codIngreso,
              "IdProducto" => $valueL4["IdProducto"],
              "CantidadMovimiento"=>$valueL4["CantidadMovimiento"],
              "ParcialTotal"=>$valueL4["ParcialTotal"],
              "FechaActualizacion"=> date("Y-m-d")
            );
            $Actualizar = ModelIngresos::mdlActualizarDetalleIngreso($tablaDetalle, $datosUpdateDetalle);

            if($Actualizar == "ok")
            {
              $datosStock = array(
                "CodTienda" => $codTienda,
                "IdProducto" => $valueL4["IdProducto"],
                "CantidadAntigua" => $valueL3["CantidadMovimiento"],
                "CantidadNueva" => $valueL4["CantidadMovimiento"]
              );
              //  Editar el stock de un ingreso
              $respuestaDetalle = ControllerStock::ctrEditarUnIngreso($datosStock);
            }
          }
          else
          //  De no ser iguales, crearemos nuevos valores
          {
            $contar=$contar+1;
            if($contar == count($l3))
            {
              $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($valueL4["IdProducto"]);
              $datosCreateDetalle = array(
                "IdMovimiento" => $codIngreso,
                "IdProducto" => $valueL4["IdProducto"],
                "CantidadMovimiento"=>$valueL4["CantidadMovimiento"],
                "PrecioUnitario"=>$precioUnitario["PrecioUnitarioProducto"],
                "ParcialTotal"=>$valueL4["ParcialTotal"],
                "FechaCreacion"=> date("Y-m-d"),
                "FechaActualizacion"=> date("Y-m-d")
              );
              $CrearDetalle = ModelIngresos::mdlIngresarDetalleIngreso($tablaDetalle, $datosCreateDetalle);

              if($CrearDetalle == "ok")
              {
                $datosStock = array(
                  "CodTienda" => $codTienda,
                  "IdProducto" => $valueL4["IdProducto"],
                  "CantidadNueva" => $valueL4["CantidadMovimiento"],
                );
                $respuestaDetalle = ControllerStock::ctrEditarUnIngreso($datosStock);
              }
            }
          }
        }

        if($respuestaDetalle == "ok")
        {
          $datosUpdateCabecera = array(
            "ActualizaUsuario" => $_SESSION["idUsuario"],
            "NumeroDocumento" => $_POST["editarNumeroDocumentoIngreso"],
            "NombreProveedor"=> $_POST["editarNombreProveedor"],
            "Total" => $_POST["nuevoTotalIngreso"],
            "FechaMovimiento"=> $_POST["editarFechaDeIngreso"],
            "FechaActualizacion"=> date("Y-m-d"),
          );
  
          $respuestaCabecera = ModelIngresos::mdlEditarCabeceraIngreso($tablaCabecera, $codIngreso, $datosUpdateCabecera);
  
          if($respuestaCabecera == "ok")
          {
            echo '
            <script>
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "¡Ingreso editado Correctamente!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                }
              });
            </script>
            ';
          }
          else
          {
            echo '
            <script>
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "¡Error al editar el ingreso!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                }
              });
            </script>
            ';
          }
        }
        else
        {
          echo '
            <script>
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "¡Error al editar el ingreso!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                }
              });
            </script>
          ';
        }
      }
    }
  }

  //  Eliminar Ingreso
  public static function ctrEliminarIngreso()
  {
    if (isset($_GET["codIngreso"]))
    {
      $tablaMovimientos = "tba_movimiento";
      $tablaDetalle = "tba_detallemovimiento";

      $codIngreso = $_GET["codIngreso"];
      $codTienda = $_GET["codTienda"];

      $listaDetalleIngreso = self::ctrObtenerListaEliminar($codIngreso);
      
      //  Comprobar que todos los elemenos de la lista se pueden eliminar sin generar ningun negativo, de ser así se restaran todos los elementos registrados en el ingreso con el stock actual, caso contrario se mandará un mensaje de error.
      $confirmacionEliminarIngreso = ControllerStock::ctrConfirmarEliminarIngreso($codTienda, $listaDetalleIngreso);

      if($confirmacionEliminarIngreso == "ok")
      {
        $eliminarIngresos = ControllerStock::ctrActualizarEliminacionIngreso($codTienda, $listaDetalleIngreso);

        //  Si se hace el update en el stock de los recursos eliminados, se procederá a eliminar el detalle del ingreso y posteriormente la cabecera del mismo
        if($eliminarIngresos == "ok")
        {
          $respuestaEliminacionDetalle = ModelIngresos::mdlEliminarDetalleIngreso($tablaDetalle, $codIngreso);

          if($respuestaEliminacionDetalle == "ok")
          {
            $respuestaEliminacionCabecera = ModelIngresos::mdlEliminarCabeceraIngreso($tablaMovimientos, $codIngreso);

            if($respuestaEliminacionCabecera == "ok")
            {
              echo '
                <script>
                  Swal.fire({
                    icon: "success",
                    title: "Correcto",
                    text: "¡El ingreso se eliminó correctamente!",
                  }).then(function(result){
                    if(result.value){
                      window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                    }
                  });
                </script>';
            }
            else
            {
              echo '
                <script>
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El detalle del ingreso no fue eliminado correctamente",
                  }).then(function(result){
                    if(result.value){
                      window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                    }
                  });
                </script>';
            }
          }
          else
          {
            echo '
              <script>
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "La cabecera del ingreso no fue eliminado correctamente",
                }).then(function(result){
                  if(result.value){
                    window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                  }
                });
              </script>';
          }
        }
        else
        {
          echo '
            <script>
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "El stock no fue actualizado correctamente",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                }
              });
            </script>';
        }
      }
      else
      {
        echo '
          <script>
            Swal.fire({
              icon: "error",
              title: "¡Error!",
              text: "Uno de los productos no tiene suficiente stock",
            }).then(function(result){
              if(result.value){
                window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
              }
            });
          </script>';
      }
    }
  }

  //  Mostrar todos los ingresos de una tienda
  public static function ctrMostrarIngresosTienda()
  {
    if(isset($_GET["codTienda"]))
    {
      $tabla = "tba_movimiento";
      $codTienda = $_GET["codTienda"];
      //  Tipo de movimiento 1 son los ingresos
      $tipoMovimiento = 1;
      $respuesta = ModelIngresos::mdlMostrarIngresosTienda($tabla, $codTienda, $tipoMovimiento);
      return $respuesta;
    }
  }

  //  Mostrar detalle del ingreso
  public static function ctrMostrarDetalleIngreso($codIngresoVisualizar)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelIngresos::mdlMostrarDetalleIngreso($tabla, $codIngresoVisualizar);
    return $respuesta;
  }

  //  Mostrar detalle del ingreso para editar el movimiento
  public static function ctrObtenerDetalleIngresoEditar($codIngreso)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelIngresos::mdlOBtenerDetalleIngresoEditar($tabla, $codIngreso);
    return $respuesta;
  }

  //  Obtener la lista de reucrsos que se va a eliminar
  public static function ctrObtenerListaEliminar($codIngreso)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelIngresos::mdlObtenerListaEliminar($tabla, $codIngreso);
    return $respuesta;
  }

  //  Obtener los datos de la cabecera de un ingreso
  public static function ctrObtenerDatosCabecera($codIngreso)
  {
    $tabla = "tba_movimiento";
    $respuesta = ModelIngresos::mdlObtenerCabeceraIngreso($tabla, $codIngreso);
    return $respuesta;
  }
}