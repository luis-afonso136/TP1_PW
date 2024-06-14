<?php
# MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES NÃO AUTENTICADOS VEJAM A PÁGINA DE REGISTO
require_once __DIR__ . '/../back/middleware/middleware-nao-autenticado.php';

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = '- Registro';
include_once __DIR__ . '/templates/cabecalho.php';

require_once __DIR__ . '/templates/navbar.php';
?>

<section class="vh-100">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register</p>
                <section>
                    <?php
                    # MOSTRA AS MENSAGENS DE SUCESSO E DE ERRO VINDA DO CONTROLADOR-UTILIZADOR
                    if (isset($_SESSION['sucesso'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo $_SESSION['sucesso'] . '<br>';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        unset($_SESSION['sucesso']);
                    }
                    if (isset($_SESSION['erros'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        foreach ($_SESSION['erros'] as $erro) {
                            echo $erro . '<br>';
                        }
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        unset($_SESSION['erros']);
                    }
                    ?>
                </section>
                <form class="mx-1 mx-md-4" action="/back/controllers/app/controlador-registo.php" method="post">
                    <div class="mb-4">
                        <label class="form-label" for="form3Example1c">Name</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                            <input type="text" id="form3Example1c" class="form-control" name="nome" placeholder="Name" maxlength="100" size="100" value="<?= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : null ?>" required />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="form3Example3c">Email address</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="form3Example3c" class="form-control" name="email" placeholder="Email address" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>" required />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="form3Example4c">Password</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3"><i class="fas fa-lock"></i></span>
                            <input type="password" id="form3Example4c" class="form-control" name="palavra_passe" placeholder="Password" required />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="form3Example4cd">Repeat your password</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon4"><i class="fas fa-key"></i></span>
                            <input type="password" id="form3Example4cd" class="form-control" name="confirmar_palavra_passe" placeholder="Repeat your password" required />
                        </div>
                    </div>
                    <div class="form-check d-flex justify-content-center mb-5">
                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                        <label class="form-check-label" for="form2Example3c">
                            I agree all statements in <a href="#!">Terms of service</a>
                        </label>
                    </div>
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                        <button type="submit" name="utilizador" value="registo" class="btn btn-primary btn-lg">Register</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<?php
include_once __DIR__ . '/templates/rodape.php';
?>