<div class="modal fade" id="edit-venue-model" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h5 class="modal-title text-secondary">Update Venue</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body m-3">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<div id='edit-venue-error'></div>
						</div>
						<div class="card-body">
							<form name="edit-venue" action="" method="">
								<div class="row">

									<div class="mb-3">
										<label class="form-label" for="name">Venue Name</label>
										<input name="name" type="text" class="form-control" id="name">
									</div>


									<div class="mb-3 col-md-6">
										<label class="form-label" for="capacity">Capacity</label>
										<input type="number" class="form-control" name="capacity" id="capacity">
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
								<input type="hidden" name="venue_id">
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<input id="edit-venue" type="button" name="edit-venue" value="Save" class="btn btn-primary">
			</div>

		</div>
	</div>
</div>