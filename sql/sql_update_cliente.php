<?php

// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

// requisição de dados
$id = $_GET["id"];
$nome = $_GET["nome"];
$cpf = $_GET["cpf"];
$celular = $_GET["celular"];

// instrução SQL de alteração
$sqlUpd = "UPDATE cliente SET nome='$nome', cpf='$cpf', celular='$celular' WHERE id=$id";

// confirma se o comando de atualização foi executado com sucesso
if ($con->query($sqlUpd) === TRUE) {
  // se a atualização foi bem-sucedida, exibe uma mensagem indicando sucesso
  echo "Dados alterados com sucesso!";
  exit(); // encerra o script para evitar a execução de mais código desnecessário
} else {
  // se houve um erro na atualização, exibe uma mensagem de erro
  echo "Erro na alteração de dado";
  // botão voltar para  a pagina de cadastro
  echo '<br><a href="pag_edit_cliente.php">Voltar</a>';
}
