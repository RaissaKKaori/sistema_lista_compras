<!-- //aa -->
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
                session_start();
                include_once('conectaDados.php');
                require 'conectaDados.php';
                    // $get_listas= 'SELECT * FROM lista_usuario WHERE id_usuario = ' . $_SESSION['id_usuario'] . ' ORDER BY id DESC;';
                    // $executa_get_listas = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_listas);
                    // $resultado = mysqli_fetch_assoc($executa_get_listas);
                    // print_r($executa_get_listas);
                    // exit;
                ?>  
                <select id='id_lista'>
                    <!-- <option value='' disabled selected >Selecione...</option> -->
                    <?php if(mysqli_num_rows($executa_get_listas) >0 ){
                        while($linha = mysqli_fetch_assoc($executa_get_listas)){ ?>
                            <option value="<?php echo($linha['id']);?>"><?php echo($linha['nome_list']);?></option>
                    <?php }} ?>
                </select>
                
                <a href='edita_lista.php'><button type='button' onclick='acessaLista()' value='acessaLista'>Acessa Lista</button></a>
            </section>
        </form>
    </div>
    <script>function acessaLista(){
            const formulario = document.querySelector('#id_form');
            const dadosForm = new FormData(formulario);
            console.log(dadosForm);
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=selecionaLista',
                data: dadosForm,
                dataType: 'json',
                processData: false, 
                contentType: false,
    
                success: function(json) {
                    if(json.retorno === 'post_vazio'){
                        console.log('NÂO TEM NADA NO POsT');
                    }
                    if(json.retorno === 'Sucesso'){
                        // Agora sim: Redireciona via JS apenas após o sucesso do back-end
                        window.location.href = 'edita_lista.php';
                    }
                }, error: function(){
                    console.log('ERRO');
                }
            })
        }
    </script>

</body>
</html>
