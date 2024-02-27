<?php
include 'funcoes.php';
verificarAutenticacao();
?>

<!-- Configurações -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>SIOG - Configurações</title>
    <!-- STYLES -->
    <link rel="stylesheet" href="../css/style0.css">
    <!-- ALERT STYLES -->
    <link rel="stylesheet" href="../css/alerts.css">
</head>
<body>
    <!-- CONFIG -->
    <div class="container">
        <div class="settings-container">

            <!-- Foto de Perfil e Email -->
            <div class="profile-info">
                <?php
                echo '<img src="' . $_SESSION['PHOTO'] . '" alt="">';
                ?>
                <p>Email Registrado: 
        <?php
        echo $_SESSION['EMAIL'];
        ?>
    </p>
                <!-- Lembrar de alterar esta parte, colocar email conforme a session e dar refresh no email da session -->
            </div>

            <!-- Formulário de Configurações -->
            <div class="settings-form">
                <div class="settings">
                    <h2>Configurações</h2>
                    <form action="configuracoes.php" method="post" enctype="multipart/form-data">
                        <label for="email">Novo Email:</label>
                        <input type="email" id="email" name="email" >

                        <label for="password">Nova Senha:</label>
                        <input type="password" id="password" name="password">

                        <label for="profile-picture">Nova Foto de Perfil:</label>
                        <input type="file" id="profile-picture" name="profile-picture" accept="image/*">

                        <button type="submit">Salvar Alterações</button>
                    </form>
                </div>
            </div>

            <?php
                include 'conexao.php'; 

                // Recuperação de dados do formulários
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $email = $_POST['email'];
                    $senha = $_POST['password'];
                    $photo = $_FILES['profile-picture']; 
                    $user = $_SESSION['EMAIL'];
                    // Preencher user conforme a session e dar refresh nela

                    // Preenchimento de arrays para query, preencho os valores e as colunas que serão incluídas na query
                    $updateFields = array();
                    $updateValues = array();

                    // Verificação se há campo vazios do formulário
                    if (!empty($email)) {
                        $updateFields[] = "email=?";
                        $updateValues[] = $email;
                    }

                    if (!empty($senha)) {
                        $updateFields[] = "password=?";
                        $updateValues[] = $senha;
                    }

                    if (!empty($photo['name'])) {
                        if ($photo['error']) {
                            die("<div class='alert alert-danger alert-bottom'>Falha ao enviar foto!</div>");
                        }

                        if ($photo['size'] > 3145728) {
                            die("<div class='alert alert-danger alert-bottom'>Imagem muito grande!! Max: 3,5MB</div>");
                        }

                        // Arquivamento das fotos de perfil. Obs.: As fotos ficam salvas, apenas altero o caminho, conforme um HD
                        $pasta = "../imgs/";
                        $novoNomeDoArquivo = "profile_" . uniqid();
                        $extensao = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
                        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

                        if ($extensao != 'jpg' && $extensao != 'png' && $extensao != 'svg') {
                            die("<div class='alert alert-danger alert-bottom'>Tipo de imagem não aceita!</div>");
                        }

                        $verificador = move_uploaded_file($photo["tmp_name"], $path);

                        if (!$verificador) {
                            die("<div class='alert alert-danger alert-bottom'>Tente novamente ocorreu algum tipo de falha!</div>");
                        }

                        $updateFields[] = "path=?";
                        $updateValues[] = $path;
                    }

                    $updateFieldsString = implode(", ", $updateFields);

                    // Querry para update no banco
                    if (!empty($updateFieldsString)) {
                        $sql = 'UPDATE Usuarios SET ' . $updateFieldsString . ' WHERE email = ?';
                        
                        $stmt = $conn->prepare($sql);
                        
                        if (!empty($updateValues)) {
                            $types = str_repeat('s', count($updateValues) + 1);
                            $stmt->bind_param($types, ...array_merge($updateValues, [$user]));
                        }

                        // Mensagens de tratamento
                        if ($stmt->execute()) {
                            if ($stmt->affected_rows > 0) {
                                echo "<div class='alert alert-success alert-bottom'>Cadastro atualizado!</div>";
                    
                                // Atualizar a SESSION com os novos valores
                                if (!empty($email)) {
                                    $_SESSION['EMAIL'] = $email;
                                }
                    
                                if (!empty($path)) {
                                    $_SESSION['PHOTO'] = $path;
                                }
                    
                            } else {
                                echo "<div class='alert alert-warning alert-bottom'>Nenhuma alteração realizada no cadastro.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger alert-bottom'>Erro ao atualizar: " . $stmt->error . "</div>";
                        }
                    
                    $conn->close();
                    echo "<script>window.parent.postMessage('atualizacaoConcluida', '*');</script>";

                }
            }
            ?>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
window.addEventListener('message', function(event) {
    if (event.data === 'atualizacaoConcluida') {
        location.reload(); 
    }
});
</script>
</body>
</html>
