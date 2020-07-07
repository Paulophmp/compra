<?php
if (!defined('ABSPATH')) exit;

$retorno_listar_produtos = $modelo->listar_produtos();//Recebe a lista de produtos

/* Validação do campo UF*/
$co_uf = false;
if (isset($_POST['uf_cadastro'])) {//Veirifica se a variável foi criada

    $co_uf = $_POST['uf_cadastro'];
}
/* FIM - Validação do campo UF*/


/* Validação do campo tp_produto*/
$co_prod = false;
if (isset($_POST['tp_produto'])) {//Veirifica se a variável foi criada

    $co_prod = $_POST['tp_produto'];
}
/* FIM - Validação do campo tp_produto*/


/* Validação do campo municipio*/
$ibge = false;
if (isset($_POST['municipio'])) {//Veirifica se a variável foi criada

    $ibge = $_POST['municipio'];
}
/* FIM - Validação do campo municipio*/

/* Array com os Estados */
$arr_mu[12] = "Acre";
$arr_mu[27] = "Alagoas";
$arr_mu[16] = "Amapá";
$arr_mu[13] = "Amazonas";
$arr_mu[29] = "Bahia";
$arr_mu[23] = "Ceará";
$arr_mu[53] = "Distrito Federal";
$arr_mu[32] = "Espírito Santo";
$arr_mu[52] = "Goiás";
$arr_mu[21] = "Maranhão";
$arr_mu[51] = "Mato Grosso";
$arr_mu[50] = "Mato Grosso Do Sul";
$arr_mu[31] = "Minas Gerais";
$arr_mu[15] = "Pará";
$arr_mu[25] = "Paraíba";
$arr_mu[41] = "Paraná";
$arr_mu[26] = "Pernambuco";
$arr_mu[22] = "Piauí";
$arr_mu[33] = "Rio de Janeiro";
$arr_mu[24] = "Rio Grande Do Norte";
$arr_mu[43] = "Rio Grande Do Sul";
$arr_mu[11] = "Rondônia";
$arr_mu[14] = "Roraima";
$arr_mu[42] = "Santa Catarina";
$arr_mu[35] = "São Paulo";
$arr_mu[28] = "Sergipe";
$arr_mu[17] = "Tocantins";
/* Sim Array com os Estados */


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
                <p></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h4>Gestores da administração pública da União, Estados, Distrito Federal e Municípios que desejam
                    adquirir alimentos oriundos da Agricultura Familiar.</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>

                </p>
                <p>
                    Ao realizar a pesquisa na base de dados da oferta organizada de produtos da agricultura familiar, os
                    gestores públicos poderão identificar os empreendimentos por estado, produtos, especificação técnica
                    e contatos. Esta base de dados disponibilizada para a pesquisa, será atualizada periodicamente com
                    intuito de ampliar e qualificar as informações acerca da oferta de produtos da agricultura familiar
                    e tem como objetivo apoiar as aquisições dos órgãos compradores interessados na execução do
                    PAA-Compra Institucional e do PNAE.
                </p>
            </div>
        </div>
        <div class="row">
            <!-- Bloco Dados Pessoais  -->
            <div class="col-lg-12">
                <fieldset>
                    <legend class="text-redesuas">Filtrar seus resultados de pesquisa</legend>
                    <form id="form_consulta" action="<?php echo HOME_URI; ?>/" method="post">
                        <div class="form-group col-md-4">
                            <label for="uf_cadastro">Estado <span class="text-danger">*</span></label>
                            <select name="uf_cadastro" class="form-control" id="uf_cadastro" required="">
                                <?php if ($co_uf == false) {
                                    echo "<option value=''>-=Selecione o Estado=-</option>";
                                }
                                while (list($uf, $nome) = each($arr_mu)) { ?>

                                    <option value="<?php echo $uf; ?>" <?php if ($co_uf != false && $co_uf == $uf) {
                                        echo "selected";
                                    } ?> ><?php echo $nome; ?></option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="municipio"> Município </label>
                            <select name="municipio" class="form-control" id="municipio">
                                <option value="" id="select_municipio">-=Todos=-</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tp_produto">Produto </label>
                            <select name="tp_produto" class="form-control" id="tp_produto">
                                <?php

                                if ($co_prod == false) {
                                    echo "<option value=''>-=Todos=-</option>";
                                } else {
                                    echo "<option value=''>-=Todos=-</option>";
                                }

                                foreach ($retorno_listar_produtos as $dado) { //Combo Tipo Logradouro$co_prod
                                    ?>

                                    <option
                                        value="<?php echo $dado['co_produto']; ?>" <?php if ($co_prod != false && $co_prod == $dado['co_produto']) {
                                        echo "selected";
                                    } ?> > <?php echo $dado['ds_produto']; ?></option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="cert_organico">Certificação de orgânico? </label> &nbsp;&nbsp;
                            <input type="checkbox" id="cert_organico" name="cert_organico" value="sim">
                        </div>

                        <div class="form-group col-md-12">
                            <center>
                                <button type="button" class="btn btn-salvar" id='idBotao'><b>&nbsp;&nbsp; Pesquisar
                                        &nbsp;&nbsp;</b> </span></button>
                                <button type="submit" style="display:none" lass="btn btn-salvar" id='idEnviar'><b>&nbsp;&nbsp;
                                        enviar &nbsp;&nbsp;</b> </span></button>
                            </center>
                        </div>

                    </form>
                </fieldset>
                <!-- /Bloco Dados Pessoais  -->
            </div>
        </div>
        <!-- /.row -->

        <?php

        /*
        * Resultado da pesquisa
        *
        *
        */

        if (isset($_POST['uf_cadastro'])) {//Veirifica se a variável uf_cadastro foi criada

            if (isset($_POST['uf_cadastro']) && isset($_POST['municipio']) && isset($_POST['tp_produto'])) {//Veirifica as variáveis foi uf_cadastro , municipio e tp_produto foram criada

                $uf_cadastro = $_POST['uf_cadastro'];// Seta a variável uf_cadastro
                $municipio = $_POST['municipio'];// Seta a variável municipio
                $tp_produto = $_POST['tp_produto'];// Seta a variável tp_produto

                if (isset($_POST['cert_organico'])) {//Veirifica se a variável cert_organico  foi criada

                    $cert_organico = 'sim';// Seta a variável cert_organico


                } else {

                    $cert_organico = 'nao';// Seta a variável cert_organico

                }

                $retorno_listar_organizacoes = $modelo->listar_organizacoes($uf_cadastro, $municipio, $cert_organico, $tp_produto);//Recebe a lista de organizações

            if ($retorno_listar_organizacoes) {//Resultado da pesquisa

                ?>

                <table id="myTable" class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Município</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $linha_aux = 1;
                    foreach ($retorno_listar_organizacoes as $dado_org) { //lista de organizações
                        ?>
                        <tr>
                            <td><?php echo $linha_aux++; ?></td>
                            <td><?php echo $dado_org['municipio_endereco']; ?></td>
                            <td><?php echo $dado_org['no_fantasia']; ?></td>
                            <td><?php echo mask($dado_org['nu_cnpj'], '##.###.###/####-##'); ?></td>
                            <td>
                                <button Onclick="detalhes('<?php echo $dado_org['co_organizacao'] ?>', 'detalhar')"
                                        class="btn btn-salvar btn-xs fa fa-list" id='idBotao'><b>&nbsp;&nbsp; Detalhar
                                        &nbsp;&nbsp;</b> </span></button>
                                <button Onclick="detalhes('<?php echo $dado_org['co_organizacao'] ?>', 'produtos')"
                                        class="btn btn-primary btn-xs fa fa-list" id='idBotao'><b>&nbsp;&nbsp; Produtos
                                        &nbsp;&nbsp;</b> </span></button>
                            </td>
                        </tr>
                        <?php

                    }

                    ?>
                    </tbody>
                </table>
                <script type="text/javascript">

                    function detalhes(co_organizacao, tipo_solicitacao) {

                        //Envia o valor do nis via Ajax para a pagina busca-dadose realiza a segunda pesquisa pelo método POST
                        $.post('<?php echo HOME_URI;?>/busca-detalhes/', {
                            co_organizacao: co_organizacao,
                            tipo_solicitacao: tipo_solicitacao
                        }, function (data, textStatus) { //chamada em Ajax para o método POST

                            if (textStatus == 'success') { //verifica se o status está tudo ok!

                                $('#alerta-sigcad-detalhar').click();
                                $('#div_detalhar').html(data);

                            } else {
                                alert('Erro no request!'); //mostra erro caso não tenha sido bem sucedido
                            }


                        }).fail(function (jqXHR, textStatus, error) {


                            document.getElementById('alerta-sigcad-detalhar').click();//Chamama o Modal de resultados com o botão Fechar
                            $('#div_detalhar').html("<center><b>Erro:</b> <b style='color:#9B0000 ' > " + error + "</b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>");

                        });

                    }


                </script>
            <?php


            } else {//Fim - Resultado da pesquisa

            ?>

                <div class="form-group col-md-12">
                    <center>
                        Nenhum resultado encontrado para a sua Pesquisar!
                    </center>
                </div>

            <?php

            }

            } else {

            ?>

                <div class="form-group col-md-12">
                    <center>
                        Nenhum resultado encontrado para a sua Pesquisar!
                    </center>
                </div>

                <?php

            }


        } //Fim pesquisa

        ?>

    </div> <!-- /.container-fluid -->

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
        }elseif ($_GET['msg'] == 'atualizar') { //mensagem de erro ao cadastrar!

        ?>

        $(window).load(function () {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><h4 class="text-success" ><b> Cadastro atualizado com sucesso! </b></h4></center>');
        });


        <?php
        }
        }

        ?>
        //FIM - Verificação das mensagens

        $('#idBotao').click(function () { //configura o evento 'click' do #idBotao -- Botão pesquisar

            if ($('#uf_cadastro').val().length <= 0) {//Valida o campo uf_cadastro

                $('#alerta-sigcad-detalhar').click();
                $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo Estado é  obrigatório e não foi preenchido. </b></p></center>');

            } else {

                $('#idEnviar').click();//Enviar formulário

            }

        });

        $('#uf_cadastro').change(function () { //Função para montar a combo de município.
            if ($(this).val()) {
                $('#municipio').hide();
                $('.carregando').show();
                $.getJSON('<?php echo HOME_URI;?>/busca-dados/', {
                    co_estado: $(this).val(),
                    ajax: 'true'
                }, function (j) {
                    var options = '<option value="">-=Todos=-</option>';
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].ibge + '">' + j[i].municipio + '</option>';
                    }
                    $('#municipio').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#municipio').html('<option value="">– Todos –</option>');
            }
        });


        // When the document is ready
        $(document).ready(function () {


            <?php if ($co_uf != false) { ?>//Verifica a uf_cadastro para realizar o preechimento da combo município, após a pesquisa

            $.getJSON('<?php echo HOME_URI;?>/busca-dados/', {
                co_estado: <?php echo $co_uf;?>,
                ajax: 'true'
            }, function (j) {

                var ibge = <?php if ($ibge != false) {
                    echo $ibge;
                } else {
                    echo 'false';
                } ?>;
                var options = '<option value="">-=Todos=-</option>';  // selected
                for (var i = 0; i < j.length; i++) {

                    if (ibge == j[i].ibge) {

                        options += '<option value="' + j[i].ibge + '" selected >' + j[i].municipio + '</option>';

                    } else {

                        options += '<option value="' + j[i].ibge + '">' + j[i].municipio + '</option>';
                    }

                }
                $('#municipio').html(options).show();
                $('.carregando').hide();
            });


            <?php } ?>


            // Modais Bootstrap
            $('.launch-modal-alert').click(function () {
                $('#alertaModal').modal({
                    keyboard: true,
                    backdrop: 'static'
                });
            });

            $('.launch-modal').click(function () { // Modal com botão fechar.
                $('#sigcadModal').modal({
                    keyboard: true,
                    backdrop: 'static'
                });
            });

            $('.launch-modal-detalhar').click(function () { // Modal com botão fechar.
                $('#sigcadModalDetalhar').modal({
                    keyboard: true,
                    backdrop: 'static'
                });
            });

            $('#myTab a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            $('.launch-modalsemBotao').click(function () { // Modal sem botão fechar.
                $('#sigcadModalsemBotao').modal({
                    keyboard: false,
                    backdrop: 'static'
                });
            });
            //Fim Modais Bootstrap
        });


    </script>

</div> <!-- .wrap -->
