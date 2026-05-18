<?php
include_once('conectaDados.php');
$a = array();
// print_r($_POST);


// $resultado['status'] = 'sucesso';
// $resultado['mensagem'] = 'login realizado com sucesso!';


session_start();
switch ($_GET['acao']) {
    case 'cadastro':
        
        $nome = $_POST['nomeCadastro'];
        $senha = $_POST['senhaCadastro'];

        if(empty($_POST['nomeCadastro']) || empty($_POST['senhaCadastro']) ){
            $resultado = 'necessário todas as informações preenchidas';
            $a['retorno']='campoVazio';
        }else{
            $pesquisaNome = 'SELECT * FROM usuario WHERE nomeUsuario = "' . $nome . '";  ';
            $execucaoNome=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaNome);

            if(mysqli_num_rows($execucaoNome) > 0){
                $resultado = mysqli_fetch_assoc($execucaoNome);
                // echo 'USUARIO JÁ CADASTRADO';
                $a['retorno']='usuExistente';
            }else{
                $instrucao='INSERT INTO usuario (nomeUsuario, senhaUsuario) VALUES ("' . $_POST["nomeCadastro"] . '","' . $_POST["senhaCadastro"] . '")';
                $execucao=mysqli_query($GLOBALS['global_conexao_mysqli'], $instrucao);

                if(mysqli_affected_rows($GLOBALS['global_conexao_mysqli']) > 0){
                    $resultado='ISERIU NO BANCO';
                    // echo $resultado;
                    $a['retorno']= 'Sucesso';
                } else{
                    $resultado='Erro';
                    // echo $resultado;
                }
            }
        }
        break;

    case 'login':
        // $pesquisaSenhaUsusario = 'SELECT * FROM usuario WHERE senhaUsuario = "' . $_POST["senhaLogin"] . '" AND nomeUsuario = "' . $_POST["nomeLogin"] . '" ;';
        // print_r($pesquisaSenhaUsusario);
        // $execucaoSenhaUsusario=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaSenhaUsusario);
        // print_r(mysqli_num_rows($execucaoSenhaUsusario));
        $nome = $_POST['nomeLogin'];
        $senha = $_POST['senhaLogin'];
        $arr = array("nomeLogin" => $nome, "senhaLogin" => $senha);
        
        if(empty($_POST['nomeLogin']) || empty($_POST['senhaLogin']) ){
            $alertErro = 'necessário todas as informações preenchidas';
            $a['retorno']='Erro';
        }else{
            $pesquisaSenhaUsusario = 'SELECT * FROM usuario WHERE senhaUsuario = "' . $senha . '" AND nomeUsuario = "' . $nome . '" ;';
            $execucaoSenhaUsusario=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaSenhaUsusario);
            
            if(mysqli_num_rows($execucaoSenhaUsusario) > 0){
                $resultado = mysqli_fetch_assoc($execucaoSenhaUsusario);
                
                // $a['nome']=$resultado['nomeUsuario'];
                $_SESSION['id_usuario'] = $resultado['id'];
                $usu_valido = 'UPDATE usuario SET usu_valido = 1 WHERE nomeUsuario ="'. $nome . '" ;'; 
                $execucaoUsuarioValido=mysqli_query($GLOBALS['global_conexao_mysqli'], $usu_valido);
                $a['retorno'] = 'Sucesso';
                // session_start();
                // $pesquisaIdUsuario= 'SELECT * FROM usuario WHERE nomeUsuario = "' . $nome . '" ;';
                // $_SESSION['usuario_id']= $pesquisaIdUsuario;
                // exit(session_start());
            }else{
                    $a['retorno'] = 'Erro';
                }
            }
        break;
    
    case 'criarLista':
        $idUsu = $_SESSION['id_usuario'];
        $nomeLista = $_POST['a'];
        // print_r( $_POST);
        // print_r($nomeLista);
        if(empty($nomeLista)){
            $alertErro = 'necessário todas as informações preenchidas';
            $a['retorno']='Erro';
        }else{
            $add_lista= 'INSERT INTO lista_usuario(nome_list, id_usuario) VALUES("'. $nomeLista . '",' . $idUsu .')';
            $executa_add_lista = mysqli_query($GLOBALS['global_conexao_mysqli'], $add_lista);


            if(mysqli_affected_rows($GLOBALS['global_conexao_mysqli']) > 0){
                $id_lista='SELECT * FROM lista_usuario ORDER BY id DESC;';
                $executa_id_lista=mysqli_query($GLOBALS['global_conexao_mysqli'], $id_lista);
                $resultado= mysqli_fetch_assoc($executa_id_lista);
                
                // print_r($resultado);
                // exit;
                $_SESSION['id_lista']=$resultado['id'];
                $_SESSION['nome_lista']=$resultado['nome_list'];
                // print_r($_SESSION['id_lista']);
                // exit;
                $a['retorno']= 'Sucesso';
            }
        }
        break;
        
        case 'caditens':
        $itens= $_POST['itemLista']; //conteúdo de dadosForm
        $id_usu = $_SESSION['id_usuario'];
        // print_r($itens);
        // exit;
        foreach($itens as $i => $item){
            $get_id_item = 'SELECT * FROM produtos WHERE nome_produto = "' . $item .'";';
            $executa_get_listas = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_id_item);
            $resultado = mysqli_fetch_assoc($executa_get_listas);
            print_r($resultado);
            // exit;

            if($resultado){
                $add_itens = 'INSERT INTO lista_aux(id_prod, id_lista) VALUES (' . $resultado['id_produtos'] . ',' . $_SESSION['id_lista'] . ');';
                // $add_itens = 'UPDATE lista_usuario SET id_produtos = ' . $resultado['id_produtos'] .' WHERE id_usuario = "' . $_SESSION['id_usuario'] . '" AND nome_list = "' .  . '" ';
                $executa_add = mysqli_query($GLOBALS['global_conexao_mysqli'], $add_itens);
                print_r($add_itens);
                
                if( mysqli_affected_rows($GLOBALS['global_conexao_mysqli']) > 0){
                    print_r('EXECUTADO');
                    $a['retorno'] ='Sucesso';
                }
                else{
                    $a['retorno'] = 'Erro';
            }
            
        }
        }
        break;

        case 'selecionaLista':
            $lista= $_POST;
            $_SESSION['lista_selecionada']=$_POST;

            if(empty($_POST)){
                $alertErro = 'necessário todas as informações preenchidas';
                $a['retorno']='post_vazio';
            }

            //validar se existe a lista antes de passar para a proxima página
            $get_listaValida = 'SELECT nome_list from lista_usuario where nome_list = "' . $listaEscolhida . '" ';
            $listaValida= mysqli_query($GLOBALS['global_conexao_mysqli'], $get_listaValida);
            
            if($listaValida){
                $a['retorno'] = 'Sucesso';
                exit; //!!!!!!
                }

            // //para aparecer todos as listas disponíveis para aquele usuário
            // $get_listas= 'SELECT nome_list FROM lista_usuario WHERE id_usuario = ' . $_SESSION['id_usuario'] . ' ORDER BY id DESC;';
            // $executa_get_listas = mysqli_query($GLOBALS['global_conexao_mysqli'],$get_listas);
            // $resultado=mysqli_fetch_assoc($executa_get_listas);
            // print_r($resultado);
            // // exit;
            // $linha_produtos = [];
            // while($linha = mysqli_fetch_assoc($executa_get_listas)){
            //     $lista[] = $linha;
            // }
            // print_r($lista);
            // exit;
        break;

        case 'editaLista':
            $itens_edicao = $_POST; 
            // print_r($_POST);
            // exit;
            
            // $item = [];
            $get_id_produto = 'SELECT * FROM produtos WHERE nome_produto = ("'. $_POST['editar'] .'");'; //id do que o usuario quer add
            // print_r($get_id_produto);
            // exit;
            $executa_get_id = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_id_produto);
            $resultado= mysqli_fetch_assoc($executa_get_id);

            
            // $edita_item = 'update lista_aux set id_prod = ' . $resultado['id_prod'] . ' where nome_list = "' . $_SESSION['lista_selecionada'] . '" AND id_prod = ' . $_SESSION['item_selecionado'] . ';';
            // $executa_edita_item = mysqli_query($GLOBALS['global_conexao_mysqli'], $edita_item);
            // print_r($executa_edita_item);
            // break;
            $edita_item = 'update lista_aux set id_prod = ' . $resultado['id_produtos'] . ' where id_lista = "' . $_SESSION['id_lista'] . '" AND id_prod = ' . $itens_edicao['opcao'] . ';';
            $executa_edita_item = mysqli_query($GLOBALS['global_conexao_mysqli'], $edita_item);
            // print_r($executa_edita_item); = 1
            // exit;
            
            $a['retorno']='editar_item';
            
            // $edita_item = 'update lista_aux set id_prod = ' . $resultado['id_prod'] . ' where nome_list = "' . $_SESSION['lista_selecionada'] . '" AND id_prod = ' . $_SESSION['item_selecionado'] . ';';
            //     $executa_edita_item = mysqli_query($GLOBALS['global_conexao_mysqli'], $edita_item);
            //     print_r($executa_edita_item);
            //     break;
            
            // $edita_item = 'update lista_aux set id_prod = ' . $resultado['id_prod'] . ' where nome_list = "' . $_SESSION['lista_selecionada'] . '" AND id_prod = ' . $_SESSION['item_selecionado'] . ';';
            // // print_r($edita_item);
            // // break;
            // $executa_edita_item = mysqli_query($GLOBALS['global_conexao_mysqli'], $edita_item);
            // print_r($executa_edita_item);
            // $a['retorno']= 'editar_item';

        break;

        case 'Exclui lista':
            $excluiItem = $_POST;

            $del_item = 'delet from lista_aux where id_prod ='. $excluiItem .';';
            $executa_del_item = mysqli_query($GLOBALS['global_conexao_mysqli'], $del_item);
            $a['retorno']= 'excluir_item';

            break;
    default:
        # code...
        break;

}
echo json_encode($a);
?>