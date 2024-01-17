<?php
define('DB_HOST', 'epila.dev');
define('DB_USER', 'alejandro');
define('DB_PASSWORD', '2yXTHf-b-ErBghZkP-2c');
define('DB_NAME', 'dam_proyecto_navidad');

function conectarDB()
{
  $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
  }

  return $conexion;
}
