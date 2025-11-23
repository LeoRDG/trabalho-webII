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
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/../src/Produto.php";

    try {
        $marcas = Produto::marcas();
        $categorias = Produto::categorias();
    } 
    catch (Exception $e) {
        redirecionar("index.php?erro={$e->getMessage()}");
    }
    ?>

    <form action="../actions/inserir.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>

            <div class="campo">
                <label for="nome">Nome: </label>
                <input class="texto" required type="text" id="nome" name="nome">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input class="texto" list="marcas" name="marca" id="marca">
                <small class="erro" hidden></small>
                <datalist id="marcas">

                    <?php foreach ($marcas as $m): ?>
                        <option value="<?= $m ?>">
                    <?php endforeach ?>

                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input class="texto" list="categorias" name="categoria" id="categoria">
                <small class="erro" hidden></small>
                <datalist id="categorias">

                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= $c ?>">
                    <?php endforeach ?>

                </datalist>
            </div>

            <div class="campo">
                <label for="descricao">Descrição: </label>
                <textarea class="texto" name="descricao" id="descricao"></textarea>
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="preco">Preço: </label>
                <input class="numero" required type="number" class="preco" id="preco" name="preco" min="0" step="0.01">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="estoque">Estoque: </label>
                <input class="numero" required type="number" id="estoque" name="estoque" min="0">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="peso">Peso (g): </label>
                <input class="numero" required type="number" id="peso" name="peso" min="0" step="0.1">
                <small class="erro" hidden></small>
            </div>

            <fieldset class="campo condicao">
                <legend for="condicao">Condição: </legend>
                <label for="Novo">
                    <input required type="radio" value="Novo" id="Novo" name="condicao">
                    Novo
                </label>

                <label for="Usado">
                    <input type="radio" value="Usado" id="Usado" name="condicao">
                    Usado
                </label>

                <label for="Recondicionado">
                    <input type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
                    Recondicionado
                </label>
                <small class="erro" hidden></small>
            </fieldset>

            <div class="campo check">
                <label>
                    <input type="checkbox" name="frete_gratis">
                    Frete Grátis
                </label>
            </div>

            <div class="campo" id="botoes">
                <input type="reset" id="resetar" value="Limpar">
                <input type="submit" id="enviar" value="Adicionar">
            </div>

        </fieldset>
    </form>

    <div id="extras">
        <a class="remover" href="../actions/inserir.php?multiplos=1000">Inserir 1000 produtos aleatórios!</a>
        <a class="remover" href="../actions/excluir.php?todos=1">Deletar todos os produtos</a>
    </div>
</body>

</html>