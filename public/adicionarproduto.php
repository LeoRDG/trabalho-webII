<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Adicionar Produto</title>
    <?php require_once __DIR__ . "/modulos/head.php" ?>
    <link rel="stylesheet" href="style/add_form_style.css">
</head>

<body>
    <?php 
    require_once __DIR__ . "/modulos/menu.php";
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/../src/HTML.php";
    require_once __DIR__ . "/../src/Produto.php";
    
    if (isset($_GET["sucesso"]) && $_GET["sucesso"] > 0) {
        mensagem_sucesso("Produto inserido com sucesso! id = {$_GET['sucesso']}");
    }
    ?>

    <form action="inserir.php" method="POST" enctype="multipart/form-data">
        <fieldset class=form-add>
            <legend><h3>Adicionar Produto</h3></legend>

            <div class="campo">
                <label for="nome">Nome: </label>
                <input required type="text" id="nome" name="nome">
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
                <label for="descricao">Descrição: </label>
                <textarea name="descricao" id="descricao"></textarea>
            </div>

            <div class="campo">
                <label for="preco">Preço: </label>
                <input required type="number" id="preco" name="preco" min=0>
            </div>

            <div class="campo">
                <label for="estoque">Estoque: </label>
                <input type="number" id="estoque" name="estoque" min=0>
            </div>

            <div class="campo">
                <label for="peso">Peso: </label>
                <input required type="number" id="peso" name="peso" min=0>
            </div>

            <fieldset class="campo">
                <legend for="condicao">Condição: </legend>
                <div>
                    <input required type="radio" value="Novo" id="Novo" name="condicao">
                    <label for="Novo">Novo</label>
                </div>

                <div>
                    <input type="radio" value="Usado" id="Usado" name="condicao">
                    <label for="Usado">Usado</label>
                </div>

                <div>
                    <input type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
                    <label for="Recondicionado">Recondicionado</label>
                </div>
            </fieldset>

            <div class="campo">
                <label for="img" accept="image/*">Imagem do Produto</label>
                <input type="file" name="img">
            </div>

            <div class="campo">
                <div>
                    <input type="checkbox" id="frete" name="frete">
                    <label for="frete">Frete Grátis</label>
                </div>
            </div>

            <div class="campo" id="botoes">
                <input type="reset" id="enviar" value="Limpar">
                <input type="submit" id="resetar" value="Adicionar">
            </div>

        </fieldset>
    </form>
</body>

</html>