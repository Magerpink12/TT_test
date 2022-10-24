<main class="content">
	<div class="container-fluid p-0">

		<div class="row mb-2 mb-xl-3">
			<div class="col-auto d-none d-sm-block">
				<h3><strong>Super Admin</strong> Dashboard</h3>
			</div>

			<div class="col-auto ml-auto text-right mt-n1">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
						<li class="breadcrumb-item"><a href="#">TTWizard</a></li>
						<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
					</ol>
				</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-xl-4">
				<div class="card mb-3">
					<div class="card-header">
						<h5 class="card-title mb-0">Profile Details</h5>
					</div>
					<div class="card-body text-center">
						<img src="img/avatars/avatar1.jpg" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" />
						<h5 class="card-title mb-0"><?php echo $super->name ?></h5>
						<div class="text-muted mb-2">Super Admin</div>

						<div>
							<a class="btn btn-primary btn-sm" href="?page=settings">Edit Profile</a>
							<a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span>
								Message</a>
						</div>
					</div>
					<hr class="my-0" />
					<div class="card-body">
						<h5 class="h6 card-title">Qualifications</h5>
						<!-- <a href="#" class="badge bg-primary mr-1 my-1">Diploma in Computer Studies</a> -->
						
					</div>

					<hr class="my-0" />
					<div class="card-body">
						
					</div>
				</div>
			</div>

			<div class="col-xl-8 col-xxl-7">
				<div class="card flex-fill w-100">
					<div class="card-header">

						<h5 class="card-title mb-0">Analytics</h5>
					</div>
					<div class="card-body py-3">


						<div class="row">
							<div class="col-lg-4 col-md-6">
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-primary">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-user fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Coordinator::find_all()) ?></div>
												<div>TT Officers</div>
											</div>
										</div>
									</div>
									<a href="?page=co-ordinators">
										<div class="card-footer">
											<span class="pull-left">View Details</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-success">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-graduation-cap fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Department::find_all()) ?></div>
												<div>Departments</div>
											</div>
										</div>
									</div>
									<a href="?page=dept">
										<div class="card-footer">
											<span class="pull-left">View Details</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-warning">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-building fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Faculty::find_all()) ?></div>
												<div>Faculties</div>
											</div>
										</div>
									</div>
									<a href="?page=faculty">
										<div class="card-footer">
											<span class="pull-left">View Details</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-danger">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-home fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Venue::find_all()) ?></div>
												<div>Venues</div>
											</div>
										</div>
									</div>
									<a href="?page=venues">
										<div class="card-footer">
											<span class="pull-left">View Details</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-md-6">
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-info">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
											<i class="fa fa-book fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Course::find_all()) ?></div>
												<div>Courses</div>
											</div>
										</div>
									</div>
									<a href="?page=courses">
										<div class="card-footer">
											<span class="pull-left">View Details</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
							
						</div>



					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
				<div class="card flex-fill w-100">
					<div class="card-header">

						<h5 class="card-title mb-0">Session Events</h5>
					</div>
					<div class="card-body d-flex">
						<div class=" w-100">
					
							<table class="table mb-0">
								<tbody>
									<tr>
										<td>2021</td>
										<td>First Semester Lectures</td>
										<td class="text-right">2020/1/4</td>
										<td class="text-right">2021/2/11</td>
									</tr>
									<tr>
										<td>2021</td>
										<td>First Semester Exams.</td>
										<td class="text-right">2021/2/11</td>
										<td class="text-right">2021/2/27</td>
									</tr>
									<tr>
										<td>2021</td>
										<td>First Semester's Break</td>
										<td class="text-right">2021/2/27</td>
										<td class="text-right">2021/3/1</td>
									</tr>
									<tr>
										<td>2021</td>
										<td>Second Semester Lectures</td>
										<td class="text-right">2021/3/1</td>
										<td class="text-right">2021/5/11</td>
									</tr>
									<tr>
										<td>2021</td>
										<td>Second Semester's Break</td>
										<td class="text-right">2021/5/11</td>
										<td class="text-right">Loading....</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<div class="card flex-fill">
						<div class="card-header">
							<?php $facs = Faculty::find_all(); ?>
							<h5 class="card-title mb-0">Updates</h5>
						</div>
						<table class="table table-hover my-0">
							<thead>
								<tr>
									<th>Faculty Name</th>
									<th class="d-none d-xl-table-cell">Start Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($facs as $fac) : ?>
									<tr>
										<td><?php echo $fac->name ?></td>
										<td class="d-none d-xl-table-cell">01/01/2020</td>
										<td><span class="badge bg-success">Done</span></td>
									</tr>
								<?php endforeach ?>
								<tr>
									<td>..........</td>
									<td class="d-none d-xl-table-cell">...........</td>
									<td><span class="badge bg-danger">Cancelled</span></td>
								</tr>

								<tr>
									<td>..........</td>
									<td class="d-none d-xl-table-cell">...........</td>
									<td><span class="badge bg-warning">In progress</span></td>
								</tr>


							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
				<div class="card flex-fill">
					<div class="card-header">

						<h5 class="card-title mb-0">Calendar</h5>
					</div>
					<div class="card-body d-flex">
						<div class="align-self-center w-100">
							<div class="chart">
								<div id="datetimepicker-dashboard"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



	</div>
</main>