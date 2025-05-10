<?php
session_start();

if (!isset($_SESSION['ClassUsuarios']) || $_SESSION['tipo_usuario'] != 'cliente') {
    header('Location: LoginCadastro.php');
    exit;
}

$mensagemSolicitacao = isset($_SESSION['mensagemSolicitacao']) ? $_SESSION['mensagemSolicitacao'] : '';

unset($_SESSION['mensagemSolicitacao']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero1 Piscinas - Clientes</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;  /* Garante que o conteúdo da página se alinhe no centro horizontalmente */
            overflow-x: hidden; /* Impede a rolagem lateral */
        }

        .container {
            width: 100%;   /* A largura será 100% da largura disponível */
            min-width: 100vw; /* Garante que o conteúdo ocupe a largura total da tela */
            display: grid;
            grid-template-columns: 300px 1fr; 
            height: auto;
            padding: 0;    /* Remove o padding */
            margin: 0;     /* Remove a margem */
        }


        .menu {
            background-color: #E0F7FA; 
            color: #374151; 
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: left;
        }

        .menu h2 {
            font-size: 30px;
            margin: 0;
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
            color: black;
        }

        .header .btn {
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .header .btn:hover {
            background-color: #005f8a;
            transform: scale(1.05);
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            flex-grow: 1;
        }

        .card h2 {
            font-size: 22px;
            color: #0077b6;
        }

        .card p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        @media (max-width: 768px) {
            .card {
                width: 100%;
            }
        }

        .btn {
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #005f8a;
            transform: scale(1.05);
        }

        .mensagem {
            margin: 20px;
            padding: 15px;
            background-color: greenyellow;
            border: 1px solid #b0e0e6;
            border-radius: 5px;
            color: green;
            text-align: center;
        }

        h2 img {
            width: 60px;
            height: 60px;
            vertical-align: middle;
            margin-left: 10px;
        }

        .header-text {
            margin-top: 5px;
        }

        .header .welcome {
            font-size: 18px;
            color: #0077b6;
            text-align: left;
        }

    </style>
</head>
<body>


<div class="container">
    <!-- Sidebar -->
    <div class="menu">
        <h2>Zero1 Piscinas <br> <img src="img/icone.png" alt="Ícone"></h2>
        <ul>
            <li><a href="index.php">Voltar</a></li>
            <li><a href="acompanharServico.php">Acompanhar Serviço</a></li>
            <li><a href="acompanharServico.php">Realizar pagamento</a></li>
        </ul>

        <!-- Seção Meus Dados -->
        <div id="meus-dados" class="card">
            <h2>Meus Dados</h2>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($_SESSION['ClassUsuarios']['nome']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['ClassUsuarios']['email']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($_SESSION['ClassUsuarios']['telefone']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($_SESSION['ClassUsuarios']['endereco']); ?></p>
            <button class="btn" onclick="window.location.href='editarClientes.php';">Editar Informações</button>
        </div>

    </div>

    <!-- Conteúdo principal -->
    <div>
        <div class="header">
            <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['ClassUsuarios']['nome']); ?></h1>
            <div class="header-text"><br>
             <p class="welcome" >Aqui você pode gerenciar suas informações e acompanhar os serviços.</p>
        </div>
    <a href="logout.php" class="btn">Sair</a>
</div>


        <!-- Seção Minha Piscina -->
        <div id="minha-piscina" class="card">
            <h2>Detalhes da Minha Piscina</h2>
            <form action="salvarSolicitacao.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="usuarioId" value="<?php echo htmlspecialchars($_SESSION['ClassUsuarios']['id']); ?>">

                <label for="tamanho">Tamanho da Piscina:</label>
                <select id="tamanho" name="tamanho" required>
                    <option value=""></option>
                    <option value="Pequena">Pequena</option>
                    <option value="Média">Média</option>
                    <option value="Grande">Grande</option>
                </select>
                <label for="tipo">Tipo de Piscina:</label>
                
                <select id="tipo" name="tipo" required>
                    <option value=""></option>
                    <option value="Fibra de Vidro">Fibra de Vidro</option>
                    <option value="Vinil">Vinil</option>
                    <option value="Plastico/ Lona"> Plástico/ Lona</option>
                    <option value="Alvenaria">Alvenaria</option>
                    <option value="Areia">Areia</option>
                    <option value="Outro">Outro</option>
                </select>

                <label for="profundidade">Profundidade:</label>
                <input type="text" id="profundidade" name="profundidade" required>

                <label for="dataInstalacao">Data de Instalação:</label>
                <input type="date" id="dataInstalacao" name="dataInstalacao" required>

                <label for="servico">Serviço desejado:</label>
                <select id="servico" name="servico" required>
                    <option value=""></option>
                    <option value="Limpeza de Piscinas">Limpeza de Piscinas</option>
                    <option value="Manutenção">Manutenção</option>
                    <option value="Reparos">Reparos</option>
                    <option value="Aquecimento de Piscinas">Aquecimento de Piscinas</option>
                    <option value="Acabamentos e Bordas">Acabamentos e Bordas</option>
                    <option value="Construção e Reforma de Piscinas">Construção ou Reforma</option>
                    <option value="Instalação de Capas Protetoras">Instalação de Capas Protetoras</option>
                    <option value="Automatização de Piscinas">Automatização</option>
                    <option value="Tratamento Avançado da Água">Tratamento da Água</option>
                </select>

                <label for="fotoPiscina">Foto da Piscina: <br>*opcional</label>

                <input type="file" id="fotoPiscina" name="fotoPiscina" accept="image/*">

                <br><br>
                <button type="submit" class="btn">Solicitar Serviço</button>


                <?php if ($mensagemSolicitacao): ?>
                <div class="mensagem">
                    <p><?php echo htmlspecialchars($mensagemSolicitacao); ?></p>
                </div>
            <?php endif; ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>