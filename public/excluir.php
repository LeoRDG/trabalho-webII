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

    if (!$sucesso) {
        mensagem_erro("ID nao existe na tabela!");
    };
}

// Redireciona para a pagina especificada ou para a pagina que chamou essa pagina ou para o index
$location = $redirecionar ?? $_SERVER["HTTP_REFERER"] ?? "index.html";
header("Location: $location");
exit;