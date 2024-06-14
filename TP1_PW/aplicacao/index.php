<?php
# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES AUTENTICADOS ACESSEM ESTE SITIO
require_once __DIR__ . '/../back/middleware/middleware-utilizador.php';

# ACESSA FUNÇÕES AUXILIADORAS. 
# NOTA: O SIMBOLO ARROBA SERVE PARA NÃO MOSTRAR MENSAGEM DE WARNING, POIS A FUNÇÃO ABAIXO TAMBÉM INICIA SESSÕES
@require_once __DIR__ . '/../back/auxiliadores/auxiliador.php';

# PROVENIENTE DE FUNÇÕES AUXILIADORAS. CARREGA O UTILIZADOR ATUAL
$utilizador = utilizador();

# CARREGA O CABECALHO PADRÃO COM O TÍTULO
$titulo = '- Aplicação';
include_once __DIR__ . '/templates/cabecalho.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
require_once __DIR__ . '/../back/basededados/repositorio-produtos.php';

# RECUPERA TODOS OS PRODUTOS
$produtos = lerTodosProdutos();
?>

<body>
    <main>
        <div class="container py-4">
            <div class="p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Olá <?= ($utilizador['nome'] ?? '') ?> <?= ($utilizador['apelido']) ?>!</h1>
                    <p class="col-md-8 fs-4">Agora que está logado no sistema, você tem acesso a informações exclusivas.</p>
                </div>
            </div>
            <div class="pb-3 mb-4 border-bottom">
                <h1 class="text-center">Produtos</h1>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4" id="productContainer">
                <?php foreach ($produtos as $produto) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <?php if (!empty($produto['imagem'])) : ?>
                                <img src="/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <?php else : ?>
                                <img src="/assets/uploads/default.png" class="card-img-top" alt="<?= htmlspecialchars($produto['nome']) ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produto['descricao']) ?></p>
                                <p class="card-text"><strong>Preço:</strong> €<?= number_format($produto['preco'], 2) ?></p>
                                <a href="/aplicacao/ver-produto.php?id=<?= htmlspecialchars($produto['id']) ?>" class="btn btn-dark">Ver mais</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>

<?php
include_once __DIR__ . '/templates/rodape.php';
?>