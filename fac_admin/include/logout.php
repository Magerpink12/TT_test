<?php
include('configuration/init.php');

// print_r($session->user);
unset($_SESSION['fac_admin']);
header('Location: ../../index.php');
// print_r($session->user['dept_admin']);


?>