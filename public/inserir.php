<?php 

require_once __DIR__ . "/../src/Produto.php";

if ( isset($_GET["multiplos"]) && is_numeric($_GET["multiplos"]) ) {
    Produto::insereTeste($_GET["multiplos"]);
}

if (!empty($_POST)) {
    $produto = new Produto($_POST);
    $id = $produto->insert();
    $redirecionar = "adicionarproduto.php?sucesso=$id";
}

redirecionar($redirecionar ?? null);
