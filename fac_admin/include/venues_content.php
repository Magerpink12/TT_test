<?php
$items_per_page = 10;


$venues = new Venue();


$items_total_count = ($search=='') || !isset($_GET['search']) ? count($venues->find_by_query("SELECT * FROM venue WHERE department IN (SELECT name FROM department WHERE faculty='{$user->faculty}')")) : count($venues::find_by_query($sql));

$page = !empty($_GET['page_no']) ? $_GET['page_no'] : 1;
$page = is_numeric($page) ? $page : 1;
$page = $page > ceil($items_total_count/$items_per_page) ? 1 :$page;

$paginate = new Paginate($page, $items_per_page, $items_total_count);
$sql = ($search=='') || !isset($_GET['search']) ? "SELECT * FROM venue WHERE department IN (SELECT name FROM department WHERE faculty='{$user->faculty}') ORDER BY id DESC" : $sql;

// $sql = "SELECT * FROM venue ORDER BY id DESC";
$sql .= " LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";

$venues = $venues::find_by_query($sql);

	// $coordinators = Coordinator::find_all();

	
	// $faculties = Faculty::find_all();

	
	
?>

<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3">Venues &Rightarrow; <span class="h4 small"><?php echo $search_message ?></span></h1>

		<div class="row">

			<div class="col-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Registered Venues</h5>
						<?php echo $session->message; ?>

						<div class="mb-3">

							<div class="row">
								<div class="col-md-6">
									<!-- BEGIN primary modal -->
									<button type="button" class="btn btn-primary" data-toggle="modal"
										data-target="#add-venue-model">
										Add Venue
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
											stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round"
											class="feather feather-plus-square align-middle mr-2">
											<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
											<line x1="12" y1="8" x2="12" y2="16"></line>
											<line x1="8" y1="12" x2="16" y2="12"></line>
										</svg>

									</button>
								</div>
								<div class="col-md-4 text-right"></div>
								<div class="col-md-2 text-right">
									
								Total <?php echo $items_total_count."<br>" ?>
								Total/Page <?php echo $items_per_page ?>
									<!-- <form action="" method="get">
										<input  type="hidden" name="page" value="venues">
										<input class="form-control" type="number" name="page_no">
										<input class="btn btn-primary" type="submit" value="Go">
									</form> -->
								</div>
							</div>


							<?php
											include('components/add_venue_modal.php');
											include('components/edit_venue_modal.php');
										?>
						</div>
						<div style="height: 10px;" class="row"></div>
						<nav class="" aria-label="...">
							<ul class="pagination pagination-sm">
								<?php 
										if ($paginate->page_total() > 1) {
											if ($paginate->has_previous()) {
												
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=venues". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=venues". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=venues". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=venues". $sss ."'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=venues". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=venues". $sss ."'>Next</a></li>";
											}
										}
									?>

							</ul>
					</div>
					<table class="table table-striped table-sm table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th class="text-right">Department</th>
								<th class="text-right">Capacity</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php

							foreach ($venues as $venue): 

						?>
							<tr title="<?php echo $venue->name; ?>">
								<td><?php echo $venue->name; ?></td>
								<td class="text-right"><?php echo $venue->department; ?></td>
								<td class="text-right"><?php echo $venue->capacity; ?></td>
								<td class="table-action text-right">
									<a class="venue-edit-modal" data=<?php echo $venue->id; ?> href="#"><i
											class="align-middle text-primary" data-feather="edit-2" data-toggle="modal"
											data-target="#edit-venue-model"></i></a>
									<a data-toggle="modal" data="venue/<?php echo $venue->id; ?>" data-target="#delete"
										class="deleteee text-danger"><i class="align-middle "
											data-feather="trash"></i></a>
								</td>
							</tr>
							<?php endforeach; ?>

						</tbody>
					</table>
					
				</div>
				
						<nav class="" aria-label="...">
							<ul class="pagination pagination-sm">
								<?php 
										if ($paginate->page_total() > 1) {
											if ($paginate->has_previous()) {
												
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=venues". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=venues". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=venues". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=venues". $sss ."'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=venues". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=venues". $sss ."'>Next</a></li>";
											}
										}
									?>

							</ul>

			</div>

		</div>

	</div>
</main>