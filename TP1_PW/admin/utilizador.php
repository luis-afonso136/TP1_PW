<?php
# NOTA: O FORMULÁRIO UTILIZADOR ESTÁ SENDO USADO PARA CRIAÇÃO E ALTERAÇÃO DE UTILIZADORES
# PARA ISSO FUNCIONAR, EXISTE UM TRATAMENTO VIA GET/REQUEST ALTERANDO O VALOR DO BOTÃO DE NOME name="utilizador" 

# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES ACESSEM O SITIO
require_once __DIR__ . '/../back/middleware/middleware-administrador.php';

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = ' - Utilizador';
require_once __DIR__ . '/../aplicacao/templates/cabecalho.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
?>

<main class="container bg-light">
  <section class="py-4">
    <a href="/admin/"><button type="button" class="btn btn-secondary px-5">Voltar</button></a>
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
  <section class="pb-4">
    <form enctype="multipart/form-data" action="/back/controllers/admin/controlador-utilizador.php" method="post" class="form-control py-3">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-user-line"></i> Nome</span>
        <input type="text" class="form-control" name="nome" maxlength="100" size="100" value="<?= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-user-line"></i> Apelido</span>
        <input type="text" class="form-control" name="apelido" maxlength="100" size="100" value="<?= isset($_REQUEST['apelido']) ? $_REQUEST['apelido'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-id-card-line"></i></i> NIF</span>
        <input type="tel" class="form-control" name="nif" maxlength="9" size="9" value="<?= isset($_REQUEST['nif']) ? $_REQUEST['nif'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-phone-line"></i> Telemóvel</span>
        <input type="tel" class="form-control" name="telemovel" maxlength="9" value="<?= isset($_REQUEST['telemovel']) ? $_REQUEST['telemovel'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-mail-line"></i> E-mail</span>
        <input type="email" class="form-control" name="email" maxlength="255" value="<?= isset($_REQUEST['email']) ? $_REQUEST['email'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="ri-image-line"></i> Foto de Perfil</label>
        <input accept="image/*" type="file" class="form-control" id="inputGroupFile01" name="foto" />
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-lock-line"></i> Palavra Passe</span>
        <input type="password" class="form-control" name="palavra_passe" maxlength="255">
      </div>
      <div class="input-group mb-3">
        <div class="form-check form-switch mb-3">
          <input class="form-check-input" type="checkbox" name="administrador" role="switch" id="flexSwitchCheckChecked" <?= isset($_REQUEST['administrador']) && $_REQUEST['administrador'] == true ? 'checked' : null ?>>
          <label class="form-check-label" for="flexSwitchCheckChecked"><i class="ri-admin-line"></i> Administrador</label>
        </div>
      </div>
      <div class="d-grid col-4 mx-auto">
        <input type="hidden" name="id" value="<?= isset($_REQUEST['id']) ? $_REQUEST['id'] : null ?>">
        <input type="hidden" name="foto" value="<?= isset($_REQUEST['foto']) ? $_REQUEST['foto'] : null ?>">
        <button type="submit" class="btn btn-success" name="utilizador" <?= isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'atualizar' ? 'value="atualizar"' : 'value="criar"' ?>>Enviar</button>
      </div>
    </form>
  </section>
</main>
<?php
# CARREGA O RODAPE PADRÃO
require_once __DIR__ . '/../aplicacao/templates/rodape.php';
?>