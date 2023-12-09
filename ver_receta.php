<?php

session_start();
require_once('conexion.php');
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir si el usuario no ha iniciado sesión
    header("Location: inicio_sesion.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];

if (!isset($_GET['id'])) {
    header("Location: perfil.php"); // Redirigir si no se proporciona el ID de la receta
    exit();
}

$receta_id = $_GET['id'];

// Obtener detalles de la receta desde la base de datos
$sql_receta = "SELECT * FROM recetas WHERE id = '$receta_id'";
$result_receta = $conn->query($sql_receta);

if ($result_receta->num_rows > 0) {
    $row_receta = $result_receta->fetch_assoc();
    $titulo_receta = $row_receta['titulo_receta'];
    $ingredientes = $row_receta['ingredientes'];
    $procedimiento = $row_receta['procedimiento'];
    $imagen = $row_receta['imagen'];
    // Otros detalles de la receta
} else {
    echo "Receta no encontrada";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ver Receta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<?php

$estadoInicial = isset($_SESSION['estado_corazon']) ? $_SESSION['estado_corazon'] : 0;
?>
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
            </a><br>

        </ul>
    </div>

    <div class="detalles-derecha">
    <div class="receta-detalle">
        <h2><?php echo $titulo_receta; ?></h2>
        <center><img src="<?php echo $imagen; ?>" alt="Foto del plato" class="imagen-plato"></center>
        <h3>Ingredientes:</h3>
        <p><?php echo nl2br($ingredientes); ?></p>
        <h3>Procedimiento:</h3>
        <p><?php echo nl2br($procedimiento); ?></p>

</div>

<div class="comentarios">
    <h3>Comentarios</h3>
    <?php
    // Mostrar comentarios de la receta desde la base de datos
    $sql_comentarios = "SELECT comentarios.*, usuarios.username AS username
                        FROM comentarios
                        INNER JOIN usuarios ON comentarios.usuario_id = usuarios.id
                        WHERE receta_id = '$receta_id'
                        ORDER BY fecha_publicacion DESC";

    $result_comentarios = $conn->query($sql_comentarios);

    if ($result_comentarios->num_rows > 0) {
        while ($row_comentario = $result_comentarios->fetch_assoc()) {
            echo '<div class="comentario">';
            echo '<p>' . nl2br($row_comentario['comentario']) . '</p>';
            echo '<h6>Por: ' . $row_comentario['username'] . ' el ' . $row_comentario['fecha_publicacion'] . '</h6>';

            // Mostrar opciones solo si el usuario actual es el autor del comentario
            if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $row_comentario['usuario_id']) {
                echo '<a href="modificar_comentario.php?id=' . $row_comentario['id'] . '" class="btnmodificar"><i class="fas fa-edit"></i>Modificar</a> ';
                echo '<a href="borrar_comentario.php?id=' . $row_comentario['id'] . '" class="btneliminar">  <i class="fas fa-trash-alt"></i> Borrar</a>';
            }

            echo '</div>';
        }
    } else {
        echo 'No hay comentarios aún.';
    }
    ?>
    <!-- Formulario para agregar un comentario -->
    <form method="post"><br>
        <textarea class="comentario" name="nuevo_comentario" placeholder="Añadir comentario" required></textarea><br><br>
         <center><input type="submit" value="Agregar Comentario"></center>
        
    </form>
</div>

</div>
<!-- Lógica para agregar comentarios -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nuevo_comentario'])) {
        $nuevo_comentario = $_POST['nuevo_comentario'];

        // Insertar el nuevo comentario en la base de datos
        $sql_insert_comentario = "INSERT INTO comentarios (receta_id, usuario_id, comentario) 
                                  VALUES ('$receta_id', '$usuario_id', '$nuevo_comentario')";
        
        if ($conn->query($sql_insert_comentario) === TRUE) {
            // Refrescar la página para mostrar el nuevo comentario
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "Error al agregar comentario: " . $conn->error;
        }
    }
}
?>

</body>
</html>
