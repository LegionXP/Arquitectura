<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>INICIO</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

     <?php include 'header.php' ?>

     <h1>Hello, <?php echo $_SESSION['name']; ?></h1>
     <a id="logout" href="logout.php">Logout</a>
</body>
</html>

<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>