<?php

function class_auto_loader($class){
	$class = strtolower($class);
	$the_path = "include/classes/{$class}.php";
	// if (file_exists($the_path)) {
	// 	require_once($the_path);
	// }else{
	// 	die("the file named {$class}.php was not found..");
	// }

	if (is_file($the_path) && !class_exists($class)) {
		include($the_path);
	}
}

spl_autoload_register('class_auto_loader');

function redirect($location){
        header("Location: {$location}");

}
?>