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
    <div class="bg-white max-w-md p-10 rounded-md text-black">
      <form action="/login" method="post">
        <div class="w-full mb-4">
          <a class=" text-2xl font-bold">Iniciar sesión</a>
        </div>
        <input type="text" name="email" required="true" class="w-full bg-gray-100 px-4 py-2 rounded-md my-2 outline-none" placeholder="Email" />
        <input type="password" name="password" required="true" class="w-full bg-gray-100 px-4 py-2 rounded-md my-2 outline-none" placeholder="Contraseña" />
        <button type="submit" class="w-full outline-none rounded-md py-2 my-2 bg-[#82BFA0] hover:bg-[#72A88D]">
          Iniciar sesión
        </button>
        <div class="mt-6">
          <span>¿No tienes una cuenta? </span>
          <a href="/register" class="text-[#82BFA0] outline-none hover:text-[#72A88D] hover:underline under cursor-pointer">
            Regístrate
          </a>
        </div>
      </form>
    </div>
  </div>

</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['email'] = $row['email'];

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