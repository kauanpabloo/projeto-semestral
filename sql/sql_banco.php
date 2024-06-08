<?php

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($i = 9; $i < 11; $i++) {
        $soma = 0;
        for ($j = 0; $j < $i; $j++) {
            $soma += $cpf[$j] * (($i + 1) - $j);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$i] != $digito) {
            return false;
        }
    }
    return true;
}

function normalizarCPF($cpf) {
    return preg_replace('/[^0-9]/', '', $cpf);
}

if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    
    include '../sql/conexao.php';

    $con = mysqli_connect($servidor, $username, $password, $database);

    if (!$con) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    $msg = "";

    $nome = $_POST["nome"];
    $cpf = normalizarCPF($_POST["cpf"]);
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $repeticao_senha = $_POST["repeticao_senha"];
    $status = 'pendente';
    $verification_code = bin2hex(random_bytes(16));

    $stmt = mysqli_prepare($con, "SELECT cpf FROM cadastro WHERE cpf = ?");
    mysqli_stmt_bind_param($stmt, 's', $cpf);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $msg = "CPF já cadastrado.";
    } else {
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
            $msg = "Apenas letras são permitidas no campo 'Nome'.";
        } elseif (!validarCPF($cpf)) {
            $msg = "CPF inválido.";
        } elseif ($senha !== $repeticao_senha) {
            $msg = "As senhas não coincidem.";
        } else {
            try {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($con, "INSERT INTO cadastro (nome, cpf, email, senha, status, verification_code) VALUES (?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'ssssss', $nome, $cpf, $email, $senha_hash, $status, $verification_code);

                if (mysqli_stmt_execute($stmt)) {
                    $msg = "Dados cadastrados com sucesso! Sua conta está pendente de aprovação.";
                    header('Location: ../index.html');
                } else {
                    $msg = "Erro ao cadastrar! Este email já está em uso.";
                }

                mysqli_stmt_close($stmt);
            } catch (Exception $e) {
                $msg = "Erro durante o cadastro: " . $e->getMessage();
            }
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);

    mysqli_close($con);
} else {
    echo "Ação inválida.";
}
?>
