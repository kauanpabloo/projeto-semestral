<?php

// inclusão do arquivo de conexão com o banco de dados
include '../sql/conexao.php';

// verifica se há dados armazenados, se houver realiza o comando de selec no banco de dados, caso contrario puxa tudo que há resgistrado.
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM cliente WHERE id LIKE '%$data%' OR cpf LIKE '%$data%' OR nome LIKE '%$data%' OR celular LIKE '%$data%'";
    $result = $con->query($sql);
} else {
    $sql = "SELECT * FROM cliente";
    $result = $con->query($sql);
}

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
    <title>TecnoAr: Consulta de Clientes</title>
    
    <link rel="icon" type="image/png" href="../assets/img/icon.png">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css" />

    <!-- Jquery -->
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
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
    <!-- tabela + campo de busca -->
    <div class="row p-2">
        <div class="col"></div>
        <div class="col-8">
            <!-- caixa de pesquisa -->
            <div class="col-6">
                <br>
                <h1>Consultar clientes:</h1>
                <br>
                <div class="caixa-pesquisa">
                    <!-- campo de pesquisa -->
                    <input type="search" class="form-control w-30" placeholder="Digite algum dado utilizado no cadastro para efetuar a busca." id="pesquisa">
                    <!-- botão de pesquisa -->
                    <button onclick="consulta()" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- informação adicional -->
            <div class="text-formulario">Necessário incluir pontuação/separadores em CPF e número celular.</div>
            <br>
            <!-- tabela para exibir resultados -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <!-- cabeçalho da tabela -->
                    <tr>
                        <th scope="col" class="col1">ID</th>
                        <th scope="col" class="col4">NOME</th>
                        <th scope="col" class="col3">CPF</th>
                        <th scope="col" class="col2">DATA DO CADASTRO</th>
                        <th scope="col" class="col3">CELULAR</th>
                        <th scope="col" class="col1">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // loop para exibir as linhas da tabela com resultados
                    while ($userdata = mysqli_fetch_assoc($result)) {

                        // formatação da data
                        $data_form = date("d/m/Y", strtotime($userdata['DATA_C']));

                        // exibição de cada linha
                        echo "<tr>";
                        echo "<td class='center-text'>" . sprintf('%03d', $userdata['ID']) . "</td>"; // Formatando o ID com zeros à esquerda
                        echo "<td>" . $userdata['NOME'] . "</td>";
                        echo "<td class='center-text'>" . $userdata['CPF'] . "</td>";
                        echo "<td class='center-text'>" . $data_form . "</td>";
                        echo "<td class='center-text'>" . $userdata['CELULAR'] . "</td>";
                        // botões de ação (Editar e Excluir)
                        echo "<td class='center-text'>
                        <a class='btn btn-sm btn-info' href='pag_edit_cliente.php?id=$userdata[ID]'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='white' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                        </a>
                        <a class='btn btn-sm btn-danger' href='javascript:void(0);' onclick='confirmarExclusao($userdata[ID])'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                                <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'/>
                            </svg>
                        </a>
                    </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col"></div>
    </div>

</body>

<script>
    // obtém elementos do DOM pelo ID
    var search = document.getElementById('pesquisa');
    var id = document.getElementById('data');

    // função para realizar uma consulta, alterando o URL da página com o termo de busca
    function consulta() {
        window.location = 'pag_consu_cliente.php?search=' + search.value;
    }
    // função para confirmar a exclusão de um cliente, redirecionando para o script PHP de exclusão
    function confirmarExclusao(id) {
        // exibe um modal de confirmação
        var modalConfirmacao = `
    <div class="modal fade" id="modalConfirmacao" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja exluir todos os dados desse cliente ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="exluircliente(${id})">Excluir</button>
            </div>
            </div>
        </div>
    </div>
    `;

        // Adiciona o modal à página
        document.body.insertAdjacentHTML('beforeend', modalConfirmacao);

        // Exibe o modal
        var modal = new bootstrap.Modal(document.getElementById('modalConfirmacao'));
        modal.show();
    }

    function exluircliente(id) {
        // redireciona para o script de exclusão com o ID como parâmetro
        window.location.href = '../sql/sql_delete_cliente.php?id=' + id;
    }
</script>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

</html>