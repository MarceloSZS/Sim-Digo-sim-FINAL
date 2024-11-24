<?php
// Conexão com o banco de dados
include("PHP/conexao.php");

// Inclui as classes do PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensagem = ""; // Variável para mensagens dinâmicas
$pergunta = ""; // Variável para armazenar a pergunta de segurança
$resposta_correta = ""; // Variável para armazenar a resposta correta

session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<span class='error'>E-mail inválido.</span>";
    } else {
        // Verifica se o e-mail existe no banco de dados usando uma declaração preparada
        $stmt = $conn->prepare("SELECT nome_materno, data_casamento, cep FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            // Define as perguntas e respostas possíveis
            $perguntas = [
                "Qual o nome da sua mãe?" => $usuario['nome_materno'],
                "Qual a data do seu casamento?" => date("d/m/Y", strtotime($usuario['data_casamento'])),
                "Qual o CEP do seu endereço?" => $usuario['cep']
            ];

            // Seleciona uma pergunta aleatória
            $pergunta = array_rand($perguntas); // Pega a chave da pergunta
            $resposta_correta = $perguntas[$pergunta]; // Resposta correta associada à pergunta

            // Armazena os dados na sessão
            $_SESSION['pergunta'] = $pergunta;
            $_SESSION['resposta_correta'] = $resposta_correta;
            $_SESSION['email_verificacao'] = $email;

            if (isset($_POST['resposta'])) {
                $resposta_usuario = trim(filter_input(INPUT_POST, 'resposta', FILTER_SANITIZE_STRING));

                // Verifica a resposta do usuário
                if (strcasecmp($resposta_usuario, $_SESSION['resposta_correta']) === 0) {
                    $codigo = rand(100000, 999999);
                    $_SESSION['codigo_verificacao'] = $codigo;

                    // Salva o código no banco
                    $stmt = $conn->prepare("UPDATE usuario SET codigo_verificacao = ? WHERE email = ?");
                    $stmt->bind_param("is", $codigo, $email);
                    $stmt->execute();

                    // Envia o e-mail
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'mail.simdigosim.com.br';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'no-reply@simdigosim.com.br';
                        $mail->Password = 'SUA_SENHA_SECRETA'; // Substituir pela senha real segura
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        $mail->Port = 465;

                        $mail->setFrom('no-reply@simdigosim.com.br', 'Sim, Digo Sim');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = 'Código de Verificação para Redefinição de Senha';
                        $mail->Body = "Seu código de verificação é: <b>" . htmlspecialchars($codigo) . "</b>";

                        $mail->send();

                        // Redireciona para a página de verificação do código
                        header("Location: verificar_codigo.php");
                        exit;
                    } catch (Exception $e) {
                        $mensagem = "<span class='error'>Erro ao enviar o e-mail: " . htmlspecialchars($mail->ErrorInfo) . "</span>";
                    }
                } else {
                    $mensagem = "<span class='error'>Resposta incorreta. Tente novamente.</span>";
                }
            }
        } else {
            $mensagem = "<span class='error'>E-mail não encontrado.</span>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Identidade</title>
    <link rel="stylesheet" href="CSS/2fa.css">
    <link rel="shortcut icon" href="Favicon/Anel pintado.png" type="image/x-icon">
</head>
<body>
    <div class="fundo">
        <img src="Imagem/Background-Banner-Desktop.webp" alt="Imagem de fundo">
    </div>

    <div class="form-container">
        <div class="logo">
            <img id="logo" src="Imagem/Logo-retangular-2-branca.webp" alt="Logo">
        </div>

        <h2>Verificação de Identidade</h2>
        <form method="POST">
            <label for="email">Digite seu e-mail:</label>
            <input type="email" id="email" name="email" placeholder="Seu e-mail" required>

            <?php if (!empty($_SESSION['pergunta'])): ?>
                <label for="resposta"><?= htmlspecialchars($_SESSION['pergunta']) ?></label>
                <input type="text" id="resposta" name="resposta" placeholder="Sua resposta" required>
            <?php endif; ?>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
