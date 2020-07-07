<?php
if (!defined('ABSPATH')) exit;

$retorno_msg = $modelo->validar_form_cadastro();//Tratamento e envio do formulário 

if (isset($_GET['token'])) {//Verifica o token

    $token = $_GET['token'];
}

if (isset($retorno_msg)) {//Gerenciamento de mensagens

    if ($retorno_msg == 'success') {//Casa a mensagem seja de sucesso

        $goto_url = HOME_URI . '/principal/?msg=success';

        // Redireciona para a página
        echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
        echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
        header('location: ' . $goto_url);

    } elseif ($retorno_msg == 'error') {//Casa a mensagem seja de erro

        $goto_url = HOME_URI . '/principal/?msg=error';

        // Redireciona para a página
        echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
        echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
        header('location: ' . $goto_url);

    } elseif ($retorno_msg == 'error_cnpj') {//Casa a mensagem seja de erro com cnpj já cadastrado

        $goto_url = HOME_URI . '/principal/?msg=error_cnpj';

        // Redireciona para a página
        echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
        echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
        header('location: ' . $goto_url);

    }

}


if (isset($_GET['token'])) {//Verifica o token

    $token = $_GET['token'];

    $validar_token = $modelo->autenticidade_token($token);

    if ($validar_token == false) {//Casa a mensagem seja de sucesso

        $goto_url = HOME_URI . '/token/?msg=token';
        // Redireciona para a token
        echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
        echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
        header('location: ' . $goto_url);
    } else {

        $nu_cnpj = $validar_token[0]['nu_cnpj'];
        $co_token = $validar_token[0]['co_token'];
        $no_email = $validar_token[0]['no_email'];

        $retorno_organizacao = $modelo->buscar_organizacao($nu_cnpj);//Recebe o tipo_organizacao

        if ($retorno_organizacao) {

            $goto_url = HOME_URI . '/editar/?token=' . $co_token;
            // Redireciona para a token
            echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
            echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
            header('location: ' . $goto_url);

        }

    }


    $retorno_tipo_organizacao = $modelo->listar_tipo_organizacao();//Recebe o tipo_organizacao
    $retorno_listar_produtos = $modelo->listar_produtos();//Recebe a lista de produtos

    ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <center>
                        <img class="img-responsive" height="180" width="1050"
                             src="<?php echo HOME_URI; ?>/views/_images/Banner-Sistema-Paa.jpg"
                             alt="Ministério do Desenvolvimento Social">
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Venda Mais para o Governo!</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p>Este formulário foi produzido pela equipe do PAA - Compra Institucional e tem o objetivo
                        cadastrar cooperativas e associações da agricultura familiar, que possuam DAP- Pessoa Jurídica,
                        visando qualificar a oferta de alimentos para disponibilizar aos órgãos públicos compradores da
                        União, Estados, Distrito Federal e Municípios que desejam adquirir alimentos da Agricultura
                        Familiar. Também possibilitará a comunicação e divulgação de chamadas abertas do PAA-Compra
                        Institucional e PNAE além de informes referente as ações em andamento.
                    </p>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="text-center col-md-4 col-md-offset-4">
                    </br>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="text-center col-md-4 col-md-offset-4">
                    <div class="form-group col-md-12">
                        <h4><label>( <span class="text-danger baseFontSize"> * </span> ) Campos obrigatórios</label>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
            <div class="row">

                <div class="col-md-12">
                    <form role="form" id="form_organizacao" action="<?php echo HOME_URI; ?>/cadastro/" method="post">
                        <!-- Bloco Informações Administrativas -->
                        <fieldset>
                            <legend class="text-redesuas">1- Informações administrativas</legend>
                            <div class="form-group col-md-3">
                                <label for="nu_cnpj">CNPJ<span class="text-danger">*</span></label>
                                <input type="text" name="nu_cnpj" readonly="readonly" class="form-control" id="nu_cnpj"
                                       maxlength="18" value="<?php echo $nu_cnpj; ?>"
                                       placeholder="Digite o número do CNPJ" required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nu_dap_juridica">Nº DAP Jurídica <span class="text-danger">*</span></label>
                                <input type="text" name="nu_dap_juridica" class="form-control" id="nu_dap_juridica"
                                       maxlength="25" placeholder="Digite o número da DAP " required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_fantasia">Nome fantasia<span class="text-danger">*</span></label>
                                <input type="text" name="no_fantasia" class="form-control" id="no_fantasia"
                                       maxlength="200" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_razao_social">Razão social<span class="text-danger">*</span></label>
                                <input type="text" name="no_razao_social" class="form-control" id="no_razao_social"
                                       maxlength="200" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="co_tipo_organizacao">Tipo da organização <span class="text-danger">*</span></label>
                                <select name="co_tipo_organizacao" class="form-control" id="co_tipo_organizacao"
                                        required="">
                                    <option value=''>-=Escolha=-</option>
                                    <?php

                                    foreach ($retorno_tipo_organizacao as $dado) { //Combo Tipo Logradouro
                                        ?>

                                        <option
                                            value="<?php echo $dado['co_tipo_organizacao']; ?>"><?php echo $dado['ds_tipo_organizacao']; ?></option>

                                    <?php } ?>

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_filiacao_central_cooper">É filiada a alguma central de cooperativas?
                                    Qual?</label>
                                <input type="text" name="no_filiacao_central_cooper" class="form-control"
                                       id="no_filiacao_central_cooper" maxlength="200" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_representante_legal">Nome do representante legal<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="no_representante_legal" class="form-control"
                                       id="no_representante_legal" maxlength="100" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="dt_inicio_mand_repres_legal">Início do mandato do representante
                                    legal </label>
                                <input type="text" name="dt_inicio_mand_repres_legal" class="form-control"
                                       id="dt_inicio_mand_repres_legal" maxlength="10">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="dt_fim_mand_repres_legal">Fim do mandato do representante legal </label>
                                <input type="text" name="dt_fim_mand_repres_legal" class="form-control"
                                       id="dt_fim_mand_repres_legal" maxlength="10">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nu_telefone_comercial">Telefone comercial<span class="text-danger">*</span></label>
                                <input type="text" name="nu_telefone_comercial" class="form-control"
                                       id="nu_telefone_comercial" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nu_telefone_celular">Telefone celular<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nu_telefone_celular" class="form-control"
                                       id="nu_telefone_celular" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email_administrativo">Endereço de e-mail da cooperativa/associação <span
                                        class="text-danger">*</span> </label>
                                <input type="text" name="email_administrativo" class="form-control" readonly="readonly"
                                       id="email_administrativo" value="<?php echo $no_email; ?>" maxlength="100"
                                       placeholder="" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="no_email_cetral_vendas">Endereço de e-mail da central de vendas do
                                    empreendimento</label>
                                <input type="text" name="no_email_cetral_vendas" class="form-control"
                                       id="no_email_cetral_vendas" maxlength="100" placeholder="">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="no_sitio_eletronico">Sítio eletrônico ou rede social</label>
                                <input type="text" name="no_sitio_eletronico" class="form-control"
                                       id="no_sitio_eletronico" maxlength="150" placeholder="">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="uf_cadastro">Estado <span class="text-danger">*</span></label>
                                <select name="uf_cadastro" class="form-control" id="uf_cadastro" required="">
                                    <option value=''>-=Escolha=-</option>
                                    <option value="12">Acre</option>
                                    <option value="27">Alagoas</option>
                                    <option value="13">Amazonas</option>
                                    <option value="16">Amapá</option>
                                    <option value="29">Bahia</option>
                                    <option value="23">Ceará</option>
                                    <option value="53">Distrito Federal</option>
                                    <option value="32">Espirito Santo</option>
                                    <option value="52">Goiás</option>
                                    <option value="21">Maranhão</option>
                                    <option value="31">Minas Gerais</option>
                                    <option value="50">Mato Grosso do Sul</option>
                                    <option value="51">Mato Grosso</option>
                                    <option value="15">Pará</option>
                                    <option value="25">Paraíba</option>
                                    <option value="26">Pernambuco</option>
                                    <option value="22">Piauí</option>
                                    <option value="41">Paraná</option>
                                    <option value="33">Rio de Janeiro</option>
                                    <option value="24">Rio Grande do Norte</option>
                                    <option value="11">Rondônia</option>
                                    <option value="14">Roraima</option>
                                    <option value="43">Rio Grande do Sul</option>
                                    <option value="42">Santa Catarina</option>
                                    <option value="28">Sergipe</option>
                                    <option value="35">São Paulo</option>
                                    <option value="17">Tocantins</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="co_ibge"> Município <span class="text-danger">*</span></label>
                                <select name="co_ibge" class="form-control" id="co_ibge" required="">
                                    <option value="" id="select_municipio"> -- Escolha um estado --</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_endereco">Endereço sede<span class="text-danger">*</span></label>
                                <input type="text" name="no_endereco" class="form-control" id="no_endereco"
                                       maxlength="150" placeholder="" required="">
                            </div>
                        </fieldset>
                        <!-- /Bloco Informações Administrativas  -->

                        <!-- Bloco Organização Social -->
                        <fieldset>
                            <legend class="text-redesuas">2- Organização Social</legend>
                            <div class="form-group col-md-4">
                                <label for="qt_agricultores_fam">Quantidade de agricultores familiares
                                    cooperados/associados<span class="text-danger">*</span></label>
                                <input type="text" name="qt_agricultores_fam" class="form-control"
                                       id="qt_agricultores_fam" maxlength="5" placeholder="" required="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="qt_cooper_associ">Quantidade de cooperados/associados com DAP<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="qt_cooper_associ" class="form-control" id="qt_cooper_associ"
                                       maxlength="5" placeholder="" required="">
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-redesuas"></legend>

                            <div class="form-group">
                                <p><label for="agroeco">De quais rede, movimento ou organização representativa está
                                        participando? <span class="text-danger">*</span> </label></p>
                                <label class="col-md-2 control-label" for="unicafes">UNICAFES</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="unicafes" name="unicafes" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="unicafes" name="unicafes" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label" for="IsSmallBusiness">UNISOL</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="unisol" name="unisol" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="unisol" name="unisol" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="ecovida">REDE ECOVIDA</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="ecovida" name="ecovida" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="ecovida" name="ecovida" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="ecovida">OCB</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="ocb" name="ocb" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="ocb" name="ocb" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="ecovida">MST</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="mst" name="mst" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="mst" name="mst" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="contag">CONTAG</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="contag" name="contag" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="contag" name="contag" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="fetraf">FETRAF</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="fetraf" name="fetraf" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="fetraf" name="fetraf" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="mpa">MPA</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="mpa" name="mpa" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="mpa" name="mpa" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="mmc">MMC</label>
                                <div class="col-md-10">
                                    <label class="radio-inline">
                                        <input id="mmc" name="mmc" type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="mmc" name="mmc" type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                        </fieldset>
                        <!-- /Organização Social  -->

                        <!-- Bloco Produção -->
                        <fieldset>
                            <legend class="text-redesuas">3- Produção</legend>
                            <div id="listar_produtos" class="text-center">
                                <?php
                                $produtos = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();

                                if (count($produtos) > 0) {

                                    ?>
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">Produto</th>
                                            <th class="text-center">Tipo do produto</th>
                                            <th class="text-center"> Embalagem</th>
                                            <th class="text-center"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        for ($a = 0; $a < count($produtos); $a++) {

                                            $co_produto = $produtos[$a]['co_produto'];
                                            $co_tipo_produto = $produtos[$a]['co_tipo_produto'];
                                            $co_embalagem = $produtos[$a]['co_embalagem'];
                                            $retorno_dados = $modelo->buscar_produto($co_produto, $co_tipo_produto, $co_embalagem);

                                            ?>
                                            <tr>
                                                <th class="text-right"><?php echo $a + 1; ?></th>
                                                <td><?php echo $retorno_dados[0]['ds_produto']; ?></td>
                                                <td><?php echo $retorno_dados[0]['ds_tipo_produto']; ?></td>
                                                <td><?php echo $retorno_dados[0]['ds_embalagem']; ?></td>
                                                <td>
                                                    <button type="button" onclick="remover_produto(<?php echo $a; ?>)">
                                                        <i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                    <?php

                                }
                                ?>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="id" class="col-md-2 control-label">Selecione o Produto , Tipo do produto e
                                    Embalagem.</label>
                                <div class="input-group">
								    <span class="input-group-btn">
								        <select name="co_produto" class="form-control" id="co_produto">
								                <option value=''>-=Escolha um produto=-</option>
                                            <?php

                                            foreach ($retorno_listar_produtos as $dado) { //Combo Tipo Logradouro
                                                ?>

                                                <option
                                                    value="<?php echo $dado['co_produto']; ?>"><?php echo $dado['ds_produto']; ?></option>

                                            <?php } ?>
									    
										</select> 
								    </span>
								    <span class="input-group-btn">
								        <select name="co_tipo_produto" class="form-control" id="co_tipo_produto">
								                <option value=''>-=Escolha um tipo=-</option>							    
										</select> 
								    </span>
								    <span class="input-group-btn">
								        <select name="co_embalagem" class="form-control" id="co_embalagem">
								                <option value=''>-=Escolha uma embalagem=-</option>
								    
										</select> 
								    </span>
								    <span class="input-group-btn">
											<button type="button" id="AddProduto" class="btn btn-success"><i
                                                    class="fa fa-plus"></i>  Adicionar </button>
								    </span>
                                </div>
                            </div>

                        </fieldset>
                        <!-- /Bloco Produção  -->


                        <!-- /Bloco opções -->
                        <fieldset>
                            <legend class="text-redesuas"></legend>

                            <div class="form-group">
                                <p><label for="agroeco">Quais os tipos de certificação o produto possui? <span
                                            class="text-danger">*</span> </label></p>

                                <label class="col-md-4 control-label" for="in_certificado_organico">Certificação de
                                    orgânico.</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_certificado_organico" name="in_certificado_organico" type="radio"
                                               value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_certificado_organico" name="in_certificado_organico" type="radio"
                                               value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for=""
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="in_certificado_sustentabilidade">Certificação
                                    de sustentabilidade.</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_certificado_sustentabilidade"
                                               name="in_certificado_sustentabilidade" type="radio" value="1"
                                               required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_certificado_sustentabilidade"
                                               name="in_certificado_sustentabilidade" type="radio" value="0"
                                               required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="in_certificado_fairtrade">Certificação de
                                    Fairtrade.</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_certificado_fairtrade" name="in_certificado_fairtrade"
                                               type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_certificado_fairtrade" name="in_certificado_fairtrade"
                                               type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-redesuas"></legend>

                            <div class="form-group">

                                <label class="col-md-4 control-label" for="in_produto_sociobiodiversidade">É um produto
                                    da sociobiodiversidade?</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_produto_sociobiodiversidade" name="in_produto_sociobiodiversidade"
                                               type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_produto_sociobiodiversidade" name="in_produto_sociobiodiversidade"
                                               type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="in_produto_origem_quilombola">É um produto de
                                    origem quilombola?</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_produto_origem_quilombola" name="in_produto_origem_quilombola"
                                               type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_produto_origem_quilombola" name="in_produto_origem_quilombola"
                                               type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="in_produto_origem_indigina">É um produto de
                                    origem indígena?</label>
                                <div class="col-md-8">
                                    <label class="radio-inline">
                                        <input id="in_produto_origem_indigina" name="in_produto_origem_indigina"
                                               type="radio" value="1" required="">
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input id="in_produto_origem_indigina" name="in_produto_origem_indigina"
                                               type="radio" value="0" required="">
                                        Não
                                    </label>
                                    <span class="field-validation-valid help-block" data-valmsg-for="PhoneNumber"
                                          data-valmsg-replace="1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <p><br/></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="radio-inline">
                                        <input id="in_termo_aceite" name="in_termo_aceite" type="checkbox" value="1"
                                               required="">
                                        <b>Ao selecionar este item, o responsável pela
                                            Cooperativa/Organização/Empreendimento da Agricultura Familiar aceita que
                                            todos os dados cadastrados sejam tornados públicos no Portal da Agricultura
                                            Familiar e outros produtos de divulgação subsequentes, para incentivar a
                                            formação de redes de negócios por meio das compras institucionais do
                                            Programa de Aquisição de Alimentos, com o objetivo de aproximar a demanda do
                                            mercado dos entes governamentais e empresas públicas de todos os entes
                                            federados da produção agropecuária das
                                            Cooperativas/Organizações/Empreendimentos da Agricultura Familiar.</b>
                                    </label>

                                </div>
                            </div>
                            </P>
                        </fieldset>
                        <!-- /Bloco opções  -->
                        <br>
                        <div class="form-group col-md-12">
                            <center>
                                <input type="hidden" name="acao_cadastro" value="inserir">
                                <input type="hidden" name="produtos" id="produtos" value="nao">
                                <input type="hidden" name="co_token" id="co_token" value="<?php echo $co_token; ?>">
                                <button type="button" class="btn btn-salvar" id='idBotao'><b>&nbsp;&nbsp; Salvar &nbsp;&nbsp;</b> </span>
                                </button>
                                <button type="submit" style="display:none" lass="btn btn-salvar" id='idEnviar'><b>&nbsp;&nbsp;
                                        enviar &nbsp;&nbsp;</b> </span></button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

            <p>
                <!-- /.row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- Autocompletar atráves de CEP com Jquery -->
    <script type="text/javascript">


        //Verificação das mensagens
        <?php

        if ( isset($_GET['msg']) ) { //Tratamento das mensagens

        if ($_GET['msg'] == 'success') {//mensagem de sucesso!
        ?>

        $(window).load(function () {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><h4 class="text-success" ><b> Cadastro realizado com sucesso! </b></h4></center>');
        });


        <?php

        }elseif ($_GET['msg'] == 'error_cnpj') {//mensagem de erro, CNPJ já cadastrado!

        ?>

        $(window).load(function () {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><p class="text-danger" ><b> CNPJ já consta cadastrado em nossa base de dados. </b></p></center>');
        });


        <?php
        }elseif ($_GET['msg'] == 'error') { //mensagem de erro ao cadastrar!

        ?>



        $(window).load(function () {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><h4 class="text-danger" ><b> Ocorreu um erro ao processar essa solicitação. Tente novamente mais tarde. </b></h4></center>');
        });


        <?php
        }
        }

        ?>
        //FIM - Verificação das mensagens


        $("#nu_cnpj").blur(function function_name() { //Funcão para verificar se o CNPJ já está cadastrado


            //validar CNPJ
            if ($('#nu_cnpj').val().length >= 1) {

                var result_cnpj = ValidarCNPJ($('#nu_cnpj').val());
                if (result_cnpj == false) {

                    $('#alerta-sigcad-detalhar').click();
                    $('#div_detalhar').html('<center><p class="text-danger" ><b> CNPJ inválido ou incorreto, certifique-se de que o CNPJ digitado está correto. </b></p></center>');

                }
            }
            //Fim - validar CNPJ

            //Envia o valor do CNPJ via Ajax para a pagina busca-dados e realiza a pesquisa pelo método POST
            $.post('<?php echo HOME_URI;?>/busca-dados/', {
                cnpj: $('#nu_cnpj').val(),
                opcao: 'verificar_cnpj'
            }, function (data, textStatus) { //chamada em Ajax para o método POST

                if (textStatus == 'success') { //verifica se o status está tudo ok!

                    if (data.replace(/^\s+|\s+$/g, "") === "sim") {

                        $('#alerta-sigcad-detalhar').click();
                        $('#div_detalhar').html('<center><p class="text-danger" ><b> CNPJ já consta cadastrado em nossa base de dados. </b></p></center>');

                    }


                } else {
                    alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                }

            }).fail(function (jqXHR, textStatus, error) {

                document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>"); //insere o valor de data no div #div_resultado
            });


        });//Fim - Funcão para verificar se o CNPJ já está cadastrado


        $('#idBotao').click(function () { //configura o evento 'click' do #idBotao -- Botão pesquisar


            //Envia o valor do nis via Ajax para a pagina busca-dados e realiza a segunda pesquisa pelo método POST
            $.post('<?php echo HOME_URI;?>/busca-dados/', {opcao: 'verificar_produtos'}, function (data, textStatus) { //chamada em Ajax para o método POST


                if (textStatus == 'success') { //verifica se o status está tudo ok!

                    if (data.replace(/^\s+|\s+$/g, "") === "nao") {

                        $('#produtos').val('nao');

                        $('#alerta-sigcad-detalhar').click();
                        $('#div_detalhar').html('<center><p class="text-danger" ><b> Nenhum produto foi selecionado até o momento. </b></p></center>');

                        return false;

                    } else {

                        $('#produtos').val('sim');
                    }

                } else {
                    alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                }


            }).fail(function (jqXHR, textStatus, error) {

                $('#alerta-sigcad-detalhar').click();//fecha o primeiro Modal sem o botão de fechar.
                document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>"); //insere o valor de data no div #div_resultado

            });


            if ($('#nu_cnpj').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo CNPJ é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#nu_cnpj').val().length >= 1 && ValidarCNPJ($('#nu_cnpj').val()) == false) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> CNPJ inválido ou incorreto, certifique-se de que o CNPJ digitado está correto. </b></p></center>');

            } else if ($('#nu_dap_juridica').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Nº DAP Jurídica é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#no_fantasia').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Nome fantasia é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#no_razao_social').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Razão social é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#co_tipo_organizacao').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Tipo da organização é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#no_representante_legal').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Nome do representante legal é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#dt_inicio_mand_repres_legal').val().length >= 1 && validaData($('#dt_inicio_mand_repres_legal').val()) == false) { //Validar Início do mandato do Representante Legal

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> Data início do mandato do representante legal inválida. </b></p></center>');

            } else if ($('#dt_fim_mand_repres_legal').val().length >= 1 && validaData($('#dt_fim_mand_repres_legal').val()) == false) { //Validar Fim do mandato do Representante Legal

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> Data fim do mandato do representante legal inválida. </b></p></center>');

            } else if ($('#dt_inicio_mand_repres_legal').val().length >= 1 && $('#dt_fim_mand_repres_legal').val().length < 1) {//Validar Fim do mandato do Representante Legal

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> A data Início do mandato do Representante Legal não pode se maior que a data Fim do mandato do Representante Legal. </b></p></center>');

            } else if ($('#dt_inicio_mand_repres_legal').val().length < 1 && $('#dt_fim_mand_repres_legal').val().length >= 1) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> A data Início do mandato do Representante Legal não pode se maior que a data Fim do mandato do Representante Legal. </b></p></center>');

            } else if ($('#dt_inicio_mand_repres_legal').val().length >= 1 && $('#dt_fim_mand_repres_legal').val().length >= 1 && verificar() == false) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> A data Início do mandato do Representante Legal não pode se maior que a data Fim do mandato do Representante Legal. </b></p></center>');

            } else if ($('#nu_telefone_comercial').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Telefone comercial é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#nu_telefone_celular').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Telefone celular é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#email_administrativo').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Endereço de e-mail da cooperativa/associação é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#uf_cadastro').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Estado é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#co_ibge').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Município é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#no_endereco').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Endereço sede é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#qt_agricultores_fam').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Quantidade de agricultores familiares cooperados/associados é  obrigatório e não foi preenchido. </b></p></center>');

            } else if ($('#qt_cooper_associ').val().length <= 0) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Quantidade de cooperados/associados com DAP é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=unicafes]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo UNICAFES é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=unisol]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo UNISOL é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=ecovida]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo REDE ECOVIDA é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=ocb]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo OCB é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=mst]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo MST é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=contag]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo CONTAG é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=fetraf]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo FETRAF é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=mpa]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo MPA é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=mmc]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo MMC é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=in_certificado_organico]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Certificação de orgânico é  obrigatório e não foi preenchido. </b></p></center>');


            } else if (!$("input[name=in_certificado_sustentabilidade]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Certificação de sustentabilidade é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=in_certificado_fairtrade]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Certificação de Fairtrade é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=in_produto_sociobiodiversidade]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo É um produto da sociobiodiversidade? é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=in_produto_origem_quilombola]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo É um produto de origem quilombola? é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=in_produto_origem_indigina]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo É um produto de origem indígena? é  obrigatório e não foi preenchido. </b></p></center>');

            } else if (!$("input[name=in_termo_aceite]:checked").val()) {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O Termo é  obrigatório e não foi aceito. </b></p></center>');

            } else if ($('#produtos').val() == 'sim') {

                // Dados do formulário
                var dados = new FormData("#form_organizacao");

                //Envia o valor do nis via Ajax para a pagina busca-dadose realiza a segunda pesquisa pelo método POST
                $.post('<?php echo HOME_URI;?>/busca-dados/', {dados: $("#form_organizacao").serializeArray()}, function (data, textStatus) { //chamada em Ajax para o método POST

                    if (textStatus == 'success') { //verifica se o status está tudo ok!

                        $('#alerta-sigcad-detalhar').click();
                        $('#div_detalhar').html(data);

                    } else {
                        alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                    }


                }).fail(function (jqXHR, textStatus, error) {


                    document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                    $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>"); //insere o valor de data no div #div_resultado

                });


            }


        });

        function salvar_form() {

            $('#idEnviar').click();//Enviar formulário

        }

        function remover_produto(id_produto) {

            //Envia o valor do CNPJ via Ajax para a pagina busca-dados e realiza a pesquisa pelo método POST
            $.post('<?php echo HOME_URI;?>/busca-dados/', {
                id_produto: id_produto,
                opcao: 'remover_produto'
            }, function (data, textStatus) { //chamada em Ajax para o método POST

                if (textStatus == 'success') { //verifica se o status está tudo ok!
                    $('#listar_produtos').html(data); //insere o valor de data no div #div_detalhar

                } else {
                    alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                }

            }).fail(function (jqXHR, textStatus, error) {

                document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>"); //insere o valor de data no div #div_resultado
            });

        }

        $('#AddProduto').click(function () { //configura o evento 'click' do #AddProduto -- Botão AddProduto


            var co_produto = $('select[name=co_produto]').val();
            var co_tipo_produto = $('select[name=co_tipo_produto]').val();
            var co_embalagem = $('select[name=co_embalagem]').val();


            if (co_produto.length >= 1 && co_tipo_produto.length >= 1 && co_embalagem.length >= 1) {

                //Envia o valor do nis via Ajax para a pagina busca-dados e realiza a segunda pesquisa pelo método POST
                $.post('<?php echo HOME_URI;?>/busca-dados/', {
                    co_produto: $('select[name=co_produto]').val(),
                    co_tipo_produto: $('select[name=co_tipo_produto]').val(),
                    co_embalagem: $('select[name=co_embalagem]').val()
                }, function (data, textStatus) { //chamada em Ajax para o método POST

                    if (textStatus == 'success') { //verifica se o status está tudo ok!
                        $('#listar_produtos').html(data); //insere o valor de data no div #div_detalhar

                    } else {
                        alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                    }


                }).fail(function (jqXHR, textStatus, error) {


                    document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                    $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>"); //insere o valor de data no div #div_resultado

                });

            } else {

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> Selecione o Produto , Tipo do produto e Embalagem. </b></p></center>');

            }

        });

        $('#uf_cadastro').change(function () { //Função para montar a combo de município.
            if ($(this).val()) {
                $('#co_ibge').hide();
                $('.carregando').show();
                $.getJSON('<?php echo HOME_URI;?>/busca-dados/', {co_estado: $(this).val(), ajax: '1'}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].ibge + '">' + j[i].municipio + '</option>';
                    }
                    $('#co_ibge').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#co_ibge').html('<option value="">–=Escolha um estado=–</option>');
            }
        });

        $('#co_produto').change(function () { //Função para montar a combo de TIPO PRODUTO.
            if ($(this).val()) {
                $('#co_tipo_produto').hide();
                $('.carregando').show();
                $.getJSON('<?php echo HOME_URI;?>/busca-dados/', {co_produto: $(this).val(), ajax: '1'}, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].co_tipo_produto + '">' + j[i].ds_tipo_produto + '</option>';
                    }
                    $('#co_tipo_produto').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#co_tipo_produto').html('<option value="">–=Escolha um tipo=–</option>');
                $('#co_embalagem').html('<option value="">–=Escolha uma embalagem=–</option>');
            }
        });

        $('#co_tipo_produto').change(function () { //Função para montar a combo de TIPO EMBALAGEM.
            if ($(this).val()) {
                $('#co_embalagem').hide();
                $('.carregando').show();
                $.getJSON('<?php echo HOME_URI;?>/busca-dados/', {
                    co_tipo_produto: $(this).val(),
                    produto: $('#co_produto').val(),
                    ajax: '1'
                }, function (j) {
                    var options = '<option value=""></option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].co_embalagem + '">' + j[i].ds_embalagem + '</option>';
                    }
                    $('#co_embalagem').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#co_embalagem').html('<option value="">–=Escolha um tipo=–</option>');
            }
        });


        var maskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(maskBehavior.apply({}, arguments), options);
                }
            };


        $(document).ready(function () {

            /* Opções de mascaras */
            $('#qt_agricultores_fam').mask('00000');
            $('#qt_cooper_associ').mask('00000');
            $('#nu_cnpj').mask('00.000.000/0000-00', {reverse: true});
            $('#dt_inicio_mand_repres_legal').mask("00/00/0000", {placeholder: "__/__/____"});
            $('#dt_fim_mand_repres_legal').mask("00/00/0000", {placeholder: "__/__/____"});
            $('#nu_telefone_comercial').mask(maskBehavior, options);
            $('#nu_telefone_celular').mask(maskBehavior, options);

        });


        //Verificar se A data inicial é maior que a data final
        function gerarData(str) {
            var partes = str.split("/");
            return new Date(partes[2], partes[1] - 1, partes[0]);
        }


        function verificar() {
            var inicio = $('#dt_inicio_mand_repres_legal').val();
            var fim = $('#dt_fim_mand_repres_legal').val();
            if (inicio.length != 10 || fim.length != 10) return;

            if (gerarData(fim) <= gerarData(inicio)) {

                return false;

            } else {

                return true;
            }
        }

    </script>

    <?php

} elseif (!isset($retorno_msg)) {


    $goto_url = HOME_URI . '/principal/';

    // Redireciona para a página
    echo '<meta http-equiv="Refresh" content="0; url=' . $goto_url . '">';
    echo '<script type="text/javascript">window.location.href = "' . $goto_url . '";</script>';
    header('location: ' . $goto_url);

}	 