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

  //  Actualizar las cantidades del stock por eliminación de un producto
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
}