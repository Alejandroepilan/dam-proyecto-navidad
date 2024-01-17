<?php
// DEBUG ERRORES
error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();
$user_id = $_SESSION['user_id'];

require_once('../config/db.php');
require_once('../app/functions/is_admin.php');

if (!isset($user_id) || !is_admin($user_id)) {
  header('Location: /');
  exit();
}

$conexion = conectarDB();

// Datos usuarios
$sql_users = "SELECT * FROM users";
$resultado2 = $conexion->query($sql_users);
?>

<?php include '../app/components/header.php'; ?>

<body>

  <div class="min-h-screen bg-[#7A6F5D]">
    <?php include '../app/components/navbar.php'; ?>
    <div class="py-32 px-16 flex flex-col items-center">
      <div class="bg-white mb-16 w-full max-w-lg flex items-center justify-center p-6 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <p class="text-2xl inline-block">Panel de administración</p>
      </div>
      <div class="bg-white mb-16 w-full p-9 shadow rounded-2xl ring-1 ring-black ring-opacity-5">
        <div class="text-2xl inline-block font-semibold mb-4">
          Usuarios
          <button onclick="abrirFormContainer()"><i class="fa-solid fa-plus ml-2 pointer"></i></button>
        </div>
        <table class='min-w-full'>
          <tr id='usersFormContainer' class="hidden">
            <form id='users' method='post'>
              <td></td>
              <input type='text' class='hidden' name='user_id' >
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='name' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='lastname' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='email' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='idfiscal' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='phone' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='password' ></td>
              <td><input type='text' class='w-full mb-4 bg-gray-100 px-4 py-2 rounded-md outline-none' name='is_admin' ></td>
              <td></td>
              <td><div class='h-full mb-4 py-2 px-4 flex items-center justify-around '>
                <button type='submit'><i class='fa-solid fa-check'></i></button>
                </form>
                <button onclick='cerrarFormContainer()' ><i class='fa-solid fa-xmark'></i></button>
                </div></td>
          </tr>  
        <tr>
        <?php
          // Obtener los nombres de las columnas
          $infoColumnas = $resultado2->fetch_fields();
          foreach ($infoColumnas as $columna) {
              echo "<th class='py-2 px-4 text-left border-b'>" . $columna->name . "</th>";
          }          
          echo "<th class='py-2 px-4 text-left border-b'>ACCIONES</th>";
          echo "</tr><tr>";

          // Mostrar los datos
          while ($fila = $resultado2->fetch_assoc()) {
            echo "<tr>";
            foreach ($fila as $valor) {
              echo "<td class='py-2 px-4 border-b'>" . $valor . "</td>";
            }
            echo "
            <td class='h-full py-2 px-4 border-b'>
              <div class='flex items-center justify-around '>
                <button onclick='editar_elemento(" . $fila['user_id'] . ")'><i class='fa-solid fa-pen'></i></button>
                <button onclick='borrar_elemento(" . $fila['user_id'] . ")'><i class='fa-solid fa-trash-can'></i></button>
              </div>
            </td>";
            echo "</tr>";
          }
        ?>        
          
        </table>
        <script>
          var editandoElemento = false;
          var idElementoEditanto;

            function abrirFormContainer() {
              $("#usersFormContainer").removeClass('hidden');
            }
            function cerrarFormContainer() {
              $("#usersFormContainer").addClass('hidden');
            }

            function editar_elemento(id) {
              editandoElemento = true;
              idElementoEditanto = id;
              obtener_elemento(id);
              console.log("editnado...");
            }

            function obtener_elemento(id) {
              var datos;

              $.ajax({
                  type: "POST",
                  url: "/api/user-read",
                  data: { id: id },
                  dataType: "json",
                  success: function(response) {
                    abrirFormContainer();
                    console.log(response);
                    $.each(response, function(nombreCampo, valorCampo) {
                        // Seleccionar el campo por su nombre y establecer el valor
                        $("input[name='" + nombreCampo + "']").val(valorCampo);
                    });
                  }
              });              
            }

            $("#users").submit(function(event) {
              var formData = new FormData(this);

              if (editandoElemento) {
                $.ajax({
                    type: "POST",
                    url: "/api/user-update",
                    //data: {id: idElementoEditanto},
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Recargar la página después de la eliminación
                        location.reload();
                    }
                });
                editandoElemento = false;
              }
              else {

                // Realizar una solicitud AJAX para eliminar el dato
                $.ajax({
                    type: "POST",
                    url: "/api/user-create",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Recargar la página después de la eliminación
                        location.reload();
                    }
                });
              }
            });

            function borrar_elemento(id) {
              if (confirm("¿Estás seguro de eliminar este dato?")) {
                // Realizar una solicitud AJAX para eliminar el dato
                $.ajax({
                    type: "POST",
                    url: "/api/user-delete",
                    data: { id: id },
                    success: function(response) {
                        // Recargar la página después de la eliminación
                        location.reload();
                    }
                });
              }
            }
        </script>
      </div>
    </div>
  </div>

</body>
</html>

<?php
  $conexion->close();
?>