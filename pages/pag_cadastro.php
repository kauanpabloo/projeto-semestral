<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tela de Cadastro - Prime Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="pag_inicio.php">
            <img src="../assets/img/tec-logo.png" height="40" loading="lazy" style="margin-top: -1px;" alt="TecnoAr Logo"/> <!-- logo Prime Solutions -->
            </a>
        </div>
    </nav>

    <!-- Formulário de Cadastro -->
    <div class="container mt-5 p-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Preencha os campos:</h5>
                        <form id="signup-form">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF:</label>
                                <input type="text" maxlength="14" class="form-control" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@exemplo.com"required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <div class="mb-3">
                                <label for="repeticao_senha" class="form-label">Repita sua Senha:</label>
                                <input type="password" class="form-control" id="repeticao_senha" name="repeticao_senha" required>
                            </div>
                            <input type="hidden" name="acao" value="cadastrar">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                        <div class="mt-3">
                            <a href="../index.html" class="text-decoration-none">Já tem uma conta? Faça login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');

            $('#signup-form').submit(function(e) {
                e.preventDefault();

                var nome = $('#nome').val();
                var cpf = $('#cpf').val();
                var email = $('#email').val();
                var senha = $('#senha').val();
                var repeticao_senha = $('#repeticao_senha').val();

                $.ajax({
                    url: '../sql/sql_banco.php',
                    type: 'POST',
                    data: {
                        nome: nome,
                        cpf: cpf,
                        email: email,
                        senha: senha,
                        repeticao_senha: repeticao_senha,
                        acao: 'cadastrar'
                    },
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
