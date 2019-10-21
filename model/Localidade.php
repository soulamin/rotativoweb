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

    case 'Combobox_LocalidadeFiscal':
     
   
        $Fiscal    = $_SESSION['ID_USUARIO'];
     
        $statement = $pdo->prepare('SELECT * FROM localidade l ,localfiscal f WHERE f.ID_FISCAL LIKE :fiscal AND 
                                    f.STATUS = 1 AND f.ID_LOCALIDADE=l.IDLOCALIDADE ');
        $statement->bindParam(':fiscal', $Fiscal);
        $statement->execute();
        $r = '';

        while ($linhas = $statement->fetch()) {

            $r.= '<option value="' . $linhas['IDLOCALIDADE'] . '" >'. $linhas['ENDERECO'] . '</option>';

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;

    case 'Combobox_Localidade':


        $statement = $pdo->prepare('SELECT * FROM localidade WHERE  STATUS = 1 ');
        $statement->execute();
        $r = '';

        while ($linhas = $statement->fetch()) {

            $r.= '<option value="' . $linhas['IDLOCALIDADE'] . '" >'. $linhas['ENDERECO'] . '</option>';

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;

        case 'Altera_Localidade' :

        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {
            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $Codigo                 = $_POST['Txt_Codigo'];
            $QtdVaga             = $_POST['ATxt_QtdVagas'];
            $Cep                 = $_POST['ATxt_Cep'];
            $Logradouro          = $_POST['ATxt_Logradouro'];
            $Bairro              = $_POST['ATxt_Bairro'];
            $Cidade              = $_POST['ATxt_Cidade'];
            $Uf                  = $_POST['ATxt_Uf'];
           

            if ((($QtdVaga>=1)) && (!empty($Cep))&& (!empty($Logradouro)) ) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('UPDATE  localidade SET QTD_VAGAS=:qtdvaga,ENDERECO=:logradouro,BAIRRO=:bairro,CIDADE=:cidade,
                UF=:uf,CEP=:cep WHERE IDLOCALIDADE=:codigo' );
                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':qtdvaga', $QtdVaga);
                $statement->bindParam(':cep', $Cep);
                $statement->bindParam(':logradouro', $Logradouro);
                $statement->bindParam(':bairro', $Bairro);
                $statement->bindParam(':cidade', $Cidade);
                $statement->bindParam(':uf', $Uf);
                $statement->bindParam(':codigo', $Codigo);

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

    case 'Salva_Localidade' :
        if( $_SESSION['NIVEL']=='A'|| $_SESSION['NIVEL']=='S') {
            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $QtdVaga             = $_POST['Txt_QtdVagas'];
            $Cep                 = $_POST['Txt_Cep'];
            $Logradouro          = $_POST['Txt_Logradouro'];
            $Bairro              = $_POST['Txt_Bairro'];
            $Cidade              = $_POST['Txt_Cidade'];
            $Uf                  = $_POST['Txt_Uf'];
            $Status  = 1;

            if ((($QtdVaga>=1)) && (!empty($Cep))&& (!empty($Logradouro)) ) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO localidade (QTD_VAGAS,ENDERECO,BAIRRO,CIDADE,UF,CEP,STATUS) VALUES
                                                                              (:qtdvaga,:logradouro,:bairro,:cidade,:uf,:cep,:status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':qtdvaga', $QtdVaga);
                $statement->bindParam(':cep', $Cep);
                $statement->bindParam(':logradouro', $Logradouro);
                $statement->bindParam(':bairro', $Bairro);
                $statement->bindParam(':cidade', $Cidade);
                $statement->bindParam(':uf', $Uf);
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


    case 'Busca_Localidade_Tabela' :

            $stmt = $pdo->prepare('SELECT * FROM localidade ');
            $executa = $stmt->execute();
            $Fiscal = array();

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
                      <a class="dropdown-item" id="btnExcluir"  codigo ="'.$linha['IDLOCALIDADE'].'"  href="#">
                      <i class="fa fa-trash"> Excluir </i> </a>
                      <a class="dropdown-item" id="btnEditar"  codigo ="'.$linha['IDLOCALIDADE'].'"  href="#">
                      <i class="fa fa-pencil"> Editar </i> </a>
                    </div>
                  </div>';


             //   $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDFISCAL'] . "' class='btn btn-warning'><i class='fa fa-pencil'></i></button>";
             //   $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['IDFISCAL'] . "' class=' btn btn-danger'><i class='fa fa-trash'></i></button>";

                $f= array('QtdVagas' => $linha['QTD_VAGAS'],'Endereco' => $linha['ENDERECO'], 'Status' => $Status, 'Html_Acao' => $botao);
                array_push($Fiscal, $f);

            }

            $Resultado['Html'] = $Fiscal;
            echo json_encode($Resultado);

    break ;

    case 'Busca_Localidade_Formulario' :

        $IdLocalidade = $_POST['Cod_Localidade'];
        $stmt = $pdo->prepare( 'SELECT * FROM localidade  WHERE IDLOCALIDADE= :idlocalidade');
        $stmt ->bindParam( ':idlocalidade', $IdLocalidade );
        $executa=$stmt->execute();
        while ($linha = $stmt->fetch()) {
            $c = array('QtdVagas' => $linha['QTD_VAGAS'],'Endereco' => $linha['ENDERECO'],
            'Bairro' => $linha['BAIRRO'],'Cidade' => $linha['CIDADE'],'Uf' => $linha['UF'],'Cep' => $linha['CEP']);
                    }
        $Resultado['Html'] = $c;
        echo json_encode($Resultado);

        break ;


    case 'Exclui_Localidade' :

        $Cod_Id = $_POST['Cod_Localidade'];
        $stmt = $pdo->prepare( 'UPDATE localidade SET STATUS =0  WHERE IDLOCALIDADE = :id');
        $stmt ->bindParam( ':id', $Cod_Id );
        if($stmt->execute()){
            $Cod_Error = 0;
        }

        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

