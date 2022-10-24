<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'TT_test');

// define('INCLUDES_PATH', SITE_ROOT . DS . 'fac_admin' . DS . 'include' .  DS .'classes');
define('INCLUDES_PATH', SITE_ROOT);

set_include_path(INCLUDES_PATH);

include_once('super_admin/include/configuration/new_config.php');
include_once('function.php');
// include_once('new_config.php');
include_once('super_admin/include/classes/database.php');
include_once('super_admin/include/configuration/session.php');
include_once('super_admin/include/classes/objects_class.php');
include_once('super_admin/include/classes/co-ordinator.php');
include_once('super_admin/include/classes/course.php');
include_once('super_admin/include/classes/department.php');
include_once('super_admin/include/classes/faculty.php');
include_once('super_admin/include/classes/lecturer.php');
include_once('super_admin/include/classes/period.php');
include_once('super_admin/include/classes/student.php');
include_once('super_admin/include/classes/timetable.php');
include_once('super_admin/include/classes/venue.php');
include_once('super_admin/include/classes/paginate.php');
include_once('super_admin/include/classes/super_admin.php');
include_once('super_admin/include/classes/subscourse.php');

?>