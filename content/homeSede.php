<?php
include 'funcoes.php';
verificarAutenticacao();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOG - MRS Logistica</title>

    <!--STYLES-->
    <link rel="stylesheet" href="../css/style0.css">
</head>
<body>

        <!-- CARDS -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers">  
                    <?php
                            include_once('conexao.php');
                            $result = mysqli_query($conn,"SELECT COUNT(*) as total from OrdensDeServico WHERE OrdensDeServico.idSede = " . $_SESSION['ID_SEDE']);
                            $row = mysqli_fetch_assoc($result);
                            $count = $row['total'];
                            echo $count;
                    ?>
                    </div>

                    <div class="cardName">Total Tickets</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="globe-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                    <?php
                            include_once('conexao.php');
                            $result = mysqli_query($conn,"SELECT COUNT(*) as total from OrdensDeServico where idStatus = 1 AND OrdensDeServico.idSede = " . $_SESSION['ID_SEDE']);
                            $row = mysqli_fetch_assoc($result);
                            $count = $row['total'];
                            echo $count;
                    ?>
                    </div>
                    <div class="cardName">Total Concluídos</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                    <?php
                            include_once('conexao.php');
                            $result = mysqli_query($conn,"SELECT COUNT(*) as total from OrdensDeServico where idStatus = 3 AND OrdensDeServico.idSede = " . $_SESSION['ID_SEDE']);
                            $row = mysqli_fetch_assoc($result);
                            $count = $row['total'];
                            echo $count;
                    ?>
                    </div>
                    <div class="cardName">Total Pendências</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="close-circle-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">
                    <?php
                        include_once('conexao.php');
                        // Coloque a data entre aspas simples na sua consulta SQL
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM OrdensDeServico WHERE DATE(dataAbertura) =  CURDATE() AND OrdensDeServico.idSede = " . $_SESSION['ID_SEDE']);
                        $row = mysqli_fetch_assoc($result);
                        $count = $row['total'];
                        echo $count;
                    ?>
                    </div>
                    <div class="cardName">Total Novos</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="information-circle-outline"></ion-icon>
                </div>
            </div>
        </div>

    
        <!-- TOP OS/TICKTS -->
        <div class="details">
                <div class="recentOs">
                    <div class="cardHeard">
                        <h2>Últimos Tickets</h2>

                        <a href="consultaSede.php" target="screen" class="btn">Ver todas</a>
                    </div>

                    <table>
                        <thead>
                            <td>Nome</td>
                            <td>Sede</td>
                            <td>Tikct</td>
                            <td>Status</td>
                        </thead>

                        <tbody>
                        <?php
        include_once('conexao.php');

        $sql = "SELECT OS.titulo, Sedes.nome AS nomeSede, Empreiteiras.nome AS nomeEmpreiteira, StatusOs.nameStatus AS status
                FROM OrdensDeServico AS OS
                INNER JOIN Empreiteiras ON OS.idEmpreiteira = Empreiteiras.idEmpreiteira
                INNER JOIN Sedes ON OS.idSede = Sedes.idSede
                INNER JOIN StatusOs ON OS.idStatus = StatusOs.idStatus
                WHERE OS.idSede = " . $_SESSION['ID_SEDE'] . "
                ORDER BY OS.dataAbertura DESC
                LIMIT 5";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = ($row['status'] == 'Concluída') ? 'delivered' : (($row['status'] == 'Em Andamento') ? 'send' :  (($row['status'] == 'Reenviada') ? 'resend' : 'pending'));

                echo "
                    <tr>
                        <td>" . $row["titulo"] . "</td>
                        <td>" . $row["nomeSede"] . "</td>
                        <td>" . $row["nomeEmpreiteira"] . "</td>
                        <td><span class=\"status $statusClass\">" . $row['status'] . "</span></td>
                    </tr>
                ";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum resultado encontrado</td></tr>";
        }
        $conn->close();
        ?>

                </tbody>
            </table>
        </div>

<!-- MENBROS EQUIPE -->
        <div class="teamMenbers">
            <div class="cardHeard">
                <h2>Membros da Equipe</h2>
            </div>

            <table>
                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="../imgs/profile02.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Gleisson <br> <span>Tavares</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="../imgs/profile01.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Hugo <br> <span>Dias</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="../imgs/profile03.svg" alt=""></div>
                    </td>
                    <td>
                        <h4>Matheus <br> <span>Almeida</span></h4>
                    </td>
                </tr>

                <tr>
                    <td width="60px">
                        <div class="imgBx"><img src="../imgs/profile04.jpg" alt=""></div>
                    </td>
                    <td>
                        <h4>Fabiano <br> <span>Bital</span></h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <!--SCRIPTS-->
    <script src="../js/main.js"></script>

    <!--ICONIS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>