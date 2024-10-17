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
    <!--MENU DE NAVEGAÇÃO-->
    <div class="container">
        <div class="navegation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                                <!-- <ion-icon name="logo-medium"></ion-icon> -->
                                <img src="../imgs/MRS-FundoAmarelo.svg" alt="">
                        </span>
                        <span class="title">MRS Logística</span>
                    </a>
                </li>

                <li>
                    <a href="homeSede.php" target="screen">
                        <span class="icon">
                                <ion-icon name="home-outline"></ion-icon></span>
                        <span class="title">Home</span>
                    </a>
                </li>

                <li>
                    <a href="consultaSede.php" target="screen">
                        <span class="icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </span>
                        <span class="title">Consultar</span>
                    </a>
                </li>

                <li>
                    <a href="configuracoes.php" target="screen">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Configurações</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>

            </ul>
        </div>
    
        <!-- MAIN - CONTEUDO PRINCIPAL -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user">
                <?php
                echo '<img src="' . $_SESSION['PHOTO'] . '" alt="">';
                ?>
                </div>
            </div>

            <div class="screenView">
                <iframe class="responsive-iframe" name = "screen" width = "100%" height = "100%" frameborder = "0" src="homeSede.php"></iframe>
            </div>
        </div>


    </div>

    <!--SCRIPTS-->
    <script src="../js/main.js"></script>

    <!--ICONIS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>