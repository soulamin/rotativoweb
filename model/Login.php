<?php
/**
 * Created by PhpStorm.
 * User: Comunicarte
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';

$acao = $_POST['acao'];

switch($acao){

    case 'Logar' :
        clearstatcache();
        //Variaveis
        $Login = $_POST['login'];
        $Senha = $_POST['senha'];

        if( (!empty($Login)) && (!empty($Senha))){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('SELECT * FROM usuarios  WHERE LOGIN = :login  AND SENHA = :senha AND
                                                                                      STATUS = 1');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':senha', md5($Senha));

            // Executa a senten�a j� com os valores
            $statement->execute();

                    if ($linha =$statement->fetch()) {

                            session_start();
                            $_SESSION['ID_USUARIO'] = $linha['IDUSUARIO'];
                            $_SESSION['LOGIN'] = $linha['LOGIN'];
                            $_SESSION['NIVEL'] = $linha['NIVEL'];
                            $html = strtoupper($_SESSION['LOGIN']);
                            $Cod_Error = 0;
                            $Tipo = $_SESSION['NIVEL'] ;

                    }
                    else{

                        $html="<div class='alert alert-danger  alert-dismissable'>
                                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;
                                  </button><h4><i class='icon fa fa-ban'></i> Senha ou Usuário inválido !</h4></div>";

                        $Cod_Error = 1;
                        $Tipo ='X';
                    }
        }else{

                $html = "<div class='alert alert-danger disable alert-dismissable'>
                               <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                               <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
                               </div>";
                 $Tipo ='X';
                 $Cod_Error = 1;
        }

        $Resultado['html']=$html;
        $Resultado['Cod_Error']=$Cod_Error;
        $Resultado['Tipo']=$Tipo;
        echo json_encode($Resultado);

        break;

    case 'Logar_Desconto' :

        //Variaveis
        $Login = $_POST['login'];
        $Senha = $_POST['senha'];
        $Nivel = 'S';
        if( (!empty($Login)) && (!empty($Senha))){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('SELECT * FROM usuarios  WHERE LOGIN = :login  AND SENHA = :senha AND NIVEL = :nivel
                                                                                      AND STATUS = 1');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':senha', md5($Senha));
            $statement->bindParam(':nivel', $Nivel);

            // Executa a senten�a j� com os valores
            $statement->execute();

            if ($linha =$statement->fetch()) {

                session_start();
                $_SESSION['IDUSUARIODESCONTO'] = $linha['IDUSUARIO'];
                $Cod_Error = 0;
            }
            else{
                $Cod_Error = 1;
            }
        }else{
            $Cod_Error = 1;
        }

        $Resultado['Cod_Error']=$Cod_Error;

        echo json_encode($Resultado);

        break;

    case 'AlterarSenha_Usuario' :

        //Variaveis
        session_start();
        $Id_USUARIO =  $_SESSION['ID_USUARIO'];
        $SenhaAtual = $_POST['SenhaAtual'];
        $SenhaNova = $_POST['SenhaNova'];

        if( (!empty($SenhaAtual)) && (!empty($SenhaNova)) ){

            $st = $pdo->prepare('SELECT IDUSUARIO FROM usuarios  WHERE IDUSUARIO = :idusuario  AND SENHA = :senha ');
            // Adiciona os dados acima para serem executados na senten�a
            $st->bindParam(':idusuario', $Id_USUARIO);
            $st->bindParam(':senha', md5($SenhaAtual));

            // Executa a senten�a j� com os valores
            $st->execute();

            if ($linha =$st->fetch()) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('UPDATE usuarios SET SENHA = :senha WHERE  IDUSUARIO = :idusuario');
                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':idusuario', $linha['IDUSUARIO']);
                $statement->bindParam(':senha', md5($SenhaNova));

               $statement->execute();
                    $Cod_Error = 1;
                }

            else{
                $Cod_Error = 0;
            }
        }else{

            $Cod_Error = 3;
        }

        $Resultado['Cod_Error']=$Cod_Error;

        echo json_encode($Resultado);

        break;

        case 'Cookie' :
      
                            session_start();
                            if(isset( $_SESSION['ID_USUARIO'])){
                                $Cod_Error = 0;
                                $Tipo = $_SESSION['NIVEL'] ;

                            }else{
                                $Cod_Error = 1;
                                $Tipo = '';
                            }
              
        

        $Resultado['Cod_Error']=$Cod_Error;
        $Resultado['Tipo']=$Tipo;
        echo json_encode($Resultado);

        break;

}

