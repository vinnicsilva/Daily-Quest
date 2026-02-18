<?php 
     Class Pessoa {

            private $pdo;
            
            public function __construct($dbname, $host, $user, $pass)
            {
                try {
                    $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $pass);
                } catch (PDOException $e) {
                    echo "Erro ao acessar banco de dados: " . $e->getMessage();
                    exit();
                } catch (Exception $e) {
                    echo "Erro: " . $e->getMessage();
                    exit();
                }
            }

            // Mostrar Dados
            public function buscarDados()
            {
                $res = array();
                $cmd = $this->pdo->prepare("SELECT * FROM user_database ORDER BY nome");
                $cmd->execute();
                $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }

            // Cadastrar Dados
            public function cadastrarPessoa($nome, $email, $senha)
            {
                // antes de cadastrar, verificação de email
                $cmd = $this->pdo->prepare("SELECT id FROM user_database WHERE email = :e");
                $cmd->bindValue(":e", $email);
                $cmd->execute();
                if ($cmd->rowCount() > 0) {
                    return false;
                } else {
                    $cmd = $this->pdo->prepare("INSERT INTO user_database (nome, email, senha) VALUES (:n, :e, :s)");
                    $cmd->bindValue(":n", $nome);
                    $cmd->bindValue(":e", $email);
                    $cmd->bindValue(":s", md5($senha));
                    $cmd->execute();
                    return true;
                }
            }

            // Excluir Usuário
            public function excluirPessoa($id)
            {
                $res = array();
                $cmd = $this->pdo->prepare("DELETE FROM user_database WHERE id = :id");
                $cmd->bindValue(":id", $id);
                $cmd->execute();
                $res = $cmd->fetch(PDO::FETCH_ASSOC);
                return $res;
            }

            // Buscar Dados de um Usuário
            public function buscarDadosUsuario($id)
            {
                $cmd = $this->pdo->prepare("SELECT * FROM user_database WHERE id = :id");
                $cmd->bindValue(":id", $id);
                $cmd->execute();
                return $cmd->fetch(PDO::FETCH_ASSOC);
            }

            // Editar Usuário
            public function editarPessoa($id, $nome, $email, $senha) {
                // Verificar se o email já existe em OUTRO usuário
                $cmd = $this->pdo->prepare("SELECT id FROM user_database WHERE email = :e AND id != :id");
                $cmd->bindValue(":e", $email);
                $cmd->bindValue(":id", $id);
                $cmd->execute();
                
                if ($cmd->rowCount() > 0) {
                    return false; // Email já existe em outro usuário
                } else {
                    // Se a senha foi alterada (não está vazia), atualiza a senha
                    if (!empty($senha)) {
                        $cmd = $this->pdo->prepare("UPDATE user_database SET nome = :n, email = :e, senha = :s WHERE id = :id");
                        $cmd->bindValue(":s", md5($senha));
                    } else {
                        // Se a senha não foi alterada, mantém a senha atual
                        $cmd = $this->pdo->prepare("UPDATE user_database SET nome = :n, email = :e WHERE id = :id");
                    }
                    
                    $cmd->bindValue(":n", $nome);
                    $cmd->bindValue(":e", $email);
                    $cmd->bindValue(":id", $id);
                    $cmd->execute();
                    return true;
                }
            }
        }
?>