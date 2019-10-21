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

    case 'Combobox_AgenteFiscalizador' :

        $statement = $pdo->prepare('SELECT * FROM agentefiscalizador WHERE STATUS = 1 ORDER BY FISCALIZADOR');
        $statement->execute();
        $r = '<option value="0" >SELECIONE AGENTE</option>';

        while ($linhas = $statement->fetch()) {

            $r.= '<option value="' . $linhas['ID'] . '" >' . $linhas['FISCALIZADOR'] . '</option>';

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;

    case 'Combobox_localFiscal' :
    
    if($_SESSION['NIVEL']=="U" || $_SESSION['NIVEL']=="F"){
        $Fiscal    ='%';
     }else{
        $Fiscal =$_SESSION['ID_USUARIO'];
     }
        $statement = $pdo->prepare('SELECT d.QTD_VAGAS,d.ENDERECO,l.IDLOCALFISCAL FROM localfiscal l,localidade d WHERE
                                                          l.ID_LOCALIDADE=d.IDLOCALIDADE 
                                                        AND l.ID_FISCAL LIKE :idfiscal AND l.STATUS = 1 ');
        $statement->bindParam(':idfiscal', $Fiscal);
        $statement->execute();
        $r = '';
        $Status ='A';

        while ($linhas = $statement->fetch()) {

            $st = $pdo->prepare('SELECT COUNT(IDTICKET) AS Ocupadas FROM ticket WHERE 
                               ID_LOCALFISCAL =:idlocalfiscal AND STATUS = :status ');
            $st->bindParam(':status', $Status);
            $st->bindParam(':idlocalfiscal', $linhas['IDLOCALFISCAL']);
            $st->execute();
            $linhaocupada = $st->fetch();
            $VagasOcupadas = $linhaocupada['Ocupadas'];

            $VagaDisponivel = $linhas['QTD_VAGAS'] - $VagasOcupadas ;

            if($VagaDisponivel >=1){
                $r.= '<option value="'.$linhas['IDLOCALFISCAL'].'" >'. $linhas['ENDERECO'] . '- <b> '.$VagaDisponivel.' VAGAS</b> </option>';

            }else{
                $r.= '<option value="0" > SEM VAGAS</b> </option>';

            }

        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break ;


    case 'Salva_LocalFiscal' :
        if( $_SESSION['NIVEL']=='A') {
            // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
            $Fiscal              = $_POST['Txt_Fiscal'];
            $Localidade          = $_POST['Txt_Local'];
            $Status  = 1;

            if ((($Fiscal>=1)) && (($Localidade>=1))) {

                // Prepara uma senten�a para ser executada
                $statement = $pdo->prepare('INSERT INTO localfiscal (ID_FISCAL,ID_LOCALIDADE,STATUS) VALUES
                                                                              (:idfiscal,:localidade,:status)');

                // Adiciona os dados acima para serem executados na senten�a
                $statement->bindParam(':idfiscal', $Fiscal);
                $statement->bindParam(':localidade', $Localidade);
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


    case 'Busca_LocalFiscal_Tabela' :


            $stmt = $pdo->prepare('SELECT * ,l.STATUS as status FROM usuarios u ,localfiscal l ,localidade d WHERE l.ID_LOCALIDADE=d.IDLOCALIDADE AND 
               u.IDUSUARIO=l.ID_FISCAL');
            $executa = $stmt->execute();
            $Fiscal = array();

            while ($linha = $stmt->fetch()) {
                if ($linha['status'] == 1) {
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
                      <a class="dropdown-item" id="btnExcluir"  codigo ="'.$linha['IDLOCALFISCAL'].'"  href="#">
                      <i class="fa fa-trash"> Excluir </i> </a>
                      <a class="dropdown-item" id="btnEditar"  codigo ="'.$linha['IDLOCALFISCAL'].'"  href="#">
                      <i class="fa fa-pencil"> Editar </i> </a>
                    </div>
                  </div>';


             //   $botaoEdit = "<button id='btnEditar'   codigo ='" . $linha['IDFISCAL'] . "' class='btn btn-warning'><i class='fa fa-pencil'></i></button>";
             //   $botaoExcluir = "<button id='btnExcluir'  codigo ='" . $linha['IDFISCAL'] . "' class=' btn btn-danger'><i class='fa fa-trash'></i></button>";

                $f= array('Nome' => $linha['NOME'],'Rua' => $linha['ENDERECO'], 'Status' => $Status, 'Html_Acao' => $botao);
                array_push($Fiscal, $f);

            }

            $Resultado['Html'] = $Fiscal;
            echo json_encode($Resultado);

    break ;

    case 'Busca_LocalFiscal_Formulario' :

        $Cod_LocalFiscal= $_POST['Cod_LocalFiscal'];
        $stmt = $pdo->prepare( 'SELECT * FROM localfiscal  WHERE IDLOCALFISCAL= :codlocalfiscal');
        $stmt ->bindParam( ':codlocalfiscal', $Cod_LocalFiscal );
        $executa=$stmt->execute();
        while ($linha = $stmt->fetch()) {
            $c = array('Fiscal' => $linha['ID_FISCAL'],'Local' => $linha['ID_LOCALIDADE']);
                    }
        $Resultado['Html'] = $c;
        echo json_encode($Resultado);

        break ;

    case 'Exclui_LocalFiscal' :

        $Cod_LocalFiscal = $_POST['Cod_LocalFiscal'];
        $stmt = $pdo->prepare( 'UPDATE localfiscal SET STATUS = 0  WHERE IDLOCALFISCAL= :codlocalfiscal');
        $stmt ->bindParam( ':codlocalfiscal', $Cod_LocalFiscal );
        if($stmt->execute()){
                    $Cod_Error = 0;
        }

        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break ;
}

