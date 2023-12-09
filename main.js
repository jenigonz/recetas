document.getElementById('logoutButton').addEventListener('click', function() {
    logout();
});

function logout() {
    window.location.href = 'logout.php';
}



document.addEventListener('DOMContentLoaded', function() {
    // Recupera el color almacenado en el almacenamiento local al cargar la página.
    var colorAlmacenado = localStorage.getItem('colorSeleccionado');

    // Aplica el color almacenado al header.
    if (colorAlmacenado) {
        document.getElementById('content22').style.backgroundColor = colorAlmacenado;
    }

    // Agrega un evento al botón para abrir el selector de color.
    document.getElementById('colorButton').addEventListener('click', function() {
        mostrarSelectorColor();
    });
});

function mostrarSelectorColor() {
    var colorInput = document.createElement('input');
    colorInput.type = 'color';

    // Abre el cuadro de diálogo de selección de color.
    colorInput.click();

    colorInput.addEventListener('input', function() {
        var nuevoColor = colorInput.value;
        // Almacena el color seleccionado en el almacenamiento local.
        localStorage.setItem('colorSeleccionado', nuevoColor);
        // Aplica el nuevo color al header.
        document.getElementById('content22').style.backgroundColor = nuevoColor;
    });
}
