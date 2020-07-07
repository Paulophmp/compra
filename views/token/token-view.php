<?php
if (!defined('ABSPATH')) exit;

$msg = ''; //criação da variável $msg
$encontrado = false;//criação da variável $encontrado

if (isset($_POST['nu_cnpj']) && isset($_POST['acao'])) {//Valida as variáveis Nu_cnpj e acao.

    if ($_POST['acao'] == 'mensagem') {

        $nu_cnpj = $_POST['nu_cnpj'];
        $no_email = $_POST['no_email'];
        $retorno = $_POST['retorno'];

        if ($retorno == 'enviado') {
            ?>

            <script>
                window.onload = function () {

                    $('#alerta-sigcad-detalhar').click();
                    $('#div_detalhar').html('<center><p class="text-center" ><b> O Código de acesso foi enviado para o e-mail: <p class="text-center" ><?php echo $no_email; ?> </p>   </b></p></center>');


                };
            </script>


            <?php

        } else {
            ?>

            <script>
                window.onload = function () {

                    $('#alerta-sigcad-detalhar').click();
                    $('#div_detalhar').html('<center><p class="text-center" ><b> Ocorreu um erro ao enviar o e-mail: <p class="text-center text-danger" ><?php echo $retorno; ?> </p>   </b></p></center>');


                };
            </script>

            <?php
        }


    } else {// mensagem


        $nu_cnpj = $_POST['nu_cnpj'];
        $acao = $_POST['acao'];

        if (valida_cnpj($nu_cnpj)) {//verifica se o cnpj é valido

            if ($acao == 'verificar') {

                $nu_cnpj_sem_mascara = preg_replace("/[^0-9\s]/", "", $nu_cnpj);//retira a mascara do CNPJ
                $retorno = $modelo->verificar_cnpj($nu_cnpj_sem_mascara);//Verifica se o cnpj está na base de dados

                if ($retorno) {//verifica o retorno

                    $encontrado = true;//se retornar, seta a variável igual a true.
                    $codigo = $retorno[0]['co_acesso'];


                } else {

                    $msg = '<center><p class="bg-danger" ><b> O CNPJ ' . $nu_cnpj . '  não foi encontrado na base de dados. </b></p></center>';


                }

            } elseif ($acao == 'gerar') {

                $id = $_POST['id'];

                $resposta = $modelo->validar_token($id, $nu_cnpj);

                $msg_erro = $resposta['retorno'];


                if ($resposta) { ?>

                    <form id="form_token" action="" method="POST">
                        <input name="nu_cnpj" id="nu_cnpj" value="<?php echo $resposta['nu_cnpj']; ?>" type="hidden">
                        <input name="no_email" id="no_email" value="<?php echo $resposta['no_email']; ?>" type="hidden">
                        <input name="retorno" id="retorno" value="<?php echo trim($msg_erro); ?>" type="hidden">
                        <input name="acao" id="acao" value="mensagem" type="hidden">
                    </form>

                    <script>
                        window.onload = function () {
                            var form_token = document.getElementById("form_token");
                            form_token.submit();
                        };
                    </script>

                <?php } else {//Fim verifica se o cnpj é valido

                    $msg = "<center><p class='bg-danger' ><b>Erro:</b> <b style='color:#9B0000 ' > </b><b> <br> Tente novamente. Ocorreu um problema com a resposta do serviço. </b></center>";

                }


            }

        } else {

            $msg = '<center><p class="bg-danger" ><b> CNPJ inválido ou incorreto, certifique-se de que o CNPJ digitado está correto. </b></p></center>';

        }

    }//fim mensagem 

}//Fim Valida as variáveis Nu_cnpj e acao.

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
                <p>Este formulário foi produzido pela equipe do PAA - Compra Institucional e tem o objetivo cadastrar
                    cooperativas e associações da agricultura familiar, que possuam DAP- Pessoa Jurídica, visando
                    qualificar a oferta de alimentos para disponibilizar aos órgãos públicos compradores da União,
                    Estados, Distrito Federal e Municípios que desejam adquirir alimentos da Agricultura Familiar.
                    Também possibilitará a comunicação e divulgação de chamadas abertas do PAA-Compra Institucional e
                    PNAE além de informes referente as ações em andamento.
                </p>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <?php echo $msg; ?>
            </div>
        </div>


        <?php

        if ($encontrado == true) {//verifica se CNPJ foi encontrado.

            ?>
            <!-- /.row -->
            <div class="row">
                <div class="panel panel-default col-md-4 col-md-offset-4 new-output">
                    <div class="panel-body">
                        <center>
                            <form role="form" id="form_organizacao" action="<?php echo HOME_URI; ?>/token/"
                                  method="post">
                                <div class="form-group col-md-12">
                                    <label for="nu_cnpj">O CNPJ <?php echo $nu_cnpj; ?> foi encontrado na base de dados.
                                        Deseja gerar um código de acesso?</label>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="hidden" name="acao" value="gerar">
                                    <input type="hidden" name="nu_cnpj" value="<?php echo $nu_cnpj_sem_mascara; ?>">
                                    <input type="hidden" name="id" value="<?php echo $codigo; ?>">
                                    <button type="submit" id="gerar_token" class="btn btn-salvar"><b>&nbsp;&nbsp; Gerar
                                            código de acesso &nbsp;&nbsp;</b> </span></button>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <?php

        } else {//fim - verifica se CNPJ foi encontrado.

            ?>

            <!-- /.row -->
            <div class="row">
                <div class="panel panel-default col-md-4 col-md-offset-4 new-output">
                    <div class="panel-body">
                        <center>
                            <form role="form" id="form_organizacao" action="<?php echo HOME_URI; ?>/token/"
                                  method="post">
                                <div class="form-group col-md-12">
                                    <label for="nu_cnpj">Digite o número de CNPJ e clique em "Consultar".</label>
                                    <input type="text" name="nu_cnpj" class="form-control" id="nu_cnpj" maxlength="18"
                                           placeholder="Digite o número do CNPJ" required="">
                                </div>
                                <div class=" col-md-4 col-md-offset-4">
                                    <input type="text" style="display:none" name="acao" value="verificar">
                                    <button type="button" class="btn btn-salvar" id='idBotao'><b>&nbsp;&nbsp; Consultar
                                            &nbsp;&nbsp;</b> </span></button>
                                    <button type="submit" style="display:none" lass="btn btn-salvar" id='idEnviar'><b>
                                            &nbsp;&nbsp; enviar &nbsp;&nbsp;</b> </span></button>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
            <!-- /.row -->


        <?php } ?>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->


