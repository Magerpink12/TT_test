
<?php
include('../configuration/init.php');
	if(isset($_GET['id'])){

		$venue = venue::find_by_id($_GET['id']);
		$data = array();
		foreach ($venue as $key => $value) {
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


// updating venue

	if(isset($_POST['update_venue'])){

		$capacity = $_POST['capacity'];
        $department = $_POST['department'];
        $name = $_POST['name'];
        $id = $_POST['id'];
		
	
		if($capacity=='' or $department=='' or $name=='' or $id==''){
			$message= notification('danger','<strong>Invalid update!</strong> Some fields are Omited.');
			$session->message($message);
			return false;
		}

		$venue = Venue::find_by_id($id);

		if ($venue) {

			$venue->capacity = $capacity;
			$venue->name = $name;
			$venue->department = $department;

			if($venue->save()){
				$message= notification('success','venue Successfuly Updated!');
				$session->message($message);
			}else{
				$message= notification('primary','<strong>venue: </strong>No Changes Were Made!');
				$session->message($message);
			}	
		}else{
		$message= notification('danger','<strong>venue </strong> Not Found!.');
		$session->message($message);
		
		}
		
		
	}



	// adding venue
	if(isset($_POST['add_venue'])){

		$capacity = $_POST['capacity'];
        $department = $_POST['department'];
        $name = $_POST['name'];
		
	
		if($capacity=='' or $department=='' or $name==''){
			$message= notification('danger','<strong>Invalid update!</strong> Some fields are Omited.');
			$session->message($message);
			return false;
		}
	
	
			$venue = new Venue();
	
				$venue->capacity = $capacity;
				$venue->department = $department;
				$venue->name = $name;
		
				if($venue->save()){
					
							$message=notification('success','<strong>venue</strong> Was Successfully Added!');
							// 	header("Location: ../../index.php?page=co-ordinators");
								$session->message($message);
							// ob_end_flush();
						
						}else{
							$message=notification('primary','<strong>Co-ordinator: </strong> The venue Already Existed!');
							
							// 	header("Location: ../../index.php?page=co-ordinators");
							// ob_end_flush();
							$session->message($message);
	
		
						}
		
		
	}



?>