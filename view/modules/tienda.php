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
          <h1 class="mt-4">Administrar tiendas</h1>

            <div class="d-flex m-2">
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarTienda">
                Agregar Tienda
              </button>
            </div>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Todos las tiendas
            </div>
            <div class="card-body">
              <table id="datatablesSimple" class="data-table-Tienda table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Codigo Tienda</th>
                    <th>Fecha Creacion</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $tiendas = ControllerTiendas::ctrMostrarTiendas();
                  foreach ($tiendas as $key => $value) 
                  {
                    echo
                    '<tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$value["NombreTienda"].'</td>
                        <td>'.$value["CodTienda"].'</td>
                        <td>'.$value["FechaCreacion"].'</td>
                        <td>
                          <button class="btn btn-warning btnEditarTienda" codTienda="'.$value["IdTienda"].'" data-bs-toggle="modal" data-bs-target="#modalEditarTienda">Editar <i class="fa-solid fa-pencil"></i></button>
                          <button class="btn btn-danger btnEliminarTienda" codTienda="'.$value["IdTienda"].'">Eliminar <i class="fa-solid fa-trash"></i></button>
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

<!-- MODAL AÑADIR TIENDA -->
<div class="modal fade" id="modalAgregarTienda" tabindex="-1" role="dialog" aria-labelledby="modalAgregarTienda" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear una nueva tienda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Tienda-->
          <div class="form-group">
            <label for="nombreTienda" class="col-form-label">Nombre Tienda:</label>
            <input type="text" class="form-control" id="nombreTienda" name="nombreTienda">
          </div>

          <!-- Código Tienda -->
          <div class="form-group">
            <label for="codigoTienda" class="col-form-label">Código de Tienda:</label>
            <input type="text" class="form-control" id="codigoTienda" name="codigoTienda">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Tienda</button>
          </div>
          <?php
            $crearTienda = new ControllerTiendas();
            $crearTienda -> ctrCrearTienda();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR TIENDA -->
<div class="modal fade" id="modalEditarTienda" tabindex="-1" aria-labelledby="modalEditarTienda" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar tienda</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form role="form" method="post">
        <div class="modal-body">
          <div class="box-body">

            <!-- Nombre -->
            <div class="form-group">
              <label for="editarNombre" class="col-form-label">Nombre Tienda:</label>
              <input type="text" class="form-control" id="editarNombre" name="editarNombre">
            </div>

            <!-- Código Tienda -->
            <div class="form-group">
              <label for="editarCodigo" class="col-form-label">Código Tienda:</label>
              <input type="text" class="form-control" id="editarCodigo" name="editarCodigo">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="codTienda" name="codTienda" class="codTienda">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Editar Tienda</button>
        </div>
        <?php
          $editarTienda = new ControllerTiendas();
          $editarTienda -> ctrEditarTienda();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
  $eliminarTienda = new ControllerTiendas();
  $eliminarTienda -> ctrEliminarTienda();
?>