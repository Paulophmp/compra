<?php

/**
 * Editar - Controller de Editar
 *
 * @package RedesuasMVC
 * @since 0.1
 */
class EditarController extends DtiController
{

    /**
     * Carrega a página "/views/Editar/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'Editar';
		
        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('cadastro/cadastro-model');

        /** Carrega os arquivos do view **/

        // /views/_includes/cabecalho.php
        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        //require ABSPATH . '/views/_includes/menu.php';

        // /views/editar/editar-view.php
        require ABSPATH . '/views/editar/editar-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class CadastroController