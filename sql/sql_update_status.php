<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'conexao.php';

    $con = mysqli_connect($servidor, $username, $password, $database);

    if (!$con) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action == 'aprovar') {
        $stmt = mysqli_prepare($con, "UPDATE cadastro SET status = 'aprovado' WHERE id = ?");
    } elseif ($action == 'rejeitar') {
        $stmt = mysqli_prepare($con, "UPDATE cadastro SET status = 'rejeitado' WHERE id = ?");
    }

    mysqli_stmt_bind_param($stmt, 'i', $userId);
    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "error";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
