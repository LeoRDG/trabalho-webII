<?php 

require_once __DIR__."/../../src/Produto.php";
require_once __DIR__."/../../src/util.php";
require_once __DIR__."/../../src/HTML.php";

$preco = [$filtros["preco_min"] ?? "", $filtros["preco_max"] ?? ""];
$estoque = [$filtros["estoque_min"] ?? "", $filtros["estoque_max"] ?? ""];
$criado_em = [$filtros["criado_em_min"] ?? "", $filtros["criado_em_max"] ?? ""];

criar_input("text", "nome", "Nome", "filtro", $filtros["nome"] ?? "");
criar_input("lista", "marca", "Marca", "filtro", $filtros["marca"] ?? "", Produto::marcas());
criar_input("lista", "categoria", "Categoria", "filtro", $filtros["categoria"] ?? "", Produto::categorias());
criar_input("number", "preco", "Preco", "filtro", $preco);
criar_input("number", "estoque", "Estoque", "filtro", $estoque);
criar_input("date", "criado_em", "Criado entre", "filtro", $criado_em);
?>