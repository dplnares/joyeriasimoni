<?php

class ControllerReportes
{
  //  Descargar el reporte del stock de la tienda
  public static function ctrDescargarReporteStock($codTienda)
  {
    if(isset($_GET["reporteStockTienda"]))
    {
      $codTienda=$_GET["reporteStockTienda"];
  
      $listaProductosTienda = ControllerStock::ctrMostrarReporte($codTienda);
  
      //  Creamos el archivo excel
      $Name = "StockProyecto.xls";

      header('Expires: 0');
      header('Cache-control: private');
      header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
      header("Cache-Control: cache, must-revalidate"); 
      header('Content-Description: File Transfer');
      header('Last-Modified: '.date('D, d M Y H:i:s'));
      header("Pragma: public"); 
      header('Content-Disposition:; filename="'.$Name.'"');
      header("Content-Transfer-Encoding: binary");

      //  Creamos nombre de las columnas del archivo
      echo utf8_decode("<table border='1'>
      
      </thead>
        <tr> 
          <th style='width:50%'>Nombre Recurso</th>
          <th style='width:10%'>Codigo Interno</th>
          <th style='width:10%'>Cantidad Actual</th>
          <th style='width:10%'>Cantidad Ingresos</th>
          <th style='width:10%'>Cantidad Salidas</th>
          <th style='width:10%'>Precio Unitario</th>
          <th style='width:10%'>Parcial Total</th>
          <th style='width:10%'>Ultimo Movimiento</th>
        </tr> 
      </thead>");
  
      // Rellenamos las columnas con los datos obtenidos
      foreach ($listaProductosTienda as $value) 
      {
        echo utf8_decode('<tr style="font-size:12px">

          <td style="width:50%">'.$value["DescripcionProducto"].'</td>
          <td style="width:10%">'.$value["CodProducto"].'</td>
          <td style="width:10%">'.$value["CantidadActual"].'</td>
          <td style="width:10%">'.$value["CantidadIngresos"].'</td>
          <td style="width:10%">'.$value["CantidadSalidas"].'</td>
          <td style="width:10%">'.$value["PrecioUnitario"].'</td>
          <td style="width:10%">'.$value["PrecioTotal"].'</td>
          <td style="width:10%">'.$value["FechaActualizacion"].'</td>
        </tr>');
      }
      echo "</table>";
    }
  }
}