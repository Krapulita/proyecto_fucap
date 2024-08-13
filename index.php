<?php
// index.php

include 'loggedin.php';

// Check if the user is logged in
if (is_loggedin()) {
    // Display the protected content
    echo 'You are logged in!';
} else {
    // Display the login form
    echo '<form action="login.php" method="post">';
    echo 'Username: <input type="text" name="username"><br>';
    echo 'Password: <input type="password" name="password"><br>';
    echo '<input type="submit" value="Login">';
    echo '</form>';
}
?>
<!-- Your HTML code here -->
<!DOCTYPE html>
<html lang="es">
<head>
  <!-- ... -->
</head>
<body>
  <!-- ... -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!-- ... -->
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <!-- ... -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownAccount" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mi Cuenta</a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAccount">
          <?php if (is_loggedin()) { ?>
            <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
          <?php } else { ?>
            <li><a class="dropdown-item" href="login.html">Iniciar Sesion</a></li>
            <li><a class="dropdown-item" href="register.html">Crear Cuenta</a></li>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- ... -->
</body>
</html>