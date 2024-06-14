<?php
require_once __DIR__ . '../../../back/controllers/admin/controlador-utilizador.php';
?>

<!--Navbar Start here-->
<nav style="background-color: #000000; height: 80px;" class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand font-weight-bold text-light" href="/index.php" style="font-size: 1.5rem;">TechHouse</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div style="background-color: #000000;" class="offcanvas-header text-light">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">TechHouse</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div style="background-color: #000000;" class="offcanvas-body">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php if (!autenticado()) : ?>
            <li class="nav-item">
              <a class="nav-link text-light" href="../aplicacao/registo.php">
                <button class="button-circle">
                  <i class="fas fa-user-plus" style="font-size: 1.5rem;"></i>
                  <span>Register</span>
                </button>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light" href="../aplicacao/login.php">
                <button class="button-circle">
                  <i class="fas fa-sign-in-alt" style="font-size: 1.5rem;"></i>
                  <span>Login</span>
                </button>
              </a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link text-light" href="/aplicacao/perfil.php">
                <button class="button-circle">
                  <i class="fas fa-user" style="font-size: 1.5rem;"></i>
                  <span>Perfil</span>
                </button>
              </a>
            </li>
            <li class="nav-item mt-2">
              <form action="/back/controllers/app/controlador-autenticacao.php" method="post" class="d-inline">
                <button class="button-circle" type="submit" name="utilizador" value="logout">
                  <i class="fas fa-sign-out-alt" style="font-size: 1.5rem;"></i>
                  <span>Logout</span>
                </button>
              </form>
            </li>
            <?php
            if (isset($utilizador['administrador']) && $utilizador['administrador']) {
              echo '<li class="nav-item">';
              echo '<a class="nav-link text-light" href="/aplicacao/administracao.php">';
              echo '<button class="button-circle">';
              echo '<i class="ri-admin-fill" style="font-size: 1.5rem;"></i>';
              echo '<span>Admin</span>';
              echo '</button>';
              echo '</a>';
              echo '</li>';
            }
            ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>