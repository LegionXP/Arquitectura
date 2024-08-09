<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido al Sistema de Facturación</h2>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin/crud.php" class="link-button">Gestión de Usuarios</a>
            <a href="admin/inventario.php" class="link-button">Gestión de Inventario</a>
        <?php endif; ?>
        <a href="employee/factura.php" class="link-button">Facturación</a>
        <a href="logout.php" class="link-button">Cerrar Sesión</a>
    </div>
</body>
</html>
