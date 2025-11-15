<?php 
    require_once __DIR__ . "/../../src/util.php";
    require_once __DIR__ . "/../../src/HTML.php";
    require_once __DIR__ . "/../../src/Produto.php";
    use function HTML\criar_input;

    criar_input("text", "nome", "Nome");
    criar_input("lista", "marcas", "Marcas", "", "", Produto::marcas());
    criar_input("lista", "categorias", "Categorias", "", "", Produto::categorias());
    criar_input("textarea", "descricao", "Descricao");
    criar_input("number", "preco", "Preco");
    criar_input("number", "estoque", "Estoque");
    criar_input("number", "peso", "Peso");
    criar_input("radio", "condicao", "Condição", "", "", ["Novo", "Usado", "Recondicionado"]);
    criar_input("checkbox", "frete_gratis", "Frete Grátis");
    criar_input("file", "img", "Imagem");
?>