<?php

// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

// requisição de dados
$nome = $_GET["nome"];
$cpf = $_GET["cpf"];
$celular = $_GET["celular"];
$data = $_GET["data"];

// verifica se o CPF já existe no banco de dados
$sqlSel = "SELECT * FROM cliente WHERE cpf = '$cpf'";
$result = $con->query($sqlSel);

// se existe acusa que ele já existe, caso contrario registra no bd
if ($result->num_rows > 0) {
  // se o CPF já existe, exibe uma mensagem indicando isso
  echo "CPF já existe no banco de dados.";
} else {
  // se o CPF não existe, insere os dados no banco
  $sqlIns = "INSERT INTO cliente(nome, cpf, celular, data_c) VALUES ('$nome', '$cpf', '$celular', '$data')";

  // confirma se o comando foi executado com sucesso 
  if ($con->query($sqlIns) === TRUE) {
    // se a inserção foi bem-sucedida, exibe uma mensagem indicando sucesso
    echo "Dados inseridos com sucesso!";
  } else {
    // se houve um erro na inserção, exibe uma mensagem de erro
    echo "Erro no registro de dados: " . $con->error;
    // botão voltar para  a pagina de cadastro
    echo '<br><a href="pag_cadas_cliente.php">Voltar</a>';
  }
}
