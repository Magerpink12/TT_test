<?php

include('include/configuration/init.php');




?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="js/jquery-3.6.0.js"></script>
	<script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="js/gstatic/loader.js"></script>
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
<link rel="stylesheet" href="include\css.css">


	<title>TTWizard - Dept Admin</title>

	<link href="css/app.css" rel="stylesheet">
	<script>

	$(document).bind("ajaxSend",()=>{

		$('.coo').fadeIn("slow")

    }).bind("ajaxComplete",()=>{

		$('.coo').fadeOut("slow")

    })

	$(window).on('load',function(){

		$('.coo').fadeOut("slow")

	})
	</script>
</head>

<body>
	<div class="wrapper">