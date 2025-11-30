<?php 
/**
 * Pagina para carregar os dados para a pagina de ver produtos
 */

require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/Produto.php";

$qtd_items = 30;                        // Quantidade de itens por pagina
$qtd_botoes = 3;                        // Quantidade de botoes de navegacao
$pagina = (int) ($_GET["pagina"] ?? 1); // Página atual (padrão: 1)

// Filtra apenas os parâmetros GET que são filtros permitidos e não estão vazios
$filtros = array_filter($_GET, fn ($valor, $chave) => ($valor && in_array($chave, Produto::FILTROS_PERMITIDOS)), ARRAY_FILTER_USE_BOTH);

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
    set_msg("erro", $e->getMessage(), 10000);
    redirecionar("index.php?");
}