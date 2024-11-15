<?php
session_start(); // Certifique-se de que o session_start() esteja no topo
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login - DIECO</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css"> <!-- Arquivo CSS externo -->
    <style>
        .message {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background-color: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="img/icon.png" alt="Ícone de reciclagem">
        <h1>DIECO</h1>
        <h2>Ecologia Digital</h2>

        <!-- Exibir mensagens de erro ou sucesso -->
        <?php
        if (isset($_SESSION['error_message'])): ?>
            <div id="message" class="message error">
                <?php
                echo htmlspecialchars($_SESSION['error_message']);
                unset($_SESSION['error_message']); // Remover a mensagem após exibir
                ?>
            </div>
        <?php elseif (isset($_GET['message'])): ?>
            <div id="message" class="message">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de usuário">
                <input type="text" name="username" placeholder="Usuário" required>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de cadeado">
                <input type="password" name="password" placeholder="Senha" required>
            </div>

            <button type="submit" class="button">Login</button>

            <div class="links">
                <a href="criar_conta.php">Criar Conta</a>
            </div>
        </form>
    </div>

    <script>
        // Ocultar a mensagem de erro ou sucesso após 5 segundos
        window.onload = function() {
            var messageDiv = document.getElementById('message');
            if (messageDiv) {
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 5000); // 5000ms = 5 segundos
            }
        };
    </script>
</body>
</html>
