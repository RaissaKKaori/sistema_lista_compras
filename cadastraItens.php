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
            <form id='id_form' action="">
                <section class='informacoes'>
                    <h1 class='textoInicio'>Selecione o item de compra:</h1>
                    <input class='informacoes' type="checkbox" id='itensLista' name="itemLista[]" value="pera">Pera</input>
                    <input class='informacoes' type="checkbox" id='itensLista' name="itemLista[]"value="maçã">Maçã</input>
                    <input class='informacoes' type="checkbox" id='itensLista' name="itemLista[]" value="banana">Banana</input>
                    <input class='informacoes' type="checkbox" id='itensLista' name="itemLista[]" value="ameixa">Ameixa</input>

                    
                    <a href='case2.php'> <button type='button' onclick='cadastraItens()' value='cadastraItens'>Salvar itens</button> </a>
                </section>
            </form>
    </div>
    <script>
        // function salvarSelecao() {
        // const checkboxes = document.querySelectorAll('.lang:checked');
        // let selecionados = [];
        // checkboxes.forEach((checkbox) => {
        //     selecionados.push(checkbox.value);
        // });
        // console.log(selecionados);
        // }
        
        // checkboxes = document.querySelectorAll('#itensLista:checked');
        // checkboxes.forEach((checkbox) => {
        //     selecionados.push(checkbox.value);
        // });
        //     console.log(selecionados);

        function cadastraItens(){
            const formulario = document.querySelector('#id_form');
            const dadosForm = new FormData(formulario);
            console.log(dadosForm);
            // console.log(dadosForm);
            $.ajax({
                type: 'POST',
                url: './user-controler.php?acao=caditens',
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
    <?php
        if(isset($_POST['cadastraItens'])){
            print_r($_POST['itemLista']);
            include_once('conectaDados.php');

            $nomeList = $_POST['itemLista'];
            $resultado = mysqli_query($conn, '');
        }
    ?> 