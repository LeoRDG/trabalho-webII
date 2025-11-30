<?php
/**
 * Página para atualizar produtos existentes
 */

require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/Produto.php";

try {
    if ( !empty($_POST) ) {
        $p = new Produto($_POST);
        $p->update();
        $target_url = "../paginas/editar_produto.php?pid=$p->id";
        set_msg("sucesso", "Produto atualizado com sucesso", 5000);
    }
}
catch (Exception $e) {
    $target_url = "../paginas/editar_produto.php?pid=$p->id";
    set_msg("erro", $e->getMessage(), 5000);
} finally {
    redirecionar($target_url);
}
