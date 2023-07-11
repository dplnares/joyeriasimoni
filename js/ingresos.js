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

//  Agregar los productos del modal al detalle del ingreso
$(".tablaProductos").on("click", ".btnAgregarProductoIngreso", function(){
  
  var idProductoIngreso = $(this).attr("idProducto");
  $(this).removeClass("btn-primary btnAgregarProductoIngreso");
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
            '<input type="text" class="form-control productoIngreso" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcionProducto+'" readonly>'+
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

//  Quitar los producto del ingreso
$(".formularioIngreso").on("click", "button.quitarProductoIngreso", function(){
  //  Eliminar el elemento listado
  $(this).parent().parent().parent().parent().remove();
  var idProducto = $(this).attr("idProducto");
  //  reactivar el boton del producto en el modal
  $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default disabled');
  $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary btnAgregarProductoIngreso');

  listarProductosIngreso();
  sumarListaProductos();
});

//  Actualizar el valor del parcial segun la cantidad
$(".formularioIngreso").on("change", "input.cantidadProducto", function(){

  var precio = $(this).parent().parent().children(".ingresoPrecioUnitario").children(".precioProducto");
  var parcial = $(this).parent().parent().children(".ingresoParcial").children(".nuevoParcialProducto");
  var precioParcial = $(this).val() * precio.val();
  var cantidadNueva = $(this).val()*1;

  $(this).val(cantidadNueva.toFixed(2));
  parcial.val(precioParcial.toFixed(2));

  listarProductosIngreso();
  sumarListaProductos();
});


//  FUNCIONES PARA SUMAR Y LISTAR LOS PRODUCTOS
function listarProductosIngreso()
{
  var listarProductosIngreso = [];
  var recurso = $(".idProducto")
  var cantidad = $(".cantidadProducto")
  var precioUnitario = $(".precioProducto")
  var precioParcial = $(".nuevoParcialProducto")
  for(var i = 0; i < recurso.length; i++)
  {
    listarProductosIngreso.push({
      "CodRecurso" : $(recurso[i]).attr("idRecurso"),
      "Cantidad" : $(cantidad[i]).val(),
      "PrecioUnitario" : $(precioUnitario[i]).val(),
      "ParcialProducto" : $(precioParcial[i]).val(),
    });
  }
  $("#listarProductosIngreso").val(JSON.stringify(listarProductosIngreso));
}

function sumarListaProductos()
{
  var precioItem = $(".nuevoParcialProducto");
  var arraySumaPrecio = []; 

  for(var i = 0; i < precioItem.length; i++)
  {
    arraySumaPrecio.push(Number($(precioItem[i]).val()));
  }

  //  Funcion para sumar todos los precios del array
  function sumaArrayPrecios(total, numero)
  {
    return total + numero;
  }

  if(arraySumaPrecio.length == 0)
  {
    var sumaTotalPrecio = 0;
  }
  else
  {
    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
  }

  var igv=(sumaTotalPrecio*18)/100;
  var total=sumaTotalPrecio+igv;

  //  $("#nuevoSubTotalIngreso").val(sumaTotalPrecio.toFixed(2));
  //  $("#nuevoImpuestoIngreso").val(igv.toFixed(2));
  //  $("#nuevoTotalIngreso").val(total.toFixed(2));
  $("#nuevoTotalIngreso").val(sumaTotalPrecio.toFixed(2));
  
}