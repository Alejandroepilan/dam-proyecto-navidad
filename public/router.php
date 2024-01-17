<?php
// Requerir el archivo con la funcion de conexion a la DB
require_once('../config/db.php');

// Rutas disponibles en la app
$rutas = [
  "register",
  "login",
  "logout",
  "profile",
  "admin",
  "test",
];

// Conectar a la DB para obtener las secciones de las ONG
$conexion = conectarDB();
$sql_tipos_ong = "SELECT link FROM ong_type";
$resultado = $conexion->query($sql_tipos_ong);
$rutas_tipos_ong = $resultado->fetch_all(MYSQLI_ASSOC);

// Obtener url de la pagina en la que nos encontramos
$url = $_SERVER['REQUEST_URI'];

////// Creamos los switch para hacer el router
/*
foreach ($rutas as $ruta) {
  switch ($url) {
    case '/' . $ruta:
      include '../app/views/' . $ruta . '.php';
      break;
  }
}*/

foreach ($rutas_tipos_ong as $ruta_tipo_ong) {
  switch ($url) {
    case '/'. $ruta_tipo_ong['link']:
      include '../app/views/ongs.php';
      break;
  }
}

switch ($url) {
  case '/':
    include '../app/views/home.php';
    break;

  case '/login':
    include '../app/views/login.php';
    break;
  case '/register':
    include '../app/views/register.php';
    break;
  case '/logout':
    include '../app/views/logout.php';
    break;
  case '/profile':
    include '../app/views/profile.php';
    break;
  case '/admin':
    include '../app/views/admin.php';
    break;

    
  ////// API //////

  // Users
  case '/api/user-create':
    include '../app/controllers/users/users.create.php';
    break; 
  case '/api/user-read':
    include '../app/controllers/users/users.read.php';
    break;   
  case '/api/user-update':
    include '../app/controllers/users/users.update.php';
    break;
  case '/api/user-delete':
    include '../app/controllers/users/users.delete.php';
    break;

  case '/api/profile-update':
    include '../app/controllers/profile.update.php';
    break;
  
  // Página de error 404 si la ruta no coincide a ninguno de los casos
  default:
    http_response_code(404);
    break;
}



