<?php

/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DO LOGIN DE UM UTILIZADOR
 */
function validarLogin($reqisicao)
{
    # RETIRA ESPAÇOS VAZIOS
    foreach ($reqisicao as $key => $value) {
        $reqisicao[$key] =  trim($reqisicao[$key]);
    }

    # VALIDANDO O CAMPO EMAIL
    if (!filter_var($reqisicao['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'O campo Email não pode estar vazio e deve ter o formato de email, a exemplo de: nome@dominio.pt.';
    }

    # VALIDANDO O CAMPO PALAVRA PASSE
    if (empty($reqisicao['palavra_passe']) || strlen($reqisicao['palavra_passe']) < 6) {
        $erros['palavra_passe'] = 'O campo Palavra Passe não pode estar vazio e deve ter no mínio 6 caracteres.';
    }

    # RETORNA ERROS
    if (isset($erros)) {
        return ['invalido' => $erros];
    }

    # RETORNA UTILIZADOR VALIDADO
    return $reqisicao;
}

/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DA PALAVRA PASSE DE UM UTILIZADOR
 */
function validarPalavraPasse($reqisicao)
{
    if (!isset($_SESSION['id'])) {

        # RECUPERA DADOS DO UTILIZADOR
        $utilizador = lerUtilizadorPorEmail($reqisicao['email']);

        # VALIDANDO O CAMPO EMAIL
        if (!$utilizador) {
            $erros['email'] = 'Verifique seu email.';
        }

        if (!password_verify($reqisicao['palavra_passe'], $utilizador['palavra_passe'])) {
            $erros['palavra_passe'] = 'Verifique sua palavra passe.';
        }

        # RETORNA ERROS
        if (isset($erros)) {
            return ['invalido' => $erros];
        }

        # RETORNA UTILIZADOR VALIDADO
        return $utilizador;
    }
}
