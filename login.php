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
        <section class='informacoes'>
            <?php
            session_start();
            ?>

            <form method="POST" action="" class="login" >
            <fieldset id="fie">
            <legend>Login</legend><br />
            <label>Nome : </label>
            <input type="text" name="usuario"  /><br />
            <label>Senha :</label>
            <input type="password" name="senha" /><br />
            <button type='button' onclick='Logar()'>Entrar</button>
            </fieldset>
            </form>
        </section>
    </div>
    
    <script>
        function Logar(){
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=login',
                data: {
                    nomeLogin: $('input[name = "usuario"]').val(),
                    senhaLogin: $('input[name = "senha"]').val()
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