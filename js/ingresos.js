//  Listar ingresos por tienda
$(".table").on("click", ".btnListarIngresos", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=ingresos&codTienda="+codTienda;
  }
});

//  Redirigir a vista de un nuevo ingreso
$("#btnNuevoIngreso").on("click", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=crearIngreso&codTienda="+codTienda;
  }
});
