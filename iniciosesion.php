<?php
session_start();
require_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password_hash FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password_hash'];

        // Verificar la contraseña ingresada con el hash almacenado en la base de datos
        if (password_verify($password, $hashed_password)) {
            $_SESSION['usuario_id'] = $row['id'];
            header("Location: perfil.php"); // Redirigir al perfil del usuario
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>
