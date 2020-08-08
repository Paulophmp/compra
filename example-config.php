<?php
/**
 * Configuração geral
 */
// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );

// Caminho para a pasta de uploads
define( 'UP_ABSPATH', ABSPATH . '/views/_uploads' );

// URL da home
define( 'HOME_URI', 'HOME_URI_VAL');

// Duração de vida do Token por dia
define( 'DURACAO_TOKEN', '@@DURACAO_TOKEN@@' );


/** DB properties */
// Nome do host da base de dados
define( 'HOSTNAME', '@@HOSTNAME@@' );

// Nome do banco de dados
define( 'DB_NAME', '@@DB_NAME@@' );

// Usuário da base de dados
define( 'DB_USER', '@@DB_USER@@' );

// Senha do usuário da base de dados
define( 'DB_PASSWORD', '@@DB_PASSWORD@@' );

//port do DB
define( 'DB_PORT', '5432' );

// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );
/** Fim - DB properties */

/** Mail properties */
// Endereço do servidor SMTP
define( 'MAIL_HOSTNAME', '@@MAIL_HOSTNAME@@' );

// Usuário do servidor SMTP
define( 'MAIL_USER', '@@MAIL_USER@@' );

//Senha do servidor SMTP
define( 'MAIL_PASSWORD', '@@MAIL_PASSWORD@@' );

//port do MAIL - 587
define( 'MAIL_PORT', '@@MAIL_PORT@@' );

// Define o remetente email
define( 'MAIL_FROM', '@@MAIL_FROM@@' );

// Define o remetente nome
define( 'MAIL_FROM_NAME', '@@MAIL_FROM_NAME@@' );
/** Fim - MAIL properties */

// Se você estiver desenvolvendo, modifique o valor para true
define( 'DEBUG', '@@DEBUG@@' );

// Variavel de Ambiente
define( 'ENV', 'dev');

// EMAIL de Ambiente
define( 'EMAIL_TO', 'paacomprainstitucional@cidadania.gov.br');

/**
 * Não edite daqui em diante
 */

// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';