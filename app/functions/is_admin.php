<?php
  require_once('../config/db.php');

  function is_admin($user_id) {
    $conexion = conectarDB();
    $sql_user = "SELECT is_admin FROM users WHERE user_id = '$user_id'";
    $resultado = $conexion->query($sql_user);
    $user_data = $resultado->fetch_assoc();
    return $user_data['is_admin'];
  };
?>