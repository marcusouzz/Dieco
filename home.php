<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Redireciona para a tela de login se não estiver autenticado
    exit();
}

// Carregar os dados dos usuários
include 'dados_cadastrais.php'; // Inclua o arquivo que contém os dados dos usuários

// Buscar os dados do usuário logado
$user_data = null;
foreach ($dados_cadastrais as $user) {
    if (openssl_decrypt(base64_decode($user['username']), 'aes-256-cbc', 'sua_chave_secreta', 0, base64_decode($user['iv'])) == $_SESSION['username']) {
        $user_data = $user;
        break;
    }
}

// Verificar se o usuário foi encontrado
if (!$user_data) {
    echo "Usuário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DIECO</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style_home.css"> <!-- Verifique se o caminho do CSS está correto -->
</head>
<body>

    <header>
        <div class="profile-section">
            <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>" alt="Foto do Usuário" class="profile-pic">
            <div class="user-info">
                <h2><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                <p><?php echo htmlspecialchars(openssl_decrypt(base64_decode($user_data['email']), 'aes-256-cbc', 'sua_chave_secreta', 0, base64_decode($user_data['iv']))); ?></p> <!-- Exibe o email do usuário -->
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn-logout">Desconectar</button>
                </form>
            </div>
        </div>
        <div class="logo-section">
            <img src="img/icon.png" alt="Logo DIECO">
        </div>
        <div class="search-section">
            <input type="text" placeholder="Pesquise Pontos de Reciclagem perto de você!">
        </div>
    </header>

    <main>
        <section class="main-options">
            <a href="minha_reciclagem.php" class="option">
                <img src="img/icon.png" alt="Minha Reciclagem">
                <p>Minha Reciclagem</p>
            </a>
            <a href="pontos_reciclagem.php" class="option">
                <img src="img/icon.png" alt="Pontos de Reciclagem">
                <p>Pontos de Reciclagens</p>
            </a>
            <a href="relatorios.php" class="option">
                <img src="img/icon.png" alt="Relatórios">
                <p>Relatórios</p>
            </a>
            <a href="materiais_reciclaveis.php" class="option">
                <img src="img/icon.png" alt="Matérias Recicláveis">
                <p>Matérias Recicláveis</p>
            </a>
            <a href="parceiros.php" class="option">
                <img src="img/icon.png" alt="Parceiros">
                <p>Parceiros</p>
            </a>
            <a href="recompensas.php" class="option">
                <img src="img/icon.png" alt="Recompensas">
                <p>Recompensas</p>
            </a>
        </section>

        <!-- Navegação do Rodapé -->
        <nav class="bottom-nav">
            <a href="perfil.php">Perfil</a>
            <a href="locais.php">Locais</a>
            <a href="home.php" class="active">Início</a>
            <a href="relatorios.php">Relatórios</a>
            <a href="recado.php">Recado</a>
        </nav>

    </main>

    <footer>
        <p>A sustentabilidade se resume em três palavras: reduzir, reusar, reciclar.</p>
    </footer>

</body>
</html>