<?php
# INSERE DADOS DA CONEXÃO COM O PDO
require_once __DIR__ . '/criar-conexao.php';

/**
 * FUNÇÃO RESPONSÁVEL POR CRIAR UM NOVO PRODUTO
 */
function inserirProduto($produto)
{
    # INSERE PRODUTO COM PROTEÇÃO CONTRA SQLINJECTION
    $sqlCreate = "INSERT INTO 
    produtos (
        nome, 
        descricao, 
        preco, 
        quantidade,  
        categoria, 
        fornecedor,
        imagem) 
    VALUES (
        :nome, 
        :descricao, 
        :preco, 
        :quantidade, 
        :categoria, 
        :fornecedor,
        :imagem
    )";

    # PREPARA A QUERY
    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    # EXECUTA A QUERY RETORNANDO VERDADEIRO SE CRIAÇÃO FOI FEITA
    $sucesso = $PDOStatement->execute([
        ':nome' => $produto['nome'],
        ':descricao' => $produto['descricao'],
        ':preco' => $produto['preco'],
        ':quantidade' => $produto['quantidade'],
        ':categoria' => $produto['categoria'],
        ':fornecedor' => $produto['fornecedor'],
        ':imagem' => $produto['imagem']
    ]);

    # RECUPERA ID DO PRODUTO CRIADO
    if ($sucesso) {
        $produto['id'] = $GLOBALS['pdo']->lastInsertId();
    }
    # RETORNO RESULTADO DA INSERSÃO 
    return $sucesso;
}

/**
 * FUNÇÃO RESPONSÁVEL POR LER UM PRODUTO
 */
function lerProduto($id)
{
    # PREPARA A QUERY
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM produtos WHERE id = ?;');

    # FAZ O BIND
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);

    # EXECUTA A CONSULTA
    $PDOStatement->execute();

    # RETORNA OS DADOS
    return $PDOStatement->fetch();
}

/**
 * FUNÇÃO RESPONSÁVEL POR LER UM PRODUTO PELO NOME
 */
function lerProdutoPorNome($nome)
{
    # PREPARA A QUERY
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM produtos WHERE nome = ? LIMIT 1;');

    # FAZ O BIND
    $PDOStatement->bindValue(1, $nome);

    # EXECUTA A CONSULTA
    $PDOStatement->execute();

    # RETORNA OS DADOS
    return $PDOStatement->fetch();
}

/**
 * FUNÇÃO RESPONSÁVEL POR RETORNAR TODOS OS PRODUTOS
 */
function lerTodosProdutos()
{
    # PREPARA A QUERY
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM produtos;');

    # INICIA ARRAY DE PRODUTOS
    $produtos = [];

    # PERCORRE TODAS AS LINHAS TRAZENDO OS DADOS
    while ($listaDeProdutos = $PDOStatement->fetch()) {
        $produtos[] = $listaDeProdutos;
    }

    # RETORNA PRODUTOS
    return $produtos;
}

/**
 * FUNÇÃO RESPONSÁVEL POR ATUALIZAR OS DADOS DE UM PRODUTO NA BASE DE DADOS
 */
function atualizarProdutoBD($produto)
{
    # INSERE PRODUTO COM PROTEÇÃO CONTRA SQLINJECTION
    $sqlUpdate = "UPDATE  
    produtos SET
        nome = :nome, 
        descricao = :descricao, 
        preco = :preco, 
        quantidade = :quantidade, 
        categoria = :categoria, 
        fornecedor = :fornecedor,
        imagem = :imagem
    WHERE id = :id;";

    # PREPARA A CONSULTA
    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    # EXECUTA A QUERY RETORNANDO VERDADEIRO SE A ATUALIZAÇÃO FOI FEITA
    return $PDOStatement->execute([
        ':id' => $produto['id'],
        ':nome' => $produto['nome'],
        ':descricao' => $produto['descricao'],
        ':preco' => $produto['preco'],
        ':quantidade' => $produto['quantidade'],
        ':categoria' => $produto['categoria'],
        ':fornecedor' => $produto['fornecedor'],
        ':imagem' => $produto['imagem']
    ]);
}

/**
 * FUNÇÃO RESPONSÁVEL POR DELETAR UM PRODUTO DO BANCO DE DADOS
 */
function deletarProdutoBD($id)
{
    # PREPARA A CONSULTA
    $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM produtos WHERE id = ?;');

    # REALIZA O BIND
    $PDOStatement->bindValue(1, $id, PDO::PARAM_INT);

    # EXECUTA A CONSULTA E RETORNA OS DADOS
    return $PDOStatement->execute();
}
