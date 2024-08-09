<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = '$admin_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "El usuario administrador ya existe.";
} else {

    $sql = "INSERT INTO users (username, password, role) VALUES ('$admin_username', '$hashed_password', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario administrador creado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
