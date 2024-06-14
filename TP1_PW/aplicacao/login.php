<?php
# MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES NÃO AUTENTICADOS VEJAM A PÁGINA DE LOGIN
require_once __DIR__ . '/../back/middleware/middleware-nao-autenticado.php';

# DEFINI O TÍTULO DA PÁGINA
$titulo = ' - Login';

include_once __DIR__ . '/templates/cabecalho.php';
require_once __DIR__ . '/templates/navbar.php';
?>

<section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">
        <div class="px-5 ms-xl-4">
          <img src="../assets/logo.jpg" class="img-fluid" alt="TechHouse logo" width="200px">
          <span class="h1 fw-bold mb-0">TechHouse</span>
        </div>

        <div class="p-2 col-md-8 col-lg-6 col-xl-8 offset-xl-1">
          <?php
          # MOSTRA AS MENSAGENS DE ERRO CASO LOGIN SEJA INVÁLIDO
          if (isset($_SESSION['erros'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '<ul class="mb-0">';
            foreach ($_SESSION['erros'] as $erro) {
              echo '<li>' . $erro . '</li>';
            }
            echo '</ul>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['erros']);
          }
          ?>
          <form action="/back/controllers/app/controlador-autenticacao.php" method="post">
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="Email">Email address</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" id="Email" class="form-control form-control-md" placeholder="Enter email address" maxlength="255" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>" />
              </div>
            </div>

            <div data-mdb-input-init class="form-outline mb-3">
              <label class="form-label" for="palavra_passe">Password</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
                <input type="password" class="form-control form-control-md" id="palavra_passe" placeholder="Password" name="palavra_passe" maxlength="255"/>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                  Remember me
                </label>
              </div>
              <a href="/aplicacao/palavra-passe.php" class="text-body">Forgot password?</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" type="submit" name="utilizador" value="login">Login</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="/aplicacao/registo.php" class="link-danger">Register</a></p>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="../assets/informatica.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>

<?php
include_once __DIR__ . '/templates/rodape.php';
?>