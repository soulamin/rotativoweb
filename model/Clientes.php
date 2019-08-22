<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 26/10/2017
 * Time: 17:26
 */
require '../fontes/conexao.php';
require 'FuncaoData.php';

session_start();
$acao = $_POST['acao'];

switch($acao){

    case 'Salva_Cliente' :
        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)

        $Senha                = $_POST['Txt_Senha'];
        $Cliente              = $_POST['Txt_Nome'];
        $DataNasc             = $_POST['Txt_DataNasc'];
        $Sexo                 = $_POST['Txt_Sexo'];
        $Rg                   = $_POST['Txt_Rg'];
        $Cpf                  = $_POST['Txt_Cpf'];
        $Email                = $_POST['Txt_Email'];
        $Telefone             = $_POST['Txt_Telefone'];
        $Celular              = $_POST['Txt_Celular'];
        $Status               = 1;


        if( (!empty($Cliente)) && (!empty($Email)) && (!empty($Celular))&& (!empty($Telefone))){


                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO  cliente (NOME,DATANASC,SEXO,RG,CPF,EMAIL,SENHA,TELEFONE,CELULAR,STATUS)VALUES 
                                                                  ( :cliente ,:datanasc , :sexo ,:rg, :cpf ,:email,:senha,:telefone,:celular,:status)');


                 $statement->bindParam(':cliente', $Cliente);
                 $statement->bindParam(':datanasc',  PdBd($DataNasc));
                 $statement->bindParam(':sexo',  $Sexo);
                 $statement->bindParam(':rg', $Rg);
                 $statement->bindParam(':cpf',  $Cpf);
                 $statement->bindParam(':email', $Email);
                 $statement->bindParam(':celular', $Celular);
                 $statement->bindParam(':telefone', $Telefone);
                 $statement->bindParam(':senha',  md5($Senha));
                 $statement->bindParam(':status',  $Status);


            // Executa a senten�a j� com os valores
            if($statement->execute()){
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Dados já cadastrado  </h4>
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

    case 'Altera_Cliente' :
        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $IdCliente            = $_POST['Txt_Codigo'];
        $Cliente              = $_POST['ATxt_Nome'];
        $DataNasc             = $_POST['ATxt_DataNasc'];
        $Sexo                 = $_POST['ATxt_Sexo'];
        $Rg                   = $_POST['ATxt_Rg'];
        $Cpf                  = $_POST['ATxt_Cpf'];
        $Email                = $_POST['ATxt_Email'];
        $Telefone             = $_POST['ATxt_Telefone'];
        $Celular              = $_POST['ATxt_Celular'];



        if( (!empty($Cliente)) && (!empty($Email)) && (!empty($Celular))&& (!empty($Telefone))){


            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE cliente SET NOME=:cliente ,DATANASC=:datanasc,SEXO=:sexo,RG=:rg,CPF=:cpf ,
                                                    EMAIL=:email,TELEFONE = :telefone,CELULAR=:celular 
                                                               WHERE IDCLIENTE = :idcliente');


            $statement->bindParam(':cliente', $Cliente);
            $statement->bindParam(':datanasc',  PdBd($DataNasc));
            $statement->bindParam(':sexo',  $Sexo);
            $statement->bindParam(':rg', $Rg);
            $statement->bindParam(':cpf',  $Cpf);
            $statement->bindParam(':email', $Email);
            $statement->bindParam(':celular', $Celular);
            $statement->bindParam(':telefone', $Telefone);
            $statement->bindParam(':idcliente', $IdCliente);

            // Executa a senten�a j� com os valores
            if($statement->execute()){
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";

            }else{
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i>Dados já cadastrados!  </h4>
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

    case 'Busca_Clientes_Tabela' :

            $stmt = $pdo->prepare( 'SELECT NOME ,STATUS ,SEXO ,IDCLIENTE FROM cliente ORDER BY NOME ');

        $executa=$stmt->execute();
        $Clientes = array();

        while ($linha = $stmt->fetch()) {
             $botaoExcluir = "<button id='btnExcluir'   codigo ='" . $linha['IDCLIENTE'] . "' class='btn btn-danger glyphicon glyphicon-trash'></button>";
             $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDCLIENTE'] . "' class='btn btn-warning glyphicon glyphicon-pencil'></button>";

            if($linha['STATUS']== '1'){
                $Status = '<span class="label label-success">Ativo</span>';

            }else{

                $Status = '<span class="label label-danger">Desativado</span>';
            }

            $C =  '<div class="col-md-4">
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header bg-gray-active">
                  <!-- /.widget-user-image -->
                      <h4 class="widget-user-username"><i class="fa fa-users"></i>' .strtoupper($linha['NOME']).'</h4>
                                           
                 </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li> '.$Status.'<span class="pull-right ">'.$botaoEdit.' '.$botaoExcluir.'</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>';
            array_push($Clientes, $C);
        }

        $Resultado['Html'] = $Clientes;
        echo json_encode($Resultado);

        break ;



    case 'Busca_Cliente_Formulario' :

        $Cod_Cliente = $_POST['Cod_Cliente'];
        $stmt = $pdo->prepare( 'SELECT *  FROM cliente   WHERE IDCLIENTE =:codcliente');
        $stmt ->bindParam( ':codcliente', $Cod_Cliente);
        $executa=$stmt->execute();

        while ($linha = $stmt->fetch()) {

            if($linha['SEXO']=='M'){
                $Sexo ='<option value="M" selected >MASCULINO</option>';
            }else{
                $Sexo ='<option value="F" selected >FEMININO</option>';
            }



            $M = array('Codigo' => $linha['IDCLIENTE'],'Nome' => $linha['NOME'],'Sexo' => $Sexo,'DataNasc' =>PdBrasil($linha['DATANASC']),
                'Telefone' => $linha['TELEFONE'],'Celular' => $linha['CELULAR'],
                'Rg' => $linha['RG'],'Cpf' => $linha['CPF'], 'Email' => $linha['EMAIL']);

        }
        $Resultado['Html'] = $M;
        echo json_encode($Resultado);

        break;

    //Desativa o Cliente Status
    case 'Exclui_Clientes' :

        $Cod_Cliente = $_POST['Cod_Cliente'];
        $stmt = $pdo->prepare( 'UPDATE cliente SET STATUS = 0  WHERE IDCLIENTE= :Cod_Cliente');
        $stmt ->bindParam( ':Cod_Cliente', $Cod_Cliente );
        if($stmt->execute()){
            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;


}



