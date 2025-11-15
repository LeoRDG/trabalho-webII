<?php 

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
        $checked = ($valor != 0) ? "checked" : "";
        echo "<input $checked $desativado type='$tipo' id='$nome' name='$nome'></input>";
        echo "<label for='$nome'>$label</label>";
    }
    else {
        echo "<input $desativado type='$tipo' value='$valor' name='$nome'>";
    }
    echo "</div>";
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
 * Gera os botões de formulário (reset e submit)
 */
function botoes_formulario(string $texto_reset = "Limpar", string $texto_submit = "Enviar", string $id_reset = "resetar", string $id_submit = "enviar"): void {
    echo "<div class='campo' id='botoes'>";
    echo "<input type='reset' id='$id_reset' value='$texto_reset'>";
    echo "<input type='submit' id='$id_submit' value='$texto_submit'>";
    echo "</div>";
}

/**
 * Gera links de paginação
 */
function links_paginacao(int $pagina_atual, int $pag_max, int $qtd_btn, array $filtros = []): void {
    require_once __DIR__ . "/util.php";
    
    for ($i = $pagina_atual - $qtd_btn; $i <= $pagina_atual + $qtd_btn; $i++) {
        if ($i <= 0 || $i > $pag_max) continue;
        echo "<a href='" . gerar_paginacao_url($i, $filtros) . "'> $i </a>";
    }
}

/**
 * Gera uma linha de tabela de produto
 */
function linha_tabela_produto($produto): void {
    require_once __DIR__ . "/util.php";
    
    echo "<tr>";
    echo "<td class='atributo' id='id'>" . $produto->id . "</td>";
    echo "<td class='atributo' id='nome'>" . $produto->nome . "</td>";
    echo "<td class='atributo' id='preco'>" . $produto->preco . "</td>";
    echo "<td class='atributo' id='categoria'>" . $produto->categoria . "</td>";
    echo "<td class='atributo' id=''><a href=" . \url("detalhes.php", ["pid" => $produto->id]) . " class='material-symbols-outlined'>visibility</a></td>";
    echo "</tr>";
}

/**
 * Gera o cabeçalho de uma tabela de produtos
 */
function cabecalho_tabela_produtos(): void {
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Nome</th>";
    echo "<th>Preço</th>";
    echo "<th>Categoria</th>";
    echo "<th>Detalhes</th>";
    echo "</tr>";
    echo "</thead>";
}

/**
 * Gera informações de paginação (ex: "30 de 100 Produtos encontrados (1-30)")
 */
function info_paginacao(int $total_filtro, int $total, int $inicio, int $fim): void {
    echo "<p>" . $total_filtro . " de " . $total . " Produtos encontrados (" . ($inicio + 1) . "-" . $fim . ")</p>";
}

?>
