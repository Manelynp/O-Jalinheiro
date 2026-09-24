
eliminarProduccion();
configurarConfirmaciones();

function eliminarProduccion() {
    var select = document.querySelector("#fechaFiltrar");
    var boton = document.querySelector("#delete-form");

    if (select && boton) {
        if (select.value === "") {
            boton.style.display = "none";
        } else {
            boton.style.display = "block";
        }
    }
}
