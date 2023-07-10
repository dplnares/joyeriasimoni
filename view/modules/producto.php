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
              <table id="datatablesSimple" class="data-table-Usuario table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $usuarios = ControllerUsuarios::ctrMostrarUsuarios();
                  foreach ($usuarios as $key => $value) 
                  {
                    echo
                    '<tr>
                        <td>'.($key + 1).'</td>
                        <td>'.$value["NombreUsuario"].'</td>
                        <td>'.$value["CorreoUsuario"].'</td>
                        <td>'.$value["NombrePerfil"].'</td>
                        <td>
                          <button class="btn btn-warning btnEditarUsuario" codUsuario="'.$value["IdUsuario"].'" data-bs-toggle="modal" data-bs-target="#modalEditUser">Editar <i class="fa-solid fa-pencil"></i></button>
                          <button class="btn btn-danger btnEliminarUsuario" codUsuario="'.$value["IdUsuario"].'">Eliminar <i class="fa-solid fa-trash"></i></button>
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
