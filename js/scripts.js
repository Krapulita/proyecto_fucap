    function loadUserMenu() {
      fetch('php/auth.php')
        .then(response => response.json())
        .then(data => {
          const accountDropdown = document.getElementById('accountDropdown');
          if (data.isLoggedIn) {
            accountDropdown.innerHTML = `
              <a class="nav-link dropdown-toggle" id="navbarDropdownAccount" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ${data.userData.name}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAccount">
                <li><a class="dropdown-item" href="php/editar_cuenta.php">Editar mi cuenta</a></li>
                <li><a class="dropdown-item" href="php/cerrar_sesion.php">Cerrar sesión</a></li>
              </ul>
            `;
          } else {
            accountDropdown.innerHTML = `
              <a class="nav-link dropdown-toggle" id="navbarDropdownAccount" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mi Cuenta</a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAccount">
                <li><a class="dropdown-item" href="login.html">Iniciar Sesion</a></li>
                <li><a class="dropdown-item" href="register.html">Crear Cuenta</a></li>
              </ul>
            `;
          }
    
          // Actualizar los enlaces de los módulos
          const moduleLinks = document.querySelectorAll('.module-link');
          moduleLinks.forEach(function(link) {
            if (!data.isLoggedIn) {
              link.addEventListener('click', function(event) {
                event.preventDefault();
                alert('Debes iniciar sesión para acceder a este módulo.');
              });
            }
          });
        })
        .catch(error => {
          console.error('Error al cargar el menú de usuario:', error);
        });
    }
    
    document.addEventListener('DOMContentLoaded', loadUserMenu);
