<?php

/**
 * Analitico - Controller de exemplo
 *
 * @package DtiMVC
 * @since 0.1
 */
class AnaliticoController extends DtiController
{

    /**
     * Carrega a página "/views/analitico/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'analitico';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('analitico/analitico-model');

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';

        // /views/analitico/analitico-view.php
        require ABSPATH . '/views/analitico/analitico-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class HomeController