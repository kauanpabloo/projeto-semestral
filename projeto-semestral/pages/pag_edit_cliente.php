<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: ../index.html");
  exit();
}

$nomeCompleto = $_SESSION['nome'];
$nomePartes = explode(' ', $nomeCompleto);
$nomeCurto = $nomePartes[0];
if (isset($nomePartes[1])) {
  $nomeCurto .= ' ' . $nomePartes[1];
}

if (!empty($_GET['id'])) {

  // inclusão do arquivo de conexão com o banco de dados
  include '../sql/conexao.php';

  // requisiçã do id para puxar os dados
  $id = $_GET['id'];

  //select de todos os dados referente ao id
  $sqlSelect = "SELECT * FROM cliente WHERE id=$id";

  //armazena o resultado do comando
  $result = $con->query($sqlSelect);

  //se a busca resultar em linhas, executa a requisição de dados
  if ($result->num_rows > 0) {

    while ($userdata = mysqli_fetch_assoc($result)) {

      $id = $userdata['ID'];
      $nome = $userdata['NOME'];
      $cpf = $userdata['CPF'];
      $celular = $userdata['CELULAR'];
      $data = $userdata['DATA_C'];
    }
  } else {
    //caso contrario retorna a pagina de consulta
    header('Location: pag_consu_cliente.php');
  }
}


$data_form = date('d/m/Y', strtotime($data));
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- titulo da pagina (aba) -->
  <title>TecnoAr: Editar Dados do Cliente</title>

  <link rel="icon" type="image/png" href="../assets/img/icon.png">

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css" />

  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Jquery -->
  <script src="../assets/js/jquery-3.7.1.min.js"></script>
  <!-- mascara Jquery -->
  <script src="../assets/js/jquery.mask.min.js"></script>

  <!-- aplicação da mascara -->
  <script>
    $(document).ready(function() {
      $('#cpf').mask('000.000.000-00'); // Mascara desejada para "cpf"
      $('#celular').mask('(00) 00000-0000'); // Mascara desejada "celular"
    });
  </script>

  <!-- script JavaScript para realizar uma requisição AJAX para atualizar dados no banco de dados -->
  <script>
    function salvar() {

      // JSON para armazenar os dados a serem enviados
      var json = {};

      // obtém valores dos campos do formulário pelo ID
      json.id = document.getElementById("id").value;
      json.nome = document.getElementById("nome").value;
      json.cpf = document.getElementById("cpf").value;
      json.celular = document.getElementById("celular").value;

      // envia uma requisição AJAX para o script PHP de atualização
      $.ajax({
        // URL do script PHP de atualização
        url: "../sql/sql_update_cliente.php",
        // dados a serem enviados na requisição
        data: json,
        // tipo de requisição (GET, POST, etc.)
        type: "get",
        // função a ser executada em caso de sucesso na requisição
        success: function(resp) {
          // exibe um alerta com a resposta do servidor
          alert(resp);
          window.location.href = "pag_consu_cliente.php";
        }
      });
    }
  </script>

</head>

<body>

  <!-- navBar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- cores Navbar -->
    <div class="container-fluid">
      <a class="navbar-brand" href="pag_inicio.php">
        <img src="../assets/img/tec-logo.png" height="40" loading="lazy" style="margin-top: -1px;" /> <!-- logo TecnoAr -->
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="pag_inicio.php" style="font-size: 20px;">Inicio</a> <!-- botão link inicio -->
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
              Cadastrar
            </a>
            <ul class="dropdown-menu" style="font-size: 18px;">
              <li><a class="dropdown-item" href="pag_cadas_cliente.php">Cliente</a></li> <!-- botão link cadastro cliente e demais (NavBar) -->
              <li><a class="dropdown-item" href="pag_cadas_servico.php">Ordem de Serviço</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
              Consultar
            </a>
            <ul class="dropdown-menu" style="font-size: 18px;">
              <li><a class="dropdown-item" href="pag_consu_cliente.php">Cliente</a></li> <!-- botão link consulta cliente e demais (NavBar) -->
              <li><a class="dropdown-item" href="pag_consu_servico.php">Ordem de Serviço</a></li>
            </ul>
          </li>
        </ul>
        <!-- Dropdown de Sair e Perfil alinhado à direita -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px;">
              <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0' />
                <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1' />
              </svg>
              <?php echo htmlspecialchars($nomeCurto); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" style="font-size: 18px;">
              <li><a class="dropdown-item" href="pag_admin.php">Admin</a></li>
              <li><a class="dropdown-item" href="pag_dados_perfil.php">Perfil</a></li>
              <li><a class="dropdown-item" href="../sql/logout.php">Sair</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>
  <!-- formulario -->
  <div class="container p-5">
    <div class="row">
      <div class="col"></div>
      <div class="col-6">
        <h1>Edição cadastro de clientes:</h1><br>
        <form></form>
        <div class="mb-2">
          <label for="ID" class="form-label">ID:</label> <!-- campo id -->
          <input disabled id="id" type="text" class="form-control" value="<?php echo $id ?>" required> <!-- preenche os dados a partir da variavel -->
        </div>
        <div class="mb-2">
          <label for="nome" class="form-label">Nome:</label> <!-- campo nome -->
          <input id="nome" type="text" class="form-control" value="<?php echo $nome ?>" required> <!-- preenche os dados a partir da variavel -->
        </div>
        <div class="mb-2">
          <label for="cpf" class="form-label">CPF:</label> <!-- campo cpf -->
          <input id="cpf" type="text" maxlength="14" class="form-control" placeholder="Ex: 000.000.000-00" value="<?php echo $cpf ?>" required> <!-- preenche os dados a partir da variavel -->
          <div class="text-formulario">Não há necessidade de digitar pontuação/separadores.</div>
        </div>
        <div class="mb-2">
          <label for="data" class="form-label">Data do Cadastro:</label>

          <input disabled id="data" type="text" class="form-control" value="<?php echo $data_form ?>" required>
        </div>
        <div class="mb-2">
          <label for="celular" class="form-label">Celular:</label> <!-- campo celular -->
          <input id="celular" type="text" maxlength="15" class="form-control" placeholder="(00) 00000-0000" value="<?php echo $celular ?>" required> <!-- preenche os dados a partir da variavel -->
          <div class="text-formulario">Não há necessidade de digitar pontuação/separadores.</div>
        </div>
        <button type="button" class="btn btn-success" onclick="salvar()"> Salvar</button> <!-- botão salvar -->
        <a type="button" class="btn btn-danger" href="pag_consu_cliente.php"> Voltar</a> <!-- botão voltar -->
        </form>
      </div>
      <div class="col"></div>
    </div>
  </div>

</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

</html>