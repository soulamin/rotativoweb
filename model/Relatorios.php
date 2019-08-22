<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 25/10/2017
 * Time: 15:26
 */
require '../fontes/conexao.php';
require 'FuncaoData.php';
session_start();
$acao = $_POST['acao'];

switch($acao){

    case 'Busca_EstoqueAtual' :

        $dataHj = date("d/m/y");
        $arquivo = 'Estoque Atual'.$dataHj.'.xls';

        $tabela = '<table border="1">';
        $tabela .= "<tr>";
        $tabela .= '<td colspan="2">Estoque Atual </tr>';
        $tabela .= '</tr>';
        $tabela .= '<tr>';
        $tabela .= '<th><b>PATIO</b></th>';
        $tabela .= '<th><b>GRV</b></th>';
        $tabela .= '<td><b>PLACA</b></td>';
        $tabela .= '<th><b>CHASSI</b></th>';
        $tabela .= '<td><b>TIPO VEICULO</b></td>';
        $tabela .= '<th><b>MARCAMODELO</b></th>';
        $tabela .= '<td><b>COR</b></td>';
        $tabela .= '<th><b>FISCALIZADOR</b></th>';
        $tabela .= '<td><b>DATA REMOÇÃO</b></td>';
        $tabela .= '<th><b>NOME AGENTE </b></th>';
        $tabela .= '<th><b>MAT. AGENTE </b></th>';
        $tabela .= '<th><b>USOU REBOQUE</b></th>';
        $tabela .= '<th><b>MAT. AGENTE </b></th>';
        $tabela .= '</tr>';

        $stmt = $pdo->prepare( 'SELECT V.AGENTEMAT,V.AGENTENOME,S.DATAREMOCAO,S.HORAREMOCAO,V.PLACA,V.CHASSI,V.TIPOVEICULO,
                                           V.USOREBOQUE,V.MARCAMODELO,V.COR ,A.FISCALIZADOR ,P.PATIO,
                                     S.GRV AS SGRV FROM grv_status S INNER JOIN grv_veiculo V ON S.GRV=V.GRV AND
                                S.ID_PATIO=V.ID_PATIO INNER JOIN agentefiscalizador A ON A.ID=V.ID_AGENTE INNER JOIN patios P ON V.ID_PATIO=P.ID AND
                                 WHERE S.STATUS IN ("C","G")' );
         $stmt->execute();
        while ($linha = $stmt->fetch())
        {
            $tabela .= '<tr>';
                $tabela .= '<td>'.$linha['SGRV'].'</td>';
                $tabela .= '<td>'.$linha['PLACA'].'</td>';
                $tabela .= '<td>'.$linha['CHASSI'].'</td>';
                $tabela .= '<td>'.$linha['TIPOVEICULO'].'</td>';
                $tabela .= '<td>'.$linha['MARCAMODELO'].'</td>';
                $tabela .= '<td>'.$linha['COR'].'</td>';
                $tabela .= '<td>'.$linha['FISCALIZADOR'].'</td>';
                $tabela .= '<td>'.PdBrasil($linha['DATAREMOCAO']).'</td>';
                $tabela .= '<td>'.$linha['HORAREMOCAO'].'</td>';
                $tabela .= '<td>'.$linha['AGENTENOME'].'</td>';
                $tabela .= '<td>'.$linha['AGENTEMAT'].'</td>';
                $tabela .= '<td>'.$linha['USOREBOQUE'].'</td>';
            $tabela .= '</tr>';
        }

       $tabela .= '</table>';

// Força o Download do Arquivo Gerado
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header('Content-Type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");
echo $tabela;


        break ;

    case 'Busca_Relatorios' :

        $DataInicio=$_POST["DataInicio"];
        $DataFim   =$_POST["DataFim"];

        if($_POST["Status"]=='C'){
            $stmt = $pdo->prepare( 'SELECT V.AGENTENOME,V.AGENTEMAT ,S.DATAREMOCAO,S.DATARETIRADA,V.PLACA,V.CHASSI,V.TIPOVEICULO,V.USOREBOQUE,V.MARCAMODELO,V.COR ,A.FISCALIZADOR ,S.GRV AS SGRV ,S.STATUS AS STATUSGRV FROM grv_status S INNER JOIN grv_veiculo V ON S.GRV=V.GRV AND
                                S.ID_PATIO=V.ID_PATIO INNER JOIN agentefiscalizador A ON A.ID=V.ID_AGENTE 
                                 WHERE S.STATUS IN ("C","G","R","L") 
                                 AND S.DATAREMOCAO BETWEEN :datainicio AND :datafim' );
        }else{
            $stmt = $pdo->prepare( 'SELECT V.AGENTENOME,V.AGENTEMAT, S.DATAREMOCAO,S.DATARETIRADA,V.PLACA,V.CHASSI,V.TIPOVEICULO,V.USOREBOQUE,V.MARCAMODELO,V.COR ,A.FISCALIZADOR ,S.GRV AS SGRV ,S.STATUS AS STATUSGRV FROM grv_status S INNER JOIN grv_veiculo V ON S.GRV=V.GRV AND
                                S.ID_PATIO=V.ID_PATIO INNER JOIN agentefiscalizador A ON A.ID=V.ID_AGENTE 
                                 WHERE S.STATUS IN ("R","L") 
                                 AND S.DATARETIRADA BETWEEN :datainicio AND :datafim' );
        }


        $stmt->bindParam(':datainicio',$DataInicio);
        $stmt->bindParam(':datafim',$DataFim);
        //$stmt->bindParam(':status',$Status);
        $executa=$stmt->execute();
        $Reboque = array();

    while ($linha = $stmt->fetch())
    {
        if($linha['STATUSGRV']=='C'){
            $StatusGrv ='GRV';
        }elseif ($linha['STATUSGRV']=='G'){
            $StatusGrv ='GGV';
        }else{
            $StatusGrv ='LIBERADO';
        }
        $r = array('MatAgente' => $linha['AGENTEMAT'],'NomeAgente' => $linha['AGENTENOME'],'Placa' => $linha['PLACA'],
            'Grv' => $linha['SGRV'],'Agente' => $linha['FISCALIZADOR'],'Chassi' => $linha['CHASSI'],
            'MarcaModelo' => $linha['MARCAMODELO'],'TipoVeiculo' => $linha['TIPOVEICULO'],'Autoridade' => $linha['FISCALIZADOR'],
            'Cor' => $linha['COR'],'DataRemocao' => PdBrasil($linha['DATAREMOCAO']),
            'DataLiberacao' => PdBrasil($linha['DATARETIRADA']),'UsoReboque' => $linha['USOREBOQUE']);
        array_push($Reboque, $r);
    }

    $Resultado['Html'] = $Reboque;
    echo json_encode($Resultado);

    break ;

    case 'Busca_RelatoriosAgentes' :

        $DataInicio=$_POST["DataInicio"];
        $DataFim   =$_POST["DataFim"];

        if($_POST["Status"]=='C') {
            $stmt = $pdo->prepare('SELECT s.DATAREMOCAO ,A.FISCALIZADOR AS AGENTE , v.TIPOVEICULO AS TIPO ,count(v.TIPOVEICULO) AS QUANTIDADE FROM 
                                `grv_status` s , grv_veiculo v ,agentefiscalizador A WHERE s.GRV=v.GRV AND A.ID=v.ID_AGENTE AND
                                s.`ID_PATIO`=v.ID_PATIO AND s.`DATAREMOCAO` BETWEEN :datainicio AND :datafim GROUP BY v.ID_AGENTE, v.TIPOVEICULO ORDER BY A.FISCALIZADOR');
        }else{
            $stmt = $pdo->prepare('SELECT s.DATAREMOCAO ,A.FISCALIZADOR AS AGENTE , v.TIPOVEICULO AS TIPO ,count(v.TIPOVEICULO) AS QUANTIDADE FROM 
                                `grv_status` s , grv_veiculo v ,agentefiscalizador A WHERE s.GRV=v.GRV AND A.ID=v.ID_AGENTE AND
                                s.`ID_PATIO`=v.ID_PATIO AND s.`DATARETIRADA` BETWEEN :datainicio AND :datafim GROUP BY v.ID_AGENTE, v.TIPOVEICULO ORDER BY A.FISCALIZADOR');
        }
        $stmt->bindParam(':datainicio',$DataInicio);
        $stmt->bindParam(':datafim',$DataFim);
        $executa=$stmt->execute();
        $Reboque = array();
        $Total=0;
        while ($linha = $stmt->fetch())
        {
            $DataRemocao =$linha['DATAREMOCAO'];
            $Total=$Total+$linha['QUANTIDADE'];
            $r = array('Agente' => $linha['AGENTE'],'Tipo' => $linha['TIPO'],'Quantidade' => $linha['QUANTIDADE']);

            array_push($Reboque, $r);
        }
        $Resultado['DataRemocao'] = PdBrasil($DataRemocao);
        $Resultado['Total'] = $Total;
        $Resultado['Html'] = $Reboque;
        echo json_encode($Resultado);

        break ;

    case 'Busca_Painel_Estoque' :

        if($_SESSION['NIVEL']!='U') {


            // busca Pontos
            $statusRemocao = 'C';
            $StatusGuardado = 'G';
            $StatusRetirada = 'R';
            $StatusLeilao = 'L';

            //Recolhidos
            $stmt = $pdo->prepare('SELECT  COUNT(S.GRV) AS QtdRecolhido FROM grv_status S INNER JOIN grv_veiculo V ON S.GRV=V.GRV AND
                                S.ID_PATIO=V.ID_PATIO INNER JOIN agentefiscalizador A ON A.ID=V.ID_AGENTE INNER JOIN patios P ON V.ID_PATIO=P.ID 
                                 WHERE S.STATUS IN ("C","G")');
            $stmt->execute();
            $linha1 = $stmt->fetch();
            $QtdRecolhido = $linha1['QtdRecolhido'];


            $stmt3 = $pdo->prepare('SELECT COUNT(GRV) AS QtdLiberado FROM grv_status WHERE  STATUS IN (:statusliberado,:statusleilao) ');
            $stmt3->bindParam(':statusleilao', $StatusLeilao);
            $stmt3->bindParam(':statusliberado', $StatusRetirada);
            $stmt3->execute();
            $linha3 = $stmt3->fetch();
            $QtdLiberado= $linha3['QtdLiberado'];


            $Resultado['QtdRecolhido']   = $QtdRecolhido;
            $Resultado['QtdLiberado']    = $QtdLiberado;


        }else{
            session_destroy();
        }

        echo json_encode($Resultado);


        break ;

    case 'Busca_Veiculo_Estoque' :

        if($_SESSION['NIVEL']!='U') {


            // busca Pontos
            $statusRemocao = 'C';
            $StatusGuardado = 'G';
            $StatusRetirada = 'R';
            $StatusLeilao = 'L';

            $stmtVeic = $pdo->prepare('SELECT  MEIOTRANSPORTE  FROM tipotransporte ');
            $stmtVeic->execute();

            $Dados="";
            $Dados1="";
            while($LinhaVeiculos= $stmtVeic->fetch()) {

                $TipoVeiculo = $LinhaVeiculos['MEIOTRANSPORTE'];

                //Recolhidos
                $stmt = $pdo->prepare('SELECT COUNT(s.GRV) AS QtdRecolhido FROM grv_status s, grv_veiculo v WHERE s.GRV=v.GRV AND s.STATUS IN ("C","G") AND  v.TIPOVEICULO =:tipoveiculo ');
                $stmt->bindParam(':tipoveiculo', $TipoVeiculo);
                $stmt->execute();
                $linha1 = $stmt->fetch();
                $QtdRecolhido = $linha1['QtdRecolhido'];

                $Dados .= " <li><a href='#'>".$TipoVeiculo."<span class='pull-right badge bg-black'>".$QtdRecolhido."</span></a></li>";

                //Recolhidos
                $stmt12 = $pdo->prepare('SELECT COUNT(s.GRV) AS QtdLiberado FROM grv_status s, grv_veiculo v WHERE s.GRV=v.GRV 
                                                                                           AND s.STATUS IN(:statusleilao, :statusliberado) AND  v.TIPOVEICULO =:tipoveiculo ');
                $stmt12->bindParam(':statusleilao', $StatusLeilao);
                $stmt12->bindParam(':statusliberado', $StatusRetirada);
                $stmt12->bindParam(':tipoveiculo', $TipoVeiculo);
                $stmt12->execute();
                $linha12 = $stmt12->fetch();
                $QtdLiberado = $linha12['QtdLiberado'];

                $Dados1 .= " <li><a href='#'>".$TipoVeiculo."<span class='pull-right badge bg-green'>".$QtdLiberado."</span></a></li>";

            }


        }else{
            session_destroy();
        }
           $Resultado['Liberado']= $Dados1;
           $Resultado['Recolhido']=$Dados;
        echo json_encode($Resultado);


        break ;


}

