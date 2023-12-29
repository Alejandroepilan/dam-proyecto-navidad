<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Login de Usuarios</title>
</head>

<body>
  <form action="/login" method="post">
    <input type="text" placeholder="Nombre de usuario" name="username"><br>
    <input type="password" placeholder="Contraseña" name="password"><br>

    <input type="submit" value="Iniciar sesion">
  </form>

  <a href="/register">Registrarse</a>

</body>

</html>


<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../config/db_conn.php');

session_start();

$conexion = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['username'] = $row['username'];

      header("Location: /");
    } else {
      echo "Contraseña incorrecta";
    }
  } else {
    echo "Usuario no encontrado";
  }
}

$conexion->close();
?>