<?php
require_once __DIR__ . "/util.php";

/**
 * Cria um input HTML baseado no tipo especificado
 */
function criar_input($tipo, $nome, $label, $modo="", $valor="", $opcoes=[]) {
    echo "<div class='campo $nome'>";
    if ($tipo !== "radio" && $tipo !== "checkbox") echo "<label>$label</label>";
    
    $desativado = ($modo === "edit") ? "disabled" : "";

    // Se for um filtro para numeros ou datas, criar dois inputs um para min e outro para max
    if ( $modo === "filtro" && ($tipo === "number" || $tipo === "date") ) {
        echo "<div class='intervalo'>";
        echo "<input type='$tipo' value='$valor[0]' name='{$nome}_min' placeholder='Min'>";
        echo "<input type='$tipo' value='$valor[1]' name='{$nome}_max' placeholder='Max'>";
        echo "</div>";
    } 
    else if ($tipo === "lista") {
        echo "<input $desativado list='$nome' name='$nome' value='$valor'>"; 
        echo "<datalist name='$nome' id='$nome'>";
        foreach ($opcoes as $opc) echo "<option>$opc</option>";
        echo "</datalist>";
    } 
    else if ($tipo === "textarea") {
        echo "<textarea $desativado name='$nome' id='$nome'>$valor</textarea>";
    }
    else if ($tipo === "radio") {
        echo "<fieldset>";
        echo "<legend>$label</legend>";
        foreach ($opcoes as $opc) {
            $checked = ($opc === $valor) ? "checked" : "";
            echo "<input $desativado type='$tipo' id='$opc' name='$nome' value=$opc $checked></input>";
            echo "<label for='$opc'>$opc</label>";
        }
        echo "</fieldset>";
    }
    else if ($tipo === "checkbox") {
        $checked = ($valor) ? "checked" : "";
        echo "<input $checked $desativado type='$tipo' id='$nome' name='$nome'></input>";
        echo "<label for='$nome'>$label</label>";
    }
    else {
        echo "<input $desativado type='$tipo' value='$valor' name='$nome'>";
    }
    echo "</div>";
}

/**
 * 
 */
function criar_filtros_inputs($filtros=[]){
    $nome = ($filtros["nome"]) ?? "";
    $marca = ($filtros["marca"]) ?? "";
    $categoria = ($filtros["categoria"]) ?? "";

    $preco = [
        $filtros["preco_min"] ?? "",
        $filtros["preco_max"] ?? ""
    ];

    $estoque = [
        $filtros["estoque_min"] ?? "",
        $filtros["estoque_max"] ?? ""
    ];

    $criado_em = [
        $filtros["criado_em_min"] ?? "",
        $filtros["criado_em_max"] ?? ""
    ];

    criar_input("text", "nome", "Nome", "filtro", $nome);
    criar_input("lista", "marca", "Marca", "filtro", $marca, Produto::marcas());
    criar_input("lista", "categoria", "Categoria", "filtro", $categoria, Produto::categorias());
    criar_input("number", "preco", "Preco", "filtro", $preco);
    criar_input("number", "estoque", "Estoque", "filtro", $estoque);
    criar_input("date", "criado_em", "Criado entre", "filtro", $criado_em);
}

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
