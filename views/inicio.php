<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../config/db_conn.php');

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /login');
  exit();
}

$conexion = conectarDB();

// aa

$resultado = $conexion->query("SELECT ong_type_id, name FROM ong_type");

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
  // Obtener los datos de cada usuario
  $tipos_ong = $resultado->fetch_all(MYSQLI_ASSOC);
} else {
  // No hay usuarios
  $tipos_ong = [];
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Inicio</title>
  <script src="https://kit.fontawesome.com/66aaee9b39.js" crossorigin="anonymous"></script>
</head>

<body>

  <h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>

  <a href="/logout">Cerrar Sesión</a>


  <?php foreach ($tipos_ong as $tipo_ong) : ?>
    <div id="<?php echo $tipo_ong['ong_type_id']; ?>">
      <p><?php echo $tipo_ong['name']; ?></p>
    </div>
  <?php endforeach; ?>

</body>

</html>