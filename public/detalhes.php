<?php 
if ( !isset($_GET["pid"]) ) {
    echo "Informe um id";
    exit;
};

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/HTML.php";
use function HTML\criar_input;

$id = $_GET["pid"];

$p = new Produto(["id" => $id]);
$sucesso = $p->carregar();
if (!$sucesso) {
    echo "id Nao encontrado";
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
