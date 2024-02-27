<?php
include 'funcoes.php';
verificarAutenticacao();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href ="../css/cadastro.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Cadastrar OS</title>
</head>
<body>
    <div class="container">
        <div class="titulo">Cadastrar Tickets</div>
        <form action="cadastrar.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <span class="details">Título *</span>
                        <input type="text" id="titulo" name="titulo" required>
                    </td>
                    <td>
                        <span class="details">Data *</span> <br>
                        <input type="date" value="<?php 
                        date_default_timezone_set('America/Sao_Paulo');
                        echo date('Y-m-d'); ?>" 
                        placeholder="Data" id="data" name="data" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="details">Descrição *</span>
                        <textarea name="descricao" oninput="updateTextoDigitado(this)" id="descricao" required></textarea>
                    </td>
                    <td>
                        <span class = "details"> Assunto *</span> <br>
                        <?php
                            include "conexao.php"; 

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            $query = "SELECT idAssunto, nameAssunto FROM AssuntoOs"; 
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                echo "<select name='assunto'>";
                                while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['idAssunto'] . "'>" . $row['nameAssunto'] . "</option>";
                            }
                            echo "</select>";
                            } 
                            else {
                            echo "Nenhum resultado encontrado.";
                        }

                        $conn->close();
                        ?>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        <div class="ultimo_bloco">
                            <table>
                                <tr>
                                    <td>
                                        <span>Sede * </span> <br>
                                        <?php
                                            include "conexao.php"; 

                                            $query = "SELECT idSede, nome FROM Sedes"; 
                                            $result = $conn->query($query);

                                        if ($result->num_rows > 0) {
                                            echo "<select name='sede'>";
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['idSede'] . "'>" . $row['nome'] . "</option>";
                                            }
                                            echo "</select>";
                                        } 
                                        else {
                                            echo "Nenhum resultado encontrado.";
                                        }
                                        $conn->close();
                                        ?>
                                    </td>
                                    <td>
                                        <span id="empreitera">Empreitera * </span> <br>
                                        <?php
                                        include "conexao.php"; 

                                        $conn = new mysqli($servername, $username, $password, $dbname);

                                        $query = "SELECT idEmpreiteira, nome FROM Empreiteiras WHERE idEmpreiteira ='".$_SESSION['ID_EMPREI']."'";
                                        $result = $conn->query($query);

                                        if ($result->num_rows > 0) {
                                            echo "<select name='empreiteira'>";
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['idEmpreiteira'] . "'>" . $row['nome'] . "</option>";
                                            }
                                            echo "</select>";
                                        } 
                                        else {
                                            echo "Nenhum resultado encontrado.";
                                        }
                                        $conn->close();
                                    ?>
                                    </td>
                                </tr>
                            </table>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="#" id="btn" title="Clique aqui para obter uma melhoria na descrição">Melhorar Descrição</a>
                        <script>
                            $(document).ready(function() {
                                $('#btn').click(function(event) {
                                    event.preventDefault();

                                    var descricao = $('#descricao').val(); // Obtém a mensagem do usuário
                                    var mensagem_padrao = 'Por favor, melhore a descrição da seguinte Ordem de Serviço: \n';
                                    var mensagem_padrao_final = "\n Nosso objetivo é garantir que a descrição seja clara, detalhada e compreensível para a empreiteira. Por favor, expanda e aprimore a descrição conforme necessário. Obrigado! (não escreva mais nada além disso)";
                                    var mensagem = mensagem_padrao + descricao + mensagem_padrao_final;
                                    

                                    // Dados a serem enviados para a API do ChatGPT
                                    var requestData = {
                                        model: 'gpt-3.5-turbo',
                                        messages: [{ role: 'user', content: mensagem }]
                                    };

                                    $.ajax({
                                        url: 'https://api.openai.com/v1/chat/completions',
                                        type: 'POST',
                                        beforeSend: function(xhr) {
                                            xhr.setRequestHeader('Authorization', 'Bearer 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'); // Substitua SUA_CHAVE_DE_API pela sua chave de API
                                            xhr.setRequestHeader('Content-Type', 'application/json');
                                        },
                                        data: JSON.stringify(requestData),
                                        success: function(response) {
                                            var resposta = response.choices[0].message.content; // Obtém a resposta do ChatGPT
                                            $('#descricao').val(resposta); // Atualiza algum elemento na sua página com a resposta
                                            updateTextoDigitado(document.getElementById('descricao'));
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Erro na requisição AJAX:', error);
                                        }
                                    });
                                });
                            });

                    </script>
                    </td>
                </tr>
                
            </table>
            <div class="botao">
                <input type="submit" value="Registrar" id ="botao">
            </div>
        </form>
    </div>
</body>

<script>
function updateTextoDigitado(textarea) {
    // Ajusta dinamicamente a altura do textarea com base no conteúdo digitado
    textarea.style.height = "auto";
    textarea.style.height = (textarea.scrollHeight) + "px";
}
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('conexao.php');

    $conn = new mysqli($servername, $username, $password, $dbname);


    $titulo = $_POST['titulo'];
    $data = $_POST['data'];
    $assunto = $_POST['assunto'];
    $descricao = $_POST['descricao'];
    $sede = $_POST['sede'];
    $empreiteira = $_POST['empreiteira'];
    $insere = mysqli_query($conn, "INSERT INTO OrdensDeServico (titulo,descricao,dataAbertura,idAssunto,idEmpreiteira,idSede)  VALUES ('$titulo', '$descricao', '$data','$assunto','$empreiteira','$sede')" ) or die("Erro ao inserir a Ordem de Serviço");
    echo "<script>alert('Parabéns! Sua Ordem de Serviço foi criada com sucesso!')</script>";
}
?>

</html>