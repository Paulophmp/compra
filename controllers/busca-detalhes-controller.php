<?php

/**
 * Busca Detalhes - Controller Buscadados
 *
 * @package DtiMVC
 * @since 0.1
 */
class BuscaDetalhesController extends DtiController
{

    /**
     * Carrega a página "/views/busca-detalhes/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'Busca Detalhes';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('principal/principal-model');

        /** Carrega os arquivos do view **/
        // /views/busca-detalhes/busca-detalhes-view.php
        require ABSPATH . '/views/busca-detalhes/busca-detalhes-view.php';


    } // index

} // class HomeController