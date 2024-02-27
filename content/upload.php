<!-- Verificar se esta logado para sim poder enviar o arquivo -->
<!-- Não deixar site aberto para qualquer envio de arquivo -->
<!-- Caso envie um php, o hacker pode zipar o servidor, baixar os dados do banco -->

<?php
// Conexao com servidor
include_once('conexao.php');

if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo'];

    if($arquivo['error'])
        die("Falha ao enviar arquivo!");

    if($arquivo['size'] > 3145728)
        die("Arquivo grande!! Max: 3,5MB");

    $pasta = "../files/";
    $nomeDoAquivo = $arquivo['name'];
    $novoNomeDoArquivo = "TKT_" . uniqid();
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

    if($extensao != 'jpg' && $extensao != 'png' && $extensao != 'pdf')
        die("Tipo de arquivo não aceito");

    $verificador = move_uploaded_file($arquivo["tmp_name"], $path);
    if($verificador){
        $insert = mysqli_query($conn,"INSERT INTO teste(nome, pathteste) values ('$nomeDoAquivo','$path')")
        or die("Erro");
        echo "<p>Arquivo enviado com sucesso! </p>";
    }
    else
        echo "<p>Falha ao enviar arquivo</p>";
}

$consulta = mysqli_query($conn, "SELECT * FROM teste") or die("Erro na consulta");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data" action="">
        <p><label for="">Selecione o arquivo</label></p>
        <p><input name="arquivo" type="file"></p>
        <button name="upload" type="submit">Enviar arquivo</button>
    </form>

    <table border='1' cellpadding='10'>
        <thead>
            <th>Arquivo</th>
            <th>Data de Envio</th>
            <th>PreViwe</th>
        </thead>
        <tbody>
        <?php
        while($arquivo = $consulta->fetch_assoc()){
        ?>
            <tr>
                <td><a target = '_blank' href='<?php echo $arquivo['pathteste'];?>'><?php echo $arquivo['nome'];?></a></td>
                <td><?php echo date("d/m/y H:i", strtotime ($arquivo['dataAbertura']));?></td>
                <td><img src="<?php echo $arquivo['pathteste'];?>" alt="" height='60'></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</body>
</html>
