<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 25/10/2019
 * Time: 15:26
 */
require '../fontes/conexao.php';
session_start();
$acao = $_POST['acao'];

switch($acao){

    case 'Salva_Taxa' :

            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $TipoArea = $_POST['Txt_Area'];
            $TipoVeiculo= $_POST['Txt_TipoVeiculo'];
            $Valor = str_replace(",", ".", str_replace(".", "", $_POST['Txt_Valor']));
            $QtdHora = $_POST['Txt_QtdHora'];
            $Status = 1;

            if (($Valor >= 0.01) && ($TipoArea >=1) && ($TipoVeiculo>=1)){

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO taxas (ID_AREA,ID_TRANSP,VALOR,QTDHORA,STATUS) VALUES
                                                                        (:tipoarea,:idtipotransp,:valor,:qtdhora,:status)');

                // Adiciona os dados acima para serem executados na senten�a

                $statement->bindParam(':tipoarea', $TipoArea);
                $statement->bindParam(':idtipotransp', $TipoVeiculo);
                $statement->bindParam(':valor', $Valor);
                $statement->bindParam(':qtdhora', $QtdHora);
                $statement->bindParam(':status', $Status);

                // Executa a senten�a j� com os valores
                if ($statement->execute()) {
                    // Definimos a mensagem de sucesso
                    $Cod_Error = 0;
                    $Html = "<div class='alert alert-success'>
		                       <h4><i class='icon fa fa-check'></i>
		                            Cadastro Realizado com Sucesso !</h4></div>";

                } else {

                    $Cod_Error = '1';
                    $Html = "<div class='alert alert-danger disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Falha ao Realizar Cadastro  </h4>
	                       </div>";
                }

            } else {

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



    case 'Altera_Taxa' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $ID               = $_POST['ATxt_Codigo'];
        $Patio            = $_POST['ATxt_Patio'];
        $TipoVeiculo      = $_POST['ATxt_TipoVeiculo'];
        $Valor            = str_replace(",",".",str_replace(".","",$_POST['ATxt_Valor']));
        $Descricao        = $_POST['ATxt_DescDiaria'];
        $DescReboque      = $_POST['ATxt_DescReboque'];
        $Valoreboque      = str_replace(",",".",str_replace(".","",$_POST['ATxt_ValorReboque']));
        $ValorKm = str_replace(",", ".", str_replace(".", "", $_POST['ATxt_ValoKmReboque']));
        $KmRebocado = $_POST['ATxt_KMRebocado'];
        //  $Status           = 1;
        if($KmRebocado=='N'){
            $ValorKm=0.00;
        }


        if( (!empty($TipoVeiculo)) && (!empty($Valor)) ){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('Update taxas SET TIPOVEICULO=:tipoveiculo,DESCRICAO=:descricao,
                    DESC_REBOQUE=:descreboque,VALOR_REBOQUE=:valoreboque,ID_PATIO=:idpatio,VALORKM=:valorkm,KMREBOCADO=:kmrebocado, VALOR =:valor WHERE ID = :id');


            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':idpatio',  $Patio);
            $statement->bindParam(':id',  $ID);
            $statement->bindParam(':tipoveiculo',  $TipoVeiculo);
            $statement->bindParam(':descricao',  $Descricao);
            $statement->bindParam(':descreboque',  $DescReboque);
            $statement->bindParam(':valoreboque',  $Valoreboque);
            $statement->bindParam(':valor',  $Valor);
            $statement->bindParam(':valorkm',  $ValorKm);
            $statement->bindParam(':kmrebocado',  $KmRebocado);

            // Executa a senten�a j� com os valores
            if($statement->execute()){
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
		                       <h4><i class='icon fa fa-check'></i>
		                            Cadastro Realizado com Sucesso !</h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Falha ao Realizar Cadastro  </h4>
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

    case 'Busca_Taxa_Tabela' :

            $stmt = $pdo->prepare('SELECT T.* ,A.AREA ,I.MEIOTRANSPORTE FROM tipotransporte I, taxas T , tipoarea A WHERE I.IDTIPOTRANSP=T.ID_TRANSP 
                                              AND A.IDAREA=T.ID_AREA ');
            $executa = $stmt->execute();
            $Taxas = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['STATUS'] == '1') {
                    $Status = '<span class="badge badge-success">Ativo</span>';

                } else {

                    $Status = '<span class="badge badge-danger">Desativado</span>';
                }

                $botao=   '<div class="btn-group">
                    <button type="button" class="btn btn-warning">Ação</button>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" id="btnExcluir"  codigo ="'.$linha['IDTAXA'].'"  href="#">
                      <i class="fa fa-trash"> Excluir </i> </a>
                      <a class="dropdown-item" id="btnEditar"  codigo ="'.$linha['IDTAXA'].'"  href="#">
                      <i class="fa fa-pencil"> Editar </i> </a>
                    </div>
                  </div>';
                $t = array('Area' => $linha['AREA'], 'QtdHora' => $linha['QTDHORA'], 'TipoTransporte' => $linha['MEIOTRANSPORTE'],
                    'Valor' => str_replace(".", ",", $linha['VALOR']), 'Status' => $Status, 'Html_Acao' => $botao);
                array_push($Taxas, $t);

            }

            $Resultado['Html'] = $Taxas;
            echo json_encode($Resultado);

    break ;

    case 'BotaoTaxa' :
        $DataHj=date('Y-m-d');
        $Id_Transp=$_POST['IdTransp'];
        $Placa= $_POST['Placa'];
        //Verifico se a placa ja teve ticket hj
        $stmt1 = $pdo->prepare('SELECT COUNT(PLACA) AS QTDPLACA  FROM ticket where PLACA like :placa AND DATAENT =:datahj');
        $stmt1->bindParam(':placa', $Placa);
        $stmt1->bindParam(':datahj', $DataHj);
        $stmt1->execute();
        $Linha1 = $stmt1->fetch();
        $QtdTicket=$Linha1['QTDPLACA'];

        if($QtdTicket >=1){
            $botao = '<p class="text-red">Essa placa já teve ticket Hoje!</p>';
            $stmt = $pdo->prepare('SELECT * FROM taxasadicional   WHERE   STATUS = 1 ORDER BY QTDHORA ASC');
            
        }else{
            $stmt = $pdo->prepare('SELECT * FROM taxas   WHERE ID_TRANSP=:idtransp  AND  STATUS =1 ORDER BY QTDHORA ASC');
             $stmt ->bindParam( ':idtransp', $Id_Transp );
            $botao ='';
        }
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
           
            $tempo = $linha['QTDHORA'].'hs';
            $botao.='<a class="BotaoTaxas btn btn-app " id="'.$linha['IDTAXA'].'"  tempo="'.$linha['QTDHORA'].'"  valor="'.$linha['VALOR'].'"  codigo="'.$linha['IDTAXA'].'">
                        <i class="fa fa-money"></i> '
                       .$tempo. '- R$ '.$linha['VALOR'].
                    '</a>';
        }

        $Resultado['Html'] = $botao;
        echo json_encode($Resultado);

        break ;


        case 'BotaoRecarga' :

        
        $stmt = $pdo->prepare('SELECT * FROM recarga  WHERE   STATUS =1 ORDER BY VALOR ASC');
        $executa = $stmt->execute();
        $botao = '';

        while ($linha = $stmt->fetch()) {
          
            $botao.='<a class="BotaoRecarga btn btn-app " id="'.$linha['IDRECARGA'].'"    valor="'.$linha['VALOR'].'"  codigo="'.$linha['IDRECARGA'].'">
                        <i class="fa fa-credit-card"></i> Recarga- R$ '.$linha['VALOR'].
                    '</a>';
        }

        $Resultado['Html'] = $botao;
        echo json_encode($Resultado);

        break ;

    case 'Busca_Taxa_Formulario' :

        $Cod_Id = $_POST['Cod_Id'];
        $stmt = $pdo->prepare( 'SELECT * FROM taxas WHERE IDTAXA=:id');
        $stmt ->bindParam( ':id', $Cod_Id );
        $stmt->execute();
            while ($linha = $stmt->fetch()) {
          
            $Taxas = array('Cod_Id' => $linha['IDTAXA'],'TipoArea' => $linha['ID_AREA'],
            'TipoVeiculo' => $linha['ID_TRANSP'],'Valor' => str_replace(".",",",$linha['VALOR']),'QtdHora'=>$linha['QTDHORA']);


        }

        $Resultado['Html'] = $Taxas;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_Taxa' :

        $Cod_Id = $_POST['Cod_Taxa'];
        $stmt = $pdo->prepare( 'UPDATE taxas SET STATUS =0  WHERE IDTAXA = :id');
        $stmt ->bindParam( ':id', $Cod_Id );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

