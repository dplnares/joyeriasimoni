</div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Sesión iniciada como:</div>
          <?php echo $_SESSION["nombreUsuario"] ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main class="bg">
        <div class="container-fluid px-4">
          <h1 class="mt-4">
            <?php 
            if(isset($_GET["codTienda"]))
            {
              $Tienda = ControllerTiendas::ctrMostrarUnaTienda($_GET["codTienda"]); 
              echo "Nueva Salida".' - '.$Tienda["NombreTienda"];
            }
            else 
            {
              echo'
                <script>
                  window.location = "index.php?ruta=salidas";
                </script>
              ';
            }
            ?>
          </h1>
        </div>
      
        <div class="container-fluid">
          <form role="form" method="post" class="row g-3 m-2 formularioSalida">

            <!-- Cabecera -->
            <span class="border border-3 p-3">
              <div class="container row g-3">
                <h3> Datos Cabecera</h3>
                <!-- Número de documento de salida -->
                <div class="col-md-6">
                  <label for="editarNumeroSalida" class="form-label" style="font-weight: bold">Número de documento</label>
                  <input type="text" class="form-control" id="editarNumeroSalida" name="editarNumeroSalida">
                </div>

                <!-- Fecha de salida -->
                <div class="col-md-6">
                  <label for="fechaSalida" class="form-label" style="font-weight: bold">Fecha de Ingreso</label>
                  <input type="date" class="form-control" id="fechaSalida" name="fechaSalida">
                </div>

                <!-- Nombre del cliente -->
                <div class="col-12">
                  <label for="nombreCliente" class="form-label">Nombre del cliente</label>
                  <input type="text" class="form-control" id="nombreCliente" name="nombreCliente">
                </div>
              </div>
            </span>

            <!-- Detalle del movimiento -->
            <span class="border border-3 p-3">
              <div class="container row g-3">
                <h3> Datos Detalle</h3>
                <div class="d-inline-flex m-2">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">Agregar Producto</button>
                </div>

                <div class="row" style="font-weight: bold">
                  <div class="col-lg-5">Descripción Producto</div>
                  <div class="col-lg-1">Codigo</div>
                  <div class="col-lg-1">Peso</div>
                  <div class="col-lg-1">Cantidad</div>
                  <div class="col-lg-2">Precio Unitario</div>
                  <div class="col-lg-2">Parcial</div>
                </div>

                <div class="form-group row nuevoProductoSalida">
                  <input type="hidden" id="listarProductosSalida" name="listarProductosSalida">
                  <input type="hidden" id="codTienda" name="<?php echo $_GET["codTienda"] ?>">
                </div>
              </div>
            </span>

            <!-- Pie de movimiento -->
            <span class="border border-3 p-3">
              <div class="container row g-3">
                <h3> Total</h3>
                <!-- <div class="row" style="font-weight: bold">
                  <div class="col-lg-1"></div>
                  <div class="col-lg-1"><span>SubTotal:</span></div><div class="col-lg-2"><input type="text" style="text-align: right;" class="form-control input-lg" id="nuevoSubTotalIngreso" name="nuevoSubTotalIngreso" placeholder="0.00" readonly></div>            
                </div>

                <div class="row" style="font-weight: bold">
                  <div class="col-lg-1"></div>
                  <div class="col-lg-1"><span>IGV:</span></div><div class="col-lg-2"><input type="text" style="text-align: right;" class="form-control input-lg" min="0" id="nuevoImpuestoIngreso" name="nuevoImpuestoIngreso" placeholder="0.00" readonly></div>              
                </div> -->

                <div class="row" style="font-weight: bold">
                  <div class="col-lg-1"></div>
                  <div class="col-lg-1"><span>Total:</span></div><div class="col-lg-2"><input type="text" style="text-align: right;" class="form-control input-lg" min="0" id="nuevoTotalSalida" name="nuevoTotalSalida" placeholder="0.00" readonly></div>              
                </div>
              </div>

              <div class="container row g-3 p-3">
                
                <button type="submit" class="col-2 d-inline-flex p-2 btn btn-primary">Generar Salida</button>
                <input type="hidden" name="codTienda" id="codTienda" value="<?php echo $_GET["codTienda"]?>"> 
              </div>
            </span>

          </form>
        </div>
      </main>
    </div>
  </div>
  
<?php
  $crearIngreso = new ControllerSalidas;
  $crearIngreso -> ctrCrearSalida();
?>

<!-- Modal ingresar nuevo recurso -->
<div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProducto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Cuerpo modal -->
      <div class="modal-body">
        <table class="table table-striped dt-responsive tablaProductos" width="100%">
          <thead>
            <tr>
              <th style ="width:10px">#</th>
              <th>Nombre Recurso</th>
              <th>Codigo</th>
              <th>Cantidad</th>
              <th>Acciones</th>      
            </tr> 
          </thead>
          <tbody>
            <?php
              //  Modificar por una lista de los productos en stock
              $listaProductos = ControllerStock::ctrMostrarProductosEnStock();
              foreach ($listaProductos as $key => $value)
              {
                if($value["CantidadActual"] > 0)
                {
                  echo ' 
                  <tr>
                    <td>'.($key + 1).'</td>
                    <td>'.$value["DescripcionProducto"].'</td>
                    <td>'.$value["CodProducto"].'</td>
                    <td>'.$value["CantidadActual"].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-primary btnAgregarProductoSalida recuperarBoton" stockActual="'.$value["CantidadActual"].'"  idProducto="'.$value["IdProducto"].'">Agregar</button> 
                      </div>
                    </td>
                  </tr>'
                  ;
                }
              }
            ?>
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>