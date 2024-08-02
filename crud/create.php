<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (nombre, correo) VALUES (:nombre, :correo)");
    $stmt->bindParam(':nombre', $name);
    $stmt->bindParam(':correo', $email);

    if ($stmt->execute()) {
        header("Location: crud.php");
    } else {
        echo "Error al crear el usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Crear Nuevo Usuario</h1>
    <form method="post">
        <label for="name">Nombre:</label>
        <input type="text" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
