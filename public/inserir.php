<?php 

require_once __DIR__ . "/../src/Produto.php";

if ( isset($_GET["multiplos"]) && is_numeric($_GET["multiplos"]) ) {
    Produto::insereTeste($_GET["multiplos"]);
    header("Location: adicionarproduto.php");
    exit;
}

if (!empty($_POST)) {
    $produto = new Produto($_POST);
    $id = $produto->insert();
    // Redireciona para a para a pagina de adicionarproduto com o id de insercao
    header("Location: adicionarproduto.php?sucesso=$id");
}

