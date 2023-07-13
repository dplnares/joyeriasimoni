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
              echo "Ingresos".' - '.$Tienda["NombreTienda"];
            }
            else 
            {
              echo "Ingresos";
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
                            <button class="btn btn-warning btn-xs btnListarIngresos" codTienda="'.$value["IdTienda"].'">Ingresos</button>
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
            //  Listar los ingresos por tienda
            if(isset($_GET["codTienda"]))
            {
            ?>
              <div class="d-inline-flex m-2">
                <button type="button" class="btn btn-info btnNuevoIngreso" id="btnNuevoIngreso" codTienda="<?php echo $_GET["codTienda"] ?>">Nuevo Ingreso </button>
              </div>
              <div class="d-inline-flex m-2">
                <a href="vistas/modulos/descargar-reporte.php?reporteStockProyecto=<?php echo $_GET["codTienda"] ?>">
                  <button type="button" class="btn btn-success">Descargar Excel</button>
                </a>
              </div>

              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-table me-1"></i>
                  Todas los ingresos
                </div>
                <div class="card-body">
                  <table id="datatablesSimple" class="data-table-ListaProductos table">
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
                        $listarIngresos = ControllerIngresos::ctrMostrarIngresosTienda();
                        foreach ($listarIngresos as $key => $value) 
                        {
                          echo
                          '<tr>
                            <td>'.($key + 1).'</td>
                            <td>'.$value["NumeroDocumento"].'</td>
                            <td>'.$value["NombreProveedor"].'</td>
                            <td>'.$value["Total"].'</td>
                            <td>'.$value["FechaCreacion"].'</td>
                            <td>
                              <button class="btn btn-success btnVisualizarIngreso" codIngreso="'.$value["IdMovimiento"].'" data-bs-toggle="modal" data-bs-target="#modalVisualizarIngreso"><i class="fa-solid fa-search"></i></button>
                              <button class="btn btn-warning btnEditarIngreso" codIngreso="'.$value["IdMovimiento"].'" data-bs-toggle="modal" data-bs-target="#modalEditarTienda"><i class="fa-solid fa-pencil"></i></button>
                              <button class="btn btn-danger btnEliminarIngreso" codIngreso="'.$value["IdMovimiento"].'" codTienda="'.$_GET["codTienda"].'"><i class="fa-solid fa-trash"></i></button>
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

<!-- Modal Visualizar Ingreso -->
<div class="modal fade lg" id="modalVisualizarIngreso" tabindex="-1" aria-labelledby="modalVisualizarIngreso" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Visualizar Ingreso</h5>
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

          <div class="form-group row nuevoDetalleIngreso">
            
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
  $eliminarIngreso = new ControllerIngresos();
  $eliminarIngreso -> ctrEliminarIngreso();
?>