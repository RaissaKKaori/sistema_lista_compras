<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</body>
</html>