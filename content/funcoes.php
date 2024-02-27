<?php
function verificarAutenticacao() {
    session_start();
    if (!isset($_SESSION['USERNAME']) || !isset($_SESSION['nivel_acesso'])) {
        header("Location: ../index.html");
        exit();
    }
}

?>
