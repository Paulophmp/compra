<?php if ( ! defined('ABSPATH')) exit; ?>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Marca a alternância se agrupados para melhor visualização móvel -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Alternar navegação<</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<!-- Imagem MDS --><a  href="http://mds.gov.br/" target="_blank" > &nbsp; <img src="<?php echo HOME_URI;?>/views/_images/mds.png" width="130" height="55" alt="Ministério do Desenvolvimento Social"> </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
                       <!-- Top Menu Items -->

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php //if( $pagina == 'pricipal' ) { echo "class='active'"; } ?> >
                        <a href="<?php echo HOME_URI;?>/"><i class="fa fa-fw fa-dashboard"></i> <b> Principal </b></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><b>Sub Menu</b> <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo HOME_URI;?>/cadastro/">CADASTRO</a></li>
                        <li><a href="<?php echo HOME_URI;?>/tipo-produto/">CADASTRO2</a></li>
                        <li><a href="<?php echo HOME_URI;?>/embalagem/">CADASTRO3</a></li>
                        <li><a href="<?php echo HOME_URI;?>/noticias/adm/">CADASTRO4</a></li>
                        <li><a href="<?php echo HOME_URI;?>/exemplo/">CADASTRO5</a></li>        
                        <li class="divider"></li>
                        <li><a href="#">Opção 1</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Opção 1</a></li>
                      </ul>
                    </li>           
                </ul>
            </div>
        </nav>

