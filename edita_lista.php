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
                <h1 class='textoInicio'>Lista <?php echo $resultado['nome_list']?></h1>
                <?php 
                include_once('conectaDados.php');
                require 'conectaDados.php';
                    $get_conteudo = 'SELECT id_prod from lista_aux where id_lista = '. $_SESSION['id_lista'] .';';
                    $executa_conteudo = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_conteudo);
                    $get_nome_produto = 'SELECT * FROM produtos WHERE id_produtos IN (SELECT id_prod from lista_aux where id_lista = ' . $_SESSION['id_lista'] . ' );';
                    $executa_get_prod = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_nome_produto);
                    $get_produtos = 'SELECT * FROM produtos';
                    $executa_get_produtos = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_produtos);

                    // $resultado = mysqli_fetch_assoc($executa);
                    // print_r($executa_get_prod);
                    // exit;
                ?>
                <?php 
                    $itens = [];
                    if(mysqli_num_rows($executa_get_produtos)>0){
                        while($resultado = mysqli_fetch_assoc($executa_get_produtos)){
                            $itens[] = $resultado['nome_produto'];
                            $_SESSION['itens']=$itens;
                        }
                    }

                    if(mysqli_num_rows($executa_get_prod) >0 ){
                        while($resultado = mysqli_fetch_assoc($executa_get_prod)){ 
                        // print_r ($resultado['nome_produto']);
                        // exit;
                        // $itens[] = $resultado['nome_produto'];
                        // $_SESSION['itens']=$itens
                        ?>
                <input class='informacoes' type="radio" id='itensLista' name="itemLista" value='<?php print_r($resultado['id_produtos']); ?>' > <?php print_r($resultado['nome_produto']); ?> </input>
                <?php }}  ?>
                <button type='button' onclick='botaoExcliur()' name='botaoExcliur'>excuir</button>
                <button type='button' onclick='editaItem()' name='editarItem'>Editar item</button>
            </section>
        </form>
    </div>

    <script>
        function editaItem(){
            selectItens= [];
            <?php foreach($itens as $item){ ?>
        selectItens["<?php echo $item; ?>"] = "<?php echo $item; ?>";
        <?php } ?>
            console.log(selectItens);
            var opcao = $("input[type=radio][name=itemLista]:checked").val();
            console.log(opcao);
            Swal.fire({
                title: "Qual item você pretende alterar?",
                input: "select",
                inputOptions: selectItens,
                inputAttributes: { autocapitalize: "off" },
                showCancelButton: true,
                confirmButtonText: "Confirmar",
            }).then((response) => {
                console.log(response.value)
                $.ajax({
                type: 'POST',
                    url: './user-controler.php?acao=editaLista',
                    data: {
                        opcao: opcao,
                        editar: response.value
                    },
                    
                    dataType: 'json',
        
                    success: function(json) {
                        if(json.retorno === 'post_vazio'){
                            console.log('NÂO TEM NADA NO POsT');
                        }
                        if(json.retorno === 'editar_item'){
                            location.reload();
                            console.log('SUCESSO');
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Item alterado com sucesso!",
                            showConfirmButton: false,
                            timer: 500
                            });

                        }
                    }, error: function(json){
                        console.log('ERRO');
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Algo de errado não está certo...",
                            showConfirmButton: false,
                            timer: 500
                            });
                    }
                })
            })
        }

        function botaoExcliur(){
            var opcao = $("input[type=radio][name=itemLista]:checked").val();
            $.ajax({
                type: 'POST',
                    url: './user-controler.php?acao=excluiItem',
                    data: { 
                        opcao: opcao
                    },
                    dataType: 'json',
                    // processData: false, 
                    // contentType: false,
        
                    success: function(json) {
                        if(json.retorno = 'post_vazio'){
                            console.log('NÂO TEM NADA NO POsT');
                        }
                        if(json.retono = ''excluir_item){
                            location.reload();
                            console.log('AAAAAA');
                            Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Item removido com sucesso!",
                            showConfirmButton: false,
                            timer: 500
                            });
                        }
                    }, error: function(){
                        console.log('ERRO');
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Algo de errado não está certo...",
                            showConfirmButton: false,
                            timer: 500
                            });
                    }
            })
        }


            // $.ajax({
            //     type: 'POST',
            //         url: './user-controler.php?acao=editaLista',
            //         data: { 
            //             item_selecionado: $('input[name = "itemLista"]').val()
            //         },
            //         dataType: 'json',
            //         // processData: false, 
            //         // contentType: false,
        
            //         success: function(json) {
            //             if(json.retorno = 'post_vazio'){
            //                 console.log('NÂO TEM NADA NO POsT');
            //             }
            //         }, error: function(){
            //             console.log('ERRO');
            //         }
            // })

    </script>

</body>
</html>