<?php 

require __DIR__."/../src/Produto.php";

$produto = new Produto($_POST);


if ( isset($_FILES["img"]) ) {
    // Gera um nome para a imagem com um id unico, mantendo a extensao do nome original
    $img = preg_replace("/.+(\..+)/", uniqid("i", true).'$1', $_FILES["img"]["name"]);
    $produto->imagem = $img;

    // Move a imagem para a pasta de imagens
    move_uploaded_file($_FILES["img"]["tmp_name"], __DIR__."/../images/$img");
}

// Insere o produto no banco
$id = $produto->insert();

// Redireciona para a para a pagina de adicionarproduto com o id de insercao
header("Location: adicionarproduto.php?sucesso=$id");
