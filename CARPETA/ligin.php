<?php
session_start();

// Configuración de la base de datos
$host = 'localhost';
$db = 'login_system';
$user = 'root';
$pass = '';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se han enviado datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['username'] = $username;
            echo "Login exitoso. Bienvenido, " . $username;
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.";
    }
}
?>
