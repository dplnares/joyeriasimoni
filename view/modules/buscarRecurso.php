
</div>
      </div>
      <div class="sb-sidenav-footer">
        <div class="small">Sesión iniciada como:</div>
        <?php echo $_SESSION["nombreUsuario"] ?>
      </div>
    </nav>
  </div>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4 stockGlobal">
        <h1 class="mt-4">Buscar Recurso</h1>
        <div class="d-flex m-2">

          <div class="col-md-3">
            <select class="form-control" required id="campoBusqueda" name="campoBusqueda">
              <option value="nombreProducto">Nombre Producto</option>
              <option value="codigoProducto">Codigo Producto</option>
            </select>
          </div>

          <div class="col-md-3">
            <input class="form-control" type="text" id="valorbusqueda"  name="valorbusqueda" >
          </div>

          <div class="col-md-3">
            <a><button class="btn btn-primary btnBuscarStockGlobal">Buscar Producto</button></a>
            <?php
              if(isset($_GET["campo"]) && isset($_GET["valor"]))
              {
                echo "<a href='vistas/modulos/descargar-reporte.php?campoStockGeneral'><button class='btn btn-success'>Descargar Excel</button></a>";
              }
              else
              {
                echo "<button class='btn btn-success'>Descargar Excel</button>";
              }
            ?>
          </div>        
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Datos Busqueda
          </div>
            
          <div class="card-body">
            <table id="datatablesSimple" class="data-table table tablaGeneralRecursos">
              <thead>
                <tr>
                  <th>Descripción</th>
                  <th>Codigo de Producto</th>
                  <th>Tienda</th>
                  <th>Cantidad Ingresos</th>
                  <th>Cantidad Salidas</th>
                  <th>Cantidad Actual</th>
                  <th>Precio Unitario</th>
                  <th>Precio Total</th>
                  <th>Último Movimiento</th>
                </tr>
              </thead>

              <tbody class="nuevoRegistrodeStock">
                <?php
                  if(isset($_GET["valor"]))
                  {
                    $listaRecursos = ControllerStock::ctrMostrarStockPorCampo($_GET["campo"], $_GET["valor"]);
                    foreach($listaRecursos as $value)
                    {
                      echo '
                        <tr>
                          <th>'.$value["DescripcionProducto"].'</th>
                          <th>'.$value["CodProducto"].'</th>
                          <th>'.$value["NombreTienda"].'</th>
                          <th>'.$value["CantidadIngresos"].'</th>
                          <th>'.$value["CantidadSalidas"].'</th>
                          <th>'.$value["CantidadActual"].'</th>
                          <th>'.$value["PrecioUnitario"].'</th>
                          <th>'.$value["PrecioTotal"].'</th>
                          <th>'.$value["FechaActualizacion"].'</th>
                        </tr>
                      ';
                    }
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