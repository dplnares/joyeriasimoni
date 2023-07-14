//  Listar stock por tienda
$(".table").on("click", ".btnListarStock", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=stock&codTienda="+codTienda;
  }
});

//  Buscar un recurso en específico
$(".stockGlobal").on("click", ".btnBuscarStockGlobal", function(){
  var campo = $("#campoBusqueda").val();
  var valor = $("#valorbusqueda").val();
  if(campo!=null && valor!='')
  {
    window.location = "index.php?ruta=buscarRecurso&campo="+campo+"&valor="+valor;
  }
});