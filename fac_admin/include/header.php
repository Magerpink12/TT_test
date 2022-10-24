<?php

include('include/configuration/init.php');




?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5"> -->
	<meta name="author" content="AdminKit">
	<!-- <meta http-equiv="Location" content="http://example.com/"> -->
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<script src="js/jquery-3.6.0.js"></script>
	<script type="text/javascript" src="js/gstatic/loader.js"></script>
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<title>TTWizard - Faculty Admin</title>

	<link href="css/app.css" rel="stylesheet">
	<script>

	$(document).bind("ajaxSend",()=>{

		$('.coo').fadeIn("slow")
       
        
    }).bind("ajaxComplete",()=>{
		$('.coo').fadeOut("slow")
    })
	$(window).on('load',function(){
		// $('.coo').addClass('finished')
		$('.coo').fadeOut("slow")

	})
	</script>
</head>

<body>
	<div class="wrapper">