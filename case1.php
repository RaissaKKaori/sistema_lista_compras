<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title></title>
</head>
<body>
    <div class='container'>

    <section class='informacoes'>
        <form class='form' action="" method='POST'>
            <h1 class='textoInicio'>Digite o nome da sua lista:</h1>
            <input class='informacoes' type="text" name="nomeLista" placeholder="Digite o nome da lista">
            <br></br>
            <button  type='button' onclick='CriarLista()' value='sendNome'>Salvar</button>

        </form>
        <a href='./cadastraItens.php'><button >Cadstrar itens</button></a>
    </section>
        
    </div>
    <script>
        function CriarLista(){
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=criarLista',
                data: {
                    nomeLista: $('input[name = "nomeLista"]').val()
                },
                dataType: 'json',
                success: function(json) {
                    console.log(json);
                    console.log('TUDO OK');
                }, 
                error: function(){
                    console.log('ERRO');    
                }

            })
        }
    </script>
</body>

</html>
<?php
    if(isset($_POST['sendNome'])){
        print_r($_POST['nomeLista']);
        include_once('conectaDados.php');

        $nomeList = $_POST['nomeLista'];
        $resultado = mysql_quiery($conn, '');
    }
?> 