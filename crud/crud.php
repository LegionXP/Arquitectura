<?php
include 'db.php';

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP</title>
    <link rel="stylesheet" href="estilosIndex.css">
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <a href="create.php">Crear Nuevo Usuario</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Genero</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Fecha de Nacimiento</th>
                <th>Identidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['nombre'] ?></td>
                    <td><?= $user['apellido'] ?></td>
                    <td><?= $user['usuario'] ?></td>
                    <td><?= $user['correo'] ?></td>
                    <td><?= $user['rol'] ?></td>
                    <td><?= $user['genero'] ?></td>
                    <td><?= $user['telefono'] ?></td>
                    <td><?= $user['direccion'] ?></td>
                    <td><?= $user['nacimiento'] ?></td>
                    <td><?= $user['identidad'] ?></td>
                    <td>
                        <a href="update.php?id=<?= $user['id'] ?>">Editar</a>
                        <a href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
