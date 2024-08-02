<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error al eliminar el usuario.";
}
?>
