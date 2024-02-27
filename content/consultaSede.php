<?php
include 'funcoes.php';
verificarAutenticacao();
?>

<!-- consulta.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Consulta - SIOG</title>
    <!-- Adicione estilos adicionais se necessário -->
        <style>
            /* Estilos fornecidos */
            {
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --blue: #023859;  /*AZUL DA LOGO*/
            --white: #fff;
            --black1: #222;
            --black2: #333; /* Alterado para uma cor mais escura */
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            background-color: var(--gray); /* Adapte conforme necessário */
            padding: 1rem;
        }

        .container {
            position: relative;
            width: 100%;
        }

        body {
            font-family: 'Ubuntu', sans-serif;
        }

        h1 {
            color: var(--blue);
            text-align: center;
            margin-top: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--white);
            border-radius: 8px;
            padding: 10px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar label {
            margin-right: 10px;
            color: var(--black2);
        }

        .search-bar input,
        .search-bar select,
        .search-bar button {
            padding: 8px;
            border: none;
            border-radius: 4px;
        }

        .search-bar input {
            flex: 1;
            margin-right: 10px;
            border: 1px solid var(--black2);
        }

        .search-bar select {
            flex: 1;
            margin-right: 10px;
            border: 1px solid var(--black2);
        }
        .demand-list {
            list-style-type: none;
            padding: 0;
            display: grid;
            gap: 20px;
        }
        
        .delete-btn {
            background-color: #023859;
            margin-left:2%;
        }
        #atualizar{
            background-color: #023859;
            margin-right:1%;

        }

        .demand-item {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .demand-item:hover {
            transform: scale(1.01); 
        }

        .demand-item span {
            display: block;
            padding: 10px;
            color: var(--black2);
        }

        .demand-item span:first-child {
            background-color: var(--blue);
            color: var(--white);
        }
            /*--MODAL--*/
        button{
            padding: .6rem 1.2rem;
            background-color: #888;
            color: #fff;
            border: none;
            border-radius: .25rem;
            cursor: pointer;
            opacity: 0.9;
            font-size: 1rem;
            transition: 0.4s;
        }

        .open-modal{
            background-color: #023859;
        }

        button:hover{
            opacity: 1;
        } 
        

#fade,#modal{
    transition: 0.5s;
    opacity: 0;
    pointer-events: none;
    display: none;
}

#fade.show {
    opacity: 1;
    pointer-events: all;
    display: block;
    background-color: transparent;
    backdrop-filter: blur(8px);
}

#modal.show {
    opacity: 1;
    pointer-events: all;
    display: block;
}


        #fade{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            z-index: 5;
        }

        #modal {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            z-index: 10;
            width: 500px;
            max-width: 90%;
            padding: 1.2rem; 
            border-radius: 0.5rem;
        }

        .modal-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }

        .modal-body p {
            margin-bottom: 1rem;
        }
        .status.send {
            padding: 2px 4px;
            background: #1795ce;
            color: var(--white);
            border-radius: 4px;
            font-weight: 500;
        }

        .status.delivered {
            padding: 2px 4px;
            background: #8de02c;
            color: var(--white);
            border-radius: 4px;
            font-weight: 500;
        }

        .status.pending {
            padding: 2px 4px;
            background: #f00;
            color: var(--white);
            border-radius: 4px;
            font-weight: 500;
        }

        .status.resend{
        padding: 2px 4px;
        background: #f59504;
        color: var(--white);
        border-radius: 4px;
        font-weight: 500;
    }

    #modal {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    z-index: 10;
    width: 500px;
    max-width: 90%;
    padding: 1.2rem; 
    border-radius: 0.5rem;
    overflow-y: auto; /* Adicionando rolagem vertical */
    max-height: calc(100% - 2.4rem); /* Definindo altura máxima do modal */
}

.modal-body {
    max-height: calc(100vh - 9rem); /* Ajustando altura máxima do corpo do modal */
    overflow-y: auto; /* Adicionando rolagem vertical */
}
.new_status {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        appearance: none; /* Remove os estilos padrão do sistema operacional */
        -webkit-appearance: none; /* Para compatibilidade com o Safari */
        -moz-appearance: none; /* Para compatibilidade com o Firefox */
        background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'); /* Adiciona uma seta personalizada */
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center;
    }

    /* Estilo para as opções do select */
    .new_status option {
        padding: 10px;
    }

     </style>
     <script src="../js/modal2.js" defer></script>
