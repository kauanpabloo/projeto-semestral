<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // arquivo de conexão com o banco de dados
    include 'sql/conexao.php';

    // conexão com o banco de dados
    $con = mysqli_connect($servidor, $username, $password, $database);

    // verifica se houve falha na conexão
    if (!$con) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // obtém os valores dos campos 'email' e 'senha' do formulário POST
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // prepara uma consulta SQL para selecionar dados da tabela cadastro com a partir do email
    $stmt = mysqli_prepare($con, "SELECT id, senha, status, nome FROM cadastro WHERE email = ?");

    // verifica se a preparação da consulta deu certo, se der acessa conta, caso contrario informa o que ocoreu
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $senha_hash, $status, $nome);

        if (mysqli_stmt_fetch($stmt)) {
            // verifica o status da conta
            if ($status === 'aprovado') {
                if (password_verify($senha, $senha_hash)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['nome'] = $nome;
                    echo "success";
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
        // fecha a declaração SQL
        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da consulta: " . mysqli_error($con);
    }

    // fecha a conexão com o banco de dados
    mysqli_close($con);
}
