<?php
/**
 * Essa classe é responsável por permitir a conexão e a execução de consultas e
 * operações no Banco de Dados. Basicamente, para utilizar a classe, basta
 * instânciá-la e chamar o método query().
 *
 * Exemplo:<br>
 * $bd = new Banco('nome_database');<br>
 * $retorno = $bd->query('select * from dados.tabela where 1=1');<br>
 * <br>
 * $bd->close();<br>
 * Para utilizar prepared statements verifique as informações do método setParams.<br>
 *
 * $bd = new Banco('nome_database');<br>
 * $sql = 'select * from dados.tabela where id=? and nome=?;<br>
 * <br>
 * //definição dos parametros<br>
 * $bd->setParams(1);<br>
 * $bd->setParams('joão');<br>
 *
 * //consulta os dados<br>
 * $retorno = $bd->query($sql);<br>
 * $bd->close();
 *
 */

class DtiDB
{
    /** DB properties */
    public $host_db      = 'localhost', // Host da base de dados
           $db_name_db   = '',    // Nome do banco de dados
           $password_db  = '',          // Senha do usuário da base de dados
           $user_db      = '',      // Usuário da base de dados
           $charset_db   = 'utf8',      // Charset da base de dados
           $pdo_db       = null,        // Nossa conexão com o BD
           $error_db     = null,        // Configura o erro
           $debug_db     = false,       // Mostra todos os erros
           $last_id_db   = null;        // Último ID inserido
    public $resultado_db;
    private $ora_conecta_db;       //identificador de conexão


    /**
     * Construtor da classe
     *
     * @since 0.1
     * @access public
     * @param string $host
     * @param string $db_name
     * @param string $password
     * @param string $user
     * @param string $charset
     * @param string $debug
     */
    public function __construct(
        $banco       = null,
        $host_db     = null,
        $db_name_db  = null,
        $password_db = null,
        $user_db     = null,
        $charset_db  = null,
        $debug_db    = null
    ) {

        // Configura as propriedades novamente.
        // Se você fez isso no início dessa classe, as constantes não serão
        // necessárias. Você escolhe...
        $this->host_db     = defined( 'HOSTNAME'    ) ? HOSTNAME    : $this->host_db;
        $this->db_name_db  = defined( 'DB_NAME'     ) ? DB_NAME     : $this->db_name_db;
        $this->password_db = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : $this->password_db;
        $this->user_db     = defined( 'DB_USER'     ) ? DB_USER     : $this->user_db;
        $this->charset_db  = defined( 'DB_CHARSET'  ) ? DB_CHARSET  : $this->charset_db;
        $this->debug_db    = defined( 'DEBUG'       ) ? DEBUG       : $this->debug_db;

        // Conecta
        $this->Banco('ci_sesan');
        $this->query('SET search_path TO compra_institucional_paa;');

        


    } // __construct

    private $numero_conexao;
    private $numero_cursor;
    private $indice;
    
    
    /**
     * atributo que armazena o nome do banco em que o usuário está conectado
     * @access private
     * @name $bancoCorrente
     */
    private $bancoCorrente;
    
    
     /**
     * atributo que armazena o tipo de driver utilizado para conexão com o
      * database. Ex: pgsql (Postgres), oci(Oracle), odbc e etc
     * @access private
     * @name $driver
     */
    private $driver;
    
    
    /**
     * Atributo que armazena um valor booleano (true or false) que determina
     * para a classe, se em cada operação de persistência (insert,delete,update)  
     * a transação será efetivada (commit) automaticamente ou não.
     * @access private
     * @name $autocomitt
     */
    private $autocomitt;
    
    
    /**
     * Atributo que armazena um objeto PDO gerado para conexão com o database.
     * Através desse atributo(objeto), é possível acessar todas as propriedades
     * e métodos do objeto PHP PDO.
     * @access private
     * @name $pdo
     */
    private $pdo;
    
    /**
     * Esse atributo é utilizado para armazenar um array com diversas
     * propriedades que se exige para conexão com alguns bancos. 
     * Exemplo:. Para conexão com Oracle: ssid
     * array("ssid"=>"mds")
     * @access private
     * @name $params_banco
     */
    private $params_banco;
    
    
    /**
     * Esse atributo é utilizado para armazenar um booleano(true or false) que
     * determinará se a classe irá utilizar as declarações preparadas
     * (prepare statement)     * 
     * @access private
     * @name $use_prepare
     */
    private $use_prepare;
    
    /**
     * Atributo que armazena um array com os detalhes do último erro ocorrido na
     * operação. Lista o código do erro e a mensagem informada pelo SGDB.          
     * @access private
     * @name $erro
     */
    private $erro;
    
    /**
     * Atributo que armazena um array com os parâmetros a serem utilizados na
     * consulta preparada, que utiliza o prepare statment     
     * @access private
     * @name $params
     */
    private $params;
    
    
    
    /**
     * Atributo que armazena um valor booleano que determina se a classe irá
     * identificar o tipo do parametro passado       
     * @access private
     * @name $checar_tipo_do_parametro_automaticamente
     */
    private $checar_tipo_do_parametro_automaticamente;
    
    
    private $listar;
     /**
     * Atributo que armazena um valor booleano que determina se a classe irá
     * identificar o tipo do parametro passado       
     * @access private
     * @name $checar_tipo_do_parametro_automaticamente
     */
    //private $listar;
    
     /**
     * Atributo que armazena uma descrição informada pelo usuário da conexão
      * efetuada     
     * @access private
     * @name $descricao
      */
    
    private $descricao;
    /*
    
    
     * Atributo que armazena uma descrição informada pelo usuário da conexão
      * efetuada     
     * @access private
     * @name $descricao
      
    private $nome;*/
    private $nome;
    
    /**
     * Atributo que armazena um valor booleano (true or false) que determina se 
     * a classe irá apenas efetuar operações (insert, delete,update)           
     * @access private
     * @name $use_mt_query
     */
    private $use_mt_query;
    
     /**
     * Atributo que armazena um objeto PDO decorrente da conexão com o banco
      * gerente_bds no servidor marfim
     * @access private
     * @name $con_gerente_bancos
      */
    private $con_gerente_bancos;
    
    /**
     * Atributo que armazena um booleano que determina se classe irá iniciar
     * ou não uma transação com o banco de dados automaticamente      
     * @access private
     * @name $starta_transacao
     */
    private $starta_transacao;
    
