<?php
require '../fontes/conexao.php';
include '../MPDF/mpdf.php';
require '../model/FuncaoData.php';
ob_start(); //inicia o buffer
//session_start();
set_time_limit(0);//$Retirada   = $_POST['TrimestreRel'];
?>
<!--AQUI COMEÇA O QUE IRA APARECE NO PDF-->

<html>
<head>
    <meta charset= "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="shortcut icon" href="../figuras/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../figuras/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../plugins/iCheck/icheck.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>


</head>
<body >
<!------------------------------Cabeçalho do sistema------------------------------------------------------>
<?php
$DataInicio  = $_POST['Txt_DataInicial'];
$DataFinal   =  $_POST['Txt_DataFim'];
$Fiscal      =  '%';
$FormaPgDinheiro = 'D';
$FormaPgCartao = 'C';

$stEmpresa = $pdo->prepare( 'SELECT * FROM empresa');
$stEmpresa->execute();
$LinhaEmpresa=$stEmpresa->fetch();

echo '<h3>'.$LinhaEmpresa['NOME'].'</h3><hr>';

$stValor = $pdo->prepare( 'SELECT SUM(VALOR) - SUM(VALOR)*0.2  AS VALORTOTAL  FROM ticket T  WHERE  T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0');
$stValor->bindParam(':datainicio', $DataInicio);
$stValor->bindParam(':datafim', $DataFinal);
$stValor->execute();
$LinhaValor=$stValor->fetch();

echo '  <p align="right">Relatório Periodo '. PdBrasil($DataInicio).  ' - ' .PdBrasil($DataFinal).
'<br>
                            <table style="font-size:8pt;width:50%;" border="1">
                                    <tr>
                                        <th style="padding:1%;">Dinheiro</th> 
                                        <th style="padding:1%;">R$ ' . number_format($LinhaValor["VALORTOTAL"], 2, ",", "") . '</th>
                                    </tr>
                                    
                                     <tr>
                                        <th style="background-color: lightgrey;padding:1%;">Valor Total</th> 
                                        <th style="background-color: lightgrey;padding:1%;">R$ ' . number_format($LinhaValor["VALORTOTAL"], 2, ",", "") . '</th>
                                    </tr>
                                    
                            </table><br>

<fieldset><legend>Histórico de Tickets</legend>
             </fieldset><hr>';
             $stTicket = $pdo->prepare( 'SELECT SUM(T.VALOR) - SUM(T.VALOR)*0.2  AS VALORTOTAL, COUNT(T.CODTICKET) - COUNT(T.CODTICKET)*0.2 AS QTDTICKET , COUNT(T.CODTICKET)*0.2  AS QTDEVASAO   , T.DATAENT   FROM  ticket T  WHERE T.EVASAO =0 AND 
              T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0 GROUP BY T.DATAENT ASC');
         
            $stTicket->bindParam(':datainicio', $DataInicio);
            $stTicket->bindParam(':datafim', $DataFinal);
           

if($stTicket->execute()) {

         echo '<table style="font-size:8pt;width:100%;" border="1">
                                    <tr style="background-color: lightgrey;">
                                         <th style="padding:1%;">Data</th>
                                        <th style="padding:1%;">Quantidade Ticket Pago</th> 
                                        <th style="padding:1%;">Quantidade Ticket Não Pago</th> 
                                       
                                        
                                    </tr>';

         while ($Linha = $stTicket->fetch()) {
           
                                 echo '<tr>
                                        <td style="padding:1%;">' . PdBrasil($Linha["DATAENT"]) . '</td> 
                                        <td style="padding:1%;">' . round($Linha["QTDTICKET"]) . '</td> 
                                        <td style="padding:1%;">' . round($Linha["QTDEVASAO"]) . '</td> 
                                       
                                      </tr>';
         }
         echo ' </table><br>';
     }
?>
</body>
</html>
<?php
$html=ob_get_clean();
$mpdf=new mPDF('utf-8', 'A4',0,'',8,8,8,15,8,10,'P');
//define o caminho da folha de estilo
//coloca o estilo no html
$mpdf->WriteHTML($stylesheet,1);
//$PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($html);
$arq = 'Relat'.date('dmYHs').'.pdf';
$mpdf->Output($arq,'D');