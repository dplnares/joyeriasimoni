//  Mostrar los datos en el modal para editar
$(".table").on("click", ".btnEditarUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");
  var datos = new FormData();

  datos.append("codUsuario", codUsuario);
  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",

    //  Ver la forma de pasar el nombre del perfil y del área a una opción del select
    success: function (respuesta) {
      $("#editarNombre").val(respuesta["NombreUsuario"]);
      $("#editarCorreo").val(respuesta["CorreoUsuario"]);
      $("#editarPerfil").val(respuesta["NombrePerfil"]);
      $("#editarArea").val(respuesta["NombreArea"]);
      $("#codUsuario").val(respuesta["CodUsuario"]);
    }
  });
});

//  Alerta para eliminar un usuario
$(".table").on("click", ".btnEliminarUsuario", function () {
  var codUsuario = $(this).attr("codUsuario");

  swal.fire({
    title: '¿Está seguro de borrar el usuario?',
    text: "¡No podrá revertir el cambio!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar usuario!'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = "index.php?ruta=usuarios&codUsuario="+codUsuario;
    }
  });
});
