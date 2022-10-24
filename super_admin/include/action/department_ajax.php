
<?php
include('../configuration/init.php');
	if(isset($_GET['id'])){

		$department = Department::find_by_id($_GET['id']);
		$data = array();
		foreach ($department as $key => $value) {
			$data[$key] = $value;
		}  
		echo json_encode($data);
	}


// updating Department

	if(isset($_POST['update_dept'])){
		
		$name = $_POST['name'];
		$faculty = $_POST['faculty'];
		$max_level_range = $_POST['max_level_range'];
		$id = $_POST['id'];
		
	
		if($name=='' or $max_level_range=='' or $faculty=='' or $id==''){
			$message='<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="alert-icon">
								<i class="far fa-fw fa-bell"></i>
							</div>
							<div class="alert-message">
								<strong>Invalid update!</strong> Some fields are Omited.
							</div>
							</div>';
						$session->message($message);
	
			return false;
		}


			$department = Department::find_by_id($_POST['id']);

			if ($department) {
				
				$department->name = $name;	
				$department->faculty = $faculty;	
				$department->max_level_range = $max_level_range;
		
				if($department->save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>A Department </strong> Was Successfully Updated!
								</div>
								</div>';
							// 	header("Location: ../../index.php?page=co-ordinators");
						$session->message($message);
						// ob_end_flush();
						
						}else{
							
							$message='<div class="alert alert-primary alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>Department: </strong>No Changes Were Made!
								</div>
								</div>';
								
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
						$session->message($message);

		
						}	
						
		
					}else{
		
							$message='<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="alert-icon">
								<i class="far fa-fw fa-bell"></i>
							</div>
							<div class="alert-message">
								<strong>Department: </strong>Not Found!
							</div>
							</div>';
									
								// 	header("Location: ../../index.php?page=co-ordinators");
								// ob_end_flush();
						$session->message($message);
							
		
						}
		
		
	}






	// adding department
	if(isset($_POST['add_dept'])){
	
		$name = $_POST['name'];
		$faculty = $_POST['faculty'];
		$max_level_range = $_POST['max_level_range'];
		
	
		if($name=='' or $max_level_range=='' or $faculty==''){
			$message='<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="alert-icon">
								<i class="far fa-fw fa-bell"></i>
							</div>
							<div class="alert-message">
								<strong>Invalid update!</strong> Name field is Omited.
							</div>
							</div>';
						$session->message($message);
	
			return false;
		}
	
	
			$department = new Department();
	
				$department->name = $name;	
				$department->faculty = $faculty;	
				$department->max_level_range = $max_level_range;	
		
				if($department->save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>Department</strong> Was Successfully Added!
								</div>
								</div>';
							// 	header("Location: ../../index.php?page=co-ordinators");
								$session->message($message);
							// ob_end_flush();
						
						}else{
							
							$message='<div class="alert alert-primary alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>Error!</strong>
								</div>
								</div>';
								
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
							$session->message($message);
	
		
						}
		
		
	}



?>