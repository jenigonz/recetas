<?php
session_start();
require_once('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo_receta = $_POST['titulo_receta'];
    $ingredientes = mysqli_real_escape_string($conn, $_POST['ingredientes']);
    $procedimiento = mysqli_real_escape_string($conn, $_POST['procedimiento']);
    $usuario_id = $_SESSION['usuario_id']; 
    
    
    $imagen = $_FILES['imagen']; 


    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $imagen['tmp_name'];
        $nombre_archivo = basename($imagen['name']);
        $imagen = "foto/receta/" . $nombre_archivo; 
    

        if (move_uploaded_file($nombre_temporal, $imagen)) {
            $sql = "INSERT INTO recetas (usuario_id, titulo_receta, ingredientes, procedimiento, imagen)
            VALUES ('$usuario_id', '$titulo_receta', '$ingredientes', '$procedimiento', '$imagen')";
    
        } else {
            echo "Hubo un error al subir la imagen.";
        }
    } else {
        echo "Error al subir la imagen: " . $imagen['error'];
    }
    
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Receta guardada exitosamente"); window.location.href = "perfil.php";</script>';

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>Subir Nueva Receta</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            </a><br>

        </ul>
    </div>
    <div id="content">
    <div id="content4">
    <div class="receta-form">
        <h2>Subir Nueva Receta</h2>
        <form method="post" enctype="multipart/form-data">
            <!-- Campos del formulario para la nueva receta -->
            <input type="text" name="titulo_receta" placeholder="Título" required><br><br>
            <textarea name="ingredientes" placeholder="Ingredientes" required></textarea><br><br>
            <textarea name="procedimiento" placeholder="Procedimiento" required></textarea><br><br>
            <input type="file" name="imagen" accept="image/*" required><br><br>
            <input type="submit" value="Subir Receta">
        </form>
    </div>
    </div>
    </div>
</body>
</html>
