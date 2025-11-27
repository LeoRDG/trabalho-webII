<?php 
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/Produto.php";

try {
    $qtd = $_POST["multiplos"] ?? null;
    if ( is_numeric($qtd) ) {
        Produto::insereTeste($qtd);
        $red_url = "../paginas/ver_produtos.php";
        set_msg("sucesso", "$qtd produtos inseridos com sucesso!", 5000);
        unset($_POST["multiplos"]);
    }
    
    if (!empty($_POST)) {
        $produto = new Produto($_POST);
        $id = $produto->insert();
        $red_url = "../paginas/adicionar_produto.php?sucesso=";
        set_msg("sucesso", "Produto inserido com sucesso! id=$id", 5000);
    }
}
catch (Exception $e) {
    set_msg("erro", $e->getMessage(), 5000);
    $red_url = "../paginas/adicionar_produto.php";
} 
finally {
    redirecionar($red_url ?? null);
}

