<?php
// Conexão com o banco de dados
include("PHP/conexao.php");

session_start();

// Verificar se o usuário está verificado
if (!isset($_SESSION['verificado'])) {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar e validar a nova senha
    $nova_senha = filter_input(INPUT_POST, 'nova_senha', FILTER_SANITIZE_STRING);

    // Hash da senha para segurança
    $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    // Verifica se a variável de sessão de e-mail está definida
    if (isset($_SESSION['email_verificacao'])) {
        $email = $_SESSION['email_verificacao'];

        // Prepara a query para evitar injeção de SQL
        $stmt = $conn->prepare("UPDATE usuario SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $nova_senha_hash, $email);
        $stmt->execute();
        $stmt->close();

        // Limpar dados temporários da sessão
        unset($_SESSION['codigo_verificacao']);
        unset($_SESSION['email_verificacao']);
        unset($_SESSION['verificado']);

        // Exibe a mensagem de sucesso e redireciona
        echo "Senha redefinida com sucesso!";
        header("Location: login");
        exit();
    } else {
        // Se o e-mail não está na sessão, redireciona para a página de login
        header("Location: login");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <!-- Imagem de fundo -->
    <div class="fundo">
        <img src="Imagem/Background-Banner-Desktop.webp" alt="Imagem de fundo">
    </div>

    <div class="form-container">
        <h2>Redefinir Senha</h2>
        <form method="POST">
            <label for="nova_senha">Digite a nova senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>

