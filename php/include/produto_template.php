<?php
require_once __DIR__ . "/../src/Produto.php";
require_once __DIR__ . "/../src/util.php";

$id = get_id_produto();

$p = new Produto(["id" => $id]);

$marcas = isset($_GET["apenas_detalhes"]) ? [] : Produto::marcas();
$categorias = isset($_GET["apenas_detalhes"]) ? [] : Produto::categorias();
$sucesso = $p->carregar();

?>

<div class="campo">
    <label for="id">ID: </label>
    <input readonly class="static" required type="text" id="id" name="id" value="<?= $id ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="nome">Nome: </label>
    <input required type="text" id="nome" name="nome" value="<?= $p->nome ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="marca">Marca: </label>
    <input list="marcas" name="marca" id="marca" value="<?= $p->marca ?>">
    <small class="erro" hidden></small>
    <datalist id="marcas">
        <?php foreach ($marcas as $m): ?>
            <option value=<?= $m ?>>
        <?php endforeach ?>
    </datalist>
</div>

<div class="campo">
    <label for="categoria">Categoria: </label>
    <input list="categorias" name="categoria" id="categoria" value="<?= $p->categoria ?>">
    <small class="erro" hidden></small>
    <datalist id="categorias">
        <?php foreach ($categorias as $c): ?>
            <option value=<?= $c ?>>
        <?php endforeach ?>
    </datalist>
</div>

<div class="campo">
    <label for="descricao">Descrição: </label>
    <textarea name="descricao" id="descricao"><?= $p->descricao ?></textarea>
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="preco">Preço: </label>
    <input required type="number" class="preco" id="preco" name="preco" min="0" step="0.01" value="<?= $p->preco ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="estoque">Estoque: </label>
    <input type="number" id="estoque" name="estoque" min="0" value="<?= $p->estoque ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="peso">Peso (g): </label>
    <input required type="number" id="peso" name="peso" min="0" step="0.1" value="<?= $p->peso ?>">
    <small class="erro" hidden></small>
</div>

<fieldset class="campo condicao">
    <legend for="condicao">Condição: </legend>
    <?php $checked = ($p->condicao === "Novo") ? "checked" : "" ?>
    <label class="container" for="Novo">
        <input required <?= $checked ?> type="radio" value="Novo" id="Novo" name="condicao">
        Novo
    </label>

    <?php $checked = ($p->condicao === "Usado") ? "checked" : "" ?>
    <label class="container" for="Usado">
        <input <?= $checked ?> type="radio" value="Usado" id="Usado" name="condicao">
        Usado
    </label>

    <?php $checked = ($p->condicao === "Recondicionado") ? "checked" : "" ?>
    <label class="container" for="Recondicionado">
        <input <?= $checked ?> type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
        Recondicionado
    </label>
    <small class="condicao erro"></small>
</fieldset>

<div class="campo check">
    <?php $checked = ($p->frete_gratis) ? "checked" : "" ?>
    <label class="container" for="frete">

        <input <?= $checked ?> type="checkbox" id="frete" name="frete_gratis">
        Frete Grátis
    </label>
</div>

<div class="campo">
    <label for="criado_em"> Criado em</label>
    <input class="static" readonly type="date" id="criado_em" name="criado_em" value="<?= $p->criado_em ?>">
</div>

<div class="campo">
    <?php $data = date_format($p->modificado_em, "d/m/Y h:i:s") ?>
    <label for="modificado_em">Modificado em</label>
    <input class="static" readonly type="text" id="modificado_em" name="modificado_em" value="<?= $data ?>">
</div>