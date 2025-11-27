<?php 

$qtd_items = 30;
$qtd_botoes = 3;
$pagina = (int) ($_GET["pagina"] ?? 1);
$filtros = array_filter($_GET, fn ($valor, $chave) => ($valor && in_array($chave, FILTROS_GET_PERMITIDOS)), ARRAY_FILTER_USE_BOTH);

try {
    $total = Produto::quantidade_total();
    $total_com_filtro = Produto::quantidade_total($filtros);
    $ultima_pagina = ceil($total_com_filtro / $qtd_items);
    
    $inicio = ($pagina - 1) * $qtd_items;
    $fim = ($pagina == $ultima_pagina) ? $total_com_filtro : $inicio + $qtd_items;

    $produtos = Produto::get_produtos($inicio, $qtd_items, $filtros);
    $marcas = Produto::marcas();
    $categorias = Produto::categorias();
}
catch (Exception $e) {
    redirecionar("ver_produtos.php?erro={$e->getMessage()}");
}