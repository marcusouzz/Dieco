<?php
// Iniciar sessão para carregar mensagens entre redirecionamentos
session_start();

// Verificar se o formulário de login foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Verificar se os campos não estão vazios
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Por favor, preencha o nome de usuário e a senha.";
        header("Location: index.php");
        exit;
    }

    // Incluir o arquivo de dados cadastrais
    include 'dados_cadastrais.php';

    // Verificar se $dados_cadastrais é um array
    if (!is_array($dados_cadastrais)) {
        $_SESSION['error_message'] = "Erro no sistema: dados de usuários inválidos.";
        header("Location: index.php");
        exit;
    }

    // Chave de criptografia (deve ser a mesma usada no registro)
    $encryption_key = 'sua_chave_secreta'; // Deve ser a mesma chave que você usa no registrar.php

    // Função para descriptografar
    function decrypt_data($data, $key, $iv) {
        return openssl_decrypt(base64_decode($data), 'aes-256-cbc', $key, 0, base64_decode($iv));
    }

    // Verificar cada usuário cadastrado
    $found_user = false;
    foreach ($dados_cadastrais as $usuario) {
        // Garantir que $usuario seja um array
        if (!is_array($usuario)) {
            continue; // Pular se houver problema no formato do usuário
        }

        // Descriptografar o nome de usuário usando o IV correto
        $decrypted_username = decrypt_data($usuario['username'], $encryption_key, $usuario['iv']);

        // Verificar se o nome de usuário fornecido corresponde ao armazenado
        if ($username === $decrypted_username) {
            $found_user = true;

            // Verificar se a senha fornecida corresponde à senha armazenada
            if (password_verify($password, $usuario['password'])) {
                // Login bem-sucedido
                $_SESSION['username'] = $decrypted_username; // Armazenar nome de usuário na sessão
                header("Location: home.php"); // Redirecionar para a página inicial ou painel de controle
                exit;
            } else {
                $_SESSION['error_message'] = "Senha incorreta.";
                header("Location: index.php");
                exit;
            }
        }
    }

    // Caso o nome de usuário não seja encontrado
    if (!$found_user) {
        $_SESSION['error_message'] = "Nome de usuário não encontrado.";
        header("Location: index.php");
        exit;
    }
} else {
    die("Método de requisição inválido.");
}
?>
