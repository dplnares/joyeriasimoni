
<!-- Menu de todos los usuarios en general -->
<div class="sb-sidenav-menu-heading">Inicio</div>
<a class="nav-link" href="home">
  <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
  Inicio
</a>

<!-- Definir las vistas de los modulos de cada usuario -->


<?php
  if($_SESSION["perfilUsuario"] == "1")
  {
?>
  <!-- Usuarios -->
  <div class="sb-sidenav-menu-heading">Usuarios</div>
  <a class="nav-link" href="usuario">
    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
    Administrar Usuarios
  </a>
  
  <!-- Catalogo -->
  <div class="sb-sidenav-menu-heading">Catálogo</div>
  <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listaCatalogo" aria-expanded="false" aria-controls="collapseLayouts">
    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
    Catálogo
    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
  </a>
  <div class="collapse" id="listaCatalogo" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
    <nav class="sb-sidenav-menu-nested nav">
      <a class="nav-link" href="producto">Productos</a>
      <a class="nav-link" href="categoria">Categorias</a>
      <a class="nav-link" href="tienda">Tiendas</a>
    </nav>
  </div>
<?php
  }
?>

<!-- Movimientos -->
<div class="sb-sidenav-menu-heading">Movimientos</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listaMovimientos" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
  Movimientos
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listaMovimientos" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="ingresos">Ingresos</a>
    <a class="nav-link" href="salidas">Salidas</a>
  </nav>
</div>

<!-- Stock -->
<div class="sb-sidenav-menu-heading">Stock</div>
<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#listaStock" aria-expanded="false" aria-controls="collapseLayouts">
  <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
  Stock
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
</a>
<div class="collapse" id="listaStock" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
  <nav class="sb-sidenav-menu-nested nav">
    <a class="nav-link" href="stock">Stock</a>
    <a class="nav-link" href="buscarRecurso">Buscar Recurso</a>
  </nav>
</div>

