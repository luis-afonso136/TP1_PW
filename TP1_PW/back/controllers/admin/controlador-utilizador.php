<?php

####################
### DEPENDÊNCIAS ###
####################
require_once __DIR__ . '/../../basededados/repositorio-utilizador.php';
require_once __DIR__ . '/../../validations/admin/validar-utilizador.php';
require_once __DIR__ . '/../../validations/admin/validar-palavra-passe.php';
require_once __DIR__ . '/../../auxiliadores/auxiliador.php';


##############
### VERBOS ###
##############

# VERBOS POST
## CONTROLA A ROTA PARA CRIAÇÃO E ATUALIZAÇÃO DE UM UTILIZADOR NA PÁGINA UTILIZADOR
if (isset($_POST['utilizador'])) {

    ## CONTROLA A CRIAÇÃO DE NOVOS UTILIZADORES
    if ($_POST['utilizador'] == 'criar') {

        # CRIA UM UTILIZADOR
        criar($_POST);
    }

    ## CONTROLA A ATUALIZAÇÃO DE DADOS DOS UTILIZADORES
    if ($_POST['utilizador'] == 'atualizar') {

        # ATUALIZA UM UTILIZADOR
        atualizar($_POST);
    }

    ## CONTROLA A ATUALIZAÇÃO DE DADOS DE PERFIL DOS UTILIZADORES (APLICAÇÃO)
    if ($_POST['utilizador'] == 'perfil') {

        # ATUALIZA UM UTILIZADOR
        atualizarPerfil($_POST);
    }

    ## CONTROLA A ATUALIZAÇÃO DA PALAVRA PASSE DE UTILIZADORES (APLICAÇÃO)
    if ($_POST['utilizador'] == 'palavra_passe') {

        # ATUALIZA UM UTILIZADOR
        alterarPalavraPasse($_POST);
    }
}

# VERBOS GET
## CONTROLA A ROTA PARA O CARREGAMENTO DE UM UTILIZADOR NA PÁGINA ATUALIZAR-UTILIZADOR
if (isset($_GET['utilizador'])) {

    ## CONTROLA A ROTA PARA A CRIAÇÃO DE NOVOS UTILIZADORES
    if ($_GET['utilizador'] == 'atualizar') {

        # RECUPERA DADOS DO UTILIZADOR PELO ID RECEBIDO
        $utilizador = lerUtilizador($_GET['id']);

        # CRIA A SESSÃO AÇÃO ATUALIZAR PARA MANIPULAR O BOTÃO DE ENVIO DO FORMULÁRIO UTILIZADOR
        # ESSA ESTRATÉGIA FOI EXPLICADO NO FICHEIRO UTILIZADOR.PHP
        $utilizador['acao'] = 'atualizar';

        # ENVIA PARÂMETROS COM DADOS DO UTILIZADOR PARA A PÁGINA UTILIZADOR RECUPERAR DADOS PARA MANIPULAR A ALTERAÇÃO
        $params = '?' . http_build_query($utilizador);

        header('location: /../admin/utilizador.php' . $params);
    }

    ## CONTROLA A ROTA PARA A EXCLUSÃO DE UTILIZADORES
    if ($_GET['utilizador'] == 'deletar') {

        # RECUPERA DADOS DO UTILIZADOR
        $utilizador = lerUtilizador($_GET['id']);

        # VALIDAÇÃO PARA NÃO PERMITIR DELETAR UTILIZADOR SE ELE FOR O DONO DO SISTEMA (SEGURANÇA)
        if ($utilizador['dono']) {

            # DEFINE MENSAGEM ESPECÍFICA DE ERRO E RETORNO PARA PAINEL DE ADM
            $_SESSION['erros'] = ['Este utilizador é proprietário do sistema e não pode ser apagado.'];

            # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
            header('location: /../admin');

            # RETORNA FALSO PARA EVITAR QUE PROGRAMA SIGA
            return false;
        }

        # DELETA UTILIZADOR
        $sucesso = deletar($utilizador);

        # REDIRECIONA UTILIZADOR PARA PÁGINA ADMIN COM MENSAGEM DE SUCCESO
        if ($sucesso) {
            # DEFINE MENSAGEM DE SUCESSO
            $_SESSION['sucesso'] = 'Utilizador deletado com sucesso!';

            # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
            header('location: /../admin/');
        }
    }
}

###############
### FUNÇÕES ###
###############

/**
 * FUNÇÃO RESPONSÁVEL POR CRIAR UM NOVO UTILIZADOR
 */
