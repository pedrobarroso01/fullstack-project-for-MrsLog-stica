<?php
if(isset($_POST['idOS'])) {
    include 'conexao.php';

    $id = $_POST['idOS'];

    $sql = "DELETE FROM OrdensDeServico WHERE idOS = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Ordem de serviço excluída com sucesso.";
    } else {
        echo "Erro ao excluir a ordem de serviço: " . $conn->error;
    }
    $conn->close();
    exit; 
}
?>