<?php
session_start();
require_once('conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: inicio_sesion.php");
    exit();
}

// Verificar si se proporciona el ID del comentario
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php"); // Redirigir si no se proporciona un ID válido
    exit();
}

$comentario_id = $_GET['id'];

// Obtener información del comentario desde la base de datos
$sql_comentario = "SELECT * FROM comentarios WHERE id = '$comentario_id'";
$result_comentario = $conn->query($sql_comentario);

if ($result_comentario->num_rows === 1) {
    $row_comentario = $result_comentario->fetch_assoc();

    // Verificar si el usuario tiene permiso para modificar el comentario
    if ($_SESSION['usuario_id'] != $row_comentario['usuario_id']) {
        header("Location: index.php"); // Redirigir si no tiene permisos
        exit();
    }

    // Mostrar el formulario para modificar el comentario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nuevo_comentario = $_POST['nuevo_comentario'];

        // Actualizar el comentario en la base de datos
        $sql_update_comentario = "UPDATE comentarios SET comentario = '$nuevo_comentario' WHERE id = '$comentario_id'";
        $conn->query($sql_update_comentario);

        header("Location: ver_receta.php?id=" . $row_comentario['receta_id']); // Redirigir a la página de la receta después de modificar el comentario
        exit();
    }

    // Mostrar el formulario para modificar el comentario
    ?>
    <!DOCTYPE html>
    <html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
        <title>Modificar Comentario</title>
    </head>
    <body>
        <h2>Modificar Comentario</h2>
        <form method="post">
            <textarea name="nuevo_comentario" placeholder="Modificar comentario" required><?php echo $row_comentario['comentario']; ?></textarea><br><br>
            <input type="submit" value="Guardar Cambios">
        </form>
    </body>
    </html>
    <?php
} else {
    header("Location: index.php"); // Redirigir si el comentario no existe
    exit();
}
?>
