<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="h-screen flex flex-col items-center justify-center bg-teal-400">
    <div class="bg-white max-w-md p-10 rounded-md text-black">
      <form action="/login" method="post">
        <div class="w-full mb-4">
          <a class=" text-2xl font-bold">Iniciar sesión</a>
        </div>
        <input type="text" name="username" required="true" class="w-full bg-gray-50  px-4 py-2 rounded-md my-2 outline-none" placeholder="Nombre de usuario" />
        <input type="password" name="password" required="true" class="w-full bg-gray-50  px-4 py-2 rounded-md my-2 outline-none" placeholder="Contraseña" />
        <button type="submit" class="w-full outline-none rounded-md py-2 my-2 bg-teal-400 hover:bg-teal-500">
          Iniciar sesión
        </button>
        <div class="mt-6">
          <span>¿No tienes una cuenta? </span>
          <a href="/register" class="text-teal-400 outline-none hover:text-teal-500 hover:underline under cursor-pointer">
            Regístrate
          </a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>


<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../config/db_conn.php');

session_start();

$conexion = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['username'] = $row['username'];

      header("Location: /");
    } else {
      echo "Contraseña incorrecta";
    }
  } else {
    echo "Usuario no encontrado";
  }
}

$conexion->close();
?>