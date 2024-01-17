<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once('../config/db.php');
$conexion = conectarDB();

$sql_tipos_ong = "SELECT link FROM ong_type";
$resultado = $conexion->query($sql_tipos_ong);
$tipos_ong = $resultado->fetch_all(MYSQLI_ASSOC);

$url = "migrantes";
//$casos = echo $subarray['link'];

// Recorrer el array y extraer las cadenas
foreach ($tipos_ong as $subarray) {
  switch ($url) {
    case $subarray['link']:
      echo "\nESTAA";
      break;
  }

}

?>