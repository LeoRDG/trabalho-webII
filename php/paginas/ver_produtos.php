<?php
define("ITENS_POR_PAGINA", 30);
define("BOTOES_PAGINACAO", 3);

require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

$pagina = (int) ($_GET["pagina"] ?? 1);
$filtros = array_filter($_GET, fn ($valor, $chave) => ($valor && in_array($chave, FILTROS_GET_PERMITIDOS)), ARRAY_FILTER_USE_BOTH);

try {
    $total = Produto::quantidade_total();
    $total_filtro = Produto::quantidade_total($filtros);
    $pag_max = ceil($total_filtro / ITENS_POR_PAGINA);
    $inicio = ($pagina - 1) * ITENS_POR_PAGINA;
    $fim = ($pagina == $pag_max) ? $total_filtro : $inicio + ITENS_POR_PAGINA;

    $produtos = Produto::get_produtos($inicio, ITENS_POR_PAGINA, $filtros);
    $marcas = Produto::marcas();
    $categorias = Produto::categorias();
}
catch (Exception $e) {
    redirecionar("index.php?erro={$e->getMessage()}");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ver Produtos</title>
    <?php include __DIR__ . "/../include/head.php"; ?>
    <script src="../../js/ajax_produto.js"></script>
    <link rel="stylesheet" href="../../css/ver_produtos.css">
</head>

<body>
    <?php 
    include __DIR__ . "/../include/menu.php";
    include __DIR__ . "/../include/msg.php";
    ?>

    <form id="form-filtros" action="">
        <div class="filtros">

            <div class="campo">
                <label for="nome">Nome: </label>
                <input type="text" id="nome" name="nome" value="<?= $filtros["nome"] ?? "" ?>">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input list="marcas" name="marca" id="marca" value=<?= $filtros["marca"] ?? "" ?>>
                <small class="erro" hidden></small>
                <datalist id="marcas">
                    <?php foreach ($marcas as $m): ?>
                        <option value=<?= $m ?>>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input list="categorias" name="categoria" id="categoria" value=<?= $filtros["categoria"] ?? "" ?>>
                <small class="erro" hidden></small>
                <datalist id="categorias">
                    <?php foreach ($categorias as $c): ?>
                        <option value=<?= $c ?>>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label>Preço: </label>
                <input type="number" class="preco" id="preco_min" placeholder="Min" name="preco_min" min="0" step="0.01" value=<?= $filtros["preco_min"] ?? "" ?>>
                <small class="erro" hidden></small>
                <input type="number" class="preco" id="preco_max" placeholder="Max" name="preco_max" min="0" step="0.01" value=<?= $filtros["preco_max"] ?? "" ?>>
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label>Criado entre: </label>
                <input type="date" id="criado_em_min" placeholder="Min" name="criado_em_min" value=<?= $filtros["criado_em_min"] ?? "" ?>>
                <small class="erro" hidden></small>
                <input type="date" id="criado_em_max" placeholder="Max" name="criado_em_max" value=<?= $filtros["criado_em_max"] ?? "" ?>>
                <small class="erro" hidden></small>
            </div>

        </div>
        <div class="campo" id="botoes">
            <input type="reset" id="reset" value="Resetar">
            <small class="erro" hidden></small>
            <input type="submit" id="enviar" value="Pesquisar">
            <small class="erro" hidden></small>
        </div>
    </form>
    
    <div id="tabela">
        <a id="add-novo" href="adicionar_produto.php">Novo Produto</a>
        <?= "<p>" . $total_filtro . " de " . $total . " Produtos encontrados (" . ($inicio + 1) . "-" . $fim . ")</p>" ?>
        <div id="paginas">
            <?php
            // Gera os links para ir para outras paginas
            for ($i = $pagina - BOTOES_PAGINACAO; $i <= $pagina + BOTOES_PAGINACAO; $i++) {
                if ($i <= 0 || $i > $pag_max) continue;
                $atual = ($i == $pagina) ? "atual" : "";
                $url = ($i == $pagina) ? "" : gerar_paginacao_url($i, $filtros);
                echo "<a class='pagina $atual' href='$url'>$i</a>";
            }
            ?>
        </div>

        <div id="produtos-lista">
            <?php foreach ($produtos as $produto) : ?>
                <div class="produto-container">
                    <div class="produto" id="<?= $produto->id ?>">
                        <span class='nome'> <?= $produto->nome ?></span>
                        <span class='preco'> <?= "R$ " . number_format($produto->preco, 2, ",", ".") ?></span>
                        <span class='marca'> <?= $produto->marca ?></span>
                        <span class='categoria'> <?= $produto->categoria ?></span>
                        <a href='detalhes_produto.php?pid=<?= $produto->id ?>' class='detalhes material-symbols-outlined'>edit</a>
                        <a href='../actions/excluir.php?pid=<?= $produto->id ?>' class='remover material-symbols-outlined'>delete</a>
                    </div>
                    <div class="produto-detalhes" id="<?= $produto->id ?>" hidden></div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

</body>

</html>