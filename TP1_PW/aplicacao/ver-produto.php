<?php
# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES AUTENTICADOS ACESSEM ESTE SITIO
require_once __DIR__ . '/../back/middleware/middleware-utilizador.php';

# ACESSA FUNÇÕES AUXILIADORAS. 
# NOTA: O SIMBOLO ARROBA SERVE PARA NÃO MOSTRAR MENSAGEM DE WARNING, POIS A FUNÇÃO ABAIXO TAMBÉM INICIA SESSÕES
@require_once __DIR__ . '/../back/auxiliadores/auxiliador.php';

# PROVENIENTE DE FUNÇÕES AUXILIADORAS. CARREGA O UTILIZADOR ATUAL
$utilizador = utilizador();

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = '- Detalhes do Produto';
include_once __DIR__ . '/templates/cabecalho.php';

require_once __DIR__ . '/../back/basededados/repositorio-produtos.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';

# RECUPERA O ID DO PRODUTO DA QUERY STRING
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

# VERIFICA SE O ID É VÁLIDO E RECUPERA O PRODUTO
if ($id > 0) {
    $produto = lerProduto($id);
}

# SE O PRODUTO NÃO FOR ENCONTRADO, REDIRECIONA PARA A PÁGINA DE PRODUTOS
if (!$produto) {
    $_SESSION['erro'] = 'Produto não encontrado!';
    header('Location: /aplicacao/produtos.php');
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="stylesheet" href="/TP1_PW/web/styles/index.css">
</head>

<body>
    <main>
        <div class="container py-4">
            <div class=" mb-4 bg-body rounded-3">
                <div class="container-fluid py-5 mb-5">
                    <h1 class="display-5 fw-bold"><?= htmlspecialchars($produto['nome']) ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 px-3">
                    <?php if (!empty($produto['imagem'])) : ?>
                        <img src="/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="img-fluid img-produto" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <?php else : ?>
                        <img src="/assets/uploads/default.png" class="img-fluid img-produto" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-5">
                    <p><strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao']) ?></p>
                    <p><strong>Preço:</strong> €<?= number_format($produto['preco'], 2) ?></p>
                    <p><strong>Quantidade Em Stock:</strong> <?= htmlspecialchars($produto['quantidade']) ?></p>
                    <p><strong>Categoria:</strong> <?= htmlspecialchars($produto['categoria']) ?></p>
                    <p><strong>Fornecedor:</strong> <?= htmlspecialchars($produto['fornecedor']) ?></p>
                    <a href="/aplicacao/index.php" class="btn btn-dark px-5">Voltar</a>
                </div>
            </div>
        </div>
    </main>
</body>
<?php
include_once __DIR__ . '/templates/rodape.php';
?>