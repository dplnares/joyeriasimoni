//  Mostrar los datos en el modal para editar un producto
$(".table").on("click", ".btnEditarProducto", function () {
  var codProducto = $(this).attr("codProducto");
  var datos = new FormData();

  datos.append("codProducto", codProducto);
  $.ajax({
    url: "ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    //  Ver la forma de pasar el nombre del perfil y del área a una opción del select
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["DescripcionProducto"]);
      $("#editarCodigo").val(respuesta["CodProducto"]);
      $("#editarCategoria").val(respuesta["IdCategoria"]);
      $("#editarPrecio").val(respuesta["PrecioUnitarioProducto"]);
      $("#editarPeso").val(respuesta["PesoProducto"]);
      $("#codProducto").val(respuesta["IdProducto"]);
    }
  });
});

//  Alerta para eliminar un producto
$(".table").on("click", ".btnEliminarProducto", function () {
  var codProducto = $(this).attr("codProducto");

  swal.fire({
    title: '¿Está seguro de eliminar el producto?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar producto!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=producto&codProducto="+codProducto;
    }
  });
});
