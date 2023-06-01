<?php

// Configurações do banco de dados MySQL
$dbHost = "localhost";
$dbUser = "seu_usuario";
$dbPass = "sua_senha";
$dbName = "seu_banco_de_dados";

// Conecta ao banco de dados
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém os dados do e-mail
    $email = file_get_contents('php://input');
    $data = json_decode($email);

    // Verifica se os dados estão corretos
    if (!empty($data->subject) && !empty($data->body)) {
        $titulo = $conn->real_escape_string($data->subject);
        $conteudo = $conn->real_escape_string($data->body);

        // Insere a postagem no banco de dados
        $sql = "INSERT INTO posts (titulo, conteudo) VALUES ('$titulo', '$conteudo')";
        if ($conn->query($sql) === TRUE) {
            echo "Postagem criada com sucesso!";
        } else {
            echo "Erro ao criar a postagem: " . $conn->error;
        }
    } else {
        echo "Dados do e-mail incompletos!";
    }
}

$conn->close();
