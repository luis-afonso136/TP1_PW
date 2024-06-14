<?php
# CARREGA MIDDLEWARE PARA GARANTIR QUE APENAS UTILIZADORES AUTENTICADOS ACESSEM ESTE SITE
require_once __DIR__ . '/../back/middleware/middleware-utilizador.php';

# ACESSA FUNÇÕES AUXILIADORAS. 
# NOTA: O SÍMBOLO DE ARROBA SUPRIME MENSAGENS DE AVISO, POIS A FUNÇÃO ABAIXO TAMBÉM INICIA SESSÕES
@require_once __DIR__ . '/../back/auxiliadores/auxiliador.php';

# CARREGA O UTILIZADOR ATUAL
$utilizador = utilizador();

# CARREGA O CABEÇALHO PADRÃO COM O TÍTULO
$titulo = '- Aplicação';
include_once __DIR__ . '/templates/cabecalho.php';

require_once __DIR__ . '/../aplicacao/templates/navbar.php';
?>

<body>
    <main>
        <div class="container py-4">
            <div id="carouselExampleDark" class="carousel carousel-dark slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                </div>
                <div class="carousel-inner mb-3">
                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="/assets/negocios.jpg" class="d-block w-100 rounded-4" alt="...">
                        <div class="carousel-caption d-none d-md-block text-white">
                            <h1>Painel de Administração</h1>
                            <h5>Aqui vai poder administrar utilizadores e produtos.</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-3 mb-4 border-bottom">
                <a class="d-flex align-items-center text-dark text-decoration-none"></a>
            </div>
            <div class="d-flex justify-content">
                <a href="/aplicacao/"><button type="button" class="btn btn-secondary px-5 me-2">Voltar</button></a>
            </div>
            <div class="row justify-content-center mt-3">
                <?php
                # MOSTRA APENAS SE O UTILIZADOR FOR ADMINISTRADOR
                if (autenticado() && $utilizador['administrador']) {
                    echo '<div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body bg-dark border rounded-3 text-white p-5">
                                    <h2 class="card-title"><i class="ri-user-line"></i> Utilizadores</h2>
                                    <p class="card-text">Este painel é exclusivo para utilizadores registados e que tenham o perfil de administrador. Aqui podes criar, alterar, apagar, promover e despromover outros utilizadores a administradores do sistema.</p>
                                    <a href="/admin/" class="btn btn-outline-light me-2">Ver Utilizadores</a>
                                    <a href="/admin/utilizador.php" class="btn btn-outline-success">Criar Utilizador</a>
                                </div>
                            </div>
                        </div>';

                    echo '<div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body bg-dark border rounded-3 text-white p-5">
                                    <h2 class="card-title"><i class="ri-box-3-fill"></i> Produtos</h2>
                                    <p class="card-text">Este painel é exclusivo para utilizadores registados e que tenham o perfil de administrador. Aqui podes criar, alterar e apagar produtos da nossa base de dados.</p>
                                    <a href="/aplicacao/produtos.php" class="btn btn-outline-light me-2">Ver Produtos</a>
                                    <a href="/admin/produto.php" class="btn btn-outline-success">Criar Produto</a>
                                </div>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </main>
</body>
<?php
include_once __DIR__ . '/templates/rodape.php';
?>