<?php
session_start();

// Verificar se o e-mail está armazenado na sessão
if (!isset($_SESSION['email_verificacao'])) {
    header("Location: esqueci_senha");
    exit();
}

$mensagemErro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_digitado = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);

    if ($codigo_digitado === $_SESSION['codigo_verificacao']) {
        $_SESSION['verificado'] = true;
        header("Location: redefinir_senha");
        exit();
    } else {
        $mensagemErro = "Código incorreto. Tente novamente.";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
    <!-- Imagem de fundo -->
    <div class="fundo">
        <img src="Imagem/Background-Banner-Desktop.webp" alt="Imagem de fundo">
    </div>
    
    <!-- Logo no topo -->
    <div class="topo">
        <a href="https://simdigosim.com.br/">
        <img src="Imagem/Logo-retangular-2-branca.webp" alt="Logo Sim, Digo Sim!">
        </a>
    </div>

    <!-- Container do formulário -->
    <div class="form-container">
        <!-- Formulário de verificação de código -->
        
        <form method="POST">
            <h2>Verificação de Código</h2>
            <label for="codigo">Digite o código de verificação enviado ao seu e-mail:</label>
            <input type="text" id="codigo" name="codigo" required>
            
            <!-- Exibição de mensagem de erro -->
            <?php if (!empty($mensagemErro)): ?>
                <div class="mensagem">
                    <?= htmlspecialchars($mensagemErro, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <button type="submit">Verificar Código</button>
        </form>
    </div>
</body>
</html>