    /**
     * Atributo utilizado para armazenar o nome do banco de dados          
     * @access private
     * @name $dbname
     */
    private $dbname;
    
    /**
     * Atributo utilizado para armazenar a porta de conexão com o banco de dados          
     * @access private
     * @name $port
     */
    private $port;
    
    /**
     * Atributo utilizado para armazenar o usuário utilizado para conexão 
     * com o banco de dados          
     * @access private
     * @name $usuario
     */
    private $usuario;
    
    /**
     * Atributo utilizado para armazenar a senha do usuário utilizada para conexão 
     * com o banco de dados          
     * @access private
     * @name $senha
     */
    private $senha;
    
    
    /**
     * Atributo utilizado para armazenar a nome ou ip da máquina onde se encontra
     * o banco de dados     
     * @access private
     * @name $host
     */
    private $host;

    /**
     * Atributo utilizado para armazenar a nome ou ip da máquina onde se encontra
     * o banco de dados     
     * @access private
     * @name $host
     */
    private $texto_sql_banco;
    
    /**
     *
     * Atributo que armazena o último retorno de uma execução de query
     * @access private
     * @name $ultimo_result_query_exec; 
     */
    private $ultimo_result_query_exec;
    
    /** 
    * Procedimento utilizado para efetuar uma conexão com o banco gerente_bds
     * no servidor marfim e armazenar um objeto PDO no atributo 
     * $con_gerente_bancos;
    * @access private              
    */ 
    private function getConexaoGerBds(){
        $this->con_gerente_bancos=false;
        try{
            
            $str_con =new PDO('pgsql:host=marfim port=5432 dbname=gerente_bds user=postgres password=.sagi@mds');
            
            if($str_con)
                $this->con_gerente_bancos = $str_con;
            
        }
        catch( PDOException $Exception ) {
            // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
            // String.
            //throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
            $str_con=null;
            die("<code>Não foi possível encontrar a configuração do Banco "
                    . "de dados....<br> Se o problema persistir, contate o "
                    . "administrador do sistema.\n<br> [ERRO] ".
                    $Exception->getCode()." - ".$Exception->getMessage().
                    "</code>");
        }
    }
    
    
    /** 
    * Método utilizado para se obter um array com as informações de conexão de
    * um determinado banco em que se deseja conectar. É necessário informar a 
     * chave (nome) de identificação do banco na tabela bd.bd_conf para que o
     * método retorne um array com o host,porta,usuario,senha,dbname e etc    
    * @access public 
    * @param String $ch Nome chave da conexão
    * @param String $sistema Parâmetro que define o sistema em que será obtido a conexão pelo nome definido em $ch
    * @return Array 
    */
    public function getArrInfoBancoCorrente($ch,$sistema=''){
        if(($ch<>'')and($this->con_gerente_bancos)){
            $sql="select * from bd.bd_conf where nome_chave='".$ch."'".($sistema<>''?" and sistema='".$sistema."'":"");
            $pdo = $this->con_gerente_bancos;
            $stmt = $pdo->prepare($sql);

            $rs=$stmt->execute();
            $this->con_gerente_bancos=null;
            $pdo=null;
            
            
            if($rs){
                    $retorno= $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt=null;
                    return $retorno;
            }else{
                    return false;
            }
            
            
            
        }else{
            return false;
        }
    }
    
    
    
