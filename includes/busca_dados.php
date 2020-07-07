<?php 
ini_set('soap.wsdl_cache_enabled', '0'); // desabilitar o cache

//define o encoding do cabeçalho para utf-8
@header('Content-Type: text/html; charset=utf-8');

// instancia cliente SOAP
$client = new SoapClient("http://aplicacoes.mds.gov.br/snas/redesuas/webservices/servidor.php?wsdl", array('encoding'=>'UTF-8')); //Webservice RedeSUAS.

// Função para retirar os acentos 
// assume $str esteja em UTF-8
$from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
$to = "aaaaeeiooouucAAAAEEIOOOUUC";
 
function utf8_strtr($str, $from, $to) {
    $keys = array();
    $values = array();
    preg_match_all('/./u', $from, $keys);
    preg_match_all('/./u', $to, $values);
    $mapping = array_combine($keys[0], $values[0]);
    return strtr($str, $mapping);
}

$opcao = $_POST['opcao']; //Opção de busca:

/*
* 1 - Pesquisar por NIS na base do CECAD.
* 2 - Detalhar os dados do usuário no CECAD.
* 3 - Pesquisar por número do beneficiário BPC no SISBPC.
* 4 - Pesquisar por CPF na base do CECAD.
* 5 - Pesquisar por número do CPF no SISBPC.
* 6 - Pesquisar por Nome, Data de Nascimento e IBGE na base do CECAD.
* 7 - Pesquisar por Nome, Data de Nascimento e UF na base do CECAD.
* 8 - Pesquisar por Nome, Data de Nascimento e UF no SISBPC.
*
*
*
*
*
*/

switch ($opcao) { // Início  do switch.

    case 1: //Pesquisar por NIS na base do CECAD.

            try
              {
                  //Variável com o numero do NIS:
                  $nis = $_POST['nis'];
                  // realiza chamada remota de método
                  $retorno = json_decode($client->buscaCadUnicoNis($nis));

              foreach($retorno as $individuo){

                $validar = $individuo->num_nis_pessoa_atual;

              }

              if($validar){

                  foreach($retorno as $individuo)

              {
?>
                  <table class="table table-hover">
                    <thead>
                        <tr>
                        <th>Nome </th>
                        <th>Data de Nascimento </th>
                        <th>Nome da Mãe </th>
                        <th>Naturalidade  </th>
                        <th>Sexo </th>
                        <th>Origem (base)</th>
                        <th>Data de atualização</th>
                        <th></th>
                        </tr>
                    </thead>  
                    <tbody>  
                        <tr>
                        <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                        <td><?php echo $individuo->dta_nasc_pessoa?></td>
                        <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                        <td>
                          <?php 

                            if($individuo->nom_ibge_munic_nasc_pessoa!='99'){

                                echo strtoupper($individuo->nom_ibge_munic_nasc_pessoa);
                                echo "/"; 

                            } else {

                                echo '';  

                            }

                            if($individuo->sig_uf_munic_nasc_pessoa!='99'){

                                echo strtoupper($individuo->sig_uf_munic_nasc_pessoa);

                            } else {

                               echo ''; 

                            }

                          ?>
                        </td>                 
                        <td>
                          <?php 

                            if ($individuo->cod_sexo_pessoa == 1) {

                              echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";

                            } elseif ($individuo->cod_sexo_pessoa == 2) {

                              echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> ";

                            } 

                          ?>
                        </td>                  
                        <td>CADÚNICO</td>
                        <td>
                          <?php 
                            echo $individuo->dat_atual_fam;
                          ?>
                        </td>
                        <td>
                          <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" >               
                        </td>
                       </tr>
                    </tbody>
                  </table>

                <?php 
                
                } 
                  
                  }else{echo"<center><b> Usuário não encontrado, favor realizar outra forma de busca. </b></center>";}  


              }
              catch (SoapFault $excecao)     //ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }
                  


        break;

    case 2:

            try
              {
                  //Variável com o numero do NIS:
                   $nis = $_POST['nis'];
                   $ibge = $_POST['ibge'];
                  // realiza chamada remota de método
                  $retorno = json_decode($client->buscaCadUnicoNisIbge($nis,$ibge));

              }
              catch (SoapFault $excecao)     //ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }

            ?>
                    <div class="row">

                        <?php
                        
                         // var_dump($xml);
                        
                        foreach($retorno as $individuo)
                        {
                          $validar = $individuo->num_nis_pessoa_atual;
                        }
                        ?>
                        <div class="col-md-12">
                          <div class="panel panel-warning">
                          <div class="panel-heading">
                            <b>Dados Pessoais </b>
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped table-bordered">
                            <tbody>
                              <tr>
                              <th>Nome completo</th>
                              <th>Data de nascimento</th>
                              <th>Sexo</th>
                              <th>CPF</th>
                              </tr>
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_pessoa) ?></td>
                              <td><?php echo $individuo->dta_nasc_pessoa ?></td>
                              <td><?php if($individuo->cod_sexo_pessoa==1){ echo"<span class='label label-primary'> Masculino </span>" ;} else{ echo "<span class='label label-danger'> Feminino </span> " ;} ?></td>
                              <td><?php echo $individuo->num_cpf_pessoa ?></td>
                             </tr>
                              <tr>
                              <th>Nome da mãe</th>
                              <th>Naturalidade</th>
                              <th>Data de atualização</th>
                              </tr>
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa);?></td>
                              <td><?php if($individuo->nom_ibge_munic_nasc_pessoa!='99'){ echo strtoupper($individuo->nom_ibge_munic_nasc_pessoa);} else { echo ''; }  if($individuo->sig_uf_munic_nasc_pessoa!='99'){ echo strtoupper(' / '.$individuo->sig_uf_munic_nasc_pessoa);} else { echo ''; } ?> </td>
                              <td><?php echo $individuo->dat_atual_fam;?></td>
                             </tr>
                            </tbody>
                            </table>
                          </div>
                          </div>

                          <div class="panel panel-warning">
                          <div class="panel-heading">
                           <b> Endereço Residencial </b>
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped table-bordered">
                            <tbody>
                             <tr>
                              <th>Endereço</th>
                              <th>Complemento</th>
                              </tr>
                              <tr>
                              <td><?php echo $individuo->nom_tip_logradouro_fam ?> <?php echo $individuo->nom_logradouro_fam ?></td>
                              <td><?php echo $individuo->txt_referencia_local_fam ?></td>
                              </tr>
                              <tr>
                              <th>CEP</th>
                              <th>Cidade</th>
                              <th>UF</th>
                              <th>Telefone</th>
                              </tr>
                               <tr>
                              <td><?php echo $individuo->num_cep_logradouro_fam ?></td>
                              <td><?php echo $individuo->municipio ?></td>
                              <td><?php echo $individuo->uf ?></td>
                              <td><?php echo $individuo->num_tel_contato_1_fam ?> </td>
                              </tr>
                            </tbody>
                            </table>
                          </div>
                          </div>
                          
                          <center>
                          <input type="button" class="btn btn-salvar" onclick="voltar()" value="Voltar" >
                          </center>
                        </div>      
                            </div>

