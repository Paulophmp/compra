<?php

/**
 * upload - Controller de upload
 *
 * @package RedesuasMVC
 * @since 0.1
 */
class UploadController extends DtiController
{

    /**
     * Carrega a página "/views/upload/index.php"
     */
    public function index()
    {
        // Título da página
        $this->title = 'Cadastro';

        // Parametros da função
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();

        // Carrega o modelo para este view
        $modelo = $this->load_model('upload/upload-model');

        /** Carrega os arquivos do view **/


        require ABSPATH . '/views/_includes/cabecalho.php';

        // /views/_includes/menu.php
        //require ABSPATH . '/views/_includes/menu.php';

        // /views/upload/upload-view.php
        require ABSPATH . '/views/upload/upload-view.php';

        // /views/_includes/rodape.php
        require ABSPATH . '/views/_includes/rodape.php';

    } // index

} // class CadastroController