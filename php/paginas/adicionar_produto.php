<?php 
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/../src/Produto.php";
    $modo = "add";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Adicionar Produto</title>
    <?php include __DIR__ . "/../include/head.php" ?>
    <link rel="stylesheet" href="../../css/adicionar_produto.css">
</head>

<body>
    <?php 
    include __DIR__ . "/../include/menu.php";
    include __DIR__ . "/../include/msg.php";

    try {
        $marcas = Produto::marcas();
        $categorias = Produto::categorias();
    } 
    catch (Exception $e) {
        redirecionar("index.php?erro={$e->getMessage()}");
    }
    ?>

    <form action="../actions/create.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>

            <?php require __DIR__ . "/../include/produto_template.php" ?>

            <div class="campo" id="botoes">
                <input type="reset" id="resetar" value="Limpar">
                <input type="submit" id="enviar" value="Adicionar">
            </div>

        </fieldset>
    </form>

    <div id="extras">
        <form action="../actions/create.php" method="POST">
            <button class="remover" type="submit">
                Inserir
                <input min=1 max=9999 type="number" id="multiplos" name="multiplos" value=100>
                produtos aleatórios!
            </button>
        </form>

        <form action="../actions/delete.php" method="POST">
            <input type="hidden" name="todos" value="1">
            <button type="submit" class="remover">Deletar todos os produtos</button>
        </form>
    </div>
</body>

</html>