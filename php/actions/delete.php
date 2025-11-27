<?php 
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/Produto.php";

try {
    if (isset($_POST["todos"]) && $_POST["todos"] == 1) {
        Produto::remover_todos();
        $red_url = "../paginas/ver_produtos.php";
        set_msg("sucesso", "Todos os produtos foram removidos.", 5000);
    }
    else {
        $id = get_id_produto();
        $p = new Produto(["id" => $id]);
        $excluidos = $p->deletar();
        $red_url = "../paginas/ver_produtos.php";
        if ($excluidos >= 1) set_msg("sucesso", "Produto $id removido.", 5000);
        else set_msg("erro", "Produto com id $id nao existe.", 5000);
    }
} 
catch (Exception $e) {
    $red_url = "../../index.php?erro={}";
    set_msg("erro", $e->getMessage(), 5000);
} 
finally {
    redirecionar($red_url ?? null);
}
