<?php

/**
 * Acesso - Controller
 *
 * @package DtiMVC
 * @since 0.1
 */
class AcessoController extends DtiController
{

    /**
     * Carrega a página "/views/principal/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'acesso';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Essa página não precisa de modelo (model)

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/acesso/acesso-view.php
        require ABSPATH . '/views/acesso/acesso-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class HomeController