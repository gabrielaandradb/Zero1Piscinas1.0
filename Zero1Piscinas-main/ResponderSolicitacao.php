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

// Obtenha o ID da solicitação
$solicitacao_id = $_GET['id'];

// Verifique se a solicitação existe
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
        u.nome AS cliente_nome, 
        u.email AS cliente_email
    FROM servicos s
    JOIN piscinas p ON s.piscina_id = p.id
    JOIN usuarios u ON p.cliente_id = u.id
    WHERE s.id = :solicitacao_id 
    AND s.profissional_id = :id_profissional
";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':solicitacao_id', $solicitacao_id, PDO::PARAM_INT);
$stmt->bindParam(':id_profissional', $_SESSION['ClassUsuarios'], PDO::PARAM_INT);
$stmt->execute();

$solicitacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$solicitacao) {
    echo "Solicitação não encontrada ou você não tem permissão para responder.";
    exit;
}

// Processar resposta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resposta = $_POST['resposta'];
    $estatus = $_POST['estatus'];
    $data_execucao = $_POST['data_execucao'];

    $update_query = "
        UPDATE servicos 
        SET estatus = :estatus, 
            descricao = :resposta, 
            data_execucao = :data_execucao
        WHERE id = :solicitacao_id
    ";
    $stmt_update = $conexao->prepare($update_query);
    $stmt_update->bindParam(':resposta', $resposta, PDO::PARAM_STR);
    $stmt_update->bindParam(':estatus', $estatus, PDO::PARAM_STR);
    $stmt_update->bindParam(':data_execucao', $data_execucao, PDO::PARAM_STR);
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
    <p><strong>Piscina:</strong> <?= htmlspecialchars($solicitacao['piscina_nome']); ?></p>
    <p><strong>Cliente:</strong> <?= htmlspecialchars($solicitacao['cliente_nome']); ?> (<?= htmlspecialchars($solicitacao['cliente_email']); ?>)</p>
    <p><strong>Tipo de Serviço:</strong> <?= htmlspecialchars($solicitacao['tipo_servico']); ?></p>
    <p><strong>Descrição:</strong> <?= htmlspecialchars($solicitacao['descricao']); ?></p>
    <p><strong>Data Solicitação:</strong> <?= htmlspecialchars($solicitacao['data_solicitacao']); ?></p>
    <p><strong>Preço:</strong> R$ <?= number_format($solicitacao['preco'], 2, ',', '.'); ?></p>

    <h2>Mensagens</h2>
    <div class="mensagens">
        <?php foreach ($mensagens as $mensagem): ?>
            <div class="mensagem">
                <p><strong><?= htmlspecialchars($mensagem['remetente_nome']); ?>:</strong></p>
                <p><?= htmlspecialchars($mensagem['mensagem']); ?></p>
                <small><?= date('d/m/Y H:i', strtotime($mensagem['data_envio'])); ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <form method="post" class="form-mensagem">
        <label for="resposta">Enviar Mensagem:</label>
        <textarea name="resposta" rows="4" cols="50" required></textarea>
        <button type="submit">Enviar</button>
    </form>

    <h2>Atualizar Status</h2>
    <form method="post">
        <label for="estatus">Status:</label>
        <select name="estatus" required>
            <option value="em_andamento" <?= $solicitacao['estatus'] == 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
            <option value="concluido" <?= $solicitacao['estatus'] == 'concluido' ? 'selected' : ''; ?>>Concluído</option>
            <option value="cancelado" <?= $solicitacao['estatus'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
        </select>
        <br>
        <label for="data_execucao">Data de Execução:</label>
        <input type="datetime-local" name="data_execucao" value="<?= date('Y-m-d\TH:i', strtotime($solicitacao['data_execucao'])); ?>">
        <br>
        <button type="submit">Atualizar Status</button>
    </form>
</body>
</html>
