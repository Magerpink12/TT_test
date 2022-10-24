
<div class="modal fade" id="add-facs" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-dark">
					<h5 class="modal-title text-secondary">Add Faculty</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						</div>
							<div class="modal-body m-3">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header">
											<div id='add-fac-error'></div>
										</div>
									<div class="card-body">
					<form name="add-fac" action="" method="">

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
							<input type="hidden" name="user_id">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<input id="add-fac" type="button" name="add-fac" value="Save" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
</div>