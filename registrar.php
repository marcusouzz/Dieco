<?php
session_start();

// Defina a chave de encriptação e o IV
$encryption_key = 'sua_chave_secreta'; // Defina uma chave de encriptação segura
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

function encrypt_data($data, $encryption_key, $iv) {
    $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted_data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Verifique se as senhas correspondem
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "As senhas não correspondem.";
        header("Location: criar_conta.php");
        exit;
    }

    // Lógica de upload da imagem
    $profilePicturePath = ''; // Inicialize a variável para o caminho da imagem
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Certifique-se de que esta pasta existe e tem permissões de escrita
        $uploadFile = $uploadDir . basename($_FILES['profile_picture']['name']);
        
        // Verifique o tipo de arquivo (opcional)
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Mova o arquivo para o diretório de upload
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                $profilePicturePath = $uploadFile; // Salve o caminho da imagem
            } else {
                $_SESSION['error_message'] = "Erro ao fazer upload da imagem.";
                header("Location: criar_conta.php");
                exit;
            }
        } else {
            $_SESSION['error_message'] = "Formato de arquivo não suportado.";
            header("Location: criar_conta.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Erro no upload do arquivo.";
        header("Location: criar_conta.php");
        exit;
    }

    // Criptografar e salvar os dados
    $encrypted_username = encrypt_data($username, $encryption_key, $iv);
    $encrypted_email = encrypt_data($email, $encryption_key, $iv);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Salvar dados no array de usuários
    $dados_cadastrais = []; // Inicializa a variável
    if (file_exists('dados_cadastrais.php')) {
        include 'dados_cadastrais.php'; // Inclua os dados existentes, se houver
    }
    
    $dados_cadastrais[] = [
        'username' => $encrypted_username,
        'email' => $encrypted_email,
        'password' => $hashed_password,
        'profile_picture' => $profilePicturePath, // Armazena o caminho da imagem de perfil
        'iv' => base64_encode($iv) // Salve o IV para o username
    ];

    // Salvar dados no arquivo
    file_put_contents('dados_cadastrais.php', '<?php $dados_cadastrais = ' . var_export($dados_cadastrais, true) . ';');

    // Redirecionar ou mostrar mensagem de sucesso
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - DIECO</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css"> <!-- Caminho do CSS -->
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="error">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="registrar.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Senha" required>
            <input type="password" name="confirm_password" placeholder="Confirme a Senha" required>
            <input type="file" name="profile_picture" accept="image/*" required> <!-- Campo para a imagem de perfil -->
            <button type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>
