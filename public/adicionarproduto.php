<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php
    $titulo = "Adicionar Produto";
    require_once __DIR__ . "/modulos/head.php";
    ?>
    <link rel="stylesheet" href="style/add_form_style.css">
</head>

<body>
    <?php 
    require_once __DIR__ . "/modulos/menu.php";
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/../src/HTML.php";
    require_once __DIR__ . "/../src/Produto.php";
    use function HTML\mensagem_sucesso;
    use function HTML\botoes_formulario;
    $categorias = Produto::categorias();
    $marcas = Produto::marcas();
    $modo = "add";
    
    if (isset($_GET["sucesso"]) && $_GET["sucesso"] > 0) {
        mensagem_sucesso("Produto inserido com sucesso! id = {$_GET['sucesso']}");
    }
    ?>

    <form action="criarproduto.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>
            <?php 
                require_once __DIR__ . "/modulos/campos_produto.php";
            ?>
            <?php botoes_formulario("Limpar", "Adicionar", "enviar", "resetar"); ?>
        </fieldset>
    </form>
</body>

</html>