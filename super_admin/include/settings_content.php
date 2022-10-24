<?php
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


if (isset($_POST['super_update_public'])) {

	$super->username = trim($_POST['username'])==''? $super->username : trim($_POST['username']);
	if ($super->update()) {
		$message= notification('success','<strong>Public Info</strong> Updated.');
		$session->message($message);
	}else{
		$message= notification('danger','<strong>Error</strong> Cannot Update.');
		$session->message($message);
	}

	
	header('Location: index.php?page=settings');


}

if (isset($_POST['super_update_private'])) {


	$super->name = trim($_POST['name'])==''? $super->name : trim($_POST['name']);
	$super->email = trim($_POST['email'])==''? $super->email : trim($_POST['email']);
	if ($super->update()) {
		$message= notification('success','<strong>Private Info</strong> Updated.');
		$session->message($message);
	}else{
		$message= notification('danger','<strong>Error</strong> Cannot Update.');
		$session->message($message);
	}
	header('Location: index.php?page=settings');
}
if (isset($_POST['super_update_password'])) {

	
	if (trim($_POST['current']) != $super->password) {
		$message= notification('danger','<strong>Current </strong> Password Incorrect .');
		$session->message($message);

		header('Location: index.php?page=settings');

	}else if (trim($_POST['new']) != trim($_POST['confirm'])) {
		$message= notification('danger','<strong>Password </strong> Varification failed .');
		$session->message($message);

		header('Location: index.php?page=settings');

	}else{

		$super->password = trim($_POST['new'])==''? $super->password : trim($_POST['new']);
		if ($super->update()) {
			$message= notification('success','<strong>Password</strong> Updated.');
			$session->message($message);
		}else{
			$message= notification('danger','<strong>Error</strong> Cannot Update.');
			$session->message($message);
		}
		header('Location: index.php?page=settings');
	
	
		$session->message($message);
		header('Location: index.php?page=settings#password');

	}


}


?>
<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3">Settings</h1>

		<div class="row">
			<div class="col-md-3 col-xl-2">

				<div class="card">
					<div class="card-header">
						<h5 class="card-title mb-0">Profile Settings</h5>
					</div>

					<div class="list-group list-group-flush" role="tablist">
						<a class="list-group-item list-group-item-action active" data-toggle="list" href="#account"
							role="tab">
							Account
						</a>
						<a class="list-group-item list-group-item-action" data-toggle="list" href="#password"
							role="tab">
							Password
						</a>
						
					</div>
				</div>
			</div>

			<div class="col-md-9 col-xl-10">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="account" role="tabpanel">

						<div class="card">
							<div class="card-header">

								<h5 class="card-title mb-0">Public info</h5>
								<div class="row">
								<?php echo $session->message; ?>
								</div>
							</div>
							<div class="card-body">
								<form method="POST">
									<div class="row">
										<div class="col-md-8">
											<div class="mb-3">
												<label class="form-label" for="inputUsername">Username</label>
												<input type="text" name="username" value="<?php echo $super->username ?>" class="form-control" id="inputUsername"
													placeholder="Username">
											</div>
											<div class="mb-3">
												<label class="form-label" for="inputUsername">Biography</label>
												<textarea disabled rows="2" class="form-control" id="inputBio"
													placeholder="Tell something about yourself"></textarea>
											</div>
										</div>
										<div class="col-md-4">
											<div class="text-center">
												<img alt="Charles Hall" src="img/avatars/avatar.jpg"
													class="rounded-circle img-responsive mt-2" width="128"
													height="128" />
												<div class="mt-2">
													<span class="btn btn-primary"><i class="fas fa-upload"></i>
														Upload</span>
												</div>
												<small>For best results, use an image at least 128px by 128px in .jpg
													format</small>
											</div>
										</div>
									</div>

									<button type="submit" name="super_update_public" class="btn btn-primary">Save changes</button>
								</form>

							</div>
						</div>

						<div class="card">
							<div class="card-header">

								<h5 class="card-title mb-0">Private info</h5>
							</div>
							<div class="card-body">
								<form method="POST">
									<div class="row">
										<div class="mb-3 col-md-6">
											<label class="form-label" for="inputFirstName">Full name</label>
											<input type="text" name="name" value="<?php echo $super->name ?>" class="form-control" id="inputFirstName"
												placeholder="Full name">
										</div>
										<div class="mb-3 col-md-6">
											<label class="form-label" for="inputLastName">Last name</label>
											<input disabled type="text" class="form-control" id="inputLastName"
												placeholder="Last name">
										</div>
									</div>
									<div class="mb-3">
										<label class="form-label" for="inputEmail4">Email</label>
										<input type="email" name="email" value="<?php echo $super->email ?>" class="form-control" id="inputEmail4" placeholder="Email">
									</div>
									<div class="mb-3">
										<label class="form-label" for="inputAddress">Address</label>
										<input disabled type="text" class="form-control" id="inputAddress"
											placeholder="Savannah Street">
									</div>
									
									<div class="row">
										<div class="mb-3 col-md-6">
											<label class="form-label" for="inputCity">City</label>
											<input disabled type="text" class="form-control" id="inputCity">
										</div>
										<div class="mb-3 col-md-4">
											<label class="form-label" for="inputState">State</label>
											<select disabled id="inputState" class="form-control">
												<option selected>Choose...</option>
												<option>...</option>
											</select>
										</div>
										<div class="mb-3 col-md-2">
											<label class="form-label" for="inputZip">Zip</label>
											<input disabled type="text" class="form-control" id="inputZip">
										</div>
									</div>
									<button type="submit" name="super_update_private" class="btn btn-primary">Save changes</button>
								</form>

							</div>
						</div>

					</div>
					<div class="tab-pane fade" id="password" role="tabpanel">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Password</h5>

								<form method="POST">
									<div class="mb-3">
										<label class="form-label" for="inputPasswordCurrent">Current password</label>
										<input type="password" name="current" class="form-control" id="inputPasswordCurrent">
										<small><a href="#">Forgot your password?</a></small>
									</div>
									<div class="mb-3">
										<label class="form-label" for="inputPasswordNew">New password</label>
										<input type="password" name="new" class="form-control" id="inputPasswordNew">
									</div>
									<div class="mb-3">
										<label class="form-label" for="inputPasswordNew2">Verify password</label>
										<input type="password" name="confirm" class="form-control" id="inputPasswordNew2">
									</div>
									<button type="submit" name="super_update_password" class="btn btn-primary">Save changes</button>
								</form>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>