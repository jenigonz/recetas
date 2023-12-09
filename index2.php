<?php
session_start();
require_once('conexion.php');

// Obtener las recetas para mostrar en la página principal
$sql_recetas = "SELECT id, titulo_receta, imagen FROM recetas ORDER BY id DESC"; // Obtener las recetas más recientes
$result_recetas = $conn->query($sql_recetas);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recetas - Página Principal</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <h1>Recetas</h1>
    <div class="recetas-list">
        <?php
        if ($result_recetas->num_rows > 0) {
            while ($row_receta = $result_recetas->fetch_assoc()) {
                echo '<div class="receta">';
                echo '<img src="' . $row_receta['imagen'] . '" alt="' . $row_receta['titulo_receta'] . '">';
                echo '<h3>' . $row_receta['titulo_receta'] . '</h3>';
                echo '<a href="ver_receta.php?id=' . $row_receta['id'] . '">Ver Receta</a>'; // Enlazar a la página para ver la receta
                echo '</div>';
            }
        } else {
            echo 'No hay recetas disponibles.';
        }
        ?>
    </div>
</body>
</html>
