<?php

/**
 * Cadastro - Controller de cadastro
 *
 * @package RedesuasMVC
 * @since 0.1
 */
class CadastroController extends DtiController
{

    /**
     * Carrega a página "/views/cadastro/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'Cadastro';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('cadastro/cadastro-model');

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        //require ABSPATH . '/views/_includes/menu.php';

        // /views/cadastro/cadastro-view.php
        require ABSPATH . '/views/cadastro/cadastro-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class CadastroController