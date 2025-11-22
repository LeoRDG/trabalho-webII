<?php 

require_once __DIR__ . "/../src/Produto.php";

$produto = new Produto($_POST);

$id = $produto->insert();

// Redireciona para a para a pagina de adicionarproduto com o id de insercao
header("Location: adicionarproduto.php?sucesso=$id");
