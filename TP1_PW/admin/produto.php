<?php
# NOTA: O FORMULÁRIO PRODUTO ESTÁ SENDO USADO PARA CRIAÇÃO E ALTERAÇÃO DE PRODUTOS
# PARA ISSO FUNCIONAR, EXISTE UM TRATAMENTO VIA GET/REQUEST ALTERANDO O VALOR DO BOTÃO DE NOME name="produto"

# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS ADMINISTRADORES ACESSEM O SITE
require_once __DIR__ . '/../back/middleware/middleware-administrador.php';

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = ' - Produto';
require_once __DIR__ . '/../aplicacao/templates/cabecalho.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
?>

<main class="container" class="bg-light">
  <section class="py-4">
    <a href="/aplicacao/produtos.php"><button type="button" class="btn btn-secondary px-5">Voltar</button></a>
  </section>
  <section>
    <?php
    # MOSTRA AS MENSAGENS DE SUCESSO E DE ERRO VINDA DO CONTROLADOR-PRODUTO
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
    <form enctype="multipart/form-data" action="/back/controllers/admin/controlador-produto.php" method="POST" class="form-control py-3">
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-price-tag-3-line"></i> Nome</span>
        <input type="text" class="form-control" name="nome" maxlength="100" size="100" value="<?= isset($_REQUEST['nome']) ? $_REQUEST['nome'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-file-text-line"></i> Descrição</span>
        <input type="text" class="form-control" name="descricao" maxlength="255" size="255" value="<?= isset($_REQUEST['descricao']) ? $_REQUEST['descricao'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-money-euro-circle-line"></i> Preço</span>
        <input type="number" class="form-control" name="preco" step="0.01" value="<?= isset($_REQUEST['preco']) ? $_REQUEST['preco'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-inbox-line"></i> Quantidade</span>
        <input type="number" class="form-control" name="quantidade" value="<?= isset($_REQUEST['quantidade']) ? $_REQUEST['quantidade'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-grid-line"></i> Categoria</span>
        <input type="text" class="form-control" name="categoria" maxlength="100" size="100" value="<?= isset($_REQUEST['categoria']) ? $_REQUEST['categoria'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="ri-truck-line"></i> Fornecedor</span>
        <input type="text" class="form-control" name="fornecedor" maxlength="100" size="100" value="<?= isset($_REQUEST['fornecedor']) ? $_REQUEST['fornecedor'] : null ?>" required>
      </div>
      <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="ri-image-line"></i> Imagem do Produto</label>
        <input accept="image/*" type="file" class="form-control" id="inputGroupFile01" name="imagem" />
      </div>
      <div class="d-grid col-4 mx-auto">
        <input type="hidden" name="id" value="<?= isset($_REQUEST['id']) ? $_REQUEST['id'] : null ?>">
        <input type="hidden" name="imagem" value="<?= isset($_REQUEST['imagem']) ? $_REQUEST['imagem'] : null ?>">
        <button type="submit" class="btn btn-success" name="produto" <?= isset($_REQUEST['acao']) && $_REQUEST['acao'] == 'atualizar' ? 'value="atualizar"' : 'value="criar"' ?>>Enviar</button>
      </div>
    </form>
  </section>
</main>
<?php
# CARREGA O RODAPE PADRÃO
require_once __DIR__ . '/../aplicacao/templates/rodape.php';
?>