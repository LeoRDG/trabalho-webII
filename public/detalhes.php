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
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="nome">Nome: </label>
                <input disabled required type="text" id="nome" name="nome" value="<?= $p->nome ?>">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="marca">Marca: </label>
                <input disabled list="marcas" name="marca" id="marca" value="<?= $p->marca ?>">
                <small class="erro" hidden></small>
                <datalist id="marcas">
                    <?php foreach (Produto::marcas() as $m): ?>
                        <option value=<?= $m ?>>
                        <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="categoria">Categoria: </label>
                <input disabled list="categorias" name="categoria" id="categoria" value="<?= $p->categoria ?>">
                <small class="erro" hidden></small>
                <datalist id="categorias">
                    <?php foreach (Produto::marcas() as $c): ?>
                        <option value=<?= $c ?>>
                        <?php endforeach ?>
                </datalist>
            </div>

            <div class="campo">
                <label for="descricao">Descrição: </label>
                <textarea disabled name="descricao" id="descricao"><?= $p->descricao ?></textarea>
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="preco">Preço: </label>
                <input disabled required type="number" id="preco" name="preco" min="0" step="0.01" value="<?= $p->preco ?>">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="estoque">Estoque: </label>
                <input disabled required type="number" id="estoque" name="estoque" min="0" value="<?= $p->estoque ?>">
                <small class="erro" hidden></small>
            </div>

            <div class="campo">
                <label for="peso">Peso (g): </label>
                <input disabled required type="number" id="peso" name="peso" min="0" step="0.1" value="<?= $p->peso ?>">
                <small class="erro" hidden></small>
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
                <small class="erro"></small>
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
                <input class="static" type="reset" id="resetar" value="Resetar">
                <input disabled type="submit" id="enviar" value="Atualizar">
            </div>
        </form>
    </main>
</body>