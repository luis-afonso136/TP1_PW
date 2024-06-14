<?php
# TRATA-SE DE UMA FORMA RÁPIDA PARA REINICIAR O BANCO DE DADOS EM AMBIENTE DE DESENVOLVIMENTO
# ESTE FICHEIRO NÃO DEVE ESTAR DISPONÍVEL EM PRODUÇÃO

# INSERE DADOS DA CONEXÃO COM O PDO UTILIZANDO SQLITE
require __DIR__ . '/criar-conexao.php';

# APAGA TABELA SE ELA EXISTIR
$pdo->exec('DROP TABLE IF EXISTS produtos;');

echo 'Tabela produtos apagada!' . PHP_EOL;

# CRIA A TABELA PRODUTOS
$pdo->exec(
    'CREATE TABLE produtos (
    id INTEGER PRIMARY KEY, 
    nome CHAR NOT NULL, 
    descricao TEXT, 
    preco DECIMAL(10, 2) NOT NULL, 
    quantidade INTEGER NOT NULL, 
    categoria CHAR NOT NULL, 
    fornecedor CHAR NOT NULL, 
    imagem BLOB
);'
);

echo 'Tabela produtos criada!' . PHP_EOL;
