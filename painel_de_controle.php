<?php
 session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?erro=nao_autenticado");
    exit();
}

// Verifica se é o usuário master
if ($_SESSION['usuario_id'] !== 999999) { // ID 999999 é do master
    header("Location: dashboard.php?erro=acesso_negado");
    exit();
}


include('./PHP/conexao.php');

// Inicializa a variável de busca
$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$busca = filter_input(INPUT_GET, "busca", FILTER_DEFAULT);

 //Remove Tags HTML e PHP
 $busca = strip_tags ($busca);

 //Converte caracteres especiais para evitar a execução de código
 $busca = htmlspecialchars($busca, ENT_QUOTES, "UTF-8");

// Verifica se foi digitado algo no campo de busca
if (!empty($busca)) {
    // Consulta com filtro de busca por nome
    $query = "SELECT * FROM usuario WHERE nome LIKE '%$busca%'";
} else {
    // Consulta normal sem filtro
    $query = "SELECT * FROM usuario";
}

$result = $conn->query($query);



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <div class="container">
        <h1>Seja bem vindo ao painel de controle</h1>
        <h3>Aqui você terá acesso a todos os usuários cadastrados em nossa plataforma.</h3>
                <form action="logout.php" method="POST">
                    <input type="submit" value="Logout" class="button">
                </form>
        <!-- Formulário de busca -->
        <form method="GET">
                <input type="text" name="busca" placeholder="Buscar por nome" value="<?=$busca?>">
                <button class="btn waves-effect waves-light" type="submit">Buscar</button>
            </form>
            <br>
            <table class="striped">
            <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Genero</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ação</th>
            </tr>
            <?php while ($usuario = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $usuario['id_usuario'] ?></td>
                        <td><?= $usuario['nome'] ?></td>
                        <td><?= $usuario['genero'] ?></td>
                        <td><?= $usuario['cpf'] ?></td>
                        <td><?= $usuario['telefonecelular'] ?></td>
                        <td><?= $usuario['email'] ?></td>
        
                        <td>
                            <a href="PHP/deletar_usuario.php?id=<?= $usuario['id_usuario'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        
        </div>
    </div>

    <!-- JavaScript MATERIALIZE CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    
</body>
</html>