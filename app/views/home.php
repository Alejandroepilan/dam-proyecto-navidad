<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

$user_id = $_SESSION['user_id'];

require_once('../config/db.php');

if (!isset($user_id)) {
  header('Location: /login');
  exit();
}

//$conexion = conectarDB();
$sql_tipos_ong = "SELECT * FROM ong_type";
$resultado = $conexion->query($sql_tipos_ong);
$tipos_ong = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<?php include '../app/components/header.php'; ?>

<body>

  <div class="min-h-screen bg-[#7A6F5D]">
  <?php include '../app/components/navbar.php'; ?>

    <div class="py-32 flex flex-col items-center">
      <div class="bg-white mb-16 w-full max-w-lg flex items-center justify-center p-6 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <p class="text-2xl inline-block">¿Dónde quieres donar?</p>
      </div>
      <?php foreach ($tipos_ong as $tipo_ong) : ?>
        <a id="<?php echo $tipo_ong['ong_type_id']; ?>" href="/<?php echo $tipo_ong['link']; ?>" class="flex items-center justify-between bg-white hover:bg-gray-100 w-full max-w-md mb-8 p-4 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
          <?php echo $tipo_ong['name']; ?>
          <i class="fa-solid fa-<?php echo $tipo_ong['icon']; ?> text-right"></i>   
        </a>
      <?php endforeach; ?>
    </div>
  </div>

</body>
</html>

<?php
  $conexion->close();
?>