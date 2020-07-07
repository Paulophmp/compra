<?php

/**
 * Token - Controller de Token
 *
 * @package RedesuasMVC
 * @since 0.1
 */
class TokenController extends DtiController
{

    /**
     * Carrega a página "/views/token/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'token';
		
        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('token/token-model');

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        //require ABSPATH . '/views/_includes/menu.php';

        // /views/token/token-view.php
        require ABSPATH . '/views/token/token-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class tokenController