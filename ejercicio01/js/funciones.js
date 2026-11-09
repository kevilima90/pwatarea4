
document.addEventListener("DOMContentLoaded", function () {

    const buscador = document.getElementById("buscarTarea");
    const botonesFiltro = document.querySelectorAll(".filtro");
    const tareas = document.querySelectorAll(".tarea");
    const contador = document.getElementById("contadorVisible");
    const sinResultados = document.getElementById("sinResultados");

    let filtroActual = "todas";

    function filtrarTareas() {

        const texto = buscador
            ? buscador.value.toLowerCase().trim()
            : "";

        let visibles = 0;

        tareas.forEach(function (tarea) {

            const estado = tarea.dataset.estado;
            const contenido = tarea.dataset.busqueda.toLowerCase();

            const coincideTexto = contenido.includes(texto);

            const coincideEstado =
                filtroActual === "todas" ||
                estado === filtroActual;

            const mostrar = coincideTexto && coincideEstado;

            tarea.hidden = !mostrar;

            if (mostrar) {
                visibles++;
            }
        });

        if (contador) {
            contador.textContent = visibles;
        }

        if (sinResultados) {
            sinResultados.hidden = visibles !== 0;
        }
    }

    // Búsqueda en tiempo real
    if (buscador) {
        buscador.addEventListener("input", filtrarTareas);
    }

    // Filtros de tareas
    botonesFiltro.forEach(function (boton) {

        boton.addEventListener("click", function () {

            botonesFiltro.forEach(function (elemento) {
                elemento.classList.remove("activo");
            });

            boton.classList.add("activo");

            filtroActual = boton.dataset.filtro;

            filtrarTareas();
        });

    });

    // Ejecutar filtro inicial
    filtrarTareas();

});
