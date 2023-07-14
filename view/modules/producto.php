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
          <h1 class="mt-4">Productos
          </h1>

            <div class="d-flex m-2">
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">
                Agregar Producto
              </button>
            </div>

          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Todos los Productos
            </div>
            <div class="card-body">
              <table id="datatablesSimple" class="data-table-Producto table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Descripción del Producto</th>
                    <th>Codigo del Producto</th>
                    <th>Precio Unitario</th>
                    <th>Peso Promedio</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $productos = ControllerProductos::ctrMostrarProductos();
                  foreach ($productos as $key => $value) 
                  {
                    echo
                    '<tr>
                      <td>'.($key + 1).'</td>
                      <td>'.$value["DescripcionProducto"].'</td>
                      <td>'.$value["CodProducto"].'</td>
                      <td>'.$value["PrecioUnitarioProducto"].'</td>
                      <td>'.$value["PesoProducto"].'</td>
                      <td>'.$value["CodCategoria"].'</td>
                      <td>
                        <button class="btn btn-warning btnEditarProducto" codProducto="'.$value["IdProducto"].'" data-bs-toggle="modal" data-bs-target="#modalEditarProducto">Editar <i class="fa-solid fa-pencil"></i></button>
                        <button class="btn btn-danger btnEliminarProducto" codProducto="'.$value["IdProducto"].'">Eliminar <i class="fa-solid fa-trash"></i></button>
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

<!-- MODAL AÑADIR PRODUCTO -->
<div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProducto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear un nuevo Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Producto-->
          <div class="form-group">
            <label for="nombreProducto" class="col-form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required>
          </div>

          <!-- Código Producto -->
          <div class="form-group">
            <label for="codigoProducto" class="col-form-label">Código del Producto:</label>
            <input type="text" class="form-control" id="codigoProducto" name="codigoProducto" required>
          </div>

          <!-- Categoría del Producto -->
          <div class="form-group">
              <label for="categoriaProducto" class="col-form-label">Perfil:</label>
              <select class="form-control" name="categoriaProducto">
                <?php
                  $categorias = ControllerCategorias::ctrMostrarCategorias();
                  foreach ($categorias as $key => $value)
                  {
                    echo '<option value="'.$value["IdCategoria"].'">'.$value["NombreCategoria"].'</option>';
                  }
                ?>
              </select>
          </div>

          <!-- Precio Producto -->
          <div class="form-group">
            <label for="precioProducto" class="col-form-label">Precio Unitario:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="precioProducto" name="precioProducto" required>
          </div>

          <!-- Peso Producto -->
          <div class="form-group">
            <label for="pesoProducto" class="col-form-label">Peso Promedio:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="pesoProducto" name="pesoProducto" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
          </div>
          <?php
            $crearProducto = new ControllerProductos();
            $crearProducto -> ctrCrearProducto();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDITAR PRODUCTO -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-labelledby="modalEditarProducto" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Cuerpo modal -->
      <div class="modal-body">
        <form role="form" method="post">
          <!-- Nombre Producto-->
          <div class="form-group">
            <label for="editarNombre" class="col-form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="editarNombre" name="editarNombre" required>
          </div>

          <!-- Código Producto -->
          <div class="form-group">
            <label for="editarCodigo" class="col-form-label">Código del Producto:</label>
            <input type="text" class="form-control" id="editarCodigo" name="editarCodigo" required>
          </div>

          <!-- Categoría del Producto -->
          <div class="form-group">
              <label for="editarCategoria" class="col-form-label">Perfil:</label>
              <select class="form-control" name="editarCategoria">
                <?php
                  $categorias = ControllerCategorias::ctrMostrarCategorias();
                  foreach ($categorias as $key => $value)
                  {
                    echo '<option value="'.$value["IdCategoria"].'">'.$value["NombreCategoria"].'</option>';
                  }
                ?>
              </select>
          </div>

          <!-- Precio Producto -->
          <div class="form-group">
            <label for="editarPrecio" class="col-form-label">Precio Unitario:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="editarPrecio" name="editarPrecio" required>
          </div>

          <!-- Peso Producto -->
          <div class="form-group">
            <label for="editarPeso" class="col-form-label">Peso Promedio:</label>
            <input type="number" min="0" step="0.01" class="form-control" id="editarPeso" name="editarPeso" required>
          </div>

          <div class="modal-footer">
            <input type="hidden" id="codProducto" name="codProducto" class="codProducto">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar Producto</button>
          </div>
          <?php
            $editarProducto = new ControllerProductos();
            $editarProducto -> ctrEditarProducto();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  $eliminarProducto = new ControllerProductos();
  $eliminarProducto -> ctrEliminarProductos();
?>