<?php

/**
 * Modelo para gerenciar Principal
 *
 * @package DtiMVC
 * @since 0.1
 */
class PrincipalModel extends DtiModel
{


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
     * Listar produtos
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_produtos()
    {


        $sql = "SELECT co_produto, ds_produto FROM tb_produto ORDER BY ds_produto";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar produtos


    /**
     * Listar de organizações
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_organizacoes($uf_cadastro, $municipio, $cert_organico, $tp_produto)
    {


        //Pesquisa uf e municipio
        if (
            ($uf_cadastro != NULL && $uf_cadastro != '' && $uf_cadastro != 0) &&
            ($municipio != NULL && $municipio != '' && $municipio != 0)
        ) {//Valida os campos
            if ($cert_organico == 'sim') {//Verifica se é ôrganico

                //Pesquisa uf
                if ($tp_produto == NULL && $tp_produto == '' && $tp_produto == 0) {//Verifica a variável tp_produto

                    //Perquisa com uf_cadastro , municipio e certificado_organico
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND co_ibge = '$municipio' AND in_certificado_organico = 1 ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                } else {

                    //Perquisa com uf_cadastro , municipio, certificado_organico e tipo do produto
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND mont.co_produto =  $tp_produto  AND co_ibge = '$municipio' AND in_certificado_organico = 1 ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                }

            } else {//Pesquisa sem o organico

                if ($tp_produto == NULL && $tp_produto == '' && $tp_produto == 0) {//Verifica a variável tp_produto

                    //Perquisa com uf_cadastro e municipio
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro'  AND co_ibge = '$municipio' ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                } else {

                    //Perquisa com uf_cadastro , municipio e tipo do produto
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND mont.co_produto =  $tp_produto AND co_ibge = '$municipio' ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                }


            }

        }

        //Pesquisa uf
        if (
            ($uf_cadastro != NULL && $uf_cadastro != '' && $uf_cadastro != 0) &&
            ($municipio == NULL && $municipio == '' && $municipio == 0)
        ) {

            if ($cert_organico == 'sim') {//Verifica se é ôrganico

                if ($tp_produto == NULL && $tp_produto == '' && $tp_produto == 0) {//Verifica a variável tp_produto

                    //Perquisa com uf_cadastro e certificado_organico
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND in_certificado_organico = 1 ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                } else {

                    //Perquisa com uf_cadastro, certificado_organico e tipo produto
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND mont.co_produto =  $tp_produto AND in_certificado_organico = 1 ORDER BY  mun_endereco.municipioibge , org.no_fantasia";


                }


            } else {

                if ($tp_produto == NULL && $tp_produto == '' && $tp_produto == 0) {//Verifica a variável tp_produto

                    //Perquisa com uf_cadastro
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                } else {

                    //Perquisa com uf_cadastro e tipo produto
                    $where = " WHERE SUBSTR(co_ibge,1,2) = '$uf_cadastro' AND mont.co_produto =  $tp_produto  ORDER BY  mun_endereco.municipioibge , org.no_fantasia";

                }


            }


        }

        $sql = "SELECT DISTINCT
		 		org.co_organizacao,
				org.nu_dap_juridica,
				org.nu_cnpj,
				org.no_fantasia,
				org.no_razao_social, 
				org.co_tipo_organizacao, 
				org.no_filiacao_central_cooper, 
				org.no_representante_legal,
				org.dt_inicio_mand_repres_legal, 
				org.dt_fim_mand_repres_legal, 
				org.nu_telefone_comercial, 
				org.nu_telefone_celular, 
				org.no_email_cetral_vendas, 
				org.no_email_administrativo, 
				org.no_sitio_eletronico, 
				org.co_ibge,
				mun_endereco.municipioibge as municipio_endereco, 
				est_endereco.estado as estado_endereco
				FROM tb_organizacao org
				INNER JOIN rl_organizacao_produto org_prod
				 ON(org_prod.co_organizacao = org.co_organizacao)
				INNER JOIN rl_produto_montado mont
				 ON (mont.co_produto_montado = org_prod.co_produto_montado)
				INNER JOIN ibge.municipios mun_endereco
					ON ( cast(mun_endereco.codigoibge7 as text) = org.co_ibge)
				INNER JOIN ibge.estados est_endereco
					ON (est_endereco.coduf = mun_endereco.coduf)" . $where;


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar de organizações


    /**
     * Listar produtos de organizações
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_produtos_organizacoes($co_organizacao, $tp_produto = null)
    {


        //Pesquisa uf
        if ($tp_produto == NULL && $tp_produto == '' && $tp_produto == 0) {

            $where = ' ORDER BY prod.ds_produto ';

        } else {

            $where = " AND mont.co_produto =  $tp_produto ORDER BY prod.ds_produto ";

        }

        $sql = "SELECT 
						prod.ds_produto,
						tp_prod.ds_tipo_produto,
						embal.ds_embalagem
					FROM tb_organizacao org
					INNER JOIN rl_organizacao_produto org_prod
					 ON(org_prod.co_organizacao = org.co_organizacao)
					INNER JOIN rl_produto_montado mont
					 ON (mont.co_produto_montado = org_prod.co_produto_montado)
					INNER JOIN   tb_produto prod
					 ON (mont.co_produto = prod.co_produto)
					INNER JOIN   tb_tipo_produto tp_prod
					 ON (mont.co_tipo_produto = tp_prod.co_tipo_produto)
					INNER JOIN   tb_embalagem_produto embal
					 ON (mont.co_embalagem = embal.co_embalagem)
					WHERE org.co_organizacao = $co_organizacao " . $where;


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar produtos de organizações


    /**
     * Listar de organização
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_organizacao($co_organizacao)
    {


        $sql = "SELECT DISTINCT
		 		org.co_organizacao,
				org.nu_dap_juridica,
				org.nu_cnpj,
				org.no_fantasia,
				org.no_razao_social, 
				org.co_tipo_organizacao, 
				org.no_filiacao_central_cooper, 
				org.no_representante_legal,
				org.dt_inicio_mand_repres_legal, 
				org.dt_fim_mand_repres_legal, 
				org.nu_telefone_comercial, 
				org.nu_telefone_celular, 
				org.no_email_cetral_vendas, 
				org.no_email_administrativo, 
				org.no_sitio_eletronico, 
				org.co_ibge,
				mun_endereco.municipioibge as municipio_endereco, 
				est_endereco.estado as estado_endereco
				FROM tb_organizacao org
				INNER JOIN rl_organizacao_produto org_prod
				 ON(org_prod.co_organizacao = org.co_organizacao)
				INNER JOIN rl_produto_montado mont
				 ON (mont.co_produto_montado = org_prod.co_produto_montado)
				INNER JOIN ibge.municipios mun_endereco
					ON ( cast(mun_endereco.codigoibge7 as text) = org.co_ibge)
				INNER JOIN ibge.estados est_endereco
					ON (est_endereco.coduf = mun_endereco.coduf)
				WHERE org.co_organizacao = $co_organizacao";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar de organização


} // PrincipalModel