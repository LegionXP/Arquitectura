<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

// Añadir producto
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO products (name, price, stock_quantity) VALUES ('$name', '$price', '$stock_quantity')";
    if ($conn->query($sql) === TRUE) {
        echo "Producto añadido con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Leer productos
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Actualizar producto
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "UPDATE products SET name='$name', price='$price', stock_quantity='$stock_quantity' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar producto
if (isset($_POST['delete_product'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado con éxito";
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
    <title>Gestión de Inventario</title>
    <link rel="stylesheet" href="../css/styles.css">

<h2>Gestión de Inventario</h2>

<!-- Formulario para añadir producto -->
<form method="POST" action="inventario.php">
    <input type="text" name="name" placeholder="Nombre del producto" required>
    <input type="number" step="0.01" name="price" placeholder="Precio" required>
    <input type="number" name="stock_quantity" placeholder="Cantidad en inventario" required>
    <button type="submit" name="add_product">Añadir Producto</button>
    <a href="../index.php" class="link-button">Regresar al Menú Principal</a>
</form>

<!-- Mostrar productos existentes -->
<h3>Productos en Inventario</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['stock_quantity']; ?></td>
        <td>
            <!-- Formulario para actualizar producto -->
            <form method="POST" action="inventario.php" style="display:inline-block;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required>
                <input type="number" name="stock_quantity" value="<?php echo $row['stock_quantity']; ?>" required>
                <button type="submit" name="update_product">Actualizar</button>
            </form>
            <!-- Formulario para eliminar producto -->
            <form method="POST" action="manage_inventory.php" style="display:inline-block;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="delete_product" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">Eliminar</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>