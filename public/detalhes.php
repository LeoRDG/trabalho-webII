<?php 
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/HTML.php";
require_once __DIR__ . "/../src/util.php";

$id = get_id_produto();

$p = new Produto(["id" => $id]);
$sucesso = $p->carregar();

if (!$sucesso) {
    mensagem_erro("ID nao existe na tabela!");
    exit;
};

criar_input("text", "nome", "Nome", "edit", "$p->nome");
criar_input("lista", "marcas", "Marcas", "edit", "$p->marca", Produto::marcas());
criar_input("lista", "categorias", "Categorias", "edit", "$p->categoria", Produto::categorias());
criar_input("textarea", "descricao", "Descricao", "edit", $p->descricao);
criar_input("number", "preco", "Preco", "edit", $p->preco);
criar_input("number", "estoque", "Estoque", "edit", $p->estoque);
criar_input("number", "peso", "Peso", "edit", $p->peso);
criar_input("checkbox", "frete_gratis", "Frete Grátis", "edit", $p->frete_gratis);
criar_input("radio", "condicao", "Condição", "edit", $p->condicao, ["Novo", "Usado", "Recondicionado"]);
