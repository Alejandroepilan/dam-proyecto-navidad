<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro de Usuarios</title>
</head>

<body>
  <form action="/register" method="post">
    <input type="text" placeholder="Nombre de usuario" name="username"><br>
    <input type="text" placeholder="Nombre" name="name"><br>
    <input type="text" placeholder="Apellidos" name="lastname"><br>
    <input type="email" placeholder="Correo electrónico" name="email"><br>
    <input type="text" placeholder="DNI" name="idfiscal"><br>
    <input type="text" placeholder="Teléfono" name="phone"><br>

    <input type="password" placeholder="Contraseña" name="password"><br>

    <input type="submit" value="Registrarse">
  </form>

  <a href="/login">Iniciar Sesión</a>

</body>

</html>

<?php
require_once('../config/db_conn.php');

$conexion = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];

  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña

  $sql = "INSERT INTO users (username, name, lastname, email, idfiscal, phone, password) VALUES ('$username', '$name', '$lastname', '$email', '$idfiscal', '$phone', '$password')";

  if ($conexion->query($sql) === true) {
    header("Location: /");
    echo "Guardado!";
  } else {
    echo "Error al registrar: " . $conexion->error;
  }
}

$conexion->close();
