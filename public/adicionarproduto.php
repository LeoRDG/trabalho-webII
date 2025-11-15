<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Adicionar Produto</title>
    <?php require_once __DIR__ . "/modulos/head.php" ?>
    <link rel="stylesheet" href="style/add_form_style.css">
</head>

<body>
    <?php 
    require_once __DIR__ . "/modulos/menu.php";
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/../src/HTML.php";
    require_once __DIR__ . "/../src/Produto.php";
    
    if (isset($_GET["sucesso"]) && $_GET["sucesso"] > 0) {
        mensagem_sucesso("Produto inserido com sucesso! id = {$_GET['sucesso']}");
    }
    ?>

    <form action="inserir.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>
            <?php 
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

            <div class='campo' id='botoes'>
                <input type='reset' value='Limpar'>
                <input type='submit' value='Adicionar'>
            </div>

        </fieldset>
    </form>
</body>

</html>