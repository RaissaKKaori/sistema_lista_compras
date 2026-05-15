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
                $id_lista='SELECT * FROM lista_usuario;';
                print_r($id_lista);
                $executa_id_lista=mysqli_query($GLOBALS['global_conexao_mysqli'], $id_lista);
                $resultado= mysqli_fetch_assoc($executa_id_lista);
                $_SESSION['id_lista']=$resultado['id_lista'];
                exit;
            }
        }
        break;
        
        case 'caditens':
        $itens= $_POST['dadosForm'];
        $id_usu = $_SESSION['id_usuario'];

        $get_id_item = "SELECT id_produtos FROM produtos WHERE nome_produto = '$itemNome'";
        $executa_get_id = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_id_item);
        $resultado = mysqli_fetch_assoc($executa_get_id);

        if($resultado){
            foreach($itens as $frutas){
                $idProd = $resultado['id_produtos'];
                $add_itens = 'UPDATE lista_usuario SET id_produtos = ' . $idProd .' WHERE id_usuario = "' . $id_usu . '" AND nome_list = ' . $_SESSION['id_lista'] . ';';
                // $add_itens = 'UPDATE lista_usuario SET id_produtos = ' . $resultado['id_produtos'] .' WHERE id_usuario = "' . $_SESSION['id_usuario'] . '" AND nome_list = "' .  . '" ';
                
            }
        }else{
            $a['retorno'] = 'Erro';

            // $get_id_item= 'SELECT id_produtos FROM produtos WHERE nome_produto ="' . $frutas[1] . '";';
            // $executa_get_id = mysqli_query($GLOBALS['global_conexao_mysqli'], $get_id_item);
            // $resultado = mysqli_fetch_assoc($executa_get_id);
            // print_r($resultado);
            // exit;
            // $a['nome_fruta']= $resultado['id_produtos'];

            
            // $add_itens = 'UPDATE lista_usuario SET id_produtos = ' . $resultado['id_produtos'] .' WHERE id_is usuario = "' . $_SESSION['id_usuario'] . '"';
            // $executa_add_itens = mysqli_query($GLOBALS['global_conexao_mysqli'], $add_itens);
            // $a['retorno'] ='Sucesso'; 
        }
        break;
    default:
        # code...
        break;

}
echo json_encode($a);
?>