    /** 
    * Método construtor da classe. Em geral, ele é acionado no momento da
     * instanciação da classe para se conectar ao banco desejado.   
     * <br>
     * O mais importante nessa classe é fornecer o nome chave correspondente
     * ao banco de dados (variável $banco_de_dados) do arquivo .ini ou da tabela
     * bd.bd_conf.
     * <br>
     * Caso o parâmetro $tp tenha o valor definido como 'ini', a classe irá 
     * procurar as informações dos bancos de dados em um 'arquivo.ini' central
     * e poderá se conectar apenas com o banco de dados Postgres
     * <br>
     * Caso o parâmetro $tp tenha o valor definido como 'bd', será necessário 
     * informar o driver de conexão, os parâmetros adicionais caso tenha e o 
     * sistema (não é obrigatório). Dessa forma, será possível se conectar aos
     * sgdbs PostgreSQL, MYSql, DB2(não testado), Oracle (não testado).
     * Utilizando o parâmetro $tp com valor 'bd' a classe irá procurar as 
     * configurações dos bancos de dados dentro da tabela gereten_bds.bd.bd_conf
     * no servidor marfim
     *  <br>
     * 
    * @access public 
    * @param String $banco_de_dados
    * @param String $driver
    * @param String $params_banco
    * @param String $sistema
    * @param String $tp
    * @return void 
    */
    public function Banco($banco_de_dados,$driver='pgsql',$params_banco=array(),$sistema='',$tp='ini') {
        
        $this->con_gerente_bancos=false;
        $this->setNumeroConexao('');
        $this->setNumeroCursor('');
        $this->setIndice('');
        $this->setBancoCorrente($banco_de_dados);
        $this->setDriver($driver);
        $this->setParamsBanco($params_banco);
        $this->setUsePrepare(0);
        $this->params=false;
        
        $this->setAutocommit(false);
        $this->setStarta_transacao(0);
        
        if($tp=='bd'){
            //conecta utilizando o banco gerente_bds, por sistema
            
            if((!empty($banco_de_dados))){
                
                $this->logon1($this->getBancoCorrente(),$sistema);
            }

        }else{     
            
            //conecta utilizando o ini
            if((!empty($banco_de_dados))and(!empty($driver))){
                $this->logon($this->getBancoCorrente(),$this->getDriver(),$this->getParamsBanco());
            }
        }
        
        
    }
    
    
    /** 
    * O método logon é acionado pela método construtor da classe para efetuar 
     * a conexão com um banco de dados especificado pelo parâmetro $banco. Ele
     * será acionado caso o parâmetro $tp do método Banco tenha o valor definido
     * como $tp='ini'. <br>
     * Esse método busca os detalhes da conexão do database em um arquivo ini 
     * central chamado BancoDeDadosIniCentralX.ini 
     * 
    * @access public 
    * @param String $banco
    * @param String $driver
    * @param String $params_banco   
    * @return void 
    */
    public function logon($banco,$driver='pgsql',$params_banco=array()){
        
        if($this->getBancoCorrente()<>'')
            $pdo = null;
        
        global $_SESSION, $estado_atual;
        $key="";
        $value="";
        //$arr_prog = (file_exists("ini/BancoDeDados.ini")) ? parse_ini_file("ini/BancoDeDados.ini",true) : parse_ini_file("../ini/BancoDeDados.ini",true);
        
        $arr_prog = parse_ini_file("ini/BancoDeDados.ini",true);


        if ($banco == null) {
            list($key, $value) = each($arr_prog);
            $this->setBancoCorrente($key);
        }
        else
        {
            while (list($key, $value) = each($arr_prog))
            {
                if ($key == $banco)
                {
                 $this->setBancoCorrente($key);
                  break;
                }
            }
        }
        if(isset($value['driver'])){
            if($value['driver']<>'')
                $this->setDriver($value['driver']);
        }
        
        
        try { 
            if($this->getDriver()=='pgsql'){//postgres

                //Autenticação via arquivo ini
                //$this->pdo = new PDO($this->getDriver().':host='.$value['host'].' port='.$value['port'].' dbname='.$value['dbname'].' user='.$value['user'].' password='.$value['password']);

                //Autenticação via arquivo config
                $this->pdo = new PDO($this->getDriver().':host='.HOSTNAME.' port='.DB_PORT.' dbname='.DB_NAME.' user='.DB_USER.' password='.DB_PASSWORD);
            

            }else if(($this->getDriver()=='db2')or($this->getDriver()=='ibm')){//db2
                
                $con_string="ibm:DRIVER={IBM DB2 ODBC DRIVER};DATABASE=".$value['dbname'].";" .
                        "HOSTNAME=".$value['host'].";PORT=".$value['port'].";PROTOCOL=".($value["protocol"]<>''?$value["protocol"]:'TCPIP').";";
                /*$con_string="odbc:Driver={SQL Native Client};Server=".$value['host'].
                        ";Port=".$value['port'].";Database=".$value['dbname']."; Uid=".$value['user'].
                        ";Pwd=".$value['password'].";";*/
                
                //$con_string=$this->getDriver().':host='.$value['host'].' port='.$value['port'].' dbname='.$value['dbname'].' user='.$value['user'].' password='.$value['password'];
                $this->pdo = new PDO($con_string,$value["user"],$value["password"]); 

            }else if($this->getDriver()=='oci'){ //oracle


                    $con_string = $value['host'].":".$value['port']."/".$value["dbname"];

                $this->pdo = new PDO("oci:dbname=".$con_string,$value["user"],$value["password"],$this->getParamsBanco());   

            }else if($this->getDriver()=='mysql'){ //mysql
                $this->pdo = new PDO($con_string,$value["user"],$value["password"],$this->getParamsBanco());            
            }
            
        }
        catch( PDOException $Exception ) {
            // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
            // String.
            //throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
            $this->pdo=null;
            die("<code>Não foi possível efetuar a conexão com o banco de dados...\n <br> [ERRO]: ".$Exception->getMessage()."</code>");
                    //.$value['dbname']." em ".$value['host'].":".$value["port"]." \n <br>[ERRO] ".$Exception->getCode()." - ".;
        }
        
        
    }
    
                        
 
    /**
    * O método logon é acionado pela método construtor da classe para efetuar
     * a conexão com um banco de dados especificado pelo parâmetro $banco. Ele
     * será acionado caso o parâmetro $tp do método Banco() tenha o valor definido
     * como $tp='bd'.
     * Esse método busca os detalhes da conexão do database na tabela
     * gerente_bds.bd.bd_conf no host 10.68.12.244. Nessa tabela as
     * configurações de cada banco de dados estão separadas por sistemas, o que
     * pode também ser informado nesse método através do parâmetro $sistema
     *
    * @access public
    * @param String $banco
    * @param String $sistema
    * @return void
    */
    public function logon1($banco,$sistema=''){ //conecta utilizando o banco de dados

        if($this->getBancoCorrente()<>'')
            $pdo = null;

        global $_SESSION, $estado_atual;
        $key="";
        $value="";
        //$arr_prog = (file_exists("ini/BancoDeDados.ini")) ? parse_ini_file("ini/BancoDeDados.ini",true) : parse_ini_file("../ini/BancoDeDados.ini",true);
        $this->getConexaoGerBds();
        if(!$this->con_gerente_bancos)
            die('<code>Não foi possível obter a configuração do banco de dados do gerente de bancos.</code>');
        $arr_conf_banco = $this->getArrInfoBancoCorrente($this->getBancoCorrente(),$sistema);
        if(($arr_conf_banco)and(count($arr_conf_banco)>0)){
            $host='';
            $dbname='';
            $user='';
            $passwd='';
            $nome='';
            $driver='';
            $port='';

            while(list($key,$value)=each($arr_conf_banco)){
                if($key=='dbname'){
                    $this->setBancoCorrente(trim($value));
                    $dbname=trim($value);
                }
                if($key=='driver'){
                    $this->setDriver(trim($value));
                    $driver=trim($value);
                }
                if($key=='host'){
                    $host=trim($value);
                }
                if($key=='user'){
                    $user=trim($value);
                }

                if($key=='passwd'){
                    $passwd=trim($value);
                }
                if($key=='port'){
                    $port=trim($value);
                }
                if($key=='nome'){
                    $nome=trim($value);
                    $this->setNome(trim($value));
                }
                if($key=='listar'){
                    $listar=trim($value);
                    $this->setListar(trim($value));
                }
                if($key=='descricao'){
                    $descricao=trim($value);
                    $this->setDescricao(trim($descricao));
                }

            }
            if(($host<>'')and($dbname<>'')and($user<>'')and($port<>'')){
                $this->pdo=null;
                try {

                    if($this->getDriver()=='pgsql'){
                        $str = $driver.':host='.$host.' port='.$port.' dbname='.$dbname.' user='.$user.' password='.$passwd;

                        $this->pdo = new PDO($str);
                        $this->setHost($host);
                        $this->setPort($port);
                        $this->setDbName($dbname);
                        $this->setUsuario($user);
                        $this->setSenha($passwd);

                    }else{
                        $this->pdo = new PDO($con_string,$user,$passwd,$this->getParamsBanco());
                    }

                }
                catch( PDOException $Exception ) {
                    // PHP Fatal Error. Second Argument Has To Be An Integer, But PDOException::getCode Returns A
                    // String.
                    //throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
                    $this->pdo=null;
                    die("<code>Não foi possível efetuar a conexão com o banco de dados... \n <br>[ERRO]: ".$Exception->getMessage()."</code>");
                            //.$dbname." em ".$host.":".$value["port"]." \n [ERRO] ".$Exception->getCode()." - ".$Exception->getMessage()."</code>");
                }
            }else{
                $this->pdo=null;
            }
        }else{
            $this->pdo=null;
        }



    }


