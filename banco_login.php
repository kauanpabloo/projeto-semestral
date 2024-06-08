<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'sql/conexao.php';

    $con = mysqli_connect($servidor, $username, $password, $database);

    if (!$con) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = mysqli_prepare($con, "SELECT id, senha, status, nome FROM cadastro WHERE email = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $senha_hash, $status, $nome);

        if (mysqli_stmt_fetch($stmt)) {
            if ($status === 'aprovado') {
                if (password_verify($senha, $senha_hash)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $nome; // Armazenar o nome na sessão
                    echo "success"; // Resposta de sucesso
                } else {
                    echo "Senha incorreta.";
                }
            } elseif ($status === 'pendente') {
                echo "Sua conta está pendente de aprovação pelo administrador.";
            } elseif ($status === 'rejeitado') {
                echo "Sua conta foi rejeitada. Entre em contato com o suporte.";
            }
        } else {
            echo "Email não encontrado.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
