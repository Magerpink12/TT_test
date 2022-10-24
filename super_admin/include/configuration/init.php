<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'TT_test');

define('INCLUDES_PATH', SITE_ROOT . DS . 'super_admin' . DS . 'include' .  DS .'classes');

set_include_path(INCLUDES_PATH);


include_once('function.php');
include_once('new_config.php');
include_once('database.php');
include_once('session.php');
include_once('objects_class.php');
include_once('co-ordinator.php');
include_once('course.php');
include_once('department.php');
include_once('faculty.php');
// include_once('lecturer.php');
include_once('period.php');
include_once('student.php');
include_once('timetable.php');
include_once('venue.php');
include_once('paginate.php');
include_once('super_admin.php');
include_once('subscourse.php');

?>