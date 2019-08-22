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


switch($acao) {

    case 'Busca_Atendimento' :

        $Tipo = $_POST['Tipo'];
        $Dados = $_POST['Dados'];
        $IdPatio = $_POST['IdPatio'];
        $Status = "G";


        $stpa= $pdo->prepare('SELECT REGRAHORA FROM patios WHERE ID =:idpatio');
        $stpa->bindParam(':idpatio', $IdPatio);
        $stpa->execute();
        $linhapatio=$stpa->fetch();
        //verifica se é por Horario ou dia
        if($linhapatio['REGRAHORA']=='S'){
            $stmt = $pdo->prepare('SELECT * ,TIMESTAMPDIFF(HOUR ,CONCAT(s.DATAREMOCAO," ",s.HORAREMOCAO),now())/24 AS DIAS FROM grv_status s INNER JOIN grv_veiculo v ON v.GRV=s.GRV AND s.ID_PATIO=v.ID_PATIO
                                              INNER JOIN grv_condutor c ON c.GRV=s.GRV AND s.ID_PATIO=c.ID_PATIO     
                                              WHERE v.' . $Tipo . ' =:dados  AND s.ID_PATIO =:idpatio AND s.STATUS =:status ');
        }
        else{
            $stmt = $pdo->prepare('SELECT * , 	DATEDIFF(CURDATE(),s.DATAREMOCAO)  AS  DIAS FROM grv_status s INNER JOIN grv_veiculo v ON v.GRV=s.GRV AND s.ID_PATIO=v.ID_PATIO
                                              INNER JOIN grv_condutor c ON c.GRV=s.GRV AND s.ID_PATIO=c.ID_PATIO     
                                              WHERE v.' . $Tipo . ' =:dados  AND s.ID_PATIO =:idpatio AND s.STATUS =:status ');
        }
        $stmt->bindParam(':idpatio', $IdPatio);
        $stmt->bindParam(':status', $Status);
        $stmt->bindParam(':dados', $Dados);
        $stmt->execute();

        if ($Linha = $stmt->fetch()) {

            $st = $pdo->prepare('SELECT * FROM taxas WHERE TIPOVEICULO like :tipoveiculo AND ID_PATIO LIKE :idpatio');
            $st->bindParam(':tipoveiculo', $Linha['TIPOVEICULO']);
            $st->bindParam(':idpatio', $IdPatio);
            $st->execute();
            $linhaservico = $st->fetch();

            $Dias = floor($Linha['DIAS']);
            if ($Dias <= 0) {
                $Dias = 1;
            } else {
                $Dias = $Dias + 1;
            }

            if ($Dias >= 30) {

                $Aviso = "<div class='alert alert-danger disable alert-dismissable'>
                                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                           <h4><i class='icon fa  fa-exclamation-triangle'></i> VEÍCULO EM PRÉ LEILÃO! (Informar a atendente, caso o Pagamento seja efetuado)</h4>
	                              </div>";
            } else {
                $Aviso = "";
            }

            $ValorDiaria = $linhaservico['VALOR'];
            $SubTotalDiaria = $ValorDiaria * $Dias;
            $DescReboque = $linhaservico['DESC_REBOQUE'];


            $HablDesc = '<br>
                                    <button class="btn btn-warning form-control" id="BtnDesconto">Desconto</button>';


            $Servicos = ' <div class="col-md-12">' . $Aviso . '</div>
                                    <div class="col-md-6">
                                        <label>DESCRIÇÃO</label>
                                        <input class="form-control" id="DescDiaria" value="' . $linhaservico['DESCRICAO'] . '" disabled>
                                    </div>
                                    <div class="col-md-2">
                                    <label>VALOR </label>
                                    <div class="col-md-12 input-group">
                                         <span class="input-group-addon ">R$</span>
                                         <input class="form-control" id="ValorDiaria"  value="' . number_format($ValorDiaria, 2, ",", "") . '" disabled>
                                         </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label>QUANTIDADE</label>
                                     <input class="form-control" id="QtdDiaria" value="' . $Dias . '" disabled>
                                    </div>
                                    <div class="col-md-2 ">
                                        <label>SUBTOTAL</label>
                                        <div class="col-md-12 input-group">
                                             <span class="input-group-addon ">R$</span>
                                             <input class="form-control"   value="' . number_format($SubTotalDiaria, 2, ",", "") . '" disabled>
                                        </div>
                                     </div>';

            $ValorReboque = 0;


            //Se fez Uso de Reboque
            if ($Linha['USOREBOQUE'] == 'N') {
                $ValorReboque = $linhaservico['VALOR_REBOQUE'];
                $Servicos .= '
                                          <div class="col-md-6">
                                             <input class="form-control" id="DescReboque" value="' . $linhaservico['DESC_REBOQUE'] . '" disabled>
                                           </div>
                                           <div class="col-md-2">
                                           <div class="col-md-12 input-group">
                                             <span class="input-group-addon">R$</span>
                                             <input class="form-control"  id="ValorReboque"  value="' . number_format($ValorReboque, 2, ",", "") . '" disabled>
                                          </div>
                                           </div>
                                           <div class="col-md-2">
                                             <input class="form-control" id="QtdReboque" value="1" disabled>
                                           </div>
                                           <div class="col-md-2">
                                          <div class="col-md-12 input-group">
                                             <span class="input-group-addon ">R$</span>
                                             <input class="form-control"   value="' . number_format($ValorReboque, 2, ",", "") . '" disabled>
                                          </div>
                                           </div>';

            } else {

                $Servicos .= '     <div class="col-md-6">
                                                <input class="form-control" id="DescReboque" value="' . $linhaservico['DESC_REBOQUE'] . '" disabled>
                                            </div>
                                            
                                             <div class="col-md-2">
                                               <div class="col-md-12 input-group">
                                                 <span class="input-group-addon">R$</span>
                                                 <input class="form-control"   value="0,00" disabled>
                                              </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input class="form-control" id="QtdReboque" value="0" disabled>
                                            </div>
                                            
                                            <div class="col-md-2">
                                             <div class="col-md-12 input-group">
                                                <span class="input-group-addon">R$</span>
                                                <input class="form-control"   value="0,00" disabled>
                                              </div> 
                                           </div>';
            }
            //SE o PATIO POSSUI KMREBOCADO ate o Patio
            if ($linhaservico['KMREBOCADO'] == 'S') {

                $TotalVlKm = $Linha['KMREB'] * $linhaservico['VALORKM'];
                $Servicos .= '<div class="col-md-6">
                                          <input class="form-control" id="TaxasKmReb" value="KM PERCORRIDO PELO REBOQUE" disabled>
                                      </div>
                                       <div class="col-md-2">
                                            <div class="col-md-12 input-group">
                                                <span class="input-group-addon">R$</span>
                                                <input class="form-control" id="ValorKm"  value="' . number_format($linhaservico['VALORKM'], 2, ",", "") . '" disabled>
                                            </div> 
                                       </div>
                                        <div class="col-md-2">
                                          <input class="form-control" id="KmPerc" value="' . $Linha['KMREB'] . '"  disabled>
                                      </div>
                                       <div class="col-md-2">
                                            <div class="col-md-12 input-group">
                                                <span class="input-group-addon">R$</span>
                                                <input class="form-control" id="TotalValorKm"  value="' . number_format($TotalVlKm, 2, ",", "") . '" disabled>
                                            </div> 
                                       </div>';

                $ValorTotal = ($ValorDiaria * $Dias) + $TotalVlKm + $ValorReboque;

            } else {
                $ValorTotal = ($ValorDiaria * $Dias) + $ValorReboque;
            }

            $Servicos .= '<div class="col-md-6 DescDesconto"  hidden="true">
                                       <label>Observação Desconto</label>
                                  <input type="text"  class="form-control" id="ObsDesconto"  disabled ></input>
                                       </div>
                                       <div class="col-md-4 DescDesconto" hidden="true">
                                         <label>Tipo Desconto</label>
                                         <select class="form-control"  id="TipoDesconto" disabled>
                                         <option value="N">Nenhum</option>
                                         <option value="E">Liberação Especial</option>
                                         <option value="S">Solicitado</option>
                                          </select>
                                       </div> 
                                       <div class="col-md-2 DescDesconto" hidden="true">
                                         <label>Desconto</label>
                                          <div class="col-md-12 input-group">
                                                <span class="input-group-addon">R$</span>
                                             <input class="form-control"  id="ValorDesconto" disabled>
                                          </div>
                                       </div> 
                                      <div class="col-md-12"><hr></div>
                                       <div class="col-md-offset-10  col-md-2 text-center">
                                            <label>VALOR TOTAL</label>
                                            <div class="col-md-12 input-group ">
                                                 <span class="input-group-addon bg-teal">R$</span>
                                                 <input class="form-control input-lg bg-teal" id="ValorTotal"  value="' . number_format($ValorTotal, 2, ",", "") . '" readonly>
                                            </div>
                                       </div> 
                                      
                                      <div class="col-md-offset-8 col-md-2 ValDuplo" hidden>
                                               <label id="NomeV1"></label>
                                                    <div class="col-md-12 input-group">
                                                    <span class="input-group-addon ">R$</span>
                                                    <input class="form-control input-lg Real" type="text" id="Vl1"  value="' . number_format($ValorTotal / 2, 2, ",", "") . '" >
                                               </div>
                                      </div>
                                      
                                        <div class="col-md-2 ValDuplo" hidden>
                                            <label id="NomeV2"></label>
                                            <div class="col-md-12 input-group">
                                                    <span class="input-group-addon ">R$</span>
                                             <input class="form-control input-lg Real"  type="text" id="Vl2"  value="' . number_format($ValorTotal / 2, 2, ",", "") . '" >
                                            </div> 
                                       </div> 
                                       
                                       
                                        <div class=" col-md-2">
                                          ' . $HablDesc . '
                                         </div>
                                      <div class=" col-md-offset-6 col-md-2">
                                      <label>Forma de Pagamento</label>
                                       <select class="form-control text-uppercase" id="FormaPag" >
                                          
                                       </select>
                                      </div>
                                      <div class="col-md-2 ">
                                       <br>
                                      <button class="btn bg-green btn-block btn-app btn-lg" id="BtnEfetuarPg" type="submit"><i class="fa fa-money"> </i> EFETUAR PAGAMENTO</button>
                                      </div>';


            $Grv = array('Grv' => $Linha['GRV'], 'DataEnt' => PdBrasil($Linha['DATAENT']), 'HoraEnt' => $Linha['HORAENT'],
                'DataRemocao' => PdBrasil($Linha['DATAREMOCAO']), 'HoraRemocao' => $Linha['HORAREMOCAO'], 'Placa' => $Linha['PLACA'], 'SemPlaca' => $Linha['SEMPLACA'],
                'Chassi' => $Linha['CHASSI'], 'Renavam' => $Linha['RENAVAM'], 'TipoVeiculo' => $Linha['TIPOVEICULO'], 'UsoReboque' => $Linha['USOREBOQUE'],
                'Cor' => $Linha['COR'], 'MarcaModelo' => $Linha['MARCAMODELO'], 'Reboquista' => $Linha['ID_REBOQUISTA'], 'Reboque' => $Linha['ID_REBOQUE'], 'Dias' => $Dias,
                'DescReboque' => $linhaservico['DESC_REBOQUE'], 'ValorReboque' => $ValorReboque, 'ValorDiaria' => $ValorDiaria, 'Servico' => $Servicos);

            $_SESSION['GRV'] = $Linha['GRV'];
            $_SESSION['PATIO'] = $IdPatio;

            $Cod_error = 0;
        } else {
            $Cod_error = 1;
            $Grv = '';

        }
        $Resultado['Dados'] = $Grv;
        $Resultado['Cod_Error'] = $Cod_error;
        echo json_encode($Resultado);

        break;

    case 'Formulario_Desconto' :

        $Dados = ' 
 
  <div class="col-md-2">
                   <label>Qtd Diária</label> 
                    <input class="form-control QtdDiaria" min="1" type="number"  >
                    </div>
                   
                                      
                     <div class="col-md-2">
                       <label>Valor Diária</label> 
                       <div class="col-md-12 input-group">
                         <span class="input-group-addon">R$</span>
                         <input class="form-control ValorDiaria"  disabled >
                       </div>
                    </div>
                    
                     <div class="col-md-2">
                     <label>Qtd Remoção</label> 
                    <input class="form-control QtdRemocao"  disabled >
                    </div>
                    
                     <div class="col-md-2">
                            <label>Valor Remoção</label> 
                             <div class="col-md-12 input-group">
                             <span class="input-group-addon">R$</span>
                             <input class="form-control ValorRemocao"  disabled >
                          </div>
                     </div>
                    
                                       
                    <div class="col-md-2">
                        <label>Desconto</label> 
                         <div class="col-md-12 input-group">
                            <span class="input-group-addon">R$</span>
                            <input class="form-control Dinheiro ValorDesconto " value="0,00"   >
                        </div> 
                    </div>
                    
                                     
                    <div class="col-md-2">
                    <label>Valor Total</label> 
                     <div class="col-md-12 input-group">
                     <span class="input-group-addon">R$</span>
                    <input class="form-control Dinheiro ValorTotal"  disabled>
                    </div>
                    </div>
                    
                    <div class="col-md-3">
                    <label>Tipo de Desconto</label> 
                     <select class="form-control TipoDesconto">
                         <option value="S" >Solicitado</option>
                         <option value="E" >Liberação Especial</option>
                     </select>
                    </div>
                    
                    <div class="col-md-12">
                    <label>Observação Desconto (obrigatório)</label> 
                    <textarea  class="form-control ObsDesconto" rows="1"></textarea>
                    </div>';


        $Resultado['Html'] = $Dados;
        echo json_encode($Resultado);

        break;

    case 'Calcula_Desconto' :

        $QtdDiaria = $_POST['QtdDiaria'];
        $ValorDiaria = str_replace(",", ".", str_replace(".", "", $_POST['Valor_Diaria']));
        $ValorRemocao = str_replace(",", ".", str_replace(".", "", $_POST['Valor_Remocao']));
        $ValorDesconto = str_replace(",", ".", str_replace(".", "", $_POST['Valor_Desconto']));


        if (isset($_POST['TotalValorKm'])) {
            $ValorTotalKm = str_replace(",", ".", str_replace(".", "", $_POST['TotalValorKm']));
            $ValorTotal = (($QtdDiaria * $ValorDiaria) + $ValorRemocao + $ValorTotalKm) - $ValorDesconto;
        } else {
            $ValorTotal = (($QtdDiaria * $ValorDiaria) + $ValorRemocao) - $ValorDesconto;
        }


        $Resultado['Html'] = number_format($ValorTotal, 2, ",", "");

        echo json_encode($Resultado);

        break;

    case 'Salva_Atendimento' :

        $Grv = $_POST['Grv'];
        $IdPatio = $_POST['Patio'];
        $Nome = strtoupper($_POST['Nome']);
        $TipoResp = $_POST['TipoResp'];
        $Nome = strtoupper($_POST['Nome']);
        $Cpf = $_POST['Cpf'];
        $Cnh = $_POST['Cnh'];
        $Cep = $_POST['Cep'];
        $Endereco = $_POST['Endereco'];
        $Numero = $_POST['Numero'];
        $Compl = $_POST['Compl'];
        $Cidade = $_POST['Cidade'];
        $Bairro = $_POST['Bairro'];
        $Uf = $_POST['Uf'];
        $Telefone = $_POST['Telefone'];
        $PNome = strtoupper($_POST['PNome']);
        $PTipo = $_POST['PTipo'];
        $Doc = $_POST['Doc'];
        $PCep = $_POST['PCep'];
        $PEndereco = $_POST['PEndereco'];
        $PNumero = $_POST['PNumero'];
        $PCompl = $_POST['PCompl'];
        $PCidade = $_POST['PCidade'];
        $PBairro = $_POST['PBairro'];
        $PUf = $_POST['PUf'];
        $PTelefone = $_POST['PTelefone'];
        $TipoPg = $_POST['TipoPg'];
        $DescDiaria = $_POST['DescDiaria'];
        $QtdDiaria = $_POST['QtdDiaria'];
        $ValorDiaria = str_replace(",", ".", str_replace(".", "", $_POST['ValorDiaria']));
        $DescRemocao = $_POST['DescRemocao'];
        $QtdRemocao = $_POST['QtdRemocao'];
        $ValorRemocao = str_replace(",", ".", str_replace(".", "", $_POST['ValorRemocao']));
        $TipoDesconto = $_POST['TipoDesconto'];
        $ObsDesconto = $_POST['ObsDesconto'];
        $ValorDesconto = str_replace(",", ".", str_replace(".", "", $_POST['ValorDesconto']));
        $ValorTotal = str_replace(",", ".", str_replace(".", "", $_POST['ValorTotal']));
        $IdUsuario = $_SESSION['ID_USUARIO'];
        $LNome = strtoupper($_POST['LNome']);
        $LCPF = $_POST['LCPF'];
        $LCnh = $_POST['LCNH'];
        $LPlaca = $_POST['LPlaca'];
        $FormaRetirada = $_POST['FormaRetirada'];
        $Vl1           = str_replace(",", ".", str_replace(".", "", $_POST['Vl1']));
        $Vl2           = str_replace(",", ".", str_replace(".", "", $_POST['Vl2']));
        $DataHj = date("Y-m-d");
        $StatusDiario = 'A';

        $stmtd = $pdo->prepare('SELECT count(ID) as Qtd  FROM diariofinanceiro  WHERE STATUS =:status  AND DATAFINANCEIRO=:datafinanceiro ');
        $stmtd->bindParam(':datafinanceiro', $DataHj);
        $stmtd->bindParam(':status', $StatusDiario);
        $stmtd->execute();
        $Qtddiario = $stmtd->fetch();
        if ($Qtddiario['Qtd'] == 0) {
            $Cod_error = 2;
        } else {
                    if (!empty($ObsDesconto)) {
                        $IdUsuarioDesc = $_SESSION['IDUSUARIODESCONTO'];
                    } else {
                        $IdUsuarioDesc = 0;
                    }

                    $Status = 'R';//Retirado
                    date_default_timezone_set('America/Sao_Paulo');
                    $DataRetirada = date("Y-m-d");
                    $HoraRetirada = date("H:i:s");

            if ((!empty($Nome)) && (!empty($Doc)) && (!empty($Cpf)) && (!empty($LCnh)) && (!empty($LCPF)) &&
                          (!empty($LNome)) && (!empty($LCPF)) && (!empty($Endereco)) && (!empty($PEndereco))) {



                // caso seja diferente da forma de pagamento DINHEIRO/CARTAO
                if ($TipoPg == 'X') {

                    $TipoPgD = 'D';
                    $std = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $std->bindParam(':grv', $Grv);
                    $std->bindParam(':patio', $IdPatio);
                    $std->bindParam(':tipopg', $TipoPgD);
                    $std->bindParam(':descdiaria', $DescDiaria);
                    $std->bindParam(':qtddiaria', $QtdDiaria);
                    $std->bindParam(':valordiaria', $ValorDiaria);
                    $std->bindParam(':descremocao', $DescRemocao);
                    $std->bindParam(':qtdremocao', $QtdRemocao);
                    $std->bindParam(':valorremocao', $ValorRemocao);
                    $std->bindParam(':tipodesconto', $TipoDesconto);
                    $std->bindParam(':desconto', $ValorDesconto);
                    $std->bindParam(':valortotal', $Vl1);
                    $std->bindParam(':obsdesconto', $ObsDesconto);
                    $std->bindParam(':idusuario', $IdUsuario);
                    $std->bindParam(':idusudesc', $IdUsuarioDesc);
                    $std->execute();

                    $TipoPgC = 'C';
                    $stc = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $stc->bindParam(':grv', $Grv);
                    $stc->bindParam(':patio', $IdPatio);
                    $stc->bindParam(':tipopg', $TipoPgC);
                    $stc->bindParam(':descdiaria', $DescDiaria);
                    $stc->bindParam(':qtddiaria', $QtdDiaria);
                    $stc->bindParam(':valordiaria', $ValorDiaria);
                    $stc->bindParam(':descremocao', $DescRemocao);
                    $stc->bindParam(':qtdremocao', $QtdRemocao);
                    $stc->bindParam(':valorremocao', $ValorRemocao);
                    $stc->bindParam(':tipodesconto', $TipoDesconto);
                    $stc->bindParam(':desconto', $ValorDesconto);
                    $stc->bindParam(':valortotal', $Vl2);
                    $stc->bindParam(':obsdesconto', $ObsDesconto);
                    $stc->bindParam(':idusuario', $IdUsuario);
                    $stc->bindParam(':idusudesc', $IdUsuarioDesc);
                    $stc->execute();

                 }elseif($TipoPg == 'Y') {

                    $TipoPgD = 'B';
                    $std = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $std->bindParam(':grv', $Grv);
                    $std->bindParam(':patio', $IdPatio);
                    $std->bindParam(':tipopg', $TipoPgD);
                    $std->bindParam(':descdiaria', $DescDiaria);
                    $std->bindParam(':qtddiaria', $QtdDiaria);
                    $std->bindParam(':valordiaria', $ValorDiaria);
                    $std->bindParam(':descremocao', $DescRemocao);
                    $std->bindParam(':qtdremocao', $QtdRemocao);
                    $std->bindParam(':valorremocao', $ValorRemocao);
                    $std->bindParam(':tipodesconto', $TipoDesconto);
                    $std->bindParam(':desconto', $ValorDesconto);
                    $std->bindParam(':valortotal', $Vl1);
                    $std->bindParam(':obsdesconto', $ObsDesconto);
                    $std->bindParam(':idusuario', $IdUsuario);
                    $std->bindParam(':idusudesc', $IdUsuarioDesc);
                    $std->execute();

                    $TipoPgC = 'C';
                    $stc = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $stc->bindParam(':grv', $Grv);
                    $stc->bindParam(':patio', $IdPatio);
                    $stc->bindParam(':tipopg', $TipoPgC);
                    $stc->bindParam(':descdiaria', $DescDiaria);
                    $stc->bindParam(':qtddiaria', $QtdDiaria);
                    $stc->bindParam(':valordiaria', $ValorDiaria);
                    $stc->bindParam(':descremocao', $DescRemocao);
                    $stc->bindParam(':qtdremocao', $QtdRemocao);
                    $stc->bindParam(':valorremocao', $ValorRemocao);
                    $stc->bindParam(':tipodesconto', $TipoDesconto);
                    $stc->bindParam(':desconto', $ValorDesconto);
                    $stc->bindParam(':valortotal', $Vl2);
                    $stc->bindParam(':obsdesconto', $ObsDesconto);
                    $stc->bindParam(':idusuario', $IdUsuario);
                    $stc->bindParam(':idusudesc', $IdUsuarioDesc);
                    $stc->execute();

                }elseif($TipoPg == 'Z') {

                    $TipoPgD = 'B';
                    $std = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $std->bindParam(':grv', $Grv);
                    $std->bindParam(':patio', $IdPatio);
                    $std->bindParam(':tipopg', $TipoPgD);
                    $std->bindParam(':descdiaria', $DescDiaria);
                    $std->bindParam(':qtddiaria', $QtdDiaria);
                    $std->bindParam(':valordiaria', $ValorDiaria);
                    $std->bindParam(':descremocao', $DescRemocao);
                    $std->bindParam(':qtdremocao', $QtdRemocao);
                    $std->bindParam(':valorremocao', $ValorRemocao);
                    $std->bindParam(':tipodesconto', $TipoDesconto);
                    $std->bindParam(':desconto', $ValorDesconto);
                    $std->bindParam(':valortotal', $Vl1);
                    $std->bindParam(':obsdesconto', $ObsDesconto);
                    $std->bindParam(':idusuario', $IdUsuario);
                    $std->bindParam(':idusudesc', $IdUsuarioDesc);
                    $std->execute();

                    $TipoPgC = 'D';
                    $stc = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, `QTDREMOCAO`, `VALORREMOCAO`, 
                                                             `DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                                                    (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,
                                                                                    :qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                    $stc->bindParam(':grv', $Grv);
                    $stc->bindParam(':patio', $IdPatio);
                    $stc->bindParam(':tipopg', $TipoPgC);
                    $stc->bindParam(':descdiaria', $DescDiaria);
                    $stc->bindParam(':qtddiaria', $QtdDiaria);
                    $stc->bindParam(':valordiaria', $ValorDiaria);
                    $stc->bindParam(':descremocao', $DescRemocao);
                    $stc->bindParam(':qtdremocao', $QtdRemocao);
                    $stc->bindParam(':valorremocao', $ValorRemocao);
                    $stc->bindParam(':tipodesconto', $TipoDesconto);
                    $stc->bindParam(':desconto', $ValorDesconto);
                    $stc->bindParam(':valortotal', $Vl2);
                    $stc->bindParam(':obsdesconto', $ObsDesconto);
                    $stc->bindParam(':idusuario', $IdUsuario);
                    $stc->bindParam(':idusudesc', $IdUsuarioDesc);
                    $stc->execute();

                }else{
                $stxo = $pdo->prepare(' INSERT INTO `grv_pagamento`(`GRV`, `IDPATIO`,`TIPOPG`,`DESCDIARIA`, `VALORDIARIA`, `QTDDIARIA`, `DESCREMOCAO`, 
                                            `QTDREMOCAO`, `VALORREMOCAO`,`DESCONTO`, `VALORTOTAL`,`TIPODESCONTO`,`OBSDESCONTO`, `ID_USUARIO`,ID_USUDESC)VALUES 
                                                  (:grv,:patio,:tipopg,:descdiaria,:valordiaria,:qtddiaria,:descremocao,:qtdremocao,:valorremocao,:desconto,:valortotal,:tipodesconto,:obsdesconto,:idusuario,:idusudesc)');
                $stxo->bindParam(':grv', $Grv);
                $stxo->bindParam(':patio', $IdPatio);
                $stxo->bindParam(':tipopg', $TipoPg);
                $stxo->bindParam(':descdiaria', $DescDiaria);
                $stxo->bindParam(':qtddiaria', $QtdDiaria);
                $stxo->bindParam(':valordiaria', $ValorDiaria);
                $stxo->bindParam(':descremocao', $DescRemocao);
                $stxo->bindParam(':qtdremocao', $QtdRemocao);
                $stxo->bindParam(':valorremocao', $ValorRemocao);
                $stxo->bindParam(':tipodesconto', $TipoDesconto);
                $stxo->bindParam(':desconto', $ValorDesconto);
                $stxo->bindParam(':valortotal', $ValorTotal);
                $stxo->bindParam(':obsdesconto', $ObsDesconto);
                $stxo->bindParam(':idusuario', $IdUsuario);
                $stxo->bindParam(':idusudesc', $IdUsuarioDesc);
                $stxo->execute();

            }

            if($TipoPg=='B'){
                $statement = $pdo->prepare('INSERT INTO grv_liberacao(GRV, ID_PATIO, TIPORESP, CPF,CNH,NOME, CEP, ENDERECO, NUMERO,
                                                                                COMPL,BAIRRO,CIDADE,UF, TELEFONE, PNOME, PTIPODOC,PDOC,PCEP, PENDERECO,
                                                                                PNUMERO, PCOMPL, PBAIRRO, PCIDADE, PUF, PTELEFONE,FORMALIBERACAO,LNOME,LCPF,LCNH, LPLACA, IDUSUARIO)
                                                                        VALUES (:grv,:idpatio,:tiporesp,:cpf,:cnh,:nome,:cep,:endereco,:numero,
                                                                        :compl,:bairro,:cidade,:uf,:telefone,:pnome,:ptipodoc,:pdoc,:pcep,:pendereco,:pnumero,
                                                                        :pcompl,:pbairro,:pcidade,:puf,:ptelefone,:formaliberacao,:lnome,:lcpf,:lcnh,:lplaca,:idusuario)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':grv', $Grv);
                $statement->bindParam(':idpatio', $IdPatio);
                $statement->bindParam(':tiporesp', $TipoResp);
                $statement->bindParam(':cnh', $Cnh);
                $statement->bindParam(':cpf', $Cpf);
                $statement->bindParam(':nome', $Nome);
                $statement->bindParam(':cep', $Cep);
                $statement->bindParam(':endereco', $Endereco);
                $statement->bindParam(':numero', $Numero);
                $statement->bindParam(':compl', $Compl);
                $statement->bindParam(':bairro', $Bairro);
                $statement->bindParam(':cidade', $Cidade);
                $statement->bindParam(':uf', $Uf);
                $statement->bindParam(':telefone', $Telefone);
                $statement->bindParam(':pnome', $PNome);
                $statement->bindParam(':ptipodoc', $PTipo);
                $statement->bindParam(':pdoc', $Doc);
                $statement->bindParam(':pcep', $PCep);
                $statement->bindParam(':pendereco', $PEndereco);
                $statement->bindParam(':pnumero', $PNumero);
                $statement->bindParam(':pcompl', $PCompl);
                $statement->bindParam(':pbairro', $PBairro);
                $statement->bindParam(':pcidade', $PCidade);
                $statement->bindParam(':puf', $PUf);
                $statement->bindParam(':ptelefone', $PTelefone);
                $statement->bindParam(':lnome', $LNome);
                $statement->bindParam(':lcpf', $LCPF);
                $statement->bindParam(':lcnh', $LCnh);
                $statement->bindParam(':lplaca', $LPlaca);
                $statement->bindParam(':formaliberacao', $FormaRetirada);
                $statement->bindParam(':idusuario', $IdUsuario);
                $statement->execute();

                $StatusPreLiberado ='P';

                $stmt = $pdo->prepare('UPDATE grv_status SET STATUS = :status , DATARETIRADA = :dataretirada ,
                                                                      HORARETIRADA = :horaretirada WHERE ID_PATIO =:patio AND GRV =:grv');
                $stmt->bindParam(':grv', $Grv);
                $stmt->bindParam(':patio', $IdPatio);
                $stmt->bindParam(':status', $StatusPreLiberado);
                $stmt->bindParam(':horaretirada', $HoraRetirada);
                $stmt->bindParam(':dataretirada', $DataRetirada);
                $stmt->execute();


                $Cod_error = 5;
            }else {


                $statement = $pdo->prepare('INSERT INTO grv_liberacao(GRV, ID_PATIO, TIPORESP, CPF,CNH,NOME, CEP, ENDERECO, NUMERO,
                                                                                COMPL,BAIRRO,CIDADE,UF, TELEFONE, PNOME, PTIPODOC,PDOC,PCEP, PENDERECO,
                                                                                PNUMERO, PCOMPL, PBAIRRO, PCIDADE, PUF, PTELEFONE,FORMALIBERACAO,LNOME,LCPF,LCNH, LPLACA, IDUSUARIO)
                                                                        VALUES (:grv,:idpatio,:tiporesp,:cpf,:cnh,:nome,:cep,:endereco,:numero,
                                                                        :compl,:bairro,:cidade,:uf,:telefone,:pnome,:ptipodoc,:pdoc,:pcep,:pendereco,:pnumero,
                                                                        :pcompl,:pbairro,:pcidade,:puf,:ptelefone,:formaliberacao,:lnome,:lcpf,:lcnh,:lplaca,:idusuario)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':grv', $Grv);
                $statement->bindParam(':idpatio', $IdPatio);
                $statement->bindParam(':tiporesp', $TipoResp);
                $statement->bindParam(':cnh', $Cnh);
                $statement->bindParam(':cpf', $Cpf);
                $statement->bindParam(':nome', $Nome);
                $statement->bindParam(':cep', $Cep);
                $statement->bindParam(':endereco', $Endereco);
                $statement->bindParam(':numero', $Numero);
                $statement->bindParam(':compl', $Compl);
                $statement->bindParam(':bairro', $Bairro);
                $statement->bindParam(':cidade', $Cidade);
                $statement->bindParam(':uf', $Uf);
                $statement->bindParam(':telefone', $Telefone);
                $statement->bindParam(':pnome', $PNome);
                $statement->bindParam(':ptipodoc', $PTipo);
                $statement->bindParam(':pdoc', $Doc);
                $statement->bindParam(':pcep', $PCep);
                $statement->bindParam(':pendereco', $PEndereco);
                $statement->bindParam(':pnumero', $PNumero);
                $statement->bindParam(':pcompl', $PCompl);
                $statement->bindParam(':pbairro', $PBairro);
                $statement->bindParam(':pcidade', $PCidade);
                $statement->bindParam(':puf', $PUf);
                $statement->bindParam(':ptelefone', $PTelefone);
                $statement->bindParam(':lnome', $LNome);
                $statement->bindParam(':lcpf', $LCPF);
                $statement->bindParam(':lcnh', $LCnh);
                $statement->bindParam(':lplaca', $LPlaca);
                $statement->bindParam(':formaliberacao', $FormaRetirada);
                $statement->bindParam(':idusuario', $IdUsuario);
                $statement->execute();


                $stmt = $pdo->prepare('UPDATE grv_status SET STATUS = :status , DATARETIRADA = :dataretirada ,
                                                                      HORARETIRADA = :horaretirada WHERE ID_PATIO =:patio AND GRV =:grv');
                $stmt->bindParam(':grv', $Grv);
                $stmt->bindParam(':patio', $IdPatio);
                $stmt->bindParam(':status', $Status);
                $stmt->bindParam(':horaretirada', $HoraRetirada);
                $stmt->bindParam(':dataretirada', $DataRetirada);
                $stmt->execute();

                $Cod_error = 0;
            }
            }else{
                $Cod_error = 1;
            }
        }

            $Resultado['Cod_Error'] = $Cod_error;
        echo json_encode($Resultado);

        break ;

    case 'CalculaDinheiroCartao' :

        $ValorTotal      = str_replace(",",".",str_replace(".","",$_POST['ValorTotal']));
        $Valor           = str_replace(",",".",str_replace(".","",$_POST['Valor']));

        $ValorSub = ($ValorTotal-$Valor) ;

        $Resultado['Html'] =  number_format($ValorSub,2,",","");

        echo json_encode($Resultado);

        break ;

}

