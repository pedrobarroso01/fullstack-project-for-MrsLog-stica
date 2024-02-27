<?php
include 'funcoes.php';
verificarAutenticacao();
?>

<?php
include 'conexao.php'; 

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém o ID do ticket da consulta GET
$ticketId = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

// Busca as informações detalhadas do ticket
$sql = "SELECT OS.idOS,OS.titulo as titulo, OS.descricao, OS.dataAbertura, OS.dataFechamento, OS.path_, 
               StatusOs.nameStatus AS status, AssuntoOS.nameAssunto AS assunto, 
               Empreiteiras.nome AS nomeEmpreiteira, Empreiteiras.idEmpreiteira AS idEmpreiteira,
               Sedes.nome AS nomeSede, Sedes.idSede AS idSede 
        FROM OrdensDeServico as OS 
        INNER JOIN Empreiteiras ON OS.idEmpreiteira = Empreiteiras.idEmpreiteira
        INNER JOIN Sedes ON OS.idSede = Sedes.idSede 
        INNER JOIN StatusOs ON OS.idStatus = StatusOs.idStatus 
        INNER JOIN AssuntoOS ON OS.idAssunto = AssuntoOS.idAssunto
        WHERE OS.idOS = $ticketId"; 

$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    echo '<p>'.$row['titulo'].' #00' . $row['idOS'] . '</p>';
    
    $statusClass = ($row['status'] == 'Concluída') ? 'delivered' : (($row['status'] == 'Em Andamento') ? 'send' :  (($row['status'] == 'Reenviada') ? 'resend' : 'pending'));
    echo '<p><span class=" status ' . $statusClass . '">Status: ' . $row['status'] . '</span></p>';
    
    echo '<p>Categoria: ' . $row['assunto'] . '</p>';
    echo '<p>Descrição: ' . $row['descricao'] . '</p>';
    echo '<p>Data de Chegada: ' . date("d/m/y H:i", strtotime($row['dataAbertura'])) . '</p>';
    echo '<p>Data de Fechamento: ' . $row['dataFechamento'] . '</p>';
    echo '<p>Destino: ' . $row['nomeSede'] . '</p>';
    echo '<p>Origem: ' . $row['nomeEmpreiteira'] . '</p>';
}

 else {
    echo 'Ticket não encontrado.';
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
