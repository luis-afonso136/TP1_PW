<?php
# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES AUTENTICADOS ACESSEM ESTE SITIO
require_once __DIR__ . '/../back/middleware/middleware-utilizador.php';

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = ' - Perfil';
include_once __DIR__ . '/templates/cabecalho.php';

# ACESSA DE FUNÇÕES AUXILIADORAS. 
# NOTA: O SIMBOLO ARROBA SERVE PARA NÃO MOSTRAR MENSAGEM DE WARNING, POIS A FUNÇÃO ABAIXO TAMBÉM INICIA SESSÕES
@require_once __DIR__ . '/../back/auxiliadores/auxiliador.php';
$utilizador = utilizador();

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
?>

<body>
  <div class="pt-1 ">
    <main class="container mb-5">
      <section class="py-4">
        <h1>Perfil</h1>
        <div class="d-flex justify-content">
          <a href="/aplicacao/"><button type="button" class="btn btn-secondary px-5 me-2">Voltar</button></a>
          <a href="/aplicacao/palavra-passe.php"><button class="btn btn-warning px-2 me-2">Alterar Palavra Passe</button></a>
        </div>
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
      <section container="py-4">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3 text-center">
              <?php
              # Verifica se o utilizador tem uma foto de perfil
              $fotoPerfil = !empty($utilizador['foto']) ? $utilizador['foto'] : 'default.png';
              ?>
              <img src="/assets/uploads/<?= htmlspecialchars($fotoPerfil) ?>" class="img-thumbnail rounded-4 mt-5" alt="Foto de Perfil" width="300">
            </div>
          </div>
          <div class="col-md-6">
            <form enctype="multipart/form-data" action="/back/controllers/admin/controlador-utilizador.php" method="post" class="form-control py-3">
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="ri-user-line"></i> Nome</span>
                <input type="text" class="form-control" name="nome" placeholder="nome" maxlength="100" size="100" value="<?= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : $utilizador['nome'] ?>" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="ri-user-line"></i> Apelido</span>
                <input type="text" class="form-control" name="apelido" maxlength="100" size="100" value="<?= isset($_REQUEST['apelido']) ? $_REQUEST['apelido'] : $utilizador['apelido'] ?>" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="ri-id-card-line"></i> NIF</span>
                <input type="tel" class="form-control" name="nif" maxlength="9" size="9" value="<?= isset($_REQUEST['nif']) ? $_REQUEST['nif'] : $utilizador['nif'] ?>" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="ri-smartphone-line"></i> Telemóvel</span>
                <input type="tel" class="form-control" name="telemovel" maxlength="9" value="<?= isset($_REQUEST['telemovel']) ? $_REQUEST['telemovel'] : $utilizador['telemovel'] ?>" required>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="ri-mail-line"></i> Email</span>
                <input type="email" class="form-control" name="email" maxlength="255" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : $utilizador['email'] ?>" required>
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01"><i class="ri-image-line"></i> Foto de Perfil</label>
                <input accept="image/*" type="file" class="form-control" id="inputGroupFile01" name="foto" />
              </div>
              <div class="d-grid col-4 mx-auto">
                <button class="w-100 btn btn-lg btn-success mb-2" type="submit" name="utilizador" value="perfil">Alterar</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>
    <?php
    include_once __DIR__ . '/templates/rodape.php';
    ?>
  </div>
</body>