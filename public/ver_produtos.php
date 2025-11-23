<?php
define("ITENS_POR_PAGINA", 30);
define("BOTOES_PAGINACAO", 3);

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/consts.php";

$pagina = (int) ($_GET["pagina"] ?? 1);
$filtros = array_filter($_GET, fn ($valor, $chave) => ($valor && in_array($chave, FILTROS_GET_PERMITIDOS)), ARRAY_FILTER_USE_BOTH);

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
    <link rel="stylesheet" href="style/ver_produtos.css">
</head>

<body>
    <?php 
    require_once __DIR__ . "/modulos/menu.php";
    require_once __DIR__ . "/modulos/msg.php";
    ?>

    <form id="form-filtros" action="">
        <div class="filtros">

            <div class="campo">
                <label for="nome">Nome: </label>
                <input type="text" id="nome" name="nome" value="<?= $filtros["nome"] ?? "" ?>">
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input list="marcas" name="marca" id="marca" value=<?= $filtros["marca"] ?? "" ?>>
                <datalist id="marcas">
                    <?php foreach (Produto::marcas() as $m): ?>
                        <option value=<?= $m ?>>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input list="categorias" name="categoria" id="categoria" value=<?= $filtros["categoria"] ?? "" ?>>
                <datalist id="categorias">
                    <?php foreach (Produto::categorias() as $c): ?>
                        <option value=<?= $c ?>>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label>Preço: </label>
                <input type="number" id="preco_min" placeholder="Min" name="preco_min" min="0" step="0.01" value=<?= $filtros["preco_min"] ?? "" ?>>
                <input type="number" id="preco_max" placeholder="Max" name="preco_max" min="0" step="0.01" value=<?= $filtros["preco_max"] ?? "" ?>>
            </div>

            <div class="campo">
                <label>Criado entre: </label>
                <input type="date" id="criado_em_min" placeholder="Min" name="criado_em_min" value=<?= $filtros["criado_em_min"] ?? "" ?>>
                <input type="date" id="criado_em_max" placeholder="Max" name="criado_em_max" value=<?= $filtros["criado_em_max"] ?? "" ?>>
            </div>

        </div>
        <div class="campo" id="botoes">
            <input type="reset" id="reset" value="Resetar">
            <input type="submit" id="enviar" value="Pesquisar">
        </div>
    </form>
    
    <main>
        <div id="tabela">
            <a id="add-novo" href="adicionarproduto.php">Novo Produto</a>
            <?= "<p>" . $total_filtro . " de " . $total . " Produtos encontrados (" . ($inicio + 1) . "-" . $fim . ")</p>" ?>
            <div id="paginas">
                <?php
                // Gera os links para ir para outras paginas
                for ($i = $pagina - BOTOES_PAGINACAO; $i <= $pagina + BOTOES_PAGINACAO; $i++) {
                    if ($i <= 0 || $i > $pag_max) continue;
                    $url = gerar_paginacao_url($i, $filtros);
                    $atual = ($i == $pagina) ? "atual" : "";
                    echo "<a class='pagina $atual' href='$url'>$i</a>";
                }
                ?>
            </div>

            <table>
                <!-- <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Marca</th>
                        <th>Categoria</th>
                        <th colspan=2>Ação</th>
                    </tr>
                </thead> -->

                <tbody>
                    <?php foreach ($produtos as $produto) : ?>
                        <tr>
                            <td class='atributo' id='nome'> <?= $produto->nome ?></td>
                            <td class='atributo' id='preco'> <?= $produto->preco ?></td>
                            <td class='atributo' id='marca'> <?= $produto->marca ?></td>
                            <td class='atributo' id='categoria'> <?= $produto->categoria ?></td>
                            <td class='atributo'><a href='detalhes.php?pid=<?= $produto->id ?>' class='material-symbols-outlined'>visibility</a></td>
                            <td class='atributo'><a href='excluir.php?pid=<?= $produto->id ?>' class='remover material-symbols-outlined'>delete</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>