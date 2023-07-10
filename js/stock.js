//  Listar stock por tienda
$(".table").on("click", ".btnListarStock", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=stock&codTienda="+codTienda;
  }
});

