<?php
require '../fontes/conexao.php';
require '../model/FuncaoData.php';

//
/*
//http://179.184.134.140/brtecpatio/grvD/serverX.php?
idreboquista=42
&countergrv=2
&idempresa=2
&idpatio=2
&placaveiculo=AAA4A44
&chassiveiculo=NCHASS
&corveiculo=PRATA
&marcaveiculo=VOLKSWAGEN
&tipotransporte=AUTOMOVEL
&idfiscalizador=3
&motivoapreensao=3
&text_endOp=-22.7603689,-43.4514677
&idplacareboque=12
&fcar=0
&fren=0
&fcnh=0
&flac=1
&status_grv=1
&horaop=14:38
&dataop=28/11/2018
&nomeagent=JAMES BOND
&matricuagent=MATRICULA AGE
&comchave=SIM
&imei=358502077498478
&listinfracoes=4,5,6
&listaequipa=3,4,5
&listalacre=164900
&listafotos=1543423080468.jpg,1543423088165.jpg
&idusuario=41
&autodeinfrac=AUTODEINFRACAO
*/


// Filtra os dados e armazena em vari�veis (o filtro padr�o � FILTER_SANITIZE_STRING que remove tags HTML)
$Grv                 = $_GET['idreboquista'].'/'.$_GET['countergrv'];
$CounterGrv          = $_GET['countergrv'];
$IdPatio             = $_GET['idpatio'];
$DataRemocao         = PdBd($_GET['dataop']);
$HoraRemocao         = $_GET['horaop'].':00';
$Motivo              = $_GET['motivoapreensao'];
$Reboque             = $_GET['idplacareboque'];
$Reboquista          = $_GET['idreboquista'];
$SemPlaca            = 'N';
$Datazero            ='0000-00-00';
$Horazero            ='00:00:00';
$TipoAgente          = $_GET['idfiscalizador']+1;
$MatAgente           = $_GET['matricuagent'];
$NomeAgente          = strtoupper($_GET['nomeagent']);
$Chassi              = $_GET['chassiveiculo'];
$Renavam             = '';
$UsouReboque         = 'N';
$Placa               = $_GET['placaveiculo'];
$TipoVeiculo         = $_GET['tipotransporte'];
$Cor                 = $_GET['corveiculo'];
$MarcaModelo         = strtoupper($_GET['marcaveiculo']);
$Cep                 = '';
$Endereco            = '';
$Numero              = '';
$Compl               = '';
$Bairro              = '';
$Cidade              = '';
$Uf                  = '';
$AnoFabMod           = '';
$PontoRef            = '';
$Status              = 'C' ;//Status Cadastrado
$IdUsuario           = $_GET['idusuario'];
$Id_Conferente       = 0;
$Nome               = '';
$Cpf                = '';
$Identidade         = '';
$Orgao              = '';
$Telefone           = '';
$Celular            = '';
$Email              = '';
$DocNoVeiculo       = 'N';
$ChaveVeiculo       = strtoupper($_GET['comchave']);
$NumeroChave        = '';
$InfAdic            = '';
$Assinatura         = 'S';
$Estado             = 'P';
$EstadoEquip        = 6;
$lacre              = $_GET['listalacre'];
$infracao           = $_GET['listinfracoes'];
$Numinfracao        = $_GET['autodeinfrac'];
$StatusAtivo         = 1;
$Equipamento        = $_GET['listaequipa'];
$NEquipamento       = explode(',', $Equipamento);
$cinfracao_array = explode(',', $infracao);
$ninfracao_array = explode(',', $Numinfracao);
$lacre_array     = explode(',', $lacre);
$KmReb =0;
        $stConfere = $pdo->prepare( 'SELECT count(GRV) as Qtd ,STATUS FROM grv_status WHERE GRV =:grv AND ID_PATIO =:idpatio ');
        $stConfere->bindParam(':idpatio', $IdPatio);
        $stConfere->bindParam(':grv', $Grv);
        $stConfere->execute();
        $Qtd = $stConfere->fetch();
        if($Qtd['Qtd'] >= 1){
        $Cod_Error='2'; //cadastrado

    }else{


        foreach($cinfracao_array as $CodInfracao){
            foreach($ninfracao_array as $NumeroInfracao) {
                // Prepara uma senten�a para ser executada
                $stinfra = $pdo->prepare('INSERT INTO grv_infracao (GRV,NUMINFRA,ID_CODINFRA,ID_PATIO,ID_USUARIO) VALUES
                                                                                  (:grv,:numinfra,:idcodinfra,:idpatio,:idusuario)');

                // Adiciona os dados acima para serem executados na senten�a
                $stinfra->bindParam(':grv', $Grv);
                $stinfra->bindParam(':numinfra', $NumeroInfracao);
                $stinfra->bindParam(':idcodinfra', $CodInfracao);
                $stinfra->bindParam(':idpatio', $IdPatio);
                $stinfra->bindParam(':idusuario', $IdUsuario);
                // Executa a senten�a j� com os valores
                $stinfra->execute();
            }
        }


        foreach($lacre_array as $Lacres) {
        // Prepara uma senten�a para ser executada
            $stlacre = $pdo->prepare('INSERT INTO grv_lacre (GRV,LACRE,ESTADO,ID_PATIO,ID_USUARIO,STATUS) VALUES
                                                                                (:grv,:lacre,:estado,:idpatio,:idusuario,:status)');

        // Adiciona os dados acima para serem executados na senten�a
            $stlacre->bindParam(':grv', $Grv);
            $stlacre->bindParam(':lacre', $Lacres);
            $stlacre->bindParam(':estado', $Estado);
            $stlacre->bindParam(':idpatio', $IdPatio);
            $stlacre->bindParam(':status', $StatusAtivo);
            $stlacre->bindParam(':idusuario', $IdUsuario);
        // Executa a senten�a j� com os valores
            $stlacre->execute();
        }

        // avarias
            foreach($NEquipamento as $Eq) {
                // Prepara uma senten�a para ser executada
                $stCheck = $pdo->prepare('INSERT INTO grv_checklist (GRV,ID_PATIO,ID_EQUIP,OBS,ESTADOEQUIP,ID_USUARIO)VALUES
                                                                              (:grv,:idpatio,:idequip,:obs,:estado,:id_usuario)');

                // Adiciona os dados acima para serem executados na senten�a
                 $stCheck->bindParam(':grv', $Grv);
                 $stCheck->bindParam(':idpatio', $IdPatio);
                 $stCheck->bindParam(':idequip', $EstadoEquip);
                 $stCheck->bindParam(':obs', $InfAdic);
                 $stCheck->bindParam(':estado', $Estado);
                 $stCheck->bindParam(':id_usuario', $IdUsuario);
                 $stCheck->execute();

            }


        // Prepara uma senten�a para ser executada
        $statement = $pdo->prepare('INSERT INTO grv_condutor (GRV,ID_PATIO,NOME,CPF,IDENTIDADE,ORGAO,TELEFONE,CELULAR,
                                                                                     EMAIL,INFORMADICIONAL,DOCNOVEICULO,CHAVENOVEICULO,NUMEROCHAVE,STATUSASSINATURA) VALUES
                                                                                  (:grv,:idpatio,:nome,:cpf,:identidade,:orgao,:telefone,:celular,:email,
                                                                                  :infadic,:docveiculo,:chaveveiculo,:numerochave,:statusassinatura)');

        // Adiciona os dados acima para serem executados na senten�a
        $statement->bindParam(':grv', $Grv);
        $statement->bindParam(':idpatio', $IdPatio);
        $statement->bindParam(':nome', $Nome);
        $statement->bindParam(':cpf', $Cpf);
        $statement->bindParam(':identidade', $Identidade);
        $statement->bindParam(':orgao', $Orgao);
        $statement->bindParam(':telefone', $Telefone);
        $statement->bindParam(':celular', $Celular);
        $statement->bindParam(':email', $Email);
        $statement->bindParam(':infadic', $InfAdic);
        $statement->bindParam(':docveiculo', $DocNoVeiculo);
        $statement->bindParam(':chaveveiculo', $ChaveVeiculo);
        $statement->bindParam(':statusassinatura', $Assinatura);
        $statement->bindParam(':numerochave', $NumeroChave);
        $statement->execute();



            $stusu = $pdo->prepare('UPDATE usuarios SET COUNTERGRV =:countergrv WHERE IDREBOQUISTA =:idreboquista');

            // Adiciona os dados acima para serem executados na senten�a
            $stusu->bindParam(':countergrv', $CounterGrv);
            $stusu->bindParam(':idreboquista', $Reboquista);
            // Executa a senten�a j� com os valores
            $stusu->execute();

        // Prepara uma senten�a para ser executada
        $st = $pdo->prepare('INSERT INTO grv_veiculo (GRV,ID_PATIO,ID_MOTIVO,ID_REBOQUISTA,ID_REBOQUE,USOREBOQUE,SEMPLACA,ANOFABMOD,
                                                                                      ID_AGENTE,AGENTEMAT,AGENTENOME,PLACA,CHASSI,RENAVAM,TIPOVEICULO,COR,
                                                                                        MARCAMODELO,CEP,ENDERECO,NUMERO,COMPL,BAIRRO,CIDADE,UF,PONTOREF)
                                                                                            VALUES
                                (:grv,:patio,:motivo,:reboquista,:reboque,:usoureboque,:semplaca,:anofabmod,:agente,:matagente,
                                   :nomeagente,:placa,:chassi,:renavam,:tipoveiculo,:cor,:marca,:cep,:endereco,:numero,:compl,:bairro,:cidade,:uf,:pontoref)');

        // Adiciona os dados acima para serem executados na senten�a
        $st->bindParam(':grv', $Grv);
        $st->bindParam(':patio', $IdPatio);
        $st->bindParam(':motivo', $Motivo);
        $st->bindParam(':reboquista', $Reboquista);
        $st->bindParam(':reboque', $Reboque);
        $st->bindParam(':usoureboque', $UsouReboque);
        $st->bindParam(':semplaca', $SemPlaca);
        $st->bindParam(':agente', $TipoAgente);
        $st->bindParam(':anofabmod', $AnoFabMod);
        $st->bindParam(':matagente', $MatAgente);
        $st->bindParam(':nomeagente', $NomeAgente);
        $st->bindParam(':placa', $Placa);
        $st->bindParam(':chassi', $Chassi);
        $st->bindParam(':renavam', $Renavam);
        $st->bindParam(':tipoveiculo', $TipoVeiculo);
        $st->bindParam(':cor', $Cor);
        $st->bindParam(':marca', $MarcaModelo);
        $st->bindParam(':cep', $Cep);
        $st->bindParam(':endereco', $Endereco);
        $st->bindParam(':numero', $Numero);
        $st->bindParam(':compl', $Compl);
        $st->bindParam(':bairro', $Bairro);
        $st->bindParam(':cidade', $Cidade);
        $st->bindParam(':uf', $Uf);
        $st->bindParam(':pontoref', $PontoRef);
        $st->execute();


            $stt1 = $pdo->prepare('INSERT INTO grv_status (GRV,ID_PATIO,DATAREMOCAO,HORAREMOCAO,LOCALPATIO,DATAENT,HORAENT,
                                                                      DATARETIRADA,HORARETIRADA,ID_CONFERENTE, STATUS,ID_USUARIO,KMREB) VALUES
                                                                    (:grv,:idpatio,:dataremocao,:horaremocao,:localpatio,:dataent,:horaent,
                                                                    :dataret,:horaret,:idconferente,:status,:idusuario,:kmreb)');

            // Adiciona os dados acima para serem executados na senten�a
            $stt1->bindParam(':grv', $Grv);
            $stt1->bindParam(':dataremocao', $DataRemocao);
            $stt1->bindParam(':horaremocao', $HoraRemocao);
            $stt1->bindParam(':idpatio', $IdPatio);
            $stt1->bindParam(':dataent', $Datazero);
            $stt1->bindParam(':horaent', $Horazero);
            $stt1->bindParam(':dataret', $Datazero);
            $stt1->bindParam(':horaret', $Horazero);
            $stt1->bindParam(':idusuario', $IdUsuario);
            $stt1->bindParam(':localpatio', $InfAdic);
            $stt1->bindParam(':status', $Status);
            $stt1->bindParam(':kmreb', $KmReb);
            $stt1->bindParam(':idconferente', $Id_Conferente);
            // Executa a senten�a j� com os valores

        // Executa a senten�a j� com os valores
        if ($stt1->execute()) {
            // Definimos a mensagem de sucesso
            $Cod_Error = '1';//OK

        }else{
            $Cod_Error = '0'; // 'ERROBANCO' erro no banco
        }

}
$resultado['result'] = $Cod_Error;
echo json_encode($resultado);


?>

