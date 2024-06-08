<?php
// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

// requisição de dados
$ordem_serv = $_GET["ordem_serv"];
$idcliente = $_GET["idcliente"];
$placa = $_GET["placa"];
$modelo = $_GET["modelo"];
$ano = $_GET["ano"];
$valor = $_GET["valor"];
$forma_pgt = $_GET["forma_pgt"];
$garantia = $_GET["garantia"];
$responsavel = $_GET["responsavel"];
$serv_realizado = $_GET["serv_realizado"];

// instrução SQL de alteração
$sqlUpd = "UPDATE servico SET id_cliente='$idcliente', placa_carro='$placa', modelo_carro='$modelo',ano='$ano', valor_serv='$valor', forma_pgt='$forma_pgt', garantia='$garantia', responsavel='$responsavel', servico_realizado='$serv_realizado' WHERE ordem_servico=$ordem_serv";

// confirma se o comando de atualização foi executado com sucesso
if ($con->query($sqlUpd) === TRUE) {
    // se a atualização foi bem-sucedida, exibe uma mensagem indicando sucesso
    echo "Dados alterados com sucesso!";
    exit(); // encerra o script para evitar a execução de mais código desnecessário
} else {
    // se houve um erro na atualização, exibe uma mensagem de erro
    echo "Erro na alteração de dado: " . $con->error;
    // botão voltar para  a pagina de cadastro
    echo '<br><a href="pag_inicio.php">Voltar</a>';
}
