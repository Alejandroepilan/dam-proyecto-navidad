<?php

$url = $_SERVER['REQUEST_URI'];

switch ($url) {
  case '/':
    include 'controllers/inicio.php';
    break;
  case '/register':
    include 'controllers/registro.php';
    break;
  case '/login':
    include 'controllers/login.php';
    break;
  case '/logout':
    include 'controllers/cerrar_sesion.php';
    break;
  default:
    // Página de error 404 si la ruta no coincide
    http_response_code(404);
    break;
}
