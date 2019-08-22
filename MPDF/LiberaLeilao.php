<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 23/10/2016
 * Time: 11:42
 */
require '../fontes/conexao.php';
include 'FuncaoData.php';
session_start();
$acao = $_POST['acao'];


switch($acao){


    case 'Busca_Liberacao' :

         $Tipo  = $_POST['Tipo'];
         $Dados = $_POST['Dados'];
         $IdPatio = $_POST['IdPatio'];
         $Status = "G";


            $stmt = $pdo->prepare( 'SELECT * ,timediff(now(),CONCAT(s.DATAREMOCAO," ",s.HORAREMOCAO)) As DIAS  FROM grv_status s INNER JOIN grv_veiculo v ON v.GRV=s.GRV AND s.ID_PATIO=v.ID_PATIO
                                              INNER JOIN grv_condutor c ON c.GRV=s.GRV AND s.ID_PATIO=c.ID_PATIO     
                                              WHERE v.'.$Tipo.' =:dados  AND s.ID_PATIO =:idpatio AND s.STATUS =:status AND DATEDIFF(CURDATE(),s.DATAREMOCAO )>=60 ');
            $stmt->bindParam(':idpatio', $IdPatio);
            $stmt->bindParam(':status', $Status);
            $stmt->bindParam(':dados', $Dados);
            $stmt->execute();

                if($Linha= $stmt->fetch()){

                    $Grv =array('Grv'=>$Linha['GRV'],'DataEnt'=>PdBrasil($Linha['DATAENT']),'HoraEnt'=>$Linha['HORAENT'],
                        'DataRemocao'=>PdBrasil($Linha['DATAREMOCAO']),'HoraRemocao'=>$Linha['HORAREMOCAO'],'Placa'=>$Linha['PLACA'],'SemPlaca'=>$Linha['SEMPLACA'],
                        'Chassi'=>$Linha['CHASSI'],'Renavam'=>$Linha['RENAVAM'],'TipoVeiculo'=>$Linha['TIPOVEICULO'],'UsoReboque'=>$Linha['USOREBOQUE'],
                        'Cor'=>$Linha['COR'],'MarcaModelo'=>$Linha['MARCAMODELO'],'Reboquista'=>$Linha['ID_REBOQUISTA'],'Reboque'=>$Linha['ID_REBOQUE']);

                    $_SESSION['GRV']=$Linha['GRV'] ;
                    $_SESSION['PATIO']=$IdPatio ;


                    $Cod_error=0;
                }else{
                    $Cod_error=1;
                    $Grv ='';

                }
        $Resultado['Dados'] = $Grv;
        $Resultado['Cod_Error'] = $Cod_error;
        echo json_encode($Resultado);

        break ;



    case 'Salva_Liberacao' :

            $Grv             = $_POST['Grv'];
            $IdPatio         = $_POST['Patio'];
            $Nome            = strtoupper($_POST['Nome']);
            $TipoResp        = $_POST['TipoResp'];
            $Cpf             =  $_POST['Cpf'];
            $Telefone        = $_POST['Telefone'];
            $Lote            = $_POST['Lote'];
            $Status         = 'L';//Leiloado
            $IdUsuario      = $_SESSION['ID_USUARIO'];
            date_default_timezone_set('America/Sao_Paulo');
            $DataRetirada = date("Y-m-d");
            $HoraRetirada = date("H:i:s");

              if ((!empty($Cpf)) && (!empty($Nome)) && (!empty($Lote)) ) {

                  $statement = $pdo->prepare('INSERT INTO grv_liberaleilao(GRV, ID_PATIO, TIPORESP, CPF,NOME, TELEFONE,IDUSUARIO,LOTE)
                                                        VALUES (:grv,:idpatio,:tiporesp,:cpf,:nome,:telefone,:idusuario,:lote)');

                  // Adiciona os dados acima para serem executados na senten�a
                  $statement->bindParam(':grv', $Grv);
                  $statement->bindParam(':idpatio', $IdPatio);
                  $statement->bindParam(':tiporesp', $TipoResp);
                  $statement->bindParam(':cpf', $Cpf);
                  $statement->bindParam(':nome', $Nome);
                  $statement->bindParam(':lote', $Lote);
                  $statement->bindParam(':telefone', $Telefone);
                  $statement->bindParam(':idusuario', $IdUsuario);

                  // Executa a senten�a j� com os valores
                  if ($statement->execute()) {

                      $stmt = $pdo->prepare('UPDATE grv_status SET   DATARETIRADA = :dataretirada , STATUS = :status,
                                                      HORARETIRADA = :horaretirada WHERE ID_PATIO =:patio AND GRV =:grv');
                      $stmt->bindParam(':grv', $Grv);
                      $stmt->bindParam(':patio', $IdPatio);
                      $stmt->bindParam(':status', $Status);
                      $stmt->bindParam(':horaretirada', $HoraRetirada);
                      $stmt->bindParam(':dataretirada', $DataRetirada);
                      $stmt->execute();
                      $Cod_error = 0;
                      // caso seja diferente da forma de pagamento DINHEIRO/CARTAO
                  }else{
                        $Cod_error =$statement->errorInfo();

                    }
            }
                    $Resultado['Cod_Error'] = $Cod_error;
                    echo json_encode($Resultado);

               break ;
            }

