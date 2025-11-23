<?php 
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

try {
    if (isset($_GET["todos"]) && $_GET["todos"] == 1) {
        Produto::remover_todos();
        $red_url = "ver_produtos?sucesso=Todos os produtos foram removidos.";
    }
    else {
        $id = get_id_produto();
        $p = new Produto(["id" => $id]);
        $excluidos = $p->deletar();
        $msg = ($excluidos >= 1) ? "sucesso=Produto $id removido." : "erro=Produto com id $id nao existe";
        $red_url = "ver_produtos.php?$msg";
    }
} 
catch (Exception $e) {
        $red_url = "index.php?erro={$e->getMessage()}";
} 
finally {
    redirecionar($red_url ?? null);
}
