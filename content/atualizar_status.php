<?php
    // Verifica se o método de requisição é POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica se o ID do ticket e o novo status estão definidos no formulário
        if (isset($_POST['ticket_id']) && isset($_POST['new_status'])) {
            // Obtém o ID do ticket e o novo status do formulário
            $ticket_id = $_POST['ticket_id'];
            $new_status = $_POST['new_status'];

            // Inclui o arquivo de conexão com o banco de dados
            include 'conexao.php';

            // Verifica se o novo status é um dos status permitidos
            $allowed_statuses = array('Concluída', 'Em Andamento', 'Reenviada', 'Pendência');
            if (in_array($new_status, $allowed_statuses)) {
                // Atualiza o status do ticket no banco de dados
                $query = "UPDATE OrdensDeServico SET idStatus = (SELECT idStatus FROM StatusOS WHERE nameStatus = '$new_status') WHERE idOS = '$ticket_id'";
                $result = $conn->query($query);

                // Verifica se a atualização foi bem-sucedida
                if ($result) {
                    echo "<script>alert('Status atualizado com sucesso.');";
                    echo "window.location.href = 'consultaSede.php?id=$ticket_id';</script>";
                } else {
                    echo "<script>alert('Erro ao atualizar o status do ticket') </script>" . $conn->error;
                }
            } else {
                echo "Status inválido.";
            }

            // Fecha a conexão com o banco de dados
            $conn->close();
        } else {
            echo "ID do ticket e novo status não estão definidos.";
        }
    } else {
        echo "Método de requisição inválido.";
    }
?>
