<?php

/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DE UM UTILIZADOR
 */
function utilizadorValido($requisicao)
{
    # RETIRA ESPAÇOS VAZIOS
    foreach ($requisicao as $key => $value) {
        $requisicao[$key] =  trim($requisicao[$key]);
    }

    # VALIDANDO O CAMPO NOME
    if (empty($requisicao['nome']) || strlen($requisicao['nome']) < 3 || strlen($requisicao['nome']) > 255) {
        $erros['nome'] = 'O campo Nome não pode estar vazio e deve ter entre 3 e 255 caracteres.';
    }

    # VALIDANDO O CAMPO APELIDO
    if (empty($requisicao['apelido']) || strlen($requisicao['apelido']) < 3 || strlen($requisicao['apelido']) > 255) {
        $erros['apelido'] = 'O campo Apelido não pode estar vazio e deve ter entre 3 e 255 caracteres.';
    }

    # VALIDANDO O CAMPO NIF
    if (!filter_var($requisicao['nif'], FILTER_VALIDATE_INT) || strlen($requisicao['nif']) != 9) {
        $erros['nif'] = 'O campo NIF não pode estar vazio e deve ter 9 números.';
    }

    # VALIDANDO O CAMPO TELEMÓVEL
    if (!filter_var($requisicao['telemovel'], FILTER_VALIDATE_INT) || strlen($requisicao['telemovel']) != 9) {
        $erros['telemovel'] = 'O campo Telemóvel não pode estar vazio e deve ter 9 números.';
    }

    # VALIDANDO O CAMPO EMAIL
    if (!filter_var($requisicao['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = 'O campo Email não pode estar vazio e deve ter o formato de email, a exemplo de: nome@dominio.pt.';
    }

    # VALIDANDO FOTO DE PERFIL
    if (isset(($_FILES['foto']['name'])) && ($_FILES['foto']['error'] == UPLOAD_ERR_OK)) {

        # DEFINE A LARGURA MÁXIMA DO FICHEIRO
        $largura = 1024;

        # DEFINE A ALTURA MÁXIMA DO FICHEIRO
        $altura = 1024;

        # DEFINE O TAMANHO MÁXIMO DO FICHEIRO EM PIXEL
        $tamanho = 1000000;

        # PEGA AS DIMENSÕES DO FICHEIRO
        $dimensoes = getimagesize($_FILES['foto']["tmp_name"]);

        # VERIFICA SE O FICHEIRO É UMA IMAGEM
        if (!preg_match("/^image\/(pjpeg|jpeg|png|gif)$/", ($_FILES['foto']['type']))) {
            $erros['foto_formato']  = 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"';
        }

        # VERIFICA SE A LARGURA DA IMAGEM É MAIOR QUE A DEFINIDA
        if ($dimensoes[0] > $largura) {
            $erros['foto_largura'] = "A largura da foto não deve ultrapassar " . $largura . " pixels";
        }

        # VERIFICA SE A ALTURA DA IMAGEM É MAIOR QUE A ALTURA PERMITIDA
        if ($dimensoes[1] > $altura) {
            $erros['foto_altura'] = "A altura da foto não deve ultrapassar " . $altura . " pixels";
        }

        # VERIFICA SE O TAMANHO DA IMAGEM É MAIOR QUE O TAMANHO EM PIXEL PERMITIDO
        if ($_FILES['foto']["size"] > $tamanho) {
            $erros['foto_bytes'] = "A foto deve ter no máximo 1 Mb";
        }
    }

    # VALIDANDO O CAMPO PALAVRA PASSE
    if (!empty($requisicao['palavra_passe']) && strlen($requisicao['palavra_passe']) < 6) {
        $erros['palavra_passe'] = 'O campo Palavra Passe não pode estar vazio e deve ter no mínio 6 caracteres.';
    }

    # VALIDANDO O CAMPOCONFIRMAR PALAVRA PASSE
    if (!empty($requisicao['confirmar_palavra_passe']) && ($requisicao['confirmar_palavra_passe']) != $requisicao['palavra_passe']) {
        $erros['confirmar_palavra_passe'] = 'O campo Confirmar Palavra Passe não pode estar vazio e deve ser igual ao campo Palavra Passe.';
    }

    # VALIDANDO O CAMPO ADMINISTRADOR
    $requisicao['administrador'] = !empty($requisicao['administrador']) == 'on' ? true : false;


    # RETORNA ERROS
    if (isset($erros)) {
        return ['invalido' => $erros];
    }

    # RETORNA UTILIZADOR VALIDADO
    return $requisicao;
}
