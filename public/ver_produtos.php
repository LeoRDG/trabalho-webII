<?php
define("ITENS_POR_PAGINA", 30);
define("BOTOES_PAGINACAO", 4);

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/HTML.php";

$pagina = (int) ($_GET["pagina"] ?? 1);
$filtros = gerar_filtros_get();

$total = Produto::quantidade_total();
$total_filtro = Produto::quantidade_total($filtros);
$pag_max = ceil($total_filtro / ITENS_POR_PAGINA);
$inicio = ($pagina - 1) * ITENS_POR_PAGINA;
$fim = ($pagina == $pag_max) ? $total_filtro : $inicio + ITENS_POR_PAGINA;

$produtos = Produto::get_produtos($inicio, ITENS_POR_PAGINA, $filtros);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ver Produtos</title>
    <?php require_once __DIR__ . "/modulos/head.php"; ?>
    <link rel="stylesheet" href="style/tabela_produtos.css">
</head>

<body>
    <?php require_once __DIR__ . "/modulos/menu.php"; ?>

    <form action="">
        <div class="filtros">
            <?php criar_filtros_inputs($filtros) ?>
        </div>

        <div class='campo' id='botoes'>
            <input type='reset' value='Resetar Filtros'>
            <input type='submit' value='Pesquisar'>
        </div>
    </form>

    <div class="main">
        <div id="tabela">
            <a href="adicionarproduto.php">Novo Produto</a>
            <?php
            info_paginacao($total_filtro, $total, $inicio, $fim);
            links_paginacao($pagina, $pag_max, BOTOES_PAGINACAO, $filtros);
            ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Detalhes</th>
                        <th>Excluir</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($produtos as $produto) : ?>
                        <tr>
                            <td class='atributo' id='id'> <?= $produto->id ?></td>
                            <td class='atributo' id='nome'> <?= $produto->nome ?></td>
                            <td class='atributo' id='preco'> <?= $produto->preco ?></td>
                            <td class='atributo' id='categoria'> <?= $produto->categoria ?></td>
                            <td class='atributo'><a href='detalhes.php?pid=<?= $produto->id ?>' class='material-symbols-outlined'>visibility</a></td>
                            <td class='atributo'><a href='excluir.php?pid=<?= $produto->id ?>' class='material-symbols-outlined'>delete</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>