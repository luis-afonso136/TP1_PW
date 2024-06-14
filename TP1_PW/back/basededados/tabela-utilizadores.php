<?php
# TRATA-SE DE UMA FORMA RÁPIDA PARA REINICIAR O BANCO DE DADOS EM AMBIENTE DE DESENVOLVIMENTO
# ESTE FICHEIRO NÃO DEVE ESTAR DISPONÍVEL EM PRODUÇÃO

# INSERE DADOS DA CONEXÃO COM O PDO UTILIZANDO SQLITE

require __DIR__ . '/criar-conexao.php';

# APAGA TABELA SE ELA EXISTIR
$pdo->exec('DROP TABLE IF EXISTS utilizadores;');

echo 'Tabela utilizadores apagada!' . PHP_EOL;

# CRIA A TABELA UTILIZADORES
$pdo->exec(
    'CREATE TABLE utilizadores (
    id INTEGER PRIMARY KEY, 
    nome CHAR, 
    apelido CHAR, 
    nif CHAR, 
    telemovel CHAR, 
    email CHAR NOT NULL, 
    foto CHAR NULL, 
    administrador CHAR, 
    dono CHAR,
    palavra_passe CHAR);'
);

echo 'Tabela utilizadores criada!' . PHP_EOL;

# ABAIXO UM ARRAY SIMULANDO DADOS DE UM UTILIZADOR 
$utilizador = [
    'nome' => 'Luis',
    'apelido' => 'Afonso',
    'nif' => '123456789',
    'telemovel' => '969176515',
    'email' => 'luis@ipvc.pt',
    'foto' => null,
    'administrador' => true,
    'dono' => true,
    'palavra_passe' => '123456'
];

# CRIPTOGRAFA PALAVRA PASSE
$utilizador['palavra_passe'] = password_hash($utilizador['palavra_passe'], PASSWORD_DEFAULT);

# INSERE UTILIZADOR
$sqlCreate = "INSERT INTO 
    utilizadores (
        nome, 
        apelido, 
        nif, 
        telemovel, 
        email, 
        foto, 
        administrador, 
        dono, 
        palavra_passe) 
    VALUES (
        :nome, 
        :apelido, 
        :nif, 
        :telemovel, 
        :email, 
        :foto, 
        :administrador, 
        :dono,
        :palavra_passe
    )";

# PREPARA A QUERY
$PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

# EXECUTA A QUERY RETORNANDO VERDADEIRO SE CRIAÇÃO FOI FEITA
$sucesso = $PDOStatement->execute([
    ':nome' => $utilizador['nome'],
    ':apelido' => $utilizador['apelido'],
    ':nif' => $utilizador['nif'],
    ':telemovel' => $utilizador['telemovel'],
    ':email' => $utilizador['email'],
    ':foto' => $utilizador['foto'],
    ':administrador' => $utilizador['administrador'],
    ':dono' => $utilizador['dono'],
    ':palavra_passe' => $utilizador['palavra_passe']
]);

echo 'Utilizador padrão criado!';
