<?php

// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Inicio</title>
</head>

<body>

  <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>

  <a href="/logout">Cerrar Sesión</a>

</body>

</html>