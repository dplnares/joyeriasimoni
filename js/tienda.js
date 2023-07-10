//  Mostrar los datos en el modal para editar tienda
$(".table").on("click", ".btnEditarTienda", function () {
  var codTienda = $(this).attr("codTienda");
  var datos = new FormData();

  datos.append("codTienda", codTienda);
  $.ajax({
    url: "ajax/tienda.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    //  Ver la forma de pasar el nombre del perfil y del área a una opción del select
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["NombreTienda"]);
      $("#editarCodigo").val(respuesta["CodTienda"]);
      $("#codTienda").val(respuesta["IdTienda"]);
    }
  });
});

//  Alerta para eliminar una tienda
$(".table").on("click", ".btnEliminarTienda", function () {
  var codTienda = $(this).attr("codTienda");

  swal.fire({
    title: '¿Está seguro de borrar la tienda?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar tienda!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=tienda&codTienda="+codTienda;
    }
  });
});