    /**
    * O método close() é utilizado para fechar uma conexão efetuada com o banco
     * de dados corrente. Em geral, ele limpa as variáveis que referenciam o
     * banco atual conetado e libera o objeto pdo.
    * @access public
    * @return void
    */
    public function close(){
        $this->setBancoCorrente('');
        $this->setDriver('');
        $this->setIndice('');
        $this->setNumeroConexao('');
        $this->setNumeroCursor('');
        $this->setParamsBanco(array());
        $this->pdo=null; //se tiver conexão aberta vai destruir a classe
        $this->setAutocommit(false);
        $this->setUsePrepare(true);
        $this->setAutocommit(false);
    }




   /**
    * O método exec() é utilizado para executar uma operação sql no banco
    * de dados (insert, delete,update). Esse método não efetua consultas
    * (Select) no database.
    * Caso ao executar a operação sgdb retorne falha, o método
    * armazenará um array com o código do erro e com a mensagem devolvida
    * no atributo errorInfo() e retornará 0 (false)    *
    * @access private
    * @param  String $textosql
    * @return boolean
    */
    private function exec($textosql){
        $retorno=0;
        //$this->params=false;
        //$this->params=false;


        $this->ultimo_result_query_exec=false;
        if(empty($textosql))
            return 0;

        if(is_object($this->getPdo())){
  

            if(!$this->getAutocommit()){
                //$this->getPdo()->beginTransaction();
            }


            $qtd_prepares=0;
            if(is_array($this->getParams())){
                $qtd_prepares =count($this->getParams());
            }
            if($qtd_prepares>0)
                $this->setUsePrepare (1);
            else
                $this->setUsePrepare (0);

            if($this->getUsePrepare()){


                //usa prepare statments
                $pdo = $this->getPdo();
                $stmt = $pdo->prepare($textosql);
                if($stmt){ //se retornar um objeto PDOStatement
                    //vamos percorrer os parametros
                    $tipo=null;
                    $nm_chave="";
                    $paras =$this->getParams();
                    while(list($key,$value)=each($paras)){
                        if($value=='null'){
                            $stmt->bindValue($key,null,PDO::PARAM_NULL);
                        }else{
                            $param = $this->getPDOTipagemValor($value);
                            if($param=='')
                                $stmt->bindValue($key,$value);
                            else {
                                $stmt->bindValue($key,$value,$param);
                            }
                        }
                    }

                    //executa a consulta
                    $retorno=$stmt->execute();
                    $return_idx=false;
                    if($retorno){
                        try{
                            $return_idx = $stmt->fetch(PDO::FETCH_BOTH);
                        }  catch( PDOException $Exception ) {
                            $return_idx=0;
                        }
                    }

                    if($return_idx>0)
                        $retorno = $return_idx;

                    $arr_erro =$this->pdo->errorInfo();
                    $cod_erro = (integer)$arr_erro[0];
                    $cod_erro1 = (integer)$arr_erro[1];
                    $msg_erro = $arr_erro[2];

                    if(($cod_erro>0)and($cod_erro1>0)and($msg_erro<>''))
                        $retorno=0;


                }

            }else{


                try{

                    $retorno=$this->getPdo()->exec($textosql);
                    $arr_erro =$this->pdo->errorInfo();
                    $cod_erro = (integer)$arr_erro[0];
                    $cod_erro1 = (integer)$arr_erro[1];
                    $msg_erro = $arr_erro[2];
                    if(($cod_erro>0)and($cod_erro1>0)and($msg_erro<>''))
                        $retorno=0;
                    else
                        $retorno=1;

                }catch( PDOException $Exception ) {

                    $retorno=false;
                    $this->setErro($this->pdo->errorInfo());
                }
            }

        }


        if((!$retorno)and(!$this->getAutocommit())) {
            $this->setErro($this->pdo->errorInfo());
            //$this->getPdo()->rollBack();

        }

        if(($retorno)and(!$this->getAutocommit())){
           // $this->getPdo()->commit();
        }

        //limpa os params
        $this->params=false;
        $this->ultimo_result_query_exec=$retorno;


        return $retorno;
    }








