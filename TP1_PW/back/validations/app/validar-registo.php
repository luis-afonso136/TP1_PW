<?php

/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DE UM UTILIZADOR
 */
function validarRegisto($requisicao)
{
    # RETIRA ESPAÇOS VAZIOS
    foreach ($requisicao as $key => $value) {
        $requisicao[$key] =  trim($requisicao[$key]);
    }

    # VALIDANDO O CAMPO NOME
    if (empty($requisicao['nome']) || strlen($requisicao['nome']) < 3 || strlen($requisicao['nome']) > 255) {
        $erros['nome'] = 'O campo Nome não pode estar vazio e deve ter entre 3 e 255 caracteres.';
    }

    # VALIDANDO O CAMPO EMAIL
    if (!filter_var($requisicao['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'O campo Email não pode estar vazio e deve ter o formato de email, a exemplo de: nome@dominio.pt.';
    }

    # VALIDANDO O CAMPO EMAIL
    if (lerUtilizadorPorEmail($requisicao['email'])) {
        $erros['email'] = 'Email já registado em nosso sistema. Se não lembrar sua palavra passe, entre em contato conosco.';
        return ['invalido' => $erros];
    }
    # VALIDANDO O CAMPO PALAVRA PASSE
    if (empty($requisicao['palavra_passe']) && strlen($requisicao['palavra_passe']) < 6) {
        $erros['palavra_passe'] = 'O campo Palavra Passe não pode estar vazio e deve ter no mínio 6 caracteres.';
    }

    # VALIDANDO O CAMPOCONFIRMAR PALAVRA PASSE
    if ($requisicao['confirmar_palavra_passe'] != $requisicao['palavra_passe']) {
        $erros['confirmar_palavra_passe'] = 'O campo Confirmar Palavra Passe não pode estar vazio e deve ser igual ao campo Palavra Passe.';
    }

    # RETORNA ERROS
    if (isset($erros)) {
        return ['invalido' => $erros];
    }

    # RETORNA UTILIZADOR VALIDADO
    return $requisicao;
}
