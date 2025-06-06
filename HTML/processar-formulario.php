<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "aquisicao_produto";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo "Erro na conexão com o banco de dados: " . $conn->connect_error;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefone = preg_replace('/\D/', '', $_POST['telefone']);
    $servico = trim($_POST['servico']);
    $detalhes = trim($_POST['detalhes']);

    // Validações básicas
    if (strlen($nome) < 3 || strlen($nome) > 100 || !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
        echo "Nome inválido.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido.";
        exit;
    }

    if (!preg_match("/^\d{11}$/", $telefone)) {
        echo "Telefone inválido.";
        exit;
    }

    if (strlen($detalhes) < 10 || strlen($detalhes) > 255) {
        echo "Detalhes inválidos.";
        exit;
    }
    
    $sql = "INSERT INTO solicitacoes (nome, email, telefone, servico, detalhes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $telefone, $servico, $detalhes);

    if ($stmt->execute()) 
	{
        header('Location: requisicaoOK.html');
		exit;
    } 
	else 
	{
        echo "Erro ao enviar a solicitação: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>