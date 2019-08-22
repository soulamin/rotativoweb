<?php

/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 23/10/2016
 * Time: 11:42
 */
require '../fontes/conexao.php';
include 'InsereArquivo.php';
include 'FuncaoData.php';
session_start();
$acao = $_POST['acao'];
date_default_timezone_set('America/Sao_Paulo');
switch ($acao) {

    case 'Busca_PagamentoPendente_Tabela':

        $stmt = $pdo->prepare('SELECT T.EVASAO , T.STATUS,L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
        FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL AND T.EVASAO IN (1,2)  ORDER BY T.IDTICKET ASC');
        $executa = $stmt->execute();
        $Ticket = array();
        while ($linha = $stmt->fetch()) {
            $DataHoraEntSai = PdBrasil($linha['DATAENT']) . ' - ' . $linha['HORAENT'] . ' | ' . PdBrasil($linha['DATASAIDA']) . ' - ' . $linha['HORASAIDA'];
            if ($linha['EVASAO'] == 1) {
                $Status = '<span class="badge badge-warning">Pendente</span>';
                $botao = '<div class="btn-group">
                <button type="button" class="btn btn-success">Ação</button>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; transform: translate3d(67px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                  <a class="dropdown-item btnEvasao"     codigo="'.$linha['IDTICKET'].'"   href="#">Evasão</a>
                  <a class="dropdown-item btnPagar"      codigo="'.$linha['IDTICKET'].'"   href="#">Pagamento</a>
                  <a class="dropdown-item btnInfoTicket" codigo="'.$linha['IDTICKET'] .'"  href="#">Informações</a>
                </div>
              </div>';
                
                
            } else {
                $Status = '<span class="badge badge-danger">Evasão</span>';
                $botao = '<div class="btn-group">
                <button type="button" class="btn btn-success">Ação</button>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; transform: translate3d(67px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                  <a class="dropdown-item btnInfoTicket" codigo="'.$linha['IDTICKET'] .'"  href="#">Informações</a>
                </div>
              </div>';
            }

            $t = array('Placa' => $linha['PLACA'], 'DataHora' => $DataHoraEntSai, 'Status' => $Status,'Botao'=>$botao);
            array_push($Ticket, $t);
        }
    
    

   // $Resultado['Saldo'] = $Saldo;
    $Resultado['Html'] = $Ticket;
    echo json_encode($Resultado);


    break;

case 'Busca_Historico_Tabela':

        if ($_SESSION['NIVEL'] == 'G') {
            $DataHj = date('Y-m-d');
            $Guardador = $_SESSION['ID_USUARIO'];
            $stmt1 = $pdo->prepare('SELECT SUM(VALOR) AS VlValor FROM ticket WHERE ID_GUARDADOR = :guardador  AND 
            DATAENT = :dataent ');
            $stmt1->bindParam(':guardador', $Guardador);
            $stmt1->bindParam(':dataent', $DataHj);
            $stmt1->execute();
            $linha1 = $stmt1->fetch();
            $Saldo = 'Venda Diária R$ ' . number_format($linha1['VlValor'], 2, ",", "");


            $stmt = $pdo->prepare('SELECT T.STATUS,L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
            FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
            AND L.ID_FISCAL LIKE :idfiscal AND T.DATAENT=:dataent ORDER BY T.IDTICKET ASC');
            $stmt->bindParam(':idfiscal', $Guardador);
           $stmt->bindParam(':dataent', $DataHj);
            $executa = $stmt->execute();
            $Ticket = array();
            while ($linha = $stmt->fetch()) {
                $DataHoraEntSai = PdBrasil($linha['DATAENT']) . ' - ' . $linha['HORAENT'] . ' | ' . PdBrasil($linha['DATASAIDA']) . ' - ' . $linha['HORASAIDA'];
                if ($linha['STATUS'] == 'A') {
                    $Status = '<span class="badge badge-warning">Andamento</span>';
                } else {
                    $Status = '<span class="badge badge-success">Concluído</span>';
                }

                $botao = '  <button type="button" class="btn btn-warning btn-sm btnInfoTicket" codigo="' . $linha['IDTICKET'] . '">Info.</button>';
                $t = array('Placa' => $linha['PLACA'], 'DataHora' => $DataHoraEntSai, 'Status' => $botao);
                array_push($Ticket, $t);
            }
        } else {

            $Id_Usuario = $_SESSION['ID_USUARIO'];
            $stmtu = $pdo->prepare('SELECT P.PLACA,U.SALDO FROM placausuario P ,usuarios U WHERE  P.ID_USUARIO=U.IDUSUARIO AND
                     P.ID_USUARIO = :usuario AND P.STATUS = 1 ');
            $stmtu->bindParam(':usuario', $Id_Usuario);
            $stmtu->execute();
            $Ticket = array();
            while ($linhau = $stmtu->fetch()) {
             $Saldo = 'Saldo Atual R$ ' . number_format($linhau['SALDO'], 2, ",", "");
                $stmt = $pdo->prepare('SELECT T.STATUS,L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
                        FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
                        AND T.PLACA LIKE :placa ORDER BY T.IDTICKET ASC');
                $stmt->bindParam(':placa', $linhau['PLACA']);
                $executa = $stmt->execute();

                while ($linha = $stmt->fetch()) {
                    $DataHoraEntSai = PdBrasil($linha['DATAENT']) . ' - ' . $linha['HORAENT'] . ' | ' . PdBrasil($linha['DATASAIDA']) . ' - ' . $linha['HORASAIDA'];
                    if ($linha['STATUS'] == 'A') {
                        $Status = '<span class="badge badge-warning">Andamento</span>';
                    } else {
                        $Status = '<span class="badge badge-success">Concluído</span>';
                    }

                    $botao = '  <button type="button" class="btn btn-warning btn-sm btnInfoTicket" codigo="' . $linha['IDTICKET'] . '">Info.</button>';
                    $t = array('Placa' => $linha['PLACA'], 'DataHora' => $DataHoraEntSai, 'Status' => $botao);
                    array_push($Ticket, $t);
                }
            }
        }

        $Resultado['Venda'] = $Saldo;
        $Resultado['Html'] = $Ticket;
        echo json_encode($Resultado);

        break;

case 'DataHoraAtual':
        // date_default_timezone_set('America/Sao_Paulo');
        $DataHj = date('d/m/Y H:i:s');
        // $HoraHj =date('H:i:s');

        $resultado['DataHoraEnt'] = $DataHj;
        //$resultado['Hora'] = $HoraHj;
        echo json_encode($resultado);

        break;

case 'DataHoraTimeStamp':
        $resultado['TimeStamp'] =  $_SESSION['ID_USUARIO'] . time();
        echo json_encode($resultado);
        break;

case 'CalculaTempo':

        $DataHoraEnt = $_POST['DataHoraEnt'];
        $DataEnt     = PdBd(substr($DataHoraEnt, 0, 10));
        $HoraEnt     = substr($DataHoraEnt, -8);
        $Tempo       = $_POST['Tempo'];
        if($Tempo == 24){
        
            $DataSaida     = PdBrasil($DataEnt);
            $HoraSaida     = '19:00:00';
        }else{
            $Resultadocalc  = date('Y-m-d H:i:s', strtotime(".$DataEnt." . $HoraEnt . " +" . $Tempo . "hour"));
            $DataSaida     = PdBrasil(substr($Resultadocalc, 0, 10));
            $HoraSaida     = substr($Resultadocalc, -8);
        }
       
        $resultado['DataHoraSaida'] = $DataSaida . " " . $HoraSaida;
        //$resultado['HoraSaida'] = $Resultado;
        echo json_encode($resultado);

        break;

case 'Salva_Ticket':
        $IdUsuario       = $_SESSION['ID_USUARIO'];
        $LocalFiscal     = $_POST['Txt_LocalFiscal'];
        $Taxa            = $_POST['Txt_Taxa'];
        $Valor           = $_POST['Txt_Valor'];
        $Placa           = $_POST['Txt_Placa'];
        $FormaPg         = $_POST['Txt_FormaPg'];
        // $data_criacao     = $_POST['Txt_DataCriacao'];
        $DataHoraEnt     = $_POST['Txt_DataHoraEnt'];
        $DataHoraSaida   = $_POST['Txt_DataHoraSaida'];
        $CodTicket       = $_POST['Txt_DataCriacao'];
        $Status          =  'A';
        $IdFiscal = 0;
        $Evasao = $_POST['Txt_Evasao'];

        $DataHj = date('Y-m-d  H:i:s');
        $DataHjs = date('Y-m-d');
        $HoraHjs = date('H:i:s');



        if ((!empty($Taxa)) && (!empty($Placa)) && (!empty($DataHoraEnt)) && (!empty($DataHoraSaida) && ($LocalFiscal >= 1))) {

            $DataEnt     = PdBd(substr($DataHoraEnt, 0, 10));
            $HoraEnt     = substr($DataHoraEnt, -8);
            $DataSaida     = PdBd(substr($DataHoraSaida, 0, 10));
            $HoraSaida    = substr($DataHoraSaida, -8);

            $stmtpla = $pdo->prepare('SELECT T.IDTICKET FROM ticket T WHERE T.DATASAIDA = :datahj  AND  T.HORASAIDA > :horahj AND  T.PLACA =:placa');
            $stmtpla->bindParam(':placa', $Placa);
            $stmtpla->bindParam(':datahj', $DataHjs);
            $stmtpla->bindParam(':horahj', $HoraHjs);
            $stmtpla->execute();
            if ($Qtdli = $stmtpla->rowCount() == 0) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO ticket (ID_TAXA,PLACA,ID_FORMAPG,ID_GUARDADOR,ID_LOCALFISCAL,DATAENT,HORAENT,
                            DATASAIDA,HORASAIDA,VALOR,ID_LIBERAR,DH_LIBERA,STATUS,CODTICKET,EVASAO) VALUES (:idtaxa,:placa,:formapg,:idguardador,:localfiscal,:dataent,:horaent,:datasaida,:horasaida,
                            :valor,:idfiscal,:dhlibera,:status,:codticket,:idevasao)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':codticket', $CodTicket);
                $statement->bindParam(':idtaxa', $Taxa);
                $statement->bindParam(':placa', $Placa);
                $statement->bindParam(':formapg', $FormaPg);
                $statement->bindParam(':localfiscal', $LocalFiscal);
                $statement->bindParam(':idguardador', $IdUsuario);
                $statement->bindParam(':valor', $Valor);
                $statement->bindParam(':dataent', $DataEnt);
                $statement->bindParam(':horaent', $HoraEnt);
                $statement->bindParam(':datasaida', $DataSaida);
                $statement->bindParam(':horasaida', $HoraSaida);
                $statement->bindParam(':idfiscal', $IdFiscal);
                $statement->bindParam(':dhlibera', $DataHj);
                $statement->bindParam(':idevasao', $Evasao);
                $statement->bindParam(':status', $Status);

                // Executa a senten�a j� com os valores
                if ($statement->execute()) {

                    // Definimos a mensagem de sucesso
                    $stmte = $pdo->prepare('SELECT EMAIL, NOME ,CNPJ,CEP, LOGRADOURO,EMAIL ,NUM,BAIRRO,CIDADE,UF FROM empresa');
                    $stmte->execute();
                    $liempresa = $stmte->fetch();

                    $EndEmpresa = $liempresa['LOGRADOURO'] . '-' . $liempresa['NUM'] . '-' . $liempresa['BAIRRO'] .
                        '-' . $liempresa['CIDADE'] . '-' . $liempresa['UF'] . ' - ' . $liempresa['CEP'] . ' - Email: ' . $liempresa['EMAIL'];

                    $stmtelo = $pdo->prepare('SELECT f.NOME ,d.ENDERECO FROM localfiscal l ,usuarios f ,localidade d WHERE l.ID_FISCAL=f.IDUSUARIO
                                          AND l.ID_LOCALIDADE=d.IDLOCALIDADE AND l.IDLOCALFISCAL =:localfiscal ');
                    $stmtelo->bindParam(':localfiscal', $LocalFiscal);
                    $stmtelo->execute();
                    $localempresa = $stmtelo->fetch();
                    $Msg = array();
                    //evasao
                    if($Evasao==0){
                        $Notifica = 'N';
                    }else{
                        $Notifica = 'S';
                    }
                   

                    $m = array(
                        'Empresa' => $liempresa['NOME'], 'Endereco' => $EndEmpresa, 'Cnpj' => $liempresa['CNPJ'], 'DataHoraEnt' => $DataHoraEnt,
                        'DataHoraSaida' => $DataHoraSaida, 'Placa' => $Placa, 'Valor' => $Valor, 'NomeFiscal' => $localempresa['NOME'], 'EnderecoFiscal' => $localempresa['ENDERECO'], 
                        'idticket' => $CodTicket,'notifica' => $Notifica
                    );
                    array_push($Msg, $m);

                    if ($Evasao == 0) {
                        $Cod_Error = '0';
                    } else {
                        $Cod_Error = '10';
                    }
                    $stmSaldo = $pdo->prepare('UPDATE usuarios SET SALDO = SALDO - :valor WHERE IDUSUARIO = :idusuario');
                    $stmSaldo->bindParam(':idusuario', $IdUsuario);
                    $stmSaldo->bindParam(':valor', $Valor);
                    $stmSaldo->execute();
                } else {

                    $Cod_Error = '1';
                    $Msg = "<div class='alert alert-danger disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Falha ao Realizar Cadastro  </h4>
	                       </div>";
                }
            } else {
                $linhaticket = $stmtpla->fetch();
                $Cod_Error = '5';
                $Msg = $linhaticket['IDTICKET'];
            }
        } else {

            $Cod_Error = '3';
            $Msg = "<div class='alert alert-danger disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
	                       </div>";
        }


        $Resultado['Msg'] = $Msg;
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

case 'Busca_Ticket':
        $DataHj = date('Y-m-d');
        $HoraHj = date('H:i:s');
        $Fiscal = $_SESSION['ID_USUARIO'];
        $Status = 'A';
        $r = '';
        $QtdTicket = 0;
        if ($_SESSION['NIVEL'] != 'G') {
            $stp = $pdo->prepare('SELECT PLACA  FROM placausuario WHERE ID_USUARIO =:idfiscal AND STATUS = 1');
            $stp->bindParam(':idfiscal', $Fiscal);
            $stp->execute();
            while ($linhap = $stp->fetch()) {
                $Placa = $linhap['PLACA'];
                $stmt = $pdo->prepare('SELECT T.STATUS, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
                            FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL AND T.STATUS = :status 
                            AND T.PLACA = :placa  ORDER BY T.HORASAIDA ASC');
                $stmt->bindParam(':placa', $Placa);
                $stmt->bindParam(':status', $Status);
                $executa = $stmt->execute();
                if ($l = $stmt->rowCount() >= 1) {

                    while ($linha = $stmt->fetch()) {
                        if (($DataHj >= $linha['DATASAIDA']) && ($HoraHj >= $linha['HORASAIDA']) || ($DataHj > $linha['DATASAIDA'])) {
                            $StatusPedido = 'bg-danger';
                            $QtdTicket = $QtdTicket + 1;
                            $r .= '<div class="col-md-3 col-sm-12">
                                                                <div class="info-box mb-3 ' . $StatusPedido . '">
                                                                
                                                            <div class="info-box-content">
                                                                <span class="info-box-number text-sm">' . $linha['PLACA'] . '  |  Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                                                <button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnLiberarVaga btn btn-block btn-success btn-sm">Liberar Vaga</button>
                                                                </div>
                                                        <!-- /.info-box-content -->
                                                                    </div>
                                                        </div>';
                        }
                    }
                }
            }
        } else {

            $stmt = $pdo->prepare('SELECT T.STATUS, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
                    FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL AND T.STATUS = :status 
                    AND L.ID_FISCAL LIKE :idfiscal ');
            $stmt->bindParam(':idfiscal', $Fiscal);
            $stmt->bindParam(':status', $Status);
            $executa = $stmt->execute();

            if ($stmt->rowCount() >= 1) {

                while ($linha = $stmt->fetch()) {

                    if ((($DataHj >= $linha['DATASAIDA']) && ($HoraHj >= $linha['HORASAIDA'])) || ($DataHj > $linha['DATASAIDA'])) {
                        $StatusPedido = 'bg-danger';

                        $QtdTicket = $QtdTicket + 1;
                        $r .= '<div class="col-md-3 col-sm-12">
                                                        <div class="info-box mb-3 ' . $StatusPedido . '">
                                                        
                                                    <div class="info-box-content">
                                                        <span class="info-box-number text-sm">' . $linha['PLACA'] . '  |  Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                                                    
                                                    <button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnLiberarVaga btn btn-block btn-success btn-sm">Liberar Vaga</button>
                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>
                                                </div>';
                    }
                }
            } else {
                $r .= '<div class="col-md-12 text-center">
                <div class="alert alert-danger" role="alert">
                NÃO EXISTE TICKET PENDENTE 
              </div>
              </div>';
            }
        }
        $Resultado['Cod_Error'] = $QtdTicket;
        $Resultado['Html'] = $r;
        echo json_encode($Resultado);

        break;

case 'Busca_TicketNotificado':

        $DataHj = date('Y-m-d');
        $HoraHj = date('H:i:s');
        $Fiscal = $_SESSION['ID_USUARIO'];
        $Status = 'A';
        $Evasao = 1 ;
        $r = '';
        
         $stmt = $pdo->prepare('SELECT T.EVASAO,T.STATUS, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
                                         FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL   AND T.EVASAO = 1 
                                         AND L.ID_FISCAL LIKE :idfiscal ');
            $stmt->bindParam(':idfiscal', $Fiscal);
           // $stmt->bindParam(':status', $Status);
          
            $executa = $stmt->execute();

            if ($stmt->rowCount() >= 1) {

                while ($linha = $stmt->fetch()) {

                        $StatusPedido = 'bg-warning';

                        $r .= '<div class="col-md-3 col-sm-12">
                                       <div class="info-box mb-3 ' . $StatusPedido . '">
                                            <div class="info-box-content">
                                                   <span class="info-box-number text-sm">' . $linha['PLACA'] . '  |  Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>                 
                                                    <button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnEvasao btn btn-block btn-secundary  btn-sm">Evasão</button>
                                                    <button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnPagar btn btn-block btn-success btn-sm">Pagamento</button>
                                                    </div>
                                         <!-- /.info-box-content -->
                                 </div>
                               </div>';
                    }
                
            } else {
                $r .= ' <div class="col-md-12 text-center">
                <div class="alert alert-warning" role="alert">
                NÃO EXISTE TICKET PENDENTE PAGAMENTO
              </div>
              </div>';
            }
        
        
        $Resultado['Html'] = $r;
        echo json_encode($Resultado);

        break;

case 'Busca_TicketPlaca':

        $Tipo = $_POST['Tipo'];
        $Dados = $_POST['Dados'];
        $DataHj = date('Y-m-d');
        $HoraHj = date('H:i:s');
        // $Status ='A';

        if ($Tipo == 'Placa') {
            $stmt = $pdo->prepare('SELECT T.STATUS, T.EVASAO, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
         ,T.CODTICKET FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL  AND T.PLACA LIKE :dados ORDER BY T.IDTICKET DESC  ');
        } else {
            $stmt = $pdo->prepare('SELECT T.STATUS,T.EVASAO, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET,T.CODTICKET
             ,T.CODTICKET  FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL  AND T.CODTICKET LIKE :dados  ');
        }

        $stmt->bindParam(':dados', $Dados);
        $executa = $stmt->execute();
        $r = '';
        if ($l = $stmt->rowCount() >= 1) {

            while ($linha = $stmt->fetch()) {

                if (($linha['STATUS'] == 'L') && ($linha['EVASAO'] == '0')) {

                    if (($DataHj == $linha['DATASAIDA'] && $HoraHj < $linha['HORASAIDA']) || ($DataHj > $linha['DATASAIDA'])  ) {
                        if ($_SESSION['NIVEL'] == 'G') {
                            $botoes =  '<button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnAlterarLocal btn btn-block btn-secondary btn-sm">
                                         Alterar Local</button>';
                        } else {
                            $botoes = '';
                        }
                        $r .= '<div class="col-md-3 col-sm-12">
                                <div class="info-box mb-3 bg-success">
                                        <div class="info-box-content">
                                        <span class="info-box-number ">Ticket :' . $linha['CODTICKET'] . '</span>
                                        <span class="info-box-number text-sm">' . $linha['PLACA'] . '   |   Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                        ' . $botoes . '
                                                </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>';
                    } else {

                        $r .= '';
                    }
                } else {
                    if ($_SESSION['NIVEL'] == 'G') {
                        $botoes =  '<button type="button" codigo="' . $linha['IDTICKET'] . '"   class="btnLiberarVaga btn btn-block btn-success btn-sm">Liberar Vaga</button>
                                        <button type="button"  codigo="' . $linha['IDTICKET'] . '"  class="btnReimprimir btn btn-block btn-info btn-sm">Reimprimir</button>';
                    } else {
                        $botoes = '';
                    }

                    if (($DataHj >= $linha['DATASAIDA'])  && ($HoraHj >= $linha['HORASAIDA'])) {

                        $r .= '<div class="col-md-4 col-sm-12">
                                            <div class="info-box mb-3 bg-danger">
                                                    <div class="info-box-content">
                                                    <span class="info-box-number ">' . $linha['CODTICKET'] . '</span>
                                        <span class="info-box-number text-sm">Ticket :' . $linha['PLACA'] . '   |   Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                        ' . $botoes . '
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                </div>';
                    } else {
                        $r .= '<div class="col-md-4 col-sm-12">
                                <div class="info-box mb-3 bg-warning">
                                        <div class="info-box-content">
                                        <span class="info-box-number ">Ticket :' . $linha['CODTICKET'] . '</span>
                                        <span class="info-box-number text-sm">' . $linha['PLACA'] . '   |   Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                        ' . $botoes . '
                                                </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>';
                    }
                }
            }
        } else {
            $r .= '<br>
            <div class="col-md-12 text-center">
            <div class="alert alert-danger" role="alert">
            VEÍCULO NÃO ENCONTRADO!
          </div>
          </div>';
        }
        $Resultado['Html'] = $r;
        echo json_encode($Resultado);

        break;

case 'Busca_InfoTicket':

        $Id_Ticket = $_POST['Cod_Id'];
        $stmt = $pdo->prepare('SELECT X.ID_TRANSP ,U.NOME ,L.STATUS,D.ENDERECO, L.IDLOCALFISCAL,T.VALOR ,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET,T.CODTICKET
                               FROM localfiscal L ,ticket T,usuarios U ,localidade D ,taxas X WHERE D.IDLOCALIDADE=L.ID_LOCALIDADE AND U.IDUSUARIO=L.ID_FISCAL AND T.ID_LOCALFISCAL=L.IDLOCALFISCAL
                               AND X.IDTAXA=T.ID_TAXA AND T.IDTICKET =:idticket  ');
        $stmt->bindParam(':idticket', $Id_Ticket);
        //  $stmt->bindParam(':status', $Status);
        $executa = $stmt->execute();


        while ($linha = $stmt->fetch()) {

            $DataHoraEnt    = PdBrasil($linha['DATAENT']) . ' ' . $linha['HORAENT'];
            $DataHoraSaida  = PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'];
            $Dados = array(
                'Placa' => $linha['PLACA'], 'Ticket' => $linha['CODTICKET'], 'Placa' => $linha['PLACA'], 'DataHoraEnt' => $DataHoraEnt, 'IDLOCALFISCAL' => $linha['IDLOCALFISCAL'],
                'DataHoraSaida' => $DataHoraSaida, 'Valor' => $linha['VALOR'], 'Status' => $linha['STATUS'], 'Localidade' => $linha['ENDERECO'], 'Fiscal' => $linha['NOME']
            );
        }

        $Resultado['Html'] = $Dados;
        echo json_encode($Resultado);

        break;

case 'Renova_Ticket':

        $Id_Ticket = $_POST['Cod_Id'];
        $stmt = $pdo->prepare('SELECT X.ID_TRANSP ,U.NOME ,L.STATUS,D.ENDERECO, L.IDLOCALFISCAL,T.VALOR ,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET,T.CODTICKET
                               FROM localfiscal L ,ticket T,usuarios U ,localidade D ,taxas X WHERE D.IDLOCALIDADE=L.ID_LOCALIDADE AND U.IDUSUARIO=L.ID_FISCAL AND T.ID_LOCALFISCAL=L.IDLOCALFISCAL
                               AND X.IDTAXA=T.ID_TAXA AND T.IDTICKET =:idticket  ');
        $stmt->bindParam(':idticket', $Id_Ticket);
        //  $stmt->bindParam(':status', $Status);
        $executa = $stmt->execute();


        while ($linha = $stmt->fetch()) {

            $DataHoraEnt    = PdBrasil($linha['DATAENT']) . ' ' . $linha['HORAENT'];
            $DataHoraSaida  = PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'];
            $Dados = array(
                'Placa' => $linha['PLACA'], 'Ticket' => $linha['CODTICKET'], 'Placa' => $linha['PLACA'], 'DataHoraEnt' => $DataHoraEnt, 'IDLOCALFISCAL' => $linha['IDLOCALFISCAL'],
                'DataHoraSaida' => $DataHoraSaida, 'IdTrans' => $linha['ID_TRANSP'], 'Status' => $linha['STATUS'], 'Localidade' => $linha['ENDERECO'], 'Fiscal' => $linha['NOME']
            );
        }

        $Resultado['Html'] = $Dados;
        echo json_encode($Resultado);

        break;


        $DataHj = date('Y-m-d');
        $HoraHj = date('H:i:s');
        $Fiscal = $_SESSION['ID_USUARIO'];
        $Status = 'A';
        // caso seja o usuario
        if ($_SESSION['NIVEL'] == 'U') {

            $stp = $pdo->prepare('SELECT PLACA  FROM placausuario WHERE ID_USUARIO =:idfiscal AND STATUS =1');
            $stp->bindParam(':idfiscal', $Fiscal);
            $stp->execute();
            while ($linhap = $stp->fetch()) {
                echo $linhap['PLACA'];
                $stmt = $pdo->prepare('SELECT COUNT(T.IDTICKET) AS QtdVencido FROM ticket T , localfiscal L WHERE  T.STATUS = :status AND
                            T.ID_LOCALFISCAL=L.IDLOCALFISCAL AND T.PLACA=:placa AND  T.DATASAIDA <=:datahj AND T.HORASAIDA <=:horahj ');
                $stmt->bindParam(':placa', $linhap['PLACA']);
                $stmt->execute();
                $linha = $stmt->fetch();
                $Cod_Error = $linha['QtdVencido'];
            }
        } else {
            $stmt = $pdo->prepare('SELECT COUNT(T.IDTICKET) AS QtdVencido FROM ticket T , localfiscal L WHERE  T.STATUS = :status AND
            T.ID_LOCALFISCAL=L.IDLOCALFISCAL AND L.ID_FISCAL =:idfiscal AND  T.DATASAIDA <=:datahj AND T.HORASAIDA <=:horahj ');
            $stmt->bindParam(':idfiscal', $Fiscal);
            $stmt->bindParam(':status', $Status);
            $stmt->bindParam(':datahj', $DataHj);
            $stmt->bindParam(':horahj', $HoraHj);
            $stmt->execute();
            $linha = $stmt->fetch();
            $Cod_Error = $linha['QtdVencido'];
        }

        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;


case 'Reimprimir_Ticket':

        $Cod_Ticket      = $_POST['Cod_Ticket'];

        // Definimos a mensagem de sucesso
        $stmte = $pdo->prepare('SELECT EMAIL, NOME ,CNPJ,CEP, LOGRADOURO,EMAIL ,NUM,BAIRRO,CIDADE,UF FROM empresa');
        $stmte->execute();
        $liempresa = $stmte->fetch();

        $Msg = array();

        $EndEmpresa = $liempresa['LOGRADOURO'] . '-' . $liempresa['NUM'] . '-' . $liempresa['BAIRRO'] .
            '-' . $liempresa['CIDADE'] . '-' . $liempresa['UF'] . ' - ' . $liempresa['CEP'] . ' - Email: ' . $liempresa['EMAIL'];

        $stmtelo = $pdo->prepare('SELECT f.NOME ,d.ENDERECO , t.* FROM localfiscal l ,usuarios f ,localidade d ,ticket t WHERE l.ID_FISCAL=f.IDUSUARIO
                                          AND l.ID_LOCALIDADE=d.IDLOCALIDADE AND t.ID_LOCALFISCAL=l.IDLOCALFISCAL AND t.IDTICKET =:codticket ');
        $stmtelo->bindParam(':codticket', $Cod_Ticket);
        $stmtelo->execute();
        $localempresa = $stmtelo->fetch();

         if($localempresa['EVASAO']==0){
                $Notifica ='N';
         }else{
                $Notifica ='S';
         }

        $m = array(
            'Empresa' => $liempresa['NOME'], 'Endereco' => $EndEmpresa, 'Cnpj' => $liempresa['CNPJ'],
            'DataHoraEnt' => PdBrasil($localempresa['DATAENT']) . ' ' . $localempresa['HORAENT'],
            'DataHoraSaida' => PdBrasil($localempresa['DATASAIDA']) . ' ' . $localempresa['HORASAIDA'],
            'Placa' => $localempresa['PLACA'], 'Valor' => $localempresa['VALOR'], 'NomeFiscal' => $localempresa['NOME'],
            'EnderecoFiscal' => $localempresa['ENDERECO'], 'idticket' => $localempresa['CODTICKET'],'notifica'=>$Notifica
        );
        array_push($Msg, $m);

        $Cod_Error = 0;

        $Resultado['Msg'] = $Msg;
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;


        //Liberar Vaga
case 'Libera_Vaga':
        $DtaHora = date('Y-m-d  H:i:s');
        $IdFiscal = $_SESSION['ID_USUARIO'];
        $Ticket   = $_POST['Ticket'];
        $Status = 'L';
        $stmt = $pdo->prepare('UPDATE ticket SET DH_LIBERA = :dthrhj ,STATUS = :status,ID_LIBERAR =:idfiscal WHERE IDTICKET=:idticket');
        $stmt->bindParam(':status', $Status);
        $stmt->bindParam(':idticket', $Ticket);
        $stmt->bindParam(':dthrhj', $DtaHora);
        $stmt->bindParam(':idfiscal', $IdFiscal);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

        //verifica saldo
case 'VerificaSaldo':

        $IdUsuario = $_SESSION['ID_USUARIO'];
        $Valor   = $_POST['Valor'];

        $stmt = $pdo->prepare('SELECT SALDO FROM usuarios where IDUSUARIO =:idusuario');
        $stmt->bindParam(':idusuario', $IdUsuario);
        $stmt->execute();
        $Linha = $stmt->fetch();
        // $Total = $Linha['SALDO'] - $Valor;
        if ($Linha['SALDO'] >= $Valor) {
            $Cod_Error = 0;
        } else {
            $Cod_Error = 1;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

 case 'Saldo':

            $IdUsuario = $_SESSION['ID_USUARIO'];
               
            $stmt = $pdo->prepare('SELECT SALDO FROM usuarios where IDUSUARIO =:idusuario');
            $stmt->bindParam(':idusuario', $IdUsuario);
            $stmt->execute();
            $Linha = $stmt->fetch();
            $Saldo = 'Saldo Atual R$ ' . number_format($Linha['SALDO'], 2, ",", "");
            $Resultado['Saldo'] = $Saldo;
            echo json_encode($Resultado);
    
            break;
case 'Altera_Localidade':
        $IdLocalFiscal = $_POST['IdLocalFiscal'];
        $Ticket   = $_POST['Txt_IdTicket'];
        $Status = 'A';
        $stmt = $pdo->prepare('UPDATE ticket SET ID_LOCALFISCAL = :idlocalfiscal ,STATUS = :status WHERE IDTICKET=:idticket');
        $stmt->bindParam(':status', $Status);
        $stmt->bindParam(':idticket', $Ticket);
        $stmt->bindParam(':idlocalfiscal', $IdLocalFiscal);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;


case 'PainelFiscal':

        $Ticket   = $_POST['Ticket'];
        $Status = 'L';
        $stmt = $pdo->prepare('UPDATE ticket SET STATUS = :status WHERE IDTICKET=:idticket');
        $stmt->bindParam(':status', $Status);
        $stmt->bindParam(':idticket', $Ticket);
        if ($stmt->execute()) {

            $stValor = $pdo->prepare('SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
            AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.DATAENT BETWEEN :datainicio AND :datafim');
            $stValor->bindParam(':idfiscal', $Fiscal);
            $stValor->bindParam(':datainicio', $DataInicio);
            $stValor->bindParam(':datafim', $DataFinal);
            $stValor->execute();
            $LinhaValor = $stValor->fetch();

            $stD = $pdo->prepare('SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
            AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.ID_FORMAPG=:formapg AND T.DATAENT BETWEEN :datainicio AND :datafim');
            $stD->bindParam(':idfiscal', $Fiscal);
            $stD->bindParam(':formapg', $FormaPgDinheiro);
            $stD->bindParam(':datainicio', $DataInicio);
            $stD->bindParam(':datafim', $DataFinal);
            $stD->execute();
            $LinhaD = $stD->fetch();

            $stC = $pdo->prepare('SELECT SUM(VALOR) AS VALORTOTAL  FROM localfiscal L ,ticket T ,usuarios U ,localidade D WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL 
            AND L.ID_FISCAL=U.IDUSUARIO  AND D.IDLOCALIDADE=L.ID_LOCALIDADE AND L.ID_FISCAL LIKE :idfiscal AND T.ID_FORMAPG=:formapg AND T.DATAENT BETWEEN :datainicio AND :datafim');
            $stC->bindParam(':idfiscal', $Fiscal);
            $stC->bindParam(':formapg', $FormaPgCartao);
            $stC->bindParam(':datainicio', $DataInicio);
            $stC->bindParam(':datafim', $DataFinal);
            $stC->execute();
            $LinhaC = $stC->fetch();

            $Cod_Error = 0;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

case 'Evasao':
     
        $Ticket   = $_POST['Cod_Ticket'];
        $Evasao = '2';
        $stmt = $pdo->prepare('UPDATE ticket SET EVASAO = :evasao WHERE IDTICKET=:idticket');
        $stmt->bindParam(':evasao', $Evasao);
        $stmt->bindParam(':idticket', $Ticket);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;
        
case 'Pagamento':
     
        $Ticket   = $_POST['Cod_Ticket'];
        $Evasao = '0';
        $stmt = $pdo->prepare('UPDATE ticket SET EVASAO = :evasao WHERE IDTICKET=:idticket');
        $stmt->bindParam(':evasao', $Evasao);
        $stmt->bindParam(':idticket', $Ticket);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;
case 'Busca_TicketPlacaFiscal':

        $Tipo = $_POST['Tipo'];
        $Dados = $_POST['Dados'];
        $DataHj = date('Y-m-d');
        $HoraHj = date('H:i:s');
        $Status ='A';

        if ($Tipo == 'Placa') {
            $stmt = $pdo->prepare('SELECT T.STATUS, T.EVASAO, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET
         ,T.CODTICKET FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL  AND T.STATUS =:status AND  T.PLACA LIKE :dados ORDER BY T.IDTICKET DESC  ');
        } else {
            $stmt = $pdo->prepare('SELECT T.STATUS,T.EVASAO, L.IDLOCALFISCAL,T.PLACA,T.DATAENT,T.HORAENT,T.DATASAIDA,T.HORASAIDA,T.IDTICKET,T.CODTICKET
             ,T.CODTICKET  FROM localfiscal L ,ticket T WHERE T.ID_LOCALFISCAL=L.IDLOCALFISCAL  AND T.STATUS =:status AND T.CODTICKET LIKE :dados  ');
        }

        $stmt->bindParam(':dados', $Dados);
        $stmt->bindParam(':status', $Status);
        $executa = $stmt->execute();
        $r = '';
        if ($l = $stmt->rowCount() >= 1) {

            while ($linha = $stmt->fetch()) {

                    if ($DataHj == $linha['DATASAIDA'] && $HoraHj < $linha['HORASAIDA']) {

                        $r .= '<div class="col-md-3 col-sm-12">
                                <div class="info-box mb-3 bg-success">
                                        <div class="info-box-content">
                                        <span class="info-box-number ">Ticket :' . $linha['CODTICKET'] . '</span>
                                        <span class="info-box-number text-sm">' . $linha['PLACA'] . '   |   Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                                     
                                                </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>';
                    } else {
                        $r .= '<div class="col-md-3 col-sm-12">
                        <div class="info-box mb-3 bg-danger">
                                <div class="info-box-content">
                                <span class="info-box-number ">Ticket :' . $linha['CODTICKET'] . '</span>
                                <span class="info-box-number text-sm">' . $linha['PLACA'] . '   |   Saída: ' . PdBrasil($linha['DATASAIDA']) . ' ' . $linha['HORASAIDA'] . '</span>
                             
                                        </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>';
                     
                    } 
            }
        } else {
            $r .= '<br>
            <div class="col-md-12 text-center">
            <div class="alert alert-danger" role="alert">
            VEÍCULO NÃO ENCONTRADO!
          </div>
          </div>';
        }
    
        $Resultado['Html'] = $r;
        echo json_encode($Resultado);

        break;        


    }
