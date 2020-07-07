<?php

/**
 * Modelo para gerenciar upload
 *
 * @package DtiMVC
 * @since 0.1
 */
class UploadModel extends DtiModel
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
     * Valida o formulário de envio
     *
     * Este método pode inserir ou atualizar dados dependendo do campo de
     * usuário.
     *
     * @since 0.1
     * @access public
     */
    public function validar_form_cadastro()
    {

        // Configura os dados do formulário
        $this->form_data = array();

        // Verifica se algo foi postado
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty ($_POST)) {

            // Faz o loop dos dados do post
            foreach ($_POST as $key => $value) {

                // Configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;

            }

        } else {

            // Termina se nada foi enviado
            return;

        }

        // Verifica se a propriedade $form_data foi preenchida
        if (empty($this->form_data)) {
            return;
        }

        $this->db->beginTransactionPDO();

        // Se Ação for inserir, atualiza os dados
        if ($this->form_data['acao_cadastro'] == 'inserir') {


            $validar = false;

            //Criação das variáveis que vem do input e validação
            $nu_dap_juridica = is_null($this->form_data['nu_dap_juridica']) ? 'null' : $this->form_data['nu_dap_juridica'];
            $nu_cnpj = is_null($this->form_data['nu_cnpj']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['nu_cnpj']);
            $no_fantasia = is_null($this->form_data['no_fantasia']) ? 'null' : $this->form_data['no_fantasia'];
            $no_razao_social = is_null($this->form_data['no_razao_social']) ? 'null' : $this->form_data['no_razao_social'];
            $co_tipo_organizacao = is_null($this->form_data['co_tipo_organizacao']) ? 'null' : $this->form_data['co_tipo_organizacao'];
            $no_filiacao_central_cooper = is_null($this->form_data['no_filiacao_central_cooper']) ? 'null' : $this->form_data['no_filiacao_central_cooper'];
            $no_representante_legal = is_null($this->form_data['no_representante_legal']) ? 'null' : $this->form_data['no_representante_legal'];
            $dt_inicio_mand_repres_legal = is_null($this->form_data['dt_inicio_mand_repres_legal']) ? 'null' : $this->inverte_data($this->form_data['dt_inicio_mand_repres_legal']);
            $dt_fim_mand_repres_legal = is_null($this->form_data['dt_fim_mand_repres_legal']) ? 'null' : $this->inverte_data($this->form_data['dt_fim_mand_repres_legal']);
            $nu_telefone_comercial = is_null($this->form_data['nu_telefone_comercial']) ? 'null' : str_replace(' ', '', preg_replace("/[^0-9\s]/", "", $this->form_data['nu_telefone_comercial']));
            $nu_telefone_celular = is_null($this->form_data['nu_telefone_celular']) ? 'null' : str_replace(' ', '', preg_replace("/[^0-9\s]/", "", $this->form_data['nu_telefone_celular']));
            $no_email_cetral_vendas = is_null($this->form_data['no_email_cetral_vendas']) ? 'null' : $this->form_data['no_email_cetral_vendas'];
            $email_administrativo = is_null($this->form_data['email_administrativo']) ? 'null' : $this->form_data['email_administrativo'];
            $no_sitio_eletronico = is_null($this->form_data['no_sitio_eletronico']) ? 'null' : $this->form_data['no_sitio_eletronico'];
            $co_ibge = is_null($this->form_data['co_ibge']) ? 'null' : $this->form_data['co_ibge'];
            $no_endereco = is_null($this->form_data['no_endereco']) ? 'null' : $this->form_data['no_endereco'];
            $qt_agricultores_fam = is_null($this->form_data['qt_agricultores_fam']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['qt_agricultores_fam']);
            $qt_cooper_associ = is_null($this->form_data['qt_cooper_associ']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['qt_cooper_associ']);
            $in_certificado_organico = is_null($this->form_data['in_certificado_organico']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_certificado_organico']);
            $in_certificado_sustentabilidade = is_null($this->form_data['in_certificado_sustentabilidade']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_certificado_sustentabilidade']);
            $in_certificado_fairtrade = is_null($this->form_data['in_certificado_fairtrade']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_certificado_fairtrade']);
            $in_produto_sociobiodiversidade = is_null($this->form_data['in_produto_sociobiodiversidade']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_produto_sociobiodiversidade']);
            $in_produto_origem_quilombola = is_null($this->form_data['in_produto_origem_quilombola']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_produto_origem_quilombola']);
            $in_produto_origem_indigina = is_null($this->form_data['in_produto_origem_indigina']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_produto_origem_indigina']);
            $unicafes = is_null($this->form_data['unicafes']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['unicafes']);
            $unisol = is_null($this->form_data['unisol']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['unisol']);
            $ecovida = is_null($this->form_data['ecovida']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['ecovida']);
            $ocb = is_null($this->form_data['ocb']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['ocb']);
            $mst = is_null($this->form_data['mst']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['mst']);
            $contag = is_null($this->form_data['contag']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['contag']);
            $fetraf = is_null($this->form_data['fetraf']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['fetraf']);
            $mpa = is_null($this->form_data['mpa']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['mpa']);
            $mmc = is_null($this->form_data['mmc']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['mmc']);
            $in_termo_aceite = is_null($this->form_data['in_termo_aceite']) ? 'null' : preg_replace("/[^0-9\s]/", "", $this->form_data['in_termo_aceite']);


            //Executa a query utilizada para gerar a Grid cnpj
            $dados_cnpj = $this->verificar_cnpj($nu_cnpj); //arquivos

            if ($dados_cnpj) {

                return 'error_cnpj';

            }


            // Executa a consulta
            $sql_tb_organizacao = "INSERT INTO tb_organizacao(
										nu_dap_juridica,
										nu_cnpj,
										no_fantasia,
										no_razao_social, 
										co_tipo_organizacao, 
										no_filiacao_central_cooper, 
										no_representante_legal, 
										dt_inicio_mand_repres_legal, 
										dt_fim_mand_repres_legal, 
										nu_telefone_comercial, 
										nu_telefone_celular, 
										no_email_cetral_vendas, 
										no_email_administrativo, 
										no_sitio_eletronico, 
										co_ibge, 
										no_endereco, 
										qt_agricultores_fam, 
										qt_cooper_associ, 
										in_certificado_organico, 
										in_certificado_sustentabilidade, 
										in_certificado_fairtrade, 
										in_produto_sociobiodiversidade, 
										in_produto_origem_quilombola, 
										in_produto_origem_indigina, 
										in_termo_aceite,
										in_unicafes, 
							            in_unisol, 
							            in_ecovida, 
							            in_ocb, 
							            in_mst, 
							            in_contag, 
							            in_fetraf,
							            in_mpa,
							            in_mmc)
								VALUES (?, ?, ?, ?, 
										            ?, ?, ?, 
										            ?, ?, ?, 
										            ?, ?, ?, 
										            ?, ?, ?, ?, 
										            ?, ?, ?, 
										            ?, ?, ?, 
										            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING * ";

            //definição dos parametros<br>
            $this->db->setParams($nu_dap_juridica);
            $this->db->setParams($nu_cnpj);
            $this->db->setParams($no_fantasia);
            $this->db->setParams($no_razao_social);
            $this->db->setParams($co_tipo_organizacao);
            $this->db->setParams($no_filiacao_central_cooper);
            $this->db->setParams($no_representante_legal);
            $this->db->setParams($dt_inicio_mand_repres_legal);
            $this->db->setParams($dt_fim_mand_repres_legal);
            $this->db->setParams($nu_telefone_comercial);
            $this->db->setParams($nu_telefone_celular);
            $this->db->setParams($no_email_cetral_vendas);
            $this->db->setParams($email_administrativo);
            $this->db->setParams($no_sitio_eletronico);
            $this->db->setParams($co_ibge);
            $this->db->setParams($no_endereco);
            $this->db->setParams($qt_agricultores_fam);
            $this->db->setParams($qt_cooper_associ);
            $this->db->setParams($in_certificado_organico);
            $this->db->setParams($in_certificado_sustentabilidade);
            $this->db->setParams($in_certificado_fairtrade);
            $this->db->setParams($in_produto_sociobiodiversidade);
            $this->db->setParams($in_produto_origem_quilombola);
            $this->db->setParams($in_produto_origem_indigina);
            $this->db->setParams('1');
            $this->db->setParams($unicafes);
            $this->db->setParams($unisol);
            $this->db->setParams($ecovida);
            $this->db->setParams($ocb);
            $this->db->setParams($mst);
            $this->db->setParams($contag);
            $this->db->setParams($fetraf);
            $this->db->setParams($mpa);
            $this->db->setParams($mmc);

            $query_tb_organizacao = $this->db->query($sql_tb_organizacao);

            $co_organizacao = $query_tb_organizacao['co_organizacao'];


            $produtos = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();

            $verificar_produtos = true;

            if (count($produtos) > 0) {

                for ($a = 0; $a < count($produtos); $a++) {

                    // Executa a consulta
                    $sql = "INSERT INTO rl_organizacao_produto(co_organizacao, co_produto_montado)
										    VALUES (?, ?) RETURNING * ";

                    //definição dos parametros
                    $this->db->setParams($co_organizacao);
                    $this->db->setParams($produtos[$a]['co_produto_montado']);

                    $query = $this->db->query($sql);

                    if (!$query) {//verifica as querys

                        $verificar_produtos = false;

                    }

                }

            } else {

                $verificar_produtos = false;

            }


            if (!$query_tb_organizacao || !$verificar_produtos) {//verifica as querys

                $this->db->rollBackPDO(); //Comando para desfazer a ação todas as querys que foram executadas na transação.

            } else {

                unset($_SESSION['produtos']);  // irá remover apenas os dados de 'produtos'
                $this->db->commitPDO(); //Comando para confirmar a execução de todas as querys executadas na transação.
                $validar = true;

            }


            // Verifica se a consulta está OK e configura a mensagem
            if (!$validar) {

                $this->form_msg = '<p class="bg-danger">Internal error. Data has not been sent.</p>';

                // Termina
                return 'error';

            } else {

                $this->form_msg = '<p class="bg-primary">Inserida com sucesso.</p>';

                // Termina
                return 'success';
            }

            // Termina
            return;

        } //Fim Inserir.


    } // validate_register_form


    /**
     * Listar tipo_organizacao
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_tipo_organizacao()
    {


        $sql = "SELECT co_tipo_organizacao, ds_tipo_organizacao FROM tb_tipo_organizacao";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar tipo_organizacao


    /**
     * Listar produtos
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function listar_produtos()
    {


        $sql = "SELECT 	prod.co_produto, 
						prod.ds_produto
				  FROM rl_produto_montado mont
				INNER JOIN   tb_produto prod
				 ON (mont.co_produto = prod.co_produto)
				 GROUP BY	prod.co_produto,
						prod.ds_produto
				ORDER BY 	prod.ds_produto	";


        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } // Listar produtos


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