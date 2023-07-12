//  Listar ingresos por tienda
$(".table").on("click", ".btnListarSalidas", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=salidas&codTienda="+codTienda;
  }
});

//  Redirigir a vista de un nuevo ingreso
$("#btnNuevaSalida").on("click", function(){
  var codTienda = $(this).attr("codTienda");
  if(codTienda!=null)
  {
    window.location = "index.php?ruta=crearSalida&codTienda="+codTienda;
  }
});

//  Agregar los productos del modal al detalle de la salida
$(".tablaProductos").on("click", ".btnAgregarProductoSalida", function(){
  
  var idProductoIngreso = $(this).attr("idProducto");
  var idProductoIngreso = $(this).attr("idProducto");
  $(this).removeClass("btn-primary btnAgregarProductoSalida");
  $(this).addClass("btn-default disabled");

  var datos = new FormData();
  datos.append("idProductoIngreso", idProductoIngreso);
  $.ajax({
    url:"ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta)
    {
      var idProducto = respuesta["IdProducto"];
      var descripcionProducto = respuesta["DescripcionProducto"];
      var pesoProducto = respuesta["PesoProducto"];
      var codigoProducto = respuesta["CodProducto"];
      var precioProducto = respuesta["PrecioUnitarioProducto"];

      $(".nuevoProductoIngreso").append(
      '<div class="row" style="padding:5px 15px">'+

        '<!-- Descripción del producto -->'+          
        '<div class="col-lg-5" style="padding-right:0px">'+
          '<div class="input-group">'+
            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProductoIngreso" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
            '<input type="text" class="form-control nuevoproductoIngreso" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcionProducto+'" readonly>'+
          '</div>'+
        '</div>'+

        '<!-- Código del producto -->'+
        '<div class="col-lg-1">'+
          '<input type="text" class="form-control codProducto" name="codProducto" value="'+codigoProducto+'" readonly>'+
        '</div>' +

        '<!-- Peso del producto -->'+
        '<div class="col-lg-1">'+
          '<input type="text" class="form-control pesoProducto" name="pesoProducto" value="'+pesoProducto+'" readonly>'+
        '</div>' +

        '<!-- Cantidad del producto -->'+
        '<div class="col-lg-1 ingresoCantidad">'+
          '<input type="number" class="form-control cantidadProducto" name="cantidadProducto" min="1" required>'+
        '</div>' +

        '<!-- Precio unitario del producto -->'+
        '<div class="col-lg-2 ingresoPrecioUnitario">'+
          '<input type="text" class="form-control precioProducto" name="precioProducto" value="'+precioProducto+'" readonly>'+
        '</div>' +

        '<!-- Precio parcial -->'+
        '<div class="col-lg-2 ingresoParcial">'+
          '<input type="decimal" class="form-control nuevoParcialProducto" name="nuevoParcialProducto" min="1.00" value="1.00" readonly required>'+
        '</div>' +
      '</div>'
      );
      listarProductosIngreso();
      sumarListaProductos();
    } 
	});
});