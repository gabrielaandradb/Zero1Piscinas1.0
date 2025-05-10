<?php
session_start();

// Verifica se o usuário está logado e é do tipo 'cliente'
if (!isset($_SESSION['ClassUsuarios']) || $_SESSION['tipo_usuario'] != 'cliente') {
    header('Location: LoginCadastro.php');
    exit;
}

// Recuperando os dados da sessão
$pedidoId = isset($_SESSION['pedidoId']) ? $_SESSION['pedidoId'] : 'Desconhecido';
$pedidoStatus = isset($_SESSION['pedidoStatus']) ? $_SESSION['pedidoStatus'] : 'Desconhecido';
$respostaProfissional = isset($_SESSION['respostaProfissional']) ? $_SESSION['respostaProfissional'] : '';
$mensagemAcompanhamento = isset($_SESSION['mensagemAcompanhamento']) ? $_SESSION['mensagemAcompanhamento'] : '';

// Limpar mensagem da sessão após exibir
unset($_SESSION['mensagemAcompanhamento']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhar Pedido - Zero1 Piscinas</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: hidden;
        }

        .container {
            display: grid;
            grid-template-columns: 300px 1fr;
            width: 100%;
            min-width: 100vw;
            height: auto;
            padding: 0;
            margin: 0;
        }

        .menu {
            background-color: #E0F7FA;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu h2 {
            font-size: 30px;
            color: #1F2937;
        }

        .menu nav {
            margin-top: 10px;
        }

        .menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu ul li {
            margin-bottom: 10px;
        }

        .menu ul li a {
            color: black;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        .menu ul li a:hover {
            text-decoration: underline;
            color: #005f8a;
        }

        .content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .header {
            background-color: #ffffff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            width: 80%;
            max-width: 1200px;
        }

        .btn {
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #005f8a;
        }

        .mensagem {
            margin: 20px;
            padding: 15px;
            background-color: lightyellow;
            border: 1px solid #b0e0e6;
            border-radius: 5px;
            color: #333;
            text-align: center;
        }
        h2 img {
            width: 60px;
            height: 60px;
            vertical-align: middle;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <div class="menu">
        <h2>Zero1 Piscinas <br> <img src="img/icone.png" alt="Ícone"></h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="Clientes.php">Voltar</a></li>
        </ul>
    </div>

    <!-- Conteúdo principal -->
    <div class="content">
        <div class="header">
            <h1>Acompanhar Pedido</h1>
            
            <a href="logout.php" class="btn">Sair</a>
        </div>
<div>
            <p>Aqui você pode acompanhar o status do seu pedido, conversar com profissional e realizar o pagamento.</p>
            </div>
        <!-- Seção de Acompanhamento de Pedido -->
        <div class="card">
            <h2>Status do Pedido #<?php echo $pedidoId; ?></h2>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($pedidoStatus); ?></p>

            <?php if ($respostaProfissional): ?>
                <h3>Resposta do Profissional:</h3>
                <p><?php echo htmlspecialchars($respostaProfissional); ?></p>
            <?php endif; ?>

            <br><br>

            <?php if ($mensagemAcompanhamento): ?>
                <div class="mensagem">
                    <p><?php echo htmlspecialchars($mensagemAcompanhamento); ?></p>
                </div>
            <?php endif; ?>

            <!-- Botão de Pagamento -->
            <form action="processarPagamento.php" method="post">
                <input type="hidden" name="pedidoId" value="<?php echo $pedidoId; ?>">
                <button type="submit" class="btn">Realizar Pagamento</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