    /**
    * O método query() é o método central para execução de consultas(Select) ou
    * para execução de operações (update,delete,insert) no banco de dados
    * conetado.<br>
    * Para efetuar operações (update,delete,insert) basta chamar esse método e
    * passa o código sql para o parâmetro $textosql. O método query() irá
    * verificar qual o tipo de operação que se deve executar e acionará
    * automaticamente o método privado $exec($textosql) que retornará para o
    * método query() true ou false, em caso de sucesso ou falha da execução.
    *<br>
    * Para executar Consultas (Select) basta informar o texto da consulta sql
    * no parâmetro $textosql e caso necessário, informar o tipo de retorno que
    * se quer obter no parâmetro $codigo_retorno conforme definições abaixo:      <br>
    * [0] -fetchAll — Returns an array containing all of the result set rows<br>
    * [1] -columnCount — Returns an array containing all of the result set rows <br>
    * [2] -execute — Executes a prepared statement(tru ou false)<br>
    * [3] -Fetch Assoc —  returns an array indexed by column name as returned in your result set          <br>
    * [4] -Fetch Into — updates an existing instance of the requested class, mapping the columns of the result set to named properties in the class <br>
    * [5] -Fetch Object — returns an anonymous object with property names that correspond to the column names returned in your result set <br>
    * [6] -FETCH_BOTH — (default): returns an array indexed by both column name and 0-indexed column number as returned in your result set <br>
    * [7] -FETCH_BOUND — Executes a prepared statement(tru ou false)<br>
    * [8] -FETCH_LAZY — combines PDO::FETCH_BOTH and PDO::FETCH_OBJ, creating the object variable names as they are accessed <br>
    * [9] -FETCH_NUM — returns an array indexed by column number as returned in your result set, starting at column 0<br>
    * [10] -FETCH_CLASS — returns a new instance of the requested class, mapping the columns of the result set to named <br>
    * properties in the class. If fetch_style includes PDO::FETCH_CLASSTYPE (e.g. PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE) then the name of the class is determined from a value of the first column. <br>
    * <br>
    * Para utilizar as declações preparadas (prepared statements) é necessário<br>
    * efetuar uma combinação desse método com o método setParams(), que<br>
    * armazenará os parâmetros passados a consulta:<br>
    * <br>
    * Exemplo: <br>
    * <br>
    * $sql="select * from dados.tabela where id=? and nome=?';<br>
    * $banco->setParams(1);<br>
    * $banco->setParams('joão');<br>
    * $resultado = $banco->query($sql);<br>
    * <br>
    * ou<br>
    * <br>
    * $sql_insert = "insert into dados.tabela(id,nome)values(:id,:nome);<br>
    * $banco->setParams(2,':id');  <br>
    * $banco->setParams(2,':nome');  <br>
    * $banco->query($sql_insert);<br>
    *<br>
    *
    * @access public
    * @param  String $textosql
    * @param  Integer $codigo_retorno
    * @return resorce or Boolean
    */
    public function query($textosql,$codigo_retorno=0){
        if(empty($textosql))
            return false;

        $this->ultimo_result_query_exec=false;
        $retorno=false;
        $stmt=false;
        $qtd_operacoes=1;

        $textosql=trim($textosql);
       // $qtd_operacoes=substr_count($textosql,';');
        $arr_palavras_reservadas=array('insert','create','update','delete','drop','alter','set','begin');
        $arr_palavras_reservadasC=array('create');
        $oper_palavra = strtolower(substr($textosql,0,6)); //insert, update,create,delete
        $oper_palavraC = strtolower(substr($textosql,0,6)); //create
        $oper_palavra2 = strtolower(substr($textosql,0,5)); //alter
        $oper_palavra5 = strtolower(substr($textosql,0,5)); //begin
        $oper_palavra3 = strtolower(substr($textosql,0,4)); //drop
        $oper_palavra4 = strtolower(substr($textosql,0,3)); //set
        $palavra = "";
        if(in_array($oper_palavra,$arr_palavras_reservadas)){
            //se for alguma das operações listadas acima, vamos verificar se existem múltiplas chamadas
            $palavra =$oper_palavra;
        }
        if(in_array($oper_palavraC,$arr_palavras_reservadasC)){
            //somente para o create
            $palavra =$oper_palavraC;
            //$this->setAutocommit(true);
        }
        if(in_array($oper_palavra2,$arr_palavras_reservadas)){
           //se for alguma das operações listadas acima, vamos verificar se existem múltiplas chamadas
            $palavra =$oper_palavra2;
            //$this->setAutocommit(true);
        }
        if(in_array($oper_palavra3,$arr_palavras_reservadas)){
           //se for alguma das operações listadas acima, vamos verificar se existem múltiplas chamadas
            $palavra =$oper_palavra3;
            //$this->setAutocommit(true);
        }
        if(in_array($oper_palavra4,$arr_palavras_reservadas)){
           //se for alguma das operações listadas acima, vamos verificar se existem múltiplas chamadas
            $palavra =$oper_palavra4;
            //$this->setAutocommit(true);
        }
        if(in_array($oper_palavra5,$arr_palavras_reservadas)){
           //se for alguma das operações listadas acima, vamos verificar se existem múltiplas chamadas
            $palavra =$oper_palavra4;
            //$this->setAutocommit(true);
        }

        if(!$this->getUse_mt_query()){
            if($palavra<>''){
                //vamos ver se tem várias operações
                //echo substr_count($textosql,$palavra." ")." - quantidade.";
                /*if(substr_count($textosql,$palavra)>1){
                    return $this->exec($textosql);
                }else if(($palavra=='alter')or($palavra=='drop')or($palavra=='create')){
                    return $this->exec($textosql);
                }*/
                $texto_auxsql = strtolower($textosql);
                $texto_auxsql="#".$textosql;
                $us_prep=$this->getUsePrepare();
                $oper_palavra = str_replace(';','',strtolower(substr($textosql,0,6))); //insert, update,create,delete
         
                if(in_array($oper_palavra,$arr_palavras_reservadas))
                {

                    return $this->exec($textosql);
                }
            }
        }
       /*echo "<pre>";
       echo $textosql;
       echo "</pre>";
        die();*/

        $rs=false;
        $qtd_prepares=0;
        if(is_array($this->getParams())){
            $qtd_prepares =count($this->getParams());
        }

        if(trim(strtolower(substr(trim($textosql),0,6)))<>'select'){ //só verifica o retorno se o resultado for um select
            $codigo_retorno =1; //muda o código de retorno para que seja retornado a quantidade de linhas: inseridas, dropadas, atualizadas e etc

        }

        if($qtd_prepares>0)
            $this->setUsePrepare (1);
        else
            $this->setUsePrepare (0);


        if(is_object($this->getPdo())){
            if($this->getUsePrepare()){

                try{
                    if($this->getStarta_transacao()){
                        if(!$this->getAutocommit()){
                            //$this->getPdo()->beginTransaction();
                        }
                    }

                    $pdo = $this->getPdo();
                    $stmt = $pdo->prepare($textosql);

                    if($stmt){ //se retornar um objeto PDOStatement

                        //vamos percorrer os parametros
                        $tipo=null;
                        $nm_chave="";
                        $paras =$this->getParams();
                        while(list($key,$value)=each($paras)){
                            if($value=='null'){
                                $stmt->bindValue($key,null,PDO::PARAM_NULL);
                            }else{
                                $param = $this->getPDOTipagemValor($value);
                                if($param=='')
                                    $stmt->bindValue($key,$value);
                                else {
                                    $stmt->bindValue($key,$value,$param);
                                }
                            }
                        }


                        //executa a consulta
                        $rs=$stmt->execute();

                        //vamos pegar os paramentros e passa-los
                        $retorno=false;
                        if($rs){

                            if($codigo_retorno==2){
                                $retorno=$rs;
                            }else{

                                    if((integer)$codigo_retorno==0)
                                        $retorno=$stmt->fetchAll();
                                    else if((integer)$codigo_retorno==1){
                                         if(trim(strtolower(substr(trim($textosql),0,6)))<>'select')
                                            $retorno=$rs;
                                        else
                                            $retorno=$stmt->columnCount();
                                    }else if((integer)$codigo_retorno>2){
                                        $pm = PDO::FETCH_ASSOC;
                                        switch ((integer)$codigo_retorno) {
                                            case 3: $pm = PDO::FETCH_ASSOC;break; //Fetch Assoc
                                            case 4: $pm = PDO::FETCH_INTO;break; //Fetch Assoc
                                            case 5: $pm = PDO::FETCH_OBJ;break; //Fetch Assoc
                                            case 6: $pm = PDO::FETCH_BOTH;break; //Fetch Assoc
                                            case 7: $pm = PDO::FETCH_BOUND;break; //Fetch Assoc
                                            case 8: $pm = PDO::FETCH_LAZY;break; //Fetch Assoc
                                            case 9: $pm = PDO::FETCH_NUM;break; //Fetch Assoc
                                            case 10: $pm = PDO::FETCH_CLASS;break; //Fetch Assoc
                                        }
                                        $retorno=$stmt->fetch($pm);
                                    }



                            }
                        }else{
                            $this->setErro($pdo->errorInfo());
                            $retorno=false;
                            $rs=false;
                        }
                    }else{
                        $this->setErro($this->pdo->errorInfo());
                        $retorno=false;
                        $rs=false;
                    }
                }catch( PDOException $Exception ) {

                        $retorno=false;
                        $rs=false;
                        $this->setErro($this->pdo->errorInfo());
                }

            }else{
                    //não utiliza o prepare
                 if($this->getStarta_transacao()){
                    if(!$this->getAutocommit()){
                        //$this->getPdo()->beginTransaction();
                    }
                 }

                    $pm = PDO::FETCH_ASSOC;
                    switch ((integer)$codigo_retorno) {
                        case 0: $pm = PDO::FETCH_ASSOC;break; //Fetch Assoc
                        case 1: $pm = PDO::FETCH_ASSOC;break; //Fetch Assoc
                        case 2: $pm = PDO::FETCH_ASSOC;break; //Fetch Assoc
                        case 3: $pm = PDO::FETCH_ASSOC;break; //Fetch Assoc
                        case 4: $pm = PDO::FETCH_INTO;break; //Fetch Assoc
                        case 5: $pm = PDO::FETCH_OBJ;break; //Fetch Assoc
                        case 6: $pm = PDO::FETCH_BOTH;break; //Fetch Assoc
                        case 7: $pm = PDO::FETCH_BOUND;break; //Fetch Assoc
                        case 8: $pm = PDO::FETCH_LAZY;break; //Fetch Assoc
                        case 9: $pm = PDO::FETCH_NUM;break; //Fetch Assoc
                        case 10: $pm = PDO::FETCH_CLASS;break; //Fetch Assoc
                    }





                    try{

                        $pdo = $this->getPdo();


                        $retorno=$pdo->query($textosql);


                        if($retorno){
                            $rs=true;
                            if((integer)$codigo_retorno==1){
                               if(trim(strtolower(substr(trim($textosql),0,6)))<>'select')
                                       $retorno=$rs;
                               else
                                $retorno = $retorno->rowCount();
                            }else if((integer)$codigo_retorno==0){
                                $retorno = $retorno->fetchAll();
                            }else if((integer)$codigo_retorno==2){
                                $retorno=$retorno->execute();
                            }else if((integer)$codigo_retorno>=3){
                               $retorno = $retorno->fetch($pm);
                            }
                        }else{
                            $this->setErro($pdo->errorInfo());
                        }
                    }catch( PDOException $Exception ) {
                        $retorno=false;
                        $this->setErro($this->pdo->errorInfo());
                        $rs=false;
                    }


            }
        }


        //zera os parametros
        $this->params=false;
         if($this->getStarta_transacao()){
            if((!$this->getAutocommit())and($rs)){
                //$pdo->commit();
            }
         }

         if($this->getStarta_transacao()){
            if((!$this->getAutocommit())and(!$rs)){
               //$pdo->rollBack();
            }
         }


        //limpa os params
        $this->params=false;
        $this->ultimo_result_query_exec=$retorno;

        return $retorno;
    }


