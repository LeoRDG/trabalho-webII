<?php 
define("FILTROS_GET_PERMITIDOS", 
[ 
    "nome",
    "marca",
    "categoria",
    "preco", "preco_min", "preco_max",
    "estoque",  "estoque_min",  "estoque_max",
    "criado_em", "criado_em_min", "criado_em_max"]);

define("FILTROS_INTERVALOS", 
[
    "preco"     => ["preco_min", "preco_max"],
    "estoque"   => ["estoque_min", "estoque_max"],
    "criado_em" => ["criado_em_min", "criado_em_max"],
]);