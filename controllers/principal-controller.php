<?php

/**
 * Principal - Controller de Principal
 *
 * @package DtiMVC
 * @since 0.1
 */
class PrincipalController extends DtiController
{

    /**
     * Carrega a página "/views/principal/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'Principal';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('principal/principal-model');

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        //require ABSPATH . '/views/_includes/menu.php';

        // /views/principal/principal-view.php
        require ABSPATH . '/views/principal/principal-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class PrincipalController