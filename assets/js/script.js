function confirmarEliminar() {
    return confirm("¿Estás seguro de que deseas eliminar esta reserva?");
}

// Función para validar fechas en el formulario de reserva
document.querySelector("form").addEventListener("submit", function(event) {
    const fechaEntrada = document.querySelector("input[name='fecha_entrada']").value;
    const fechaSalida = document.querySelector("input[name='fecha_salida']").value;
    
    if (new Date(fechaEntrada) >= new Date(fechaSalida)) {
        event.preventDefault();
        alert("La fecha de entrada debe ser anterior a la fecha de salida.");
    }
});
