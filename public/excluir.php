<?php 
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/HTML.php";
require_once __DIR__ . "/../src/util.php";

$id = get_id_produto();

$p = new Produto(["id" => $id]);
$sucesso = $p->deletar();

if (!$sucesso) {
    mensagem_erro("ID nao existe na tabela!");
    exit;
};

header("Location: ver_produtos.php");