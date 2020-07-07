<?php

/**
 * sintetico - Controller de exemplo
 *
 * @package DtiMVC
 * @since 0.1
 */
class SinteticoController extends DtiController
{

    /**
     * Carrega a página "/views/principal/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'sintetico';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('sintetico/sintetico-model');

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';

        // /views/sintetico/sintetico-view.php
        require ABSPATH . '/views/sintetico/sintetico-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class HomeController