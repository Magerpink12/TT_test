<div class="modal fade" id="add-course-model" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h5 class="modal-title text-secondary">Add Course</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body m-3">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div id='add-course-error'></div>
						</div>
						<div class="card-body">
							<form name="add-course" action="" method="">
								<div class="row">
									<div class="mb-3 col-md-6">
										<label class="form-label" for="code">Course Code</label>
										<input name="code" type="text" class="form-control" id="name"
											placeholder="eg. CSC####">
									</div>
									<div class="mb-3">
										<label class="form-label" for="title">Coures Title</label>
										<input name="title" type="text" class="form-control" id="title"">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="unit">Credit Unit</label>
										<input name="unit" type="number" class="form-control" id="unit">
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="level">Level</label>
										<select class="form-control" name="level" id="level">
											<option value="">..</option>
											<option value="100">100</option>
											<option value="200">200</option>
											<option value="300">300</option>
											<option value="400">400</option>
											<option value="500">500</option>
										</select>
									</div>
									<div class="mb-3 col-md-6">
										<label class="form-label" for="semester">Semester</label>
											<select class="form-control" name="semester" id="semester">
												<option value="">Choose..</option>
												<option value="First">First</option>
												<option value="Second">Second</option>
											</select>
									</div>
								
									<div class="mb-3 col-md-6">
										<label class="form-label" for="department">Department</label>
										<select name="department" id="department" class="form-control">
											<option value="" selected>Choose...</option>
											<?php $depts = Department::find_by_query("SELECT * FROM department WHERE faculty='{$user->faculty}'");
												foreach ($depts as $dept):
											?>
											<option value="<?php echo $dept->name ?>"><?php echo $dept->name ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="user_id">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<input id="add-course" type="button" name="add-course" value="Save" class="btn btn-primary">
			</div>
			
		</div>
	</div>
</div>

