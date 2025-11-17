<?php
require_once __DIR__ . "/util.php";

/**
 * Exibe uma mensagem de sucesso
 */
function mensagem_sucesso(string $mensagem, string $id = "sucesso"): void {
    echo "<p id='$id'>$mensagem</p>";
}

/**
 * Exibe uma mensagem de erro
 */
function mensagem_erro(string $mensagem, string $id = "erro"): void {
    echo "<p id='$id'>$mensagem</p>";
}

?>
