<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header('Location: /');
  exit();
}

require_once('../config/db.php');

$conexion = conectarDB();
?>

<?php include '../app/components/header.php'; ?>

<body>

  <div class="h-screen flex flex-col items-center justify-center bg-[#7A6F5D]">
    <div class="bg-white max-w-md p-10 rounded-md  text-black">
      <form action="/register" method="post">
        <div class="w-full mb-4">
          <a class=" text-2xl font-bold">Crea una cuenta</a>
        </div>
        <input type="text" name="name" placeholder="Nombre" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="lastname" placeholder="Apellidos" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="email" name="email" placeholder="Correo electrónico" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="idfiscal" placeholder="DNI" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="text" name="phone" placeholder="Teléfono" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <input type="password" name="password" placeholder="Contraseña" required="true" class="w-full bg-gray-100  px-4 py-2  rounded-md my-2 outline-none" />
        <button type="submit" class="w-full outline-none  py-2 rounded-md my-2 bg-[#82BFA0] hover:bg-[#72A88D]">
          Regístrate
        </button>
        <div class="mt-6">
          <span>¿Ya tienes una cuenta? </span>
          <a href="/login" class="text-[#82BFA0] outline-none hover:text-[#72A88D] hover:underline under cursor-pointer">
            Iniciar sesión
          </a>
        </div>
      </form>
    </div>

</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $lastname = $_POST["lastname"];
  $email = $_POST["email"];
  $idfiscal = $_POST["idfiscal"];
  $phone = $_POST["phone"];

  $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash de la contraseña

  $sql = "INSERT INTO users (name, lastname, email, idfiscal, phone, password) VALUES ('$name', '$lastname', '$email', '$idfiscal', '$phone', '$password')";

  if ($conexion->query($sql) === true) {
    header("Location: /");
    echo "Guardado!";
  } else {
    echo "Error al registrar: " . $conexion->error;
  }
}

$conexion->close();
