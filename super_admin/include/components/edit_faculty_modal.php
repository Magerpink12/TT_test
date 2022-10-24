
<div class="modal fade" id="edit_faculty" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-dark">
					<h5 class="modal-title text-secondary">Update Faculty</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
							<div class="modal-body m-3">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<div id='edit-fac-error'></div>
										</div>
									<div class="card-body">
					<form name="edit_fac" action="" method="">

										<div class="row">
											<div class="mb-3">
												<label class="form-label" for="name">Faculty Name</label>
												<input name="name" type="text" class="form-control" id="name" placeholder="Insert Faculty Name">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="fac_id">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input id="edit-fac" type="button" name="edit-fac" value="Save" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
</div>