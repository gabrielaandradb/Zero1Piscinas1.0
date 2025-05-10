<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'Zero1Piscinas');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$erro = '';
$sucesso = '';

// Verifique se o usuário já está logado
$usuario_logado = isset($_SESSION['ClassUsuarios']) ? $_SESSION['ClassUsuarios'] : null;

// Verifique se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email_login']) && isset($_POST['senha_login'])) {
        $email = $_POST['email_login'];
        $senha = $_POST['senha_login'];

        // Verifica se o email termina com @profissional.com
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email_login']) && isset($_POST['senha_login'])) {
        $email = $_POST['email_login'];
        $senha = $_POST['senha_login'];

        // Determina o tipo de usuário com base no sufixo do e-mail
$tipo_usuario = (str_ends_with($email, '@profissional.com')) ? 'profissional' : 'cliente';

        // Consulta ao banco de dados
        $sql = "SELECT * FROM usuarios WHERE email = ? AND tipo_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $tipo_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verifica se a senha informada corresponde ao hash da senha armazenada
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['ClassUsuarios'] = $usuario;
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

                if ($usuario['tipo_usuario'] == 'profissional') {
                    header('Location: Profissionais.php');
                    exit;
                } else if ($usuario['tipo_usuario'] == 'cliente') {
                    header('Location: index.php');
                    exit;
                }
            } else {
                $erro = "E-mail ou senha incorretos!";
            }
        } else {
            $erro = "Profissional não encontrado!";
        }

        $stmt->close();
    }
}
    }

    // Verifique se o formulário de cadastro foi enviado
    if (isset($_POST['email_cad']) && isset($_POST['senha_cad'])) {
    $nome = $_POST['nome_cad'];
    $email = $_POST['email_cad'];
    $telefone = $_POST['telefone_cad'];
    $endereco = $_POST['endereco_cad'];
    $senha = $_POST['senha_cad'];

    // Criptografa a senha antes de salvar
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Determina o tipo de usuário com base no e-mail
    $tipo_usuario = (str_ends_with($email, '@profissional.com')) ? 'profissional' : 'cliente';

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, telefone, endereco, senha, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $nome, $email, $telefone, $endereco, $senha_hash, $tipo_usuario);

    if ($stmt->execute()) {
        $sucesso = "Cadastro realizado com sucesso! Faça login.";
    } else {
        $erro = "Erro ao cadastrar usuário: " . $conn->error;
    }

    $stmt->close();
}


    /*exclusao de conta*/
    if (isset($_GET['mensagem'])) {
        echo '<div style="margin: 20px; padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">' . htmlspecialchars($_GET['mensagem']) . '</div>';
    }

    if (isset($_GET['mensagemErro'])) {
        echo '<div style="margin: 20px; padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;">' . htmlspecialchars($_GET['mensagemErro']) . '</div>';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Cadastro</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="js/script.js" defer></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
            // Aqui você pode enviar o token para o backend para validação e login.
        }

        window.onload = function () {
            google.accounts.id.initialize({
                client_id: "964075037995-62drlhckrr5cfbu79ets39tpk02ei1h4.apps.googleusercontent.com", // Substitua pelo seu Client ID do Google
                callback: handleCredentialResponse
            });

            google.accounts.id.renderButton(
                document.getElementById("google-signin"),
                { theme: "outline", size: "large" } // Personalize o botão aqui
            );
        };
    </script>

</head>
<body>
<div class="form-container">


    <!-- Formulário de Login -->
<div id="login-form">
    <form method="post" action="">
        <h2>Login</h2>
        <label for="email_login">E-mail:</label>
        <input type="email" id="email_login" name="email_login" placeholder="seuemail@exemplo.com" required>

        <label for="senha_login">Senha:</label>
        <input type="password" id="senha_login" name="senha_login" placeholder="senha" required>


    <!--    <div id="google-signin"></div>  Botão de login com Google -->


        <input type="submit" value="Entrar">
        <div class="form-switch">
            <a href="javascript:void(0);" onclick="mostrarCadastro()">Não tem uma conta? Cadastre-se</a>
        </div>

        <!-- Mensagens -->
        <?php if ($erro): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <?php if ($sucesso): ?>
        <p style="color: green;"><?= htmlspecialchars($sucesso) ?></p>
        <?php endif; ?>
    </form>
</div>

<!-- Formulário de Cadastro -->
<div id="cadastro-form" class="hidden">
    <form method="post" action="">
        <h2>Cadastro</h2>

        <label for="nome_cad">Nome completo:</label>
        <input type="text" id="nome_cad" name="nome_cad" placeholder="Seu nome completo" required>

        <label for="email_cad">E-mail:</label>
        <input type="email" id="email_cad" name="email_cad" placeholder="seuemail@exemplo.com" required>

        <label for="telefone_cad">Telefone:</label>
        <input type="tel" id="telefone_cad" name="telefone_cad" placeholder="(xx) xxxxx-xxxx" required>

        <label for="endereco_cad">Endereço:</label>
        <input type="text" id="endereco" name="endereco_cad" placeholder="Endereço completo" required>

        <label for="senha_cad">Senha:</label>
        <input type="password" id="senha_cad" name="senha_cad" placeholder="ex: 123456" required>

        <input type="submit" value="Cadastrar">

        <div class="form-switch">
            <a href="javascript:void(0);" onclick="mostrarLogin()">Já tem uma conta? Faça login</a>
        </div>

        <!-- Mensagens -->
        <?php if ($erro): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
        <?php if ($sucesso): ?>
        <p style="color: green;"><?= htmlspecialchars($sucesso) ?></p>
        <?php endif; ?>
    </form>

</div>
    </div>
</>
    <script>
        function mostrarLogin() {
            document.getElementById("login-form").classList.remove("hidden");
            document.getElementById("cadastro-form").classList.add("hidden");
        }

        function mostrarCadastro() {
            document.getElementById("login-form").classList.add("hidden");
            document.getElementById("cadastro-form").classList.remove("hidden");
        }
    </script>
</body>
</html>