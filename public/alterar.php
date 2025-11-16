<?php
require_once __DIR__ . "/../src/Produto.php";

$p = new Produto($_POST);

$p->update();

