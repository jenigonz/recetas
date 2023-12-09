<?php
session_start();
require_once('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: inicio_sesion.php"); // Redirigir si el usuario no ha iniciado sesión
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener información del usuario desde la base de datos
$sql = "SELECT username, foto_perfil FROM usuarios WHERE id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $foto_perfil = $row['foto_perfil'];
}

// Obtener recetas del usuario
$sql_recetas = "SELECT id, titulo_receta, imagen FROM recetas WHERE usuario_id = '$usuario_id'";
$result_recetas = $conn->query($sql_recetas);
?>
<!DOCTYPE html>
<html>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
<head>
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

    </style>
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
        <div id="content22">
        <header>
        <img src="<?php echo $foto_perfil; ?>" alt="Foto de perfil">
        <h2>Bienvenido <?php echo $username; ?></h2>
        <a href="#" class="pencil-button" id="colorButton"><i class="fas fa-edit"></i></a>
    </header>
    </div>

    <div id="content6">
        <h2>Mis recetas</h2>
        <?php
        if ($result_recetas->num_rows > 0) {
            while ($row_receta = $result_recetas->fetch_assoc()) {
                echo '<div class="receta">';
                echo '<img src="' . $row_receta['imagen'] . '" alt="' . $row_receta['titulo_receta'] . '">';
                echo '<h3>' . $row_receta['titulo_receta'] . '</h3>';
                echo '<a href="ver_receta.php?id=' . $row_receta['id'] . '">Ver Receta</a>'; // Enlazar a la página para ver la receta
                echo '</div><br><br>';
            }
        } else {
            echo 'No hay recetas aún.';
        }
        echo '<button class="btnreceta"><a href="subir_receta.php">Subir Nueva Receta</a> </button><br>';
        echo '<button id="logoutButton" class="btnreceta">Cerrar Sesión</button> ';
        ?>
        
    </div>
    </div>
    <script src="main.js"></script>
</body>
</html>
