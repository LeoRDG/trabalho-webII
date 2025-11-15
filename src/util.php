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
function gerar_paginacao_url(string $pagina_num, array $filtros=[]){
    $params = ["pagina" => $pagina_num];
    foreach ($filtros as $chave => $valor) {
        if ( !$valor || !in_array($chave, FILTROS_GET_PERMITIDOS) ) continue;
        $params[$chave] = $valor;
    }
    return url("", $params);
}

function gerar_filtros_get(): array{
    // $pagina = $_GET["pagina"] ?? 1;
    // $filtros = ["pagina" => $pagina];
    
    foreach  ($_GET as $chave => $valor) {
        if (!in_array($chave, FILTROS_GET_PERMITIDOS)) continue;
        $filtros[$chave] = $valor;
    }

    return $filtros;
}

?>