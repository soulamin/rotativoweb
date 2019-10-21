<?php
/**
 * Created by PhpStorm.
 * User: Comunicarte
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';
require 'FuncaoData.php';

session_start();
$acao = $_POST['acao'];

switch($acao) {

    case 'Busca_PainelSelecionadoGrupo' :

        if($_SESSION['NIVEL']=='V' || $_SESSION['NIVEL']=='A'||$_SESSION['NIVEL']=='S') {


            // busca Pontos
            $DataHj = date("Y-m-d");
            $DataRetiradaHj = date("Y-m-d");
            $statusRemocao = 'C';
            $StatusRetirada = 'R';
            $StatusLeilao = 'L';
            $Mes=$_POST['Mes'];



            $stV3 = $pdo->prepare('SELECT SUM(p.VALORTOTAL) AS ValorTotalMensal FROM grv_status s,grv_pagamento p
                                             WHERE s.GRV=p.GRV AND s.ID_PATIO=p.IDPATIO AND s.STATUS =:status AND
                                              MONTH(s.DATARETIRADA) =  MONTH (:mes)  AND ID_PROPRIETARIO =2');
            $stV3->bindParam(':status', $StatusRetirada);
            $stV3->bindParam(':mes', $Mes);
            $stV3->execute();
            $lv3 = $stV3->fetch();
            $ValorTotalMensal1 = $lv3['ValorTotalMensal'];


            $Resultado['ValorTotalMensalSelecionado'] = 'R$' .number_format($ValorTotalMensal1, 2, ",", "");


        }else{
            session_destroy();
        }

        echo json_encode($Resultado);


        break ;

  

    case 'Busca_Painel' :

        if($_SESSION['NIVEL']=='V' || $_SESSION['NIVEL']=='A'||$_SESSION['NIVEL']=='S') {


            // busca Pontos
            $DataHj = date("Y-m-d");
            $DataRetiradaHj = date("Y-m-d");
            $statusOcupada = 'A';
            $StatusEvasao = 'E';
            //$StatusLeilao = 'L';
            $Resultado['PainelPatio'] ='';

              //Qtd Vagas
              $stmtvagas = $pdo->prepare('SELECT SUM(QTD_VAGAS)  as TotalVagas FROM localidade WHERE STATUS = 1 ');
              $stmtvagas->execute();
              $linhavagas = $stmtvagas->fetch();
              $TotalVagas = $linhavagas['TotalVagas'];

              $stmtocupadas = $pdo->prepare('SELECT COUNT(IDTICKET) As VagasOcupadas FROM ticket  WHERE STATUS = :status');
              $stmtocupadas->bindParam(':status', $statusOcupada);
              $stmtocupadas->execute();
              $linhaocupadas = $stmtocupadas->fetch();

             if( $linhaocupadas['VagasOcupadas']>=0){
                $TotalOcupadas = $linhaocupadas['VagasOcupadas'];
                $PorcOcupadas  = ($TotalOcupadas/$TotalVagas) * 100;
             }else{
                $TotalOcupadas=0;
                $PorcOcupadas  = 0;

             }

            
              $TotalDisponivel =  $TotalVagas - $TotalOcupadas;
              $PorcDisponivel  =  ($TotalDisponivel/$TotalVagas) * 100;

                //Proprietario
                $stmt = $pdo->prepare('SELECT COUNT(IDTICKET)- COUNT(IDTICKET)*0.2 AS QtdTicketDiaria FROM ticket WHERE DATAENT = :data ');
                $stmt->bindParam(':data', $DataHj);
                $stmt->execute();
                $linha = $stmt->fetch();
                $QtdRemovidoDiaria = round($linha['QtdTicketDiaria']);


                $stmt1 = $pdo->prepare('SELECT COUNT(IDTICKET) - COUNT(IDTICKET)*0.2 AS QtdTicketSemanal FROM ticket  WHERE WEEK(DATAENT) =  WEEK(now())');
                $stmt1->execute();
                $linha1 = $stmt1->fetch();
                $QtdRemovidoSemanal = round($linha1['QtdTicketSemanal']);


                $stmt2 = $pdo->prepare('SELECT COUNT(IDTICKET)- COUNT(IDTICKET)*0.2 AS QtdticketMensal FROM ticket  WHERE 
                                            MONTH(DATAENT) =  MONTH(now())');
                $stmt2->execute();
                $linha2 = $stmt2->fetch();
                $QtdRemovidoMensal = round($linha2['QtdticketMensal']);


                $st = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdEvasaoDiaria FROM ticket WHERE  DATAENT=:data AND EVASAO = 2');
                $st->bindParam(':data', $DataHj);
                $st->execute();
                $l = $st->fetch();
                $QtdEvasaoDiaria = $l['QtdEvasaoDiaria'];


                $st1 = $pdo->prepare('SELECT COUNT(IDTICKET)  AS QtdEvasaoSemanal FROM ticket WHERE
                           WEEK(DATAENT)=WEEK(now()) AND EVASAO = 2');
               
                $st1->execute();
                $l1 = $st1->fetch();
                $QtdEvasaoSemanal = $l1['QtdEvasaoSemanal'];

                $st2 = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdEvasaoMensal FROM ticket WHERE  MONTH(DATAENT)= MONTH(now()) AND EVASAO = 2');
                $st2->execute();
                $l2 = $st2->fetch();
                $QtdEvasaoMensal = $l2['QtdEvasaoMensal'];


                $stV = $pdo->prepare('SELECT SUM(VALOR)- SUM(VALOR)*0.2 AS ValorTotalDiaria FROM ticket WHERE DATAENT =:datahj AND EVASAO = 0');
                $stV->bindParam(':datahj', $DataHj);
                $stV->execute();
                $lv = $stV->fetch();
                if ($lv['ValorTotalDiaria'] == 'null') {
                    $ValorTotalDiario = '0.00';
                } else {
                    $ValorTotalDiario = round($lv['ValorTotalDiaria']);
                }

                if ($ValorTotalDiario == 0.00) {
                    $TicketMedio = 2.00;
                } else {
                    $TicketMedio = 2.00;//$ValorTotalDiario / $QtdRemovidoDiaria;
                }

                $stV1 = $pdo->prepare('SELECT SUM(VALOR)- SUM(VALOR)*0.2 AS ValorTotalSemanal FROM ticket WHERE WEEK(DATAENT)=WEEK(now())  AND EVASAO = 0');
                $stV1->execute();
                $lv1 = $stV1->fetch();
                $ValorTotalSemanal = round($lv1['ValorTotalSemanal']);


                $stV2 = $pdo->prepare('SELECT SUM(VALOR)- SUM(VALOR)*0.2 AS ValorTotalMensal FROM ticket WHERE
                                               MONTH(DATAENT) =  MONTH (now())  AND EVASAO = 0 ');
                $stV2->execute();
                $lv2 = $stV2->fetch();
                $ValorTotalMensal = round($lv2['ValorTotalMensal']);

                $Resultado['PorcOcupada']        = $PorcOcupadas;
                $Resultado['PorcDisponivel']     = $PorcDisponivel;
                $Resultado['QtdTicketDiaria']    = $QtdRemovidoDiaria;
                $Resultado['QtdTicketSemanal']   = $QtdRemovidoSemanal;
                $Resultado['QtdTicketMensal']    = $QtdRemovidoMensal;
                $Resultado['QtdEvasaoDiaria']    = $QtdEvasaoDiaria;
                $Resultado['QtdEvasaoSemanal']   = $QtdEvasaoSemanal;
                $Resultado['QtdEvasaoMensal']    = $QtdEvasaoMensal;
                $Resultado['ValorTotalDiario']   = 'R$' .number_format($ValorTotalDiario, 2, ",", "");
                $Resultado['ValorTotalMensal']   = 'R$' .number_format($ValorTotalMensal, 2, ",", "");
                $Resultado['ValorTotalSemanal']  = 'R$' .number_format($ValorTotalSemanal, 2, ",", "");
                $Resultado['TicketMedio']        = 'R$' .number_format($TicketMedio, 2, ",", "");
            
        }else{
            session_destroy();
        }

        echo json_encode($Resultado);


    break ;
}

