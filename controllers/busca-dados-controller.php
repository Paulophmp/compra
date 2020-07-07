<?php
/**
 * Busca dados - Controller Buscadados
 *
 * @package DtiMVC
 * @since 0.1
 */
class BuscaDadosController extends DtiController
{

	/**
	 * Carrega a página "/views/busca-dados/index.php"
	 */
    public function index()
    {
		// Título da página
		$this->title = 'Busca dados';
		
		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
		// Carrega o modelo para este view
        $modelo = $this->load_model('busca-dados/busca-dados-model');

		/** Carrega os arquivos do view **/
		// /views/busca-dados/busca-dados-view.php
        require ABSPATH . '/views/busca-dados/busca-dados-view.php';

		
    } // index
	
} // class HomeController