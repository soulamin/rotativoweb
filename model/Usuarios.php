<?php

/**
 * Created by PhpStorm.
 * User: ALAN
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';
require '../EnvioEmail/Enviar.php';
session_start();
$acao = $_POST['acao'];

switch ($acao) {

    case 'Salva_Usuario':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Nome = $_POST['Txt_Nome'];
        $Email = $_POST['Txt_Email'];
        $Login = $_POST['Txt_Login'];
        $Senha = $_POST['Txt_Senha'];
        $Tipo = $_POST['Txt_Tipo'];
        $Celular = $_POST['Txt_Celular'];
        $Telefone = $_POST['Txt_Telefone'];
        $Cpf = $_POST['Txt_Cpf'];
        $Status = 1;
        $Saldo = 0.00;

        if ((!empty($Nome)) && (!empty($Login)) && (!empty($Senha))) {

            //Caso queira altera a senha do usuario

            $Senha = md5($_POST['Txt_Senha']);
            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('INSERT INTO  usuarios (NOME,LOGIN,SENHA,CPF,DATA_IN,EMAIL,TELEFONE,CELULAR,NIVEL,STATUS,LAST_LOG,SALDO)VALUES
                                             (:nome ,:login , :senha ,:cpf,CURRENT_TIMESTAMP ,:email,:telefone,:celular,:tipo,:status,CURRENT_TIMESTAMP,:saldo)');
            $statement->bindParam(':nome', $Nome);
            $statement->bindParam(':senha', $Senha);
            $statement->bindParam(':tipo', $Tipo);
            $statement->bindParam(':telefone', $Telefone);
            $statement->bindParam(':celular', $Celular);
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':status', $Status);
            $statement->bindParam(':email', $Email);
            $statement->bindParam(':cpf', $Cpf);
            $statement->bindParam(':saldo', $Saldo);


            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                       <h4><i class='icon fa fa-check'></i>
                            Cadastro Realizado com Sucesso! </h4></div>";
            } else {
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                   <h4><i class='icon fa fa-ban'></i> Usuário já Cadastro!  </h4>
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

    case 'Salva_UsuarioCadastro':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Nome = $_POST['Txt_Nome'];
        $Email = $_POST['Txt_Email'];
        $Login = $_POST['Txt_Login'];
        $Senha = $_POST['Txt_Senha'];
        $Tipo = $_POST['Txt_Tipo'];
        $Celular = $_POST['Txt_Celular'];
        $Placa = $_POST['Txt_Placa'];
        $Cpf = $_POST['Txt_Cpf'];
        $Telefone = $_POST['Txt_Telefone'];
        $Status = 1;


        if ((!empty($Nome)) && (!empty($Login)) && (!empty($Senha)) && (!empty($Placa))) {

            //Caso queira altera a senha do usuario

            $Senha = md5($_POST['Txt_Senha']);
            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('INSERT INTO  usuarios (NOME,LOGIN,SENHA,DATA_IN,EMAIL,TELEFONE,CELULAR,NIVEL,STATUS,LAST_LOG,CPF)VALUES
                                                     (:nome ,:login , :senha ,CURRENT_TIMESTAMP ,:email,:telefone,:celular,:tipo,:status,CURRENT_TIMESTAMP,:cpf)');
            $statement->bindParam(':nome', $Nome);
            $statement->bindParam(':senha', $Senha);
            $statement->bindParam(':tipo', $Tipo);
            $statement->bindParam(':telefone', $Telefone);
            $statement->bindParam(':celular', $Celular);
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':status', $Status);
            $statement->bindParam(':email', $Email);
            $statement->bindParam(':cpf', $Cpf);

            // Executa a senten�a j� com os valores
            if ($exec1 = $statement->execute()) {
                $IdUsuario = $pdo->lastInsertId();
                $st = $pdo->prepare('INSERT INTO placausuario (PLACA,ID_USUARIO,STATUS) VALUES (:placa,:idusuario ,:status)');
                $st->bindParam(':idusuario', $IdUsuario);
                $st->bindParam(':placa', $Placa);
                $st->bindParam(':status', $Status);
                $st->execute();

                // Definimos a mensagem de sucesso
                $Cod_Error = 0;


                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";
            } else {
                $Cod_Error = '1';
                $Html = "<div class='alert alert-danger disable alert-dismissable'>
                           <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                           <h4><i class='icon fa fa-ban'></i> Usuário já Cadastro!  </h4>
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


    case 'Altera_Usuario':

        // Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
        $Codigo               = $_POST['ATxt_Codigo'];
        $Nome                 = $_POST['ATxt_Nome'];
        $Login                = $_POST['ATxt_Login'];
        $Celular              = $_POST['ATxt_Celular'];
        $Cpf                  = $_POST['ATxt_Cpf'];
        $Email                  = $_POST['ATxt_Email'];


        if ((!empty($Nome)) && (!empty($Login)) && (!empty($Cpf)) && (!empty($Email))) {


            // Prepara uma senten�a para ser executada
            $statement = $pdo->prepare('UPDATE  usuarios  SET CPF= :cpf , NOME = :nome ,
                              LOGIN = :login ,CELULAR =:celular ,EMAIL =:email WHERE IDUSUARIO = :codigo');


            $statement->bindParam(':codigo',  $Codigo);
            $statement->bindParam(':nome', $Nome);
            $statement->bindParam(':login', $Login);
            $statement->bindParam(':celular',  $Celular);
            $statement->bindParam(':cpf',  $Cpf);
            $statement->bindParam(':email',  $Email);


            // Executa a senten�a j� com os valores
            if ($statement->execute()) {
                // Definimos a mensagem de sucesso
                $Cod_Error = 0;
                $Html = "<div class='alert alert-success'>
                               <h4><i class='icon fa fa-check'></i>
                                    Cadastro Realizado com Sucesso! </h4></div>";
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

    case 'Busca_Usuarios_Tabela':


        $stmt = $pdo->prepare('SELECT *  FROM usuarios WHERE NIVEL != "U" ');

        $executa = $stmt->execute();
        $Usuarios = array();

        while ($linha = $stmt->fetch()) {

            $botao =   '<div class="btn-group">
                    <button type="button" class="btn btn-warning">Ação</button>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" id="btnExcluir"  codigo ="' . $linha['IDUSUARIO'] . '"  href="#">
                      <i class="fa fa-trash"> Excluir </i> </a>
                      <a class="dropdown-item" id="btnEditar"  codigo ="' . $linha['IDUSUARIO'] . '"  href="#">
                      <i class="fa fa-pencil"> Editar </i> </a>
                    </div>
                  </div>';


            if ($linha['NIVEL'] == 'A') {
                $Nivel = 'ADMINISTRADOR';
            } elseif ($linha['NIVEL'] == 'G') {

                $Nivel = 'GUARDADOR';
            } elseif ($linha['NIVEL'] == 'F') {

                $Nivel = 'AGENTE FISCAL';
            } else {
                $Nivel = 'USUÁRIO';
            }

            if ($linha['STATUS'] == '1') {
                $Status = '<span class="badge badge-success">Ativo</span>';
            } else {

                $Status = '<span class="badge badge-danger">Desativado</span>';
            }
            $U = array('Nome' => $linha['NOME'], 'Login' => $linha['LOGIN'],  'Nivel' => $Nivel, 'Status' => $Status, 'Html_Acao' => $botao);
            array_push($Usuarios, $U);
        }

        $Resultado['Html'] = $Usuarios;
        echo json_encode($Resultado);

        break;

    case 'Busca_Usuario_Formulario':

        if ($_SESSION['NIVEL'] != 'A') {
            $Usuario = $_SESSION['ID_USUARIO'];
        } else {
            $Usuario = $_POST['Cod_Usuario'];
        }
        $stmt = $pdo->prepare('SELECT U.* FROM usuarios U  WHERE IDUSUARIO LIKE :usuario');
        $stmt->bindParam(':usuario', $Usuario);
        $executa = $stmt->execute();

        while ($linha = $stmt->fetch()) {
            $usuario = array(
                'Nome' => $linha['NOME'], 'Email' => $linha['EMAIL'], 'Login' => $linha['LOGIN'], 'Cpf' => $linha['CPF'],
                'Celular' => $linha['CELULAR'], 'Codigo' => $linha['IDUSUARIO'], 'Telefone' => $linha['TELEFONE']
            );
        }
        $Resultado['Html'] = $usuario;
        echo json_encode($Resultado);
        break;

    case 'Exclui_Usuario':

        $Cod_Usuario = $_POST['Cod_Usuario'];
        $stmt = $pdo->prepare('UPDATE usuarios SET STATUS = 0  WHERE IDUSUARIO= :Cod_Usuario');
        $stmt->bindParam(':Cod_Usuario', $Cod_Usuario);
        if ($stmt->execute()) {

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

    case 'Exclui_PlacaUsuario':

        $Cod_PlacaUsuario = $_POST['Cod_PlacaUsuario'];
        $stmt = $pdo->prepare('UPDATE placausuario SET STATUS = 0  WHERE IDPLACAUSUARIO= :Cod_PlacaUsuario');
        $stmt->bindParam(':Cod_PlacaUsuario', $Cod_PlacaUsuario);
        if ($stmt->execute()) {

            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;


    case 'Salva_PlacaUsuario':

        $IdUsuario = $_POST['Id_Usuario'];
        $Placa = $_POST['Placa'];
        $Status = 1;

        $sts = $pdo->prepare('SELECT COUNT(ID_USUARIO) AS QTD FROM placausuario WHERE PLACA=:placa AND ID_USUARIO=:idusuario');
        $sts->bindParam(':idusuario', $IdUsuario);
        $sts->bindParam(':placa', $Placa);
        $sts->execute();
        $linhas = $sts->fetch();

        if ($linhas['QTD'] == 0) {
            $st = $pdo->prepare('INSERT INTO placausuario (PLACA,ID_USUARIO,STATUS) VALUES (:placa,:idusuario ,:status)');
            $st->bindParam(':idusuario', $IdUsuario);
            $st->bindParam(':placa', $Placa);
            $st->bindParam(':status', $Status);
            // Definimos a mensagem de sucesso
            if ($st->execute()) {
                $Cod_Error = 0;
            }
        } else {
            $Cod_Error = 1;
        }

        $Resultado['Cod_Error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

        case 'UsuarioToken':

        $IdUsuario = $_SESSION['ID_USUARIO'];
        $Status = 1;
        $sts = $pdo->prepare('SELECT  * FROM token WHERE STATUS=:status AND ID_USUARIO=:idusuario');
        $sts->bindParam(':idusuario', $IdUsuario);
        $sts->bindParam(':status', $Status);
        $sts->execute();
        $Token ='';
        if($sts->rowCount()>=1){
            while($linhas = $sts->fetch()){
            $Token .= '<option value="'.$linhas["IDTOKEN"].'">CARTÃO FINAL '.$linhas["CARTAO"].'- VAL.'.$linhas["VAL"].' </option>';
            }
            $Cod_Error = 0;
        }
        else {
            $Cod_Error = 1;
        }
        $Token .= '<option value="#">Novo Cartão </option>';

        $Resultado['Html'] = $Token;
        echo json_encode($Resultado);

        break;


    case 'Resetar_Senha':

        $Cod_Usuario = $_POST['Cod_Usuario'];
        $Senha = md5(12345);
        $stmt = $pdo->prepare('UPDATE usuarios SET SENHA =:senha  WHERE IDUSUARIO= :Cod_Usuario');
        $stmt->bindParam(':Cod_Usuario', $Cod_Usuario);
        $stmt->bindParam(':senha', $Senha);
        if ($stmt->execute()) {
            $Cod_Error = 0;
        }
        $Resultado['Cod_error'] = $Cod_Error;
        echo json_encode($Resultado);

        break;

    case 'Combobox_Fiscal':

        $statement = $pdo->prepare('SELECT * FROM usuarios WHERE STATUS = 1 AND NIVEL IN("G" ,"F") ORDER BY NOME ASC');
        $statement->execute();

        $r = '<option value="0" >SELECIONE GUARDADOR</option>';
        while ($linhas = $statement->fetch()) {

            $r .= '<option value="' . $linhas['IDUSUARIO'] . '" >' . $linhas['NOME'] . '</option>';
        }
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;

    case 'MinhasPlacas':
        $Id_Usuario = $_SESSION['ID_USUARIO'];
        $statement = $pdo->prepare('SELECT P.PLACA ,P.IDPLACAUSUARIO FROM   placausuario P WHERE P.ID_USUARIO =:idusuario AND P.STATUS = 1');
        $statement->bindParam(':idusuario', $Id_Usuario);
        $statement->execute();

        $r = '';

        while ($linhas = $statement->fetch()) {

            $r .= '<div class="col-md-3 col-sm-6">
                     <div class="small-box bg-gray">
                            <div class="inner text-center">
                            <h3>' . $linhas['PLACA'] . '</h3>
                            </div>
                           <a href="#" class="small-box-footer btnExcluirPlacaUsuario text-danger" codigo ="' . $linhas['IDPLACAUSUARIO'] . '">Excluir <i class="fa fa-trash "></i></a>
                       </div>
                    </div>';
        }

        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;


    case 'Combobox_PlacaUsuario':
        $Id_Usuario = $_SESSION['ID_USUARIO'];
        $statement = $pdo->prepare('SELECT P.PLACA , U.SALDO  FROM usuarios U ,placausuario  P 
        WHERE P.ID_USUARIO=U.IDUSUARIO AND U.IDUSUARIO =:idusuario AND P.STATUS = 1');
        $statement->bindParam(':idusuario', $Id_Usuario);
        $statement->execute();

        $r = '';

        while ($linhas = $statement->fetch()) {
            $Saldo = 'Saldo Atual R$ ' . number_format($linhas['SALDO'], 2, ",", "");
            $r .= '<option value="' . $linhas['PLACA'] . '" >' . $linhas['PLACA'] . '</option>';
        }
        $resultado['Saldo'] = $Saldo;
        $resultado['Html'] = $r;
        echo json_encode($resultado);

        break;

    case 'EsqueciaSenha':

        $NovaSenha = substr(md5(date('YdHis')),0,5);
        $Email = trim($_POST['Email']);
        $statement = $pdo->prepare('SELECT  IDUSUARIO,NOME , LOGIN FROM usuarios WHERE EMAIL =:email AND NIVEL = "U" AND STATUS = 1');
        $statement->bindParam(':email', $Email);
        $statement->execute();
        if($statement->rowCount() >= 1){
           $LinhaEmail= $statement->fetch();
           
             $Nome =   $LinhaEmail['NOME'];
             $Login =  $LinhaEmail['LOGIN'];
                $st1 = $pdo->prepare('UPDATE usuarios SET SENHA = :senha WHERE NIVEL = "U" AND EMAIL = :email');
                $st1->bindParam(':email', $Email);
                $st1->bindParam(':senha', md5($NovaSenha));
                $st1->execute();
                EnviaEmail($Nome,$Email,$Login,$NovaSenha) ;
                $Cod_Error='0'; 
                $Html = "<div class='alert alert-warning disable alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-exclamation'></i> 'Foi enviado um Email com seu Usuário e Senha Cadastrado'  </h4>
                </div>";
        }else{
                $Cod_Error='1';
                $Html = "<div class='alert alert-info disable alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-exclamation'></i> Não Encontramos esse Email cadastrado.  </h4>
                </div>";
        }
        $resultado['Html'] =  $Html;
        $resultado['Cod_Error'] =  $Cod_Error;
        echo json_encode($resultado);

        break;
}
