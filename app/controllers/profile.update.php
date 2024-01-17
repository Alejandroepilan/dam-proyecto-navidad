<?php
include "head.users.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña

  $sql_user_update = "UPDATE users SET name = '$name', lastname = '$lastname', email = '$email', idfiscal = '$idfiscal', phone = '$phone', password = '$password' WHERE (`user_id` = '$user_id')";
  $resultado = $conexion->query($sql_user_update);
} else {
  http_response_code(400); // Solicitud incorrecta
}
?>