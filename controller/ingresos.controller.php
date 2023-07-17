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
        "FechaIngreso" => $_POST["fechaDeIngreso"],
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
    if(isset($_POST["editarNumeroDocumentoIngreso"]))
		{
      //  Datos para agregar la cabecera del ingreso
      $tablaCabecera = "tba_movimiento";
      $codTienda = $_POST["codTienda"];
      $codIngreso = $_POST["codIngreso"];

      $datosUpdateCabecera = array(
        "IdMovimiento" => $_POST["codIngreso"],
        "ActualizaUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["editarNumeroDocumentoIngreso"],
        "NombreProveedor" => $_POST["editarNombreProveedor"],
        "Total" => $_POST["nuevoTotalIngreso"],
        "FechaIngreso" => $_POST["editarFechaDeIngreso"],
        "FechaActualizacion"=> date("Y-m-d")
      );
		
      $respuestaCabecera = ModelIngresos::mdlEditarCabeceraIngreso($tablaCabecera, $codIngreso, $datosUpdateCabecera);
      
      //  Ingresar el detalle del ingreso registrado si se ingreso la cabecera correctamente
      if($respuestaCabecera == "ok")
      {
        //  Obtener todos los recursos registrados y agregar cada uno a la tabla detalle de movimiento
        $listarProductos = json_decode($_POST["listarProductosIngreso"], true);

        $tablaDetalle = "tba_detallemovimiento";
        
        //  Modificar el stock previo a la edición del ingreso, es decir eliminar cada detalle del ingreso en el stock y posteriormente añadir el nuevo detalle que se tiene
        $listarProductosAnteriores = ModelIngresos::mdlObtenerListaEliminar($tablaDetalle, $codIngreso);

        foreach($listarProductosAnteriores as $value)
        {
          $respuestaEliminarStock = ControllerStock::ctrActualizarEliminacionIngreso($codTienda, $listarProductosAnteriores);      
        }

        if($respuestaEliminarStock == "ok")
        {
          //  Eliminar el detalle actual y luego ingresar el nuevo detalle del ingreso
          $eliminarDetalle = ModelIngresos::mdlEliminarDetalleIngreso($tablaDetalle ,$codIngreso);

          foreach ($listarProductos as $value) 
          {
            $idProducto = $value["CodRecurso"];
            $cantidad = $value["Cantidad"];
            $precioUnitario = $value["PrecioUnitario"];
            $parcial = $value["ParcialProducto"];
  
            $datosDetalle = array(
              "IdMovimiento" => $codIngreso,
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
              $stockActual = ControllerStock::ctrObtenerStockActualProducto($idProducto, $codTienda);
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
                  "IdTienda" => $codTienda,
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
        }
        else
        {
          echo '
            <script>
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "¡Error al actualizar el stock!",
              }).then(function(result){
                if(result.value){
                  window.location = "index.php?ruta=ingresos&codTienda='.$codTienda.'";
                }
              });
            </script>
          ';
        }

        if ($respuestaStock == "ok")
        {
          echo '
            <script>
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "¡Ingreso registrado Correctamente!",
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
                text: "¡Error al ingresar el registro!",
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
              text: "¡Error al ingresar el registro!",
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