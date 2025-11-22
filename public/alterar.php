<?php
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

if ( !empty($_POST) ) {
    $p = new Produto($_POST);
    $p->update();
}

redirecionar($redirecionar ?? null);