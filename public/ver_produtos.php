<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $titulo = "Ver Produtos";
    require "head.php";
    ?>

<body>

    <?php
    require "menu.php";
    require __DIR__ . "/../src/Produto.php";
    ?>

    <a href="adicionarproduto.php">Adicionar Produto</a>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Categoria</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach (Produto::produtos() as $p): ?>
                <tr>
                    <td><?= $p->nome ?> </td>
                    <td><?= $p->preco ?> </td>
                    <td><?= $p->estoque ?> </td>
                    <td><?= $p->categoria ?> </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>

</body>

</html>