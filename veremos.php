<?php
session_start();
include('db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

?>

<link rel="stylesheet" href="login.css">

<form action="post">
    <p>Usuario: </p><input type="text" name="usuario" required><br>
    <p>Contraseña: </p><input type="password" name="contrasena" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>