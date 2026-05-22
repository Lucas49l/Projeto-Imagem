<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section>
        <a href="produtos.php" class="sombra">Ver todos os produto</a> 
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
