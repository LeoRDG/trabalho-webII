<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $titulo = "Ver Produtos";
    require "head.php";
    ?>

<body>

    <?php
    include "menu.php";
    require __DIR__ . "/../src/Produto.php";
    define("TAMANHO", 50);

    $pagina = $_GET["pagina"] ?? 1;
    $total = Produto::quantidade_total();
    $pag_max = ceil($total / TAMANHO);
    $inicio = ($pagina-1)*TAMANHO;
    $fim = ($pagina == $pag_max ) ? $total : $inicio + TAMANHO;
    $produtos = Produto::get_produtos($inicio, TAMANHO);
    $qtd_btn = 4;
    ?>

    <form action="">
        <div class="filtros">
            <?php 
                criar_input("text", "nome", "Nome", "filtro");            
                criar_input("text", "marca", "Marca", "filtro");            
                criar_input("text", "categoria", "Categoria", "filtro");            
                criar_input("number", "preco", "Preco", "filtro");            
            ?>
        </div>
        <div class="" id="botoes">
                <input type="reset" id="enviar" value="Limpar">
                <input type="submit" id="resetar" value="Buscar">
        </div>
    </form>

    <div>
        <a href="adicionarproduto.php">Novo Produto</a>
        <p><?= "Mostrando " . count($produtos) . " de " . $total ." Produtos (" . $inicio+1 . "-" . $fim . ")"?></p>

    <?php
    for ($i=$pagina-$qtd_btn; $i<=$pagina+$qtd_btn; $i++) {
        if ($i > 0 && $i <=$pag_max) {
            echo "<a href='?pagina=$i'> $i </a>";
        }
    } 
    
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Categoria</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p->id ?> </td>
                    <td><?= $p->nome ?> </td>
                    <td><?= $p->preco ?> </td>
                    <td><?= $p->estoque ?> </td>
                    <td><?= $p->categoria ?> </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>

</body>

</html>