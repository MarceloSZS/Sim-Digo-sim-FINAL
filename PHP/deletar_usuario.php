<?php
 session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php?erro=nao_autenticado");
    exit();
}

// Verifica se é o usuário master
if ($_SESSION['usuario_id'] !== 999999) { // ID 999999 é do master
    header("Location: ../dashboard.php?erro=acesso_negado");
    exit();
}

include('conexao.php');

$id = $_GET['id'];
$query = "DELETE FROM usuario WHERE id_usuario = $id";
$conn->query($query);

header("Location: ../painel_de_controle.php");
?>
