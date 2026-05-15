<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title></title>
</head>
<body>
    <div class='container'>
        <form action="" method='POST'>
            <section class='informacoes'>
                <h1 class='textoInicio'>Selecione a lista:</h1>
                <?php
                    require 'conectaDados.php';
                    $get_listas= 'SELECT nome_list FROM lista_usuario WHERE id_usuario = ' . $_SESSION['id_usuario'] . '';
                    
                ?>
                <select >
                    <option =>Selecione...</option>
                    <?php while($linha = mysqli_fetch_assoc($executa_get_nome)){ ?>
                    <option value="<?php echo($linha['nome_list']);?>"></option>
                    <?php } ?>
                </select>
                
                <button type='button' onclick='acessaLista()' value='acessaLista'>Acessa Lista</button>
            </section>
        </form>
    </div>
    <script>function acessaLista(){
            // const formulario = document.querySelector('#id_form');
            // const dadosForm = new FormData(formulario);
            // // console.log(dadosForm);
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=selecionaLista',
                data: dadosForm,
                dataType: 'json',
                processData: false, 
                contentType: false,
    
                success: function(json) {
                    if(json.retorno = 'Sucesso'){
                        console.log(json.retorno);
                    }
                }, error: function(){
                    console.log('ERRO');
                }
            })
        }
    </script>

</body>
</html>
