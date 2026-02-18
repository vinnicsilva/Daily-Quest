<?php 
    session_start();
    require_once 'connection.php';

    $erro_name = '';
    $erro_email = '';
    $erro_password = '';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';
        $email = $_POST['email'] ?? '';

        // Busca o usuário pelo email OU nome
        $sql = "SELECT * FROM user_database WHERE email = ? OR name = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verifica a senha com hash
            if (password_verify($password, $user['password'])) {
                $_SESSION['id']         = $user['id'];
                $_SESSION['name']   = $user['name'];
                $_SESSION['email']      = $user['email'];

                header("Location: user_list.php");
                exit;
            } else {
                $erro_password = "Senha incorreta!";
            }
        } else {
            if (!empty($name)) $erro_name = "Nome de usuário não encontrado!";
            if (!empty($email))    $erro_email    = "Email não encontrado!";
        }
    }
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
    </header>

    <div class="container">
        <h1>Login</h1>
        <hr>
        <form action="" method="post">
            
            <label for="nome">Nome de Usuário</label>
            <input type="text" id="nome" name="name" required 
                    value="<?= htmlspecialchars($name) ?>">
            <?php if ($erro_name): ?>
                <p style="color:red;"><?= $erro_name ?></p>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required 
                    value="<?= htmlspecialchars($email) ?>">
            <?php if ($erro_email): ?>
                <p style="color:red;"><?= $erro_email ?></p>
            <?php endif; ?>

            <label for="password">Senha</label>
            <div class="senha">
                <input type="password" id="password" name="password" maxlength="8" required>
                <button type="button" class="viewpass" onclick="MostraSenha()">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <?php if ($erro_password): ?>
                <p style="color:red;"><?= $erro_password ?></p>
            <?php endif; ?>

            <button type="submit">Logar</button>
            <P>Não tem uma conta? <a href="register.php">Registre-se</a></P>
        </form>
    </div>

    <footer>
        <p>Site criado por <a href="https://github.com/vinnicsilva">VinnicSilva</a></p>
    </footer>
</body>
<script>
    function MostraSenha() {
    var senhaInput = document.getElementById("password");
    senhaInput.type = senhaInput.type === "password" ? "text" : "password";
}
</script>
</html>