<?php

// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';
echo"certo";

// requisição de dados
$idcliente= $_POST["idcliente"];
$placa = $_POST["placa"];
$modelo = $_POST["modelo"];
$ano = $_POST["ano"];
$data_os = $_POST["data_os"];
$valor = $_POST["valor"];
$garantia = $_POST["garantia"];
$forma_pgt = $_POST["forma_pgt"];
$responsavel = $_POST["responsavel"];
$serv_realizado = $_POST["serv_realizado"];

$sqlIns = "INSERT INTO servico(id_cliente, placa_carro, modelo_carro, ano, data_s, valor_serv, forma_pgt, garantia, responsavel, servico_realizado) VALUES ('$idcliente', '$placa', '$modelo', '$ano', '$data_os', '$valor', '$forma_pgt', '$garantia', '$responsavel', '$serv_realizado')";

// confirma se o comando foi executado com sucesso 
if ($con->query($sqlIns) === TRUE) {
    // se a inserção foi bem-sucedida, exibe uma mensagem indicando sucesso     
    echo "Dados da ordem de serviço inseridos com sucesso!";
} else {
    // se houve um erro na inserção, exibe uma mensagem de erro
    echo "Erro no registro de dados: " . $con->error;
    // botão voltar para a pagina de cadastro
    echo '<br><a href="../pages/pag_cadas_servico.php">Voltar</a>';
}