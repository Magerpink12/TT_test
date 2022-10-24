
<?php
include('../configuration/init.php');
	if(isset($_GET['id'])){

		$course = Course::find_by_id($_GET['id']);
		$data = array();
		foreach ($course as $key => $value) {
			$data[$key] = $value;
		}  
		echo json_encode($data);
	}

	function notification($type, $msg) {

         $message = '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="alert-icon">
            <i class="far fa-fw fa-bell"></i>
        </div>
        <div class="alert-message">
            ' . $msg . '
        </div>
        </div>';

        return $message;
    }


// updating course

	if(isset($_POST['update_course'])){

		$code= $_POST['code'];
        $title= $_POST['title'];
        $unit= $_POST['unit'];
        $level= $_POST['level'];
        $semester= $_POST['semester'];
        $department= $_POST['department'];
        $id= $_POST['id'];

		if($code=='' or $title=='' or $unit=='' or $level=='' or $semester=='' or $department=='' or $id==''){
			$message= notification('danger','<strong>Invalid update!</strong> Some fields are Omited.');
			$session->message($message);
			return false;
		}

		$course = Course::find_by_id($id);

		if ($course) {

			$course->code = $code;
			$course->title = $title;
			$course->unit = $unit;
			$course->semester = $semester;
			$course->department = $department;
			$course->level = $level;

			if($course->save()){
				$message= notification('success','Course Successfuly Updated!');
				$session->message($message);
			}else{
				$message= notification('primary','<strong>course: </strong>No Changes Were Made!');
				$session->message($message);
			}	
		}else{
		$message= notification('danger','<strong>Course </strong> Not Found!.');
		$session->message($message);
		
		}
		
		
	}



	// adding course
	if(isset($_POST['add_course'])){

		$code= $_POST['code'];
        $title= $_POST['title'];
        $unit= $_POST['unit'];
        $level= $_POST['level'];
        $semester= $_POST['semester'];
        $department= $_POST['department'];
		
	
		if($code=='' or $title=='' or $unit=='' or $level=='' or $semester=='' or $department==''){
			$message= notification('danger','<strong>Invalid update!</strong> Some fields are Omited.');
			$session->message($message);
			return false;
		}
	
	
			$course = new Course();
	
				$course->course_code = $code;
				$course->title = $title;
				$course->unit = $unit;
				$course->level = $level;
				$course->semester = $semester;
				$course->department	 = $department;
		
				if($course->save()){
					
							$message=notification('success','<strong>course</strong> Was Successfully Added!');
							// 	header("Location: ../../index.php?page=co-ordinators");
								$session->message($message);
							// ob_end_flush();
						
						}else{
							$message=notification('primary','<strong>Co-ordinator: </strong> The course Already Existed!');
							
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
							$session->message($message);
	
		
						}
		
		
	}



?>