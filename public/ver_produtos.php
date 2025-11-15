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

            <div class="campo">
                <label for="nome">Nome: </label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input list="marcas" name="marca" id="marca">
                <datalist id="marcas">
                    <?php foreach ($marcas as $m): ?>
                        <option value=<?= $m ?>>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input list="categorias" name="categoria" id="categoria">
                <datalist id="categorias">
                    <?php foreach ($categorias as $c): ?>
                        <option value=<?= $c ?>>
                        <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label>Preço: </label>
                <input required type="number" id="preco_min" placeholder="Min" name="preco_min" min=0>
                <input required type="number" id="preco_max" placeholder="Max" name="preco_max" min=0>
            </div>

            <div class="campo">
                <label>Criado entre: </label>
                <input required type="date" id="preco_min" placeholder="Min" name="preco_min" min=0>
                <input required type="date" id="preco_max" placeholder="Max" name="preco_max" min=0>
            </div>

            <div class="campo" id="botoes">
                <input type="reset" id="reset" value="Resetar">
                <input type="submit" id="pesquisar" value="Pesquisar">
            </div>
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