<!DOCTYPE html>
<html lang="pt-br">
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

            <form method="POST" action="" >
            <fieldset id="fie">
            <legend>Cadastro</legend><br />
            <label>Nome : </label>
            <input type="text" name="usuario"  /><br />
            <label>Senha :</label>
            <input type="password" name="senha" /><br>
            <button type='button' onclick='Cadastro()'>Cadastrar</button><br/>
            <a href='./user_login.php'> <button type='button'>Logar</button></a>
            </fieldset>
            </form> 
        </section>
    </div>
    
    <script>
        function Cadastro(){
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=cadastro',
                data: {
                    nomeCadastro: $('input[name = "usuario"]').val(),
                    senhaCadastro: $('input[name = "senha"]').val()
                },
                dataType: 'json',
                success: function(json) {
                    if(json.retorno == 'Sucesso'){
                        window.location.href = './user-input.php';
                    } 
                    if(json.retorno == 'Erro'){
                        Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Confira suas Credenciais!",
                        // footer: "<a href=\"#\">Why do I have this issue?</a>"
                        });
                    }
                // error: function(){
                //     console.log('ERRO');
                // }
                }
            })
        }
    </script>
</body>
</html>