    /**
    * O método getNumeroConexao() retorna o número da conexão corrente
    * @access public
    *
    * @return Integer
    */
    public function getNumeroConexao(){
        if(!empty($this->numero_conexao)){
            return $this->numero_conexao;
        }else{
            return false;
        }
    }


    /**
    * O método setNumeroConexao() define o número da conexão corrente
    * @access public
    * @param Integer $numero_conexao
    * @return Integer
    */
    public function setNumeroConexao($numero_conexao){
        if(!empty($numero_conexao)){
            $this->numero_conexao=$numero_conexao;
        }else{
            $this->numero_conexao=false;
        }
    }



    public function getNumeroCursor(){
        if(!empty($this->numero_cursor)){
            return $this->numero_cursor;
        }else{
            return false;
        }
    }

    public function setNumeroCursor($numero_cursor){
        if(!empty($numero_cursor)){
            $this->numero_cursor=$numero_cursor;
        }else{
            $this->numero_cursor=false;
        }
    }

    public function getIndice(){
        if(!empty($this->indice)){
            return $this->indice;
        }else{
            return false;
        }
    }

    public function setIndice($indice){
        if(!empty($indice)){
            $this->indice=$indice;
        }else{
            $this->indice=false;
        }
    }



    /**
    * O método setBancoCorrente() define o nome do banco a ser conectado
    * @access public
    * @param Integer $bancoCorrente
    * @return void
    */
    public function setBancoCorrente($bancoCorrente){
        if(!empty($bancoCorrente)){
            $this->bancoCorrente=$bancoCorrente;
        }else{
            $this->bancoCorrente=false;
        }
    }


    /**
    * O método getBancoCorrente() retorna o nome do banco a ser conectado
    * @access public
    * @return String
    */
    public function getBancoCorrente(){
        if(!empty($this->bancoCorrente)){
            return $this->bancoCorrente;
        }else{
            return '';
        }
    }


