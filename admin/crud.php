<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Crear usuario
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario creado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Leer usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Actualizar usuario
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET username='$username', role='$role' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar usuario
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>

<html lang="es"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Usuarios</title>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <!-- Formulario para crear usuario -->
    <form method="POST" action="crud.php">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="role">
            <option value="admin">Administrador</option>
            <option value="employee">Empleado</option>
        </select>
        <button type="submit" name="create">Crear Usuario</button>
        <a href="../index.php" class="link-button">Regresar al Menú Principal</a>
    </form>
    
    <!-- Mostrar usuarios existentes -->
    <h3>Usuarios Existentes</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre de usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <!-- Formulario para actualizar usuario -->
                    <form method="POST" action="crud.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                        <select name="role">
                            <option value="admin" <?php echo $row['role'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            <option value="employee" <?php echo $row['role'] == 'employee' ? 'selected' : ''; ?>>Empleado</option>
                        </select>
                        <button type="submit" name="update">Actualizar</button>
                    </form>
                    <!-- Formulario para eliminar usuario -->
                    <form method="POST" action="crud.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        
        </html>
        </html>
        