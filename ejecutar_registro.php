<?php
// Configuración de la conexión a la base de datos en Azure
$server = "jke.database.windows.net";
$username = "edwin";
$password = "A1b2c3d4";
$database = "proyecto1";

// Crear la conexión
$conn = new mysqli($server, $username, $password, $database, null, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);

// Establecer la versión de TLS
if (!$mysqli->ssl_set(null, null, null, null, null, 'TLSv1.2')) {
    die('Error al establecer la versión de TLS: ' . $mysqli->error);
}

// Intentar la conexión
if (!$mysqli->real_connect()) {
    die('Error al conectarse al servidor: ' . $mysqli->connect_error);
}

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
  echo "Conexión exitosa";  // Este mensaje te ayudará a saber si la conexión se realiza correctamente
}

// Recibir datos del formulario
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Verificar si las contraseñas coinciden
if ($_POST['password'] != $_POST['confirm_password']) {
    die("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
}

// Encriptar la contraseña (puedes usar funciones más seguras en un entorno de producción)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES ('$name', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error al registrar: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>