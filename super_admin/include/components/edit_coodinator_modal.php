<div class="modal fade" id="edit_coordinator" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h5 class="modal-title text-secondary">Update TT Officer's Imformation </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body m-3">


				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div id='edit-error'></div>
						</div>
						<div class="card-body">
							<form name="edit" action="" method="">
								<!-- <form action="include/add_coo.php" method="POST"> -->
								<div class="row">
									<div class="mb-3 col-md-4">
										<label class="form-label" for="inputState">title</label>
										<select name="title" id="inputState" class="form-control">
											<option value="" selected>Choose...</option>
											<option value="Dr.">Doc.</option>
											<option value="Mal.">Mal.</option>
											<option value="Mr.">Mr.</option>
											<option>...</option>
										</select>
									</div>
									<div class="col-md-4">
										<div class="text-center">
											<img alt="Charles Hall" src="img/avatars/avatar1.jpg"
												class="rounded-circle img-responsive mt-2" width="128" height="128" />
											<div class="mt-2">
												<span class="btn btn-primary"><i class="fas fa-upload"></i>
													Upload</span>
											</div>
											<small>For best results, use an image at least 128px by 128px in .jpg
												format</small>
										</div>
									</div>
									<div class="mb-3">
										<label class="form-label" for="name">Full Name</label>
										<input name="name" type="text" class="form-control" id="name"
											placeholder="eg. Isah Ahmad">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="inputEmail4">Email</label>
										<input name="email" type="email" class="form-control" id="inputEmail4"
											placeholder="Email">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="phone">Phone Number</label>
										<input name="phone" type="number" class="form-control" id="phone"
											placeholder="eg. 0816xxxxxxx">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="username">Username</label>
										<input name="username" type="text" class="form-control" id="username"
											placeholder="Username">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="inputPassword4">Password</label>
										<input name="password" type="password" class="form-control" id="inputPassword4"
											placeholder="Password">
									</div>
								</div>


								<div class="row">
									<!-- <div class="mb-3 col-md-6">
												<label class="form-label" for="faculty">Faculty</label>
												<select name="faculty" id="faculty" class="form-control">
												<option value="" selected>Choose...</option>
												<?php
													$facs = Faculty::find_all();
													foreach ($facs as $fac):
												?>
													<option value="<?php echo $fac->name; ?>"><?php echo $fac->name; ?></option>
												<?php endforeach;?>
												</select>
											</div> -->


									<div class="mb-3 col-md-4">
										<label class="form-label" for="department">Department</label>
										<select name="department" id="department" class="form-control">
											<option value="" selected>Choose...</option>
											<?php $depts = Department::find_all(); 
													foreach ($depts as $dept):
													?>
											<option value="<?php echo $dept->name ?>"><?php echo $dept->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="mb-3 col-md-4">
										<label class="form-label" for="coordinate">Coordinates</label>
										<select name="coordinate" id="coordinate" class="form-control">
											<option value="" selected>Choose...</option>
											<option value="Faculty">Faculty</option>
											<option value="Department">Department</option>
										</select>
									</div>

								</div>

								<!-- <button type="submit" class="btn btn-primary">Submit</button> -->

						</div>
					</div>
				</div>



			</div>
			<div class="modal-footer">
				<input type="hidden" name="user_id">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<input id="update" type="button" name="update" value="Update" class="btn btn-primary">
			</div>
			</form>
		</div>
	</div>
</div>