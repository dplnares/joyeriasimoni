<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php require "modules/header.php" ?>
</head>


  <?php
    if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok")
    {
      echo '<body class="sb-nav-fixed">';
      
      include "modules/navbar.php";

      echo '
      <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">';
      include "modules/menu.php";

      if(isset($_GET["ruta"]))
      {
        if(
          $_GET["ruta"] == "home" ||  
          $_GET["ruta"] == "usuario" ||
          $_GET["ruta"] == "categoria" ||
          $_GET["ruta"] == "producto" ||
          $_GET["ruta"] == "tienda" ||
          $_GET["ruta"] == "stock" ||
          $_GET["ruta"] == "ingresos" ||
          $_GET["ruta"] == "salidas" ||
          $_GET["ruta"] == "signout" 
        )
        {
          include "modules/".$_GET["ruta"].".php";
        }
        else
        {
          include "web/404.html";
        }
      }
      else
      {
        include "modules/home.php";
      }
      echo '<footer>';
      include "modules/footer.php";
      echo '</footer>';
      echo '</div>';
      echo '</div>';
    }
    else
    {
      include "modules/login.php";
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>

  <script src="js/plantilla.js"></script>
  <script src="js/usuario.js"></script>
  <script src="js/tienda.js"></script>
  <script src="js/categoria.js"></script>
</body>
</html>