
<div class="modal fade" id="edit_department" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-dark">
					<h5 class="modal-title text-secondary">Add Department</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
							<div class="modal-body m-3">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<div id='edit-dept-error'></div>
										</div>
									<div class="card-body">
					<form name="edit-dept" action="" method="">

										<div class="row">
											<div class="mb-3">
												<label class="form-label" for="name">Department Name</label>
												<input name="name" type="text" class="form-control" id="name" placeholder="Insert Department Name">
											</div>
										</div>
										<div class="row">
											<div class="mb-3 col-md-6">
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
											</div>
											<div class="mb-3 col-md-6">
												<label class="form-label" for="max_level_range">Max. Level</label>
												<select name="max_level_range" id="max_level_range" class="form-control">
													<option value="400" selected>400</option>
													<option value="500">500</option>
												</select>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="dept_id">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input id="edit-dept" type="button" name="edit-dept" value="Save" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
</div>