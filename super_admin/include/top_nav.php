<?php 

if (!isset($session->user['super_admin']['user_id'])) {
	header('Location: ../');
}

$super = Super::find_by_id($session->user['super_admin']['user_id']);

$page_s = !isset($_GET['page']) ? '' : $_GET['page'];
$page_no_s = !isset($_GET['page_no']) ? 1 : $_GET['page_no'];
$page_no_s = is_numeric($page_no_s) ? $page_no_s : 1;

$search = !isset($_GET['search']) ? '' : $_GET['search'];
$sss = isset($_GET['search']) ? "&search={$_GET['search']}" : "";
$search_message = empty($search) ? "All" : "Search Result for <i>{$_GET['search']}</i> <a class='btn btn-secondary' href='?page={$page_s}'> reset</a>";


if(isset($_GET['page']) && isset($_GET['search'])){
	
$sql;

switch ($_GET['page']) {
	case 'co-ordinators':
		$sql = "SELECT * FROM `coordinator` WHERE `name` LIKE '%{$_GET['search']}%' OR `faculty` LIKE '%{$_GET['search']}%' OR `department` LIKE '%{$_GET['search']}%' OR `coordinate` LIKE '%{$_GET['search']}%' OR `title` LIKE '%{$_GET['search']}%' OR `username` LIKE '%{$_GET['search']}%' OR `phone` LIKE '%{$_GET['search']}%' OR `email`  LIKE '%{$_GET['search']}%' ORDER BY id DESC";
		break;
	case 'dept':
		$sql = "SELECT * FROM `department` WHERE `name` LIKE '%". $_GET['search'] ."%' or `faculty` LIKE '%". $_GET['search'] ."%'";
		// echo'dept';
		break;
	case 'profile':
		// echo'profile';
		break;
	case 'faculty':
		$sql = "SELECT * FROM `faculty` WHERE `name` LIKE '%{$_GET['search']}%' ORDER BY id DESC";
		// echo'faculty';

		break;
	case 'settings':
		// echo'settings';
		break;
	case 'venues':
		$sql = "SELECT *  FROM `venue` WHERE `name` LIKE '%".$_GET['search']."%' OR `department` LIKE '%".$_GET['search']."%' ORDER BY id DESC";
		break;
	case 'courses':
		$sql = "SELECT * FROM `course` WHERE `course_code` LIKE '%".$_GET['search']."%' OR `title` LIKE '%".$_GET['search']."%' OR `unit` = 'SCI' OR `semester` LIKE '%".$_GET['search']."%' OR `level` LIKE '".$_GET['search']."' OR `department` LIKE '%".$_GET['search']."%' ORDER BY id DESC";
		// echo'courses';
		break;
	
	default:
		# code...
		break;
}

}

// notification section SELECT DISTINCT d.id, d.name, d.faculty, d.max_level_range FROM department d, coordinator c WHERE d.name != c.department AND c.coordinate='department'

$coo = Coordinator::null_check('department');
$venues = Venue::null_check('department');
$depts2 = Department::null_check('faculty');
$facs = Faculty::notice();
$depts = Department::notice();

$depts_count = count($depts);
$venues_count = count($venues);
$facs_count = count($facs);
$coo_count = count($coo);

// print_r($depts2);

$total_notice =$depts_count + $facs_count +$coo_count +$venues_count;





?>

