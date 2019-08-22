<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 25/10/2017
 * Time: 15:26
 */
require '../fontes/conexao.php';
session_start();
$acao = $_POST['acao'];

switch($acao){



    case 'Salva_TipoPagamento' :

            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
              $TipoPagamento   = $_POST['Txt_TipoPagamento'];
              $Status         = 1;


            if(!empty($TipoPagamento)){

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO tipopagamento (TIPOPAGAMENTO,STATUS) VALUES
                                                                      (:tipopagamento, :status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':tipopagamento',  $TipoPagamento);
                $statement->bindParam(':status',  $Status);

                // Executa a senten�a j� com os valores
                if($statement->execute()){
                    // Definimos a mensagem de sucesso
                    $Cod_Error = 0;
                    $Html = "<div class='alert alert-success'>
		                       <h4><i class='icon fa fa-check'></i>
		                            Cadastro Realizado com Sucesso !</h4></div>";

                }else{
                    $Cod_Error = '1';
                    $Html = "<div class='alert alert-warning disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Dados já cadastrado! </h4>
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

    case 'Alterar_TipoPagamento' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo          = $_POST['Txt_Codigo'];
        $TipoPagamento   = $_POST['ATxt_TipoPagamento'];


        if(!empty($TipoPagamento)){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE tipopagamento SET TIPOPAGAMENTO=:tipopagamento WHERE IDTIPOPAGAMENTO=:idpagamento');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':tipopagamento',  $TipoPagamento);
            $statement->bindParam(':idpagamento',  $Codigo);

            // Executa a senten�a j� com os valores
            if($statement->execute()){
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
		                       <h4><i class='icon fa fa-check'></i>
		                            Cadastro Realizado com Sucesso !</h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-warning disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Dados já cadastrado! </h4>
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


    case 'Busca_TipoPagamento_Tabela' :



            if ($_SESSION['IDEMPRESA'] > 0) {
                session_destroy();
            }

            $stmt = $pdo->prepare('SELECT * FROM tipopagamento ');
            $executa = $stmt->execute();
            $TipoPagamento = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['STATUS'] == '1') {
                    $Status = '<span class="label label-success">Ativo</span>';
                } else {
                    $Status = '<span class="label label-danger">Desativado</span>';
                }

                $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDTIPOPAGAMENTO'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";
                $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['IDTIPOPAGAMENTO'] . "' class=' btn btn-danger glyphicon glyphicon-trash' ></button>";

                $t = '<div class="col-md-4">
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-gray-active">
                  <!-- /.widget-user-image -->
                      <h4 class="widget-user-username"><i class="fa fa-money"> </i> ' . strtoupper($linha['TIPOPAGAMENTO']) . '</h4>
                 </div>
                    <div class="box-footer no-padding">
                      <ul class="nav nav-stacked">
                        <li> ' . $Status . '<span class="pull-right ">' . $botaoEdit . ' ' . $botaoExcluir . '</span></a></li>
                      </ul>
                    </div>
          </div>
          <!-- /.widget-user -->
        </div>';
                array_push($TipoPagamento, $t);

            }

            $Resultado['Html'] = $TipoPagamento;
            echo json_encode($Resultado);

    break ;

    case 'Busca_TipoPagamento_Formulario' :

        $TipoPagamento = $_POST['Cod_TipoPagamento'];
        $stmt = $pdo->prepare( 'SELECT * FROM tipopagamento  WHERE IDTIPOPAGAMENTO= :codtipopagamento');
        $stmt ->bindParam( ':codtipopagamento', $TipoPagamento );
        $executa=$stmt->execute();
        while ($linha = $stmt->fetch()) {
            $t = array('TipoPagamento' => $linha['TIPOPAGAMENTO']);
                    }
        $Resultado['Html'] = $t;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_TipoPagamento' :

        $TipoPagamento = $_POST['Cod_TipoPagamento'];
        $stmt = $pdo->prepare( 'UPDATE tipopagamento SET STATUS =0  WHERE IDTIPOPAGAMENTO= :Cod_TIPOPAGAMENTO');
        $stmt ->bindParam( ':Cod_TIPOPAGAMENTO', $TipoPagamento );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

