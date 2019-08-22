<?php
/**
 * Created by PhpStorm.
 * User: Alan Lamin
 * Date: 23/10/2016
 * Time: 11:42
 */
require '../fontes/conexao.php';
include 'InsereArquivo.php';
session_start();
$acao = $_POST['acao'];

switch($acao){

    case 'UrlNotaFiscal' :

        $statement = $pdo->prepare('SELECT URLNOTAFISCAL FROM empresa ');
        $statement->execute();
        $linhaNotafiscal= $statement->fetch();
        $resultado['Html'] = $linhaNotafiscal['URLNOTAFISCAL'];
        echo json_encode($resultado);

        break ;

    case 'Altera_Empresa' :

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo              = $_POST['Txt_Codigo'];
        $Nome_Empresa        = $_POST['ATxt_Nome'];
        $Email               = $_POST['ATxt_Email'];
        $Telefone            = $_POST['ATxt_Telefone'];
        $Celular             = $_POST['ATxt_Celular'];
        $Cnpj                = $_POST['ATxt_Cnpj'];
        $Cep                 = $_POST['ATxt_Cep'];
        $Logradouro          = $_POST['ATxt_Logradouro'];
        $Numero              = $_POST['ATxt_Numero'];
        $Compl               = $_POST['ATxt_Compl'];
        $Bairro              = $_POST['ATxt_Bairro'];
        $Cidade              = $_POST['ATxt_Cidade'];
        $Uf                  = $_POST['ATxt_Uf'];



        if( (!empty($Nome_Empresa)) && (!empty($Cnpj)) ){

            if (!isset($_FILES['Txt_Logo']['name'])) {

                $Arquivo_Logo = 'X.jpg';

            } else {

                $Arquivo_Logo = InserirArquivo('Foto', $_FILES['Txt_Logo']['name'], $_FILES['Txt_Logo']['tmp_name'], $_FILES['Txt_Logo']['size'], $_FILES['Txt_Logo']['type']);

            }
            if ( $Arquivo_Logo == FALSE) {

                $Cod_Error = 1;
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                 <h4><i class='icon fa fa-ban'></i> Verifique o Tamanho e a Extensão do Arquivo!</h4></div>";
                $Cod_Projeto = 0;
            } else {


                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('UPDATE empresa SET NOME=:nome,TELEFONE=:telefone,CELULAR=:celular,
                                                               EMAIL=:email,CNPJ=:cnpj,CEP=:cep,LOGRADOURO=:logradouro,NUM=:numero,
                                                               LOGO=:logo,COMPLEMENTO=:compl,BAIRRO=:bairro,CIDADE=:cidade,
                                                               UF=:uf
                                                                WHERE IDEMPRESA = :idempresa');


                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':idempresa', $Codigo);
                $statement->bindParam(':nome', $Nome_Empresa);
                $statement->bindParam(':cnpj', $Cnpj);
                $statement->bindParam(':telefone', $Telefone);
                $statement->bindParam(':celular', $Celular);
                $statement->bindParam(':email', $Email);
                $statement->bindParam(':cep', $Cep);
                $statement->bindParam(':logradouro', $Logradouro);
                $statement->bindParam(':logo', $Arquivo_Logo);
                $statement->bindParam(':numero', $Numero);
                $statement->bindParam(':compl', $Compl);
                $statement->bindParam(':bairro', $Bairro);
                $statement->bindParam(':cidade', $Cidade);
                $statement->bindParam(':uf', $Uf);



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

    case 'Combobox_Empresas' :

        $statement = $pdo->prepare('SELECT IDEMPRESA ,NOME FROM empresa WHERE  STATUS = 1');
        $statement->execute();
        while ($linhas = $statement->fetch()) {

            $e= '<option value="'.$linhas['IDEMPRESA'].'" >'.strtoupper($linhas['NOME']).'</option>';
            //array_push($empresa, $e);
        }
        $resultado['Html'] = $e;
        echo json_encode($resultado);

        break ;

    case 'Busca_Empresas_Tabela' :

        if($_SESSION['NIVEL']!='A'){
            session_destroy();
        }else{
                $stmt = $pdo->prepare( 'SELECT * FROM empresa');
                $executa=$stmt->execute();
                $Empresa = array();

                while ($linha = $stmt->fetch()) {

                    if($linha['STATUS']== '1'){
                        $Status = '<span class="badge badge-success">Ativo</span>';

                    }else{

                        $Status = '<span class="badge badge-danger">Desativado</span>';
                    }

                    $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDEMPRESA'] . "' class='btn btn-warning'> <i class='fa fa-pencil'> Editar</button>";

                    $e =  array('Empresa' => $linha['NOME'], 'Status' => $Status,'Html_Acao' => $botaoEdit);
                    array_push($Empresa, $e);
                }
    }
        $Resultado['Html'] = $Empresa;
        echo json_encode($Resultado);

        break ;

    case 'Busca_Empresa_Formulario' :

        $Empresa = $_POST['Cod_Empresa'];
        $stmt = $pdo->prepare( 'SELECT * FROM empresa WHERE IDEMPRESA  = :Cod_Empresa');
        $stmt ->bindParam( ':Cod_Empresa', $Empresa );
        $executa=$stmt->execute();

        while ($linha = $stmt->fetch()) {


            if( $linha['LOGO'] == ''){

                $ArqLogo ='<input type="file"  PLACEHOLDER="LOGO EMPRESA" name="Txt_Logo" >
                           <p class="help-block">LOGO EMPRESA (Somente Extensão .png,.jpeg,.jpg).</p>';

            } else {

                $ArqLogo ='<label>Logo .:</label>
                                <img height="100px" width="100px" class="img-responsive" src ="../'.$linha['LOGO'].'">
                           <span codigo="../'.$linha['LOGO'].'" id="BtnExcluirLogo"> <a href="#"> 
                           <i class="glyphicon glyphicon-trash text-red" > Excluir</i></a>';

            }


            $re = array('Nome' => $linha['NOME'],'Logo'=>$ArqLogo,'Descricao' => $linha['DESCRICAO'],'Cnpj' => $linha['CNPJ'],'Telefone' => $linha['TELEFONE'],
                'Celular' => $linha['CELULAR'],'Email' => $linha['EMAIL'],'Cep' => $linha['CEP'],'Logradouro' => $linha['LOGRADOURO'],'Num' => $linha['NUM'],
                'Complemento' => $linha['COMPLEMENTO'],'Bairro' => $linha['BAIRRO'],'Cidade' => $linha['CIDADE'],'Uf' => $linha['UF'],'Telefone' => $linha['TELEFONE']);
        }

        $Resultado['Html'] = $re;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_Logo' :

        $NomeArquivo = $_POST['Arquivo'];
        $Codigo = $_POST['Codigo'];
        date_default_timezone_set('America/Sao_Paulo');
        if(unlink($NomeArquivo)){

            $Cod_Error = 0;
            $ArqLogo =' <input type="file"  PLACEHOLDER="LOGO EMPRESA" name="ATxt_Logo" >
                                    <p class="help-block">LOGO EMPRESA (Somente Extensão Png).</p>';
            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE  empresas SET LOGO = :logo WHERE IDEMPRESA  = :idempresa');
            $Logo = 'X.jpg';
            // Adiciona os dados acima para serem executados na senten�a
            $statement->bindParam(':idempresa', $Codigo);
            $statement->bindParam(':logo', $Logo);
            $statement->execute();

        }
        $Resultado['Arq_Logo'] = $ArqLogo;
        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_Empresa' :

        $Cod_Empresa = $_POST['Cod_Empresa'];
        $stmt = $pdo->prepare( 'UPDATE empresa SET STATUS = 0  WHERE IDEMPRESA= :Cod_Empresa');
        $stmt ->bindParam( ':Cod_Empresa', $Cod_Empresa );
        if($stmt->execute()){

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;



}

