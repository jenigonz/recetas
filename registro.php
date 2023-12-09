<?php
require_once('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); 


    $foto_perfil = $_FILES['foto_perfil']; 

    if ($foto_perfil['error'] === UPLOAD_ERR_OK) {
        $nombre_temporal = $foto_perfil['tmp_name'];
        $nombre_archivo = basename($foto_perfil['name']);
        $ruta_destino = "foto/perfil/" . $nombre_archivo; 

        if (move_uploaded_file($nombre_temporal, $ruta_destino)) {

            $sql = "INSERT INTO usuarios (username, email, foto_perfil, password_hash)
                    VALUES ('$username', '$email', '$ruta_destino', '$hashed_password')";
            
            // Resto de la lógica para insertar los datos en la base de datos
        } else {
            echo "Hubo un error al subir la imagen.";
        }
    } else {
        echo "Error al subir la imagen: " . $foto_perfil['error'];
    }



//    $foto_perfil = 'foto/perfil/imagen'; // Ruta de la imagen guardada en el servidor

   
    
   /* $sql = "INSERT INTO usuarios (username, email, foto_perfil, password_hash)
            VALUES ('$username', '$email', '$foto_perfil', '$hashed_password')";*/

            if ($conn->query($sql) === TRUE) {
                echo '<script>alert("Registro exitoso. Ahora puedes iniciar sesión."); window.location.href = "index.php";</script>';
            } else {
                echo '<script>alert("Error: ' . $conn->error . '");</script>';
            }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<div id="content">
        <div id="content2">
            <header>
                <h1>Cocina Creativa Online</h1>
            </header>
        </div>
    <div id="content5">
        <h2>Registro de Usuario</h2>
        <form method="post" enctype="multipart/form-data">
            <!-- Campos del formulario para el registro -->
            <input type="text" name="username" placeholder="Nombre de Usuario" required><br><br>
            <input type="email" name="email" placeholder="Correo Electrónico" required><br><br>
            <!-- Otros campos del formulario como la imagen de perfil, contraseña, etc. -->
            <input type="password" name="password" placeholder="Contraseña" required><br><br>
            <input type="file" name="foto_perfil" accept="image/*" id="fileInput" required><br><br>            
            <input type="submit" value="Registrarse">
        </form>
    </div>
    </div>
</body>
</html>
