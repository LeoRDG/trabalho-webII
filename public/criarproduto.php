<?php 

require __DIR__."/../src/Produto.php";

$produto = new Produto($_POST);

$produto->insert();
