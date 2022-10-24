<main class="content">
	<div class="container-fluid p-0">

		<div class="row mb-2 mb-xl-3">
			<div class="col-auto d-none d-sm-block">
				<h3><strong>(<?php echo $user->department ?>) Department</strong> Admin Dashboard</h3>
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
						<h5 class="card-title mb-0"><?php echo $user->name ?></h5>
						<div class="text-muted mb-0">Department of <strong><?php echo $user->department ?></strong> Timetable Officer</div>
						<div class="text-muted mb-2">Faculty of <strong><?php echo $user->faculty ?></strong></div>

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
								<div style="border:.1px solid rgba(50,50,50,.1)" class="card text-danger">
									<div class="card-header">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-home fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Venue::find_by_query("SELECT * FROM venue WHERE department = '{$user->department}'")) ?></div>
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
												<div style="font-size: 16px;" class="bg-primary badge"><?php echo count(Course::find_by_query("SELECT * FROM course WHERE department ='{$user->department}'")) ?></div>
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

		<div class="row">
			<div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
				<div class="card flex-fill w-100">
					<div class="card-header">

						<h5 class="card-title mb-0">Session Events</h5>
					</div>
					<div class="card-body d-flex">
						<div class=" w-100">
							<!-- <div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div> -->

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
<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("datetimepicker-dashboard").flatpickr({
			inline: true,
			prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
			nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
		});
	});
</script>