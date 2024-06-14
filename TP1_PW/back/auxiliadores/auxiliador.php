<?php
session_start();
# INICIALIZA O REPOSITÓRIO PDO UTILIZADOR 
require_once __DIR__ . '/../../back/basededados/repositorio-utilizador.php';

/**
 * FUNÇÃO PARA INFORMAR SE UTILIZADO ESTÁ AUTENTICADO
 */
function autenticado()
{
    return isset($_SESSION['id']) ? true : false;
}

/**
 * FUNÇÃO QUE RETORNA OS DADOS DO UTILIZADOR
 */
function utilizador()
{
    if (autenticado()) {
        return lerUtilizador($_SESSION['id']);
    } else {
        return false;
    }
}

/**
 * FUNÇÃO QUE RETORNA O ID DO UTILIZADOR LOGADO
 */
function utilizadorId()
{
    return  $_SESSION['id'];
}

/**
 * FUNÇÃO PARA INFORMAR SE UTILIZADOR É ADMNISTRADOR
 */
function administrador()
{
    $utilizador = utilizador();
    return $utilizador['administrador'] ? true : false;
}

/**
 * FUNÇÃO PARA INFORMAR SE UTILIZADOR É O DONO DO SISTEMA
 */
function dono()
{
    $utilizador = utilizador();
    return $utilizador['dono'] ? true : false;
}
