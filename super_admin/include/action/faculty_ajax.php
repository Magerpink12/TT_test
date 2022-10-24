
<?php
include('../configuration/init.php');
	if(isset($_GET['id'])){

		$faculty = Faculty::find_by_id($_GET['id']);
		$data = array();
		foreach ($faculty as $key => $value) {
			$data[$key] = $value;
		}  
		echo json_encode($data);
	}


// updating Faculty

	if(isset($_POST['update_fac'])){
		
		$name = $_POST['name'];

		if($name==''){
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


			$faculty = Faculty::find_by_id($_POST['fac_id']);

			if ($faculty) {
				
				$faculty->name = $name;
		
				if($faculty->save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>A Co-ordinator </strong> Was Successfully Updated!
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
									<strong>Faculty: </strong>No Changes Were Made!
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
								<strong>Co-ordinator: </strong>Not Found!
							</div>
							</div>';
									
								// 	header("Location: ../../index.php?page=co-ordinators");
								// ob_end_flush();
						$session->message($message);
							
		
						}
		
		
	}






	// adding faculty
	if(isset($_POST['add_fac'])){
	
		$name = $_POST['name'];
		
	
		if($name==''){
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
	
	
			$faculty = new Faculty();
	
				$faculty->name = $name;	
		
				if($faculty->save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>Faculty</strong> Was Successfully Added!
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
									<strong>Co-ordinator: </strong>Either The Department Or The Faculty Already has Faculty!
								</div>
								</div>';
								
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
							$session->message($message);
	
		
						}
		
		
	}



?>