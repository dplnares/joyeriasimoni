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
              echo "Salidas".' - '.$Tienda["NombreTienda"];
            }
            else 
            {
              echo "Salidas";
            }
            ?>
          </h1>
          
          <?php 
            //  LISTA DE TIENDAS
            if(isset($_GET["codTienda"]))
            {
              $listarTiendas = $_GET["codTienda"];
            }
            else
            {
              $listarTiendas=0;
            }

            //  Si se tiene codigo de tienda, ingresa a la tienda. Caso cotnrario lista todas las tienda existentes.
            if($listarTiendas=="0")
            {
            ?>
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-table me-1"></i>
                  Todas las tiendas
                </div>
                <div class="card-body">
                  <table id="datatablesSimple" class="data-table-ListaTiendas table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre Tienda</th>
                        <th>Codigo de Tienda</th>
                        <th>Fecha Creacion</th>
                        <th>Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $listaTiendas = ControllerTiendas::ctrMostrarTiendas();
                      foreach ($listaTiendas as $key => $value) 
                      {
                        echo
                        '<tr>
                          <td>'.($key + 1).'</td>
                          <td>'.$value["NombreTienda"].'</td>
                          <td>'.$value["CodTienda"].'</td>
                          <td>'.$value["FechaCreacion"].'</td>
                          <td>
                            <button class="btn btn-warning btn-xs btnListarSalidas" codTienda="'.$value["IdTienda"].'">Salidas</button>
                          </td>
                        </tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
            <?php
            }
            //  Listar las salidas por tienda
            if(isset($_GET["codTienda"]))
            {
            ?>
              <div class="d-inline-flex m-2">
                <button type="button" class="btn btn-info btnNuevaSalida" id="btnNuevaSalida" codTienda="<?php echo $_GET["codTienda"] ?>">Nueva Salida </button>
              </div>
              <div class="d-inline-flex m-2">
                <!-- <a href="vistas/modulos/descargar-reporte.php?reporteStockProyecto=<?php //echo $_GET["codTienda"] ?>">
                  <button type="button" class="btn btn-success">Descargar Excel</button>
                </a> -->
              </div>

              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-table me-1"></i>
                  Todas las salidas
                </div>
                <div class="card-body">
                  <table id="datatablesSimple" class="data-table-ListaSalidas table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Numero Documento</th>
                        <th>Nombre Proveedor</th>
                        <th>Total</th>
                        <th>Fecha Creacion</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $listarSalidas = ControllerSalidas::ctrMostrarSalidasTienda();
                        foreach ($listarSalidas as $key => $value) 
                        {
                          echo
                          '<tr>
                            <td>'.($key + 1).'</td>
                            <td>'.$value["NumeroDocumento"].'</td>
                            <td>'.$value["NombreCliente"].'</td>
                            <td>'.$value["Total"].'</td>
                            <td>'.$value["FechaCreacion"].'</td>
                            <td>
                              <button class="btn btn-success btnVisualizarSalida" codSalida="'.$value["IdMovimiento"].'" data-bs-toggle="modal" data-bs-target="#modalVisualizarSalida"><i class="fa-solid fa-search"></i></button>
                              <button class="btn btn-warning btnEditarSalida" codSalida="'.$value["IdMovimiento"].'" data-bs-toggle="modal" data-bs-target="#modalEditarTienda"><i class="fa-solid fa-pencil"></i></button>
                              <button class="btn btn-danger btnEliminarSalida" codSalida="'.$value["IdMovimiento"].'" codTienda="'.$_GET["codTienda"].'"><i class="fa-solid fa-trash"></i></button>
                            </td> 
                          </tr>';
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
          <?php
            }
          ?>

<!-- Modal Visualizar Salida -->
<div class="modal fade lg" id="modalVisualizarSalida" tabindex="-1" aria-labelledby="modalVisualizarSalida" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Visualizar Salida</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="container-fluid">
          <div class="row" style="font-weight: bold">
            <div class="col-md-5">Descripción</div>
            <div class="col-md-2">Cantidad</div>
            <div class="col-md-2">P. U.</div>
            <div class="col-md-3">Parcial</div>
          </div>

          <div class="form-group row nuevoDetalleSalida">
            
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<?php
  $eliminarIngreso = new ControllerSalidas();
  $eliminarIngreso -> ctrEliminarSalida();
?>