<?php

$url = $_SERVER['REQUEST_URI'];

switch ($url) {
  case '/':
    include '../views/inicio.php';
    break;
  case '/register':
    include '../views/registro.php';
    break;
  case '/login':
    include '../views/login.php';
    break;
  case '/logout':
    include '../views/cerrar_sesion.php';
    break;
  default:
    // Página de error 404 si la ruta no coincide
    http_response_code(404);
    break;
}
