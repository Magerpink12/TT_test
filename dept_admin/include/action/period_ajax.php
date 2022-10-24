
<?php
include('../configuration/init.php');
if (isset($_GET['department'])) {

	$department = $_GET['department'];
	$subcourse = Subscourse::find_by_query("SELECT * FROM subs_course WHERE department='{$department}'");
	echo json_encode($subcourse);
}




// Addind sub courses

if (isset($_POST['add_period'])) {


	$course = $_POST['course'];
	$department = $_POST['department'];
	$semester = $_POST['semester'];
	$day = $_POST['day'];
	$level = $_POST['level'];
	$venue = $_POST['venue'];
	$start = $_POST['start'];
	$end = $_POST['end'];


	// if($level=='' or $semester=='' or $department=='' or $course=='' or $venue=='' or $start=='' or $end==''){
	// 	return false;
	// }

	$period = Period::find_by_query("SELECT * from period WHERE department='{$department}' AND level='{$level}' AND semester='{$semester}'");
	$period = array_shift($period);



	$week = $period->periods;
	$week = json_decode($week);
	$single_day = new stdClass();
	foreach ($week as $key => $value) {

		if ($key == $day) {

			// $single_day = $week->$key;

			if (key_exists($course, $week->$key)) {

				$ven = $week->$key->$course->venue;
			} else {
				$week->$key->$course = new stdClass();
				$week->$key->$course->venue = $venue;
				$week->$key->$course->start = $start;
				$week->$key->$course->end = $end;
			}

			$week = json_encode($week);
			$period->periods = $week;
			$period->save();
		}
	}

	echo $week;
}














// if(isset($_POST['del_subs'])){

// 	$course = $_POST['course'];
//     $department = $_POST['department'];
//     $semester = $_POST['semester'];
//     $level = $_POST['level'];

// 	$subcourse = Subscourse::find_by_query("SELECT * FROM subs_course WHERE department='{$department}' AND level={$level} LIMIT 1");
// 	$subcourse = array_shift($subcourse);

// 	if (isset($_POST['gst'])) {

// 		$gst_courses =$subcourse->gst_courses;

// 		$gst_courses = json_decode($gst_courses);

// 		$g_sems_co = $gst_courses->$semester;

// 		$filtered = array_filter($g_sems_co,function($var) use ($course){
// 			return $var != $course;
// 		});

// 		$gst_courses->$semester = json_decode(json_encode($filtered));

// 		$new = json_encode($gst_courses);

// 		$subcourse->gst_courses = $new;

// 	}else{


// 		$other_courses =$subcourse->other_courses;

// 		$other_courses = json_decode($other_courses);

// 		$o_sems_co = $other_courses->$semester;

// 		$filtered = array_filter($o_sems_co,function($var) use ($course){

// 			return $var != $course;
// 		});

// 		$other_courses->$semester = json_decode(json_encode($filtered));

// 		$new = json_encode($other_courses);

// 		$subcourse->other_courses = $new;

// 	}


// 	$subcourse->save();

// 	echo $new;


// }




?>