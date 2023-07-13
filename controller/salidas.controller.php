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
        "IdUsuario" => $_SESSION["idUsuario"],
        "NumeroDocumento" => $_POST["numeroDocumentoSalida"],
        "NombreCliente" => $_POST["nombreCliente"],
        "Total" => $_POST["nuevoTotalSalida"],
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
}