<!DOCTYPE html>

<head>
    <?php require_once __DIR__ . "/modulos/head.php" ?>
    <link rel="stylesheet" href="style/detalhes.css">
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
    <main>
        <form action="alterar.php" method="POST" enctype="multipart/form-data">
            <div class="campo">
                <label for="id">ID: </label>
                <input readonly class="static" required type="text" id="id" name="id" value="<?= $id ?>">
            </div>

            <div class="campo">
                <label for="nome">Nome: </label>
                <input disabled required type="text" id="nome" name="nome" value="<?= $p->nome ?>">
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input disabled list="marcas" name="marca" id="marca" value="<?= $p->marca ?>">
                <datalist id="marcas">
                    <?php foreach (Produto::marcas() as $m): ?>
                        <option value=<?= $m ?>>
                        <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input disabled list="categorias" name="categoria" id="categoria" value="<?= $p->categoria ?>">
                <datalist id="categorias">
                    <?php foreach (Produto::marcas() as $c): ?>
                        <option value=<?= $c ?>>
                        <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="descricao">Descrição: </label>
                <textarea disabled name="descricao" id="descricao"><?= $p->descricao ?></textarea>
            </div>

            <div class="campo">
                <label for="preco">Preço: </label>
                <input disabled required type="number" id="preco" name="preco" min=0 value="<?= $p->preco ?>">
            </div>

            <div class="campo">
                <label for="estoque">Estoque: </label>
                <input disabled type="number" id="estoque" name="estoque" min=0 value="<?= $p->estoque ?>">
            </div>

            <div class="campo">
                <label for="peso">Peso: </label>
                <input disabled required type="number" id="peso" name="peso" min=0 value="<?= $p->peso ?>">
            </div>

            <fieldset class="campo condicao">
                <legend for="condicao">Condição: </legend>
                <?php $checked = ($p->condicao === "Novo") ? "checked" : "" ?>
                <label for="Novo">
                    <input disabled required <?= $checked ?> type="radio" value="Novo" id="Novo" name="condicao">
                    Novo
                </label>

                <?php $checked = ($p->condicao === "Usado") ? "checked" : "" ?>
                <label for="Usado">
                    <input disabled <?= $checked ?> type="radio" value="Usado" id="Usado" name="condicao">
                    Usado
                </label>

                <?php $checked = ($p->condicao === "Recondicionado") ? "checked" : "" ?>
                <label for="Recondicionado">
                    <input disabled <?= $checked ?> type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
                    Recondicionado
                </label>
            </fieldset>

            <div class="campo check">
                <?php $checked = ($p->frete_gratis) ? "checked" : "" ?>
                <label for="frete">
                    <input disabled $checked type="checkbox" id="frete" name="frete">
                    Frete Grátis
                </label>
            </div>

            <div class="campo">
                <label for="criado_em"> Criado em</label>
                <input class="static" disabled type="date" id="criado_em" name="criado_em" value="<?= $p->criado_em ?>">
            </div>

            <div class="campo">
                <?php $data = date_format($p->modificado_em, "d/m/Y h:i:s") ?>
                <label for="modificado_em">Modificado em</label>
                <input class="static" disabled type="text" id="modificado_em" name="modificado_em" value="<?= $data ?>">
            </div>

            <div class="campo" id="botoes">
                <input class="static" type="reset" id="enviar" value="Resetar">
                <input disabled type="submit" id="resetar" value="Atualizar">
            </div>
        </form>
    </main>
</body>