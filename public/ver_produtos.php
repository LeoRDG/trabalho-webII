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
    require_once __DIR__ . "/../src/HTML.php";
    // use function HTML\botoes_formulario;
    
    $pagina = ($_GET["pagina"]) ?? 1;
    $filtros = gerar_filtros_get();   
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
            <?php require "modulos/filtros_produtos.php"; ?>
        </div>
        <?php botoes_formulario("Limpar", "Buscar", "resetar", "enviar"); ?>
    </form>

    <div class="main">
        <div id="tabela">
            <a href="adicionarproduto.php">Novo Produto</a>
            <?php 
            info_paginacao($total_filtro, $total, $inicio, $fim);
            links_paginacao($pagina, $pag_max, $qtd_btn, $filtros);
            ?>

            <table>
                <?php cabecalho_tabela_produtos(); ?>

                <tbody>
                    <?php 
                    foreach ($produtos as $p) {
                        linha_tabela_produto($p);
                    }
                    ?>
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