<!-- Autocompletar atráves de CEP com Jquery -->
<script type="text/javascript">


    //Verificação das mensagens
    <?php

    if ( isset($_GET['msg']) ) { //Tratamento das mensagens

    if ($_GET['msg'] == 'token') {//mensagem de sucesso!
    ?>

    $(window).load(function () {

        $('#alerta-sigcad-detalhar').click();
        $('#div_detalhar').html('<center><p class="text-danger" ><b> Código de acesso inválido. </b></p></center>');
    });

    <?php

    }elseif ($_GET['msg'] == 'expirado') {//mensagem de sucesso!
    ?>

    $(window).load(function () {

        $('#alerta-sigcad-detalhar').click();
        $('#div_detalhar').html('<center><p class="text-danger" ><b> Código de acesso expirado. </b></p></center>');
    });

    <?php

    }
    }
    ?>



    $(document).ready(function () {

        var formID = document.getElementById("form_organizacao");
        var gerar_token = $("#gerar_token");

        $(formID).submit(function (event) {
            if (formID.checkValidity()) {
                gerar_token.attr('disabled', 'disabled');
            }
        });

        /* Opções de mascaras */
        $('#nu_cnpj').mask('00.000.000/0000-00', {reverse: true});


    });

    $('#idBotao').click(function () { //configura o evento 'click' do #idBotao -- Botão pesquisar

        if ($('#nu_cnpj').val().length <= 0) {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><p class="text-danger" ><b> O campo CNPJ é  obrigatório e não foi preenchido. </b></p></center>');

        } else if ($('#nu_cnpj').val().length >= 1 && ValidarCNPJ($('#nu_cnpj').val()) == false) {

            $('#alerta-sigcad-detalhar').click();
            $('#div_detalhar').html('<center><p class="text-danger" ><b> CNPJ inválido ou incorreto, certifique-se de que o CNPJ digitado está correto. </b></p></center>');

        } else {


            $('#idEnviar').click();//Enviar formulário

        }


    });


</script>

