<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/estilo.css" />

</head>

<body>

    <!-- navBar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- cores Navbar -->
        <div class="container-fluid">
            <a class="navbar-brand" href="pag_inicio.php">
                <img src="img/tec-logo.png" height="40" loading="lazy" style="margin-top: -1px;" /> <!-- logo Prime Solutions -->
            </a>

            <!-- Dropdown de Sair e Perfil alinhado à direita -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 18px;">
                        <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-person-circle' viewBox='0 0 16 16'>
                            <path d='M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0' />
                            <path fill-rule='evenodd' d='M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1' />
                        </svg>
                        <?php echo htmlspecialchars($nomeCurto); ?>
                    </a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <br>

    <div class="container d-flex align-items-center justify-content-center">
        <div class="mensagem-erro">
            <h3>Acesso autorizado somente para administradores.</h3>
            <br>
            <p>Clique no botão abaixo e volte a navegar.</p>
            <a href="javascript:history.go(-1);" class="btn btn-secondary esp-botao">Voltar</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6M2N8gkaYzhg+iWFLFELa0LAjJ8Y5yJ8dWw5yUANVNfc5HhXJIm" crossorigin="anonymous"></script>
</body>

</html>