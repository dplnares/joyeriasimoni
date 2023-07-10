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
              echo "Stock".' - '.$Tienda["NombreTienda"];
            }
            else 
            {
              echo "Stock";
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
                            <button class="btn btn-success btn-xs btnListarStock" codTienda="'.$value["IdTienda"].'">Stock</button>
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
            //  Lista de stock por tienda
            if(isset($_GET["codTienda"]))
            {
            ?>
              <div class="d-flex m-2">
                <a href="vistas/modulos/descargar-reporte.php?reporteStockProyecto=<?php echo $_GET["codTienda"] ?>">
                <button type="button" class="btn btn-success">Descargar Excel</button>
              </div>

              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-table me-1"></i>
                  Todas los productos
                </div>
                <div class="card-body">
                  <table id="datatablesSimple" class="data-table-ListaProductos table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Codigo de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total</th>
                        <th>Último Movimiento</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $listarStock = ControllerStock::ctrMostrarStockActual();
                      foreach ($listarStock as $key => $value) 
                      {
                        echo
                        '<tr>
                          <td>'.($key + 1).'</td>
                          <td>'.$value["DescripcionProducto"].'</td>
                          <td>'.$value["CodProducto"].'</td>
                          <td>'.$value["CantidadStock"].'</td>
                          <td>'.$value["PrecioUnitarioProducto"].'</td>
                          <td>'.$value["PrecioTotal"].'</td>
                          <td>'.$value["FechaCreacion"].'</td>
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