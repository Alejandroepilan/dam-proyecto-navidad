<?php
include "head.users.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {
  $id = $_POST["user_id"];
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña
  $is_admin = $_POST["is_admin"];

  $sql_user_update = "UPDATE users SET name = '$name', lastname = '$lastname', email = '$email', idfiscal = '$idfiscal', phone = '$phone', password = '$password', is_admin = '$is_admin' WHERE (`user_id` = '$id')";
  $resultado = $conexion->query($sql_user_update);
} else {
  http_response_code(400); // Solicitud incorrecta
}
?>