<?php
require '../fontes/conexao.php';
include '../MPDF/mpdf.php';
require '../model/FuncaoData.php';
ob_start(); //inicia o buffer
session_start();
set_time_limit(0);
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
$DataEnt        =  $_GET['D'];
$Fiscal         =  $_GET['F'];
$Usuario        = $_SESSION['ID_USUARIO'];

$stEmpresa      = $pdo->prepare( 'SELECT * FROM empresa');
$stEmpresa->execute();
$LinhaEmpresa=$stEmpresa->fetch();

$stUsuario      = $pdo->prepare( 'SELECT * FROM usuarios WHERE IDUSUARIO=:idusuario');
$stUsuario->bindParam(':idusuario', $Fiscal);
$stUsuario->execute();
$LinhaUsuario=$stUsuario->fetch();

echo '<h3>'.$LinhaEmpresa['NOME'].'</h3><hr>';

            //Proprietario
            $stValor = $pdo->prepare('SELECT SUM(VALOR) AS VALORTOTAL , COUNT(IDTICKET)  AS QTDTICKET FROM ticket WHERE EVASAO = 0 AND DATAENT = :data AND ID_GUARDADOR=:idguardador ');
            $stValor->bindParam(':data', $DataEnt);
            $stValor->bindParam(':idguardador', $Fiscal);
            $stValor->execute();
           
            $LinhaValor=$stValor->fetch();

           echo ' <p align="center" >Fechamento de Caixa | GUARDADOR :'.$LinhaUsuario['NOME'].' |  DATA : '.PdBrasil($DataEnt).'</p><br>
                            <table style="font-size:10pt;width:100%;" border="1">
                                    <tr>
                                        <th style="padding:1%;">Valor Total R$ ' . number_format($LinhaValor["VALORTOTAL"], 2, ",", "") .'</th> 
                                        <th style="padding:1%;">Quantidade Ticket :' .$LinhaValor["QTDTICKET"].'</th> 
                                    </tr>
                                    <tr>
                                        <th style="padding:1%;">Recebido R$ </th> 
                                        <th style="padding:1%;" align="center"><hr><br> '.$LinhaUsuario['NOME'].' 
                                        </th> 
                                     </tr>
                    </table><br>
                    <p>Conferido em '.date('d/m/Y H:i:s').'</p><hr> ';  
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
$mpdf->Output($arq,'I');