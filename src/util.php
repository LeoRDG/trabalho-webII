<?php 
include_once "consts.php";

function url(string $url, array $params=[]): string {
    if ( !empty($params) ) $url .= "?" . http_build_query($params);
    return $url;
}

/**
 * Gera a url para os botoes para ir para proxima pagina
 * Inclui na url os parametros dos filtros
 */
function gerar_paginacao_url(string $pagina_num, array $filtros=[]): string{
    $params = ["pagina" => $pagina_num];
    foreach ($filtros as $chave => $valor) {
        if ( !$valor || !in_array($chave, FILTROS_GET_PERMITIDOS) ) continue;
        $params[$chave] = $valor;
    }
    return url("", $params);
}


function redirecionar($url) {
    $location = $url ?? $_SERVER["HTTP_REFERER"] ?? "index.html";
    header("Location: $location");
        
}


function get_id_produto(): int {
    if ( !isset($_GET["pid"]) ) {
        echo ("Informe o ID do produto!");
        exit;
    };

    $id = $_GET["pid"];

    if (!is_numeric($id)) {
        echo ("ID invalido!");
        exit;
    }

    return $id;
}

?>