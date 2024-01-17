<?php
include "head.users.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
  $id = $_POST["id"];

  $sql_user_delete = "DELETE FROM users WHERE (`user_id` = '$id')";
  $resultado = $conexion->query($sql_user_delete);
} else {
  http_response_code(400); // Solicitud incorrecta
}
?>