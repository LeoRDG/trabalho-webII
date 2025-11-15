<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $titulo = "Ver Produtos";
    require_once __DIR__ . "/modulos/head.php";
    ?>
    <link rel="stylesheet" href="style/tabela_produtos.css">
</head>

<body>

    <?php
    require_once __DIR__ . "/modulos/menu.php";
    require_once __DIR__ . "/../src/Produto.php";
    require_once __DIR__ . "/../src/util.php";
    $tamanho = 30;
    $total = Produto::quantidade_total();
    $total_filtro = Produto::quantidade_total($filtros);
    $pag_max = ceil($total_filtro / $tamanho);
    $inicio = ($pagina-1)*$tamanho;
    $fim = ($pagina == $pag_max ) ? $total_filtro : $inicio + $tamanho;
    $produtos = Produto::get_produtos($inicio, $tamanho, $filtros);
    $qtd_btn = 4;
    ?>

    <form action="">
        <div class="filtros">
            <?php 
                criar_input("text", "nome", "Nome", "filtro", $filtros["nome"]);
                criar_input("lista", "marca", "Marca", "filtro", $filtros["marca"], Produto::marcas());
                criar_input("lista", "categoria", "Categoria", "filtro", $filtros["categoria"], Produto::categorias());
                criar_input("number", "preco", "Preco", "filtro", $filtros["preco"]);        
                criar_input("number", "estoque", "Estoque", "filtro", $filtros["estoque"]);
                criar_input("date", "criado_em", "Criado entre", "filtro", $filtros["criado_em"]);
            ?>
        </div>
        <div class="" id="botoes">
                <input type="reset" id="resetar" value="Limpar">
                <input type="submit" id="enviar" value="Buscar">
        </div>
    </form>

    <div class="main">
        <div id="tabela">
            <a href="adicionarproduto.php">Novo Produto</a>
            <p><?= $total_filtro . " de " . $total ." Produtos encontrados (" . $inicio+1 . "-" . $fim . ")"?></p>

            <?php
            for ($i=$pagina-$qtd_btn; $i<=$pagina+$qtd_btn; $i++) {
                if ($i > 0 && $i <=$pag_max) {
                    $params = "pagina=$i";
                    foreach ($filtros as $k => $v) {
                        if (!$v || !$v[0] && !$v[1]) continue;
                        if (in_array($k, ["preco", "estoque", "criado_em"])) {
                            $params .= "&{$k}_min=$v[0]";
                            $params .= "&{$k}_max=$v[1]";
                        }
                        else {
                            $params .= "&$k=$v";
                        }
                    }
                    echo "<a href='?$params'> $i </a>";
                }
            } 
            ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($produtos as $p): ?>
                        <tr>
                            <td class="atributo" id="id"><?= $p->id ?> </td>
                            <td class="atributo" id="nome"><?= $p->nome ?> </td>
                            <td class="atributo" id="preco"><?= $p->preco ?> </td>
                            <td class="atributo" id="categoria"><?= $p->categoria ?> </td>
                            <td class="atributo" id=""><a href="detalhes.php?pid=<?=$p->id?>" class="material-symbols-outlined">visibility</a ></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- <div id="detalhes">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium aperiam libero, non explicabo, nulla vel, eum quisquam ea mollitia inventore porro sapiente. Corporis quibusdam quo sequi libero dolore quisquam laborum.
            Tempora, autem quo repellat fuga tenetur ea hic, ullam architecto sequi molestias voluptate? Voluptate fuga necessitatibus sed dolorem culpa nobis vero delectus placeat blanditiis iste incidunt, alias, quis, asperiores nisi!
            Ducimus assumenda ab aliquid neque delectus eum officiis adipisci earum magnam sunt, temporibus amet tempore labore, doloremque veniam tenetur magni quo maxime similique hic! Qui architecto voluptates veritatis pariatur repellendus?
            Veritatis magnam consequatur suscipit optio, nam quidem sapiente ab iusto quod, impedit sunt itaque excepturi accusantium repellendus ea unde repellat sit magni voluptatibus eveniet molestiae! Ad doloribus necessitatibus quo eum?
            Odit alias quam vero vitae tenetur, nihil doloribus minima voluptatum, consequatur, dignissimos nostrum. Tempore quibusdam fugit, maxime consequatur deserunt rem numquam suscipit commodi quos quia autem similique veritatis. Beatae, a!
            Perferendis magnam facere voluptate tenetur labore. Optio laudantium facilis minima assumenda? Officia, corporis. Iste sapiente doloremque sequi recusandae incidunt in possimus. Minima, nisi nemo rem voluptas porro ex dolorum mollitia!
            Nulla atque officiis minima iste, magni suscipit, nobis accusamus animi reprehenderit distinctio excepturi ab incidunt ducimus vero itaque autem impedit modi doloremque non cumque sequi. Aspernatur culpa ullam magnam totam.
            Quidem officiis consequatur dicta. Consequatur et voluptatem a voluptatibus pariatur fugit, iure quisquam quos nesciunt repellendus adipisci libero repudiandae! Nulla ab, expedita saepe provident quo maxime id ullam sapiente corrupti?
            Sed sint dolores praesentium blanditiis suscipit totam perferendis reprehenderit at obcaecati sit vero repellat ex consequuntur harum voluptatibus et doloribus esse, atque ipsum ipsam veritatis numquam. Quam alias eum optio.
            Illum, ad porro qui, eius ipsum tempore sapiente laboriosam illo laudantium corporis dolores perspiciatis, asperiores officia. Eius unde fuga vel fugit nesciunt aspernatur nulla, numquam doloremque molestias, consequatur magni illum?</p>
        </div> -->
    </div>

</body>

</html>