<?php if ( ! defined('ABSPATH')) exit; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Empreendimentos da Agricultura Familiar</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<!-- Bootstrap Core CSS -->

    <link href="<?php echo HOME_URI;?>/views/_css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo HOME_URI;?>/views/_css/planoacao.css" rel="stylesheet">
    
    
    <!-- Custom Fonts -->
    <link href="<?php echo HOME_URI;?>/views/_fontes/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
        .div_ajax {
            width: 600px;
            height: 600px;
        }
        .loader {
            display: none;
            float: left;
        }
    </style>


	<!-- JavaScript -->	 
	<script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/jquery.min.js"></script>	 
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/bootstrap-table-expandable.js"></script>   
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/ui.core.js"></script>   
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/ui.dropdownchecklist.js"></script>   
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/jquery.cpfcnpj.js"></script>
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/jquery.mask.js"></script>
    <script type="text/javascript" src="<?php echo HOME_URI;?>/views/_js/validar_data.js"></script>

</head>

<body>
