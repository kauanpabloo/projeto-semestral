<?php

include '../sql/conexao.php';

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
?>


<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- titulo da pagina (aba) -->
  <title>TecnoAr: Nova Ordem de Serviço</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">

  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Jquery -->
  <script src="../assets/js/jquery-3.7.1.min.js"></script>

  <script>
    // Função que faz a requisição de dados para registrar no banco de dados
    function salvar() {
      var json = {}; // Inicializa um objeto JSON vazio

      // Atribui os valores dos campos do formulário ao objeto JSON
      json.idcliente = document.getElementById("idcliente").value;
      json.placa = document.getElementById("placa").value;
      json.modelo = document.getElementById("modelo").value;
      json.ano = document.getElementById("ano").value;
      json.data_os = document.getElementById("data_os").value;
      json.valor = document.getElementById("valor").value;
      json.forma_pgt = document.getElementById("forma_pgt").value;
      json.garantia = document.getElementById("garantia").value;
      json.responsavel = document.getElementById("responsavel").value;
      json.serv_realizado = document.getElementById("serv_realizado").value;

      // Faz uma requisição AJAX para o script "sql_insert_ordem_servico.php" com os dados do objeto JSON
      $.ajax({
        url: "../sql/sql_insert_servico.php",
        data: json,
        type: "POST",
        success: function(resp) {
          // Exibe um alerta com a resposta da requisição
          alert(resp);
          limpar(); // Chama a função para limpar os campos do formulário
        }
      });
    }

    // Função para limpar os campos do formulário (se necessário)
    function limpar() {
      document.getElementsByTagName("form")[0].reset(); // reseta o formulário, limpando os campos
    }

    function converterParaMaiusculas(elemento) {
      elemento.value = elemento.value.toUpperCase();
    }

    document.addEventListener("DOMContentLoaded", function() {
      var today = new Date();
      var day = String(today.getDate()).padStart(2, '0');
      var month = String(today.getMonth() + 1).padStart(2, '0'); // Janeiro é 0
      var year = today.getFullYear();

      var todayFormatted = year + '-' + month + '-' + day;
      document.getElementById('data_os').value = todayFormatted;
    });
  </script>

</head>

<body>
  <!-- navBar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- cores Navbar -->
    <div class="container-fluid">
      <a class="navbar-brand" href="pag_inicio.php">
        <img src="../assets/img/tec-logo.png" height="40" loading="lazy" style="margin-top: -1px;" /> <!-- logo Prime Solutions -->
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
      <div class="col-10">
        <h1>Nova ordem de serviço:</h1><br>
        <div class="row">
          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">ID Cliente:</label> <!-- campo id do cliente -->
              <input id="idcliente" type="text" class="form-control" placeholder="Ex: 000">
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">Placa do veiculo:</label> <!-- campo placa do veiculo -->
              <input id="placa" type="text" maxlength="8" class="form-control" placeholder="Ex: 0000000" oninput="converterParaMaiusculas(this)">
            </div>
          </div>

          <div class="col-md-4">
            <div class="mb-2">
              <label class="form-label">Modelo do veiculo:</label> <!-- campo modelo do veiculo -->
              <input id="modelo" type="text" maxlength="15" class="form-control" placeholder="" oninput="converterParaMaiusculas(this)">
            </div>
          </div>

          <div class="col-md-2">
            <div class="mb-2">
              <label class="form-label">Ano:</label> <!-- campo modelo do veiculo -->
              <input id="ano" type="text" maxlength="4
              " class="form-control" placeholder="" oninput="converterParaMaiusculas(this)">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-2">
            <div class="mb-2">
              <label for="data" class="form-label">Data:</label> <!-- campo data -->
              <input id="data_os" type="date" class="form-control">
            </div>
          </div>

          <div class="col-md-2">
            <div class="mb-2">
              <label class="form-label">Valor:</label> <!-- campo valor -->
              <input id="valor" type="text" maxlength="15" class="form-control" oninput="converterParaMaiusculas(this)">
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">Forma de pagamento:</label> <!-- campo garantia com seleções-->
              <select id="forma_pgt" type="text" class="form-select">
                <option selected>Selecione:</option>
                <option value="1">Dinheiro</option>
                <option value="2">Pix</option>
                <option value="3">Cartão - à vista </option>
                <option value="4">Cartão - 2X </option>
                <option value="5">Cartão - 4X </option>
                <option value="6">Cartão - 6X </option>
                <option value="6">Cartão - 8X </option>
                <option value="6">Cartão - 10X </option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="mb-2">
              <label class="form-label">Garantia:</label> <!-- campo garantia com seleções-->
              <select id="garantia" type="text" class="form-select">
                <option selected>Selecione:</option>
                <option value="1">3 Meses</option>
                <option value="2">30 dias</option>
                <option value="3">6 Meses</option>
                <option value="4">12 Meses</option>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="mb-2">
              <label class="form-label">Responsável:</label> <!-- campo responsável-->
              <input id="responsavel" type="text" maxlength="30" class="form-control" placeholder="Resposável pelo serviço." oninput="converterParaMaiusculas(this)">
            </div>
          </div>

        </div>
        <div class="mb-2">
          <label class="form-label">Descrição:</label> <!-- campo serviço realizado -->
          <textarea id="serv_realizado" type="text" class="form-control" rows="3" placeholder="Breve descrição do serviço realizado." oninput="converterParaMaiusculas(this)"></textarea>
        </div>

        <button type="button" class="btn btn-success" onclick="salvar()">Salvar</button><!-- botão salvar -->
        <a type="button" class="btn btn-danger" href="pag_inicio.php">Voltar</a> <!-- Botão voltar -->

      </div>
      <div class="col"></div>
    </div>
  </div>
  </div>

</body>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

</html>