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
          <h1 class="mt-4">Categorias
          </h1>

            <div class="d-flex m-2">
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modelAgregarCategoria">
                Agregar Categoria
              </button>
            </div>

          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Todas las Categorias
            </div>
            <div class="card-body">
              <table id="datatablesSimple" class="data-table-Categoria table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Código Categoría</th>
                    <th>Descripción</th>
                    <th>Fecha Creacion</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $categorias = ControllerCategorias::ctrMostrarCategorias();
                  foreach ($categorias as $key => $value) 
                  {
                    echo
                    '<tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$value["NombreCategoria"].'</td>
                        <td>'.$value["CodCategoria"].'</td>
                        <td>'.$value["DescripcionCategoria"].'</td>
                        <td>'.$value["FechaCreacion"].'</td>
                        <td>
                          <button class="btn btn-warning btnEditarCategoria" codCategoria="'.$value["IdCategoria"].'" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria">Editar <i class="fa-solid fa-pencil"></i></button>
                          <button class="btn btn-danger btnEliminarCategoria" codCategoria="'.$value["IdCategoria"].'">Eliminar <i class="fa-solid fa-trash"></i></button>
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

<!-- MODAL AÑADIR CATEGORIA -->
<div class="modal fade" id="modelAgregarCategoria" tabindex="-1" role="dialog" aria-labelledby="modelAgregarCategoria" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear una nueva categoria</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Categoria-->
          <div class="form-group">
            <label for="nombreCategoria" class="col-form-label">Nombre Categoría:</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria">
          </div>

          <!-- Código Categoria -->
          <div class="form-group">
            <label for="codigoCategoria" class="col-form-label">Código de Categoría:</label>
            <input type="text" class="form-control" id="codigoCategoria" name="codigoCategoria">
          </div>

          <!-- Descripcion Categoria -->
          <div class="form-group">
            <label for="descripcionCategoria" class="col-form-label">Descripción:</label>
            <input type="text" class="form-control" id="descripcionCategoria" name="descripcionCategoria">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Categoria</button>
          </div>
          <?php
            $crearCategoria = new ControllerCategorias();
            $crearCategoria -> ctrCrearCategoria();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR CATEGORIA -->
<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoria" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar Categoria</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form role="form" method="post">
        <div class="modal-body">
          <div class="box-body">

            <!-- Nombre Categoria -->
            <div class="form-group">
              <label for="editarNombre" class="col-form-label">Nombre Categoría:</label>
              <input type="text" class="form-control" id="editarNombre" name="editarNombre">
            </div>

            <!-- Código Categoria -->
            <div class="form-group">
              <label for="editarCodigo" class="col-form-label">Código Categoría:</label>
              <input type="text" class="form-control" id="editarCodigo" name="editarCodigo">
            </div>

            <!-- Descripcion Categoria -->
            <div class="form-group">
              <label for="editarDescripcion" class="col-form-label">Descripción Categoría:</label>
              <input type="text" class="form-control" id="editarDescripcion" name="editarDescripcion">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="codCategoria" name="codCategoria" class="codCategoria">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Editar Categoría</button>
        </div>
        <?php
          $editarCategoria = new ControllerCategorias();
          $editarCategoria -> ctrEditarCategoria();
        ?>
      </form>
    </div>
  </div>
</div>

<?php
  $eliminarCategoria = new ControllerCategorias();
  $eliminarCategoria -> ctrEliminarCategoria();
?>
