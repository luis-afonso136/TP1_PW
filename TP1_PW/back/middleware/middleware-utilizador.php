<?php

/**
 * FICHEIRO RESPONSÁVEL PARA GARANTIR QUE UMA PÁGINA SEJA ACESSÍVEL
 * APENAS POR UM UTILIZADOR AUTENTICADO EM SESSÃO OU COOKIE 
 **/

# INICIA A SESSÃO
session_start();

# SE UTILIZADOR NÃO TIVER SESSÃO INICIADA, ENVIA PARA TELA DE LOGIN
if (!isset($_SESSION['id'])) {

  # ADICIONA COOCKIE CASO UTILIZADOR TENHA SESSÃO INICIADA
  if (isset($_COOKIE['id']) && isset($_COOKIE['nome'])) {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['nome'] = $_COOKIE['nome'];
  } else {

    # REDIRECIONA UTILIZADOR PARA TELA DE LOGIN, CASO TENTE ACESSAR ÁREA PROTEGIDA
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/aplicacao/login.php';
    header('Location: ' . $home_url);
  }
}
