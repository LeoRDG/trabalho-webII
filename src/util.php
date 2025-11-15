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
        // Se o valo r for vazio, skippar
        if (!$valor || !$valor[0] && !$valor[1]) continue;

        // Se a chave for uma dessas, criar uma chave composta 
        if (in_array($chave, ["preco", "estoque", "criado_em"])) {
            $params["{$chave}_min"] = $valor[0];
            $params["{$chave}_max"] = $valor[1];
        }
        else {
            $params[$chave] = $valor;
        }
    }
    return url("", $params);
}

function gerar_filtros_get(): array{
    $pagina = $_GET["pagina"] ?? 1;
    $filtros = ["pagina" => $pagina];
    
    foreach  ($_GET as $chave => $valor) {
        if (!in_array($chave, FILTROS_GET_PERMITIDOS)) continue;
        $filtros[$chave] = $valor;
    }

    return $filtros;
}

?>