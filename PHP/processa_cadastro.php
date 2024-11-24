<?php
// Conexão com o banco de dados
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $nome_materno = $conn->real_escape_string(trim($_POST['nome_materno']));
    $cpf = $conn->real_escape_string(trim($_POST['cpf']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $senha = $conn->real_escape_string(trim($_POST['senha']));
    $estado = $conn->real_escape_string(trim($_POST['estado']));
    $data_nascimento = $conn->real_escape_string(trim($_POST['data']));
    $telefonecelular = $conn->real_escape_string(trim($_POST['telefoneCelular']));
    $genero = $conn->real_escape_string(trim($_POST['genero'])); 
    $cep = $conn->real_escape_string(trim($_POST['cep']));
    $endereco = $conn->real_escape_string(trim($_POST['endereco']));
    $complemento = $conn->real_escape_string(trim($_POST['complemento']));
    $bairro = $conn->real_escape_string(trim($_POST['bairro']));
    $cidade = $conn->real_escape_string(trim($_POST['cidade']));
    $aceitou_termos = isset($_POST['termos']) ? 1 : 0;

    // Validação inicial
    $erros = [];
    if (empty($nome)) $erros[] = "O campo nome é obrigatório!";
    if (empty($nome_materno)) $erros[] = "O campo nome materno é obrigatório!";
    if (empty($cpf)) $erros[] = "O campo CPF é obrigatório!";
    if (empty($email)) $erros[] = "O campo e-mail é obrigatório!";
    if (empty($senha)) $erros[] = "O campo senha é obrigatório!";
    if (empty($estado)) $erros[] = "O campo estado é obrigatório!";
    if (empty($data_nascimento)) $erros[] = "A data do casamento é obrigatória!";
    if (empty($telefonecelular)) $erros[] = "O telefone celular é obrigatório!";
    if (empty($genero)) $erros[] = "O Genero é obrigatório";
    if (empty($cep)) $erros[] = "O campo CEP é obrigatório!";
    if (empty($endereco)) $erros[] = "O campo endereço é obrigatório!";
    if (empty($complemento)) $erros[] = "O campo complemento é obrigatório!";
    if (empty($bairro)) $erros[] = "O campo bairro é obrigatório!";
    if (empty($cidade)) $erros[] = "O campo cidade é obrigatório!";
    if (!$aceitou_termos) $erros[] = "Você deve aceitar os termos de uso!";

    if (count($erros) > 0) {
        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
        exit();
    }



    // Verificar duplicidade de email e cpf
    $sql_verifica = "SELECT id_usuario FROM usuario WHERE email = ? OR cpf = ?";
    $stmt = $conn->prepare($sql_verifica);
    $stmt->bind_param("ss", $email, $cpf);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        // Duplicidade detectada
        header("Location: ../cadastro.php?erro=duplicidade");
        exit();
    }

    // Hash da senha
    $senha_hashed = password_hash($senha, PASSWORD_BCRYPT);

    // Prepara e executa a consulta SQL com bind de parâmetros para evitar SQL injection
    $stmt = $conn->prepare("
        INSERT INTO usuario 
        (nome, email, senha, estado, data_nascimento, telefonecelular, genero, aceitou_termos, 
         nome_materno, cpf, cep, endereco, complemento, bairro, cidade) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssssssssssss",
        $nome, $email, $senha_hashed, $estado, $data_nascimento, $telefonecelular, $genero, $aceitou_termos, 
        $nome_materno, $cpf, $cep, $endereco, $complemento, $bairro, $cidade
    );

    if ($stmt->execute()) {
        // Redireciona para a página de login
        header("Location: ../login.php");
        exit();
    } else {
        echo "<p style='color: red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
    }

    // Fecha a declaração preparada
    $stmt->close();
}

// Fecha a conexão com o banco
$conn->close();
?>
