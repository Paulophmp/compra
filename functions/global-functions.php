<?php
/**
 * Verifica chaves de arrays
 *
 * Verifica se a chave existe no array e se ela tem algum valor.
 * Obs.: Essa função está no escopo global, pois, vamos precisar muito da mesma.
 *
 * @param array  $array O array
 * @param string $key   A chave do array
 * @return string|null  O valor da chave do array ou nulo
 */
function chk_array ( $array, $key ) {
    // Verifica se a chave existe no array
    if ( isset( $array[ $key ] ) && ! empty( $array[ $key ] ) ) {
        // Retorna o valor da chave
        return $array[ $key ];
    }
    
    // Retorna nulo por padrão
    return null;
} // chk_array


/**
 * Enviar E-mail
 *
 * Enviar e-mails pelo PHP usando o PHPMailer
 *
 * @param array  $array O array
 * @param string $key   A chave do array
 * @return string|null  O valor da chave do array ou nulo
 */
function enviar_email ( $para, $assunto ,$message) {

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();                                  # Set mailer to use SMTP
        $mail->Timeout  = 30;                             # set the timeout (seconds)
        $mail->Host     = MAIL_HOSTNAME;                  # Specify main and backup SMTP servers
        $mail->SMTPAuth = false;                          # For enable SMTP authentication set true        
        $mail->Port     = MAIL_PORT;                      # TCP port to connect to

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->AddBCC('paacomprainstitucional@mds.gov.br'); // Cópia Oculta
        $mail->AddBCC('compras.institucionais@mds.gov.br'); // Cópia Oculta
        $mail->addAddress($para);                         # Add a recipient
        $mail->isHTML(true);                              # Set email format to HTML
        $mail->CharSet = "UTF-8";                        # Set charset

        $mail->Subject = $assunto;
        $mail->Body    = $message;

        $mail->Send();

        return 'enviado';

    } catch (phpmailerException $e) {

        $ErrorInfo =  "Error mail function.".$e;


    }


} // enviar_email



/**
 * Valida CNPJ
 *
 * @param string $cnpj 
 * @return bool true para CNPJ correto
 *
 */
function valida_cnpj ( $cnpj ) {
    // Deixa o CNPJ com apenas números
    $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
    
    // Garante que o CNPJ é uma string
    $cnpj = (string)$cnpj;
    
    // O valor original
    $cnpj_original = $cnpj;
    
    // Captura os primeiros 12 números do CNPJ
    $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
    
    /**
     * Multiplicação do CNPJ
     *
     * @param string $cnpj Os digitos do CNPJ
     * @param int $posicoes A posição que vai iniciar a regressão
     * @return int O
     *
     */
    if ( ! function_exists('multiplica_cnpj') ) {
        function multiplica_cnpj( $cnpj, $posicao = 5 ) {
            // Variável para o cálculo
            $calculo = 0;
            
            // Laço para percorrer os item do cnpj
            for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
                // Cálculo mais posição do CNPJ * a posição
                $calculo = $calculo + ( $cnpj[$i] * $posicao );
                
                // Decrementa a posição a cada volta do laço
                $posicao--;
                
                // Se a posição for menor que 2, ela se torna 9
                if ( $posicao < 2 ) {
                    $posicao = 9;
                }
            }
            // Retorna o cálculo
            return $calculo;
        }
    }
    
    // Faz o primeiro cálculo
    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
    
    // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
    // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
    $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
    
    // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
    // Agora temos 13 números aqui
    $primeiros_numeros_cnpj .= $primeiro_digito;
 
    // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
    $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
    $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
    
    // Concatena o segundo dígito ao CNPJ
    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
    
    // Verifica se o CNPJ gerado é idêntico ao enviado
    if ( $cnpj === $cnpj_original ) {
        return true;
    }
}

/*
*
*PHP mascara - PHP mask
*Usar para qualquer tipo de mascara que deseje exemplos abaixo com data, cep, cnpj e cpf
*
*/

function mask($val, $mask)
{
     $maskared = '';
     $k = 0;
     for($i = 0; $i<=strlen($mask)-1; $i++)
     {
        if($mask[$i] == '#')
        {
            if(isset($val[$k]))
            $maskared .= $val[$k++];
        }
        else
        {
             if(isset($mask[$i]))
             $maskared .= $mask[$i];
        }
     }
     return $maskared;
}
//Exemplos de máscaras em php
// $cnpj = "11222333000199";
// $cpf = "00100200300";
// $cep = "08665110";
// $data = "10102010";

// echo mask($cnpj,'##.###.###/####-##');
// echo mask($cpf,'###.###.###-##');
// echo mask($cep,'#####-###');
// echo mask($data,'##/##/####');


/**
 * Função para carregar automaticamente todas as classes padrão
 * Ver: http://php.net/manual/pt_BR/function.autoload.php.
 * Nossas classes estão na pasta classes/.
 * O nome do arquivo deverá ser class-NomeDaClasse.php.
 * Por exemplo: para a classe ResuasMVC, o arquivo vai chamar class-ResuasMVC.php
 */
function __autoload($class_name) {

    if ($class_name == 'PHPMailer' || $class_name == 'SMTP') {

        $file = ABSPATH . '/includes/PHPMailer-master/class.'.strtolower($class_name).'.php';

    }else{

        $file = ABSPATH . '/classes/class-' . $class_name . '.php';

    }
    
    if ( ! file_exists( $file ) ) {
        require_once ABSPATH . '/includes/404.php';
        return;
    }
    
    // Inclui o arquivo da classe
    require_once $file;
} // __autoload


