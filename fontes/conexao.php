<?php
try {
    // Faz conex�o com banco de daddos
    $pdo = new PDO("mysql:host=localhost;dbname=zonazul;","root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e){
    // Caso ocorra algum erro na conex�o com o banco, exibe a mensagem
    echo 'Falha ao conectar no banco de dados: '.$e->getMessage();
    die;
}
