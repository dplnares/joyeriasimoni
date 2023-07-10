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
              echo "Nuevo Ingreso".' - '.$Tienda["NombreTienda"];
            }
            else 
            {
              echo'
                <script>
                  window.location = "index.php?ruta=ingresos";
                </script>
              ';
            }
            ?>
          </h1>
        </div>
      
        <div class="container-fluid">
          <form class="row g-3">

          <!-- HACER UN DIV PARA DIFERENCIAR CABECERA DE CUERPO -->
            <!-- Número de documento de ingreso -->
            <div class="col-md-6">
              <label for="numeroDocumentoIngreso" class="form-label">Número de documento</label>
              <input type="text" class="form-control" id="numeroDocumentoIngreso">
            </div>

            <!-- Fecha del ingreso-->
            <div class="col-md-6">
              <label for="fechaDeIngreso" class="form-label">Fecha de Ingreso</label>
              <input type="date" class="form-control" id="fechaDeIngreso">
            </div>

            <!-- Fecha del ingreso-->
            <div class="col-12">
              <label for="inputAddress" class="form-label">Address</label>
              <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div>

          </form>
        </div>
      </main>
    </div>