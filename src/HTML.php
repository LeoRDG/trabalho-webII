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

/**
 * Gera links de paginação
 */
function links_paginacao(int $pagina_atual, int $pag_max, int $qtd_btn, array $filtros = []): void {
    for ($i = $pagina_atual - $qtd_btn; $i <= $pagina_atual + $qtd_btn; $i++) {
        if ($i <= 0 || $i > $pag_max) continue;
        $url = gerar_paginacao_url($i, $filtros);
        echo "<a href='$url'>$i</a>";
    }
}

/**
 * Gera informações de paginação (ex: "30 de 100 Produtos encontrados (1-30)")
 */
function info_paginacao(int $total_filtro, int $total, int $inicio, int $fim): void {
    echo "<p>" . $total_filtro . " de " . $total . " Produtos encontrados (" . ($inicio + 1) . "-" . $fim . ")</p>";
}

?>
