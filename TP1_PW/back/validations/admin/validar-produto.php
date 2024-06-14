<?php

/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DE UM PRODUTO
 */
function produtoValido($requisicao)
{
    # RETIRA ESPAÇOS VAZIOS
    foreach ($requisicao as $key => $value) {
        $requisicao[$key] = trim($requisicao[$key]);
    }

    # ARRAY PARA ARMAZENAR ERROS DE VALIDAÇÃO
    $erros = [];

    # VALIDANDO O CAMPO NOME
    if (empty($requisicao['nome']) || strlen($requisicao['nome']) < 3 || strlen($requisicao['nome']) > 255) {
        $erros['nome'] = 'O campo Nome não pode estar vazio e deve ter entre 3 e 255 caracteres.';
    }

    # VALIDANDO O CAMPO DESCRIÇÃO
    if (empty($requisicao['descricao']) || strlen($requisicao['descricao']) < 3 || strlen($requisicao['descricao']) > 255) {
        $erros['descricao'] = 'O campo Descrição não pode estar vazio e deve ter entre 3 e 255 caracteres.';
    }

    # VALIDANDO O CAMPO PREÇO
    if (!is_numeric($requisicao['preco']) || $requisicao['preco'] <= 0) {
        $erros['preco'] = 'O campo Preço deve ser um número maior que zero.';
    }

    # VALIDANDO O CAMPO QUANTIDADE
    if (!is_numeric($requisicao['quantidade']) || $requisicao['quantidade'] <= 0) {
        $erros['quantidade'] = 'O campo Quantidade deve ser um número maior que zero.';
    }

    # VALIDANDO O CAMPO CATEGORIA
    if (empty($requisicao['categoria']) || strlen($requisicao['categoria']) < 3 || strlen($requisicao['categoria']) > 100) {
        $erros['categoria'] = 'O campo Categoria não pode estar vazio e deve ter entre 3 e 100 caracteres.';
    }

    # VALIDANDO O CAMPO FORNECEDOR
    if (empty($requisicao['fornecedor']) || strlen($requisicao['fornecedor']) < 3 || strlen($requisicao['fornecedor']) > 100) {
        $erros['fornecedor'] = 'O campo Fornecedor não pode estar vazio e deve ter entre 3 e 100 caracteres.';
    }

    # RETORNA ERROS SE HOUVER
    if (!empty($erros)) {
        return ['invalido' => $erros];
    }

    # RETORNA OS DADOS DO PRODUTO VALIDADOS, INCLUINDO O ARQUIVO DE IMAGEM
    return $requisicao;
}
