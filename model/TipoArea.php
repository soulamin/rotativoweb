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

    case 'Combobox_TipoArea' :

        $statement = $pdo->prepare('SELECT * FROM tipoarea WHERE STATUS = 1 ORDER BY AREA ASC');
        $statement->execute();

        $r = '<option value="#" >SELECIONE ÁREA</option>';
        while ($linhas = $statement->fetch()) {

            $r.= '<option value="' . $linhas['IDAREA'] . '" >' . $linhas['AREA'] . '</option>';

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;

    case 'Salva_Reboque' :
        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {

            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $Placa = $_POST['Txt_Placa'];
            $Status = 1;


            if (!empty($Placa)) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO reboque (PLACA,STATUS) VALUES
                                                                    (:placa, :status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':placa', $Placa);
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
                    $Html = "<div class='alert alert-warning disable alert-dismissable'>
	                       <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	                       <h4><i class='icon fa fa-ban'></i> Dados já cadastrado! </h4>
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
        }else{
            session_destroy();
        }
        break;

    case 'Alterar_Reboque' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo       = $_POST['Txt_Codigo'];
        $Placa        = $_POST['ATxt_Placa'];


        if(!empty($Placa)){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE reboque SET PLACA=:placa WHERE ID=:id');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':placa',  $Placa);
            $statement->bindParam(':id',  $Codigo);

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


    case 'Busca_Reboque_Tabela' :

        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {
            $stmt = $pdo->prepare('SELECT * FROM reboque ');
            $executa = $stmt->execute();
            $Reboque = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['STATUS'] == '1') {
                    $Status = '<span class="label label-success">Ativo</span>';
                } else {
                    $Status = '<span class="label label-danger">Desativado</span>';
                }

                $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['ID'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";
                $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['ID'] . "' class=' btn btn-danger glyphicon glyphicon-trash' ></button>";

                $r = array('Placa' => $linha['PLACA'], 'Html_Acao' => $botaoEdit . ' ' . $botaoExcluir);
                array_push($Reboque, $r);

            }

            $Resultado['Html'] = $Reboque;
            echo json_encode($Resultado);
        }else{
            session_destroy();
        }
    break ;

    case 'Busca_Reboque_Formulario' :

        $CodReboque = $_POST['Cod_Reboque'];
        $stmt = $pdo->prepare( 'SELECT * FROM reboque  WHERE ID= :codreboque');
        $stmt ->bindParam( ':codreboque', $CodReboque );
        $executa=$stmt->execute();
        while ($linha = $stmt->fetch()) {
            $c = array('Placa' => $linha['PLACA']);
                    }
        $Resultado['Html'] = $c;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_Reboque' :

        $Cod_Reboque = $_POST['Cod_Reboque'];
        $stmt = $pdo->prepare( 'UPDATE reboque SET STATUS =0  WHERE ID= :Cod_Reboque');
        $stmt ->bindParam( ':Cod_Reboque', $Cod_Reboque );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

