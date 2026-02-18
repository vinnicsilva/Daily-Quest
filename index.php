<?php 

session_start();

require_once 'classe_pessoa.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=database_teste', 'root', '');
} catch (PDOException $e) {
    echo 'Falha ao Acesso de Banco de Dados: ' . $e->getMessage(); 
} catch (Exception $e) {
    echo 'Erro de Conexão: ' . $e->getMessage();
}

// Verifica se o usuário está logado
$usuarioLogado = isset($_SESSION['usuario_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Quest - Realize suas Quests</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <a href="#">
            <h4>Daily Quest</h4>
        </a>
        <div class="user-tools">
            <?php if ($usuarioLogado): ?>
                <!-- Usuário logado - Mostra menu do usuário -->
                <img src="profilepics/user.webp" alt="foto de usuário">
                <div class="user-menu">
                    <a href="#" id="user-button">
                        <h4><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></h4>
                    </a>
                    <div class="user-dropdown" id="user-dropdown" aria-hidden="true">
                        <a href="#" id="edit-profile">EDITAR PERFIL</a>
                        <a href="logout.php" id="logout">SAIR</a>
                    </div>
                </div>
                <label>XP</label>
                <progress value="70" max="100">70%</progress>
            <?php else: ?>
                <!-- Usuário não logado - Mostra botão de login -->
                <a href="login.php" class="login-button">
                    <h4>Fazer Login</h4>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <h1>Lista de Tarefas</h1>
        <hr>
        <div class="tasks">
            <div class="hidden">
                <h6>Exemplo de Tarefa</h6>
                <p>Esta é uma tarefa de exemplo para mostrar como as tarefas serão exibidas.</p>
                <progress value="50" max="100">50%</progress>
                <div class="task-options">
                    <button class="check-btn"><i class="fas fa-check"></i></button>
                    <button class="edit-btn"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
        <div class="input-group">
            <input type="text" id="taskInput" placeholder="Adicione uma nova tarefa...">
            <button id="addTaskBtn"><i class="fas fa-plus"></i></button>
        </div>
        <ul id="taskList"></ul>
    </div>

    <footer>
        <p>Site criado por <a href="https://github.com/vinnicsilva">VinnicSilva</a></p>
    </footer>
</body>
</html>