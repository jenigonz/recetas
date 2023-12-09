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

    // Verificar si el usuario tiene permiso para borrar el comentario
    if ($_SESSION['usuario_id'] != $row_comentario['usuario_id']) {
        header("Location: index.php"); // Redirigir si no tiene permisos
        exit();
    }

    // Borrar el comentario de la base de datos
    $sql_delete_comentario = "DELETE FROM comentarios WHERE id = '$comentario_id'";
    $conn->query($sql_delete_comentario);

    header("Location: ver_receta.php?id=" . $row_comentario['receta_id']); // Redirigir a la página de la receta después de borrar el comentario
    exit();
} else {
    header("Location: index.php"); // Redirigir si el comentario no existe
    exit();
}
?>
