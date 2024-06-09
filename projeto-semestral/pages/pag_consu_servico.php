<?php
// inclusão do arquivo de conexão com o banco de dados
include '../sql/conexao.php';

// verifica se há dados armazenados, se houver realiza o comando de selec no banco de dados, caso contrario puxa tudo que há resgistrado.
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM servico WHERE (ordem_servico LIKE '%$data%' OR id_cliente LIKE '%$data%' OR responsavel LIKE '%$data%'  OR placa_carro LIKE '%$data%')";
    $result = $con->query($sql);
} else {
    $sql = "SELECT * FROM servico";
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
    <title>TecnoAr: Consultar seviços</title>

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

    <!-- tabela de serviços realizados -->
    <div class="row p-2">
        <div class="col"></div>
        <div class="col-10">
            <div class="col-6">
                <h1>Consultar ordens de serviço:</h1>
                <div class="caixa-pesquisa"><!-- caixa de pesquisa -->
                    <input type="search" class="form-control w-30" placeholder="Deseja realizar uma pesquisa em serviços realizados?" id="pesquisa">
                    <button onclick="consulta()" class="btn btn-success"> <!-- botão pesquisa-->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 
                                    
                            1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="text-formulario">Necessário incluir pontuação/separadores em casos de pesquisa pela placa do veiculo.</div>
            <br>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr> <!-- colunas tabela -->
                        <th scope="col" class="col1i text-center">OS</th>
                        <th scope="col" class="col2i text-center">ID CLIENTE</th>
                        <th scope="col" class="col4i text-center">NOME</th>
                        <th scope="col" class="col3i text-center">MODELO</th>
                        <th scope="col" class="col3i text-center">PLACA</th>
                        <th scope="col" class="col5i text-center">SERVIÇO REALIZADO</th>
                        <th scope="col" class="col3i text-center">DATA</th>
                        <th scope="col" class="col3i text-center">RESPONSÁVEL</th>
                        <th scope="col" class="col2i text-center">AÇÕES</th> <!-- coluna para as ações -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($userdata = mysqli_fetch_assoc($result)) {
                        $data_form = date("d/m/Y", strtotime($userdata['DATA_S']));
                        // Consulta para obter o nome do cliente com base no ID do cliente

                        $id_cliente = $userdata['ID_CLIENTE'];
                        $query_cliente = "SELECT NOME FROM cliente WHERE ID = $id_cliente";
                        $result_cliente = $con->query($query_cliente);
                        $cliente = mysqli_fetch_assoc($result_cliente);

                        // Convertendo o nome completo para maiúsculas
                        $nome_completo = strtoupper($cliente['NOME']);

                        // Dividindo o nome completo em partes
                        $partes_nome = explode(' ', $nome_completo);

                        // Pegando apenas o primeiro e o segundo nome
                        $primeiro_nome = $partes_nome[0];
                        $segundo_nome = isset($partes_nome[1]) ? $partes_nome[1] : ''; // Verificando se o segundo nome existe

                        echo "<tr>"; // linhas tabela
                        echo "<td class='center-text'>" . $userdata['ORDEM_SERVICO'] . "</td>";
                        echo "<td class='center-text'>" . sprintf('%03d', $userdata['ID_CLIENTE']) . "</td>"; // usar sprintf para formatar o ID com zeros a esquerda
                        echo "<td class='center-text'>" . $primeiro_nome . ' ' . $segundo_nome . "</td>";
                        echo "<td class='center-text'>" . $userdata['MODELO_CARRO'] . "</td>";
                        echo "<td class='center-text'>" . $userdata['PLACA_CARRO'] . "</td>";
                        echo "<td class='center-text'>" . $userdata['SERVICO_REALIZADO'] . "</td>";
                        echo "<td class='center-text'>" . $data_form . "</td>";
                        echo "<td class='center-text'>" . $userdata['RESPONSAVEL'] . "</td>";
                        echo "<td class='center-text'>
                    <a href='pag_edit_servico.php?id=" . $userdata['ORDEM_SERVICO'] . "' class='btn btn-info'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='white' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                    <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                    <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                    </svg>
                    </a>
                    <a href='javascript:void(0);' onclick='confirmarExclusao($userdata[ORDEM_SERVICO])' . ' class='btn btn-danger'>
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

<!-- editada o url da pagina enviando o dado a ser processado e filtrado -->
<script>
    var search = document.getElementById('pesquisa')

    function consulta() {
        window.location = 'pag_inicio.php?search=' + search.value;
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
                Tem certeza que deseja excluir essa ordem de serviço?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="deleteOrdemServico(${id})">Excluir</button>
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

    function finalizarOrdemServico(id) {
        // redireciona para o script de exclusão com o ID como parâmetro
        window.location.href = '../sql/sql_delete_servico.php?id=' + id;
    }
</script>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>