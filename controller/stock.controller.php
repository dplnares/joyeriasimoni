<?php

class ControllerStock
{
  //  Mostrar el stock actual por proyecto
  public static function ctrMostrarStockActual()
  {
    if(isset($_GET["codTienda"]))
    {
      $tabla = "tba_stock";
      $codTienda = $_GET["codTienda"];
      $respuesta = ModelStock::mdlMostrarStockActual($tabla, $codTienda);
      return $respuesta;
    }
  }

  //  Actualizar las cantidades del stock por eliminación de una lista de ingresos
  public static function ctrActualizarEliminacionIngreso($codTienda, $listaDetalleIngreso)
  {
    $respuesta = "ok";
    foreach($listaDetalleIngreso as $value)
    {
      $datosStockActual = self::ctrObtenerStockActualProducto($value["IdProducto"], $codTienda);
      $nuevaCantidadActual = $datosStockActual["CantidadActual"] - $value["CantidadMovimiento"];
      $nuevaCantidadIngresos = $datosStockActual["CantidadIngresos"] - $value["CantidadMovimiento"];
      $nuevoParcial = $datosStockActual["PrecioUnitario"] * $nuevaCantidadActual;

      $datosStockUpdate = array(
        "CantidadIngresos" => $nuevaCantidadIngresos,
        "CantidadActual" => $nuevaCantidadActual,
        "PrecioTotal" => $nuevoParcial,
        "FechaActualizacion" => date("Y-m-d")
      );
      $respuesta = self::ctrActualizarIngresoEliminado($datosStockActual["IdStock"], $datosStockUpdate);

      if($respuesta == "ok")
      {
        continue;
      }
      else
      {
        $respuesta == "error";
      }
    }
    return $respuesta;
  }

  //  Actualizar las cantidades del stock por eliminación de una lista de salidas
  public static function ctrActualizarEliminacionSalida($codTienda, $listaDetalleSalida)
  {
    $respuesta = "ok";
    foreach($listaDetalleSalida as $value)
    {
      $datosStockActual = self::ctrObtenerStockActualProducto($value["IdProducto"], $codTienda);
      $nuevaCantidadActual = $datosStockActual["CantidadActual"] + $value["CantidadMovimiento"];
      $nuevaCantidadSalidas = $datosStockActual["CantidadSalidas"] - $value["CantidadMovimiento"];
      $nuevoParcial = $datosStockActual["PrecioUnitario"] * $nuevaCantidadActual;

      $datosStockUpdate = array(
        "CantidadSalidas" => $nuevaCantidadSalidas,
        "CantidadActual" => $nuevaCantidadActual,
        "PrecioTotal" => $nuevoParcial,
        "FechaActualizacion" => date("Y-m-d")
      );
      $respuesta = self::ctrActualizarSalidaEliminado($datosStockActual["IdStock"], $datosStockUpdate);

      if($respuesta == "ok")
      {
        continue;
      }
      else
      {
        $respuesta == "error";
      }
    }
    return $respuesta;
  }

  //  Enviar confirmación de eliminar el ingreso
  public static function ctrConfirmarEliminarIngreso($codTienda, $listaDetalleIngreso)
  {
    //  La respuesta por defecto es ok, en caso de que la resta del stock actual y la cantidad a eliminar sea menor a 0, cambiará a error
    $respuesta = "ok";
    foreach($listaDetalleIngreso as $value)
    {
      $cantidadActual = self::ctrObtenerStockActualProducto($value["IdProducto"], $codTienda);
      $nuevaCantidad = $cantidadActual["CantidadActual"] - $value["CantidadMovimiento"];
      if($nuevaCantidad < 0)
      {
        $respuesta = "error";
      }
      else
      {
        continue;
      }
    }
    return $respuesta;
  }

