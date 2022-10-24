<?php
$items_per_page = 10;



$faculties = new Faculty();

$items_total_count = ($search=='') || !isset($_GET['search']) ? count($faculties->find_by_query("SELECT * FROM faculty ORDER BY id DESC")) : count($faculties::find_by_query($sql));
// $items_total_count = $faculties->count_all();


$page = !empty($_GET['page_no']) ? $_GET['page_no'] : 1;
$page = is_numeric($page) ? $page : 1;
$page = $page > ceil($items_total_count/$items_per_page) ? 1 :$page;

$paginate = new Paginate($page, $items_per_page, $items_total_count);
$sql = ($search=='') || !isset($_GET['search']) ? "SELECT * FROM faculty ORDER BY id DESC" : $sql;

// $sql = "SELECT * FROM faculty ORDER BY id DESC";
$sql .= " LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";

$faculties = $faculties::find_by_query($sql);

	
?>

<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3">Faculties &Rightarrow; <span class="h4 small"><?php echo $search_message ?></span></h1>

		<div class="row">

			<div class="col-12 col-xl-12">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">Registered Faculties</h5>


						<?php echo $session->message; ?>

						<div class="mb-3">
							<div class="row">
								<div class="col-md-6">
									<!-- BEGIN primary modal -->
									<button type="button" class="btn btn-primary" data-toggle="modal"
										data-target="#add-facs">
										Add Faculty
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
										include('components/add_faculty_modal.php');
										include('components/edit_faculty_modal.php');

									?>
						</div>
						<div style="height: 10px;" class="row"></div>
						<nav class="" aria-label="...">
							<ul class="pagination pagination-sm">
								<?php 
										if ($paginate->page_total() > 1) {
											if ($paginate->has_previous()) {
												
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=faculty". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=faculty". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=faculty". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=faculty'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=faculty". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=faculty". $sss ."'>Next</a></li>";
											}
										}
									?>

							</ul>
						</nav>
					</div>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width:40%;">Name</th>
								<th style="width:25%">Coordinator</th>
								<th class="d-none d-md-table-cell" style="width:25%">Phone Number</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; foreach($faculties as $faculty): ?>

							<tr class="<?php $i++; if($i%2==0){echo "table-primary";}else{echo "";}  ?>">
								<td><?php echo $faculty->name ?></td>
								<td><?php echo Faculty::fac_relate($faculty->name)['name']; ?></td>
								<td class="d-none d-md-table-cell">
									<?php echo Faculty::fac_relate($faculty->name)['phone']; ?></td>
								<td class="table-action">
									<a class="fac-edit-modal text-primary" data-toggle="modal"
										data-target="#edit_faculty" data=<?php echo $faculty->id; ?>><i
											class="align-middle" data-feather="edit-2"></i></a>
									<!-- <a href="include/action/delete_faculty.php?id=<?php echo $faculty->id; ?>" ><i class="align-middle" data-feather="trash"></i></a> -->
									<a data-toggle="modal" data="fac/<?php echo $faculty->id; ?>" data-target="#delete"
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
												
												echo "<li class='page-item '><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=faculty". $sss ."'>Previous</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->previous()}&page=faculty". $sss ."'>Previous</a></li>";
											}	
											for ($i=1; $i <= $paginate->page_total(); $i++) { 
												if ($i == $paginate->current_page) {
													echo "<li class='page-item active' aria-current='page' ><a class='page-link' href='index.php?page_no={$i}&page=faculty". $sss ."'>{$i}</a></li>";
												}else{
													echo "<li class='page-item'><a class='page-link' href='index.php?page_no={$i}&page=faculty". $sss ."'>{$i}</a></li>";
												}
											}
											if ($paginate->has_next()) {
												echo "<li class='page-item'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=faculty". $sss ."'>Next</a></li>";
											}else{
												echo "<li class='page-item disabled'><a class='page-link' tabindex='-1' aria-disabled='true' href='index.php?page_no={$paginate->next()}&page=faculty". $sss ."'>Next</a></li>";
											}
										}
									?>

					</ul>
				</nav>

			</div>

		</div>

	</div>

</main>