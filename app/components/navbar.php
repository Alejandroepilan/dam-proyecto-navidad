<?php
  require_once('../app/functions/is_admin.php');
  
  $sql_user = "SELECT name, lastname FROM users WHERE user_id = '$user_id'";
  $resultado = $conexion->query($sql_user);
  $user_data = $resultado->fetch_assoc();
?>

<div class="fixed w-full z-10 flex items-center p-4 justify-between bg-white shadow ring-1 ring-black ring-opacity-5">
  <a href="/" class="text-xl">ONG Manager</a>
  <div>
    <?php 
      // Pongo el elemento a desde php porque si no me añadia un espacio al final del string
      echo '<a href="/profile" class="mr-4 hover:underline">' . $user_data["name"] . "\n" . $user_data['lastname'] . '</a>';

      if (is_admin($user_id)) {
    ?>
      <a href="/admin" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2 mr-2">
        <i class="fa-solid fa-user-shield mr-1"></i>
        Panel de administración
      </a>
    <?php
      }
    ?>
    <a href="/logout" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2">
      <i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>
      Cerrar Sesión
    </a>
  </div>
</div>
