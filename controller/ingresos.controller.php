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
        "IdUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["numeroDocumentoIngreso"],
        "NombreProveedor" => $_POST["nombreProveedor"],
        "Total" => $_POST["nuevoTotalIngreso"],
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
}