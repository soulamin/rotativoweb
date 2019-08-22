<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 26/10/2017
 * Time: 15:26
 */
require '../fontes/conexao.php';
//Permissão de acesso
session_start();

$acao = $_POST['acao'];

switch($acao){


    case 'Combobox_TipoVeiculo' :

        $statement = $pdo->prepare('SELECT * FROM tipotransporte WHERE STATUS = 1');
        $statement->execute();
        $TipoTransp = array();
        $t = '<option value="0" >SELECIONE VEICULO</option>';
        array_push($TipoTransp, $t);
        while ($linhas = $statement->fetch()) {

            $t = '<option value="' . $linhas['IDTIPOTRANSP']. '" >' .$linhas['MEIOTRANSPORTE']. '</option>';
            array_push($TipoTransp, $t);
        }
        $resultado['Html'] = $TipoTransp;
        echo json_encode($resultado);

        break ;



    case 'Salva_TipoVeiculo' :


            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $TipoVeiculo   = $_POST['Txt_TipoVeiculo'];
            $Status                = 1;


            if(!empty($TipoVeiculo)){

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO tipotransporte (MEIOTRANSPORTE,STATUS) VALUES
                                                                       (:tipoveiculo, :status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':tipoveiculo',  $TipoVeiculo);
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

    case 'Alterar_TipoVeiculo' :


        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo        = $_POST['Txt_Codigo'];
        $TipoVeiculo   = $_POST['ATxt_TipoVeiculo'];



        if(!empty($TipoVeiculo)){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE tipotransporte SET MEIOTRANSPORTE=:tipoveiculo WHERE  IDTIPOTRANSP =:idtipotransp');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':tipoveiculo',  $TipoVeiculo);
            $statement->bindParam(':idtipotransp',  $Codigo);



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
	                       <h4><i class='icon fa fa-ban'></i> Dados ja cadastrado! </h4>
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

    case 'Busca_TipoVeiculo_Tabela' :

    $stmt = $pdo->prepare( 'SELECT * FROM tipotransporte ');
    $executa=$stmt->execute();
    $TipoVeiculo = array();

    while ($linha = $stmt->fetch())
    {
        if($linha['STATUS']== '1'){
            $Status = '<span class="label label-success">Ativo</span>';
        }else{
            $Status = '<span class="label label-danger">Desativado</span>';
        }

        $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDTIPOTRANSP'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";
        $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['IDTIPOTRANSP'] . "' class=' btn btn-danger glyphicon glyphicon-trash' ></button>";

        $t =  array('TipoVeiculo' => $linha['MEIOTRANSPORTE'], 'Status' => $Status,'Html_Acao' => $botaoEdit.' '.$botaoExcluir);
        array_push($TipoVeiculo, $t);
    }

    $Resultado['Html'] = $TipoVeiculo;
    echo json_encode($Resultado);

    break ;

    case 'Busca_TipoVeiculo_Formulario' :

        $Cod_TipoTransp = $_POST['Cod_Tipo'];
        $stmt = $pdo->prepare( 'SELECT * FROM tipotransporte  WHERE IDTIPOTRANSP= :Cod_TipoTransp');
        $stmt ->bindParam( ':Cod_TipoTransp', $Cod_TipoTransp );
        $executa=$stmt->execute();

        while ($linha = $stmt->fetch()) {
            $t = array('MeioTransporte' => $linha['MEIOTRANSPORTE']);

        }
        $Resultado['Html'] = $t;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_TipoVeiculo' :

        $Cod_TipoTransp = $_POST['Cod_TipoVeiculo'];
        $stmt = $pdo->prepare( 'UPDATE  tipotransporte SET STATUS = 0 WHERE IDTIPOTRANSP = :Cod_TipoTransp');
        $stmt ->bindParam( ':Cod_TipoTransp', $Cod_TipoTransp );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

