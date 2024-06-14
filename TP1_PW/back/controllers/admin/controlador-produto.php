<?php

# Dependências
require_once __DIR__ . '/../../basededados/repositorio-produtos.php';
require_once __DIR__ . '/../../validations/admin/validar-produto.php';
require_once __DIR__ . '/../../auxiliadores/auxiliador.php';

# Verificação da sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Verbos POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['produto'])) {

    # Criação de produto
    if ($_POST['produto'] == 'criar') {

        # Cria um produto
        criarProduto($_POST);
    }

    # Atualização de produto
    if ($_POST['produto'] == 'atualizar') {

        # Atualiza um produto
        atualizarProduto($_POST);
    }
}

# Verbos GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['produto'])) {

    # Atualização de produto
    if ($_GET['produto'] == 'atualizar') {

        # Lê o produto pelo ID
        $produto = lerProduto($_GET['id']);

        # Define a ação como atualizar
        $produto['acao'] = 'atualizar';

        # Parâmetros
        $params = '?' . http_build_query($produto);

        # Redirecionamento para página de produto
        header('location: /../admin/produto.php' . $params);
    }

    # Deleção de produto
    if ($_GET['produto'] == 'deletar') {

        # Lê o produto pelo ID
        $produto = lerProduto($_GET['id']);

        # Deleta o produto
        $sucesso = deletarProduto($produto);

        # Redireciona para página admin com mensagem de sucesso
        if ($sucesso) {

            # Define mensagem de sucesso
            $_SESSION['sucesso'] = 'Produto deletado com sucesso!';

            # Redireciona para página dos produtos
            header('location: /../aplicacao/produtos.php');
        }
    }
}

# Função para criar um produto
function criarProduto($requisicao)
{

    # Valida o produto
    $dados = produtoValido($requisicao);

    # Verifica se há erros de validação
    if (isset($dados['invalido'])) {

        # Define os erros em sessão
        $_SESSION['erros'] = $dados['invalido'];

        # Parâmetros
        $params = '?' . http_build_query($requisicao);

        # Redirecionamento para página de produto
        header('location: /../admin/produto.php' . $params);
        return false;
    }

    # Guarda a imagem
    $dados = guardaImagem($dados);

    # Insere o produto
    $sucesso = inserirProduto($dados);

    # Redireciona para página admin com mensagem de sucesso
    if ($sucesso) {
        $_SESSION['sucesso'] = 'Produto criado com sucesso!';
        header('location: /../aplicacao/produtos.php');
    }
}

# Função para atualizar um produto no banco de dados
function atualizarProduto($requisicao)
{

    # Valida o produto
    $dados = produtoValido($requisicao);

    # Verifica se há erros de validação
    if (isset($dados['invalido'])) {

        # Define os erros em sessão
        $_SESSION['erros'] = $dados['invalido'];
        $_SESSION['acao'] = 'atualizar';

        # Parâmetros
        $params = '?' . http_build_query($requisicao);

        # Redirecionamento para página de produto
        header('location: /../aplicacao/produtos.php' . $params);
        return false;
    }

    # Lê o produto
    $produto = lerProduto($dados['id']);

    # Se houver upload de uma nova imagem, guarda a nova imagem
    if (!empty($_FILES['imagem']['name'])) {
        $dados = guardaImagem($dados, $produto);
    }

    # Atualiza o produto
    $sucesso = atualizarProdutoBD($dados);

    # Redireciona para página de produto com mensagem de sucesso
    if ($sucesso) {
        $_SESSION['sucesso'] = 'Produto alterado com sucesso!';
        $dados['acao'] = 'atualizar';
        $params = '?' . http_build_query($dados);
        header('location: /../admin/produto.php' . $params);
    }
}

# Função para deletar um produto
function deletarProduto($produto)
{
    $caminhoFicheiro = __DIR__ . '/../../../assets/uploads/';

    # Chame a função do repositório para deletar o produto pelo ID
    $retorno = deletarProdutoBD($produto['id']);

    # Verifique se a eliminação do produto foi bem-sucedida antes de tentar excluir o arquivo de imagem
    if ($retorno && $produto['imagem']) {
        unlink($caminhoFicheiro . $produto['imagem']);
    }

    return $retorno;
}

# Função para guardar uma imagem
function guardaImagem($dados, $imagemAntiga = null)
{
    # Verifica se a imagem foi enviada
    if (isset($_FILES['imagem']) && is_array($_FILES['imagem'])) {
        $nomeFicheiro = $_FILES['imagem']['name'];
        $ficheiroTemporario = $_FILES['imagem']['tmp_name'];
        $extensao = pathinfo($nomeFicheiro, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);
        $novoNome = uniqid('produto_') . '.' . $extensao;
        $caminhoFicheiro = __DIR__ . '/../../../assets/uploads/';
        $ficheiro = $caminhoFicheiro . $novoNome;

        if (move_uploaded_file($ficheiroTemporario, $ficheiro)) {
            $dados['imagem'] = $novoNome;
            if (isset($dados['id']) && $imagemAntiga) {
                unlink($caminhoFicheiro . $imagemAntiga['imagem']);
            }
        }
    }

    return $dados;
}
