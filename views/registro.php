<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <!--<form action="/register" method="post">
    <input type="text" placeholder="Nombre de usuario" name="username"><br>
    <input type="text" placeholder="Nombre" name="name"><br>
    <input type="text" placeholder="Apellidos" name="lastname"><br>
    <input type="email" placeholder="Correo electrónico" name="email"><br>
    <input type="text" placeholder="DNI" name="idfiscal"><br>
    <input type="text" placeholder="Teléfono" name="phone"><br>

    <input type="password" placeholder="Contraseña" name="password"><br>

    <input type="submit" value="Registrarse">
  </form>

  <a href="/login">Iniciar Sesión</a> -->

  <div class="h-screen flex flex-col items-center justify-center bg-teal-400">
    <div class="bg-white max-w-md p-10 rounded-md  text-black">
      <form action="/register" method="post">
        <div class="w-full mb-4">
          <a class=" text-2xl font-bold">Crea una cuenta</a>
        </div>
        <input type="text" name="username" placeholder="Nombre de usuario" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="name" placeholder="Nombre" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="lastname" placeholder="Apellidos" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="email" name="email" placeholder="Correo electrónico" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="idfiscal" placeholder="DNI" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="phone" placeholder="Teléfono" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="password" name="password" placeholder="Contraseña" required="true" class="w-full bg-gray-50  px-4 py-2  rounded-md my-2 outline-none" />
        <button type="submit" class="w-full outline-none  py-2 rounded-md my-2 bg-teal-400 hover:bg-teal-500">
          Regístrate
        </button>
        <div class="mt-6">
          <span>¿Ya tienes una cuenta? </span>
          <a href="/login" class="text-teal-400 outline-none hover:text-teal-500 hover:underline under cursor-pointer">
            Iniciar sesión
          </a>
        </div>
      </form>
    </div>

</body>

</html>

<?php
require_once('../config/db_conn.php');

$conexion = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];

  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña

  $sql = "INSERT INTO users (username, name, lastname, email, idfiscal, phone, password) VALUES ('$username', '$name', '$lastname', '$email', '$idfiscal', '$phone', '$password')";

  if ($conexion->query($sql) === true) {
    header("Location: /");
    echo "Guardado!";
  } else {
    echo "Error al registrar: " . $conexion->error;
  }
}

$conexion->close();
