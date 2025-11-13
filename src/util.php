<?php 

function criar_input($tipo, $nome, $label, $modo="", $valor="", $opcoes=[]) {
    echo "<div class='campo $nome'>";
    if ($tipo !== "radio" && $tipo !== "checkbox") echo "<label>$label</label>";
    
    $desativado = ($modo === "edit") ? "disabled" : "";

    // Se for um filtro para numeros ou datas, criar dois inputs um para min e outro para max
    if ( $modo === "filtro" && ($tipo === "number" || $tipo === "date") ) {
        echo "<div class='intervalo'>";
        echo "<input type='$tipo' name='{$nome}_min' placeholder='Min'>";
        echo "<input type='$tipo' name='{$nome}_max' placeholder='Max'>";
        echo "</div>";
    } 
    else if ($tipo === "lista") {
        echo "<input $desativado list='$nome' name='$nome'>"; 
        echo "<datalist name='$nome' id='$nome'>";
        foreach ($opcoes as $opc) echo "<option>$opc</option>";
        echo "</datalist>";
    } 
    else if ($tipo === "textarea") {
        echo "<textarea $desativado name='$nome' id='$nome'></textarea>";
    }
    else if ($tipo === "radio") {
        echo "<fieldset>";
        echo "<legend>$label</legend>";
        foreach ($opcoes as $opc) {
            echo "<input $desativado type='$tipo' id='$opc' name='$nome' value=$opc></input>";
            echo "<label for='$opc'>$opc</label>";
        }
        echo "</fieldset>";
    }
    else if ($tipo === "checkbox") {
        echo "<input $desativado type='$tipo' id='$nome' name='$nome'></input>";
        echo "<label for='$nome'>$label</label>";
    }
    else if ($tipo === "file") {
        echo "<input $desativado type='$tipo' value='$valor' name='$nome'>";
    }
    else {
        echo "<input $desativado type='$tipo' value='$valor' name='$nome'>";
    }
    echo "</div>";
}

?>