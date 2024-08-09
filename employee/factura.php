<?php
session_start();
if ($_SESSION['role'] != 'employee' && $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');

if (isset($_POST['create_invoice'])) {
    $products = isset($_POST['products']) ? $_POST['products'] : [];
    $total_amount = 0;

    if (!empty($products)) {
        $stmt = $conn->prepare("INSERT INTO invoices (user_id, total_amount, invoice_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $_SESSION['user_id'], $total_amount);
        $stmt->execute();
        if ($stmt->error) {
            echo 'Error al crear la factura: ' . $stmt->error;
            exit();
        }
        $invoice_id = $stmt->insert_id;

        foreach ($products as $product_id => $quantity) {
            if ($quantity > 0) {
                $product_query = $conn->query("SELECT * FROM products WHERE id = $product_id");
                if ($conn->error) {
                    echo 'Error al obtener producto: ' . $conn->error;
                    exit();
                }
                $product = $product_query->fetch_assoc();
                $amount = $product['price'] * $quantity;
                $total_amount += $amount;

                $conn->query("INSERT INTO invoice_details (invoice_id, product_id, quantity, amount) VALUES ($invoice_id, $product_id, $quantity, $amount)");
                if ($conn->error) {
                    echo 'Error al insertar detalles de la factura: ' . $conn->error;
                    exit();
                }
                $conn->query("UPDATE products SET stock_quantity = stock_quantity - $quantity WHERE id = $product_id");
                if ($conn->error) {
                    echo 'Error al actualizar inventario: ' . $conn->error;
                    exit();
                }
            }
        }

        $conn->query("UPDATE invoices SET total_amount = $total_amount WHERE id = $invoice_id");
        if ($conn->error) {
            echo 'Error al actualizar total de la factura: ' . $conn->error;
            exit();
        }

        $date = date('Y-m-d');
        $daily_file = '../ganancias.txt';

        if (file_exists($daily_file)) {
            $file_content = file_get_contents($daily_file);
            $daily_earnings = json_decode($file_content, true);
        } else {
            $daily_earnings = [];
        }

        if (isset($daily_earnings[$date])) {
            $daily_earnings[$date] += $total_amount;
        } else {
            $daily_earnings[$date] = $total_amount;
        }

        file_put_contents($daily_file, json_encode($daily_earnings));

        $invoice_details_query = $conn->query("SELECT * FROM invoice_details JOIN products ON invoice_details.product_id = products.id WHERE invoice_details.invoice_id = $invoice_id");
        if ($conn->error) {
            echo 'Error al obtener detalles de la factura: ' . $conn->error;
            exit();
        }
        $invoice_details = $invoice_details_query->fetch_all(MYSQLI_ASSOC);
        $attendant = $_SESSION['username'];
        $date_display = date('d-m-Y H:i:s');
    } else {
        $error_message = "No se seleccionaron productos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Facturación</h2>
        <form method="POST" action="factura.php" id="invoiceForm">
            <?php
            $result = $conn->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()): ?>
            <div class="form-group">
                <label><?php echo $row['name']; ?> (<?php echo $row['price']; ?> $)</label>
                <input type="number" name="products[<?php echo $row['id']; ?>]" min="0" max="<?php echo $row['stock_quantity']; ?>" placeholder="Cantidad">
            </div>
            <?php endwhile; ?>
            <button type="submit" name="create_invoice">Crear Factura</button>
            <button type="button" onclick="clearForm()">Limpiar Factura</button>
        </form>

        <?php if (isset($error_message)): ?>
            <div class="error">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($invoice_details)): ?>
            <div class="invoice">
                <h3>Factura</h3>
                <p>Atendido por: <?php echo $attendant; ?></p>
                <p>Fecha: <?php echo $date_display; ?></p>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoice_details as $detail): ?>
                        <tr>
                            <td><?php echo $detail['name']; ?></td>
                            <td><?php echo $detail['quantity']; ?></td>
                            <td><?php echo $detail['price']; ?></td>
                            <td><?php echo number_format($detail['amount'], 2) . ' $'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong><?php echo number_format($total_amount, 2) . ' $'; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="../index.php" class="link-button">Regresar al Menú Principal</a>
    </div>

    <script>
        function clearForm() {
            document.getElementById("invoiceForm").reset();
        }
    </script>
</body>
</html>
