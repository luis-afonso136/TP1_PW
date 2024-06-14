<?php
# FUNÇÕES AUXILIADORAS
require_once __DIR__ . '/back/middleware/middleware-nao-autenticado.php';

require_once __DIR__ . '/aplicacao/templates/navbar.php';

# INICIA CABECALHO
include_once __DIR__ . '/aplicacao/templates/cabecalho.php';
?>
<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/assets/C2.avif" class="d-block w-100" height="450">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="titulo mt-5 mb-5">TechHouse</h1>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/assets/C1.jpg" class="d-block w-100" height="450">
    </div>
    <div class="carousel-item">
      <img src="/assets/C3.jpg" class="d-block w-100" height="450">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<body>
  <main>
    <div class="container py-4">
      <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Bem vindo!</h1>
          <p class="col-md-8 fs-4">
            Este WebSite é um sistema de gestão de uma loja de informática que permite gerenciar produtos e 
            utilizadores de maneira eficiente. O sistema também é responsivo, facilitando o 
            utilizador a ver o webSite em outro tipo de telas. Ele inclui funcionalidades para registro e login, 
            controlar o stock de produtos, preços e outras funcionalidades. 
          </p>
        </div>
      </div>
    </div>
  </main>
</body>

<?php
# CARREGA O RODAPE PADRÃO
require_once __DIR__ . '/aplicacao/templates/rodape.php';
?>