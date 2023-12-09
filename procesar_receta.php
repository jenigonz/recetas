<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recetas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Procesar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $ingredientes = $_POST["ingredientes"];
    $procedimiento = $_POST["procedimiento"];
    $autor = $_POST["autor"];

    // Subir imagen al servidor
    $imagenNombre = $_FILES["imagen"]["name"];
    $imagenTemp = $_FILES["imagen"]["tmp_name"];
    $imagenRuta = "imagenes/" . $imagenNombre; // Cambia "carpeta_destino" a la carpeta donde deseas guardar las imágenes

    move_uploaded_file($imagenTemp, $imagenRuta);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO recetas (imagen, titulo_receta, ingredientes, procedimiento, autor) VALUES ('$imagenRuta', '$titulo', '$ingredientes', '$procedimiento', '$autor')";

    if ($conn->query($sql) === TRUE) {
        echo "Receta enviada con éxito.";
    } else {
        echo "Error al enviar la receta: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>