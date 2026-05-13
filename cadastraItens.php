<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class='container'>
        <form action="">
            <section class='informacoes'>
                <h1 class='textoInicio'>Selecione o item de compra:</h1>
                <input class='informacoes' type="text" name="itemLista" placeholder='Pera'>
                <button type='button' onclick='cadastraItens()' value='cadastraItens'>Salvar itens</button>
                <a s='case2.php'> <button type='button' value='acessaLista'>Acessar lista</button> </a>
            </section>
        </form>
</div>

<script>
    function cadastraItens(){
        $.ajax({
            type: 'POST',
            url: './user-controler.php',
            data: {
                itensLista: $('input[name=itemLista]').val()
            },
            dataType: 'json',
            success: function(json) {
                console.log(json);
            }, error: function(){
                console.log('ERRO');    
            }
        })
    }
</script>

</body>

</html>
<?php
    if(isset($_POST['cadastraItens'])){
        print_r($_POST['itemLista']);
        include_once('conectaDados.php');

        $nomeList = $_POST['itemLista'];
        $resultado = mysqli_query($conn, '');
    }
?> 