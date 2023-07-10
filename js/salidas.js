//  Listar ingresos por tienda
$(".table").on("click", ".btnListarSalidas", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=salidas&codTienda="+codTienda;
  }
});

