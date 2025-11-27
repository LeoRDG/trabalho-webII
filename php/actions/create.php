<?php 

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

try {
    $qtd = $_POST["multiplos"] ?? null;
    if ( is_numeric($qtd) ) {
        Produto::insereTeste($qtd);
        $red_url = "../paginas/ver_produtos.php?sucesso=$qtd produtos inserido com sucesso!";
        unset($_POST["multiplos"]);
    }

    if (!empty($_POST)) {
        $produto = new Produto($_POST);
        $id = $produto->insert();
        $red_url = "../paginas/adicionar_produto.php?sucesso=Produto inserido com sucesso! id=$id";
    }
}
catch (Exception $e) {
    $red_url = "../paginas/adicionar_produto.php?erro={$e->getMessage()}";
} 
finally {
    redirecionar($red_url ?? null);
}

