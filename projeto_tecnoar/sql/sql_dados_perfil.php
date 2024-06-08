<?php
session_start();
include 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não está logado.']);
    exit();
}

$email = $_SESSION['email']; // Supondo que o email do usuário logado esteja armazenado na sessão

// Consulta SQL para obter os dados do usuário logado com base no email
$sql = "SELECT nome, cpf,  email  FROM cadastro WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $response = ['success' => true, 'data' => $user_data];
} else {
    $response = ['success' => false, 'message' => 'Nenhum dado encontrado para o usuário.'];
}

$stmt->close();
$con->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
