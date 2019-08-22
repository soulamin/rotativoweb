<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 23/10/2016
 * Time: 11:42
 */
require '../fontes/conexao.php';
//include 'InsereArquivo.php';
session_start();
$acao = $_POST['acao'];

switch($acao){



    case 'Salva_GrvLacre' :

          $Grv = trim($_POST['Grv']);
          $IdPatio = $_POST['Patio'];
          $Estado = $_POST['Estado'];
          $Lacre = $_POST['Lacre'];
          $IdUsuario = $_SESSION['ID_USUARIO'];
          $Status = 1;
        $stmt = $pdo->prepare( 'SELECT count(ID) as Qtd FROM grv_lacre WHERE LACRE =:lacre AND ID_PATIO =:idpatio ');
        $stmt->bindParam(':idpatio', $IdPatio);
        $stmt->bindParam(':lacre', $Lacre);
        $stmt->execute();
        $Qtd = $stmt->fetch();
        if($Qtd['Qtd'] >= 1){
            $Cod_error=1;
        }else{
            if(empty($Lacre)){
                $Cod_error=0;
            }else{
                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO grv_lacre (GRV,LACRE,ESTADO,ID_PATIO,ID_USUARIO,STATUS) VALUES
                                                                        (:grv,:lacre,:estado,:idpatio,:idusuario,:status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':grv',  $Grv);
                $statement->bindParam(':lacre',  $Lacre);
                $statement->bindParam(':estado',  $Estado);
                $statement->bindParam(':idpatio',  $IdPatio);
                $statement->bindParam(':status',  $Status);
                $statement->bindParam(':idusuario',  $IdUsuario);
                // Executa a senten�a j� com os valores
                $statement->execute();
                $Cod_error=0;
            }


        }

        $Resultado['Cod_error'] = $Cod_error;
        echo json_encode($Resultado);

        break ;

    case 'Busca_GrvLacre_Tabela' :

        $Grv =$_POST['Grv'];
        $Patio =$_POST['Patio'];
        $stmt = $pdo->prepare( 'SELECT * ,l.STATUS as STATUS FROM grv_lacre l 
                                                 INNER JOIN usuarios u ON l.ID_USUARIO=u.IDUSUARIO WHERE l.ID_PATIO =:patio AND  l.GRV =:grv');
        $stmt->bindParam(':grv', $Grv);
        $stmt->bindParam(':patio', $Patio);
        $executa=$stmt->execute();
        $r='';

        while ($linha = $stmt->fetch())
        {
            if($linha['STATUS']== '1'){
                $Status = '<span class="label label-success">Ativo</span>';
            }else{
                $Status = '<span class="label label-danger">Removido</span>';
            }

            if($linha['ESTADO']== 'P'){
                $Estado = '<span class="label label-success">Perfeito</span>';
            }else{
                $Estado = '<span class="label label-warning">Avariado</span>';
            }

            //$botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['ID'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";
            $botaoExcluir = "<button id='btnExcluirLacre'  codigo ='" . $linha['ID'] . "' class=' btn btn-danger glyphicon glyphicon-trash' ></button>";

            $r.="<tr>
                     <td>".$linha['LACRE']."</td>
                     <td>".$Estado."</td>
                     <td>".$Status."</td>
                     <td>".$linha['LOGIN']."</td>
                     <td>".$botaoExcluir."</td>
                 </tr>";
          }

        $Resultado['Html'] = $r;
        echo json_encode($Resultado);

        break ;

    //Desativa o GrvLacre
    case 'Exclui_GrvLacre' :

        $IdUsuario   = $_SESSION['ID_USUARIO'];
        $IdLacre = $_POST['IdLacre'];
        $stmt = $pdo->prepare( 'DELETE FROM grv_lacre WHERE ID= :idlacre');
        //$stmt ->bindParam( ':idusuario', $IdUsuario );
        $stmt ->bindParam( ':idlacre', $IdLacre );
        if($stmt->execute()){
            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;



}

