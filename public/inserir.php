<?php 

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

try {
    $qtd = $_GET["multiplos"] ?? null;
    if ( is_numeric($qtd) ) {
        Produto::insereTeste($qtd);
        $red_url = "adicionarproduto.php?sucesso=$qtd produtos inserido com sucesso!";
    }

    if (!empty($_POST)) {
        $produto = new Produto($_POST);
        $id = $produto->insert();
        $red_url = "adicionarproduto.php?sucesso=Produto inserido com sucesso! id=$id";
    }
}
catch (Exception $e) {
    $red_url = "adicionarproduto.php?erro={$e->getMessage()}";
} 
finally {
    redirecionar($red_url ?? null);
}

