<?php 
session_start();


/**
 * Cria uma mensagem no $_SESSION para ser exibida ao usuario
 * @param string $tipo Tipo da mensagem: sucesso/erro
 * @param string $texto Texto da mensagem
 * @param int $ttl Tempo de vida da mensagem em milissegundos (padrao: 5s)
 */
function set_msg(string $tipo, string $texto, int $ttl=5000): void {
    $_SESSION["msg"] = [
        "tipo" => $tipo,
        "texto" => $texto,
        "ttl"=> $ttl,
    ];
}


/**
 * Gera a url para os botoes para ir para proxima pagina
 * @param string $pagina_num O numero da página
 * @param array $filtros Os filtros para pesquisar produtos
 * 
 */
function gerar_paginacao_url(string $pagina_num, array $filtros=[]): string{
    $params = ["pagina" => $pagina_num];
    foreach ($filtros as $chave => $valor) {
        if ( !$valor || !in_array($chave, Produto::FILTROS_PERMITIDOS) ) continue;
        $params[$chave] = $valor;
    }
    return "ver_produtos.php?" . http_build_query($params);
}


/**
 * Redireciona para outra pagina
 * Se a URL nao for informada, tenta usar a pagina anterior ou index.html
 * @param ?string $url URL para redirecionar
 */
function redirecionar(?string $url=null): void{
    $location = $url ?? $_SERVER["HTTP_REFERER"] ?? "index.html";
    header("Location: $location");
    exit;
}


/**
 * Obtem e verifica se o id informado no get é valido
 * @return int ID do produto
 * @throws InvalidArgumentException Se o ID nao for passadp ou se for invalido
 */
function get_id_produto(): int {
    if ( !isset($_GET["pid"]) ) throw new InvalidArgumentException("Informe o ID do produto!");

    $id = $_GET["pid"];

    // Verifica se o ID é numerico
    if (!is_numeric($id)) throw new InvalidArgumentException("ID informado invalido!");

    return $id;
}

?>