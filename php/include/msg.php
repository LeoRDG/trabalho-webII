<?php
require_once __DIR__ . "/../src/util.php";
if ( isset($_SESSION["msg"]) ) {
    $tipo = $_SESSION["msg"]["tipo"];
    $texto = $_SESSION["msg"]["texto"];
    $ttl = $_SESSION["msg"]["ttl"];
    $simbolo = $tipo == "sucesso" ? "check" : "close";

    echo
    " 
    <div class='msg $tipo' ttl='$ttl'>
        <span class='material-symbols-outlined'>$simbolo</span>
        <p>$texto</p>
    </div>
    ";

    unset($_SESSION["msg"]);
}