</head>
<body>
    <h1>Consulta</h1>

    <!-- Barra de Pesquisa -->
    <div class="search-bar">
        <form method="post" action="consultaSede.php">
            <label for="search">Pesquisar por Descrição:</label>
            <input type="text" id="search" name="search">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date">
            <label for="search">Status:</label>
            <select name="status">
                <option></option>
                <?php
                    include 'conexao.php'; 
                    $querry = "SELECT * FROM StatusOS;";
                    $result = $conn->query($querry);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()){
                            echo"<option value= '".$row['idStatus']."'>".$row['nameStatus']."</option>";
                        }
                    }
                    
                ?>
            </select>
            <button type="submit" class="open-modal">Buscar</button>
        </form>
    </div>

    <!-- Lista de Demandas -->
    <ul class="demand-list">
        <?php
            include 'conexao.php'; 
            // Verifica a conexão
            if ($conn->connect_error) {
                die("Falha na conexão com o banco de dados: " . $conn->connect_error);
            }

            // Querry de pesquisa
            $search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';
            $date = isset($_POST['date']) ? $conn->real_escape_string($_POST['date']) : '';
            $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : '';


            $sql = "SELECT OS.idOS,OS.titulo as titulo, OS.descricao as descricao, OS.dataAbertura as dataAbertura, OS.dataFechamento, OS.path_ as path, StatusOs.nameStatus AS status, StatusOs.idStatus AS idStatus,
            AssuntoOS.nameAssunto AS assunto, Empreiteiras.nome AS nomeEmpreiteira, Empreiteiras.idEmpreiteira AS idEmpreiteira,
            Sedes.nome AS nomeSede, Sedes.idSede AS idSede FROM OrdensDeServico as OS INNER JOIN Empreiteiras ON OS.idEmpreiteira = Empreiteiras.idEmpreiteira
            INNER JOIN Sedes ON OS.idSede = Sedes.idSede INNER JOIN StatusOs ON OS.idStatus = StatusOs.idStatus INNER JOIN AssuntoOS ON OS.idAssunto = AssuntoOS.idAssunto WHERE OS.idSede = '". $_SESSION['ID_SEDE']."'";
    
    $builerSQLQuestions = [];
    
    // Adiciona condição para pesquisa por descrição
    if (!empty($search)) {
        $builerSQLQuestions[] = "descricao LIKE '%$search%'";
    }
    
    // Adiciona condição para filtro de data
    if (!empty($date)) {
        $builerSQLQuestions[] = "DATE(dataAbertura) = '$date'";
    }
    
    // Adiciona condição para filtro de status
    if (!empty($status)) {
        $builerSQLQuestions[] = "StatusOs.idStatus = '$status'";
    }
    
    // Constrói a consulta SQL final
    if (!empty($builerSQLQuestions)) {
        $sql .= " AND " . implode(" AND ", $builerSQLQuestions);
    }

            $result = $conn->query($sql);

            // Exibe as demandas na lista
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                echo '<li class="demand-item">';
                echo '<span>'.$row['titulo'].' #00' . $row['idOS'] . '</span>';
                $statusClass = ($row['status'] == 'Concluída') ? 'delivered' : (($row['status'] == 'Em Andamento') ? 'send' :  (($row['status'] == 'Reenviada') ? 'resend' : 'pending'));
                echo '<span class="status ' . $statusClass . '">Status: ' . $row['status'] . '</span>';
                echo '<span>Categória: ' . $row['assunto'] . '</span>';
                echo '<span>Descrição: ' . $row['descricao'] . '</span>';
                echo '<span>Data de Chegada: ' . date("d/m/y H:i", strtotime($row['dataAbertura'])) . '</span>';
                echo '<span>Destino: ' . $row['nomeSede'] . '</span>';
                echo '<span>Status Real: ' . $row['status'] . '</span>';




                // Evento Modal
                                // Botão "Atualizar Status"
                echo '<form method="post" action="atualizar_status.php">';
                echo '<button type="submit" id ="atualizar">Atualizar Status</button>';

                echo '<input type="hidden" name="ticket_id" value="' . $row['idOS'] . '">';
                echo '<select name="new_status" class ="new_status">';
                echo '<option value="Concluída">Concluída</option>';
                echo '<option value="Em Andamento">Em Andamento</option>';
                echo '<option value="Reenviada">Reenviada</option>';
                echo '<option value="Pendência">Pendência</option>';

                echo '</select>';
                echo '</form>';
                
                echo '<br> <button class="open-modal" data-ticket-id="' . $row['idOS'] . '">Ver Informações</button> ';

                echo '</li>';
            }
        }
            else {
                echo '<li class="demand-item">';
                echo '<span>Nenhum resultado encontrado.</span>';
                echo '</li>';
            }

            // Fecha a conexão com o banco de dados
            $conn->close();
        ?>
    </ul>

    <!-- Modal -->
    <!--<button id="open-modal">abrir</button>-->
    <div id="fade" class="hide"></div>
    <div id="modal" class="hide">
        <div class="modal-header">
            <h2>TICKT</h2>
            <button id="close-modal">Fechar</button>
        </div>
        <div class="modal-body">
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var idOS = $(this).data('ticket-id');

            $.ajax({
                url: 'excluir.php',
                type: 'POST',
                data: {idOS: idOS},
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        });
    });
</script>
</html>
