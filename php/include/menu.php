<?php preg_match("/\/([\w]+\.php)/", $_SERVER["PHP_SELF"], $current); ?>

<ul class="menu">
    <li><a class="<?= $current[1] == "index.php" ? "current" : "" ?>" href="../paginas/index.php">Home</a></li>
    <li><a class="<?= $current[1] == "adicionar_produto.php" ? "current" : "" ?>" href="../paginas/adicionar_produto.php">Adicionar Produto</a></li>
    <li><a class="<?= $current[1] == "ver_produtos.php" ? "current" : "" ?>" href="../paginas/ver_produtos.php">Ver Produtos</a></li>
</ul>
