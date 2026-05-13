<?php
include_once('conectaDados.php');
$a = array();
// print_r($_POST);


// $resultado['status'] = 'sucesso';
// $resultado['mensagem'] = 'login realizado com sucesso!';



switch ($_GET['acao']) {
    case 'cadastro':
        
        $nome = $_POST['nomeCadastro'];
        $senha = $_POST['senhaCadastro'];

        if(empty($_POST['nomeCadastro']) || empty($_POST['senhaCadastro']) ){
            $a = 'necessário todas as informações preenchidas';
        }else{
            $pesquisaNome = 'SELECT * FROM usuario WHERE nomeUsuario = "' . $_POST["nomeCadastro"] . '";  ';
            $execucaoNome=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaNome);

            if(mysqli_num_rows($execucaoNome) > 0){
                $resultado = mysqli_fetch_assoc($execucaoNome);
                echo 'USUARIO JÁ CADASTRADO';
            }else{
                $instrucao='INSERT INTO usuario (nomeUsuario, senhaUsuario) VALUES ("' . $_POST["nomeCadastro"] . '","' . $_POST["senhaCadastro"] . '")';
                $execucao=mysqli_query($GLOBALS['global_conexao_mysqli'], $instrucao);

                if(mysqli_affected_rows($GLOBALS['global_conexao_mysqli']) > 0){
                    $resultado='ISERIU NO BANCO';
                    echo $resultado;
                } else{
                    $resultado='ERRO';
                    echo $resultado;
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

        if(empty($_POST['nomeLogin']) || empty($_POST['senhaLogin']) ){
            $alertErro = 'necessário todas as informações preenchidas';
            $resultado=$alertErro;
        }else{
            $pesquisaSenhaUsusario = 'SELECT * FROM usuario WHERE senhaUsuario = "' . $senha . '" AND nomeUsuario = "' . $nome . '" ;';
            $execucaoSenhaUsusario=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaSenhaUsusario);
            
            if(mysqli_num_rows($execucaoSenhaUsusario) > 0){
                $resultado = mysqli_fetch_assoc($execucaoSenhaUsusario);
                $a['retorno'] = 'Sucesso';
                $usu_valido = 'UPDATE usuario SET usu_valido = 1 WHERE nomeUsuario ="'. $nome . '" ;'; 
                $execucaoUsuariooValido=mysqli_query($GLOBALS['global_conexao_mysqli'], $usu_valido);
                }else{
                    $a['retorno'] = 'Erro';
                }
            }
        break;
    
    case 'criarLista':

        $nome = $_POST['nomeLista'];
        if(empty($_POST['nomeLista'])){
            $alertErro = 'necessário todas as informações preenchidas';
            $resultado=$alertErro;
        }else{
            $add_lista= 'INSERT nomeLista INTO infoListaUsuario(nome_list)';
            $executa_add_lista = mysqli_query($GLOBALS['global_conexao_mysqli'], $add_lista);

        }

        break;
    
    default:
        # code...
        break;

}
echo json_encode($a);
?>