<?php

# CRIA CONEXÃO COM O PDO UTILIZANDO A BASE DE DADOS SQLITE
try {
    $caminhoBD = __DIR__ . '/database.sqlite';
    $pdo = new PDO('sqlite:' . $caminhoBD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ocorreu um erro na ligação à base de dados";
    echo $e->getMessage();
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    exit();
}
