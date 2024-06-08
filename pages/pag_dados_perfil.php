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
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- titulo da pagina (aba) -->
    <title>PS: Dados Pessoais</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css" />

    <!-- Jquery -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

    <div class="container mt-5">
        <h1 class="mb-4">Dados do perfil:</h1>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>NOME:</strong></td>
                    <td id="nome"></td>
                </tr>
                <tr>
                    <td><strong>CPF:</strong></td>
                    <td id="cpf"></td>
                </tr>
                <tr>
                    <td><strong>E-MAIL:</strong></td>
                    <td id="email"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../sql/sql_dados_perfil.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#nome').text(response.data.nome);
                        $('#cpf').text(response.data.cpf);
                        $('#email').text(response.data.email);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>