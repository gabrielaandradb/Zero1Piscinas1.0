<?php
session_start();
session_destroy(); // Destrói todas as sessões
header('Location: index.php'); // Redireciona para a página de login
exit;
?>

