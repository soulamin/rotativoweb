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

    case 'Combobox_FormaPg' :

        $statement = $pdo->prepare('SELECT * FROM formapg WHERE STATUS = 1 ORDER BY FORMAPG ASC');
        $statement->execute();

          $r='';
        while ($linhas = $statement->fetch()) {

            $r.= '<option value="' . $linhas['IDFORMAPG'] . '" >' . $linhas['FORMAPG'] . '</option>';

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;

    case 'Salva_FormaPg' :

        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {

            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $FormaPg = $_POST['Txt_FormaPg'];
            $Sigla = $_POST['Txt_Sigla'];
            $Status = 1;

            if((!empty($FormaPg)) && (!empty($Sigla))){
                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO formapg (FORMAPG,SIGLA,STATUS) VALUES
                                                                    (:forma,:sigla, :status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':forma', $FormaPg);
                $statement->bindParam(':sigla', $Sigla);
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

    case 'Alterar_FormaPg' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo       = $_POST['Txt_Codigo'];
        $FormaPg   = $_POST['ATxt_FormaPg'];
        $Sigla   = $_POST['ATxt_Sigla'];


        if((!empty($FormaPg)) && (!empty($Sigla))){

            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE formapg SET FORMAPG=:formapg ,SIGLA=:sigla WHERE IDFORMAPG=:id');

            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':formapg',  $FormaPg);
            $statement->bindParam(':sigla',  $Sigla);
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


    case 'Busca_FormaPg_Tabela' :

        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {
            $stmt = $pdo->prepare('SELECT * FROM formapg ');
            $executa = $stmt->execute();
            $FormaPg = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['STATUS'] == '1') {
                    $Status = '<span class="label label-success">Ativo</span>';
                } else {
                    $Status = '<span class="label label-danger">Desativado</span>';
                }

                $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDFORMAPG'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";
                $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['IDFORMAPG'] . "' class=' btn btn-danger glyphicon glyphicon-trash' ></button>";

                $f = array('FormaPg' => $linha['FORMAPG'],'Sigla' => $linha['SIGLA'],'Status' => $Status, 'Html_Acao' => $botaoEdit . ' ' . $botaoExcluir);
                array_push($FormaPg, $f);

            }

            $Resultado['Html'] = $FormaPg;
            echo json_encode($Resultado);
        }else{
            session_destroy();
        }
    break ;

    case 'Busca_FormaPg_Formulario' :

        $Cod_FormaPg = $_POST['Cod_FormaPg'];
        $stmt = $pdo->prepare( 'SELECT * FROM formapg  WHERE IDFORMAPG= :codformapg');
        $stmt ->bindParam( ':codformapg', $Cod_FormaPg );
        $executa=$stmt->execute();
        while ($linha = $stmt->fetch()) {
            $c = array('FormaPg' => $linha['FORMAPG'],'Sigla' => $linha['SIGLA'],'Cod'=>$linha['IDFORMAPG']);
                    }
        $Resultado['Html'] = $c;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_FormaPg' :

        $Cod_FormaPg = $_POST['Cod_FormaPg'];
        $stmt = $pdo->prepare( 'UPDATE formapg SET STATUS =0  WHERE IDFORMAPG= :Cod_FormaPg');
        $stmt ->bindParam( ':Cod_FormaPg', $Cod_FormaPg );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

