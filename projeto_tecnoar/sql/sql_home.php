<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('Location: ../index.html');
    exit();
}

$nomeUsuario = $_SESSION['nome'];
?>