<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="php.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class='container'>
        <form action="" id='id_form' method='POST'>
            <section class='informacoes'>
                <?php
                include_once('conectaDados.php');
                    require 'conectaDados.php';
                    session_start();
                    // print_r($_SESSION);
                    $get_nome_lista ='SELECT nome_list from lista_usuario where id = '. $_SESSION['id_lista'] .';'; 
                    $executa = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_nome_lista);
                    $resultado= mysqli_fetch_assoc($executa);
                    // print_r($resultado);
                    // exit;
                ?>
                <h1 class='textoInicio'>Lista <?php echo $resultado['nome_list'];?></h1>
                <?php 
                include_once('conectaDados.php');
                require 'conectaDados.php';
                    $get_conteudo = 'SELECT id_prod from lista_aux where id_lista = '. $_SESSION['id_lista'] .';';
                    $executa_conteudo = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_conteudo);
                    $get_nome_produto = 'SELECT nome_produto FROM produtos WHERE id_produtos IN (SELECT id_prod from lista_aux where id_lista = ' . $_SESSION['id_lista'] . ' );';
                    $executa_get_prod = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_nome_produto);

                    // $resultado = mysqli_fetch_assoc($executa);
                    // print_r($executa_get_prod);
                    // exit;
                ?>
                <?php 
                    if(mysqli_num_rows($executa_get_prod) >0 ){
                        while($resultado = mysqli_fetch_assoc($executa_get_prod)){ 
                        // print_r ($resultado['nome_produto']);
                        // exit;
                        ?>
                <input class='informacoes' type="checkbox" id='itensLista' name="itemLista"> <?php print_r($resultado['nome_produto']); ?> </input>
                <?php }} ?>
                //edita_lista.php:18 Uncaught TypeError: botaoExcliur is not a function at HTMLButtonElement.onclick (edita_lista.php:18:100)
                <button type='button' onclick='botaoExcliur()' name='botaoExcliur'>excuir</button>
            </section>
        </form>
    </div>

    <script>
        function botaoExcliur(){
            $.ajax({
                type: 'POST',
                    url: './user-controler.php?acao=editaLista',
                    data: { 
                        excluir: $('input[name = "itemLista"]').val()
                    },
                    dataType: 'json',
                    // processData: false, 
                    // contentType: false,
        
                    success: function(json) {
                        if(json.retorno = 'post_vazio'){
                            console.log('NÂO TEM NADA NO POsT');
                        }
                    }, error: function(){
                        console.log('ERRO');
                    }
            })
}
    </script>

</body>
</html>