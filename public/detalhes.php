<!DOCTYPE html>

<head>
    <?php require_once __DIR__ . "/modulos/head.php" ?>
</head>

<body>
    <?php
    require_once __DIR__ . "/../src/Produto.php";
    require_once __DIR__ . "/../src/HTML.php";
    require_once __DIR__ . "/../src/util.php";
    require_once __DIR__ . "/modulos/menu.php";

    $id = get_id_produto();

    $p = new Produto(["id" => $id]);
    $sucesso = $p->carregar();

    if (!$sucesso) {
        mensagem_erro("ID nao existe na tabela!");
        exit;
    }; ?>

    <button id='edit'>Editar</button>

    <form action="alterar.php" method="POST" enctype="multipart/form-data">
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
            <div>
                <input type="checkbox" id="frete" name="frete">
                <label for="frete">Frete Grátis</label>
            </div>
        </div>

        <div class="campo">
            <div>
                <label for="criado_em"> Criado em</label>
                <input type="date" id="criado_em" name="criado_em">
            </div>
        </div>

        <div class="campo">
            <div>
                <label for="modificado_em">Modificado em</label>
                <input type="date" id="modificado_em" name="modificado_em">
            </div>
        </div>

        <div class="campo" id="botoes">
            <input type="reset" id="enviar" value="Limpar">
            <input type="submit" id="resetar" value="Adicionar">
        </div>
</body>