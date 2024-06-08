<?php
// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

if (!empty($_GET['id'])) {

    // requisição de dados
    $ordem_serv = $_GET["id"];
    $status = 'finalizado';
    // instrução SQL de alteração
    $sqlUpd = "UPDATE servico SET status = '$status' WHERE ordem_servico=$ordem_serv";

    // confirma se o comando de atualização foi executado com sucesso
    if ($con->query($sqlUpd) === TRUE) {
        // se a atualização foi bem-sucedida, exibe uma mensagem indicando sucesso
        echo "Ordem de serviço finalizada com sucesso!";
        // redireciona para a página inicio
        header('Location:../pages/pag_inicio.php');
        exit(); // encerra o script para evitar a execução de mais código desnecessário
    } else {
        // se houve um erro na atualização, exibe uma mensagem de erro
        echo "Erro ao finalizar ordem de serviço" . $con->error;
        // botão voltar para  a pagina de cadastro
        echo '<br><a href="../pages/pag_inicio.php">Voltar</a>';
    }
}
