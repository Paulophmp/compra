<?php
/**
 * UserLogin - Manipula os dados de usuários
 *
 * Manipula os dados de usuários, faz login e logout, verifica permissões e 
 * redireciona página para usuários logados.
 *
 * @package DtiMVC
 * @since 0.1
 */
class UserLogin
{
	/**
	 * Usuário logado ou não
	 *
	 * Verdadeiro se ele estiver logado.
	 *
	 * @public
	 * @access public
	 * @var bol
	 */
	public $logged_in;
	
	/**
	 * Dados do usuário
	 *
	 * @public
	 * @access public
	 * @var array
	 */
	public $userdata;
	
	
	/**
	 * Verifica o login
	 *
	 */
	public function check_userlogin () {
	
		// // Verifica se existe $_COOKIE
		// if ( 	isset( $_COOKIE['authsagi_cpf'] ) && 
				// isset( $_COOKIE['authsagi_auth_perfil'] )&& 
				// isset( $_COOKIE['authsagi_auth'] )&&
				// isset( $_COOKIE['authsagi_email'] )&&
				// isset( $_COOKIE['authsagi_nome'])
			// ) { 

			// // Configura os dados do usuário

			// $this->userdata['cpf'] 	= $_COOKIE['authsagi_cpf'];
			// $this->userdata['perfil'] = $_COOKIE['authsagi_auth_perfil'];	
			// $this->userdata['email'] = $_COOKIE['authsagi_email'];
			// $this->userdata['nome'] = $_COOKIE['authsagi_nome'];

			// return 'Usuário Logado!';

		// } else {

		// require_once ABSPATH . '/includes/sem_permissoes.php';
		// exit;
		// return;

		// }
		
		
			// Configura os dados do usuário

			$this->userdata['cpf'] 	= '03373809100';
			$this->userdata['perfil'] = 'registro' ;	
			$this->userdata['email'] = 'philipe.almeida@outlook.com';
			$this->userdata['nome'] = 'Philipe Allan Almeida';
			$this->userdata['ibge'] = '410690';
			$this->userdata['co_uf'] = '41';
			$this->userdata['uf'] = 'PR';

			return 'Usuário Logado!';
	
	
	}
	
}