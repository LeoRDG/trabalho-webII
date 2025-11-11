<!-- TODO Definir quais campos sao required -->

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    $titulo = "Adicionar Produto";
    require "head.php";
    ?>
<body>
    <?php require "menu.php" ?>
    <?php 
        require __DIR__."/../src/Produto.php";
        $categorias = Produto::categorias();
        $marcas = Produto::marcas();
    ?>

    <form action="criarproduto.php" method="POST">
        <p>Cadastrar Produto</p>
        <div>
            <label for="nome">Nome: </label>
            <input required type="text" id="nome" name="nome">
        </div>

        <div>
            <label for="marca">Marca: </label>
            <input list="marcas" name="marca" id="marca">
            <datalist id="marcas">

                <?php foreach ($marcas as $m): ?>
                    <option value=<?= $m ?>>
                <?php endforeach ?>

            </datalist>
        </div>

        <div>
            <label for="categoria">Categoria: </label>
            <input list="categorias" name="categoria" id="categoria">
            <datalist id="categorias">

                <?php foreach ($categorias as $c): ?>
                    <option value=<?= $c ?>>
                <?php endforeach ?>
                
            </datalist>
        </div>

        <div>
            <label for="descricao">Descrição: </label>
            <textarea name="descricao" id="descricao"></textarea>
        </div>

        <div>
            <label for="preco">Preço: </label>
            <input required type="number" id="preco" name="preco" min=0>
        </div>

        <div>
            <label for="estoque">Estoque: </label>
            <input type="number" id="estoque" name="estoque" min=0>
        </div>

        <div>
            <label for="peso">Peso: </label>
            <input required type="number" id="peso" name="peso" min=0>
        </div>

        <div>
            <label for="condicao">Condição: </label>
                <input required type="radio" value="Novo" id="Novo" name="condicao">
                <label for="Novo">Novo</label>

                <input type="radio" value="Usado" id="Usado" name="condicao">
                <label for="Usado">Usado</label>

                <input type="radio" value="Recondicionado" id="Recondicionado" name="condicao">
                <label for="Recondicionado">Recondicionado</label>
        </div>
        
        <div>
            <label for="frete">Frete Grátis: </label>
            <input type="checkbox" id="frete" name="frete">
        </div>
        
        <input type="submit" value="Adicionar">
    </form>
    
</body>
</html>