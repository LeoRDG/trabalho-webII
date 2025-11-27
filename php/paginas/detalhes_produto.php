<?php
require_once __DIR__ . "/../src/util.php";
if (isset($_GET["apenas_detalhes"])) {
    include __DIR__ . "/../include/produto_template.php";
    exit;
}
?>

<!DOCTYPE html>

<head>
    <?php include __DIR__ . "/../include/head.php" ?>
    <link rel="stylesheet" href="../../css/detalhes_produto.css">
</head>

<body>
    <?php
    include __DIR__ . "/../include/menu.php";
    include __DIR__ . "/../include/msg.php";
    ?>

    <main>
        <form action="../actions/update.php" method="POST" enctype="multipart/form-data">

            <?php include __DIR__ . "/../include/produto_template.php" ?>

            <div class="campo" id="botoes">
                <input class="static" type="reset" id="resetar" value="Resetar">
                <input type="submit" id="enviar" value="Atualizar">
            </div>
        </form>
    </main>
</body>