    /**
    * O método setDriver() define o o tipo de driver a ser utilizado na conexão
    * como o banco de dados: (pgsql - Postgres, oci - Oracle, db2 - DB2).
     * Caso o parâmetro $driver esteja vazio, será definido o driver de conexão
     * como postgres (pgsql)
    * @access public
    * @param Integer $driver
    * @return void
    */
    public function setDriver($driver){
        if(!empty($driver)){
            $this->driver=$driver;
        }else{
            $this->driver='pgsql';
        }
    }

    /**
    * O método getDriver() retorna o driver a ser utilizado na conexão
    * como o banco de dados: (pgsql - Postgres, oci - Oracle, db2 - DB2).
     * Caso não tenha nenhum driver setado no atributo, será retornado o driver
     * de conexão com postgres (pgsql)
    * @access public
    * @return string
    */
    public function getDriver(){
        if(!empty($this->driver)){
            return $this->driver;
        }else{
            return 'pgsql';
        }
    }


    /**
    * O método setPDO() define no atributo 'pdo' da classe, um objeto do tipo
    * PHP Data Objects (PDO), que é uma interface utilizada para acesso a
    * diversos bancos de dados pelo php. (para mais informações acesse:
    * http://php.net/manual/en/book.pdo.php)
    *
    *
    * @access private
    * @param PDO $pdo
    * @return void
    */
    private function setPDO(PDO $pdo){
        if(is_object($pdo)){
            $this->pdo=$pdo;
        }else{
            $this->pdo=null;
        }
    }


    /**
    * O método getPdo() retorna um objeto do tipo
    * PHP Data Objects (PDO), que é uma interface utilizada para acesso a
    * diversos bancos de dados pelo php. (para mais informações acesse:
    * http://php.net/manual/en/book.pdo.php)
    *
    *
    * @access public
    * @return PDO
    */
    public function getPdo(){
        if(is_object($this->pdo)){
            return $this->pdo;
        }else{
            return null;
        }
    }



    /**
    * O método setParamsBanco() cria um array com os parâmetros a serem
     * utilizados na conexão com o banco de dados.
    *
    *
    *
    * @access public
     * @param Array $params_banco Array associoativo com o nome do parâmetro e o seu valor
    */
    public function setParamsBanco($params_banco){
        if((is_array($params_banco))and(count($params_banco)>0)){
            $this->params_banco=$params_banco;
        }else{
            $this->params_banco=array();
        }
    }

    /**
    * O método getParamsBanco() retorna um array com os parâmetros a serem
     * utilizados na conexão com o banco de dados.
    *
    *
    *
    * @access public
     * @param Array $params_banco Array associoativo com o nome do parâmetro e o seu valor
     * @return Array Retorna um Array de String com os parâmetros definidos
    */
    public function getParamsBanco(){
        if((is_array($this->params_banco))and(count($this->params_banco)>0)){
            return $this->params_banco;
        }else{
            return array();
        }
    }


    /**
    * O método setAutocommit() define um valor booleano para o atributo
     * autocomitt (true or false)
    *
    *
    * @access public
    * @param boolean $auto_commit
    * @return void
    */
    public function setAutocommit($auto_commit){
        if((integer)$auto_commit==1)
                $this->autocomitt=true;
            else
                $this->autocomitt=false;

    }


    /**
    * O método getAutocommit() retorna um valor booleano do atributo
     * autocomitt (true or false)
    *
    *
    * @access public
    * @return void
    */
    public function getAutocommit(){
        if(!$this->autocomitt)
            return false;
        else
            return $this->autocomitt;
    }

    /**
    * O método setUsePrepare() define um valor booleano para o atributo
     * use_prepare (true or false)
    *
    *
    * @access public
    * @param boolean $auto_commit
    * @return void
    */
    public function setUsePrepare($use_prepare){
        $use_prepare = (bool)$use_prepare;
        if((bool)$use_prepare){
           $this->use_prepare=true;
        }else{
            $this->use_prepare=false;
        }
    }

     /**
    * O método getUsePrepare() retorna um valor booleano do atributo
     * use_prepare (true or false)
    *
    *
    * @access public
    * @return Boolean
    */
    public function getUsePrepare(){
        if(!$this->use_prepare)
            return false;
        else
            return $this->use_prepare;
    }


    /**
    * O método setErro() define o array com os valores do erro retornado pelo
    * sgdb.
    * array[0] = Código de erro do SQLSTATE (definido no padrão ANSI SQL)
    * array[1] = Código do erro especificado pelo driver
    * array[2] = Mensagem de Erro especificada pelo driver
    *
    *
    * @access public
    * @param Array $erro Um Array de string contendo o código e a mensagem de erro
    * @return void
    */
    public function setErro($erro){
        if(!empty($erro)){
                $this->erro=$erro;

        }else{
            $this->erro='';
        }
    }


    /**
    * O método getErro() retorna um array com os valores do erro retornado pelo
    * sgdb.
    * array[0] = Código de erro do SQLSTATE (definido no padrão ANSI SQL)
    * array[1] = Código do erro especificado pelo driver
    * array[2] = Mensagem de Erro especificada pelo driver
    *
    *
    * @access public
    * @return Array String
    */
    public function getErro(){

            return $this->erro;
    }



