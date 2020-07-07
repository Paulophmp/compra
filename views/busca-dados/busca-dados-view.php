<?php

//define o encoding do cabeçalho para utf-8
@header('Content-Type: text/html; charset=utf-8');


if (isset($_POST['dados'])) {


    $dados = $_POST['dados'];

    foreach ($dados as $value) {

        $dados_form[$value['name']] = $value['value'];

    }

    ?>
    <div class="row">
        <div class="col-md-12">

            <p class="text-center"><b> Por favor, confirme as informações abaixo.</b></p>

        </div>
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <b> 1- Informações administrativas </b>
                </div>
                <div class="panel-body">
                    <table class="table  table-hover table-striped ">
                        <tbody>

                        <tr>
                            <th>CNPJ</th>
                            <th>Nº DAP Jurídica</th>
                        </tr>
                        <tr>
                            <td><?php echo $dados_form['nu_cnpj']; ?></td>
                            <td><?php echo $dados_form['nu_dap_juridica']; ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">Nome fantasia</th>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $dados_form['no_fantasia']; ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">Razão social</th>
                        </tr>
                        <tr>
                            <td colspan="2"><?php echo $dados_form['no_razao_social']; ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">Tipo da organização</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                switch ($dados_form['co_tipo_organizacao']) {

                                    case "1":
                                        echo "Cooperativa";
                                        break;
                                    case "2":
                                        echo "Associação";
                                        break;
                                    case "3":
                                        echo "Agroindústria familiar";
                                        break;

                                }

                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">É filiada a alguma central de cooperativas? Qual?</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['no_filiacao_central_cooper']; ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Nome do representante legal</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['no_representante_legal']; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Início do mandato do representante legal</th>
                            <th>Fim do mandato do representante legal</th>
                        </tr>
                        <tr>
                            <td><?php echo $dados_form['dt_inicio_mand_repres_legal']; ?></td>
                            <td><?php echo $dados_form['dt_fim_mand_repres_legal']; ?></td>
                        </tr>

                        <tr>
                            <th>Telefone comercial</th>
                            <th>Telefone celular</th>
                        </tr>
                        <tr>
                            <td><?php echo $dados_form['nu_telefone_comercial']; ?></td>
                            <td><?php echo $dados_form['nu_telefone_celular']; ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">Endereço de e-mail da cooperativa/associação</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['email_administrativo']; ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Endereço de e-mail da central de vendas do empreendimento</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['no_email_cetral_vendas']; ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Sítio eletrônico ou rede social</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['no_sitio_eletronico']; ?>
                            </td>
                        </tr>

                        <?php $municipio = $modelo->listar_municipio_ibge($dados_form['co_ibge']); ?>

                        <tr>
                            <th>Estado</th>
                            <th>Município</th>
                        </tr>
                        <tr>
                            <td><?php echo $municipio[0]['estado']; ?></td>
                            <td><?php echo $municipio[0]['municipioibge']; ?></td>
                        </tr>


                        <tr>
                            <th colspan="2">Endereço sede</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $dados_form['no_endereco']; ?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-warning">
                <div class="panel-heading">
                    <b> 2- Organização Social </b>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <tbody>

                        <tr>
                            <th>Quantidade de agricultores familiares cooperados/associados</th>
                            <th>Quantidade de cooperados/associados com DAP</th>
                        </tr>
                        <tr>
                            <td><?php echo $dados_form['qt_agricultores_fam']; ?></td>
                            <td><?php echo $dados_form['qt_cooper_associ']; ?></td>
                        </tr>

                        <tr>
                            <th colspan="2">De quais rede, movimento ou organização representativa está participando?
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php

                                if ($dados_form['unicafes'] == 1) {
                                    echo 'UNICAFES <br>';
                                }
                                if ($dados_form['unisol'] == 1) {
                                    echo 'UNISOL <br>';
                                }
                                if ($dados_form['ecovida'] == 1) {
                                    echo 'REDE ECOVIDA <br>';
                                }
                                if ($dados_form['ocb'] == 1) {
                                    echo 'OCB <br>';
                                }
                                if ($dados_form['mst'] == 1) {
                                    echo 'MST <br>';
                                }
                                if ($dados_form['contag'] == 1) {
                                    echo 'CONTAG <br>';
                                }
                                if ($dados_form['fetraf'] == 1) {
                                    echo 'FETRAF <br>';
                                }
                                if ($dados_form['mpa'] == 1) {
                                    echo 'MPA <br>';
                                }
                                if ($dados_form['mmc'] == 1) {
                                    echo 'MMC <br>';
                                }

                                ?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel panel-warning">
                <div class="panel-heading">
                    <b> 3- Produção </b>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <tbody>

                        <tr>
                            <th colspan="2">Produtos</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php

                                $produtos = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();


                                if (count($produtos) > 0) {


                                    ?>
                                    <table class="table table-condensed">
                                        <thead>
                                        <tr>
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
                                                <td class="text-center"><?php echo $retorno_dados[0]['ds_produto']; ?></td>
                                                <td class="text-center"><?php echo $retorno_dados[0]['ds_tipo_produto']; ?></td>
                                                <td class="text-center"><?php echo $retorno_dados[0]['ds_embalagem']; ?></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>

                                    <?php


                                }

                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">Quais os tipos de certificação o produto possui?</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php

                                if ($dados_form['in_certificado_organico'] == 1) {
                                    echo 'Certificação de sustentabilidade <br>';
                                }
                                if ($dados_form['in_certificado_sustentabilidade'] == 1) {
                                    echo 'Certificação de sustentabilidade <br>';
                                }
                                if ($dados_form['in_certificado_fairtrade'] == 1) {
                                    echo 'Certificação de Fairtrade <br>';
                                }

                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">
                                É um produto da sociobiodiversidade?
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($dados_form['in_produto_sociobiodiversidade'] == 1) {
                                    echo 'Sim';
                                } else {
                                    echo 'Não';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">
                                É um produto de origem quilombola?
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($dados_form['in_produto_origem_quilombola'] == 1) {
                                    echo 'Sim';
                                } else {
                                    echo 'Não';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="2">
                                É um produto de origem indígena?
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($dados_form['in_produto_origem_indigina'] == 1) {
                                    echo 'Sim';
                                } else {
                                    echo 'Não';
                                }
                                ?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <center>
                <button type="button" class="btn btn-salvar" onclick="salvar_form()"><b>Confirmar informações </b>
                </button>
            </center>
        </div>
    </div>
    <?php

} else {

    if (isset($_POST['opcao'])) {

        if ($_POST['opcao'] == 'verificar_cnpj') {

            $cnpj = preg_replace("/[^0-9\s]/", "", $_POST['cnpj']);

            //Executa a query utilizada para gerar a Grid cnpj
            $dados_cnpj = $modelo->verificar_cnpj($cnpj); //arquivos

            if ($dados_cnpj[0]['co_organizacao']) {

                echo "sim";

            } else {

                echo "nao";

            }


        } elseif ($_POST['opcao'] == 'verificar_produtos') {

            $produtos = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();


            if (count($produtos) > 0) {

                echo "sim";

            } else {

                echo "nao";


            }
        } elseif ($_POST['opcao'] == 'remover_produto') {

            $id_produto = $_POST['id_produto'];

            if ($id_produto == NULL || $id_produto == '') {
                echo "
                    <script type=\"text/javascript\">
                    alert ('O $id_produto do produto deve ser inteiro e maior que zero');
                    </script>";
                return false;
            }


            unset ($_SESSION['produtos'][$id_produto]);
            if (count($_SESSION['produtos']))//se ainda houver produtos no carrinho
            {
                //organiza as chaves do array desde zero até (count ($_SESSION['produtos']) - 1)
                $car_keys = range(0, (count($_SESSION['produtos']) - 1));
                $_SESSION['produtos'] = array_combine($car_keys, $_SESSION['produtos']);
            }


            $produtos_grid = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();


            if (count($produtos_grid) > 0) {


                ?>
                <center></center>
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
                    for ($a = 0; $a < count($produtos_grid); $a++) {

                        $co_produto = $produtos_grid[$a]['co_produto'];
                        $co_tipo_produto = $produtos_grid[$a]['co_tipo_produto'];
                        $co_embalagem = $produtos_grid[$a]['co_embalagem'];
                        $retorno_dados = $modelo->buscar_produto($co_produto, $co_tipo_produto, $co_embalagem);

                        ?>
                        <tr>
                            <th class="text-right"><?php echo $a + 1; ?></th>
                            <td><?php echo $retorno_dados[0]['ds_produto']; ?></td>
                            <td><?php echo $retorno_dados[0]['ds_tipo_produto']; ?></td>
                            <td><?php echo $retorno_dados[0]['ds_embalagem']; ?></td>
                            <td>
                                <button type="button" onclick="remover_produto(<?php echo $a; ?>)"><i
                                        class="fa fa-times"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <?php


            }

        }


    } elseif (isset($_GET['co_estado'])) {


        $coduf = $_GET['co_estado'];

        //Executa a query utilizada para gerar a Grid Municípios
        $dados_municipio = $modelo->listar_municipio($coduf); //arquivos

        foreach ($dados_municipio as $valor) {

            $cidades[] = array(
                'ibge' => $valor['codigoibge7'],
                'municipio' => $valor['municipioibge'],
            );

        }


        die(json_encode($cidades, JSON_UNESCAPED_UNICODE));


    } elseif (isset($_GET['co_produto'])) {

        $co_produto = $_GET['co_produto'];

        $dados_tipo_produto = $modelo->listar_tipo_produtos($co_produto); //arquivos

        foreach ($dados_tipo_produto as $produtos) {

            $tipo_produto[] = array(
                'co_tipo_produto' => $produtos['co_tipo_produto'],
                'ds_tipo_produto' => $produtos['ds_tipo_produto'],
            );

        }


        die(json_encode($tipo_produto, JSON_UNESCAPED_UNICODE));


    } elseif (isset($_GET['co_tipo_produto']) && isset($_GET['produto'])) {


        $co_tipo_produto = $_GET['co_tipo_produto'];
        $co_produto = $_GET['produto'];

        $dados_embalagem = $modelo->listar_embalagem($co_tipo_produto, $co_produto); //arquivos

        foreach ($dados_embalagem as $embalagem) {

            $embalagens[] = array(
                'co_embalagem' => $embalagem['co_embalagem'],
                'ds_embalagem' => $embalagem['ds_embalagem'],
            );

        }


        die(json_encode($embalagens, JSON_UNESCAPED_UNICODE));


    } else {

        //session_destroy();

        $co_produto = $_POST['co_produto'];
        $co_tipo_produto = $_POST['co_tipo_produto'];
        $co_embalagem = $_POST['co_embalagem'];


        if (($co_produto == NULL || $co_produto == '' || $co_produto == 0) || ($co_tipo_produto == NULL || $co_tipo_produto == '' || $co_tipo_produto == 0) || ($co_embalagem == NULL || $co_embalagem == '' || $co_embalagem == 0)) {
            echo "
                  <script type=\"text/javascript\">
                  alert ('Selecione um produto');
                  </script>";
            return false;
        }

        //próxima chave de $_SESSION['']:
        $k = isset ($_SESSION['produtos']) ? count($_SESSION['produtos']) : 0;

        $retorno = $modelo->buscar_produto($co_produto, $co_tipo_produto, $co_embalagem);
        $co_produto_montado = $retorno[0]['co_produto_montado'];
        $inserir = true;
        $msg = '';


        $produtos_verificar = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();

        if (count($produtos_verificar) > 0) {

            for ($b = 0; $b < count($produtos_verificar); $b++) {

                if ($co_produto_montado == $produtos_verificar[$b]['co_produto_montado']) {

                    $msg = '<center><p class="text-danger" ><b> Produto já selecionado! </b></p></center>';

                    $inserir = false;

                }

            }


        }

        if ($inserir == true) {

            $_SESSION['produtos'][$k]['co_produto_montado'] = $co_produto_montado;
            $_SESSION['produtos'][$k]['co_produto'] = $co_produto;
            $_SESSION['produtos'][$k]['co_tipo_produto'] = $co_tipo_produto;
            $_SESSION['produtos'][$k]['co_embalagem'] = $co_embalagem;

        } else {


        }

        $produtos = isset ($_SESSION['produtos']) ? $_SESSION['produtos'] : array();


        if (count($produtos) > 0) {


            ?>
            <center> <?php echo $msg; ?> </center>
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
                            <button type="button" onclick="remover_produto(<?php echo $a; ?>)"><i
                                    class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

            <?php


        }


    }

}

?>            
