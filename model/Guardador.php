<?php
/**
 * Created by PhpStorm.
 * User: ALAN LAMIN
 * Date: 11/10/2019
 * Time: 15:26
 */
require '../fontes/conexao.php';
require 'FuncaoData.php';

session_start();
$acao = $_POST['acao'];

switch($acao) {

    case 'Busca_Painel' :

        if($_SESSION['NIVEL']=='V' || $_SESSION['NIVEL']=='A'||$_SESSION['NIVEL']=='F') {

            // busca Pontos
            $DataHj = date("Y-m-d");
            $DataRetiradaHj = date("Y-m-d");
            $statusOcupada = 'A';
            $StatusEvasao = 'E';
            $Guardador =$_POST['Guardador'];
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
                $stmt = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdTicketDiaria FROM ticket WHERE DATAENT = :data AND ID_GUARDADOR=:idguardador ');
                $stmt->bindParam(':data', $DataHj);
                $stmt->bindParam(':idguardador', $Guardador);
                $stmt->execute();
                $linha = $stmt->fetch();
                $QtdRemovidoDiaria = $linha['QtdTicketDiaria'];
                //Qtd Notificaçoes
                $stmtnot = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdTicketNotificado FROM ticket WHERE  EVASAO = 1 AND DATAENT = :data AND ID_GUARDADOR=:idguardador ');
                $stmtnot->bindParam(':data', $DataHj);
                $stmtnot->bindParam(':idguardador', $Guardador);
                $stmtnot->execute();
                $linhaNot = $stmtnot->fetch();
                $QtdTicketNot = $linhaNot['QtdTicketNotificado'];

                $stmt1 = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdTicketSemanal FROM ticket  WHERE WEEK(DATAENT) =  WEEK(now()) AND ID_GUARDADOR=:idguardador');
                $stmt1->bindParam(':idguardador', $Guardador);
                $stmt1->execute();
                $linha1 = $stmt1->fetch();
                $QtdRemovidoSemanal = $linha1['QtdTicketSemanal'];


                $stmt2 = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdticketMensal FROM ticket  WHERE 
                                            MONTH(DATAENT) =  MONTH(now()) 
                                            AND ID_GUARDADOR=:idguardador');
                $stmt2->bindParam(':idguardador', $Guardador);
                $stmt2->execute();
                $linha2 = $stmt2->fetch();
                $QtdRemovidoMensal = $linha2['QtdticketMensal'];


                $st = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdEvasaoDiaria FROM ticket WHERE 
                 DATAENT=:data AND EVASAO = 2 AND ID_GUARDADOR=:idguardador ');
                $st->bindParam(':data', $DataHj);
                $st->bindParam(':idguardador', $Guardador);
                $st->execute();
                $l = $st->fetch();
                $QtdEvasaoDiaria = $l['QtdEvasaoDiaria'];


                $st1 = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdEvasaoSemanal FROM ticket WHERE
                           WEEK(DATAENT)=WEEK(now()) AND EVASAO = 2 AND ID_GUARDADOR=:idguardador ');
                $st1->bindParam(':idguardador', $Guardador);
                $st1->execute();
                $l1 = $st1->fetch();
                $QtdEvasaoSemanal = $l1['QtdEvasaoSemanal'];

                $st2 = $pdo->prepare('SELECT COUNT(IDTICKET) AS QtdEvasaoMensal FROM ticket WHERE  MONTH(DATAENT)= MONTH(now()) AND EVASAO = 2 AND ID_GUARDADOR=:idguardador ');
                $st2->bindParam(':idguardador', $Guardador);
                $st2->execute();
                $l2 = $st2->fetch();
                $QtdEvasaoMensal = $l2['QtdEvasaoMensal'];

                $stV = $pdo->prepare('SELECT SUM(VALOR)  AS ValorTotalDiaria FROM ticket WHERE DATAENT =:datahj 
                AND EVASAO = 0 AND ID_GUARDADOR=:idguardador ');
                $stV->bindParam(':idguardador', $Guardador);
                $stV->bindParam(':datahj', $DataHj);
                $stV->execute();
                $lv = $stV->fetch();
                if ($lv['ValorTotalDiaria'] == 'null') {
                    $ValorTotalDiario = '0.00';
                } else {
                    $ValorTotalDiario = $lv['ValorTotalDiaria'];
                }

                if ($ValorTotalDiario == 0.00) {
                    $TicketMedio = 2.00;
                } else {
                    $TicketMedio = $ValorTotalDiario / $QtdRemovidoDiaria;
                }

                $stV1 = $pdo->prepare('SELECT SUM(VALOR) AS ValorTotalSemanal FROM ticket WHERE WEEK(DATAENT)=WEEK(now())  
                AND EVASAO = 0 AND ID_GUARDADOR=:idguardador ');
                $stV1->bindParam(':idguardador', $Guardador);
                $stV1->execute();
                $lv1 = $stV1->fetch();
                $ValorTotalSemanal = $lv1['ValorTotalSemanal'];


                $stV2 = $pdo->prepare('SELECT SUM(VALOR)  AS ValorTotalMensal FROM ticket WHERE
                                               MONTH(DATAENT) =  MONTH (now())  AND EVASAO = 0 AND ID_GUARDADOR=:idguardador');
                $stV2->bindParam(':idguardador', $Guardador);
                $stV2->execute();
                $lv2 = $stV2->fetch();
                $ValorTotalMensal = $lv2['ValorTotalMensal'];

                
                $Resultado['TicketNotificado']       = $QtdTicketNot;
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

