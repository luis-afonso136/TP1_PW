<?php
# INICIALIZA O REPOSITÓRIO
require_once __DIR__ . '/../back/basededados/repositorio-produtos.php';

# MIDDLEWARE PARA GARANTIR QUE APENAS ADMINISTRADORES ACESSEM ESTA PÁGINA
require_once __DIR__ . '/../back/middleware/middleware-administrador.php';

# FAZ O CARREGAMENTO DE TODOS OS PRODUTOS PARA MOSTRAR AO ADMINISTRADOR
$produtos = lerTodosProdutos();

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = ' - Painel de Administração';
require_once __DIR__ . '/../aplicacao/templates/cabecalho.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
?>

<main class="bg-light">
  <section class="py-5 m-5">
    <h1>Administrar Produtos</h1>
    <div class="d-flex justify-content">
      <a href="/aplicacao/administracao.php"><button class="btn btn-dark px-5">Back</button></a>
    </div>
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
      echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
      unset($_SESSION['erros']);
    }
    ?>
  </section>
  <section class="m-5">
    <div class="table-responsive">
      <table class="table">
        <thead class="table-secondary">
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Descrição</th>
            <th scope="col">Preço</th>
            <th scope="col">Quantidade</th>
            <th scope="col">Categoria</th>
            <th scope="col">Fornecedor</th>
            <th scope="col">Gerenciar</th>
          </tr>
        </thead>
        <tbody>
          <?php
          # VARRE TODOS OS PRODUTOS PARA CONSTRUÇÃO DA TABELA
          foreach ($produtos as $produto) {
          ?>
            <tr>
              <th scope="row"><?= $produto['nome'] ?></th>
              <td><?= $produto['descricao'] ?></td>
              <td><?= $produto['preco'] ?></td>
              <td><?= $produto['quantidade'] ?></td>
              <td><?= $produto['categoria'] ?></td>
              <td><?= $produto['fornecedor'] ?></td>
              <td>
                <div class="d-flex justify-content">
                  <a href="/back/controllers/admin/controlador-produto.php?<?= 'produto=atualizar&id=' . $produto['id'] ?>"><button type="button" class="btn btn-primary me-2">Atualizar</button></a>
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletar<?= $produto['id'] ?>">Eliminar</button>
                </div>
              </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="deletar<?= $produto['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Deletar Produto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Esta operação não poderá ser desfeita. Tem certeza que deseja deletar este produto?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <a href="/back/controllers/admin/controlador-produto.php?<?= 'produto=deletar&id=' . $produto['id'] ?>"><button type="button" class="btn btn-danger">Confirmar</button></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fim Modal -->
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
<?php
# CARREGA O RODAPE PADRÃO
require_once __DIR__ . '/../aplicacao/templates/rodape.php';
?>