<?php

/**
 * Modelo para gerenciar Busca Dados
 *
 * @package DtiMVC
 * @since 0.1
 */
class BuscaDadosModel extends DtiModel
{

    /**
     * $form_data
     *
     * Os dados do formulário de envio.
     *
     * @access public
     */
    public $form_data;


    /**
     * $form_msg
     *
     * As mensagens de feedback para o usuário.
     *
     * @access public
     */
    public $form_msg;


    /**
     * $db
     *
     * O objeto da nossa conexão PDO
     *
     * @access public
     */
    public $db;


    /**
     * Construtor para essa classe
     *
     * Configura o DB, o controlador, os parâmetros e dados do usuário.
     *
     * @since 0.1
     * @access public
     * @param object $db Objeto da nossa conexão PDO
     * @param object $controller Objeto do controlador
     */
    public function __construct($db = false, $controller = null)
    {
        // Configura o DB
        $this->db = $db;

        // Configura o controlador
        //$this->controller = $controller;

        // Configura os parâmetros
        //$this->parametros = $this->controller->parametros;

    }


    /**
     * Listar tipo produtos
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_tipo_produtos($co_produto)
    {


        $sql = "SELECT 	tp_prod.co_tipo_produto, 
					tp_prod.ds_tipo_produto
				  FROM rl_produto_montado mont
				INNER JOIN   tb_tipo_produto tp_prod
				 ON (mont.co_tipo_produto = tp_prod.co_tipo_produto)
				WHERE  mont.co_produto = $co_produto
				 GROUP BY	tp_prod.co_tipo_produto,
						tp_prod.ds_tipo_produto
				ORDER BY 	tp_prod.ds_tipo_produto";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar tipo produtos


    /**
     * Listar embalagens
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_embalagem($co_tipo_produto, $co_produto)
    {


        $sql = "SELECT 	embal.co_embalagem, 
					embal.ds_embalagem
				  FROM rl_produto_montado mont
				INNER JOIN   tb_embalagem_produto embal
				 ON (mont.co_embalagem = embal.co_embalagem)
				WHERE  mont.co_tipo_produto = $co_tipo_produto AND co_produto = $co_produto
				 GROUP BY	embal.co_embalagem,
						embal.ds_embalagem
				ORDER BY 	embal.ds_embalagem";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar embalagens


    /**
     * Buscar produtos
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function buscar_produto($co_produto, $co_tipo_produto, $co_embalagem)
    {


        $sql = "SELECT 	mont.co_produto_montado,
					prod.ds_produto,
					tp_prod.ds_tipo_produto,
					embal.ds_embalagem
				 FROM rl_produto_montado mont
				INNER JOIN   tb_produto prod
				 ON (mont.co_produto = prod.co_produto)
				INNER JOIN   tb_tipo_produto tp_prod
				 ON (mont.co_tipo_produto = tp_prod.co_tipo_produto)
				INNER JOIN   tb_embalagem_produto embal
				 ON (mont.co_embalagem = embal.co_embalagem)
				WHERE  mont.co_produto = $co_produto AND mont.co_tipo_produto = $co_tipo_produto AND mont.co_embalagem = $co_embalagem";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } //Buscar produtos


    /**
     * Buscar Municipios
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_municipio($coduf)
    {


        $sql = "SELECT codigoibge7, codigoibge6, municipioibge, coduf, uf, municipiomis, municipiovelho
  				FROM ibge.municipios WHERE coduf = '" . $coduf . "' ORDER BY  municipioibge ";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } //Buscar Municipios


    /**
     * Buscar Municipios IBGE
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_municipio_ibge($codigoibge)
    {


        $sql = "SELECT codigoibge7, codigoibge6, municipioibge, estados.coduf, uf, estado , municipiomis, 
				       municipiovelho
				FROM ibge.municipios
				INNER JOIN ibge.estados
					ON (estados.coduf = municipios.coduf)
				WHERE codigoibge7 = " . $codigoibge . " ";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } //Buscar Municipios IBGE


    /**
     * Buscar verificar_cnpj
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function verificar_cnpj($cnpj)
    {


        $sql = "SELECT co_organizacao, nu_cnpj
  				FROM tb_organizacao where nu_cnpj = '" . $cnpj . "' ";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } //Buscar verificar_cnpj


} // PrincipalModel