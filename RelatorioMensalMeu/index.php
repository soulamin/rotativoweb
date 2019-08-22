﻿

<?php
require '../fontes/conexao.php';
require '../model/FuncaoData.php';
session_start();
set_time_limit(0);//$Retirada   = $_POST['TrimestreRel'];
//$Tipo        = $_POST['TipoTr'];
ob_start(); //inicia o buffer

?>
<!--AQUI COMEÇA O QUE IRA APARECE NO PDF-->

<html>

<head>
    <meta charset= "UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>:: BRZona Azul::</title>
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
$Fiscal      = $_POST['Txt_Fiscal'];
$FormaPgDinheiro = 'D';
$FormaPgCartao = 'C';


$stEmpresa = $pdo->prepare( 'SELECT * FROM empresa');
$stEmpresa->execute();
$LinhaEmpresa=$stEmpresa->fetch();

echo '<h3>'.$LinhaEmpresa['NOME'].'</h3><hr>';

$stValor = $pdo->prepare( 'SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
 AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0');
$stValor->bindParam(':idfiscal', $Fiscal);
$stValor->bindParam(':datainicio', $DataInicio);
$stValor->bindParam(':datafim', $DataFinal);
$stValor->execute();
$LinhaValor=$stValor->fetch();

$stD = $pdo->prepare( 'SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
 AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.ID_FORMAPG=:formapg AND T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0');
$stD->bindParam(':idfiscal', $Fiscal);
$stD->bindParam(':formapg', $FormaPgDinheiro);
$stD->bindParam(':datainicio', $DataInicio);
$stD->bindParam(':datafim', $DataFinal);
$stD->execute();
$LinhaD=$stD->fetch();

$stC= $pdo->prepare( 'SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
 AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.ID_FORMAPG=:formapg AND T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0' );
$stC->bindParam(':idfiscal', $Fiscal);
$stC->bindParam(':formapg', $FormaPgCartao);
$stC->bindParam(':datainicio', $DataInicio);
$stC->bindParam(':datafim', $DataFinal);
$stC->execute();
$LinhaC=$stC->fetch();


echo '  <p align="right">Relatório Periodo '. PdBrasil($DataInicio).  ' - ' .PdBrasil($DataFinal).
'<br>
                            <table style="font-size:8pt;width:50%;" border="1">
                                    <tr>
                                        <th style="padding:1%;">Dinheiro</th> 
                                        <th style="padding:1%;">R$ ' . number_format($LinhaD["VALORTOTAL"], 2, ",", "") . '</th>
                                    </tr>
                                    <tr>
                                        <th style="padding:1%;">Débito/Crédito</th> 
                                        <th style="padding:1%;">R$ ' . number_format($LinhaC["VALORTOTAL"], 2, ",", "") . '</th>
                                    </tr>
                                     <tr>
                                        <th style="background-color: lightgrey;padding:1%;">Valor Total</th> 
                                        <th style="background-color: lightgrey;padding:1%;">R$ ' . number_format($LinhaValor["VALORTOTAL"], 2, ",", "") . '</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: lightgrey;padding:1%;">Taxa Admin</th> 
                                        <th style="background-color: lightgrey;padding:1%;">R$ ' . number_format(($LinhaValor["VALORTOTAL"]*0.1), 2, ",", "") . '</th>
                                    </tr>
                            </table><br>

<fieldset><legend>Histórico de Tickets</legend>
             </fieldset><hr>';
     $stTicket = $pdo->prepare( 'SELECT U.NOME ,T.STATUS,L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,
                                  T.HORASAIDA,T.CODTICKET,T.VALOR ,D.ENDERECO,T.ID_FORMAPG,(T.VALOR*0.1) AS VALORRETIDO
                               FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
                               AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.DATAENT BETWEEN :datainicio AND :datafim AND T.EVASAO=0');
     $stTicket->bindParam(':datainicio', $DataInicio);
     $stTicket->bindParam(':datafim', $DataFinal);
     $stTicket->bindParam(':idfiscal', $Fiscal);

if($stTicket->execute()) {

         echo '<table style="font-size:8pt;width:100%;" border="1">
                                    <tr style="background-color: lightgrey;">
                                        <th style="padding:1%;">Ticket</th> 
                                        <th style="padding:1%;">Fiscal</th>
                                        <th style="padding:1%;">Localidade</th>
                                        <th style="padding:1%;">Placa</th>
                                        <th style="padding:1%;">Data/Hora Ent.- Saída</th>
                                        <th style="padding:1%;">Valor </th>
                                        <th style="padding:1%;">Valor Adm. </th>
                                        <th style="padding:1%;">Forma Pg.</th>
                                      
                                      
                                    </tr>';

         while ($Linha = $stTicket->fetch()) {
             if ($Linha["ID_FORMAPG"] == 'D') {
                 $FormaPg = 'Dinheiro';

             } else {
                 $FormaPg = 'Débito/Crédito';

                
             }
                                 echo '<tr>
                                        <td style="padding:1%;">' . $Linha["CODTICKET"] . '</td> 
                                        <td style="padding:1%;">' . $Linha["NOME"] . '</td> 
                                        <td style="padding:1%;">'  . $Linha["ENDERECO"] . '</td>
                                        <td style="padding:1%;">'  . $Linha["PLACA"] . '</td>
                                        <td style="padding:1%;">'.PdBrasil($Linha["DATAENT"]).' '.$Linha["HORAENT"].' - '.PdBrasil($Linha["DATASAIDA"]).' '.$Linha["HORASAIDA"].'</td>
                                        <td style="padding:1%;">R$ ' . number_format($Linha["VALOR"], 2, ",", "") . ' </td>
                                        <td style="padding:1%;">R$ ' . number_format($Linha["VALORRETIDO"], 2, ",", "") . ' </td>
                                        <td style="padding:1%;">' .$FormaPg . '</td>
                                      </tr>';
         }
         echo ' </table><br>';
     }

?>

</body>
</html>
<?php
$html=ob_get_clean();
include '../MPDF/mpdf.php';
$mpdf=new mPDF('utf-8', 'A4',0,'',8,8,8,15,8,10,'P');

//define o caminho da folha de estilo
$stylesheet = file_get_contents('../bootstrap/css/bootstrap.min.css');
//coloca o estilo no html
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$arq = 'Relat'.date('dmYHs').'.pdf';
$mpdf->Output($arq,'D');

?>