<?php
session_start();

// Verifique se o profissional está logado
if (!isset($_SESSION['ClassUsuarios']) || $_SESSION['tipo_usuario'] != 'profissional') {
    header('Location: LoginCadastro.php');
    exit;
}

// Conexão com o banco de dados
require_once 'Conexao.php';
$conexao = Conexao::getInstance();

// Obtenha o ID da solicitação (piscina) que o profissional deseja acessar
$solicitacao_id = $_GET['id'];

// Verifique se a solicitação (piscina) existe e se está associada ao profissional logado
$query = "
    SELECT 
    s.id, 
    s.tipo_servico, 
    s.descricao, 
    s.estatus, 
    s.preco, 
    s.data_solicitacao, 
    s.data_execucao, 
    p.tamanho, 
    p.tipo AS tipo_piscina, 
    c.nome AS cliente_nome, 
    c.email AS cliente_email
FROM servicos s
JOIN piscinas p ON s.piscina_id = p.id
JOIN clientes cl ON p.cliente_id = cl.id
JOIN usuarios c ON cl.id = c.id  -- Associar a tabela 'clientes' à 'usuarios' para pegar o nome do cliente
WHERE s.id = 1 
AND s.profissional_id = 2;

";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':solicitacao_id', $solicitacao_id, PDO::PARAM_INT);
$stmt->bindParam(':id_cliente', $_SESSION['ClassUsuarios'], PDO::PARAM_INT);
$stmt->execute();

$solicitacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$solicitacao) {
    echo "Solicitação não encontrada ou você não tem permissão para responder.";
    exit;
}

// Processar resposta e atualização de status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resposta = $_POST['resposta'];
    $estatus = $_POST['estatus'];
    $data_execucao = $_POST['data_execucao'];

    // Atualiza o status e a resposta do profissional
    $update_query = "
        UPDATE piscinas 
        SET status = :estatus, 
            resposta = :resposta
        WHERE id = :solicitacao_id
    ";
    $stmt_update = $conexao->prepare($update_query);
    $stmt_update->bindParam(':resposta', $resposta, PDO::PARAM_STR);
    $stmt_update->bindParam(':estatus', $estatus, PDO::PARAM_STR);
    $stmt_update->bindParam(':solicitacao_id', $solicitacao_id, PDO::PARAM_INT);
    
    if ($stmt_update->execute()) {
        $_SESSION['mensagem'] = "Resposta e status enviados com sucesso!";
        header('Location: gerenciamentoProfissional.php');
        exit;
    } else {
        echo "Erro ao enviar resposta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Acompanhar Serviço</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .mensagens {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            max-height: 300px;
            overflow-y: auto;
        }

        .mensagem {
            margin-bottom: 10px;
        }

        .mensagem p {
            margin: 0;
        }

        .form-mensagem {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>Acompanhar Serviço</h1>
    <p><strong>Piscina:</strong> <?= htmlspecialchars($solicitacao['tipo_piscina']); ?> - <?= htmlspecialchars($solicitacao['tamanho']); ?>m²</p>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($solicitacao['cliente_nome']); ?> (<?= htmlspecialchars($solicitacao['cliente_email']); ?>)</p>
    <p><strong>Serviço Desejado:</strong> <?= htmlspecialchars($solicitacao['servico_desejado']); ?></p>
    <p><strong>Data Solicitação:</strong> <?= htmlspecialchars($solicitacao['data_solicitacao']); ?></p>
    <p><strong>Status da Solicitação:</strong> <?= htmlspecialchars($solicitacao['status_solicitacao']); ?></p>

    <h2>Mensagem do Cliente</h2>
    <div class="mensagens">
        <p><strong>Resposta do Cliente:</strong> <?= htmlspecialchars($solicitacao['resposta_cliente']); ?></p>
    </div>

    <h2>Responder Solicitação</h2>
    <form method="post" class="form-mensagem">
        <label for="resposta">Enviar Resposta:</label>
        <textarea name="resposta" rows="4" cols="50" required></textarea>
        <button type="submit">Enviar Resposta</button>
    </form>

    <h2>Atualizar Status</h2>
    <form method="post">
        <label for="estatus">Status:</label>
        <select name="estatus" required>
            <option value="em_andamento" <?= $solicitacao['status_solicitacao'] == 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
            <option value="concluido" <?= $solicitacao['status_solicitacao'] == 'concluido' ? 'selected' : ''; ?>>Concluído</option>
            <option value="pendente" <?= $solicitacao['status_solicitacao'] == 'pendente' ? 'selected' : ''; ?>>Pendente</option>
        </select>
        <br>
        <label for="data_execucao">Data de Execução:</label>
        <input type="datetime-local" name="data_execucao" value="<?= date('Y-m-d\TH:i', strtotime($solicitacao['data_solicitacao'])); ?>" required>
        <br>
        <button type="submit">Atualizar Status</button>
    </form>
</body>
</html>
