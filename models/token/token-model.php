<?php

/**
 * Modelo para gerenciar Token
 *
 * @package DtiMVC
 * @since 0.1
 */
class TokenModel extends DtiModel
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
    public function validar_token($id, $cnpj)
    {

        // Precisaremos de uma instância da classe Phpass
        $password_hash = new PasswordHash(8, FALSE);

        // Cria o token_hash hash
        $token_hash = $password_hash->HashPassword($cnpj);

        // Executa a consulta
        $sql = "UPDATE compra_institucional_paa.tp_acesso
							   SET co_token=?, dt_token=?, st_ativo=?
							 WHERE co_acesso=? AND nu_cnpj=? RETURNING * ";


        //definição dos parametros

        $this->db->setParams($token_hash);
        $this->db->setParams('now');
        $this->db->setParams('true');
        $this->db->setParams($id);
        $this->db->setParams($cnpj);

        $query = $this->db->query($sql);


        // Verifica se a consulta está OK e configura a mensagem
        if (!$query) {

            $this->form_msg = '<p class="bg-danger">Internal error. Data has not been sent.</p>';

            // Termina
            return false;

        } else {

            $sql_cnpj = "SELECT co_organizacao, nu_cnpj
					  				FROM tb_organizacao where nu_cnpj = '" . $cnpj . "' ";


            //consulta os dados
            $retorno_cnpj = $this->db->query($sql_cnpj);

            if ($retorno_cnpj) {

                $link = '<a href="' . HOME_URI . '/editar/?token=' . $query['co_token'] . '">' . HOME_URI . '/editar/?token=' . $query['co_token'] . '</a>';

            } else {

                $link = '<a href="' . HOME_URI . '/cadastro/?token=' . $query['co_token'] . '">' . HOME_URI . '/cadastro/?token=' . $query['co_token'] . '</a>';

            }


            // multiple recipients
            $para = $query['no_email'];

            //assunto
            $assunto = 'Compras Institucionais';


            // message
            $message = '
                                <html>
                                    <head>
                                      <title>Registro de Atendimento</title>
                                    </head>
                                    <body>
                                        <p> Prezado (a), </p>
                                        <p>Agradecemos seu contato e encaminhamos link de acesso ao formulário para cadastramento de seu Empreendimento no <b>Portal de Compras da Agricultura Familiar.</b></p>
                                            <b>link:</b> ' . $link . '
                                        <p>
                                        <b>Importante: O acesso ao Formulário de Cadastro do Portal de Compras da Agricultura Familiar, estará disponível até que as informações sejam cadastradas e salvas. O acesso será invalidado após o envio das informações. Para alterações do cadastro será necessário nova solicitação ao <a href="paacomprainstitucional@cidadania.gov.br">paacomprainstitucional@cidadania.gov.br</a>.</b>
                                        <p>   
                                        <p>Atenciosamente,</p>
                                        <p>
                                        Equipe PAA Compra Institucional</br>
                                        </p>
                                        Coordenação Geral de Aquisição e Distribuição de Alimentos - CGDIA</br>
                                        Departamento de Compras Públicas para Inclusão Social e Produtiva - DECOMP</br>
                                        Secretaria Nacional de Inclusão Social e Produtiva Rural - SEISP</br>
                                        Secretaria Especial de Desenvolvimento Social - SEDS</br>
                                        
                                        Ministério da Cidadania - MC</br>
                                        Tel: (61) 2030-1059/1185
                                                                
                                    </body>
                                </html>';

            $query['retorno'] = enviar_email($para, $assunto, $message);

            if ($query['retorno'] == 'enviado') {

               // enviar_email('philipe.almeida@terceirizado.mds.gov.br', $assunto, $message);

            }

            // Termina
            return $query;
        }

        // Termina
        return;


    } // validar_token


    /**
     * Buscar verificar_cnpj
     *
     * @since 0.1
     * @access public
     * @return array Os dados da base de dados
     */
    public function verificar_cnpj($cnpj)
    {


        // Executa a consulta
        $sql = "SELECT co_acesso, nu_cnpj, no_email, co_token, dt_token, st_ativo
  				FROM compra_institucional_paa.tp_acesso where nu_cnpj = ? ";

        //definição dos parametros
        $this->db->setParams($cnpj);

        //consulta os dados
        $retorno = $this->db->query($sql);


        // // Retorna
        return $retorno;


    } //Buscar verificar_cnpj


} // PrincipalModel