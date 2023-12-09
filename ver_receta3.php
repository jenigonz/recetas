<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Receta</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <?php
    // Verificar si se proporciona un ID de receta
    if (isset($_GET['id'])) {
        $receta_id = $_GET['id'];

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

        // Consulta SQL para obtener detalles de la receta
        $sql = "SELECT recetas.*, usuarios.username AS username
        FROM recetas
        INNER JOIN usuarios ON recetas.usuario_id = usuarios.id";
        $result = $conn->query($sql);

        // Mostrar detalles de la receta
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="contenedor-detalle">';
            echo '<div class="detalles-derecha">';
            echo '<h1>' . $row["titulo_receta"] . '</h1>';
            echo '<p>Autor: ' . $row["username"] . '</p>';
            echo '<img src="' . $row["imagen"] . '" alt="Imagen de la receta">';
            echo '<p>Ingredientes: <br><br>' . nl2br($row["ingredientes"]) . '</p>'; // Utiliza nl2br aquí
            echo '<p>Procedimiento: <br><br>' . nl2br($row["procedimiento"]) . '</p>'; // Utiliza nl2br aquí
            echo '</div>';
            echo '</div>';
        } else {
            echo "Receta no encontrada.";
        }
        

        // Cerrar conexión
        $conn->close();
    } else {
        echo "ID de receta no proporcionado.";
    }
    ?>
<a href="#" class="heart-button" onclick="toggleHeart()"><i class="fa-solid fa-heart"></i></a>

<script>
  let isPressed = false;

function toggleHeart() {
  isPressed = !isPressed;
  const heartButton = document.querySelector('.heart-button');
  heartButton.classList.toggle('active', isPressed);
}
</script>
</body>

</html>