<nav style="background-color: #222e3c;" class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle d-flex">
		<i class="hamburger align-self-center"></i>
	</a>

	<form method="GET" class="d-none d-sm-inline-block">
		<div class="input-group input-group-navbar">
			<input type="hidden" value="<?php echo $page_no_s ?>" name="page_no" id="">
			<input type="hidden" value="<?php echo $page_s ?>" name="page" id="">
			<input type="search" value="<?php echo $search ?>" name="search" class="form-control" placeholder="Search…" aria-label="Search">
			<button class="btn" type="submit">
				<i class="align-middle" data-feather="search"></i>
			</button>
			
		</div>
	</form>

	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align ">
			<li class="nav-item dropdown">
				
				<a class="nav-icon dropdown-toggle text-light" href="#" id="alertsDropdown" data-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="bell"></i>
						<span class="indicator"><?php echo $total_notice; ?></span>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
					<div class="dropdown-menu-header">
					<?php echo $total_notice; ?> New Notifications
					</div>
					<div class="list-group">

					<?php foreach ($facs as $fac): ?>
						<a href="?page=faculty&search=<?php echo $fac->name ?>" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Faculty Warning! <em>(<?php echo $fac->name; ?>)</em></div>
									<div class="text-muted small mt-1"><b><?php echo $fac->name; ?> Faculty</b> Has no Coordinator yet.</div>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
					<?php foreach ($depts as $dept): ?>
						<a href="?page=dept&search=<?php echo $dept->name ?>" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Department Warning! <em>(<?php echo $dept->name; ?>)</em></div>
									<div class="text-muted small mt-1"><b><?php echo $dept->name; ?> Department </b> Has no Coordinator yet.</div>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
					<?php foreach ($depts2 as $dept): ?>
						<a href="?page=dept&search=<?php echo $dept->name ?>" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Department Warning! <em>(<?php echo $dept->name; ?>)</em></div>
									<div class="text-muted small mt-1"><b><?php echo $dept->name; ?> Department </b> Has no Faculty yet.</div>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
					<?php foreach ($coo as $co): ?>
						<a href="?page=co-ordinators&search=<?php echo $co->name ?>" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Coordinator Warning! <em>(<?php echo $co->name; ?>)</em></div>
									<div class="text-muted small mt-1"><b><?php echo $co->name; ?></b> Has no Department yet.</div>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
					<?php foreach ($venues as $venue): ?>
						<a href="?page=venues&search=<?php echo $venue->name ?>" class="list-group-item">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<i class="text-warning" data-feather="alert-circle"></i>
								</div>
								<div class="col-10">
									<div class="text-dark">Venue Warning! <em>(<?php echo $venue->name; ?>)</em></div>
									<div class="text-muted small mt-1"><b><?php echo $venue->name; ?></b> Has no Department yet.</div>
								</div>
							</div>
						</a>
					<?php endforeach; ?>

					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all notifications</a>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle text-light" href="#" id="messagesDropdown" data-toggle="dropdown">
					<div class="position-relative">
						<i class="align-middle" data-feather="message-square"></i>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="messagesDropdown">
					<div class="dropdown-menu-header">
						<div class="position-relative">
							0 New Messages
						</div>
					</div>
					<div class="list-group">
						<a href="#" class="list-group-item text-light">
							<div class="row g-0 align-items-center">
								<div class="col-2">
									<img src="img/avatars/avatar1.jpg" class="avatar img-fluid rounded-circle">
								</div>
								<div class="col-10 pl-2">
									<div class="text-dark">From (Isah Ahmed)</div>
									<div class="text-muted small mt-1">Working On it....
									</div>
									<div class="text-muted small mt-1">....</div>
								</div>
							</div>
						</a>
					</div>
					<div class="dropdown-menu-footer">
						<a href="#" class="text-muted">Show all messages</a>
					</div>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
					<i class="align-middle" data-feather="settings"></i>
				</a>

				<a class="nav-link dropdown-toggle d-none d-sm-inline-block  text-light" href="#" data-toggle="dropdown">
					<img style="border: 1px solid gray;" src="img/avatars/avatar.jpg" class="avatar img-fluid rounded mr-1" alt="Charles Hall" /> <span
						class="text-light"><?php echo $super->name ?> (Super Admin)</span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="?page=settings"><i class="align-middle mr-1"
							data-feather="settings"></i> Settings & Privacy</a>
					<a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="help-circle"></i> Help
						Center</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="include/logout.php">Log out</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
