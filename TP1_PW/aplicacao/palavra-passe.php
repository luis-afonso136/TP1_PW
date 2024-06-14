<?php
# CARREGA MIDDLEWARE PAGARA GARANTIR QUE APENAS UTILIZADORES AUTENTICADOS ACESSEM ESTE SITIO
require_once __DIR__ . '/../back/middleware/middleware-utilizador.php';

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = ' - Alterar Palavra Passe';
include_once __DIR__ . '/templates/cabecalho.php';

# ACESSA DE FUNÇÕES AUXILIADORAS. 
# NOTA: O SIMBOLO ARROBA SERVE PARA NÃO MOSTRAR MENSAGEM DE WARNING, POIS A FUNÇÃO ABAIXO TAMBÉM INICIA SESSÕES
@include_once __DIR__ . '/../back/auxiliadores/auxiliador.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
# CARREGA O UTILIZADOR ATUAL. PROVENIENTE DE FUNÇÕES AUXILIADORAS ACIMA
$utilizador = utilizador();
?>

<body class="bg-light">
  <div class="pt-1 ">
    <main class="container mb-5" class="bg-light">
      <section class="py-4">
        <a href="/aplicacao/perfil.php"><button type="button" class="btn btn-secondary px-5">Voltar</button></a>
      </section>
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
      <section>
        <form action="/back/controllers/admin/controlador-utilizador.php" method="post" class="form-control py-3">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="ri-user-line"></i> Nome</span>
            <input type="text" readonly class="form-control" name="nome" placeholder="<?= $utilizador['nome'] ?>" value="<?= $utilizador['nome'] ?>">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="ri-lock-line"></i> Palavra Passe</span>
            <input type="password" class="form-control" name="palavra_passe" maxlength="255" size="255" required>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="ri-lock-line"></i> Confirme a Palavra Passe</span>
            <input type="password" class="form-control" name="confirmar_palavra_passe" maxlength="255" required>
          </div>
          <div class="d-grid col-4 mx-auto">
            <button class="w-100 btn btn-lg btn-success mb-2" type="submit" name="utilizador" value="palavra_passe">Alterar</button>
          </div>
        </form>
      </section>
    </main>
    <?php
    include_once __DIR__ . '/templates/rodape.php';
    ?>