<?php
        break;

    case 3: //Pesquisar por número do beneficiário BPC no SISBPC.

            try
              {
                  //Variável com o numero do beneficiário:
                   $nb_beneficiario = $_POST['nb'];

                  // realiza chamada remota de método
                  $individuo = json_decode($client->buscaBpcNB($nb_beneficiario));

                  if($individuo){

                      $no_titular       = $individuo->NO_TITULAR;
                      $data_nascimento  = $individuo->DATA_NASCIMENTO;
                      $no_mae           = $individuo->NO_MAE;

                      if ($individuo->DS_SEXO == 'MASCULINO') {

                        $ds_sexo = "<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";
                        
                      } elseif ($individuo->DS_SEXO == 'FEMININO') {

                        $ds_sexo = "<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; 
                        
                      } else {

                        $ds_sexo = $individuo->DS_SEXO;
                        
                      }



                       $corpo_tabela .= " <tr>
                                  <td> $no_titular </td>
                                  <td> $data_nascimento </td>
                                  <td> $no_mae </td>
                                  <td> </td>
                                  <td> $ds_sexo </td>
                                  <td> SISBPC </td>
                                  <td><a class='btn btn-salvar' href='#' role='button'>Detalhar</a></td>
                                </tr>";

                  }

                  if($corpo_tabela){
                  ?>    

                        <table class="table table-hover">
                        <thead>
                          <tr>
                          <th>Nome </th>
                          <th>Data de Nascimento </th>
                          <th>Nome da Mãe </th>
                          <th>Naturalidade  </th>
                          <th>Sexo </th>
                          <th>Origem (base)</th>
                          <th></th>
                          </tr>
                        </thead>  
                        <tbody>
                        <?php  echo $corpo_tabela; ?> 
                        </tbody>
                      </table>
                  <?php

                   }else{echo"<center><b> Usuário não encontrado, favor realizar outra forma de busca. </b></center>";} 



              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }




        break;

    case 4: //Pesquisar por CPF na base do CECAD.

            try
              {



                  //Variável com o numero do CPF:
                  $cpf = $_POST['cpf'];
                  // realiza chamada remota de método
                  $retorno = json_decode($client->buscaCadUnicoCPF($cpf));


              foreach($retorno as $individuo){

                $validar = $individuo->num_nis_pessoa_atual;

              }

              if($validar){

                  foreach($retorno as $individuo)

              {



?>
                    

                        <table class="table table-hover">
                        <thead>
                          <tr>
                          <th>Nome </th>
                          <th>Data de Nascimento </th>
                          <th>Nome da Mãe </th>
                          <th>Naturalidade  </th>
                          <th>Sexo </th>
                          <th>Origem (base)</th>
                          <th>Data de atualização</th>
                          <th></th>
                          </tr>
                        </thead>  
                        <tbody>  
                          <tr>
                          <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                          <td><?php echo $individuo->dta_nasc_pessoa?></td>
                          <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                          <td>
                          <?php 
                            if($individuo->nom_ibge_munic_nasc_pessoa!='99'){
                              echo strtoupper($individuo->nom_ibge_munic_nasc_pessoa);
                              echo "/"; 
                            } else {
                              echo '';
                            }
                            if($individuo->sig_uf_munic_nasc_pessoa!='99'){
                              echo strtoupper($individuo->sig_uf_munic_nasc_pessoa);
                            } else {
                              echo ''; 
                            }?>
                          </td>                 
                          <td><?php if ($individuo->cod_sexo_pessoa == 1) { echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";} elseif ($individuo->cod_sexo_pessoa == 2) { echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; } ?></td>                  
                          <td>CADÚNICO</td>
                          <td><?php echo $individuo->dat_atual_fam;?></td>
                          <td>
                            <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" > 
                          </td>
                         </tr>
                        </tbody>
                        </table>


                  <?php 
                  } 
                    }else{echo"false";}




              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }

        break;     


    case 5: //Pesquisar por número do CPF no SISBPC.

            try
              {
                  //Variável com o numero do beneficiário:
                   $cpf = $_POST['cpf'];

                  // realiza chamada remota de método
                  $individuo = json_decode($client->buscaBpcCPF($cpf));

                  if($individuo){

                      $no_titular       = $individuo->NO_TITULAR;
                      $data_nascimento  = $individuo->DATA_NASCIMENTO;
                      $no_mae           = $individuo->NO_MAE;

                      if ($individuo->DS_SEXO == 'MASCULINO') {

                        $ds_sexo = "<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";
                        
                      } elseif ($individuo->DS_SEXO == 'FEMININO') {

                        $ds_sexo = "<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; 
                        
                      } else {

                        $ds_sexo = $individuo->DS_SEXO;
                        
                      }



                       $corpo_tabela .= " <tr>
                                  <td> $no_titular </td>
                                  <td> $data_nascimento </td>
                                  <td> $no_mae </td>
                                  <td> </td>
                                  <td> $ds_sexo </td>
                                  <td> SISBPC </td>
                                  <td><a class='btn btn-salvar' href='#' role='button'>Detalhar</a></td>
                                </tr>";

                  }

                  if($corpo_tabela){
                  ?>    

                        <table class="table table-hover">
                        <thead>
                          <tr>
                          <th>Nome </th>
                          <th>Data de Nascimento </th>
                          <th>Nome da Mãe </th>
                          <th>Naturalidade  </th>
                          <th>Sexo </th>
                          <th>Origem (base)</th>
                          <th></th>
                          </tr>
                        </thead>  
                        <tbody>
                        <?php  echo $corpo_tabela; ?> 
                        </tbody>
                      </table>
                  <?php

                   }else{echo"<center><b> Usuário não encontrado, favor realizar outra forma de busca. </b></center>";} 



              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }

        break;       

    case 6: //Pesquisar por Nome, Data de Nascimento e IBGE na base do CECAD.

            try
              {

                   //Variáveis
                  $no_pessoa = $_POST['no_pessoa'];
                  $dt_nasc_pessoa = $_POST['dt_nasc_pessoa'];
                  $uf_ibge = $_POST['uf_ibge'];

                  $nome = strtoupper(utf8_strtr($no_pessoa, $from, $to)); // funciona corretamente

                  $aux_data_nasc = implode("-",array_reverse(explode("/",$dt_nasc_pessoa)));

                  // realiza chamada remota de método
                  $retorno = json_decode($client->buscaCadUnicoNomeDataNascIbge( $nome, $aux_data_nasc , $uf_ibge ));


             if($retorno->total[0]==1){

                          unset($retorno->total);

                          foreach($retorno as $individuo){

                            $validar = $individuo->num_nis_pessoa_atual;

                          }

                          if($validar){

                              foreach($retorno as $individuo)

                          {

                        ?>
                        

                            <table class="table table-hover">
                            <thead>
                              <tr>
                              <th>Nome </th>
                              <th>Data de Nascimento </th>
                              <th>Nome da Mãe </th>
                              <th>Naturalidade  </th>
                              <th>Sexo </th>
                              <th>Origem (base)</th>
                              <th>Data de atualização</th>
                              <th></th>
                              </tr>
                            </thead>  
                            <tbody>  
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->datanasc)); ?></td>
                              <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                              <td>
                              <?php   ?>
                              </td>                 
                              <td><?php if ($individuo->cod_sexo_pessoa == "Mas") { echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";} elseif ($individuo->cod_sexo_pessoa == "Fem") { echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; } ?></td>                  
                              <td>CADÚNICO</td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->dat_atual_fam)); ?></td>
                              <td>
                                <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" >                 
                              </td>
                             </tr>
                            </tbody>
                            </table>

                      <?php 
                      } 
                        }else{
                        
                        // var_dump($_POST);
                        
                         echo"false";
                        
                        }



             }else{


                          foreach($retorno->individuo as $individuo){

                            $validar = $individuo->num_nis_pessoa_atual;

                          }

                          if($validar){

                              foreach($retorno->individuo as $individuo)

                          {

                        ?>
                        

                            <table class="table table-hover">
                            <thead>
                              <tr>
                              <th>Nome </th>
                              <th>Data de Nascimento </th>
                              <th>Nome da Mãe </th>
                              <th>Naturalidade  </th>
                              <th>Sexo </th>
                              <th>Origem (base)</th>
                              <th>Data de atualização</th>
                              <th></th>
                              </tr>
                            </thead>  
                            <tbody>  
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->datanasc)); ?></td>
                              <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                              <td>
                              <?php   ?>
                              </td>                 
                              <td><?php if ($individuo->cod_sexo_pessoa == "Mas") { echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";} elseif ($individuo->cod_sexo_pessoa == "Fem") { echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; } ?></td>                  
                              <td>CADÚNICO</td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->dat_atual_fam)); ?></td>
                              <td>
                                <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" >                 
                              </td>
                             </tr>
                            </tbody>
                            </table>

                      <?php 
                      } 
                        }else{
                        
                        // var_dump($_POST);
                        
                         echo"false";
                        
                        }


             }





              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }


        break;          

    case 7: //Pesquisar por Nome, Data de Nascimento e UF na base do CECAD.

            try
              {


                   //Variáveis
                  $no_pessoa = $_POST['no_pessoa'];
                  $dt_nasc_pessoa = $_POST['dt_nasc_pessoa'];
                  $uf = $_POST['uf_ibge'];

                  $nome = strtoupper(utf8_strtr($no_pessoa, $from, $to)); // funciona corretamente

                  $aux_data_nasc = implode("-",array_reverse(explode("/",$dt_nasc_pessoa)));

                  // realiza chamada remota de método
                  $retorno = json_decode($client->buscaCadUnicoNomeDataNascUF( $nome, $aux_data_nasc , $uf ));


              if($retorno->total[0]==1){

                          unset($retorno->total);

                          foreach($retorno as $individuo){

                            $validar = $individuo->num_nis_pessoa_atual;

                          }

                          if($validar){

                              foreach($retorno as $individuo)

                          {

                        ?>
                        

                            <table class="table table-hover">
                            <thead>
                              <tr>
                              <th>Nome </th>
                              <th>Data de Nascimento </th>
                              <th>Nome da Mãe </th>
                              <th>Naturalidade  </th>
                              <th>Sexo </th>
                              <th>Origem (base)</th>
                              <th>Data de atualização</th>
                              <th></th>
                              </tr>
                            </thead>  
                            <tbody>  
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->datanasc)); ?></td>
                              <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                              <td>
                              <?php   ?>
                              </td>                 
                              <td><?php if ($individuo->cod_sexo_pessoa == "Mas") { echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";} elseif ($individuo->cod_sexo_pessoa == "Fem") { echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; } ?></td>                  
                              <td>CADÚNICO</td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->dat_atual_fam)); ?></td>
                              <td>
                                <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" >                 
                              </td>
                             </tr>
                            </tbody>
                            </table>

                      <?php 
                      } 
                        }else{
                        
                        // var_dump($_POST);
                        
                         echo"false";
                        
                        }



             }else{


                          foreach($retorno->individuo as $individuo){

                            $validar = $individuo->num_nis_pessoa_atual;

                          }

                          if($validar){

                              foreach($retorno->individuo as $individuo)

                          {

                        ?>
                        

                            <table class="table table-hover">
                            <thead>
                              <tr>
                              <th>Nome </th>
                              <th>Data de Nascimento </th>
                              <th>Nome da Mãe </th>
                              <th>Naturalidade  </th>
                              <th>Sexo </th>
                              <th>Origem (base)</th>
                              <th>Data de atualização</th>
                              <th></th>
                              </tr>
                            </thead>  
                            <tbody>  
                              <tr>
                              <td><?php echo strtoupper($individuo->nom_pessoa)?></td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->datanasc)); ?></td>
                              <td><?php echo strtoupper($individuo->nom_completo_mae_pessoa)?></td>                 
                              <td>
                              <?php   ?>
                              </td>                 
                              <td><?php if ($individuo->cod_sexo_pessoa == "Mas") { echo"<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";} elseif ($individuo->cod_sexo_pessoa == "Fem") { echo"<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; } ?></td>                  
                              <td>CADÚNICO</td>
                              <td><?php echo date('d/m/Y', strtotime($individuo->dat_atual_fam)); ?></td>
                              <td>
                                <input type="button" class="btn btn-salvar" onclick="detalhar(<?php echo $individuo->num_nis_pessoa_atual.' , '.$individuo->ibge; ?>)" value="Detalhar" >                 
                              </td>
                             </tr>
                            </tbody>
                            </table>

                      <?php 
                      } 
                        }else{
                        
                        // var_dump($_POST);
                        
                         echo"false";
                        
                        }


             }

              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }


        break;             

    case 8: //Pesquisar por Nome, Data de Nascimento e UF no SISBPC.

           try
              {


                   //Variáveis
                  $no_pessoa = $_POST['no_pessoa'];
                  $dt_nasc_pessoa = $_POST['dt_nasc_pessoa'];
                  $uf = $_POST['uf_ibge'];

                  // realiza chamada remota de método
                  $individuo = json_decode($client->buscaBpcNomeDataNascUF($no_pessoa, $dt_nasc_pessoa , $uf));


                  if($individuo){

                      $no_titular       = $individuo->NO_TITULAR;
                      $data_nascimento  = $individuo->DATA_NASCIMENTO;
                      $no_mae           = $individuo->NO_MAE;

                      if ($individuo->DS_SEXO == 'MASCULINO') {

                        $ds_sexo = "<span class='label label-primary'>&nbsp;&nbsp; M &nbsp;&nbsp;</span>";
                        
                      } elseif ($individuo->DS_SEXO == 'FEMININO') {

                        $ds_sexo = "<span class='label label-danger'>&nbsp;&nbsp; F &nbsp;&nbsp;</span> "; 
                        
                      } else {

                        $ds_sexo = $individuo->DS_SEXO;
                        
                      }



                       $corpo_tabela .= " <tr>
                                  <td> $no_titular </td>
                                  <td> $data_nascimento </td>
                                  <td> $no_mae </td>
                                  <td> </td>
                                  <td> $ds_sexo </td>
                                  <td> SISBPC </td>
                                  <td><a class='btn btn-salvar' href='#' role='button'>Detalhar</a></td>
                                </tr>";

                  }

                  if($corpo_tabela){
                  ?>    

                        <table class="table table-hover">
                        <thead>
                          <tr>
                          <th>Nome </th>
                          <th>Data de Nascimento </th>
                          <th>Nome da Mãe </th>
                          <th>Naturalidade  </th>
                          <th>Sexo </th>
                          <th>Origem (base)</th>
                          <th></th>
                          </tr>
                        </thead>  
                        <tbody>
                        <?php  echo $corpo_tabela; ?> 
                        </tbody>
                      </table>
                  <?php

                   }else{echo"false";}


              }
              catch (SoapFault $excecao)//ocorrência de erro
              {
                  echo "<center>Erro: ";
                  echo "<b style='color:red ' > {$excecao->faultstring} </b></center>";
              }

        break;        

}// Fim  do switch.



  

?>            