<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../config/db.php');

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('Location: /login');
  exit();
}


$conexion = conectarDB();

// Obtener la ruta actual sin la barra
$ruta_actual = $_SERVER['REQUEST_URI'];
$ruta_sin_barra = substr($ruta_actual, 1);

// Seleccionamos la vista de las ong, pero solo las del tipo en el que nos encontramos
$sql_ongs = "SELECT * FROM ong_view WHERE type_link = '$ruta_sin_barra' ";
$resultado = $conexion->query($sql_ongs);
$ongs = $resultado->fetch_all(MYSQLI_ASSOC);

$sql_transaction_currencys = "SELECT * FROM transactions_currency";
$resultado = $conexion->query($sql_transaction_currencys);
$transaction_currencys = $resultado->fetch_all(MYSQLI_ASSOC);

?>

<?php include '../app/components/header.php'; ?>

<body>
  <div class="min-h-screen bg-[#7A6F5D]">
    <?php include '../app/components/navbar.php'; ?>

    <div class="py-32 relative flex flex-col items-center">
      <!-- <a href="/" class="sticky flex items-center justify-center bg-white hover:bg-gray-100 w-12 h-12 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <i class="fa-solid fa-arrow-left"></i>
      </a> -->
      <?php foreach ($ongs as $ong) : ?>
        <div id="<?php echo $ong['ong_id']; ?>" class="bg-white mb-16 w-full max-w-2xl p-9 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
          <div class="w-48 mb-9">
            <img src="<?php echo $ong['logo_url']; ?>" />
          </div>
          <div class="flex items-center justify-between mb-9">
            <a href="<?php echo $ong['url']; ?>" target="_blank" class="text-xl font-semibold hover:underline">
              <?php echo $ong['name']; ?>
            </a>
            <span class="fi fi-<?php echo $ong['country_code']; ?>"></span>
          </div>
          <div class="mb-9"><?php echo $ong['description']; ?></div>
          <form action="<?php $ruta_actual ?>" method="post" class="flex items-center justify-left ">
            <input type="number" name="transaction_amount_input" required="true" placeholder="10" class="bg-gray-100 px-4 py-2 rounded-md outline-none w-32	mr-6" />
            <select name="transaction_currency_input" class="bg-gray-100 px-4 py-2 rounded-md outline-none mr-6">
              <?php foreach ($transaction_currencys as $transaction_currency) : ?>
                <option value="<?php echo $transaction_currency['transactions_currency_id']; ?>"><?php echo $transaction_currency['code']; ?></option>
              <?php endforeach; ?>
            </select>
            <button value="<?php echo $ong['ong_id']; ?>" name="ong_button" type="submit" class="outline-none rounded-md py-2 px-4 bg-[#82BFA0] hover:bg-[#72A88D]" />
              Donar
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_amount_input = $_POST['transaction_amount_input'];
    $transaction_currency_input = $_POST['transaction_currency_input'];
    $ong_id = $_POST['ong_button'];
    
    $sql = "INSERT INTO transactions (user_id, ong_id, currency_id, amount) VALUES ('$user_id', '$ong_id', '$transaction_currency_input', '$transaction_amount_input')";
    
    if ($conexion->query($sql) === true) {
    } else {
      echo "Error al registrar: " . $conexion->error;
    }
  }

  $conexion->close();
?>