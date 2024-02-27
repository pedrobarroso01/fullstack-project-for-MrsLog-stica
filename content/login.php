<?php
session_start();
include_once('conexao.php');

// Limites de tentativas e bloqueio
$limite_tentativas = 5;

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para obter informações do usuário
    $sql = "SELECT usuarios.id, usuarios.username, usuarios.password, usuarios.tentativas, usuarios.bloqueado, usuarios.idAcesso FROM usuarios INNER JOIN Acesso ON Acesso.idAcesso = usuarios.idAcesso WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $usuario_id = $row['id'];
        $tentativas = $row['tentativas'];
        $bloqueado = $row['bloqueado'];
        $acesso = $row['idAcesso'];

        if (!$bloqueado) {
            if ($password == $row['password']) {
                // Login bem-sucedido
                echo '<style>.success-message { background-color: #4CAF50; color: white; padding: 15px; font-size: 18px; text-align: center; }</style>';
                echo '<div class="success-message">Login bem-sucedido!</div>';
                // Reinicia as tentativas
                resetarTentativas($conn, $usuario_id);
                $_SESSION['id_User'] = $usuario_id;

                if ($acesso == 1) {
                    $querry = "SELECT usuarios.id AS idUsuario, usuarios.username, usuarios.email, usuarios.path, usuarios.password,
                    emprei.idEmpreiteira, emprei.nome AS nomeEmpreiteira,
                    sede.idSede, sede.nome AS nomeSede
                    FROM usuarios
                    LEFT JOIN Empreiteiras AS emprei ON emprei.idEmpreiteira = usuarios.idEmpreiteira
                    LEFT JOIN Sedes AS sede ON sede.idSede = usuarios.idSede WHERE usuarios.idAcesso=1 AND usuarios.id='" . $_SESSION['id_User'] . "';";

                    $result = mysqli_query($conn, $querry) or die(mysqli_error($conn));

                    $row = mysqli_fetch_assoc($result);

                    $_SESSION['USERNAME'] = $row['username'];
                    $_SESSION['EMAIL'] = $row['email'];
                    $_SESSION['ID_EMPREI'] = $row['idEmpreiteira'];
                    $_SESSION['NOME_EMPREI'] = $row['nomeEmpreiteira'];
                    $_SESSION['PHOTO'] = $row['path'];
                    $_SESSION['nivel_acesso'] =  $acesso;

                    echo '<script>
                    setTimeout(function() {
                        window.location.href = "dashEmprei.php";
                    }, 2000);
                </script>';
                } else {
                    $querry = "SELECT usuarios.id AS idUsuario, usuarios.username, usuarios.email, usuarios.path, usuarios.password,
                    emprei.idEmpreiteira, emprei.nome AS nomeEmpreiteira,
                    sede.idSede, sede.nome AS nomeSede
                    FROM usuarios
                    LEFT JOIN Empreiteiras AS emprei ON emprei.idEmpreiteira = usuarios.idEmpreiteira
                    LEFT JOIN Sedes AS sede ON sede.idSede = usuarios.idSede WHERE usuarios.idAcesso=2 AND usuarios.id='" . $_SESSION['id_User'] . "';";

                    $result = mysqli_query($conn, $querry) or die(mysqli_error($conn));

                    $row = mysqli_fetch_assoc($result);

                    $_SESSION['USERNAME'] = $row['username'];
                    $_SESSION['EMAIL'] = $row['email'];
                    $_SESSION['ID_SEDE'] = $row['idSede'];
                    $_SESSION['NOME_SEDE'] = $row['nomeSede'];
                    $_SESSION['PHOTO'] = $row['path'];
                    $_SESSION['nivel_acesso'] =  $acesso;
                    echo '<script>
                    setTimeout(function() {
                        window.location.href = "dashSede.php";
                    }, 2000);
                </script>';
                }
                exit();
            } else {
                // Senha incorreta
                $tentativas++;
                if ($tentativas > $limite_tentativas) {
                    bloquearConta($conn, $usuario_id);
                    echo '<style>.error-message { background-color: #FF5252; color: white; padding: 15px; font-size: 18px; text-align: center; }</style>';
                    echo '<div class="error-message">Limite de tentativas excedido. Conta bloqueada.</div>';
                    echo '<script>
                setTimeout(function() {
                    window.location.href = "../index.html";
                }, 2000);
                </script>';
                } else {
                    atualizarTentativas($conn, $usuario_id, $tentativas);
                    echo '<style>.error-message { background-color: #FF5252; color: white; padding: 15px; font-size: 18px; text-align: center; }</style>';
                    echo '<div class="error-message">Credenciais inválidas. Tentativas restantes: ' . ($limite_tentativas - $tentativas) . '</div>';
                    echo '<script>
                setTimeout(function() {
                    window.location.href = "../index.html";
                }, 2000);
                </script>';
                }
            }
        } else {
            echo '<style>.error-message { background-color: #FF5252; color: white; padding: 15px; font-size: 18px; text-align: center; }</style>';
            echo '<div class="error-message">Conta bloqueada. Entre em contato com o suporte.</div>';
            echo '<script>
                setTimeout(function() {
                    window.location.href = "../index.html";
                }, 2000);
                </script>';
        }
    } else {
        // Usuário não encontrado
        echo '<style>.error-message { background-color: #FF5252; color: white; padding: 15px; font-size: 18px; text-align: center; }</style>';
        echo '<div class="error-message">Credenciais inválidas.</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "../index.html";
                },
 2000);
            </script>';
    }

    $stmt->close();
}

// Função para atualizar o contador de tentativas no banco de dados
function atualizarTentativas($conn, $usuario_id, $tentativas) {
    $sql = "UPDATE usuarios SET tentativas = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $tentativas, $usuario_id);
    $stmt->execute();
    $stmt->close();
}

// Função para reiniciar o contador de tentativas no banco de dados
function resetarTentativas($conn, $usuario_id) {
    $sql = "UPDATE usuarios SET tentativas = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();
}

// Função para bloquear a conta
function bloquearConta($conn, $usuario_id) {
    $sql = "UPDATE usuarios SET tentativas = 0, bloqueado = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>