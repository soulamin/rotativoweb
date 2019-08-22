<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 26/10/2017
 * Time: 17:26
 */
require '../fontes/conexao.php';
include 'InsereArquivo.php';

$acao = $_POST['acao'];

switch($acao){

    case 'Salva_Veiculo' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Ponto                = $_POST['Txt_Ponto'];
        $Placa                = $_POST['Txt_Placa'];
        $Cor                  = $_POST['Txt_Cor'];
        $Chassi               = $_POST['Txt_Chassi'];
        $Ano                  = $_POST['Txt_Ano'];
        $Renavan              = $_POST['Txt_Renavan'];
        $Tipo                 = $_POST['Txt_Tipo'];
        $Marca                = $_POST['Txt_Marca'];
        $Modelo               = $_POST['Txt_Modelo'];
        $Equipamento          = $_POST['Txt_Equipamento'];
        $Status               = 1;


        if( ($Ponto >0) && ($Marca >0) && ($Modelo >0) && ($Tipo >0) &&
            ($Cor >0) && (!empty($Placa)) && (!empty($Ano)) && (!empty($Renavan))&& (!empty($Chassi))){

            if (!isset($_FILES['Txt_DocCrlv']['name'])) {

                $Arquivo_DocCrlv = 'X.jpg';

            } else {

                $Arquivo_DocCrlv = InserirArquivo('Crvl', $_FILES['Txt_DocCrlv']['name'], $_FILES['Txt_DocCrlv']['tmp_name'], $_FILES['Txt_DocCrlv']['size']);

            }
            if ( $Arquivo_DocCrlv == FALSE) {

                $Cod_Error = 1;
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                 <h4><i class='icon fa fa-ban'></i> Verifique o Tamanho e a Extensão do Arquivo!</h4></div>";

            } else {

                           // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO  veiculo (ID_PONTO,ID_EQUIPAMENTO,STATUS,ID_TIPOTRANSP,ID_MARCA,ID_MODELO,ANO,ID_COR,PLACA,
                                                                   CHASSI,RENAVAN,DOC_CRVL)VALUES
                                                                 (:idponto, :idequip ,:status , :idtipo,:idmarca ,:idmodelo, :ano ,:idcor ,:placa,
                                                                  :chassi,:renavan,:crlv)');
                 $statement->bindParam(':idponto',  $Ponto);
                $statement->bindParam(':crlv', $Arquivo_DocCrlv);
                 $statement->bindParam(':idequip', $Equipamento);
                 $statement->bindParam(':status',  $Status);
                 $statement->bindParam(':idtipo',  $Tipo);
                 $statement->bindParam(':idmarca',  $Marca);
                 $statement->bindParam(':idmodelo', $Modelo);
                 $statement->bindParam(':ano',  $Ano);
                 $statement->bindParam(':idcor',  $Cor);
                 $statement->bindParam(':placa', $Placa);
                 $statement->bindParam(':chassi',  $Chassi);
                 $statement->bindParam(':renavan',  $Renavan);

            // Executa a senten�a j� com os valores
            if($statement->execute()){
                $CodVeiculo = $pdo->lastInsertId();
                // Prepara uma senten�a para ser executada
                $stm = $pdo->prepare('UPDATE equipamento SET ID_VEICULO=:idveiculo WHERE IDEQUIPAMENTO = :idequipamento');
                $stm->bindParam(':idequipamento', $Equipamento);
                $stm->bindParam(':idveiculo',     $CodVeiculo);
                $stm->execute();
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";



            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Falha ao Realizar Cadastro  </h4>
                           </div>";
            }

            }

        }else{

            $Cod_Error = '1';
            $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
                           </div>";
        }

        $resultado['Cod_Error'] = $Cod_Error;
        $resultado['Html'] = $Html;
        echo json_encode($resultado);

        break;

    case 'Altera_Veiculo' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo               = $_POST['Txt_Codigo'];
        $Ponto                = $_POST['Txt_Ponto'];
        $Placa                = $_POST['Txt_Placa'];
        $Cor                  = $_POST['Txt_Cor'];
        $Chassi               = $_POST['Txt_Chassi'];
        $Ano                  = $_POST['Txt_Ano'];
        $Renavan              = $_POST['Txt_Renavan'];
        $Tipo                 = $_POST['Txt_Tipo'];
        $Marca                = $_POST['Txt_Marca'];
        $Modelo               = $_POST['Txt_Modelo'];
        $Equipamento          = $_POST['Txt_Equipamento'];



        if( ($Ponto >0) && ($Marca >0) && ($Modelo >0) && ($Tipo >0) &&
            ($Cor >0) && (!empty($Placa)) && (!empty($Ano)) && (!empty($Renavan))&& (!empty($Chassi))){


            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE veiculo SET ID_PONTO = :idponto,ID_EQUIPAMENTO=:idequip,ID_TIPOTRANSP=:idtipo,
                                                    ID_MARCA=:idmarca,ID_MODELO=:idmodelo,ANO=:ano,ID_COR=:idcor,PLACA=:placa,
                                                                   CHASSI=:chassi,RENAVAN=:renavan WHERE IDVEICULO = :codigo');
            $statement->bindParam(':codigo',  $Codigo);
            $statement->bindParam(':idponto',  $Ponto);
            $statement->bindParam(':idequip', $Equipamento);
            $statement->bindParam(':status',  $Status);
            $statement->bindParam(':idtipo',  $Tipo);
            $statement->bindParam(':idmarca',  $Marca);
            $statement->bindParam(':idmodelo', $Modelo);
            $statement->bindParam(':ano',  $Ano);
            $statement->bindParam(':idcor',  $Cor);
            $statement->bindParam(':placa', $Placa);
            $statement->bindParam(':chassi',  $Chassi);
            $statement->bindParam(':renavan',  $Renavan);

            // Executa a senten�a j� com os valores
            if($statement->execute()){

                $sta = $pdo->prepare('UPDATE equipamento SET ID_VEICULO=:idveiculo WHERE IDEQUIPAMENTO = :idequip');
                $sta->bindParam(':idveiculo', $Codigo);
                $sta->bindParam(':idequip',  $Equipamento);
                // Executa a senten�a j� com os valores
                $sta->execute();
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Veiculo já cadastrado ! </h4>
                           </div>";
            }


        }else{

            $Cod_Error = '1';
            $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Existe(m) Campo(s) Vazio(s). Por favor preencher!</h4>
                           </div>";
        }

        $resultado['Cod_Error'] = $Cod_Error;
        $resultado['Html'] = $Html;
        echo json_encode($resultado);

        break;

    case 'Busca_Veiculos_Tabela' :

            $stmt = $pdo->prepare( 'SELECT V.PLACA,V.IDVEICULO,V.STATUS,M.MODELO,P.NOMEPONTO FROM veiculo V 
                                                                    INNER JOIN ponto P ON P.IDPONTO = V.ID_PONTO 
                                                                    INNER JOIN modelotransporte M ON M.IDMODELO = V.ID_MODELO ');

        $executa=$stmt->execute();
        $Veiculos = array();

        while ($linha = $stmt->fetch()) {
             $botaoExcluir = "<button id='btnExcluir'   codigo ='" . $linha['IDVEICULO'] . "' class='btn btn-danger glyphicon glyphicon-trash'></button>";
             $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDVEICULO'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";

            if($linha['STATUS']== '1'){
                $Status = '<span class="label label-success">Ativo</span>';

            }else{

                $Status = '<span class="label label-danger">Desativado</span>';
            }

            $V =  '<div class="col-md-4">
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-gray-active">
                  <!-- /.widget-user-image -->
                      <h4 class="widget-user-username"><i class="fa fa-road"></i>' .strtoupper($linha['PLACA']).'</h4>
                      <h5 class="widget-user-desc">'.$linha['NOMEPONTO'].'</h5>
                      
                 </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li> '.$Status.'<span class="pull-right ">'.$botaoEdit.' '.$botaoExcluir.'</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>';            array_push($Veiculos, $V);
        }

        $Resultado['Html'] = $Veiculos;
        echo json_encode($Resultado);

        break ;



    case 'Busca_Veiculo_Formulario' :

        $Cod_Veiculo = $_POST['Cod_Veiculo'];
        $stmt = $pdo->prepare( 'SELECT *  FROM veiculo V INNER JOIN tipotransporte T       ON V.ID_TIPOTRANSP=T.IDTIPOTRANSP
                                                            INNER JOIN ponto P             ON V.ID_PONTO=P.IDPONTO
                                                            INNER JOIN marcatransporte M   ON V.ID_MARCA=M.IDMARCA
                                                            INNER JOIN modelotransporte MO ON V.ID_MODELO=MO.IDMODELO
                                                            INNER JOIN cortransporte C     ON V.ID_COR=C.IDCOR
                                                            LEFT JOIN  equipamento E       ON V.ID_EQUIPAMENTO=E.IDEQUIPAMENTO
                                                            WHERE V.IDVEICULO =:codveiculo ');
        $stmt ->bindParam( ':codveiculo', $Cod_Veiculo);
        $executa=$stmt->execute();

        while ($linha = $stmt->fetch()) {
            $TipoTransp   = '<option value="' . $linha['IDTIPOTRANSP'] . '" selected>'.$linha['MEIOTRANSPORTE'].'</option>';
            $MarcaTransp  = '<option value="' . $linha['IDMARCA'] . '" selected >' .$linha['MARCA'].'</option>';
            $Ponto        = '<option value="' . $linha['IDPONTO'] . '" selected>'.$linha['NOMEPONTO'].'</option>';
            $ModeloTransp = '<option value="' . $linha['IDMODELO'] . '" selected>' .$linha['MODELO'].'</option>';
            $Cor          = '<option value="' . $linha['IDCOR'] . '" selected>'.$linha['COR'].'</option>';
            if($linha['ID_EQUIPAMENTO']>0){
                $Equipamento  = '<option value="' . $linha['ID_EQUIPAMENTO'] . '" >'.$linha['MAC_WIFI'].'</option>';
            }else{
                $Equipamento  = '<option value="0" >EQUIPAMENTO</option>';
            }


            $v = array('Ponto' => $Ponto,'Tipo' => $TipoTransp,'Marca' => $MarcaTransp,'Modelo' => $ModeloTransp,'Cor' => $Cor,'Equipamento' => $Equipamento,'Ano' => $linha['ANO'],  'Placa' => $linha['PLACA'], 'Chassi' => $linha['CHASSI'], 'Renavan' => $linha['RENAVAN']);

        }
        $Resultado['Html'] = $v;
        echo json_encode($Resultado);

        break;


    case 'Combobox_Veiculo' :


        $statement = $pdo->prepare('SELECT PLACA ,IDVEICULO FROM veiculo WHERE  ID_EQUIPAMENTO = 0');
        $statement->execute();
        $Veiculo = array();
        $v = '<option value="0" selected>VEICULO</option>';
        array_push($Veiculo, $v);
        while ($linhas = $statement->fetch()) {

            $v = '<option value="' . $linhas['IDVEICULO'] . '" >' . $linhas['PLACA'] . '</option>';
            array_push($Veiculo, $v);
        }
        $resultado['Html'] = $Veiculo;
        echo json_encode($resultado);

        break ;

    case 'Combobox_Veiculo_Motorista' :
        $IdPonto = $_POST['Cod_Ponto'];
        $statement = $pdo->prepare('SELECT PLACA ,IDVEICULO FROM veiculo WHERE ID_PONTO =:idponto AND  ID_MOTORISTA = 0');
        $statement ->bindParam( ':idponto', $IdPonto);
        $statement->execute();
        $Veiculo = array();
        $v = '<option value="0" selected>VEICULO</option>';
        array_push($Veiculo, $v);
        while ($linhas = $statement->fetch()) {

            $v = '<option value="' . $linhas['IDVEICULO'] . '" >' . $linhas['PLACA'] . '</option>';
            array_push($Veiculo, $v);
        }
        $resultado['Html'] = $Veiculo;
        echo json_encode($resultado);

        break ;



    //Desativa o Veiculo Status
    case 'Exclui_Veiculo' :

        $Cod_Veiculo= $_POST['Cod_Veiculo'];
        $stmt = $pdo->prepare( 'UPDATE veiculo SET STATUS = 0  WHERE IDVEICULO= :Cod_Veiculo');
        $stmt ->bindParam( ':Cod_Veiculo', $Cod_Veiculo );
        if($stmt->execute()){

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;


}



