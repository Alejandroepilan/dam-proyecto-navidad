<?php
session_start();
$user_id = $_SESSION['user_id'];

require_once('../config/db.php');
require_once('../app/functions/is_admin.php');

if (!isset($user_id) || !is_admin($user_id)) {
    http_response_code(400);
  exit();
}

$conexion = conectarDB();
?>