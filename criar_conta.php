<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - DIECO</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css"> <!-- Arquivo CSS externo -->
    <style>
        /* Estilos adicionais para a pré-visualização */
        .preview {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }
        .preview img {
            max-width: 150px; /* Ajusta a largura máxima da imagem */
            max-height: 150px; /* Ajusta a altura máxima da imagem */
            border-radius: 10px; /* Bordas arredondadas para a imagem */
            border: 1px solid #ddd; /* Borda ao redor da imagem */
            object-fit: cover; /* Mantém a proporção da imagem */
            display: none; /* Inicialmente, a imagem não é exibida */
        }
    </style>
    <script>
        function updateFileName(input) {
            // Atualiza a pré-visualização da imagem
            const file = input.files[0];
            const previewImage = document.getElementById('preview-image');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block'; // Mostra a imagem
                }
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none'; // Esconde a imagem se nenhum arquivo for selecionado
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <img src="img/icon.png" alt="Ícone de reciclagem">
        <h1>Criar Conta</h1>
        <h2>Ecologia Digital</h2>

        <form action="registrar.php" method="POST" enctype="multipart/form-data"> <!-- Adicione o enctype para upload de arquivos -->

            <div class="preview">
                <img id="preview-image" src="" alt="Pré-visualização da Imagem"> <!-- Pré-visualização da imagem -->
            </div>

            <div class="input-container">
                <label class="custom-file-upload">
                    <input type="file" name="profile_picture" accept="image/*" required onchange="updateFileName(this)">
                    Escolher Foto de Perfil
                </label>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de usuário">
                <input type="text" name="name" placeholder="Nome Completo" required>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de e-mail">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de usuário">
                <input type="text" name="username" placeholder="Usuário" required>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de cadeado">
                <input type="password" name="password" placeholder="Senha" required>
            </div>

            <div class="input-container">
                <img src="img/icon.png" alt="Ícone de cadeado">
                <input type="password" name="confirm_password" placeholder="Confirmar Senha" required>
            </div>

            <button type="submit" class="button">Criar Conta</button>

            <div class="links">
                <a href="index.php">Já possui uma conta? Login</a>
            </div>
        </form>
    </div>
</body>
</html>
