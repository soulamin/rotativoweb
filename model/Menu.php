<?php
/**
 * Created by PhpStorm.
 * User: ALAN Lamin
 * Date: 11/10/2016
 * Time: 15:26
 */
require '../fontes/conexao.php';

$acao = $_POST['acao'];

switch($acao) {

    case 'Sair' :

        session_start();
        session_destroy();
        $Resultado['Cod_Error'] = 1;
        echo json_encode($Resultado);

        break;

    case 'Validar' :

        session_start();
        if (!isset ($_SESSION['LOGIN'])) {
            session_destroy();
            $Resultado['Cod_Error'] = 1;
            $html = 1;
        } else {

            $TipoPerfil = $_SESSION['NIVEL'];

            $Saudacao = '<b>BEM VINDO, ' . strtoupper($_SESSION['LOGIN']) . '  </b>';

            switch ($TipoPerfil) {

                // Tipo de Perfil ADMINISTRADOR
                case 'A' :

                    $MenuLateral = '  <li class="nav-item ">
                                          <a href="#"  class="nav-link btnPainel">
                                            <i class="nav-icon fa fa-tv"></i>
                                            <p>Painel</p>
                                          </a>
                                        </li> 
                                        <li class="nav-item  ">
                                            <a href="#"  class="nav-link btnEmpresa">
                                              <i class="nav-icon fa fa-building"></i>
                                              <p>Empresas</p>
                                            </a>
                                          </li>
                                            <li class="nav-item ">
                                            <a href="#"  class="nav-link btnLocalidade">
                                              <i class="nav-icon fa fa-map-marker"></i>
                                              <p>Localidade</p>
                                            </a>
                                          </li>
                                          
                                       <li class="nav-item ">
                                            <a href="#" class="nav-link btnTaxa">
                                              <i class="nav-icon fa fa-money"></i>
                                              <p>Taxas</p>
                                            </a>
                                        </li>
                                        <li class="nav-item ">
                                            <a href="#"  class="nav-link btnLocalFiscal">
                                              <i class="nav-icon fa fa-location-arrow"></i>
                                              <p>Local Fiscal</p>
                                            </a>
                                          </li>
                                          <li class="nav-item ">
                                          <a href="#"  class="nav-link btnUsuario">
                                            <i class="nav-icon fa fa-user"></i>
                                            <p>Usuários</p>
                                          </a>
                                        </li>
                                        <li class="nav-item ">
                                        <a href="#"  class="nav-link btnPgPendente">
                                          <i class="nav-icon fa fa-exclamation"></i>
                                          <p>Pagamento Pendente</p>
                                        </a>
                                      </li>';


                    $Tipo = $TipoPerfil;

                    break;

                   //Fiscalizador
                    case 'G' :
    
                        $MenuLateral = '         <li class="nav-item  ">
                                                <a href="#"  class="nav-link btnGerenciar ">
                                                  <i class="nav-icon fa fa-desktop"></i>
                                                  <p>Consultar Ticket</p>
                                                </a>
                                              </li>                             
                                              <li class="nav-item ">
                                                <a href="#"  class="nav-link btnTicket">
                                                  <i class="nav-icon fa fa-file-text-o"></i>
                                                  <p> Novo Ticket</p>
                                                </a>
                                              </li>  
                                              <li class="nav-item ">
                                                <a href="#"  class="nav-link btnHistoricoFiscal">
                                                  <i class="nav-icon fa fa-book"></i>
                                                  <p>Histórico</p>
                                                </a>
                                              </li>';
    
    
                        $Tipo = $TipoPerfil;
    
                        break;

                        case 'U' :
    
                        $MenuLateral = '  <li class="nav-item ">
                                              <a href="#"  class="nav-link btnPerfil">
                                                <i class="nav-icon fa fa-user"></i>
                                                <p>Perfil</p>
                                              </a>
                                            </li><li class="nav-item  ">
                                                <a href="#"  class="nav-link btnInformacao ">
                                                  <i class="nav-icon fa fa-desktop"></i>
                                                  <p>Informação Ticket</p>
                                                </a>
                                              </li>                             
                                              <li class="nav-item ">
                                                <a href="#"  class="nav-link btnMeuTicket">
                                                  <i class="nav-icon fa fa-file-text-o"></i>
                                                  <p> Novo Ticket</p>
                                                </a>
                                              </li>  
                                              <li class="nav-item ">
                                                <a href="#"  class="nav-link btnRecarga">
                                                  <i class="nav-icon fa fa-money"></i>
                                                  <p>Compra</p>
                                                </a>
                                              </li>';
    
    
                        $Tipo = $TipoPerfil;
    
                        break;

                        case 'F' :
    
                        $MenuLateral = '<li class="nav-item ">
                                              <a href="#"  class="nav-link btnNotificacao">
                                                <i class="nav-icon fa fa-exclamation"></i>
                                                <p>Notificação</p>
                                              </a>
                                            </li>';
    
    
                        $Tipo = $TipoPerfil;
    
                        break;
            }
            $MenuTopo = '<li class=" text-white nav-item dropdown ">
                                    <a class="nav-link text-dark" data-toggle="dropdown" href="#" >
                                      ' . $Saudacao . '
                                     <i class="nav-icon fa fa-caret-down"> </i>
                                     </a>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                      <span class="dropdown-item dropdown-header btnAlteraSenha text-center ">ALTERAR SENHA</span>
                                      <span   id="btnSair" class="dropdown-item dropdown-header btnAlteraSenha text-center ">SAIR </span>
                                     
                          </li>';
            if ($_SESSION['NIVEL'] == 'G'|| $_SESSION['NIVEL'] == 'U' ) {

            $MenuTopo .= ' <li class="nav-item">
                                       <a class="nav-link btnGerenciar"  href="#" >
                                           <i class="fa fa-bell-o" id="QtdVenc"></i>
                                       </a>   
                           </li>';
                }

            // Tipo de Perfil Visualizador
            $Resultado['Cod_Error'] = 0;
            $Resultado['MenuTopo'] = $MenuTopo;
            $Resultado['MenuLateral'] = $MenuLateral;
            $Resultado['Tipo'] = $Tipo;
        }
        echo json_encode($Resultado);

        break;

}
