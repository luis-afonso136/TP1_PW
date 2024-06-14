<?php
session_start();

####################
### DEPENDÊNCIAS ###
####################
require_once __DIR__ . '/../../basededados/repositorio-utilizador.php';
require_once __DIR__ . '/../../validations/app/validar-login-senha.php';


##############
### VERBOS ###
##############

# VERBOS POST
## CONTROLA A ROTA PARA A CRIAÇÃO E ATUALIZAÇÃO DE UM UTILIZADOR NA PÁGINA UTILIZADOR
if (isset($_POST['utilizador'])) {

    ## CONTROLA A ROTA PARA O LOGIN DE UTILIZADORES
    if ($_POST['utilizador'] == 'login') {

        # CRIA UM UTILIZADOR
        login($_POST);
    }

    ## CONTROLA A ROTA PARA O LOGOUT DE UTILIZADORES
    if ($_POST['utilizador'] == 'logout') {

        # CRIA UM UTILIZADOR
        logout();
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR FAZER O LOGIN DE UM UTILIZADOR
 */
function login($requisicao)
{
    # VALIDA DADOS DO UTILIZADOR (VALIDAÇÃO)
    $dados = validarLogin($requisicao);

    # VERIFICA SE EXISTEM ERROS DE VALIDAÇÃO
    $valido = verificaErros($dados, $requisicao);

    if ($valido) {
        # VALIDA PALAVRA PASSE DO UTILIZADOR
        $dados = validarPalavraPasse($dados);
    }

    # VERIFICA SE EXISTEM ERROS DE AUTENTICAÇÃO
    $utilizador = verificaErros($dados, $requisicao);

    if ($utilizador) {
        fazerLogin($dados);
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR VERIFICAR ERROS E RETORNAR MENSAGEM AMIGÁVEL PARA INTERNAUTA
 * NOTA: REFATORANDO CÓDIGO -> REAPROVEITAMENTO.
 */
function verificaErros($dados, $requisicao)
{

    if (isset($dados['invalido'])) {

        # RECUPERA MENSAGEM DE ERRO, CASO EXISTA, PARA ENVIAR VIA SESSÃO PARA FORMULÁRIO DE LOGIN
        $_SESSION['erros'] = $dados['invalido'];

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($requisicao);

        # REDIRECIONA UTILIZADOR PARA FORMULÁRIO DE LOGIN INFORMANDO ERROS
        header('location: /../aplicacao/login.php' . $params);

        return false;
    }

    # LIMPA A SESSÃO DE ERROS
    unset($_SESSION['erros']);

    # RETORNA VERDADEIRO, OU SEJA, NÃO EXISTEM ERROS
    return true;
}

/**
 * FUNÇÃ PARA SIMULAR LOGIN DE UTILIZADOR.
 */
function fazerLogin($dados)
{
    # FAZ O LOGIN DO UTILIZADOR
    $_SESSION['id'] = $dados['id'];
    $_SESSION['nome'] = $dados['nome'];

    // 30 Dias = Data atual + 60 minutos * 60 segundos * 24 horas * 30 dias
    setcookie("id", $dados['id'], time() + (60 * 60 * 24 * 30), "/");
    setcookie("nome", $dados['nome'], time() + (60 * 60 * 24 * 30), "/");

    # REDIRECIONA PARA A PÁGINA APLICAÇÃO
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aplicacao/';
    header('Location: ' . $home_url);
}

/**
 * FUNÇÃO PARA REALIZAR DESLOGAR UM UTILIZADOR
 */
function logout()
{
    # VERIFICA SE EXISTE SESSÃO ATIVA PARA O UTILIZADOR ATUAL
    if (isset($_SESSION['id'])) {

        # APAGA TODAS AS SESSÕES ATIVAS
        $_SESSION = array();

        # VERIFICA SE EXISTEM COOKIES PARA SEREM RECUPERADOS PELA SESSÃO
        if (isset($_COOKIE[session_name()])) {

            # APAGA TODOS OS COOKIES
            setcookie(session_name(), '', time() - 3600);
        }

        # DESTROI A SESSÃO
        session_destroy();
    }

    // REFORÇA A GARANTIA DE APGAR COOKIES UTILIZADOS NO SISTEMA
    setcookie('id', '', time() - 3600, "/");
    setcookie('nome', '', time() - 3600, "/");

    # REDIRECIONA UTILIZADOR PARA A PÁGINA PRINCIPAL APÓS O LOGOUT
    $home_url = 'http://' . $_SERVER['HTTP_HOST'];
    header('Location: ' . $home_url);
}
