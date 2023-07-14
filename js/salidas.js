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
  
  var idProductoSalida = $(this).attr("idProducto");
  var stockActual = $(this).attr("stockActual");
  
  $(this).removeClass("btn-primary btnAgregarProductoSalida");
  $(this).addClass("btn-default disabled");

  var datos = new FormData();
  datos.append("idProductoSalida", idProductoSalida);
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
      var stockActualProducto = stockActual;

      $(".nuevoProductoSalida").append(
      '<div class="row" style="padding:5px 15px">'+

        '<!-- Descripción del producto -->'+          
        '<div class="col-lg-5" style="padding-right:0px">'+
          '<div class="input-group">'+
            '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitaProductoSalida" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
            '<input type="text" class="form-control nuevoproductoSalida" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcionProducto+'" readonly>'+
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
          '<input type="number" class="form-control nuevacantidadProducto" name="nuevacantidadProducto" min="1" stockActual="'+stockActualProducto+'" required>'+
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
      //listarProductosSalida();
      //sumarListaProductosSalida();
    } 
	});
});

//  Modificar la cantidad de la salida, si supera al stock, notificarlo
$(".formularioSalida").on("change", "input.nuevacantidadProducto", function(){
  var nuevoStock = Number($(this).attr("stockActual")) - $(this).val();
    if(nuevoStock<0)
    {
      $(this).val(1);
      Swal.fire(
        "La cantidad supera al stock actual",
        "¡Sólo hay "+$(this).attr("stockActual")+" unidades!",
        "error"
      );
    }
    listarProductosSalida();
    sumarListaProductosSalida();
});

//  Actualizar el valor del parcial segun la cantidad
$(".formularioSalida").on("change", "input.nuevacantidadProducto", function(){

  var precio = $(this).parent().parent().children(".ingresoPrecioUnitario").children(".precioProducto");
  var parcial = $(this).parent().parent().children(".ingresoParcial").children(".nuevoParcialProducto");
  var precioParcial = $(this).val() * precio.val();
  var cantidadNueva = $(this).val()*1;

  $(this).val(cantidadNueva.toFixed(2));
  parcial.val(precioParcial.toFixed(2));

  listarProductosSalida();
  sumarListaProductosSalida();
});

//  Quitar los producto del ingreso
$(".formularioSalida").on("click", "button.quitaProductoSalida", function(){
  //  Eliminar el elemento listado
  $(this).parent().parent().parent().parent().remove();
  var idProducto = $(this).attr("idProducto");
  //  reactivar el boton del producto en el modal
  $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default disabled');
  $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary btnAgregarProductoSalida');

  listarProductosSalida();
  sumarListaProductosSalida();
});

//  Modal Visualizar detalle del movimiento
$(".table").on("click", ".btnVisualizarSalida", function(){
  
  var codMovimientoVisualizarSalida = $(this).attr("codSalida");

  var datos = new FormData();
  datos.append("codMovimientoVisualizarSalida", codMovimientoVisualizarSalida);
  $.ajax({
    url:"ajax/movimientos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta)
    {
      function obtenerDetalleSalida(lista)
      {
        var descripcionProducto = lista["DescripcionProducto"];
        var cantidadProducto = lista["CantidadMovimiento"];
        var precioUnitario = lista["PrecioUnitario"];
        var parcialMovimiento = lista["ParcialTotal"];
        
        $(".nuevoDetalleSalida").append(
          '<div class="row" style="padding:5px 15px">'+
            //  Descripcion
            '<div class="col-md-5">'+
              '<div class="input-group">'+
                '<input type="text" class="form-control nuevoDetalleSalida" name="nuevoDetalleSalida" id="nuevoDetalleSalida" value="'+descripcionProducto+'" readonly>'+
              '</div>'+
            '</div>' +
            //  Cantidad
            '<div class="col-md-2">'+
              '<div class="input-group">'+
                '<input type="text" class="form-control nuevaCantidadSalida" name="nuevaCantidadSalida" id="nuevaCantidadSalida" value="'+cantidadProducto+'" readonly>'+
              '</div>'+
            '</div>' +
            //  Precio Unitario
            '<div class="col-md-2">'+
              '<div class="input-group">'+
                '<input type="text" class="form-control nuevoPrecioUSalida" name="nuevoPrecioUSalida" id="nuevoPrecioUSalida" value="'+precioUnitario+'" readonly>'+
              '</div>'+
            '</div>' +
            //  Parcial Movimiento
            '<div class="col-md-3">'+
              '<div class="input-group">'+
                '<input type="text" class="form-control nuevoPrecioParcialSalida" name="nuevoPrecioParcialSalida" id="nuevoPrecioParcialSalida" value="'+parcialMovimiento+'" readonly>'+
              '</div>'+
            '</div>' +
          '</div>'
        );
      }
      respuesta.forEach((lista) => obtenerDetalleSalida(lista));
    } 
	});
});
$('#modalVisualizarSalida').on('hidden.bs.modal', function () {
  var elementos = document.querySelectorAll('#nuevoDetalleSalida').length;
  for(i=0; i<elementos; i++)
  {
    document.getElementById("nuevoDetalleSalida").remove();
    document.getElementById("nuevaCantidadSalida").remove();
    document.getElementById("nuevoPrecioUSalida").remove();
    document.getElementById("nuevoPrecioParcialSalida").remove();
  }
});

//  Alerta para eliminar un ingreso
$(".table").on("click", ".btnEliminarSalida", function () {
  var codSalida = $(this).attr("codSalida");
  var codTienda = $(this).attr("codTienda");
  swal.fire({
    title: '¿Está seguro de borrar el registro?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar salida!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=salidas&codSalida="+codSalida+"&codTienda="+codTienda;
    }
  });
});


//  FUNCIONES PARA SUMAR Y LISTAR LOS PRODUCTOS
function listarProductosSalida()
{
  var listarProductosSalida = [];
  var recurso = $(".nuevoproductoSalida")
  var cantidad = $(".nuevacantidadProducto")
  var precioUnitario = $(".precioProducto")
  var precioParcial = $(".nuevoParcialProducto")
  for(var i = 0; i < recurso.length; i++)
  {
    listarProductosSalida.push({
      "CodRecurso" : $(recurso[i]).attr("idProducto"),
      "Cantidad" : $(cantidad[i]).val(),
      "PrecioUnitario" : $(precioUnitario[i]).val(),
      "ParcialProducto" : $(precioParcial[i]).val(),
    });
  }
  $("#listarProductosSalida").val(JSON.stringify(listarProductosSalida));
}

function sumarListaProductosSalida()
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
  $("#nuevoTotalSalida").val(sumaTotalPrecio.toFixed(2));
}
