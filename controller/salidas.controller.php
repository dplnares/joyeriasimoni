<?php

class ControllerSalidas
{
  //  Mostrar todas las salidas de la tienda
  public static function ctrMostrarSalidasTienda()
  {
    if(isset($_GET["codTienda"]))
    {
      $tabla = "tba_movimiento";
      $codTienda = $_GET["codTienda"];
      //  Tipo de movimiento 2 son las salidas
      $tipoMovimiento = 2;
      $respuesta = ModelSalidas::mdlMostrarSalidasTienda($tabla, $codTienda, $tipoMovimiento);
      return $respuesta;
    }
  }

  //  Crear una nueva salida
  public static function ctrCrearSalida()
  {
    if(isset($_POST["numeroDocumentoSalida"]))
		{
      //  Datos para agregar la cabecera de la salida
      $tablaCabecera = "tba_movimiento";
      $tiendaActual = $_POST["codTienda"];

      $datosCabecera = array(
        "IdTipoMovimiento" => "2",
        "IdTienda" => $tiendaActual,
        "CreadoUsuario" => $_SESSION["idUsuario"],
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["numeroDocumentoSalida"],
        "NombreCliente" => $_POST["nombreCliente"],
        "Total" => $_POST["nuevoTotalSalida"],
        "FechaMovimiento" => $_POST["fechaSalida"],
        "FechaCreacion"=> date("Y-m-d"),
        "FechaActualizacion"=> date("Y-m-d")
      );
		
      $respuestaCabecera = ModelSalidas::mdlIngresarCabeceraSalida($tablaCabecera, $datosCabecera);
      $idUltimoMovimiento = ModelIngresos::mdlObtenerUltimoId($tablaCabecera);
      
      //  Ingresar el detalle del ingreso registrado si se ingreso la cabecera correctamente
      if($respuestaCabecera == "ok")
      {
        //  Obtener todos los recursos registrados y agregar cada uno a la tabla detalle de movimiento
        $listarProductos = json_decode($_POST["listarProductosSalida"], true);
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

          $respuestaDetalle = ModelSalidas::mdlIngresarDetalleSalida($tablaDetalle, $datosDetalle);
        
          //  Actualizar el stock luego de que se agrego correctamente el detalle del ingreso
          if($respuestaDetalle == "ok")
          {
            $stockActual = ControllerStock::ctrObtenerStockActualProducto($idProducto, $tiendaActual);
            //  Se realiza una resta de la cantidad de salida con el stock actual del producto, si es menor a 0, significa que está sacando mas de lo permitido, por lo cual hay un error y se mandará un mensaje de error. Caso contrario, solo se restará del stock actual y este se actualizará.
            $nuevoStock = $stockActual["CantidadActual"] - $cantidad;
            $nuevoStockSalidas = $stockActual["CantidadSalidas"] + $cantidad;
            if($nuevoStock < 0)
            {
              echo '
                <script>
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "La cantidad que registro, es superior al stock actual!",
                  }).then(function(result){
                    if(result.value){
                      window.location = "index.php?ruta=salidas&codTienda='.$tiendaActual.'";
                    }
                  });
                </script>
              ';
            }
            else
            {
              $datosStockUpdate = array(
                "CantidadSalidas"=> $nuevoStockSalidas,
                "CantidadActual"=> $nuevoStock,
                "PrecioUnitario"=> $precioUnitario,
                "PrecioTotal"=> $parcial,
                "FechaActualizacion"=> date("Y-m-d")
              );
              $respuestaStock = ControllerStock::ctrActualizarStockSalida($stockActual["IdStock"], $datosStockUpdate);
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
                text: "Salida registrada Correctamente!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=salidas&codTienda='.$tiendaActual.'";
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
                  window.location = "index.php?ruta=salidas&codTienda='.$tiendaActual.'";
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
                window.location = "index.php?ruta=salidas&codTienda='.$tiendaActual.'";
              }
            });
          </script>
        ';
      }
    }
  }

  //  Mostrar el detalle de la salida
  public static function ctrMostrarDetalleSalida($codSalidaVisualizar)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelSalidas::mdlMostrarDetalleSalida($tabla, $codSalidaVisualizar);
    return $respuesta;
  }

  //  Eliminar una salida
  public static function ctrEliminarSalida()
  {
    if (isset($_GET["codSalida"]))
    {
      $tablaMovimientos = "tba_movimiento";
      $tablaDetalle = "tba_detallemovimiento";

      $codSalida = $_GET["codSalida"];
      $codTienda = $_GET["codTienda"];

      $listaDetalleSalida = self::ctrObtenerListaEliminar($codSalida);
      
      //  Eliminar la salida sin ningun problema de negativos, al eliminar el registro solo se añadirá las cantidades que fueron egresadas por el registro
      $eliminarSalida = ControllerStock::ctrActualizarEliminacionSalida($codTienda, $listaDetalleSalida);

      //  Si se hace el update en el stock de los recursos eliminados, se procederá a eliminar el detalle de la salida y posteriormente la cabecera
      if($eliminarSalida == "ok")
      {
        $respuestaEliminacionDetalle = ModelSalidas::mdlEliminarDetalleSalida($tablaDetalle, $codSalida);
        if($respuestaEliminacionDetalle == "ok")
        {
          $respuestaEliminacionCabecera = ModelSalidas::mdlEliminarCabeceraSalida($tablaMovimientos, $codSalida);

          if($respuestaEliminacionCabecera == "ok")
          {
            echo '
              <script>
                Swal.fire({
                  icon: "success",
                  title: "Correcto",
                  text: "¡La salida se eliminó correctamente!",
                }).then(function(result){
                  if(result.value){
                    window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
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
                  text: "La cabecera de la salida no fue eliminada correctamente",
                }).then(function(result){
                  if(result.value){
                    window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
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
                text: El detalle de la salida no fue eliminado correctamente",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
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
                window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
              }
            });
          </script>';
      }
    }
  }

  //  Obtener la lista de reucrsos que se va a eliminar
  public static function ctrObtenerListaEliminar($codSalida)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelSalidas::mdlObtenerListaEliminar($tabla, $codSalida);
    return $respuesta;
  }

  //  Obtener la cabecera de la salida
  public static function ctrObtenerDatosCabecera($codSalida)
  {
    $tabla = "tba_movimiento";
    $respuesta = ModelSalidas::mdlObtenerCabeceraSalida($tabla, $codSalida);
    return $respuesta;
  }

  //  Obtener el detalle de la salida
  public static function ctrObtenerDetalleSalidaEditar($codSalida)
  {
    $tabla = "tba_detallemovimiento";
    $respuesta = ModelSalidas::mdlOBtenerDetalleSalidaEditar($tabla, $codSalida);
    return $respuesta;
  }

  //  Editar salida
  public static function ctrEditarSalida()
  {
    if(isset($_POST["listarProductosSalida"]))
		{
      $tablaCabecera = "tba_movimiento";
      $tablaDetalle = "tba_detallemovimiento";
      $codSalida = $_POST["codSalida"];
      $codTienda = $_POST["codTienda"];

      $l3 = array();
      $l4 = array();
      $listaAntigua = ModelSalidas::mdlObtenerListaAntigua($tablaDetalle, $codSalida);
      $listaNueva = json_decode($_POST["listarProductosSalida"], true);

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

      $datosUpdateCabecera = array(
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["editarNumeroSalida"],
        "NombreCliente"=> $_POST["editarNombreCliente"],
        "Total" => $_POST["nuevoTotalSalida"],
        "FechaMovimiento"=> $_POST["editarFechaSalida"],
        "FechaActualizacion"=> date("Y-m-d"),
      );

      $respuestaCabecera = ModelSalidas::mdlEditarCabeceraSalida($tablaCabecera, $codSalida, $datosUpdateCabecera);
      if($respuestaCabecera == "ok")
      {
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
                //  Si se eliminó un recurso, este debe sumarse al stock que había previamente. -> El stock se sumará luego, al ingresar la nueva salida
                $Eliminar = ModelSalidas::mdlEliminarEditarDetalleSalida($tablaDetalle, $codSalida, $valueL3["IdProducto"]);
                if($Eliminar == "ok")
                {
                  ControllerStock::ctrEliminarUnRecursoSalida($codTienda, $valueL3["IdProducto"], $valueL3["CantidadMovimiento"]);
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
            //  De tener los mismo valores en las guías de la salida, solo actualizaremos los valores y el precio de la salida
            if($valueL4["IdProducto"] == $valueL3["IdProducto"])
            {
              $datosUpdateDetalle = array(
                "IdMovimiento" => $codSalida,
                "IdProducto" => $valueL4["IdProducto"],
                "CantidadMovimiento"=>$valueL4["CantidadMovimiento"],
                "ParcialTotal"=>$valueL4["ParcialTotal"],
                "FechaActualizacion"=> date("Y-m-d")
              );
              $Actualizar = ModelSalidas::mdlActualizarDetalleSalida($tablaDetalle, $datosUpdateDetalle);

              if($Actualizar == "ok")
              {
                $datosStock = array(
                  "CodTienda" => $codTienda,
                  "IdProducto" => $valueL4["IdProducto"],
                  "CantidadAntigua" => $valueL3["CantidadMovimiento"],
                  "CantidadNueva" => $valueL4["CantidadMovimiento"]
                );
                //  Editar el stock de un ingreso
                $respuestaDetalle = ControllerStock::ctrEditarUnaSalida($datosStock);
              }
            }
            else
            //  De no ser iguales, significa que el producto no tiene movimientos y por lo tanto no se puede hacer salidas de este
            {
              $respuestaDetalle = "error";
            }
          }
          if($respuestaDetalle == "ok")
          {
            echo '
            <script>
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "Salida editado Correctamente!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
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
                  text: "¡Error al editar el detalle de la salida!",
                }).then(function(result){
                  if(result.value){
                    window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
                  }
                });
              </script>
            ';
          }
        }
      }
      else
      {
        echo '
          <script>
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "¡Error al editar la salida!",
            }).then(function(result){
              if(result.value){
                window.location = "index.php?ruta=salidas&codTienda='.$codTienda.'";
              }
            });
          </script>
        ';
      }
      
    }
  }
}