    /**
    * O método setParams() cria e incrementa um array de parâmetros a serem
    * utilizados na execução das declarações preparadas. Para utilizar esse
    * método deve-se levar em conta como foi definido a consulta sql:
    * <br>
    * Exemplo:<br>
    * <br>
    * $sql = "select * from dados.tabela where  id=? and nome=?;<br>
    * <br>
    * //para esse caso só foi informado '?' no lugar dos parâmetros. Dessa
    * forma o método irá considerar a ordem de definição para atribuir no
    * sql:<br>
    * $banco->setParams(1); //vai ser atribuido ao id, pq foi passado primeiro<br>
    * $banco->setParams('joão'); //vai ser atribuido ao nome, pq foi passado em segundo<br>
    * <br>
    * O problema de trabalhar dessa forma é que se não for observado a ordem de passagem
    * dos parâmetros a consulta pode sair errada. Para o exemplo acima, se for
    * passado na seguinte ordem: <br>
    *<br>
    * $banco->setParams('joão'); //vai ser atribuido ao id, pq foi passado primeiro<br>
    * $banco->setParams(1); //vai ser atribuido ao nome, pq foi passado em segundo
    * <br>
    * Pode-se trabalhar nesse método utilizando-se a definição de parâmetros
    * por nome (Param By Name), onde, no lugar de cada parâmetro, é definido
    * um nome, que utiliza como prefixo ':' (dois pontos).<br>
    * <br>
    * Exemplo:<br>
    * <br>
    * $sql = "select * from dados.tabela where  id=:id_pessoa and nome=:nome_pessoa;  <br>
    * <br>
    * $banco->setParams('joão',':nome_pessoa'); //vai ser atribuido ao id<br>
    * $banco->setParams(1,':id_pessoa'); //vai ser atribuido ao nome  <br>
    * <br>
    *
    * @access public
    * @param String $valor_do_parametro O valor a ser definido para o parâmetro
    * @param String $nome_ou_codigo_na_sql Nome do parâmetro
    * @return void
    */
    public function setParams($valor_do_parametro,$nome_ou_codigo_na_sql=null){
        $params_aux = $this->getParams();
        if(!is_array($params_aux))
            $params_aux = array();

        if($nome_ou_codigo_na_sql<>null){
            if(is_string($nome_ou_codigo_na_sql)){
                if(!substr($nome_ou_codigo_na_sql,0,1)==':')
                        $nome_ou_codigo_na_sql=':'.$nome_ou_codigo_na_sql;
                $nome_ou_codigo_na_sql=trim($nome_ou_codigo_na_sql);
            }else if(is_numeric($nome_ou_codigo_na_sql)){
                if((integer)$nome_ou_codigo_na_sql<0)
                    $nome_ou_codigo_na_sql=0;
            }
            $params_aux[$nome_ou_codigo_na_sql]=$valor_do_parametro;
        }else{
            $proximo_parametro = count($params_aux)+1;

            $nome_ou_codigo_na_sql=$proximo_parametro;
            $params_aux[$nome_ou_codigo_na_sql]=$valor_do_parametro;

        }

        $this->params = $params_aux;

    }


    /**
    * O método getParams() retorna um array de parâmetros a serem
    * utilizados na execução das declarações preparadas.
    * @access public
    * @return Array
    */
    public function getParams(){

            return $this->params;
    }
    /*
    public function setChecarTipoDoParametroAutomaticamente($checar){
        if((integer)$checar==1){
                $this->checar_tipo_do_parametro_automaticamente=true;
        }else{
            $this->checar_tipo_do_parametro_automaticamente=false;
        }
    }

    public function getChecarTipoDoParametroAutomaticamente(){
            return $this->checar_tipo_do_parametro_automaticamente;
    }*/



    /**
    * O método getPDOTipagemValor() retorna o tipo definido PDO de acordo com o
    * valor. Só serão considerados Numeric, String or Null
    *
    * utilizados na execução das declarações preparadas.
    * @param $var Valor informado
    * @access public
    * @return PDOType
    */
    private function getPDOTipagemValor($var){
        $param='';
        if( is_numeric( $var ) ){
        $param=PDO::PARAM_INT;
        }else if( (is_null( $var ))or($var==null) ){
        $param=PDO::PARAM_NULL;
      }else if(!is_numeric($var)){
        $param=PDO::PARAM_STR;
      }
        return $param;
    }

    public function getListar(){
        return $this->listar;
    }
    public function setListar($listar){
        $this->listar=$listar;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome=$nome;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    public function setDescricao($descricao){
        $this->descricao=$descricao;
    }

    public function getStarta_transacao(){
        return (integer)$this->starta_transacao==1?true:false;;
    }
    public function setStarta_transacao($starta){
        $this->starta_transacao=(integer)$starta==1?true:false;
    }
    public function getUse_mt_query(){
        return (integer)$this->use_mt_query==1?true:false;
    }
    public function setUse_mt_query($use_mt_query){
        $this->use_mt_query=(integer)$use_mt_query==1?true:false;
    }


    public function getDbName(){
        return $this->dbname;
    }
    public function setDbName($dbName){
        $this->dbname=$dbName;
    }
    public function getPort(){
        return $this->port;
    }
    public function setPort($port){
        $this->port=$port;
    }
    public function getUsuario(){
        return $this->usuario;
    }
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha=$senha;
    }
    public function getHost(){
        return $this->host;
    }
    public function setHost($host){
        $this->host=$host;
    }

    /**
     * Esse método é utilizado para contar a quantidade de linhas de uma consulta
     * @param type $rs resultado da consulta executada (opcional pois a classe considera a última execução efetuada)
     * @return int
     */
    public function fetchrow($rs=false){
        if($rs){
            if(is_array($rs))
                return count($rs);
            else
                return 0;
        }else{
            if(is_array($this->ultimo_result_query_exec))
                return count($this->ultimo_result_query_exec);
            else
                return 0;
        }
    }

    /**
     * Esse método é utilizado para contar a quantidade de linhas de uma consulta
     * @param type $rs resultado da consulta executada (opcional pois a classe considera a última execução efetuada)
     * @return int
     */
    public function fetch_row($rs=false){
        return $this->fetchrow($rs);
    }


    /**
     * comando para indicar onde uma transação será iniciada. A partir desse comando, todas as querys surtirão
     * efeitos permanentes no banco de dados somente quando for executado o commit;
     * @param type $rs resultado da consulta executada (opcional pois a classe considera a última execução efetuada)
     * @return int
     */
    public function beginTransactionPDO(){

       $this->pdo->beginTransaction();

        return  true;
        
    }


    /**
     * comando para confirmar a execução de todas as querys executadas na transação. Após o commit não poderá ser 
     * desfeito as manipulações ocorridas. O commit deve ser executado depois de todas as verificações de erros.
     * @param type $rs resultado da consulta executada (opcional pois a classe considera a última execução efetuada)
     * @return int
     */
    public function commitPDO(){

       $this->pdo->commit();

        return  true;  

    }


    /**
     * comando para desfazer a ação todas as querys que foram executadas na transação.
     * É utilizado sempre que algum erro ocorre.
     * @param type $rs resultado da consulta executada (opcional pois a classe considera a última execução efetuada)
     * @return int
     */
    public function rollBackPDO(){

        $this->pdo->rollBack();

        return  true;  

    }


    public function lastInsertId(){
        if(!is_object($this->pdo))
            return false;
        $ultimo_id=0;
        try{
            $pdo =$this->pdo;
            $ultimo_id = $pdo->lastInsertId();
        }catch( PDOException $Exception ) {

            return false;

        }

        return $ultimo_id;

    }

}

?>