<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php
    $titulo = "Adicionar Produto";
    require "head.php";
    ?>
    <link rel="stylesheet" href="style/add_form_style.css">
</head>

<body>
    <?php 
    require "menu.php";
    require __DIR__ . "/../src/util.php";
    require __DIR__ . "/../src/Produto.php";
    $categorias = Produto::categorias();
    $marcas = Produto::marcas();
    $modo = "add";

    if (isset($_GET["sucesso"]) && $_GET["sucesso"] > 0) {
        echo "<p id='sucesso'>Produto inserido com sucesso! id = {$_GET['sucesso']}</p>";
    }
    ?>

    <form action="criarproduto.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>
            <?php 
                criar_input("text", "nome", "Nome");
                criar_input("lista", "marcas", "Marcas", "", "", $marcas);
                criar_input("lista", "categorias", "Categorias", "", "", $categorias);
                criar_input("textarea", "descricao", "Descricao");
                criar_input("number", "preco", "Preco");
                criar_input("number", "estoque", "Estoque");
                criar_input("number", "peso", "Peso");
                criar_input("radio", "codicao", "Condição", "", "", ["Novo", "Usado", "Recondicionado"]);
                criar_input("checkbox", "frete_gratis", "Frete Grátis");
                criar_input("file", "img", "Imagem");
            ?>
            <div class="campo" id="botoes">
                <input type="reset" id="enviar" value="Limpar">
                <input type="submit" id="resetar" value="Adicionar">
            </div>
        </fieldset>
    </form>
</body>

</html>