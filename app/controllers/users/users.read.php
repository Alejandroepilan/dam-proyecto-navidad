<?php
include "head.users.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
  $id = $_POST["id"];

  $sql_user_read = "SELECT user_id, name, lastname, email, idfiscal, phone, is_admin FROM users WHERE user_id = '$id'";
  $resultado = $conexion->query($sql_user_read);
  $data = $resultado->fetch_all(MYSQLI_ASSOC);
  $data_json = json_encode($data[0]);
  echo $data_json;
} else {
  http_response_code(400); // Solicitud incorrecta
}
?>