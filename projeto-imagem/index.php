<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section>
        <a href="./pages/produtos.php" class="sombra">Ver todos os produto</a> 
        <h2>Cadastro de Produto</h2>
        <form method="POST" enctype = "multipart/form-data">
            <h1>ENVIO DE IMAGENS</h1>
            <input type="text" name = "nome"      placeholder = "Nome do Produto" class="sombra" required>
            <textarea          name = "descricao" placeholder = "Descrição do Produto" class="sombra"required></textarea>
            <input type="file" name = "foto[]"    multiple class="sombra meuInput" required>
            <button type="submit" name = "enviar" id="botao">Enviar</button>
        </form>
    </section>
</body>
</html>

<?php
require 'classes/Produto.php';
$produto = new Produto();

if( isset($_POST['nome']) && isset($_POST['descricao'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    // Verifica se o usuario enviou alguma foto
    if( isset($_FILES['foto'])) {
        $fotos = array();
        $tipo = "";

        $cadastro = $produto->enviarProduto($nome, $descricao, $fotos);

        if($cadastro){
        // percorre o array de fotos e salva na pasta designada
            for($i = 0; $i < count($_FILES['foto']['name']); $i++) {
                if($_FILES['foto']['type'][$i] == 'image/png'){
                    $tipo = "png";
                }else if ($_FILES['foto']['type'][$i] == 'image/jpeg'){
                    $tipo = "jpeg";
                }else{
                    $tipo = "outros";
                }
                if($tipo == "outros"){
                    echo "<center>Tipo de imagem não compativel</center>";
                    exit();
                }else{
                    //md5 codifica o nome da imagem
                    $nomeArquivo = md5( $_FILES['foto']['name'][$i].time()).'.jpg';
                    move_uploaded_file($_FILES['foto']['tmp_name'][$i], 'imagens-salvas/'.$nomeArquivo);
                    //adiciona o nome da foto no array de fotos, para enviar para o banco de dados
                    array_push($fotos, $nomeArquivo);
                    echo "<pre>";
                    print_r($fotos);
                    echo"</pre>";
                }            
            }
        }else{
            echo "Produto não cadastrado";
        }
    }
}
?>