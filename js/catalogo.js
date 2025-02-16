$(document).ready(function () {
  var table = new DataTable("#nftmax-table__main", {
    select: true,
  });

  $(".sync").click(function () {
    var dataContent = $(this).data("id");
    Swal.fire({
      title: "¿Seguro que quieres sincronizar?",
      text: "Esta acción se puede tardar y no es reversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Actualizar",
    }).then((result) => {
      if (result.isConfirmed) {
        let timerInterval;
        Swal.fire({
          title: "Producto actualizado correctamente",
          timer: 2500,
          icon: "success",
          dismiss: false,
          timerProgressBar: true,
          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false, // There won't be any confirm button
          showOkButton: false,
          willClose: () => {
            clearInterval(timerInterval);
          },
        }).then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          }
        });
      }
    });
  });
});
