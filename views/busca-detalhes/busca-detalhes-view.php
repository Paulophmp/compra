<?php


$co_organizacao = $_POST['co_organizacao'];
$tipo_solicitacao = $_POST['tipo_solicitacao'];

if ($tipo_solicitacao == 'detalhar') {


    $retorno_co_organizacao = $modelo->listar_organizacao($co_organizacao);//Recebe a lista de organizações

    foreach ($retorno_co_organizacao as $retorno) { //lista de organizações

        ?>
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <b> Informações administrativas </b>
                    </div>
                    <div class="panel-body">
                        <table class="table  table-hover table-striped ">
                            <tbody>

                            <tr>
                                <th>CNPJ</th>
                                <th>DAP Jurídica</th>
                            </tr>
                            <tr>
                                <td><?php echo mask($retorno['nu_cnpj'], '##.###.###/####-##'); ?></td>
                                <td><?php echo $retorno['nu_dap_juridica']; ?></td>
                            </tr>

                            <tr>
                                <th colspan="2">Nome fantasia</th>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo $retorno['no_fantasia']; ?></td>
                            </tr>

                            <tr>
                                <th colspan="2">Razão social</th>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo $retorno['no_razao_social']; ?></td>
                            </tr>

                            <tr>
                                <th colspan="2">Tipo da organização</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php
                                    switch ($retorno['co_tipo_organizacao']) {

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
                                <th>Telefone comercial</th>
                                <th>Telefone celular</th>
                            </tr>
                            <tr>
                                <td><?php echo mask($retorno['nu_telefone_comercial'], '(##) ####-#####'); ?></td>
                                <td><?php echo mask($retorno['nu_telefone_celular'], '(##) ####-#####'); ?></td>
                            </tr>

                            <tr>
                                <th colspan="2">Endereço de e-mail da cooperativa/associação</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <?php echo $retorno['no_email_administrativo']; ?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">Sítio Eletrônico</th>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo $retorno['no_sitio_eletronico']; ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php

    }

}

if ($tipo_solicitacao == 'produtos') {

    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <b> Produtos </b>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th class="text-center">Item</th>
                            <th class="text-center">Produto</th>
                            <th class="text-center">Tipo do produto</th>
                            <th class="text-center">Embalagem</th>
                        </tr>
                        <?php

                        $retorno_listar_produtos_org = $modelo->listar_produtos_organizacoes($co_organizacao);//Recebe a lista de organizações

                        $linha = 1;
                        foreach ($retorno_listar_produtos_org as $dado_produtos_org) { //lista de organizações

                            ?>
                            <tr>
                                <td class="text-center"><?php echo $linha++; ?></td>
                                <td class="text-center"><?php echo $dado_produtos_org['ds_produto']; ?></td>
                                <td class="text-center"><?php echo $dado_produtos_org['ds_tipo_produto']; ?></td>
                                <td class="text-center"><?php echo $dado_produtos_org['ds_embalagem']; ?></td>
                            </tr>
                            <?php

                        }

                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
}
