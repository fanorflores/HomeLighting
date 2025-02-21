$(document).ready(function () {
  var table = new DataTable("#nftmax-table__main", {
    select: true,
  });
  var tablehl = new DataTable("#nftmax-table__mainhl", {
    select: true,
  });

  $(".sync").click(function () {
    var dataContent = $(this).data("id");
    Swal.fire({
      title: "¿Seguro que quieres sincronizar el artículo " + dataContent + "?",
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

  $(".carrito_data").click(function () {
    var dataContentItem = $(this).data("carts_item");
    var tableContent =
      "<table border='0' style='width:100%; text-align:left;' ><tr><th>ID</th><th>ID GC</th><th>Descripción</th><th>Precio</th><th>Cantidad</th></tr>";
    dataContentItem.forEach(function (item) {
      tableContent +=
        "<tr style='border-bottom: 1px solid gray; border-top: 1px solid gray;'><td width=100 style='padding: 2px;'>" +
        item.id +
        "</td><td width=100 style='padding: 2px;'>" +
        item.idGc +
        "</td><td>" +
        item.descripcion +
        "</td><td width=100 style='padding: 2px;'>" +
        item.precio +
        "</td><td width=100 style='padding: 2px;'>" +
        item.cantidad +
        "</td></tr>";
    });
    tableContent += "</table>";

    Swal.fire({
      title: "Listado de items en el carrito",
      html: tableContent,
      width: "900",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Agregar",
    }).then((result) => {
      if (result.isConfirmed) {
        let timerInterval;
        Swal.fire({
          title: "Producto agregado al carrito correctamente",
          timer: 2500,
          icon: "success",
          timerProgressBar: true,
          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false, // There won't be any confirm button
          willClose: () => {
            clearInterval(timerInterval);
          },
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            location.reload();
          }
        });
      }
    });
  });
});
