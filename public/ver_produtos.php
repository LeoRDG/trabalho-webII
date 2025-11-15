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
    <?php
    $titulo = "Ver Produtos";
    require_once __DIR__ . "/modulos/head.php";
    ?>
    <link rel="stylesheet" href="style/tabela_produtos.css">
</head>

<body>
    <?php require_once __DIR__ . "/modulos/menu.php"; ?>

    <form action="">
        <div class="filtros">
            <?php require "modulos/filtros_produtos.php"; ?>
        </div>
        <?php botoes_formulario("Limpar", "Buscar", "resetar", "enviar"); ?>
    </form>

    <div class="main">
        <div id="tabela">
            <a href="adicionarproduto.php">Novo Produto</a>
            <?php 
            info_paginacao($total_filtro, $total, $inicio, $fim);
            links_paginacao($pagina, $pag_max, BOTOES_PAGINACAO, $filtros);
            ?>

            <table>
                <?php cabecalho_tabela_produtos(); ?>

                <tbody>
                    <?php 
                    foreach ($produtos as $produto) {
                        linha_tabela_produto($produto);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>