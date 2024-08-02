<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Usuario</title>
</head>
<body>
    <h1>Actualizar Usuario</h1>
    <form method="post">
        <label for="name">Nombre:</label>
        <input type="text" name="name" value="<?= $user['name'] ?>" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required>
        <br>
        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
