<?php
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

try {
    if ( !empty($_POST) ) {
        $p = new Produto($_POST);
        $p->update();
        $target_url = "detalhes.php?pid=$p->id&sucesso=Produto atualizado com sucesso";
    }
}
catch (Exception $e) {
        $erro = $e->getMessage();
        $target_url = "detalhes.php?&erro=$erro";
} finally {
    redirecionar($target_url ?? null);
}
