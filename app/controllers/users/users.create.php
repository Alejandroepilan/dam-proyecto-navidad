<?php
include "head.users.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña
  $is_admin = $_POST["is_admin"];

  $sql_user_create = "INSERT INTO users (name, lastname, email, idfiscal, phone, password, is_admin) VALUES ('$name', '$lastname', '$email', '$idfiscal', '$phone', '$password', '$is_admin')";
  $resultado = $conexion->query($sql_user_create);
} else {
  http_response_code(400); // Solicitud incorrecta
}
?>