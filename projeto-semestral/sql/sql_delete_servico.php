<?php

// inclusão do arquivo de conexão com o banco de dados
include 'conexao.php';

// obtem o "id" da URL
$id = $_GET["id"];

// ver se há serviços registrados com o id
$sqlSel = "SELECT * FROM servico WHERE ordem_servico=$id";
$result = $con->query($sqlSel);

// se tiver executa os comandos abaixo, caso contrário apresenta erro
if ($result->num_rows > 0) {
  // exclui o serviço
  $sqlDel = "DELETE FROM servico WHERE ordem_servico=$id";
  $resultDel = $con->query($sqlDel);

  // verifica se a exclusão foi bem-sucedida
  if ($resultDel === TRUE) {
    // redireciona para a página de consulta de serviços após a exclusão
    header('Location:../pages/pag_consu_servico.php');
  } else {
    // se houve um erro na exclusão, exibe uma mensagem de erro
    echo "Erro ao excluir o serviço: " . $con->error;
    // botão voltar para a página de consulta
    echo '<br><a href="../pages/pag_consu_servico.php">Voltar</a>';
  }
} else {
  // o erro apresentado
  echo "Serviço não encontrado." . $con->error;
  // botão voltar para a página de consulta
  echo '<br><a href="../pages/pag_consu_servico.php">Voltar</a>';
}

?>
