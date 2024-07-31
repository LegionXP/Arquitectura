<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: crud.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
