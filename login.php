<?php
session_start();
include('db.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM users WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: crud.php");
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>

<link rel="stylesheet" href="login.css">

<form method="post" action="">
    <p>Usuario: </p><input type="text" name="usuario" required><br>
    <p>Contraseña: </p><input type="password" name="contrasena" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>
