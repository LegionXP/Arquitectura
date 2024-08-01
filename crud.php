<?php
require 'includes/config/database.php';

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Conecta a la base de datos
    $db = conectarDB();

    // Prepara la consulta para insertar un nuevo usuario
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password); // Asocia los parámetros con el tipo cadena
    $stmt->execute();

    // Verifica si la inserción fue exitosa
    if ($stmt->affected_rows > 0) {
        header("Location: login.php"); // Redirige a la página de inicio de sesión
        exit();
    } else {
        echo "Error al registrar el usuario.";
    }

    // Cierra la conexión a la base de datos
    $db->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estiloIndex.css">
    <title>Crear Cuenta</title>
</head>
<body>
    <h2>Crear Cuenta</h2>
    <form action="register.php" method="post">
        <label for="username">Nombre:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