function criar($requisicao)
{
    # VALIDA DADOS DO UTILIZADOR. FICHEIRO VALIDAÇÃO->APLICAÇAO->ADMIN->VALIDAR-UTILIZADOR.PHP
    $dados = utilizadorValido($requisicao);

    # VERIFICA SE EXISTEM ERROS DE VALIDAÇÃO
    if (isset($dados['invalido'])) {

        # RECUPERA MENSAGEM DE ERRO, CASO EXISTA, E COLOCA EM SESSÃO PARA RECUPERANÃO NO FORMULARIO UTILIZADOR
        $_SESSION['erros'] = $dados['invalido'];

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($requisicao);

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /../admin/utilizador.php' . $params);

        return false;
    }

    # GARDA FOTO EM DIRETÓRIO LOCAL (FUNÇÃO LOCAL)
    $dados = guardaFoto($dados);

    # GUARDA UTILIZADOR NA BASE DE DADOS (REPOSITÓRIO PDO)
    $sucesso = criarUtilizador($dados);

    # REDIRECIONA UTILIZADOR PARA PÁGINA DE REGISTO COM MENSAGEM DE SUCCESO
    if ($sucesso) {

        # DEFINE MENSAGEM DE SUCESSO
        $_SESSION['sucesso'] = 'Utilizador criado com sucesso!';

        # REDIRECIONA O UTILIZADOR PARA A PÁGINA ADMIN
        header('location: /../admin/');
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR ATUALIZAR UM UTILIZADOR
 */
function atualizar($requisicao)
{
    # VALIDA DADOS DO UTILIZADOR
    $dados = utilizadorValido($requisicao);

    # VERIFICA SE EXISTEM ERROS DE VALIDAÇÃO
    if (isset($dados['invalido'])) {

        # RECUPERA MENSAGEM DE ERRO, CASO EXISTA
        $_SESSION['erros'] = $dados['invalido'];

        # CRIA A SESSÃO AÇÃO ATUALIZAR PARA MANIPULAR O BOTÃO DE ENVIO DO FORMULÁRIO UTILIZADOR
        $_SESSION['acao'] = 'atualizar';

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($requisicao);

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /../admin/index.php' . $params);

        return false;
    }

    # RECUPERA DADOS DO UTILIZADOR
    $utilizador = lerUtilizador($dados['id']);

    # VALIDAÇÃO PARA NÃO PERMITIR DELETAR UTILIZADOR SE ELE FOR O DONO DO SISTEMA
    if ($utilizador['dono'] && $dados['administrador'] == false) {

        # DEFINE MENSAGEM ESPECÍFICA DE ERRO E RETORNO PARA PAINEL DE ADM
        $_SESSION['erros'] = ['Este utilizador é proprietário do sistema e não pode deixar de ser administrador.'];

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /../admin/index.php');

        return false;
    }

    # GARDA FOTO EM DIRETÓRIO LOCAL E APAGA A FOTO ANTIGA ORIUNDA DA REQUISIÇÃO (FUNÇÃO LOCAL)
    if (!empty($_FILES['foto']['name'])) {
        $dados = guardaFoto($dados, $requisicao);
    }

    # ATUALIZA UTILIZADOR (REPOSITÓRIO PDO)
    $sucesso = atualizarUtilizador($dados);

    # REDIRECIONA UTILIZADOR PARA PÁGINA DE ALTERAÇÃO COM MENSAGEM DE SUCCESO
    if ($sucesso) {

        # DEFINE MENSAGEM DE SUCESSO
        $_SESSION['sucesso'] = 'Utilizador alterado com sucesso!';

        # DEFINI BOTÃO DE ENVIO DO FORMULÁRIO
        $dados['acao'] = 'atualizar';

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($dados);

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /index.php' . $params);
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR ATUALIZAR UM UTILIZADOR
 */
function atualizarPerfil($requisicao)
{
    # VALIDA DADOS DO UTILIZADOR (VALIDAÇÃO)
    $dados = utilizadorValido($requisicao);

    # VERIFICA SE EXISTEM ERROS DE VALIDAÇÃO
    if (isset($dados['invalido'])) {

        # RECUPERA MENSAGEM DE ERRO, CASO EXISTA
        $_SESSION['erros'] = $dados['invalido'];

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($requisicao);

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /../aplicacao/perfil.php' . $params);
    } else {

        # MEDIDA DE SEGURANÇA PARA GARANTIR QUE UTILIZADO SÓ MUDARÁ O PRÓPRIO PERFIL
        $utilizador = utilizador(); // RECUPERA UTILIZADOR LOGADO
        $dados['id'] = $utilizador['id']; // ATRIBUI O PRÓPRIO ID
        $dados['administrador'] = $utilizador['administrador']; // ATRIBUI O PAPEL ATUAL

        # GARDA FOTO EM DIRETÓRIO LOCAL E APAGA A FOTO ANTIGA ORIUNDA DA REQUISIÇÃO
        if (!empty($_FILES['foto']['name'])) {

            # GUARDA FOTOS EM DIRETÓRIO LOCAL
            $dados = guardaFoto($dados, $utilizador); // UTILIZADOR É PASSADO PARA PEPAR CAMINHO FOTO ANTIGA
        }

        # ATUALIZA UTILIZADOR
        $sucesso = atualizarUtilizador($dados);

        # REDIRECIONA UTILIZADOR PARA PÁGINA DE ALTERAÇÃO COM MENSAGEM DE SUCCESO
        if ($sucesso) {

            # DEFINE MENSAGEM DE SUCESSO
            $_SESSION['sucesso'] = 'Utilizador alterado com sucesso!';

            # DEFINI BOTÃO DE ENVIO DO FORMULÁRIO
            $_SESSION['acao'] = 'atualizar';

            # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
            $params = '?' . http_build_query($dados);

            # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
            header('location: /../aplicacao/perfil.php' . $params);
        }
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR ATUALIZAR A PALAVRA PASSE DO UTILIZADOR
 */
function alterarPalavraPasse($requisicao)
{
    # VALIDA DADOS DO UTILIZADOR
    $dados = palavraPasseValida($requisicao);

    # VERIFICA SE EXISTEM ERROS DE VALIDAÇÃO
    if (isset($dados['invalido'])) {

        # RECUPERA MENSAGEM DE ERRO, CASO EXISTA
        $_SESSION['erros'] = $dados['invalido'];

        # RECUPERA DADOS DO FORMULÁRIO PARA RECUPERAR PREENCHIMENTO ANTERIOR
        $params = '?' . http_build_query($requisicao);

        # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
        header('location: /../aplicacao/palavra-passe.php' . $params);
    } else {

        # MEDIDA DE SEGURANÇA PARA GARANTIR QUE UTILIZADO SÓ MUDARÁ O PRÓPRIO PERFIL
        $dados['id'] = utilizadorId();

        # ATUALIZA UTILIZADOR
        $sucesso = atualizarPalavraPasse($dados);

        # REDIRECIONA UTILIZADOR PARA PÁGINA DE ALTERAÇÃO COM MENSAGEM DE SUCCESO
        if ($sucesso) {

            # DEFINE MENSAGEM DE SUCESSO
            $_SESSION['sucesso'] = 'Palavra passe alterada com sucesso!';

            # REDIRECIONA UTILIZADOR COM DADOS DO FORMULÁRIO ANTERIORMENTE PREENCHIDO
            header('location: /../aplicacao/palavra-passe.php');
        }
    }
}

/**
 * FUNÇÃO RESPONSÁVEL POR DELETAR UM UTILIZADOR
 */
function deletar($utilizador)
{
    # DEFINE O CAMINHO DO FICHEIRO
    $caminhoFicheiro = __DIR__ . '/../../../assets/uploads/';

    # VALIDA DADOS DO UTILIZADOR
    $retorno = deletarUtilizador($utilizador['id']);

    # COMANDO PARA APAGAR O FICHEIRO
    unlink($caminhoFicheiro . $utilizador['foto']);

    # RETORNA RESULTADO DO BANCO DE DADOS
    return $retorno;
}

/**
 * FUNÇÃO RESPONSÁVEL POR GARDAR FICHEIROS DE FOTOS NO DIRETÓRIO
 */
function guardaFoto($dados, $fotoAntiga = null)
{
    # UTILIZA VARIÁVEL GLOBAL PARA PEGAR O NOME DO FICHEIRO
    $nomeFicheiro = $_FILES['foto']['name'];

    # PAGA O FICHEIRO TEMPORÁRIO
    $ficheiroTemporario = $_FILES['foto']['tmp_name'];

    # PEGA TIPO DE EXTENSÃO DA FOTO
    $extensao = pathinfo($nomeFicheiro, PATHINFO_EXTENSION);

    # CONVERTE A EXTENSÃO PARA MINÚSCULO
    $extensao = strtolower($extensao);

    # CRIA UM NOME ÚNICO PARA O FICHEIRO
    $novoNome = uniqid('foto_') . '.' . $extensao;

    # DEFINE O CAMINHO DO FICHEIRO
    $caminhoFicheiro = __DIR__ . '/../../../assets/uploads/';

    # DEFINE CAMINHO COMPLETO DO FICHEIRO
    $ficheiro = $caminhoFicheiro . $novoNome;

    # MOVE O FICHEIRO TEMPORÁRIO PARA O LOCAL DEFINITIVO
    if (move_uploaded_file($ficheiroTemporario, $ficheiro)) {

        # ATRIBUI NOME DO FICHEIRO NO ARRAY DE DADOS PARA ARMAZENAMENTO NA BASE DE DADOS
        $dados['foto'] = $novoNome;

        # APAGA FICHEIRO ANTERIOR, CASO SEJA UMA ATUALIZAÇÃO DE FOTO DE PERFIL
        if (isset($dados['utilizador']) && ($dados['utilizador'] == 'atualizar') || ($dados['utilizador'] == 'perfil')) {

            # COMANDO PARA APAGAR O FICHEIRO
            unlink($caminhoFicheiro . $fotoAntiga['foto']);
        }
    }

    # RETORNA OS DADOS DO FICHEIRO PARA GARDAR NA BASE DE DADOS
    return $dados;
}
