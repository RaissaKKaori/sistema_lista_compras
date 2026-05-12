<?php
include_once('conectaDados.php');
$resultado = array();
print_r($_POST);

 
// $resultado['status'] = 'sucesso';
// $resultado['mensagem'] = 'login realizado com sucesso!';

$resultado['nome'] = $_POST['nomeLogin'];
$resultado['senha'] = $_POST['senhaLogin'];

switch ($_GET['acao']) {
    case 'login':
        
        if(empty($_POST['nomeLogin']) ||  empty($_POST['senhaLogin']) ){
            $alertErro = 'necessário todas as informações preenchidas';
            $resultado=$alertErro;
        }else{
            $pesquisaNome = 'SELECT * FROM usuario WHERE nomeUsuario = "' . $_POST["nomeLogin"] . '";  ';
            $execucaoNome=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaNome);
            
            $pesquisaSenha = 'SELECT nomeUsuario FROM usuario WHERE senhaUsuario = "' . $_POST["senhaLogin"] . '";  ';
            $execucaoSenha=mysqli_query($GLOBALS['global_conexao_mysqli'], $pesquisaSenha);

            // print_r($execucaoSenha);
            if(mysqli_num_rows($execucaoNome) > 0){
                $resultado = mysqli_fetch_assoc($execucaoNome);
                echo 'USUARIO JÁ CADASTRADO';
            }else{
                $instrucao='INSERT INTO usuario (nomeUsuario, senhaUsuario) VALUES ("' . $_POST["nomeLogin"] . '","' . $_POST["senhaLogin"] . '")';
                $execucao=mysqli_query($GLOBALS['global_conexao_mysqli'], $instrucao);

                if(mysqli_affected_rows($GLOBALS['global_conexao_mysqli']) > 0){
                    $resultado='ISERIU NO BANCO';
                    echo $resultado;
                } else{
                    $resultado='ERRO';
                    echo $resultado;
                }
            }

            if ($pesquisaSenha == $_POST['senhaLogin']){
                echo 'PODE ENTRAR';
            }
        }
        print_r($resultado);
        
        break;
    
    
    case 'criarLista':
        $sql= 'INSERT nomeLista INTO infoListaUsuario (nome_list)';
        break;
    
    default:
        # code...
        break;

    

};
echo json_decode($resultado);
exit;
?>