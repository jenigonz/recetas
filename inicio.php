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

// Consulta SQL para obtener las recetas con información del usuario
$sql = "SELECT recetas.*, usuarios.username AS username
        FROM recetas
        INNER JOIN usuarios ON recetas.usuario_id = usuarios.id";

$result = $conn->query($sql); 

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <link rel="stylesheet" href="estilo.css">
    <title>CocinaCreativaOnline</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
<div id="navbar">
        <h2></h2>
        <ul>
            <a href="perfil.php">
                <li class="fas fa-user-circle tamfont"></li>
                <span class="tooltiptext"></span>
            </a><br><br>
            <a href="inicio.php">
                <li class="fas fa-home tamfont"></li>
                <span class="tooltiptext"></span>
            </a><br><br>
            <a href="subir_receta.php">
                <li class="fas fa-plus-circle tamfont"></li>
                <span class="tooltiptext"><br></span>
            </a><br><!--
            <a href="tarjetaseguridad.html">
                <li class="fas fa-search tamfont"></li>
                <span class="tooltiptext"><br></span>
            </a><br><br>-->
        </ul>
    </div>
    <div id="content">
        <div id="content2">
            <header>
                <h1>Cocina Creativa Online</h1>
            </header>
        </div>
        <div id="content3">
            <?php
            // Mostrar las recetas con información del usuario
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<a href="ver_receta.php?id=' . $row["id"] . '" class="contenedor-receta">';
                    echo '<img src="' . $row["imagen"] . '" alt="Imagen de la receta" width="100" height="100">';
                    echo '<h3>' . $row["titulo_receta"] . '</h3>';
                    echo '<p>Autor: ' . $row["username"] . '</p>';
                    echo '</a>'; // Cerrar el enlace dentro del contenedor
                }
            } else {
                echo "No hay recetas disponibles.";
            }
            ?>
            <br><br>
        </div>
    </div>
</body>

</html>
