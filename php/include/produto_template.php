<?php
require_once __DIR__ . "/../src/util.php";
require_once __DIR__ . "/../src/Produto.php";
$modo = $modo ?? null;

try {
    $marcas = Produto::marcas();
    $categorias = Produto::categorias();

    if ($modo != "add") {
        $id = get_id_produto();
        $p = new Produto(["id" => $id]);
        $p->carregar();
    }
} 
catch (Exception $e) {
    set_msg("erro", $e->getMessage(), 10000);
    redirecionar("index.php");
}

?>

<?php if ($modo != "add"): ?>
    <div class="campo">
        <label for="id">ID: </label>
        <input readonly class="static" required type="text" id="id" name="id" value="<?= $id ?>">
        <small class="erro" hidden></small>
    </div>
<?php endif ?>

<div class="campo">
    <label for="nome">Nome: </label>
    <input required type="text" id="nome" name="nome" value="<?= $p->nome ?? null ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="marca">Marca: </label>
    <input list="marcas" name="marca" id="marca" value="<?= $p->marca ?? null ?>">
    <small class="erro" hidden></small>
    <datalist id="marcas">
        <?php foreach ($marcas as $m): ?>
            <option value=<?= $m ?>>
        <?php endforeach ?>
    </datalist>
</div>

<div class="campo">
    <label for="categoria">Categoria: </label>
    <input list="categorias" name="categoria" id="categoria" value="<?= $p->categoria ?? null ?>">
    <small class="erro" hidden></small>
    <datalist id="categorias">
        <?php foreach ($categorias as $c): ?>
            <option value=<?= $c ?>>
        <?php endforeach ?>
    </datalist>
</div>

<div class="campo">
    <label for="descricao">Descrição: </label>
    <textarea name="descricao" id="descricao"><?= $p->descricao ?? null ?></textarea>
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="preco">Preço: </label>
    <input required type="number" class="preco" id="preco" name="preco" min="0" step="0.01" value="<?= $p->preco ?? null ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="estoque">Estoque: </label>
    <input type="number" id="estoque" name="estoque" min="0" value="<?= $p->estoque ?? null ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <label for="peso">Peso (kg): </label>
    <input required type="number" id="peso" name="peso" min="0" step="0.1" value="<?= $p->peso ?? null ?>">
    <small class="erro" hidden></small>
</div>

<div class="campo">
    <?php $data = isset($p->vencimento) ? date_format(date_create_from_format("Y-m-d", $p->vencimento), "d/m/Y") : "" ?>
    <label for="vencimento">Data de vencimento: </label>
    <!-- type="date" é muito limitado, entao escolhi type="text" com jquery mask -->
    <input placeholder="" class="data" type="text" id="vencimento" name="vencimento" value="<?= $data ?>">
    <small class="erro" hidden></small>
</div>

<fieldset class="campo condicao">
    <legend for="condicao">Condição: </legend>
    <?php $checked = (isset($p->condicao) && $p->condicao === "Novo") ? "checked" : "" ?>
    <label class="container" for="Novo">
        <input required <?= $checked ?> type="radio" value="Novo" id="Novo" name="condicao">
        Novo
    </label>

    <?php $checked = (isset($p->condicao) && $p->condicao === "Usado") ? "checked" : "" ?>
    <label class="container" for="Usado">
        <input <?= $checked ?> type="radio" value="Usado" id="Usado" name="condicao">
        Usado
    </label>

    <?php $checked = (isset($p->condicao) && $p->condicao === "Recondicionado") ? "checked" : "" ?>
    <label class="container" for="Recondicionado">
        <input <?= $checked ?> type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
        Recondicionado
    </label>
    <small class="condicao erro"></small>
</fieldset>

<div class="campo check">
    <?php $checked = isset($p->frete_gratis) && $p->frete_gratis == 1 ? "checked" : "" ?>
    <label class="container" for="frete">
        <input <?= $checked ?> type="checkbox" id="frete" name="frete_gratis">
        Frete Grátis
    </label>
</div>

<?php if ($modo != "add"): ?>
    <div class="campo">
        <?php $data = date_format($p->criado_em, "d/m/Y H:i:s") ?>
        <label for="criado_em"> Criado em</label>
        <input class="static" readonly type="text" id="criado_em" name="criado_em" value="<?= $data ?>">
    </div>

    <div class="campo">
        <?php $data = date_format($p->modificado_em, "d/m/Y H:i:s") ?>
        <label for="modificado_em">Modificado em</label>
        <input class="static" readonly type="text" id="modificado_em" name="modificado_em" value="<?= $data ?>">
    </div>
<?php endif ?>