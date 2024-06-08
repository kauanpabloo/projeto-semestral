<?php

// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

// obtem o "id" da URL
$id = $_GET["id"];

// ver se há clientes registrados com o id
$sqlSel = "SELECT * FROM cliente WHERE id=$id";
$result = $con->query($sqlSel);

// se tiver executa os comandos abaixo, caso contrario apresenta erro
if ($result->num_rows > 0) {
  // verifica se existem serviços associados a esse cliente
  $sqlServico = "SELECT * FROM servico WHERE ID_CLIENTE=$id";
  $resultServico = $con->query($sqlServico);

  // se houver serviços associados
  if ($resultServico->num_rows > 0) {
    // exclui os serviços associados a esse cliente
    $sqlDelete = "DELETE FROM servico WHERE id_cliente=$id";
    $resultDelete = $con->query($sqlDelete);

    // em seguida exclui o cliente
    $sqlDel = "DELETE FROM cliente WHERE id=$id";
    $resultDel = $con->query($sqlDel);

    // redireciona para a página de consulta de clientes após a exclusão
    header('Location:pag_consu_cliente.php');
  } else {
    // caso não haja serviços associados, exclui apenas o cliente
    $sqlDel = "DELETE FROM cliente WHERE id=$id";
    $resultDel = $con->query($sqlDel);

    // redireciona para a página de consulta de clientes após a exclusão
    header('Location:pag_consu_cliente.php');
  }
} else {
  // o erro apresentado
  echo "Cliente não encontrado." . $con->error;
  // botão voltar para  a pagina de consulta
  echo '<br><a href="pag_consu_cliente.php">Voltar</a>';
}