  //  Mostrar el stock actual de un producto en una tienda en específico
  public static function ctrObtenerStockActualProducto($codProducto, $codTienda)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlObtenerStockActualProducto($tabla, $codProducto, $codTienda);
    return $respuesta;
  }

  //  Update del stock actual de un ingreso
  public static function ctrActualizarStockIngreso($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockIngreso($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Actualizar el stock luego de eliminarse un ingreso
  public static function ctrActualizarIngresoEliminado($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockIngresoEliminado($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Actualizar el stock luego de eliminarse una salida
  public static function ctrActualizarSalidaEliminado($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockSalidaEliminado($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Update del stock actual de una salida
  public static function ctrActualizarStockSalida($codStock, $datosStockUpdate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlUpdateStockSalida($tabla, $codStock, $datosStockUpdate);
    return $respuesta;
  }

  //  Crear un nuevo stocck de un producto
  public static function ctrCrearRegistroStock($datosStockCreate)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlCrearRegistroStock($tabla, $datosStockCreate);
    return $respuesta;
  }

  //  Mostrar todos los productos en stock
  public static function ctrMostrarProductosEnStock()
  {
    $tabla = "tba_stock";
    $codTienda = $_GET["codTienda"];
    $respuesta = ModelStock::mdlObtenerProductosEnStock($tabla, $codTienda);
    return $respuesta;
  }

  //  Mostrar todos los productos en stock
  public static function ctrMostrarProductosEnStockTienda($codTienda)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlObtenerProductosEnStock($tabla, $codTienda);
    return $respuesta;
  }

  //  Mostrar datos del reporte
  public static function ctrMostrarReporte($codTienda)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlObtenerReporteTienda($tabla, $codTienda);
    return $respuesta;
  }

  //  Mostrar el stock por campo seleccionado
  public static function ctrMostrarStockPorCampo($campoBusqueda, $valorBuscado)
  {
    $tabla = "tba_stock";
    $respuesta = ModelStock::mdlObtenerStockGeneral($campoBusqueda, $valorBuscado);
    return $respuesta;
  }

  //  Cambiar el stock de un item por modificación 
  public static function ctrEditarUnIngreso($datosStock)
  {
    $tabla = "tba_stock";
    $stockActual = self::ctrObtenerStockActualProducto($datosStock["IdProducto"], $datosStock["CodTienda"]);
    //  Si el recurso ya tiene movimiento en ese almacén, solo se corregirá el stock actual de ese recurso
    if($stockActual != null || $stockActual != "")
    {
      $nuevaCantidadIngresos = $stockActual["CantidadIngresos"] - $datosStock["CantidadAntigua"];
      $nuevaCantidadIngresos = $nuevaCantidadIngresos + $datosStock["CantidadNueva"];

      $nuevaCantidadActual = $stockActual["CantidadActual"] - $datosStock["CantidadAntigua"];
      $nuevaCantidadActual = $nuevaCantidadActual + $datosStock["CantidadNueva"];

      $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($datosStock["IdProducto"]);
      $nuevoPrecioTotal = $nuevaCantidadActual * $precioUnitario["PrecioUnitarioProducto"];
      
      $datosUpdateStock = array(
        "IdProducto" => $datosStock["IdProducto"],
        "IdTienda" => $datosStock["CodTienda"],
        "CantidadIngresos" => $nuevaCantidadIngresos,
        "CantidadActual" => $nuevaCantidadActual,
        "PrecioTotal" => $nuevoPrecioTotal,
        "FechaActualizacion" => date("Y-m-d")
      );
      $respuesta = ModelStock::mdlActualizarStockIngreso($tabla, $datosUpdateStock);
    }
    
    //  Si no se tiene movimiento de ese recurso en almacén, creará un nuevo registro del stock
    else
    {
      $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($datosStock["IdProducto"]);
      $nuevoPrecioTotal = $datosStock["CantidadNueva"] * $precioUnitario["PrecioUnitarioProducto"];
      $datosCreateStock = array(       
        "IdTienda" => $datosStock["CodTienda"],
        "IdProducto" => $datosStock["IdProducto"],
        "CantidadIngresos" => $datosStock["CantidadNueva"],
        "CantidadSalidas" => 0,
        "CantidadActual" => $datosStock["CantidadNueva"],
        "PrecioUnitario" => $precioUnitario["PrecioUnitarioProducto"],
        "PrecioTotal" => $nuevoPrecioTotal,
        "FechaCreacion" => date("Y-m-d"),
        "FechaActualizacion" => date("Y-m-d")
      );
      $respuesta = ModelStock::mdlCrearRegistroStock($tabla, $datosCreateStock);
    }
    return $respuesta;
  }

  //  Cambiar el stock de un item por modificación 
  public static function ctrEditarUnaSalida($datosStock)
  {
    $tabla = "tba_stock";
    $stockActual = self::ctrObtenerStockActualProducto($datosStock["IdProducto"], $datosStock["CodTienda"]);
    //  Si el recurso ya tiene movimiento en ese almacén, solo se corregirá el stock actual de ese recurso
    if($stockActual != null || $stockActual != "")
    {
      $nuevaCantidadSalidas = $stockActual["CantidadSalidas"] - $datosStock["CantidadAntigua"];
      $nuevaCantidadSalidas = $nuevaCantidadSalidas + $datosStock["CantidadNueva"];

      $nuevaCantidadActual = $stockActual["CantidadActual"] - $datosStock["CantidadAntigua"];
      $nuevaCantidadActual = $nuevaCantidadActual + $datosStock["CantidadNueva"];

      $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($datosStock["IdProducto"]);
      $nuevoPrecioTotal = $nuevaCantidadActual * $precioUnitario["PrecioUnitarioProducto"];
      
      $datosUpdateStock = array(
        "IdProducto" => $datosStock["IdProducto"],
        "IdTienda" => $datosStock["CodTienda"],
        "CantidadSalidas" => $nuevaCantidadSalidas,
        "CantidadActual" => $nuevaCantidadActual,
        "PrecioTotal" => $nuevoPrecioTotal,
        "FechaActualizacion" => date("Y-m-d")
      );
      $respuesta = ModelStock::mdlActualizarStockSalida($tabla, $datosUpdateStock);
    }
    return $respuesta;
  }

  //  Eliminar un producto de un ingreso
  public static function ctrEliminarUnRecursoIngreso($codTienda, $codProducto, $cantidad)
  {
    $tabla = "tba_stock";
    $stockActual = self::ctrObtenerStockActualProducto($codProducto, $codTienda);
    $nuevaCantidadIngresos = $stockActual["CantidadIngresos"] - $cantidad;
    $nuevaCantidadActual = $stockActual["CantidadActual"] - $cantidad;
    $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($codProducto);
    $nuevoPrecioTotal = $nuevaCantidadActual * $precioUnitario["PrecioUnitarioProducto"];

    $datosUpdateStock = array(
      "IdProducto" => $codProducto,
      "IdTienda" => $codTienda,
      "CantidadIngresos" => $nuevaCantidadIngresos,
      "CantidadActual" => $nuevaCantidadActual,
      "PrecioTotal" => $nuevoPrecioTotal,
      "FechaActualizacion" => date("Y-m-d")
    );
    
    $respuesta = ModelStock::mdlActualizarStockIngreso($tabla, $datosUpdateStock);
  }

  //  Eliminar un producto de un ingreso
  public static function ctrEliminarUnRecursoSalida($codTienda, $codProducto, $cantidad)
  {
    $tabla = "tba_stock";
    $stockActual = self::ctrObtenerStockActualProducto($codProducto, $codTienda);
    $nuevaCantidadSalidas = $stockActual["CantidadSalidas"] + $cantidad;
    $nuevaCantidadActual = $stockActual["CantidadActual"] + $cantidad;
    $precioUnitario = ControllerProductos::ctrObtenerPrecioUnitario($codProducto);
    $nuevoPrecioTotal = $nuevaCantidadActual * $precioUnitario["PrecioUnitarioProducto"];

    $datosUpdateStock = array(
      "IdProducto" => $codProducto,
      "IdTienda" => $codTienda,
      "CantidadSalidas" => $nuevaCantidadSalidas,
      "CantidadActual" => $nuevaCantidadActual,
      "PrecioTotal" => $nuevoPrecioTotal,
      "FechaActualizacion" => date("Y-m-d")
    );
    
    $respuesta = ModelStock::mdlActualizarStockSalida($tabla, $datosUpdateStock);
  }
}