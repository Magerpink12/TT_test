
<?php
include('../configuration/init.php');
	if(isset($_GET['id'])){

		$coordinator = Coordinator::find_by_id($_GET['id']);
		$data = array();
		foreach ($coordinator as $key => $value) {
			$data[$key] = $value;
		}  
		echo json_encode($data);
	}


// updating Co-ordinator

	if(isset($_POST['update'])){
		
		$name = $_POST['name'];
		$title = $_POST['title'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		// $faculty = $_POST['faculty'];
		$department = $_POST['department'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$coordinate = $_POST['coordinate'];

		if($name=='' or $coordinate=='' or $phone =='' or $department =='' or $username =='' or $password ==''){
			$message='<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="alert-icon">
								<i class="far fa-fw fa-bell"></i>
							</div>
							<div class="alert-message">
								Invalid update!</strong> Some fields are Omited.
							</div>
							</div>';
						$session->message($message);

			return false;
		}


			$coodinator = Coordinator::find_by_id($_POST['user_id']);

			if ($coodinator) {
				
				$coodinator->name		= $name;
				$coodinator->title		= $title;			
				$coodinator->email		= $email;			
				$coodinator->phone		= $phone;				
				$coodinator->faculty	= Coordinator::coo_dept_fac($department);		
				$coodinator->department	= $department;		
				$coodinator->username	= $username;	
				$coodinator->password	= $password;
				$coodinator->coordinate= $coordinate;

		
				if($coodinator->validate_and_save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									A Co-ordinator </strong> Was Successfully Updated!
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
								Co-ordinator: </strong>'.$coodinator->error.'
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
								Co-ordinator: </strong>Not Found!
							</div>
							</div>';
									
								// 	header("Location: ../../index.php?page=co-ordinators");
								// ob_end_flush();
						$session->message($message);
							
		
						}
		
		
	}






	// adding co-ordinator
	if(isset($_POST['add_co'])){
	
		$name = $_POST['name'];
		$title = $_POST['title'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		// $faculty = $_POST['faculty'];
		$department = $_POST['department'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$coordinate = $_POST['coordinate'];
	
		if($name=='' or $coordinate=='' or $phone =='' /*or $faculty ==''*/ or $department =='' or $username =='' or $password ==''){
			$message='<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<div class="alert-icon">
								<i class="far fa-fw fa-bell"></i>
							</div>
							<div class="alert-message">
								<strong>Invalid update!</strong> Some field are Omited.
							</div>
							</div>';
						$session->message($message);
	
			return false;
		}
	
	
			$coodinator = new Coordinator();
	
				$coodinator->name		= $name;
				$coodinator->title		= $title;			
				$coodinator->email		= $email;			
				$coodinator->phone		= $phone;				
				$coodinator->faculty	= Coordinator::coo_dept_fac($department);		
				$coodinator->department	= $department;		
				$coodinator->username	= $username;	
				$coodinator->password	= $password;	
				$coodinator->coordinate	= $coordinate;	
		
				
		
				if($coodinator->validate_and_save()){
							$message='<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="alert-icon">
									<i class="far fa-fw fa-bell"></i>
								</div>
								<div class="alert-message">
									<strong>A Co-ordinator </strong> Was Successfully Added!
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
									<strong>Co-ordinator: </strong>Either The Department Or The Faculty Already has Coordinator!
								</div>
								</div>';
								
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
							$session->message($message);
	
		
						}
		
		
	}



?>