<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('Location: /login');
  exit();
}

require_once('../config/db.php');
$conexion = conectarDB();
$sql_my_user = "SELECT name, lastname, email, idfiscal, phone, password FROM users WHERE user_id = '$user_id'";
$resultado = $conexion->query($sql_my_user);
$my_user = $resultado->fetch_assoc();

$sql_transactions = "SELECT * FROM transactions_view WHERE user_id = '$user_id' ORDER BY transaction_id DESC";
$resultado = $conexion->query($sql_transactions);
$transactions = $resultado->fetch_all(MYSQLI_ASSOC);

?>

<?php include '../app/components/header.php'; ?>

<body>

  <div class="min-h-screen bg-[#7A6F5D]">
    <?php include '../app/components/navbar.php'; ?>
    <div class="py-32 flex flex-col items-center">
      <div class="bg-white mb-16 w-full max-w-2xl p-9 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <div class="text-2xl inline-block font-semibold mb-8">Tus datos</div>
        <div class="inline-block mb-8">Aquí puedes revisar y actualizar tus datos de usuario Gestiona tus contraseñas y cómo iniciar sesión.</div>
        <form id="my-data-form" method="post">
          <div class="grid grid-cols-2 gap-x-6">
            <div class="flex flex-col">
              <p>Nombre</p>
              <input type='text' value="<?php echo $my_user["name"] ?>" class='mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='name' />
            </div>
            <div class="flex flex-col">
              <p>Apellidos</p>
              <input type='text' value="<?php echo $my_user["lastname"] ?>" class='mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='lastname' />
            </div>
            <div class="flex flex-col">
              <p>DNI</p>
              <input type='text' value="<?php echo $my_user["idfiscal"] ?>" class='mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='idfiscal' />
            </div>
            <div class="flex flex-col">
              <p>Teléfono</p>
              <input type='text' value="<?php echo $my_user["phone"] ?>" class='mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='phone' />
            </div>
          </div>
            <p>Email</p>
            <input type='email' value="<?php echo $my_user["email"] ?>" class='w-full mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='email' />
            <p>Contraseña</p>
            <input type='password' value="<?php echo $my_user["password"] ?>" class='w-full mt-2 mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' required disabled name='password' />
        
          <div id="edit-confirm" class="hidden mt-8">
            <button type="submit" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2 mr-2">
              Aceptar
            </button>
            <div id="edit-btn-cancel" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2 mr-2 cursor-pointer inline-block">
              Cancelar
            </div>
          </div>
        </form>
        <button id="edit-btn" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2 mt-8">
          <i class="fa-solid fa-pen-to-square mr-1"></i>
          Editar datos
        </button>

        <script>
          var inputs = $('#my-data-form').find('input');

          $("#edit-btn").click(function(event) {
            $("#edit-btn").addClass("hidden");
            $("#edit-confirm").removeClass("hidden");
            inputs.prop("disabled", false);
            $("#my-data-form [name='password']").val("");
          });

          $("#edit-btn-cancel").click(function(event) {
            $("#edit-btn").removeClass("hidden");
            $("#edit-confirm").addClass("hidden");
            inputs.prop("disabled", true);

            $.each(<?php echo json_encode($my_user); ?>, function(nombreCampo, valorCampo) {
              $("#my-data-form [name='" + nombreCampo + "']").val(valorCampo);
            });
          });

          $("#my-data-form").submit(function(event) {
            //var datosFormulario = $("#my-data-form").serializeArray();
            var datosFormulario = new FormData(this);
            console.log(datosFormulario);
            
            $.ajax({
              type: "POST",
              url: "/api/profile-update",
              data: datosFormulario,
              dataType: "json",
              contentType: false,
              processData: false,
              success: function(response) {
                  // Recargar la página después de la eliminación
                  location.reload();
              }
            });
          });
        </script>

      </div>
      <div class="bg-white mb-16 w-full max-w-2xl p-9 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <div class="text-2xl inline-block font-semibold mb-8">Tus transacciones</div>
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="py-2 px-4 text-left border-b">ONG</th>
                <th class="py-2 px-4 text-left border-b">Cantidad</th>
                <th class="py-2 px-4 text-left border-b">Divisa</th>
                <th class="py-2 px-4 text-left border-b">Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($transactions as $transaction) : ?>
                <tr>
                  <td class="py-2 px-4 border-b"><?php echo $transaction['ong_name']; ?></td>
                  <td class="py-2 px-4 border-b"><?php echo $transaction['amount']; ?></td>
                  <td class="py-2 px-4 border-b"><?php echo $transaction['transactions_currency_name']; ?></td>
                  <td class="py-2 px-4 border-b"><?php echo $transaction['create_time']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>

</body>
</html>

<?php
  $conexion->close();
?>