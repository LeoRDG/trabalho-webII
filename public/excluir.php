<?php 
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/HTML.php";
require_once __DIR__ . "/../src/util.php";

if (isset($_GET["todos"]) && $_GET["todos"] == 1) {
    Produto::remover_todos();
}
else {
    $id = get_id_produto();
    $p = new Produto(["id" => $id]);
    $sucesso = $p->deletar();
}

redirecionar($redirecionar ?? null);
