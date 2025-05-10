<?php
session_start();

$usuario = isset($_SESSION['ClassUsuarios']) ? $_SESSION['ClassUsuarios'] : null;

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Zero1 Piscinas</title>
    <link rel="stylesheet" href="css/estilo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .index {
                width: 100%;   /* A largura será 100% da largura disponível */
                min-width: 100vw; /* Garante que o conteúdo ocupe a largura total da tela */
                height: 100%;  /* A altura será 100% da altura da tela */
                padding: 0;    /* Remove o padding */
                margin: 0;     /* Remove a margem */
                text-align: center;  /* Centraliza o texto */
        }

        h1 {
            font-size: 32px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 30px;
            color: #0077b6;         
            font-weight: bold;
        }
        .p-estilo {
            font-size: 22px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
            margin-left: 70px;  /* Adiciona margem à esquerda */
            margin-right: 70px; /* Adiciona margem à direita */
        }

        .usuario-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end; /* Alinha tudo à direita */
            -top: 20px;
        }

        .saudacao-login {
            font-size: 22px; /* Aumenta o tamanho da fonte */
            color: #000000; /* Cor preta */
            font-weight: bold; /* Deixa o nome em negrito */
            margin-right: 0px; /* Adiciona espaço entre o nome e o botão */
            margin-right: 70px; /* Adiciona margem à direita */
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* Cor de fundo do botão */
            color: white; /* Cor do texto do botão */
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-right: 70px; /* Adiciona margem à direita */
        }

        .btn:hover {
            background-color: #45a049; /* Cor do botão ao passar o mouse */
            margin-right: 70px; /* Adiciona margem à direita */
        }

        .menu {
            list-style: none;
            display: flex;
            gap: 15px;
            margin: 0;
            padding: 0;
            justify-content: right;
            margin-right: 70px; /* Adiciona margem à direita */
        }
        .menu li a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 16px;
            margin-right: 20px; /* Adiciona margem à direita */

        }
        .menu li a:hover {
            text-decoration: underline;
        }

        .servicos-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            padding: 50px;
        }
        .servicos-container h2 {
            font-size: 36px;
            color: #0077b6;
            margin-bottom: 40px;
            font-weight: bold;
        }
        .servicos {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 imagens por linha */
            gap: 20px; /* Adiciona uma margem entre as imagens */
        }

        @media (max-width: 768px) {
            .servicos {
                grid-template-columns: repeat(2, 1fr); /* 2 imagens por linha em telas menores */
            }
        }

        @media (max-width: 480px) {
            .servicos {
                grid-template-columns: 1fr; /* 1 imagem por linha em telas pequenas */
            }
        }

        .servico {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .servico img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .servico:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .servico h3 {
            font-size: 22px;
            color: #0072ff;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .servico p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
            margin-top: 10px;
        }
        @media (max-width: 768px) {
            .menu {
                flex-direction: column;
                gap: 15px;
            }
            .servicos {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .servicos {
                grid-template-columns: 1fr;
            }
            .saudacao-login {
                font-size: 20px;
                color: #000000;
                text-align: left;
                padding: 2px 0 20px 0;
            }
        }

        .precos-container {
            max-width: 1200px;
            margin: 50px auto;
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .precos-container h2 {
            font-size: 28px;
            color: #0077b6;
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #0077b6;
            color: #fff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }


        footer {
            text-align: center;
            padding: 20px;
            background-color: #f1f1f1;
            width: 100%;
        }

        footer p {
            font-size: 14px;
            color: #333;
        }
       
        h1 img {
            width: 60px;
            height: 60px;
            vertical-align: middle;
            margin-left: 10px;
        }

    </style>
</head>
<body>
    <div class="index">
        <h1>Bem-vindo à Zero1 Piscinas! <img src="img/icone.png" alt="Ícone"></h1>
        <div class="usuario-info">
    <?php if ($usuario): ?>
        <p class="saudacao-login"><?= htmlspecialchars($usuario['nome']); ?></p>
        <a href="logout.php" class="btn">Sair</a>
    <?php else: ?>
        <a href="LoginCadastro.php" class="btn">Login/Cadastro</a>
    <?php endif; ?>
</div>
        <br><br>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#servicos">Serviços</a></li>
                <li><a href="index.php#precos">Preços</a></li>
                <li><a href="index.php#quem-somos">Sobre nós</a></li>
                <?php if ($usuario): ?>
                    <li><a href="Clientes.php">Meu Perfil</a></li>
                <?php else: ?>
                    <li><a href="LoginCadastro.php">Meu Perfil</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <br>

        <p class="p-estilo">
            Bem-vindo ao Zero1 Piscinas! Estamos aqui para facilitar o cuidado 
            com sua piscina, conectando você aos melhores profissionais para 
            serviços de limpeza, manutenção e reparo. Explore nossas soluções 
            personalizadas e aproveite uma experiência prática, segura e eficiente. 
            Estamos prontos para ajudar a manter sua piscina sempre 
            em perfeitas condições!
        </p>
        <div class="servicos-container" id="servicos">
    <h1>Nossos Serviços</h1>
    <div class="servicos">
        <div class="servico">
            <img src="img/limpeza2.jpg" alt="Limpeza de Piscina">
            <h3>Limpeza de Piscinas</h3>
            <p>Realizamos uma limpeza completa para garantir a pureza da água e a segurança dos banhistas.</p>
        </div>

        <div class="servico">
            <img src="img/manutencao2.jpg" alt="Manutenção de Piscinas">
            <h3>Manutenção</h3>
            <p>Oferecemos um serviço abrangente para manter sua piscina em ótimas condições.</p>
        </div>

        <div class="servico">
            <img src="img/reparo1.jpg" alt="Reparo de Piscinas">
            <h3>Reparos</h3>
            <p>Corrigimos vazamentos e realizamos consertos em equipamentos, garantindo que sua piscina esteja sempre funcional.</p>
        </div>

        <div class="servico">
            <img src="img/aquecimento1.webp" alt="Aquecimento de Piscinas">
            <h3>Aquecimento de Piscinas</h3>
            <p>Instalamos sistemas de aquecimento para você aproveitar sua piscina durante todo o ano.</p>
        </div>

        <div class="servico">
            <img src="img/acabamentos1.png" alt="Acabamentos e Bordas">
            <h3>Acabamentos e Bordas</h3>
            <p>Personalize sua piscina com materiais de alta qualidade e bordas cimentícias para maior durabilidade.</p>
        </div>

        <div class="servico">
            <img src="img/construcao1.jpg" alt="Construção e Reforma de Piscinas">
            <h3>Construção e Reforma</h3>
            <p>Construímos e reformamos piscinas de diferentes estilos e tamanhos para atender às suas necessidades.</p>
        </div>

        <div class="servico">
            <img src="img/capa1.jpg" alt="Instalação de Capas Protetoras">
            <h3>Instalação de Capas Protetoras</h3>
            <p>Instalamos capas de proteção de alta resistência para maior segurança e economia de limpeza.</p>
        </div>

        <div class="servico">
            <img src="img/automacao1.jpg" alt="Automação de Piscinas">
            <h3>Automação de Piscinas</h3>
            <p>Automatize o controle da sua piscina com sistemas modernos para iluminação, temperatura e filtragem.</p>
        </div>

        <div class="servico">
            <img src="img/tratamento1.jpg" alt="Tratamento Avançado da Água">
            <h3>Tratamento Avançado da Água</h3>
            <p>Oferecemos soluções de alta tecnologia para garantir máxima qualidade e segurança da água.</p>
        </div>
    </div>
</div>

 <!--PREÇOS -->
<div class="precos-container" id="precos">
        <h2>Tabela de Preços</h2>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Piscinas Pequenas <br>(até 10m²)</th>
                    <th>Piscinas Médias <br>(até 25m²)</th>
                    <th>Piscinas Grandes <br>(acima de 25m²)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Limpeza de Piscinas</td>
                    <td>R$ 150,00</td>
                    <td>R$ 250,00</td>
                    <td>R$ 350,00</td>
                </tr>
                <tr>
                    <td>Manutenção</td>
                    <td>R$ 200,00</td>
                    <td>R$ 300,00</td>
                    <td>R$ 400,00</td>
                </tr>
                <tr>
                    <td>Reparos</td>
                    <td>R$ 300,00</td>
                    <td>R$ 450,00</td>
                    <td>R$ 600,00</td>
                </tr>
                <tr>
                    <td>Aquecimento de Piscinas</td>
                    <td>R$ 2.000,00</td>
                    <td>R$ 3.000,00</td>
                    <td>R$ 4.000,00</td>
                </tr>
                <tr>
                    <td>Acabamentos e Bordas</td>
                    <td>R$ 1.000,00</td>
                    <td>R$ 1.500,00</td>
                    <td>R$ 2.000,00</td>
                </tr>
                <tr>
                    <td>Construção e Reforma</td>
                    <td>R$ 10.000,00</td>
                    <td>R$ 15.000,00</td>
                    <td>R$ 20.000,00</td>
                </tr>
                <tr>
                    <td>Instalação de Capas Protetoras</td>
                    <td>R$ 500,00</td>
                    <td>R$ 800,00</td>
                    <td>R$ 1.000,00</td>
                </tr>
                <tr>
                    <td>Automação de Piscinas</td>
                    <td>R$ 5.000,00</td>
                    <td>R$ 7.000,00</td>
                    <td>R$ 9.000,00</td>
                </tr>
                <tr>
                    <td>Tratamento da Água</td>
                    <td>R$ 800,00</td>
                    <td>R$ 1.200,00</td>
                    <td>R$ 1.500,00</td>
                </tr>
            </tbody>
        </table>
        <a href="Orcamento.php" class="btn">Solicitar Orçamento</a>
    </div>
 
            <div class="quem-somos" id="quem-somos" style="text-align: center; margin: 50px 0;">
                <h1>Quem Somos</h1>
        <p class="p-estilo">
                    Na Zero1 Piscinas, acreditamos que uma piscina bem cuidada é sinônimo de lazer, saúde e segurança. 
                    Com anos de experiência no mercado, nossa missão é oferecer soluções inovadoras e acessíveis 
                    para a manutenção, construção e personalização de piscinas, garantindo a satisfação de nossos clientes.
                </p>
         <p class="p-estilo">
                    Nossa equipe é composta por profissionais altamente capacitados que estão prontos para atender às 
                    suas necessidades com agilidade e excelência. Trabalhamos com tecnologia de ponta e um compromisso 
                    inabalável com a qualidade e o meio ambiente.
                </p>

                
            </div>
        </div>
    </div>
    <footer>
        <p>© 2025 Zero1 Piscinas. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
