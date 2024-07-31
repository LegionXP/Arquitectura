<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Crear usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $genero = $_POST['genero'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $identidad = $_POST['identidad'];

    $sql = "INSERT INTO users (nombre, apellido, usuario, contrasena, correo, rol, genero, telefono, direccion, fecha_nacimiento, identidad) VALUES ('$nombre', '$apellido', '$usuario', '$contrasena', '$correo', '$rol', '$genero', '$telefono', '$direccion', '$fecha_nacimiento', '$identidad')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Usuario creado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Leer usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Actualizar y eliminar usuarios
?>

<a href="logout.php">Cerrar sesión</a>
<h2>Crear Usuario</h2>
<form method="post" action="">
    Nombre: <input type="text" name="nombre" required><br>
    Apellido: <input type="text" name="apellido" required><br>
    Usuario: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="contrasena" required><br>
    Correo: <input type="email" name="correo" required><br>
    Rol: <input type="text" name="rol" required><br>
    Genero: <input type="text" name="genero"><br>
    Teléfono: <input type="text" name="telefono"><br>
    Dirección: <input type="text" name="direccion"><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento"><br>
    Identidad: <input type="text" name="identidad"><br>
    <input type="submit" name="create" value="Crear Usuario">
</form>

<h2>Lista de Usuarios</h2>
<table border="1">
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
        <th>Fecha de Creación</th>
        <th>Fecha de Modificación</th>
        <th>Acciones</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['apellido'] . "</td>";
            echo "<td>" . $row['usuario'] . "</td>";
            echo "<td>" . $row['correo'] . "</td>";
            echo "<td>" . $row['rol'] . "</td>";
            echo "<td>" . $row['genero'] . "</td>";
            echo "<td>" . $row['telefono'] . "</td>";
            echo "<td>" . $row['direccion'] . "</td>";
            echo "<td>" . $row['fecha_nacimiento'] . "</td>";
            echo "<td>" . $row['identidad'] . "</td>";
            echo "<td>" . $row['fecha_creacion'] . "</td>";
            echo "<td>" . $row['fecha_modificacion'] . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Editar</a> | <a href='delete.php?id=" . $row['id'] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='14'>No hay usuarios</td></tr>";
    }
    ?>
</table>
