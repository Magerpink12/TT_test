<?php
$items_per_page = 10;

$coordinators = new Coordinator();

// $items_total_count = $coordinators->count_all();

$items_total_count = ($search=='') || !isset($_GET['search']) ? count($coordinators->find_by_query("SELECT * FROM coordinator ORDER BY id DESC")) : count($coordinators::find_by_query($sql));


$page = !empty($_GET['page_no']) ? $_GET['page_no'] : 1;
$page = is_numeric($page) ? $page : 1;
$page = $page > ceil($items_total_count/$items_per_page) ? 1 :$page;

$paginate = new Paginate($page, $items_per_page, $items_total_count);
$sql = ($search=='') || !isset($_GET['search']) ? "SELECT * FROM coordinator ORDER BY id DESC" : $sql;

// $sql = "SELECT * FROM coordinator ORDER BY id DESC";
$sql .= " LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";

$coordinators = $coordinators::find_by_query($sql);

?>

<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3">Time-Table Officers &Rightarrow; <span class="h4 small"><?php echo $search_message ?></span></h1>

		<div class="row">
			<div class="col-12 col-xl-12">
				<div class="card ">
					<div class="card-header">

						<?php
							include('components/add_coodinator_modal.php');
							include('components/edit_coodinator_modal.php');
						?>

						<h5 class="card-title">Registered TT Officers</h5>

						<?php echo $session->message; ?>


						<div class="mb-3">

							<div class="row">
								<div class="col-md-6">
									<!-- BEGIN primary modal -->
									<button type="button" class="btn btn-primary" data-toggle="modal"
										data-target="#add-coo">
										Add TT Officer
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

							<!-- Paginations -->
							<div style="height: 10px;" class="row"></div>
							<nav class="" aria-label="...">
								<ul class="pagination pagination-sm">
									<?php 
										if ($paginate->page_total() > 1) {
											if ($paginate->has_previous()) {
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=co-ordinators". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=co-ordinators". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=co-ordinators". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=co-ordinators". $sss ."'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=co-ordinators". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=co-ordinators". $sss ."'>Next</a></li>";
											}
										}
									?>

								</ul>
							</nav>





							<table style="font-size: 12px;" class=" mb-3 table table-striped table-hover">
								<thead>
									<tr>
										<th>Title</th>
										<th style="width:20%;">Name</th>
										<th style="width:10%;">Faculty</th>
										<th style="width:20%;">Department</th>
										<th style="width:20%;">Coordinates</th>
										<th style="width:20%;">Email</th>
										<th style="width:10%;">Phone</th>
										<th>Actions</th>
									</tr>
									<?php $i = 0; foreach($coordinators as $coordinator): ?>

								</thead>
								<tbody>
									<tr class="<?php $i++; if($i%2==0){echo "table-primary";}else{echo "";}  ?>">
										<td class="d-none d-md-table-cell"><?php echo $coordinator->title; ?></td>

										<td>
											<img src="img/avatars/avatar1.jpg" width="48" height="48"
												class="rounded-circle mr-2" alt="Avatar">
											<?php echo $coordinator->name; ?>
										</td>
										<td><?php echo $coordinator->faculty; ?></td>
										<td class="d-none d-md-table-cell"><?php echo $coordinator->department; ?></td>
										<td class="d-none d-md-table-cell"><?php echo $coordinator->coordinate; ?></td>
										<td class="d-none d-md-table-cell"><?php echo $coordinator->email; ?></td>
										<td class="d-none d-md-table-cell"><?php echo $coordinator->phone; ?></td>
										<td class="table-action">
											<a class="edit  text-primary" data-toggle="modal"
												data-target="#edit_coordinator" data=<?php echo $coordinator->id; ?>><i
													class="align-middle" data-feather="edit-2"></i></a>
											<a data-toggle="modal" data="coo/<?php echo $coordinator->id; ?>"
												data-target="#delete" class="deleteee text-danger"><i
													class="align-middle " data-feather="trash"></i></a>
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
												
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=co-ordinators". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=co-ordinators". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=co-ordinators". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=co-ordinators". $sss ."'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=co-ordinators". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=co-ordinators". $sss ."'>Next</a></li>";
											}
										}
									?>

							</ul>
						</nav>
					</div>


				</div>


			</div>

</main>