<?php 

require_once __DIR__."/../../src/Produto.php";
require_once __DIR__."/../../src/util.php";
require_once __DIR__."/../../src/HTML.php";
use function HTML\criar_input;

criar_input("text", "nome", "Nome", "filtro", $filtros["nome"]);
criar_input("lista", "marca", "Marca", "filtro", $filtros["marca"], Produto::marcas());
criar_input("lista", "categoria", "Categoria", "filtro", $filtros["categoria"], Produto::categorias());
criar_input("number", "preco", "Preco", "filtro", $filtros["preco"]);        
criar_input("number", "estoque", "Estoque", "filtro", $filtros["estoque"]);
criar_input("date", "criado_em", "Criado entre", "filtro", $filtros["criado_em"]);
?>