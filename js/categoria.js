//  Mostrar los datos en el modal para editar categoria
$(".table").on("click", ".btnEditarCategoria", function () {
  var codCategoria = $(this).attr("codCategoria");
  var datos = new FormData();

  datos.append("codCategoria", codCategoria);
  $.ajax({
    url: "ajax/categoria.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    //  Ver la forma de pasar el nombre del perfil y del área a una opción del select
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["NombreCategoria"]);
      $("#editarCodigo").val(respuesta["CodCategoria"]);
      $("#editarDescripcion").val(respuesta["DescripcionCategoria"]);
      $("#codTienda").val(respuesta["IdCategoria"]);
    }
  });
});

//  Alerta para eliminar una categoria
$(".table").on("click", ".btnEliminarCategoria", function () {
  var codCategoria = $(this).attr("codCategoria");

  swal.fire({
    title: '¿Está seguro de borrar la categoria?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar categoria!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=categoria&codCategoria="+codCategoria;
    }
  });
});
