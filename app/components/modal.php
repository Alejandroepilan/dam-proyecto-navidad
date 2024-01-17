<?php
  function borrar_elemento() {
    echo "borrando...";
  };

  function generarModal($modalId, $modalTitulo, $modalContenido, $modalAccion) {
    echo <<<HTML
      <div id="$modalId" class="fixed hidden inset-0 overflow-auto z-20">
          <div class="flex items-center justify-center min-h-screen">
              <div class="absolute w-full h-full bg-gray-800 opacity-50"></div>
              <div class="bg-white w-11/12 md:max-w-md mx-auto shadow rounded-2xl ring-1 ring-black ring-opacity-5 z-30 overflow-y-auto">
                  <div class="p-6 text-left">
                      <div class="flex justify-between items-center pb-3">
                          <p class="text-2xl font-bold">$modalTitulo</p>
                          <button onclick="cerrarModal('$modalId')" class="cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                          </button>
                      </div>
                      <div class="mb-4">
                          $modalContenido
                      </div>
                      <div class="flex items-center justify-end">
                        <button onclick="cerrarModal('$modalId')" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2 mr-4">Cancelar</button>
                        <button onclick="$modalAccion" class="bg-[#82BFA0] hover:bg-[#72A88D] rounded-md p-2">
                          Aceptar                          
                        </button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script>
        function abrirModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
      </script>
    HTML;
  }
?>

